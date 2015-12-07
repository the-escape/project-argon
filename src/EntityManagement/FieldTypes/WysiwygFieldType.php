<?php

namespace Escape\Argon\EntityManagement\FieldTypes;

use Escape\Argon\EntityManagement\Eloquent\FieldData;

class WysiwygFieldType extends AbstractFieldType
{
    protected $name = 'Wysiwyg';

    protected $key = 'wysiwyg';

    protected $properties = [
        'required' => [
            'label' => 'Required?',
            'type' => 'boolean',
            'default' => false,
            'help' => null,
        ],
        'multiple' => [
            'label' => 'Multiple',
            'type' => 'boolean',
            'default' => false,
            'help' => "Allow multiple instances of a field (cloning).",
        ],
        'minlength' => [
            'label' => 'Minimum Length',
            'type' => 'integer',
            'default' => null,
            'help' => null,
        ],
        'maxlength' => [
            'label' => 'Maximum Length',
            'type' => 'integer',
            'default' => null,
            'help' => null,
        ],

        'height' => [
            'label' => 'Wysiwyg height',
            'type' => 'integer',
            'default' => 150,
            'help' => null,
        ],
        'source' => [
            'label' => 'Source',
            'type' => 'boolean',
            'default' => true,
            'help' => "Enable 'Source' option.",
            'toolbar' => 'Source',
        ],
        'format' => [
            'label' => 'Format',
            'type' => 'boolean',
            'default' => true,
            'help' => "Enable 'Format' option to activate other html tags below. Note, '&lt;p&gt;' tag is enabled by default, even without Format option.",
            'toolbar' => 'Format',
            'children' => [
// Wysiwyg enabless 'p' tag regardless of settings, It will not show it in a Format dropdown when not enebled, but will allow within editor... Just don't show the option at all.
//                'p' => [
//                    'label' => "Enable '&lt;p&gt;' tag within format dropdown.",
//                    'type' => 'boolean',
//                    'default' => true,
//                    'help' => "Depends on 'Format' option - must be enabled.",
//                    'format_tags' => 'p',
//                ],
                'h1' => [
                    'label' => "Enable '&lt;h1&gt;' tag within format dropdown.",
                    'type' => 'boolean',
                    'default' => true,
                    'help' => "Depends on 'Format' option - must be enabled.",
                    'format_tags' => 'h1',
                ],
                'h2' => [
                    'label' => "Enable '&lt;h2&gt;' tag within format dropdown.",
                    'type' => 'boolean',
                    'default' => true,
                    'help' => "Depends on 'Format' option - must be enabled.",
                    'format_tags' => 'h2',
                ],
                'h3' => [
                    'label' => "Enable '&lt;h3&gt;' tag within format dropdown.",
                    'type' => 'boolean',
                    'default' => true,
                    'help' => "Depends on 'Format' option - must be enabled.",
                    'format_tags' => 'h3',
                ],
                'h4' => [
                    'label' => "Enable '&lt;h4&gt;' tag within format dropdown.",
                    'type' => 'boolean',
                    'default' => true,
                    'help' => "Depends on 'Format' option - must be enabled.",
                    'format_tags' => 'h4',
                ],
                'h5' => [
                    'label' => "Enable '&lt;h5&gt;' tag within format dropdown.",
                    'type' => 'boolean',
                    'default' => false,
                    'help' => "Depends on 'Format' option - must be enabled.",
                    'format_tags' => 'h5',
                ],
                'h6' => [
                    'label' => "Enable '&lt;h6&gt;' tag within format dropdown.",
                    'type' => 'boolean',
                    'default' => false,
                    'help' => "Depends on 'Format' option - must be enabled.",
                    'format_tags' => 'h6',
                ],
            ],
        ],
        'fontsize' => [
            'label' => 'Font Size',
            'type' => 'boolean',
            'default' => false,
            'help' => "Enable 'Font Size' option.",
            'toolbar' => 'FontSize',
        ],
        'bold' => [
            'label' => 'Bold',
            'type' => 'boolean',
            'default' => true,
            'help' => "Enable 'Bold' option.",
            'toolbar' => 'Bold',
        ],
        'italic' => [
            'label' => 'Italic',
            'type' => 'boolean',
            'default' => false,
            'help' => "Enable 'Italic' option.",
            'toolbar' => 'Italic',
        ],
        'blockquote' => [
            'label' => 'Blockquote',
            'type' => 'boolean',
            'default' => false,
            'help' => "Enable 'Blockquote' option.",
            'toolbar' => 'Blockquote',
        ],
        'numberedlist' => [
            'label' => 'Numbered List',
            'type' => 'boolean',
            'default' => false,
            'help' => "Enable 'Numbered List' option.",
            'toolbar' => 'NumberedList',
        ],
        'bulletedlist' => [
            'label' => 'Bulleted List',
            'type' => 'boolean',
            'default' => false,
            'help' => "Enable 'Bulleted List' option.",
            'toolbar' => 'BulletedList',
        ],
        'image' => [
            'label' => 'Image',
            'type' => 'boolean',
            'default' => false,
            'help' => "Enable 'Image' option.",
            'toolbar' => 'Image',
        ],
        'table' => [
            'label' => 'Table',
            'type' => 'boolean',
            'default' => false,
            'help' => "Enable 'Table' option.",
            'toolbar' => 'Table',
        ],
        'link' => [
            'label' => 'Link',
            'type' => 'boolean',
            'default' => true,
            'help' => "Enable 'Link' option.",
            'toolbar' => 'Link',
        ],
        'unlink' => [
            'label' => 'Unlink',
            'type' => 'boolean',
            'default' => true,
            'help' => "Enable 'Unlink' option.",
            'toolbar' => 'Unlink',
        ],
    ];

    // TODO: finish options

    public function getValue(FieldData $data=null)
    {
        return @$data->value;
//        return new TextFieldValue($data); // commented out since multiple field property will end up here with array... and __toString obviously will not like that.
//        throw new \Exception('Not implemented');
    }
}
