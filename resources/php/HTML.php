<?php

class HTML
{
    private static $element_count = [];


    /**
     * getID
     *
     * Generates a sequential HTML id based on the given type (of HTML
     * element).
     *
     * @param   string $type
     * @return  stirng
     */

    public static function getID(&$spec)
    {
        $id = '';

        if (array_key_exists('id', $spec))
            $id = $spec['id'];
        else
            $id = self::createID($spec['type']);

        return "id=\"$id\"";
    }


    /**
     * createID
     *
     */

    private static function createID($type)
    {
        if (array_key_exists($type, self::$element_count))
            ++self::$element_count[$type];
        else
            self::$element_count[$type] = 1;

        return $type.'-'.self::$element_count[$type];
    }


    /**
     * getClass
     */
    
    private static function getClass(&$spec)
    {
        $class = '';

        if (array_key_exists('class', $spec))
            $class = ' class="'.$spec['class'].'"';

        return $class;
    }


    /**
     * simpleElement
     *
     * Method used by h1-h5, p, etc. tags where specifiying attributes
     * is optional.
     *
     * @param string|array &$spec
     * @param string &$type = __method__ of calling function.
     *
     * @return string 
     */

    public static function simpleElement (&$spec, &$type)
    {
        $id   = '';
        $text = '';
        $type = ltrim($type, 'HTML::');

        if (is_array($spec)) {
            $id   = self::getID($spec);
            $text = $spec['text'];
        }
        else if (is_string($spec)) {
            $id   = 'id="'.self::createID($type).'"';
            $text = $spec;
        }

        return '<'.$type.' '.$id.">$text</$type>\n";
    }
    public static function h1 ($spec=[], $type=__method__) {
        return self::simpleElement($spec, $type);
    }
    public static function h2 ($spec=[], $type=__method__) {
        return self::simpleElement($spec, $type);
    }
    public static function h3 ($spec=[], $type=__method__) {
        return self::simpleElement($spec, $type);
    }
    public static function h4 ($spec=[], $type=__method__) {
        return self::simpleElement($spec, $type);
    }
    public static function h5 ($spec=[], $type=__method__) {
        return self::simpleElement($spec, $type);
    }
    public static function p ($spec=[], $type=__method__) {
        return self::simpleElement($spec, $type);
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
        $id           = self::getID($spec);
        $class        = self::getClass($spec);

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
