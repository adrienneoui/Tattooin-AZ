<?php
  $pageID = (isset($_GET['page'])) ? $_REQUEST['page'] : "home" ;
  include_once './resource/var.php';
  include_once('./includes/bbc.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <?php include_once './includes/meta.php';?>
  </head>
  <body>
    <div class="shell">
      <?php include_once './includes/header.php';?>
      <div id="content">
      <?php include_once './includes/'. $pageID .'.php';?>
      </div>
      <?php include_once './includes/footer.php';?>
    </div>
  </body>
</html>