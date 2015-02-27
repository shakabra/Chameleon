<?php
namespace app;
require_once('config.php'); 
require_once('controller.php'); 
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <?php print_site_header(); ?>
  </head>

  <body>
    <?php include_page_from_uri(); ?>
    <?php print_required_scripts(); ?>
  </body>

</html>
