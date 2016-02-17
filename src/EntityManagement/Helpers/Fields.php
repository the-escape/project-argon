<?php

namespace Escape\Argon\EntityManagement\Helpers;

use Escape\Argon\EntityManagement\Eloquent\FieldDataRepository;
use Escape\Argon\EntityManagement\Helpers\Validation as ValidationHelpers;
use Illuminate\Http\Request;
use Input;

class Fields
{
    const DIVIDER = ' &#10141; ';

    /**
     * Builds $niceNames and $rules arrays for validation based on supplied $fields collection
     * @param $fields Illuminate\Database\Eloquent\Collection
     * @param array $niceNames optional
     * @param array $rules optional
     * @return array [$niceNames, $rules] use list($niceNames, $rules) to easily capture returned values
     */
    public static function validationFieldsSetup(
        Request $request,
        $fields,
        array $niceNames = [],
        array $rules = [],
        $combos = null,
        $parent = null
    ) {
        if (!isset($combos)) {
            $combos = $request->input("combo");
        }

        $hash = null;

        foreach ($fields as $field) {
            $settings = $field->settings;

            if (@$settings->multiple) {
                $niceName = "fields.{$field->id}";
            } else  {
                $niceName = "fields.{$field->id}.0";
            }

            if ($field->parent_field_id && isset($combos[$field->parent_field_id])) {
                if (!isset($hash)) {
                    reset($combos[$field->parent_field_id]);
                    $hash = key($combos[$field->parent_field_id]);
                    unset($combos[$field->parent_field_id][$hash]);
                }

                if (@$settings->multiple) {
                    $niceName = "combo.{$field->parent_field_id}.{$hash}.fields.{$field->id}";
                } else {
                    $niceName = "combo.{$field->parent_field_id}.{$hash}.fields.{$field->id}.0";
                }


            }

            if ($field->field_type == 'combo') {

                if (@$settings->multiple) {
                    $i = 1;
                    foreach ($request->input("combo.{$field->id}", []) as $k => $v) {
                        $field->instance = $i;
                        list($niceNames, $rules, $combos) = self::validationFieldsSetup(
                            $request,
                            $field->subfields,
                            $niceNames,
                            $rules,
                            $combos,
                            $field
                        );
                        $i++;
                    }

                    // remove top level field, since unnecessary
                    if (@$rules[$niceName]) {
                        unset($rules[$niceName]);
                    }
                    continue;
                }

                $field->instance = 1;
                list($niceNames, $rules, $combos) = self::validationFieldsSetup(
                    $request,
                    $field->subfields,
                    $niceNames,
                    $rules,
                    $combos,
                    $field
                );
                continue;
            }

            // location field setup
            if ($field->field_type == 'location') {
                // longitude
                $longitude = $niceName.'.longitude';

                $niceNames[$longitude] = ($field->parent_field_id)
                    ? $parent->name.' '.$parent->instance.self::DIVIDER.$field->name.self::DIVIDER.'Longitude'
                    : $field->name.self::DIVIDER.'Longitude';

                $rules = self::rules($rules, $settings, $longitude);

                // latitude
                $latitude = $niceName.'.latitude';
                $niceNames[$latitude] = ($field->parent_field_id)
                    ? $parent->name.' '.$parent->instance.self::DIVIDER.$field->name.self::DIVIDER.'Latitude'
                    : $field->name.self::DIVIDER.'Latitude';
                $rules = self::rules($rules, $settings, $latitude);
                continue;
            }

            // generic single field setup
            $niceNames[$niceName] = ($field->parent_field_id && isset($combos[$field->parent_field_id]))
                ? $parent->name.' '.$parent->instance.self::DIVIDER.$field->name
                : $field->name;

            $rules = self::rules($rules, $settings, $niceName);

            // validate each multiple field value individually
            // copy fields validation rules to individual subfields,
            // then remove top level field nice name and validation since not needed
            if (@$settings->multiple) {
                foreach ($request->input($niceName,[]) as $k => $v) {
                    $niceNames["{$niceName}.{$k}"] = $niceNames[$niceName].self::DIVIDER.($k+1);

                    if (@$rules[$niceName]) {
                        $rules["{$niceName}.{$k}"] = $rules[$niceName];
                    }
                }

                if (@$rules[$niceName]) {
                    unset($niceNames[$niceName]);
                    unset($rules[$niceName]);
                }
            }
        }

        return [$niceNames, $rules, $combos];
    }


    private static function rules(array $rules, $settings, $niceName)
    {
        if (@$settings->required) {
            $rules[$niceName][] = 'required';
        }

        if (@$settings->minlength) {
            $rules[$niceName][] = "min:{$settings->minlength}";
        }

        if (@$settings->maxlength) {
            $rules[$niceName][] = "max:{$settings->maxlength}";
        }

        if (@$settings->url) {
            $rules[$niceName][] = "url";
        }

        if (@$settings->integer) {
            $rules[$niceName][] = "integer";
        }

        if (@$settings->float) {
            $rules[$niceName][] = 'regex:'.ValidationHelpers::REGEX_FLOAT;
        }

        if (@$settings->email) {
            $rules[$niceName][] = "email";
        }

        if (@$settings->phone) {
            $rules[$niceName][] = 'regex:'.ValidationHelpers::REGEX_PHONE;
        }

        if (@$rules[$niceName]) {
            $rules[$niceName] = implode('|', $rules[$niceName]);
        }

        return $rules;
    }


    public static function saveFields(
        Request $request,
        $fields,
        $revision,
        FieldDataRepository $fieldDataRepository,
        $combos = null
    ) {
        if (!isset($combos)) {
            $combos = $request->input("combo");
        }
        $hash = null;

        foreach ($fields as $field) {
            /*
             * Handle combos.
             * Break them into individual fields.
             * */
            if ($field->field_type == 'combo') {
                self::saveCombo($field, $revision, $request);
                continue;
            }

            /*
             * Handle individual fields below.
             */

            // default nicename
            $niceName = "fields.{$field->id}";

            // adjust nicename for subfield
            if ($field->parent_field_id) {
                if (!isset($hash)) {
                    reset($combos[$field->parent_field_id]);
                    $hash = key($combos[$field->parent_field_id]);
                    unset($combos[$field->parent_field_id][$hash]);
                }

                $niceName = "combo.{$field->parent_field_id}.{$hash}.fields.{$field->id}";
            }

            $settings = $field->settings;

            $FieldData = $fieldDataRepository->create([
                'field_id' => $field->id,
                'entity_revision_id' => $revision->id,
                'language' => 'en_GB',
                'value' => $request->input($niceName),
            ]);

            // when combo subfield, save $FieldData->id reference as combo value to enable combo rebuild
            // from (multiple) saved values
            if ($field->parent_field_id) {
                $fieldDataRepository->create([
                    'field_id' => $field->parent_field_id,
                    'entity_revision_id' => $revision->id,
                    'language' => 'en_GB',
                    'value' => json_encode([$hash => $FieldData->id]),
                ]);
            }
        }

        return [$combos];
    }

    public static function saveCombo($field, $revision, $request)
    {
        /** @var FieldDataRepository $repo */
        $repo = app()->make(FieldDataRepository::class);
        $fieldData = $repo->create([
            'field_id' => $field->id,
            'entity_revision_id' => $revision->id,
            'value' => $request->input("combo.{$field->id}")
        ]);
    }
}
