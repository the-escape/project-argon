<?php

namespace Escape\Argon\Helpers;

use Escape\Argon\EntityManagement\Eloquent\Entity;
use Escape\Argon\EntityManagement\Eloquent\EntityRepository;
use Escape\Argon\EntityManagement\Eloquent\Localisation;
use Solarium;
use Solarium\Core\Client\Adapter\Curl;
use Solarium\QueryType\Select\Result\Grouping\FieldGroup;
use Solarium\QueryType\Select\Result\Grouping\ValueGroup;
use Solarium\QueryType\Select\Result\Result;
use Symfony\Component\EventDispatcher\EventDispatcher;

class Solr
{
    public $client;

    protected $enabled;

    public function __construct()
    {
        $this->enabled = (bool) config('solr.enable');

        if ($this->isEnabled()) {
            $adapter = new Curl();
            $dispatcher = new EventDispatcher();
            $options = ['endpoint' => config('solr.endpoint')];
            $this->client = new Solarium\Client($adapter, $dispatcher, $options);
        }
    }

    public function isEnabled()
    {
        return $this->enabled;
    }

    public function indexEntity(Entity $entity, Localisation $localisation = null)
    {
        if ($this->isEnabled()) {
            if ($localisation === null) {
                $localisation = $entity->getDefaultLocalisation();
            }

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

                if ($entity->type->type == 'page') {
                    $p = $entity->toPage();
                    $p->adjustLocale($localisation);
                    $doc->entity_url = $p->getUrl();
                }

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
                        $itr = 0;

                        foreach ($values as $hash => $val) {
                            foreach ($type->getSubFields() as $subField) {
                                if ($subField instanceof \Escape\Argon\EntityManagement\FieldTypes\ImageFieldType) {
                                    continue;
                                }

                                if ($subField instanceof \Escape\Argon\EntityManagement\FieldTypes\FileFieldType) {
                                    continue;
                                }

                                if ($subField instanceof \Escape\Argon\EntityManagement\FieldTypes\VideoFieldType) {
                                    continue;
                                }

                                if ($subField instanceof \Escape\Argon\EntityManagement\FieldTypes\BooleanFieldType) {
                                    // TODO: REVIEW HERE
                                    $vals = $values->getValueForSubField($hash, $subField->getId());
                                    $doc->addField($slug . "_txt", (int) $vals->isTrue());
                                    $doc->addField("{$slug}:{$itr}:{$subField->getFieldSlug()}_is", (int) $vals->isTrue());
                                } elseif ($subField instanceof \Escape\Argon\EntityManagement\FieldTypes\DatetimeFieldType) {
                                    $vals = $values->getValueForSubField($hash, $subField->getId());

                                    foreach ($vals as $val) {
                                        $v = (string) $val;

                                        if ($v != '') {
                                            $doc->addField($slug . "_dts", $val->format('Y-m-d\TH:i:s\Z'));
                                            $doc->addField("{$slug}:{$itr}:{$subField->getFieldSlug()}_dts", $val->format('Y-m-d\TH:i:s\Z'));
                                        } else {
                                            $doc->addField($slug . "_dts", null);
                                            $doc->addField("{$slug}:{$itr}:{$subField->getFieldSlug()}_dts", null);
                                        }

                                        $doc->addField($slug . "_txt", $v);
                                        $doc->addField("{$slug}:{$itr}:{$subField->getFieldSlug()}_txt", $v);
                                    }
                                } elseif ($subField instanceof \Escape\Argon\EntityManagement\FieldTypes\ItemFieldType) {
                                    $vals = $values->getValueForSubField($hash, $subField->getId());
                                    $vals = $vals->getIds();

                                    if (is_array($vals)) {
                                        foreach ($vals as $value) {
                                            $doc->addField("{$slug}_txt", $value);
                                            $doc->addField("{$slug}:{$itr}:{$subField->getFieldSlug()}_txt", $value);
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
                                            $doc->addField("{$slug}_txt", $v);
                                            $doc->addField("{$slug}:{$itr}:{$subField->getFieldSlug()}_txt", $v);
                                        }
                                    }
                                }
                            }

                            $itr++;
                        }
                    } elseif ($type instanceof \Escape\Argon\EntityManagement\FieldTypes\ImageFieldType) {
                        continue;
                    } elseif ($type instanceof \Escape\Argon\EntityManagement\FieldTypes\FileFieldType) {
                        continue;
                    } elseif ($type instanceof \Escape\Argon\EntityManagement\FieldTypes\VideoFieldType) {
                        continue;
                    } elseif ($type instanceof \Escape\Argon\EntityManagement\FieldTypes\BooleanFieldType) {
                        $doc->addField($slug . "_is", (int) $values->isTrue());
                    } elseif ($type instanceof \Escape\Argon\EntityManagement\FieldTypes\DatetimeFieldType) {
                        foreach ($values as $val) {
                            $v = (string) $val;

                            if ($v != '') {
                                $doc->addField($slug . "_dts", $val->format('Y-m-d\TH:i:s\Z'));
                            } else {
                                $doc->addField($slug . "_dts", null);
                            }

                            $doc->addField($slug . "_txt", $v);
                        }
                    } elseif ($type instanceof \Escape\Argon\EntityManagement\FieldTypes\ItemFieldType) {
                        $values = $values->getIds();

                        if (is_array($values)) {
                            foreach ($values as $value) {
                                $doc->addField($slug . "_txt", $value);
                            }
                        }
                    } else {
                        foreach ($values as $val) {
                            if (is_object($val) && !method_exists($val, '__toString')) {
                                continue;
                            }

                            $v = (string) $val;

                            if ($v != '') {
                                $doc->addField($slug . "_txt", $v);
                            }
                        }
                    }
                }

                $update->addDocuments([$doc]);
                $update->addCommit();

                $response = $this->client->update($update);

                return [
                    'action' => 'indexing',
                    'entity_id' => $entity->id,
                    'solr_status' => $response->getResponse()->getStatusMessage(),
                ];
            }
        }
    }

    public function unindexEntity($entityId)
    {
        if ($this->isEnabled()) {
            $update = $this->client->createUpdate();
            $update->addDeleteQuery("entity_id:" . $entityId);
            $update->addCommit();

            $response = $this->client->update($update);

            return [
                'action' => 'unindexing',
                'entity_id' => $entityId,
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

            foreach ($entities as $entity) {
                if (!$entities_to_index || in_array($entity->entity_type_id, $entities_to_index)) {
                    foreach ($entity->localisations as $localisation) {
                        $latestRevision = $localisation->latestRevision();
                        $response = $this->indexEntity($entity, $localisation);

                        yield [
                            'action' => 'reindexing',
                            'entity_id' => $entity->id,
                            'revision_id' => $latestRevision->id,
                            'solr_status' => $response['solr_status'],
                        ];
                    }
                }
            }
        }
    }

    public function unindex($field = 'id', $value = '*')
    {
        if ($this->isEnabled()) {
            $update = $this->client->createUpdate();
            $update->addDeleteQuery('%1%:%2%', [$field, $value]);
            $update->addCommit();

            $response = $this->client->update($update);

            return [
                'action' => 'unindexing',
                'solr_status' => $response->getResponse()->getStatusMessage(),
            ];
        }
    }

    public static function buildQueryStringFromParams($field, $params, $glue = "OR", $placeholder = "P")
    {
        if (!is_array($params)) {
            $params = [$params];
        }

        $query = [];

        for ($i = 1; $i <= count($params); $i++) {
            $query[] = "{$field}:%{$placeholder}{$i}%";
        }

        $glue = trim($glue);

        $query = implode(" {$glue} ", $query);

        return $query;
    }

    public static function getDocumentsFromGroupedResultset($resultset, $groupValue = null)
    {
        $documents = [];

        if (!($resultset instanceof FieldGroup)) {
            return $documents;
        }

        $valueGroups = $resultset->getValueGroups();

        if ($valueGroups) {
            if ($groupValue !== null) {
                foreach ($valueGroups as $valueGroup) {
                    if ($valueGroup->getValue() == $groupValue) {
                        $docs = $valueGroup->getDocuments();

                        if ($docs) {
                            foreach ($docs as $doc) {
                                $documents[] = $doc;
                            }
                        }

                        break;
                    }
                }
            } else {
                foreach ($valueGroups as $valueGroup) {
                    $docs = $valueGroup->getDocuments();

                    if ($docs) {
                        foreach ($docs as $doc) {
                            $documents[] = $doc;
                        }
                    }
                }
            }
        }

        return $documents;
    }

    public static function getDocumentFieldValuesFromGroupedResultset($resultset, $groupValue, $field)
    {
        $values = [];

        if (!($resultset instanceof FieldGroup)) {
            return $values;
        }

        $documents = self::getDocumentsFromGroupedResultset($resultset, $groupValue);

        if ($documents) {
            foreach ($documents as $document) {
                $values[] = $document->{$field};
            }
        }

        return $values;
    }

    public static function getDocumentFieldValues($resultset, $groupValue, $field)
    {
        $values = [];
        $documents = [];

        if ($resultset instanceof FieldGroup) {
            $documents = self::getDocumentsFromGroupedResultset($resultset, $groupValue);
        } elseif ($resultset instanceof Result) {
            $documents = $resultset->getDocuments();
        } elseif ($resultset instanceof ValueGroup) {
            $docs = $resultset->getDocuments();

            if ($docs) {
                foreach ($docs as $doc) {
                    $documents[] = $doc;
                }
            }
        }

        if ($documents) {
            foreach ($documents as $document) {
                $values[] = $document->{$field};
            }
        }

        return $values;
    }

    public static function getValueGroupById($resultset, $id)
    {
        $valueGroups = $resultset->getValueGroups();

        if ($valueGroups) {
            foreach ($valueGroups as $valueGroup) {
                if ($valueGroup->getValue() == $id) {
                    return $valueGroup;
                }
            }
        }

        return null;
    }

    /**
     * Escape like phrase, prepring value for solr wildcard query, like: entity_url:\/url-path.
     *
     * @param $input
     *
     * @return mixed
     */
    public static function escape($input)
    {
        return preg_replace('/("|\\\|\/)/', '\\\$1', $input);
    }
}
