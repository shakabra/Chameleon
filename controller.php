<?php
namespace app;


/**
 * Grabs the request URI, parses it, then includes any requested page
 * that is in the PAGES_DIR.
 *
 * @return void
 */

function include_page_from_uri() {
    $URI = ltrim(filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL), '/');

    if (!empty($_GET)) {
        $URI = strstr($URI, '?', true);
    }

    if ($URI === '' && DEFAULT_PAGE){
        include(PAGES_DIR.'/'.DEFAULT_PAGE);
    }
    else if (in_array("$URI.php", scandir(PAGES_DIR))) {
        include(PAGES_DIR."/$URI.php");
    }
    else {
        include(PAGES_DIR.'/404.php');
    }
}


/**
 * Prints the required HTML header data (based on config).
 */

function print_site_header()
{
    print '
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">

    <title>'.SITE_TITLE.'</title>

    <script src="'.JS_DIR.'/jquery-1.11.2.min.js"></script>
    <script src="'.JQUERY_UI_DIR.'/external/jquery/jquery.js"></script>
    <script src="'.JQUERY_UI_DIR.'/jquery-ui.min.js"></script>

    <link rel="stylesheet" href="'.BOOTSTRAP_DIR.'/css/bootstrap.min.css">
    <link rel="stylesheet" href="'.CSS_DIR.'/layout.css">
    <link rel="stylesheet" href="'.CSS_DIR.'/formatting.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn\'t work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    ';
}


/**
 * Prints the script tags required for Chameleon/Bootstrap to function.
 */

function print_required_scripts()
{
    print '
    <script src="'.BOOTSTRAP_DIR.'/js/bootstrap.min.js"></script>
    ';
}
