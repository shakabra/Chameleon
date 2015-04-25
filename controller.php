<?php


/**
 * Grabs the request URI, parses it, then includes any requested page
 * that is in the PAGES_DIR.
 *
 * @return void
 */

function includePageFromUri()
{
    $URI = requestUri();

    if (!empty($_GET))
        $URI = strstr($URI, '?', true);

    if ($URI === '' && DEFAULT_PAGE)
        include(PAGES_DIR.'/'.DEFAULT_PAGE);

    else if (isInPagesDir("$URI.php"))
        include(PAGES_DIR."/$URI.php");

    else
        include(PAGES_DIR.'/404.php');
}


/**
 * uri
 * 
 * @return The filtered REQUEST_URI.
 */

function requestUri()
{
    return
        ltrim(filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL), '/');  
}


/**
 * isInPagesDir
 *
 * @param String $page The name of the file to check existance of in
 * PAGES_DIR.
 *
 * @return Boolean True if $page is a file in the PAGES_DIR false
 * otherwise.
 */

function isInPagesDir($page)
{
    return in_array($page, scandir(PAGES_DIR));
}

/**
 * printSiteHeader
 *
 * Prints the required HTML header data (based on config).
 */

function printSiteHeader()
{
    print '
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">

    <title>'.htmlTitle().'</title>

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
 * htmlTitle
 *
 * Determines the HTML title.
 */

function htmlTitle()
{
    $URI = requestUri();

    if (isInPagesDir("$URI.php"))
	return $URI;
    else
        return SITE_TITLE;	
}


/**
 * Prints the script tags required for Chameleon/Bootstrap to function.
 */

function printRequiredScripts()
{
    print '
    <script src="'.BOOTSTRAP_DIR.'/js/bootstrap.min.js"></script>';
}
