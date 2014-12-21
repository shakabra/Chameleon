<?php
namespace app;


/**
 * Grabs the request URI, parses it, then includes on the page any
 * requested page that is in the PAGES_DIR.
 *
 * @return void
 */

function include_page_from_uri() {
    $URI = ltrim(filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL), '/');

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
