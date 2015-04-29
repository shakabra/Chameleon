<?php
require_once('config.php'); 
require_once('controller.php'); 
?>


<!DOCTYPE html>
<html lang="en">

  <head>
    <?php printSiteHeader(); ?>
  </head>

  <body>
    <?php includePageFromUri(); ?>
    <?php printRequiredScripts(); ?>
  </body>

</html>

