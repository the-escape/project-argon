<?php namespace Escape\Argon\EntityManagement\Helpers;

use Escape\Argon\EntityManagement\Eloquent\FieldDataRepository;
use Escape\Argon\EntityManagement\Helpers\Validation as ValidationHelpers;
use Input;


class Fields
{

    /**
     * Builds $niceNames and $rules arrays for validation based on supplied $fields collection
     * @param $fields Illuminate\Database\Eloquent\Collection
     * @param array $niceNames optional
     * @param array $rules optional
     * @return array [$niceNames, $rules] use list($niceNames, $rules) to easily capture returned values
     */
    public static function validationFieldsSetup($fields, array $niceNames=[], array $rules=[], $combos=null, $parent=null)
    {
        if (!isset($combos))
        {
            $combos = Input::get("combo");
        }

        $hash = null;

        foreach ($fields as $field)
        {
            $niceName = "fields.{$field->id}";

            if ($field->parent_field_id)
            {
                if (!isset($hash))
                {
                    reset($combos[$field->parent_field_id]);
                    $hash = key($combos[$field->parent_field_id]);
                    unset($combos[$field->parent_field_id][$hash]);
                }

                $niceName = "combo.{$field->parent_field_id}.{$hash}.fields.{$field->id}";
            }

            if ($field->field_type == 'combo')
            {
                $settings = $field->settings;

                if (@$settings->multiple)
                {
                    $i = 1;
                    foreach (Input::get("combo.{$field->id}") as $k => $v)
                    {
                        $field->instance = $i;
                        list($niceNames, $rules, $combos) = self::validationFieldsSetup($field->subfields, $niceNames, $rules, $combos, $field);
                        $i++;
                    }

                    // remove top level field, since unnecessary
                    if (@$rules[$niceName])
                    {
                        unset($rules[$niceName]);
                    }
                    continue;
                }

                $field->instance = 1;
                list($niceNames, $rules, $combos) = self::validationFieldsSetup($field->subfields, $niceNames, $rules, $combos, $field);
                continue;
            }

            $niceNames[$niceName] = ($field->parent_field_id)
                ? $parent->name.' '.$parent->instance.' &#10141; '.$field->name
                : $field->name;

            $settings = $field->settings;

            if (@$settings->required)
            {
                $rules[$niceName][] = 'required';
            }

            if (@$settings->minlength)
            {
                $rules[$niceName][] = "min:{$settings->minlength}";
            }

            if (@$settings->maxlength)
            {
                $rules[$niceName][] = "max:{$settings->maxlength}";
            }

            if (@$settings->url)
            {
                $rules[$niceName][] = "url";
            }

            if (@$settings->integer)
            {
                $rules[$niceName][] = "integer";
            }

            if (@$settings->float)
            {
                $rules[$niceName][] = 'regex:'.ValidationHelpers::REGEX_FLOAT;
            }

            if (@$settings->email)
            {
                $rules[$niceName][] = "email";
            }

            if (@$settings->phone)
            {
                $rules[$niceName][] = 'regex:'.ValidationHelpers::REGEX_PHONE;
            }

            if (@$rules[$niceName])
            {
                $rules[$niceName] = implode('|', $rules[$niceName]);
            }

            // validate each multiple field value individually
            // copy fields validation rules to individual subfields, then remove top level field validation since not needed
            if (@$settings->multiple)
            {
                foreach (Input::get($niceName) as $k => $v)
                {
                    $niceNames["{$niceName}.{$k}"] = $field->name.' ['.($k+1).']';

                    if (@$rules[$niceName])
                    {
                        $rules["{$niceName}.{$k}"] = $rules[$niceName];
                    }
                }

                if (@$rules[$niceName])
                {
                    unset($rules[$niceName]);
                }
            }
        }

        return [$niceNames, $rules, $combos];
    }


    public static function saveFields($fields, $revision, FieldDataRepository $fieldDataRepository, $combos=null)
    {
        if (!isset($combos))
        {
            $combos = Input::get("combo");
        }
        $hash = null;

        foreach ($fields as $field)
        {
            /*
             * Handle combos.
             * Break them into individual fields.
             * */
            if ($field->field_type == 'combo')
            {
                $settings = $field->settings;

                if (@$settings->multiple)
                {
                    foreach (Input::get("combo.{$field->id}") as $k => $v)
                    {
                        list($combos) = self::saveFields($field->subfields, $revision, $fieldDataRepository, $combos);
                    }
                    continue;
                }

                list($combos) = self::saveFields($field->subfields, $revision, $fieldDataRepository, $combos);
                continue;
            }

            /*
             * Handle individual fields below.
             * */

            // default nicename
            $niceName = "fields.{$field->id}";

            // adjust nicename for subfield
            if ($field->parent_field_id)
            {
                if (!isset($hash))
                {
                    reset($combos[$field->parent_field_id]);
                    $hash = key($combos[$field->parent_field_id]);
                    unset($combos[$field->parent_field_id][$hash]);
                }

                $niceName = "combo.{$field->parent_field_id}.{$hash}.fields.{$field->id}";
            }

            $settings = $field->settings;

            if ($settings->multiple)
            {
                foreach (Input::get("{$niceName}") as $k => $v)
                {
                    $FieldData = $fieldDataRepository->create([
                        'field_id' => $field->id,
                        'entity_revision_id' => $revision->id,
                        'language' => 'en_GB',
                        'value' => Input::get("{$niceName}.{$k}"),
                    ]);
                    // when combo subfield, save $FieldData->id reference as combo value to enable combo rebuild from (multiple) saved values
                    if ($field->parent_field_id)
                    {
                        $fieldDataRepository->create([
                            'field_id' => $field->parent_field_id,
                            'entity_revision_id' => $revision->id,
                            'language' => 'en_GB',
                            'value' => json_encode([$hash => $FieldData->id]),
                        ]);
                    }
                }
            }
            else
            {
                $FieldData = $fieldDataRepository->create([
                    'field_id' => $field->id,
                    'entity_revision_id' => $revision->id,
                    'language' => 'en_GB',
                    'value' => Input::get("{$niceName}")
                ]);

                // when combo subfield, save $FieldData->id reference as combo value to enable combo rebuild from (multiple) saved values
                if ($field->parent_field_id)
                {
                    $fieldDataRepository->create([
                        'field_id' => $field->parent_field_id,
                        'entity_revision_id' => $revision->id,
                        'language' => 'en_GB',
                        'value' => json_encode([$hash => $FieldData->id]),
                    ]);
                }
            }
        }

        return [$combos];
    }

}