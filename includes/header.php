<?php
  $aryNav = array('home','tattoos','merch','contact','links');
?>
<a href="./?page=home"><img src="./resource/img/header.png" alt="TattooIn-AZ: BY:Dave" /></a>
<div class="nav">
  <ul class="nav">
    <?php
    $pageID = (isset($_GET['page'])) ? $_REQUEST['page'] : "home" ;

    foreach($aryNav as $links){
      $linkClass = ($links == $pageID)? " active" : "" ; ?>
      <li><a class="navImg <?= $links . $linkClass; ?>" href="./?page=<?= $links; ?>"><?= $links; ?></a></li>
    <?php } ?>
  </ul>
</div>
