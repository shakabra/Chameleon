<?php
/**
 * A class used to store data in an HTTP cookie
 */

class Cookie
{
    public $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function __toString() {
        return (string)$this->data;
    }
}

