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
                $doc->id = "e={$entity->id}&l={$revision->entity_localisation_id}";
                $doc->name = $entity->name;
                $doc->slug = $entity->slug;
                $doc->type_id = $entity->entity_type_id;
                $doc->parent_id = $entity->parent_id;
                $doc->created_at = $entity->created_at->format('Y-m-d\TH:i:s\Z');

                $fields = $revision->fields;

				foreach ($fields as $field) {
                    $type = $field->field->type;
                    $slug = $type->getFieldSlug();

                    // recursively run through $value since it contains subfields and build dynamic multivalued _txt field for solr
                    if ($type instanceof \Escape\Argon\EntityManagement\FieldTypes\ComboFieldType) {

                        $slug = $slug."_txt";
                        $value = $type->parseData($field);

                        foreach ($value as $hash => $v) {
                            foreach ($type->getSubFields() as $subField) {

                                if ($subField instanceof \Escape\Argon\EntityManagement\FieldTypes\ImageFieldType) {
                                    continue;

                                } elseif ($subField instanceof \Escape\Argon\EntityManagement\FieldTypes\FileFieldType) {
                                    continue;

                                } elseif ($subField instanceof \Escape\Argon\EntityManagement\FieldTypes\VideoFieldType) {
                                    continue;

                                } elseif ($subField instanceof \Escape\Argon\EntityManagement\FieldTypes\BooleanFieldType) {
                                    continue;

                                } else {
                                    $vals = $value->getValueForSubField($hash, $subField->getId());
                                    foreach ($vals as $val) {
                                        $val = (string)$val;
                                        $doc->addField($slug, $val);
                                    }
                                }
                            }
                        }

                    } elseif ($type instanceof \Escape\Argon\EntityManagement\FieldTypes\ImageFieldType) {
                        continue;

                    } elseif ($type instanceof \Escape\Argon\EntityManagement\FieldTypes\FileFieldType) {
                        continue;

                    } elseif ($type instanceof \Escape\Argon\EntityManagement\FieldTypes\VideoFieldType) {
                        continue;

                    } elseif ($type instanceof \Escape\Argon\EntityManagement\FieldTypes\BooleanFieldType) {
                        continue;

                    } else {
                        $slug = $slug."_txt";
                        $values = $type->parseData($field);

                        foreach ($values as $v) {
                            $val = (string) $v;
                            $doc->addField($slug, $val);
                        }
                    }

				}

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
