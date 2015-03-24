<?php

class HTML
{
    private static $element_count = [];

    public static function p ($spec=[], $type=__method__)
    {
        $text = "";
        $type = ltrim($type, "HTML::");

        if      (is_array($spec))    $text = $spec["text"];
        else if (is_string($spec))   $text = $spec;

        return "<" . $type . " id=\"" . self::getID($type) . "\">" . $text .
            "</" . $type . ">";
    }


    public static function h1 ($spec=[], $type=__method__) {
        return self::p($spec, $type);
    }

    public static function h2 ($spec=[], $type=__method__) {
        return self::p($spec, $type);
    }

    public static function h3 ($spec=[], $type=__method__) {
        return self::p($spec, $type);
    }

    public static function h4 ($spec=[], $type=__method__) {
        return self::p($spec, $type);
    }

    public static function h5 ($spec=[], $type=__method__) {
        return self::p($spec, $type);
    }


    private static function getID($type)
    {
        if (array_key_exists($type, self::$element_count)) ++self::$element_count[$type];
        else                                               self::$element_count[$type] = 1;

        return $type . "-" . self::$element_count[$type];
    }
}
