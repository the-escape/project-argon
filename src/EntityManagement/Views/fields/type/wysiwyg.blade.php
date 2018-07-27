<?php

    $isInCombo = $field->getParentId() !== 0;

    // get wysiwyg toolbar options
    $toolbar = $format_tags = [];

    foreach ($field->getProperties() as $name => $property)
    {
        if (property_exists($field->getSettings(), $name) && property_exists($property, 'toolbar'))
        {
            if ($field->getSetting($name))
            {
                $toolbar[] = $property->toolbar;
            }

            if (($name == 'format') && $property->children)
            {
                foreach($property->children as $child_name => $child_propery)
                {
                    if ($field->getSetting($child_name))
                    {
                        $format_tags[] = $child_name;
                    }
                }
            }
        }
    }

    $wysiwyg_config_toolbar = implode(',', $toolbar);

    $wysiwyg_config_format_tags = implode(';', $format_tags);

    $wysiwyg_config_height = $field->getSetting('height');

    $wysiwyg_config_extraAllowedContent = $field->getSetting('iframe');



?>

<div class="o-form-status">
    <div class="o-form-status__input">
        <label for="fields-{{ $field->getId() }}-0">{{ $field->getFieldName() }}</label>

        @foreach($value as $k => $v)

            <?php
                $fieldNameSuffix = 'wysiwyg-'. str_replace('.', '', microtime(1));
            ?>

            <textarea
                    name="{{ $field->getFormFieldName($hash) }}[{{ $fieldNameSuffix }}]"
                    class="js-wysiwyg @if($field->isRequired()) required @endif"
                    data-wysiwyg_height="{{$wysiwyg_config_height}}"
                    data-wysiwyg_toolbar="{{$wysiwyg_config_toolbar}}"
                    data-wysiwyg_format_tags="{{$wysiwyg_config_format_tags}}"
                    data-wysiwyg_extraAllowedContent="{{$wysiwyg_config_extraAllowedContent}}"
                    data-wysiwyg_typography_styles="{{config('argon.typography_styles','/css/typography.css')}}"
            >{{ $v }}</textarea>

        @endforeach

    </div>
    <div class="o-form-status__message">
        <div class="o-form-status__icon">
            <div class="o-form-status__icon--error">
                <svg><use xlink:href="/argon/images/svgicons.svg#alert"></use></svg>
            </div>
            <div class="o-form-status__icon--success">
                <svg><use xlink:href="/argon/images/svgicons.svg#success"></use></svg>
            </div>
        </div>
        <div class="o-form-status__message-bar">
            <label for="content">Error Message</label>
        </div>
    </div>
</div>
@if(false)
    <div class="o-form__help-text l-full">
        <p>Help Lorem ipsum dolor, sit amet consectetur adipisicing elit.</p>
    </div>
@endif


<?php /*


 @if(!$isCloning)
    <div class="field field-text field-{{ $field->getId() }} @if($field->isRequired()) required @endif"
         data-field="{{$field->getId()}}"
         data-hash="{{$hash}}">

        <label for="fields-{{ $field->getId() }}-0">{{ $field->getFieldName() }}</label>
        <div class="field-values">
@endif

    @foreach($value as $k => $v)

        @if($field->allowMultiple())
            <div class="input-group sortable-item">
                <div class="input-group-addon sortable-handle">&#8645;</div>
        @endif

                <?php
                /*
                 * This suffix is necessary to allow rendering multiple WYSIWYGs that should have the same name.
                 * Since array like name used, WYSIWYG had issues as it generates id for each editor instance based on a textarea field name.
                 * To fix it
                 *
                 * */ /*
$fieldNameSuffix = 'wysiwyg-'. str_replace('.', '', microtime(1));
?>

<textarea
        name="{{ $field->getFormFieldName($hash) }}[{{ $fieldNameSuffix }}]"
        class="js-wysiwyg @if($field->isRequired()) required @endif"
        data-wysiwyg_height="{{$wysiwyg_config_height}}"
        data-wysiwyg_toolbar="{{$wysiwyg_config_toolbar}}"
        data-wysiwyg_format_tags="{{$wysiwyg_config_format_tags}}"
        data-wysiwyg_extraAllowedContent="{{$wysiwyg_config_extraAllowedContent}}"
        data-wysiwyg_typography_styles="{{config('argon.typography_styles','/css/typography.css')}}"
>{{ $v }}</textarea>

@if($field->allowMultiple())
    <div class="input-group-addon field-remove">&#10005;</div>
    </div>
    @endif

    @endforeach

    @if(!$isCloning)
    </div>
    @if($field->allowMultiple())
        <a href="#addField" class="btn btn-secondary-outline btn-sm field-clone" data-field="{{$field->getId()}}" data-hash="{{$hash}}">Add Field</a>
        @endif
        </div>
    @endif



    */ ?>
