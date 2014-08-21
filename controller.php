<?php
namespace app;

require_once('config.php');
require_once(PHP_DIR.'/authentication.php');

use authentication as auth;


/**
 * Grab the server request URI, trim off the leading slash, look inside
 * a specified for a php file with the same name as the URI. If there's
 * such a file, return an include statement with the file specified as
 * its argument.
 *
 *     NOTE: Includes a 404.php page by default.
 *
 * @todo: Make the $pages_dir parameter a configuration option.
 *
 * @param string $pages_dir 'pages' by default, otherwise the directory
 * from where pages are included from.
 *
 * @return void Includes A php file in the document.
 */
function get_page_from_uri($pages_dir='pages') {
    $URI = ltrim($_SERVER['REQUEST_URI'], '/');

    if ($URI == ""){
        include("$pages_dir/home.php");
    }
    else if (in_array("$URI.php", scandir("$pages_dir"))) {
        include("$pages_dir/$URI.php");
    }
    else if (preg_match('|^posts\?id=\d+$|', $URI)) {
        include('pages/posts.php');
    }
    else {
        include("$pages_dir/404.php");
    }
}

function print_authenticator() {
    print(auth\html_authenticator());
}

function print_session() {
    echo "cookie: "; print_r($_COOKIE); print "\n<br>";
    if ($_SESSION) {
        print_r($_SESSION);
    }
    else {
        print('No Session');
    }
}
