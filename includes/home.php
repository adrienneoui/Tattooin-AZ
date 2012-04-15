<?php
  $feed = file_get_contents("./data/home.json");
  $feed = json_decode($feed);
//  echo "<pre>";
//  print_r(json_encode($feed));
//  die;
?>

<h2>Welcome To Tattooin—Az.com</h2>
<img src="./resource/img/tattooing.jpg" alt="Dave hard at work" class="homeImg" />
<div class="bodycopy">
  <?php
    echo BBC($feed->bodycopy);
  ?>
  <p class="sig">- Dave</p>
</div>