<?php
namespace app;

require_once('vendor/autoload.php');
require_once('config.php'); 
require_once('controller.php'); 


print '
<!DOCTYPE html>
<html lang="en">

  <head>
    '.printSiteHeader().'
  </head>

  <body>
    '.includePageFromUri().'
    '.printRequiredScripts().'
  </body>

</html>
';

