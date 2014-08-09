<?php
/**
 * A object used to store and retrie instances of other objects.
 *
 * @author Jason Favrod <lakona808@gmail.com>
 */

class Registry {
    private static $_store = array();

    public static function add($object, $name=null) {
        !is_null($name)?: $name = get_class($object);

        if (isset(self::$_store[$name])) {
            throw new Exception('Already an object: '. $name .' in the Registry');
        }

        self::$_store[$name] = $object; 
    }

    public static function get($name) {
        if (!array_key_exists($name, self::$_store)) {
            throw new Exception('Item: '. $name .' not in the Registry');
        }
        return self::$_store[$name];
    }

    public function __toString() {
        $_string = '';
        foreach(self::$_store as $name => $object) {
            $_string .= $name. ': ' .get_class($object) . "\n";
        }
        return $_string;
    }
}
