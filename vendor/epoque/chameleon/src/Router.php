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
    private $routes = [];


    /**
     * addRoute
     *
     * Checks given route for validity
     *
     * @param Route $route The given route.
     * @return Boolean True  : Given route is valid and added to
     *                         $this->routes.
     *                 False : Given route was not valid, not added to
     *                         $this->routes.
     */

    public function addRoute($route=[])
    {
        print "Hello";
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


    public function toHtml()
    {
        $string = "<table>\n";

        foreach (self::$routes as $k => $v)
            $string .= "\t<tr><td>$k</td><td>$v</td></tr>\n";

        $string .= '</table>';

        return $string;
    }

    protected function is_view($route)
    {
        $view = False;
        $tmp  = null;

        if (is_file(VIEWS_DIR.'/'.current($route)))
            $view = True;
        else {
            $tmp = scandir(VIEWS_DIR);
            array_shift($tmp);
            array_shift($tmp);
            print '<p>VIEWS_DIR contents: '; print_r($tmp); print '</p>';
        }

        return $view;
    }
}
