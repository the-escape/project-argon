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
    public static function validationFieldsSetup($fields, array $niceNames=[], array $rules=[])
    {
        foreach ($fields as $field)
        {
            if ($field->field_type == 'combo')
            {
                list($niceNames, $rules) = self::validationFieldsSetup($field->subfields, $niceNames, $rules);
                continue;
            }

            $niceNames["fields.{$field->id}"] = $field->name;

            $settings = $field->settings;

            if (@$settings->required)
            {
                $rules["fields.{$field->id}"][] = 'required';
            }

            if (@$settings->minlength)
            {
                $rules["fields.{$field->id}"][] = "min:{$settings->minlength}";
            }

            if (@$settings->maxlength)
            {
                $rules["fields.{$field->id}"][] = "max:{$settings->maxlength}";
            }

            if (@$settings->url)
            {
                $rules["fields.{$field->id}"][] = "url";
            }

            if (@$settings->integer)
            {
                $rules["fields.{$field->id}"][] = "integer";
            }

            if (@$settings->float)
            {
                $rules["fields.{$field->id}"][] = 'regex:'.ValidationHelpers::REGEX_FLOAT;
            }

            if (@$settings->email)
            {
                $rules["fields.{$field->id}"][] = "email";
            }

            if (@$settings->phone)
            {
                // flex regex to match following types of international and british phone numbers:
                // (0) 125 1 2 3633 x4567
                // 1256 334567 x123
                // +44 (0) 125 1 2 3633 x4567
                // +44 1256 334567 x123
                // +44 (0) 1256 334567
                // +441256334567
                // +44(0)1256334567 x123
                // +441256334567
                // +44 1256 334567 x1
                $rules["fields.{$field->id}"][] = 'regex:'.ValidationHelpers::REGEX_PHONE;
            }

            if (@$rules["fields.{$field->id}"])
            {
                $rules["fields.{$field->id}"] = implode('|', $rules["fields.{$field->id}"]);
            }

            // validate each multiple field value individually
            // copy fields validation rules to individual subfields, then remove top level field validation since not needed
            if (@$settings->multiple)
            {
                foreach (Input::get("fields.{$field->id}") as $k => $v)
                {
                    $niceNames["fields.{$field->id}.{$k}"] = $field->name.' ['.($k+1).']';

                    if (@$rules["fields.{$field->id}"])
                    {
                        $rules["fields.{$field->id}.{$k}"] = $rules["fields.{$field->id}"];
                    }
                }

                if (@$rules["fields.{$field->id}"])
                {
                    unset($rules["fields.{$field->id}"]);
                }
            }
        }

        return [$niceNames, $rules];
    }


    public static function saveFields($fields, $revision, FieldDataRepository $fieldDataRepository)
    {
        foreach ($fields as $field)
        {
            if ($field->field_type == 'combo')
            {
                self::saveFields($field->subfields, $revision, $fieldDataRepository);
                continue;
            }

            $settings = $field->settings;

            if ($settings->multiple)
            {
                foreach (Input::get("fields.{$field->id}") as $k => $v)
                {
                    $fieldDataRepository->create([
                        'field_id' => $field->id,
                        'entity_revision_id' => $revision->id,
                        'language' => 'en_GB',
                        'value' => Input::get("fields.{$field->id}.{$k}")
                    ]);
                }
            }
            else
            {
                $fieldDataRepository->create([
                    'field_id' => $field->id,
                    'entity_revision_id' => $revision->id,
                    'language' => 'en_GB',
                    'value' => Input::get("fields.{$field->id}")
                ]);
            }
        }
    }

}