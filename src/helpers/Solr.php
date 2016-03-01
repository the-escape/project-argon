<?php namespace Escape\Argon\Helpers;

use Escape\Argon\EntityManagement\Eloquent\Entity;
use Escape\Argon\EntityManagement\Eloquent\EntityRevision;
use Solarium;

class Solr
{
	protected $client;
	protected $enabled;

	public function __construct()
    {
		$this->enabled = config('solr.enable');

        if ($this->enabled) {
            $solr = array('endpoint' => config('solr.endpoint'));
            $this->solr = new Solarium\Client($solr);
        }
    }

	public static function addUser($id) {

		$solr = new Solr();

		$config = Config::get('cms::solr.settings');

		if(isset($config['enable_solr_user']) && $config['enable_solr_user']) {

			$user = \Cms\Models\User::bindProfileData(\Cms\Models\User::find($id));

			$roles = $user->roles->lists('name', 'id');

			if(!array_key_exists($config['role_to_index'], $roles)) {

				return;

			}

			$fields = $config['user_fields'];

			$client = $solr->client;

			$update = $client->createUpdate();

			$doc = $update->createDocument();

			$doc->id = $user->id;
			$doc->username = $user->username;
			$doc->email = $user->email;

			foreach($fields as $key => $value) {

				if(isset($user->uservar->{$key}) && !empty($user->uservar->{$key}->value) && $user->uservar->{$key}->value != "null") {

					if(is_numeric($user->uservar->{$key}->value)) {

						$doc->{$value} = (int) $user->uservar->{$key}->value;

					} else if(is_array($user->uservar->{$key}->value)) {

						$doc->{$value} = $user->uservar->{$key}->value;

					} else {

						$doc->{$value} = strip_tags($user->uservar->{$key}->value);

					}

				}

			}

			$update->addDocuments(array($doc));

			$update->addCommit();

			$result = $client->update($update);

		}

	}

	static public function removeUser($id)
	{

		$solr = new Solr();

		// Get the node just saved
    	$user = \Cms\Models\User::find($id);

		$config = Config::get('cms::solr.settings');

        // If solr is enabled
        if(isset($config['enable_solr_user']) && $config['enable_solr_user']) {

            $client = $solr->client;

            $update = $client->createUpdate();

            // Create solr document
            $update->addDeleteQuery("id:".$id);

            $update->addCommit();

			$result = $client->update($update);

        }

	}

	public function addEntity(Entity $entity, EntityRevision $revision)
	{
        if ($this->enabled) {
            $entities_to_index = config('solr.entity.types');

            if (!$entities_to_index || in_array($entity->entity_type_id, $entities_to_index)) {

                $fields = config('solr.entity.fields');

                $update = $this->solr->createUpdate();

                // Create solr document
                $doc = $update->createDocument();

                // Add default entity fields
                $doc->id = $entity->id;
                $doc->name = $entity->name;
                $doc->slug = $entity->slug;
                $doc->type_id = $entity->entity_type_id;
                $doc->parent_id = $entity->parent_id;
                $doc->created_at = $entity->created_at->format('Y-m-d\TH:i:s\Z');

                $fields = $revision->fields;

				foreach ($fields as $field) {
                    $type = $field->field->type;
                    $slug = $type->getFieldSlug();

                    if ($type instanceof \Escape\Argon\EntityManagement\FieldTypes\ComboFieldType) {

//                        $value = $type->parseData($field);
//                        // TODO: recursively run through $value since it contains subfields and data to build multivalued _txt field for solr
//
//                        $doc->{$slug."_txt"} = $value;

                    } else {
                        $value = (string) $type->parseData($field);
                        $doc->{$slug."_t"} = $value;
                    }

				}






//                $entity->getLocalisation($something)->publishedRevision()->field('title');
//                $revision->field('foo')

                // Loop through data fields to map
//            foreach($fields as $field_name => $solr_name) {
//
//                if(isset($node->node_data->{$field_name}) && !empty($node->node_data->{$field_name})) {
//
//                    if(is_numeric($node->node_data->{$field_name})) {
//
//                        $doc->{$solr_name} = (int) $node->node_data->{$field_name};
//
//                    } else if(is_array($node->node_data->{$field_name})) {
//
//                        $doc->{$solr_name} = $node->node_data->{$field_name};
//
//                    } else {
//
//                        $doc->{$solr_name} = strip_tags($node->node_data->{$field_name});
//
//                    }
//
//                }
//
//            }

//            if(!empty($parent) && !empty($parent_fields)) {
//
//                foreach($parent_fields as $field_name => $solr_name) {
//
//                    if(isset($parent->node_data->{$field_name}) && !empty($parent->node_data->{$field_name})) {
//
//                        if(is_numeric($parent->node_data->{$field_name})) {
//
//                            $doc->{$solr_name} = (int) $parent->node_data->{$field_name};
//
//                        } else if(is_array($parent->node_data->{$field_name})) {
//
//                            $doc->{$solr_name} = $parent->node_data->{$field_name};
//
//                        } else {
//
//                            $doc->{$solr_name} = strip_tags($parent->node_data->{$field_name});
//
//                        }
//
//                    }
//
//                }
//
//            }

                // add the documents and a commit command to the update query
                $update->addDocuments([$doc]);
                $update->addCommit();

                // this executes the query and returns the result
                return $this->solr->update($update);

            }
        }
	}

	static public function removeNode($node_id)
	{

		$solr = new Solr();

		// Get the node just saved
    	$node = Node::getById($node_id);

    	// Get type of node
    	$type = $node->node_type_id;

        // If solr is enabled
        if($solr->enabled) {

            // Get the node types configured to be indexed
            $nodes_to_index = Config::get('cms::solr.settings.nodes_to_index');

            // Check if the node we're saving is a type we want to index or we want to index all nodes
            if(in_array($type, $nodes_to_index) || $nodes_to_index[0] == "all") {

            	$fields = Config::get('cms::solr.settings.fields');

                $client = $solr->client;

                $update = $client->createUpdate();

                // Create solr document
                $update->addDeleteQuery("id:".$node_id);

	            $update->addCommit();

				$result = $client->update($update);

            }

        }

	}

}
