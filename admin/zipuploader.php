<?php
if ($_FILES['zip_file']['name']) {
  $category = $_POST['zip_1'];
  $filename = $_FILES['zip_file']['name'];
  $source = $_FILES['zip_file']['tmp_name'];
  $type = $_FILES['zip_file']['type'];

  $name = explode('.', $filename);
  $accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
  foreach ($accepted_types as $mime_type) {
    if ($mime_type == $type) {
      $okay = true;
      break;
    }
  }

  $continue = strtolower($name[1]) == 'zip' ? true : false;
  if (!$continue) {
    $message = 'The file you are trying to upload is not a .zip file. Please try again.';
  }

  $target_path = './upload/' . $filename;  // change this to the correct site path
  if (move_uploaded_file($source, $target_path)) {
    $zip = new ZipArchive();
    $x = $zip->open($target_path);
    if ($x === true) {
      $zip->extractTo('./upload/temp/'); // change this to the correct site path
      $zip->close();

      unlink($target_path);
    }
    $message = 'Your .zip file was uploaded and unpacked.';
  } else {
    $message = 'There was a problem with the upload. Please try again.';
  }
}

if ($handle = opendir('./upload/temp/')) {

    /* This is the correct way to loop over the directory. */
  $images = array();
  while (false !== ($entry = readdir($handle))) {
    if($entry === '.' || $entry === '..') {
      continue;
    }

    $images[] = $entry;
  }
  echo "<pre>";
  print_r($images);
  die;
  closedir($handle);
}

require_once './filemanipulator.php';

?>