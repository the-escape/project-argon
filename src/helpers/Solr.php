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
                $doc->entity_status = $entity->status;
                $doc->entity_created_at = $entity->created_at->format('Y-m-d H:i:s');
                $doc->entity_created_at_dts = $entity->created_at->format('Y-m-d\TH:i:s\Z');

                $fields = $latestRevision->fields;

                foreach ($fields as $field) {

                    if (!$field->field) {
                        // skip deleted field
                        continue;
                    }

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

                                } elseif ($subField instanceof \Escape\Argon\EntityManagement\FieldTypes\DatetimeFieldType) {
                                    $vals = $values->getValueForSubField($hash, $subField->getId());
                                    foreach ($vals as $val) {
                                        $v = (string) $val;

                                        if ($v != '') {
                                            $doc->addField($slug . "_dts", $val->format('Y-m-d\TH:i:s\Z'));
                                        } else {
                                            $doc->addField($slug . "_dts", $entity->created_at->format('Y-m-d\TH:i:s\Z'));
                                            $v = $entity->created_at->format('Y-m-d H:i:s');
                                        }

                                        $doc->addField($slug . "_txt", $v);
                                    }

                                } elseif ($subField instanceof \Escape\Argon\EntityManagement\FieldTypes\ItemFieldType) {
                                    $vals = $values->getValueForSubField($hash, $subField->getId());
                                    $vals = $vals->getIds();

                                    if (is_array($vals)) {
                                        foreach ($vals as $value) {
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

                    } elseif ($type instanceof \Escape\Argon\EntityManagement\FieldTypes\DatetimeFieldType) {
                        foreach ($values as $val) {
                            $v = (string) $val;

                            if ($v != '') {
                                $doc->addField($slug . "_dts", $val->format('Y-m-d\TH:i:s\Z'));
                            } else {
                                $doc->addField($slug . "_dts", $entity->created_at->format('Y-m-d\TH:i:s\Z'));
                                $v = $entity->created_at->format('Y-m-d H:i:s');
                            }

                            $doc->addField($slug . "_txt", $v);
                        }

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
