<?php

namespace Escape\Argon\EntityManagement\FieldValues;

class IconFieldValue extends AbstractFieldValue
{
    public function __toString()
    {
        if (is_array($this->data)) {
            return implode(PHP_EOL, $this->data);
        } elseif ($this->data) {
            return (string) $this->data;
        } else {
            return "";
        }
    }

    public function getHtml($class = '')
    {
        $value = $this->data;

        if(is_array($this->data))
        {
            foreach($this->data as $data)
            {
                $value = $data;
            }
        }

        $svgiconsPath = config('svgicons_path', '/images/svgicons.png');
        $html = sprintf('<svg class="%s"><use xlink:href="%s#%s"></use></svg>', $class, $svgiconsPath, $value);

        return  $html;
    }

}
