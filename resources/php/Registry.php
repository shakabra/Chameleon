<?php
/**
 * A object used to store and retrie instances of other objects.
 *
 * @author Jason Favrod <lakona808@gmail.com>
 */
require_once 'Chameleon.php';

class Registry extends Chameleon
{
    private static $_store = array();

    public static function add($object, $name=null)
    {
        if (is_null($name)) $name = get_class($object);

        if (isset(self::$_store[$name]))
            self::printWarning('Already an object: '. $name .' in the Registry');

        self::$_store[$name] = $object; 
    }

    public static function get($name)
    {
        if (!array_key_exists($name, self::$_store))
            self::printError('Item: '. $name .' not in the Registry');

        return self::$_store[$name];
    }

    
    public static function isStored($name)
    {
	if (in_array($_store, $name))
	    return true;
	else
	    return false;
    }

    public function __toString()
    {
        $_string = '';
        foreach (self::$_store as $name => $object)
            $_string .= $name. ': ' .get_class($object) . "\n";

        return $_string;
    }

    public function toHtml()
    {
        $_html = "<table class=\"php-obj-table\">\n";
        $_html .= "\t<tr><th>Name</th><th>Type</th></tr>\n";

        foreach(self::$_store as $name => $object)
            $_html .= "\t<tr><td>$name</td><td>".get_class($object)."</td></tr>\n";

        $_html .= "</table>\n";
        return $_html;
    }
}

