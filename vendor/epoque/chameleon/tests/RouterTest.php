<?php
use Epoque\Chameleon\Router;
use Epoque\Chameleon\Route;

$homeRoute = new Route(['/home' => 'default.php']);

print '
<style>
#routerTestTable {
width: 400px;
}
#routerTestTable td {
border: 1px solid black;
}

</style>

<p>Try to add the following route:</p>
<pre>
print_r($homeRoute);

';
print_r($homeRoute);
print '</pre>';

Router::addRoute($homeRoute);
print Router::toHtml();

$routeArray = [
    new Route(['' => '']),
    new Route(['/path/no/file' => '']),
    new Route(['' => 'path.no']),
    new Route(['/example/path' => 'example.file'])
];

foreach ($routeArray as $route) {
    print '<p>Add Route:</p>';
    print '<pre>';
    print_r($route);
    print '</pre>';
    Router::addRoute($route);
}


print Router::toHtml();

