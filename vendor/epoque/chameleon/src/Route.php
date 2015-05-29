<?php
namespace Epoque\Chameleon;


/**
 * Route
 *
 * An object that maps a requested path to a filesystem resource.
 *
 */

class Route
{
    /** @var string The requested path. **/
    public $requestPath  = '';

    /** @var string The filesystem resources the request is mapped to. **/
    public $responseFile = '';


    /**
     * construct
     *
     */

    public function __construct($array)
    {
        if (is_array($array) && count($array) === 1) {
            $this->requestPath = key($array);
            $this->responseFile = current($array);
        }
    }
}

