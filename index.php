<?php
namespace app;
require_once('config.php'); 
require_once('controller.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo SITE_TITLE; ?></title>

  <!--<script src=""></script>-->

  <link rel="stylesheet" href="<?php echo BOOTSTRAP_DIR; ?>/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo CSS_DIR; ?>/layout.css">
  <link rel="stylesheet" href="<?php echo CSS_DIR; ?>/formatting.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>
<?php
include_page_from_uri();
?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <script src="<?php echo BOOTSTRAP_DIR; ?>/js/bootstrap.min.js"></script>
</body>
</html>
