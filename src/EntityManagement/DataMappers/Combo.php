<?php

namespace Escape\Argon\EntityManagement\DataMappers;

use Escape\Argon\EntityManagement\FieldValues\ComboFieldValue;

/**
 * Class Combo is a blueprint that your custom class ie 'MyCombo' should extend like so:
 *
 * class MyCombo extends Combo
 * {
 *     protected $property1;
 *     protected $property2;
 * }
 *
 * Your custom combo class will allow to specify all properties to be mapped.
 * It will also allow to override existing default getters/setters/assertions
 * and add more specific method as required.
 *
 * For combo with multiple option see MultiCombo class.
 *
 * @package Escape\Argon\EntityManagement\DataMappers
 */
class Combo extends DataMapper
{
    public function __construct($data=null)
    {
        if ($data instanceof ComboFieldValue)
        {
            foreach ($data as $array)
            {
                $this->mapArray($array);
                return;
            }
        }

        if (is_array($data))
        {
            $this->mapArray($data);
            return;
        }
    }
}
