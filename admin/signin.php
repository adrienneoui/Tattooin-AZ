<?php
  $name = $_POST['name'];
  $pass = $_POST['pass'];

  $feed = json_decode(file_get_contents("./mine.json"));

  $valid->name = true;
  $valid->pass = true;

  if($name === $feed->name && $pass === $feed->pass){
    session_start();
    $_SESSION['active'] = 'true';
    $_SESSION['time']     = time()+3600;
  }

  header( 'Location: ./?mess=true' );
?>
