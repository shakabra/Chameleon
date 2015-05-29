<?php
namespace Epoque\Chameleon;


/**
 * Router
 *
 * A static class for holding routes and handling route requests.
 */

class Router
{
    /** @var array Contains valid routes. **/
    private static $routes = [];


    /**
     * addRoute
     *
     * Adds a given route to the routes array if valid.
     *
     * @param  Route   $route The given route.
     * @return Boolean True if given route is valid and added to
     *                 $this->routes.
     */

    public static function addRoute($route=null)
    {
        if (self::validRoute($route)) {
            array_push(self::$routes, $route);
        }
    }


    /**
     * validRoute
     *
     * Checks if a given route is considered valid.
     *
     * @param Route $route The given route.
     * @return Boolean True  : Given route is valid.
     *                 False : Given route is not valid.
     */

    private function validRoute($route)
    {
        return True;
    }


    protected function isView($route)
    {
        $view = False;
        $tmp  = null;

        if (is_file(VIEWS_DIR.'/'.current($route))) {
            $view = True;
        }
        else {
            $tmp = scandir(VIEWS_DIR);
            array_shift($tmp);
            array_shift($tmp);
            print '<p>VIEWS_DIR contents: '; print_r($tmp); print '</p>';
        }

        return $view;
    }


    public static function toHtml()
    {
        $string = "<table>\n";

        foreach (self::$routes as $route) {
            $string .= "\t<tr><td>".$route->requestPath.'</td><td>'.$route->responseFile."</td></tr>\n";
        }


        $string .= '</table>';

        return $string;
    }
}
