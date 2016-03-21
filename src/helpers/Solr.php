<?php namespace Escape\Argon\Helpers;

use Escape\Argon\EntityManagement\Eloquent\Entity;
use Escape\Argon\EntityManagement\Eloquent\EntityRepository;
use Escape\Argon\EntityManagement\Eloquent\Localisation;
use Solarium;

class Solr
{
    public $client;
    protected $enabled;

    public function __construct()
    {
        $this->enabled = (bool) config('solr.enable');

        if ($this->isEnabled()) {
            $client = array('endpoint' => config('solr.endpoint'));
            $this->client = new Solarium\Client($client);
        }
    }

    public function isEnabled()
    {
        return $this->enabled;
    }


//	public static function addUser($id) {
//
//		$solr = new Solr();
//
//		$config = Config::get('cms::solr.settings');
//
//		if(isset($config['enable_solr_user']) && $config['enable_solr_user']) {
//
//			$user = \Cms\Models\User::bindProfileData(\Cms\Models\User::find($id));
//
//			$roles = $user->roles->lists('name', 'id');
//
//			if(!array_key_exists($config['role_to_index'], $roles)) {
//
//				return;
//
//			}
//
//			$fields = $config['user_fields'];
//
//			$client = $solr->client;
//
//			$update = $client->createUpdate();
//
//			$doc = $update->createDocument();
//
//			$doc->id = $user->id;
//			$doc->username = $user->username;
//			$doc->email = $user->email;
//
//			foreach($fields as $key => $value) {
//
//				if(isset($user->uservar->{$key}) && !empty($user->uservar->{$key}->value) && $user->uservar->{$key}->value != "null") {
//
//					if(is_numeric($user->uservar->{$key}->value)) {
//
//						$doc->{$value} = (int) $user->uservar->{$key}->value;
//
//					} else if(is_array($user->uservar->{$key}->value)) {
//
//						$doc->{$value} = $user->uservar->{$key}->value;
//
//					} else {
//
//						$doc->{$value} = strip_tags($user->uservar->{$key}->value);
//
//					}
//
//				}
//
//			}
//
//			$update->addDocuments(array($doc));
//
//			$update->addCommit();
//
//			$result = $client->update($update);
//
//		}
//
//	}
//
//	static public function removeUser($id)
//	{
//
//		$solr = new Solr();
//
//		// Get the node just saved
//    	$user = \Cms\Models\User::find($id);
//
//		$config = Config::get('cms::solr.settings');
//
//        // If solr is enabled
//        if(isset($config['enable_solr_user']) && $config['enable_solr_user']) {
//
//            $client = $solr->client;
//
//            $update = $client->createUpdate();
//
//            // Create solr document
//            $update->addDeleteQuery("id:".$id);
//
//            $update->addCommit();
//
//			$result = $client->update($update);
//
//        }
//
//	}

    public function indexEntity(Entity $entity, Localisation $localisation)
    {
        if ($this->isEnabled()) {

            $entities_to_index = config('solr.entity.types');

            if (!$entities_to_index || in_array($entity->entity_type_id, $entities_to_index)) {

                $latestRevision = $localisation->latestRevision();

                $update = $this->client->createUpdate();

                $doc = $update->createDocument();

                $doc->id = "e={$entity->id}&l={$latestRevision->entity_localisation_id}";
                $doc->entity_id = $entity->id;
                $doc->entity_localisation_id = $latestRevision->entity_localisation_id;
                $doc->entity_locale_id = $localisation->locale_id;
                $doc->entity_name = $entity->name;
                $doc->entity_slug = $entity->slug;
                $doc->entity_type_id = $entity->entity_type_id;
                $doc->entity_parent_id = $entity->parent_id;
                $doc->entity_created_at = $entity->created_at->format('Y-m-d H:i:s');
                $doc->entity_created_at_dts = $entity->created_at->format('Y-m-d\TH:i:s\Z');

                $fields = $latestRevision->fields;

                foreach ($fields as $field) {

                    $type = $field->field->type;
                    $slug = $type->getFieldSlug();
                    $values = $type->parseData($field);

                    // run through $value since it contains subfields and build dynamic multivalued _txt field for solr
                    if ($type instanceof \Escape\Argon\EntityManagement\FieldTypes\ComboFieldType) {

                        foreach ($values as $hash => $val) {

                            foreach ($type->getSubFields() as $subField) {

                                if ($subField instanceof \Escape\Argon\EntityManagement\FieldTypes\ImageFieldType) {
                                    continue;

                                } elseif ($subField instanceof \Escape\Argon\EntityManagement\FieldTypes\FileFieldType) {
                                    continue;

                                } elseif ($subField instanceof \Escape\Argon\EntityManagement\FieldTypes\VideoFieldType) {
                                    continue;

                                } elseif ($subField instanceof \Escape\Argon\EntityManagement\FieldTypes\BooleanFieldType) {
                                    continue;

                                } elseif ($subField instanceof \Escape\Argon\EntityManagement\FieldTypes\ItemFieldType) {
                                    $vals = $values->getValueForSubField($hash, $subField->getId());
                                    $values = $vals->getIds();

                                    if (is_array($values)) {
                                        foreach ($values as $value) {
                                            $doc->addField($slug."_txt", $value);
                                        }
                                    }

                                } else {
                                    $vals = $values->getValueForSubField($hash, $subField->getId());

                                    foreach ($vals as $val) {
                                        if (is_object($val) && !method_exists($val, '__toString')) {
                                            continue;
                                        }

                                        $v = (string) $val;

                                        if ($v != '') {
                                            $doc->addField($slug."_txt", $v);

                                            if ($subField instanceof \Escape\Argon\EntityManagement\FieldTypes\DatetimeFieldType) {
                                                $doc->addField($slug."_dts", $val->format('Y-m-d\TH:i:s\Z'));
                                            }
                                        }
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

                    } elseif ($type instanceof \Escape\Argon\EntityManagement\FieldTypes\ItemFieldType) {

                        $values = $values->getIds();

                        if (is_array($values)) {
                            foreach ($values as $value) {
                                $doc->addField($slug."_txt", $value);
                            }
                        }

                    } else {

                        foreach ($values as $val) {
                            if (is_object($val) && !method_exists($val, '__toString')) {
                                continue;
                            }

                            $v = (string) $val;

                            if ($v != '') {
                                $doc->addField($slug."_txt", $v);

                                if ($type instanceof \Escape\Argon\EntityManagement\FieldTypes\DatetimeFieldType) {
                                    $doc->addField($slug."_dts", $val->format('Y-m-d\TH:i:s\Z'));
                                }
                            }
                        }

                    }

                }

                $update->addDocuments([$doc]);
                $update->addCommit();

                $response = $this->client->update($update);

                return [
                    'action'      => 'indexing',
                    'entity_id'   => $entity->id,
                    'solr_status' => $response->getResponse()->getStatusMessage(),
                ];
            }
        }
    }



    public function unindexEntity($entity)
    {
        if ($this->isEnabled()) {

            $update = $this->client->createUpdate();
            $update->addDeleteQuery("entity_id:".$entity->id);
            $update->addCommit();

            $response = $this->client->update($update);

            return [
                'action'      => 'unindexing',
                'entity_id'   => $entity->id,
                'solr_status' => $response->getResponse()->getStatusMessage(),
            ];
        }
    }



    public function reindex()
    {
        if ($this->isEnabled()) {

            $entityRepository = app()->make(EntityRepository::class);
            $entities = $entityRepository->all();
            $entities_to_index = config('solr.entity.types');
            $results = [];

            foreach ($entities as $entity) {

                if (!$entities_to_index || in_array($entity->entity_type_id, $entities_to_index)) {

                    $localisations = $entity->localisations;
                    foreach ($localisations as $localisation) {
                        $latestRevision = $localisation->latestRevision();
                        $response = $this->indexEntity($entity, $localisation);

                        $results[] = [
                            'action'      => 'reindexing',
                            'entity_id'   => $entity->id,
                            'revision_id' => $latestRevision->id,
                            'solr_status' => $response['solr_status'],
                        ];
                    }

                }

            }

            return $results;

        }
    }


}
