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

    private static $htmlId = 'routerTestTable';


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
     * ignored
     *
     * Checks the config file to see if the requested route should be ignored.
     *
     * @param Route $route a route object (see Route.php)
     * @return Boolean true  : If the path should be ignored
     *                 false : If the path should be processed
     */
 
    private function ignored($route) {
        $responFile = $route->responseFile;
        $ext = pathinfo($rp)['extension'];

        $ignoredFiles = array();
        array_push($ignoredFiles, explode(' ', IGNORE_FILES));

        $ignoredExt = array();
        array_push($ignoredExt, explode(' ', IGNORE_EXT));
        
        if (in_array(basename($responseFile), $ignoredFiles)) {
            return true;
        } else if (in_array($ext, $ignoredExt)) {
            return true;
        } else {
            return false;
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
        if (self::isView($route) && ! self::ignored($route)) {
            return true;
        } else {
            return false;
        }
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
        }

        return True;
    }

    public static function toHtml()
    {
        $string  = '<table id="'.self::$htmlId."\">\n";
        $string .= '<thead><tr><th>Router::routes Table</th></tr></thead>';
        $string .= '<tr><th>requestPath</th><th>responseFile</th>';

        foreach (self::$routes as $route)
            $string .= "\t<tr><td>".$route->requestPath.'</td><td>'.$route->responseFile."</td></tr>\n";

        $string .= '</table>';

        return $string;
    }
}
