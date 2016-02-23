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
     * Builds $niceNames and $rules and $messages arrays for validation based on supplied $fields collection
     * @param $fields Illuminate\Database\Eloquent\Collection
     * @param array $niceNames optional
     * @param array $rules optional
     * @param array $messages optional
     * @return array [$niceNames, $rules, $messages] use list($niceNames, $rules, $messages) to easily capture returned values
     */
    public static function validationFieldsSetup(
        Request $request,
        $fields,
        array $niceNames = [],
        array $rules = [],
        $messages = [],
        $combos = null,
        $parent = null
    ) {
        if (!isset($combos)) {
            $combos = $request->input("combo");
        }

        $hash = null;

        foreach ($fields as $field) {
            $settings = $field->settings;

            if (@$settings->multiple || ($field->field_type == 'location' && !$field->parent_field_id) || ($field->field_type == 'image' && !$field->parent_field_id)) {
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

                if (@$settings->multiple || ($field->field_type == 'location') || ($field->field_type == 'image')) {
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
                        list($niceNames, $rules, $messages, $combos) = self::validationFieldsSetup(
                            $request,
                            $field->subfields,
                            $niceNames,
                            $rules,
                            $messages,
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
                list($niceNames, $rules, $messages, $combos) = self::validationFieldsSetup(
                    $request,
                    $field->subfields,
                    $niceNames,
                    $rules,
                    $messages,
                    $combos,
                    $field
                );
                continue;
            }

            // location field setup
            if ($field->field_type == 'location') {
                list($rules, $niceNames, $messages) = self::location($request, $field, $parent, $settings, $rules, $niceNames, $messages, $niceName);
                continue;
            }

            // image field setup
            if ($field->field_type == 'image') {
                list($rules, $niceNames, $messages) = self::image($request, $field, $parent, $settings, $rules, $niceNames, $messages, $niceName);
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

        return [$niceNames, $rules, $messages, $combos];
    }


    private static function image(Request $request, $field, $parent, $settings, $rules, $niceNames, $messages, $niceName)
    {
        $i = 0;
        foreach ($request->input($niceName,[]) as $k => $v) {

            $i++;


            // id
            $id = "{$niceName}.{$k}.id";

            $str = ($field->parent_field_id)
                ? $parent->name.' '.$parent->instance.self::DIVIDER.$field->name.self::DIVIDER.($i).self::DIVIDER
                : $field->name.self::DIVIDER.($i).self::DIVIDER;


            $messages["{$id}.required"] = "The {$str}Image is required.";

            $niceNames[$id] = $str.'Image';

            $settings_id = clone $settings;
            unset($settings_id->width, $settings_id->height);
            $rules = self::rules($rules, $settings_id, $id);


            // width
            $width = "{$niceName}.{$k}.width";

            $messages["{$width}.in"] = "The :attribute should be {$settings->width} pixels.";

            $niceNames[$width] = ($field->parent_field_id)
                ? $parent->name.' '.$parent->instance.self::DIVIDER.$field->name.self::DIVIDER.($i).self::DIVIDER.'Width'
                : $field->name.self::DIVIDER.($i).self::DIVIDER.'Width';

            $settings_width = clone $settings;
            unset($settings_width->height, $settings_width->required);
            $rules = self::rules($rules, $settings_width, $width);

            // height
            $height = "{$niceName}.{$k}.height";

            $messages["{$height}.in"] = "The :attribute should be {$settings->height}  pixels.";

            $niceNames[$height] = ($field->parent_field_id)
                ? $parent->name.' '.$parent->instance.self::DIVIDER.$field->name.self::DIVIDER.($i).self::DIVIDER.'Height'
                : $field->name.self::DIVIDER.($i).self::DIVIDER.'Height';

            $settings_height = clone $settings;
            unset($settings_height->width, $settings_height->required);
            $rules = self::rules($rules, $settings_height, $height);
        }

        return [$rules, $niceNames, $messages];
    }


    private static function location(Request $request, $field, $parent, $settings, $rules, $niceNames, $messages, $niceName)
    {
        $i = 0;
        foreach ($request->input($niceName,[]) as $k => $v) {

            $i++;

            // longitude
            $longitude = "{$niceName}.{$k}.longitude";

            $niceNames[$longitude] = ($field->parent_field_id)
                ? $parent->name.' '.$parent->instance.self::DIVIDER.$field->name.self::DIVIDER.($i).self::DIVIDER.'Longitude'
                : $field->name.self::DIVIDER.($i).self::DIVIDER.'Longitude';

            $rules = self::rules($rules, $settings, $longitude);

            // latitude
            $latitude = "{$niceName}.{$k}.latitude";

            $niceNames[$latitude] = ($field->parent_field_id)
                ? $parent->name.' '.$parent->instance.self::DIVIDER.$field->name.self::DIVIDER.($i).self::DIVIDER.'Latitude'
                : $field->name.self::DIVIDER.($i).self::DIVIDER.'Latitude';

            $rules = self::rules($rules, $settings, $latitude);
        }

        return [$rules, $niceNames, $messages];
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

        if (@$settings->width) {
            $rules[$niceName][] = "in:{$settings->width}";
        }

        if (@$settings->height) {
            $rules[$niceName][] = "in:{$settings->height}";
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

            if ($field->field_type == 'combo') {
                self::saveCombo($field, $revision, $request);
                continue;
            }

            // default nicename
            $niceName = "fields.{$field->id}";

//            // adjust nicename for subfield
//            if ($field->parent_field_id) {
//                if (!isset($hash)) {
//                    reset($combos[$field->parent_field_id]);
//                    $hash = key($combos[$field->parent_field_id]);
//                    unset($combos[$field->parent_field_id][$hash]);
//                }
//
//                $niceName = "combo.{$field->parent_field_id}.{$hash}.fields.{$field->id}";
//            }

            $FieldData = $fieldDataRepository->create([
                'field_id' => $field->id,
                'entity_revision_id' => $revision->id,
                'language' => 'en_GB',
                'value' => $request->input($niceName),
            ]);

//            // when combo subfield, save $FieldData->id reference as combo value to enable combo rebuild
//            // from (multiple) saved values
//            if ($field->parent_field_id) {
//                $fieldDataRepository->create([
//                    'field_id' => $field->parent_field_id,
//                    'entity_revision_id' => $revision->id,
//                    'language' => 'en_GB',
//                    'value' => json_encode([$hash => $FieldData->id]),
//                ]);
//            }
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
