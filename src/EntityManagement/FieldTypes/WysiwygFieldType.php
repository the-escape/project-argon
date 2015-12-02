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
            'help' => "Allows multiple instances of a field.",
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
            'help' => "Enable 'Format' option.",
            'toolbar' => 'Format',
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

    public function getValue(FieldData $data=null)
    {
        return @$data->value;
//        return new TextFieldValue($data); // commented out since multiple field property will end up here with array... and __toString obviously will not like that.
//        throw new \Exception('Not implemented');
    }
}
