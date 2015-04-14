<?php

class Html
{
    private static function generate_html(&$description)
    {
        $spec    = $description['spec'];
        $markup  = '<'.$description['tag'];

        if (is_array($spec))
        {
            foreach ($spec as $spec_key => $spec_value)
            {
                if (in_array($spec_key, $description['attribs']))
                    $markup .= ' '.$spec_key.'="'.$spec_value.'"';
            }
        }

        $markup .= '>';

        if(is_string($spec))
            $markup .= $spec;
        else if (array_key_exists('text', $spec))
            $markup .= $spec['text'];

        $markup .= "</".$description['tag'].">\n";

        return $markup;
    }


    /**
     * simpleElement
     *
     * Method used by h1-h5, p, etc. tags where specifiying attributes
     * is optional.
     *
     * @param string|array &$spec
     * @param string &$type = Type of calling function.
     *
     * @return string 
     */

    public static function simpleElement (&$spec, $type)
    {
        $description = ['tag'     => ltrim($type, 'HTML::'),
                        'attribs' => ['id', 'text'],
                        'spec'    => $spec ];

        return self::generate_html($description);
    }
    public static function h1 ($spec=[]) {
        return self::simpleElement($spec, 'h1');
    }
    public static function h2 ($spec=[]) {
        return self::simpleElement($spec, 'h2');
    }
    public static function h3 ($spec=[]) {
        return self::simpleElement($spec, 'h3');
    }
    public static function h4 ($spec=[]) {
        return self::simpleElement($spec, 'h4');
    }
    public static function h5 ($spec=[]) {
        return self::simpleElement($spec, 'h5');
    }
    public static function p ($spec=[]) {
        return self::simpleElement($spec, 'p');
    }
    public static function span ($spec=[]) {
        return self::simpleElement($spec, 'span');
    }


    public static function label($spec=[])
    {
        $description = ['tag'     => 'label',
                        'attribs' => ['id', 'for', 'text'],
                        'spec'    => $spec ];

        return self::generate_html($description);
    }

    public static function button($spec=[])
    {
        $description = ['tag'     => 'button',
                        'attribs' => ['name', 'type', 'value'],
                        'spec'    => $spec ];

        return self::generate_html($description);
    }


    public static function input ($spec=[])
    {
        $description = ['tag'     => 'input',
                        'attribs' => ['name', 'type', 'value', 'required',
                                      'placeholder'],
                        'spec'    => $spec ];

        return self::generate_html($description);
    }


    public static function textarea($spec=[])
    {
        $description = ['tag'     => 'textarea',
                        'attribs' => ['rows', 'cols'],
                        'spec'    => $spec ];

        return self::generate_html($description);
    }


    private static function container_type(&$spec, $type)
    {
        $markup  = "<$type";
        
        if (array_key_exists('id', $spec))
            $markup .= ' id="'.$spec['id'].'"';
        
        if (array_key_exists('class', $spec))
            $markup .= ' class="'.$spec['class'].'"';

        $markup .= '>';

        if (array_key_exists('elements', $spec))
            if (is_array($spec['elements']))
                foreach ($spec['elements'] as $element) $markup .= $element;
            else
                $markup .= $spec['elements'];


        $markup .= "</$type>";

        return $markup;
    }
    public static function div($spec=[]) {
        return self::container_type($spec, 'div');

    }
    public static function form($spec=[]) {
        return self::container_type($spec, 'form');
    }



    /**
     * table
     *
     * An HTML table generated base upon $spec parameter.
     *
     * @param array $spec HTML table specification.
     * @return String The generated HTML table.
     */

    public static function table($spec=[])
    {
        $markup       = '';
        $spec['type'] = 'table';
        $id           = $spec['id'];
        $class        = $spec['class'];

        $markup = "<table $id$class>";
        if (array_key_exists('cols', $spec))
        {
            $markup .= "\t<tr>";

            foreach ($spec['cols'] as $attribute) {
                $markup .= "<th>$attribute</th>";
            }

            $markup .= "</tr>\n";
        }

        foreach ($spec['rows'] as $row) {
            $markup .= "\t<tr>";

          foreach ($row as $data) {
            $markup .= "<td>$data</td>";
          }

          $markup .= "</tr>\n";
        }

        return $markup .= "</table>\n";
    }
}
