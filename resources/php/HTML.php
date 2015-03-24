<?php

class HTML
{
    private static $element_count = [];

    public static function simpleElement (&$spec, &$type)
    {
        $text = '';
        $type = ltrim($type, 'HTML::');

        if (is_array($spec) && array_key_exists('id', $spec))
            $id = $spec['id'];
        else
            $id = self::getID($type);

        if      (is_array($spec))    $text = $spec["text"];
        else if (is_string($spec))   $text = $spec;

        return "<$type id=\"$id\">$text</$type>\n";
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
        if (array_key_exists('id', $spec)) $id = $spec['id'];
        else                               $id = self::getID('table');

        $markup = "<table id=\"$id\">\n";

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


    private static function getID($type)
    {
        if (array_key_exists($type, self::$element_count)) ++self::$element_count[$type];
        else                                               self::$element_count[$type] = 1;

        return $type . "-" . self::$element_count[$type];
    }
}
