<?php
namespace app;

require_once('resources/php/Registry.php');
require_once('resources/php/Database.php');
require_once('resources/php/Nav.php');

use Registry;
use Database;
use Nav;


error_reporting(E_ERROR | E_PARSE | E_WARNING);
#(E_ERROR | E_PARSE | E_WARNING)


// Setup some constants.
define('APP_ROOT', __DIR__);
define('PHP_DIR', __DIR__.'/resources/php');
define('IMG_DIR', '/resources/images');
define('SITE_TITLE', '');


// MySQL settings
define('DB_NAME', '');   # The name of the database.
define('DB_USER', '');   # The MySQL database username.
define('DB_PASS', '');   # Password for the database user.
define('DB_HOST', '');   # The Host Address of the database.

// Dates Formatting
define('PUBDATE_FORMAT', 'M d, Y');
date_default_timezone_set('UTC');


/**
/* Options for the Site Navigation:
/* ------------------------------------
/* nav_root => [path] To the site's published content.
/* files => [true | false] Show files in site's navigation.
/* dirs => [true | false] Show directories in the site's navigation
/* discard_ext = ['.html', '.php']
/* ignore_files_by_ext = ['.swp']
 */
$nav_config = [
    'nav_root' => 'pages',
    'files' => true,
    'dirs' => false,
    'default_page' => 'default.php',
    'ignore' => ['404.php', 'post.php', 'test.php'],
    'ignore_files_by_ext' => ['.swp'],
    'custom_html' => null
];

// Create a Registry and ddd our shared objects.
$Registry = new Registry();
$Registry::add(new Database());
$Registry::add(new Nav($nav_config));
