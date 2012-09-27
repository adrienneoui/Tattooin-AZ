<?php
$images = array();
$errors = array();
$imgDir = '';
$validExt = array(
    'jpg',
    'jpeg'
);

$imgTypes = $_FILES['img']['type'];

foreach ($imgTypes as $key=>$fileType){
  if(empty($fileType)){
    continue;
  }

  $temp = explode('/', $fileType);
  $imgType = $temp[1];
  $fileName = $_FILES['img']['name'][$key];
  $hashedFileName = md5($fileName);
  $displayName = $_POST['img_'. ($key + 1) .'_name'];
  $category = $_POST['img_'. ($key + 1)];

  if (!in_array($imgType,$validExt)) {
    $errors[] = 'Unknown extension for: '. $fileName;
  }

  $newFileName = $hashedFileName .'.'. $imgType;
  $uploadedLoc = 'upload/'. $category .'/'. $hashedFileName .'.'. $imgType;


  if(file_exists($uploadedLoc)){
    $errors[] = $fileName .' - already uploaded';
  }else{
    $action = copy($_FILES['img']['tmp_name'][$key], $uploadedLoc);

    if (!$action) {
      $errors[] = 'File upload failed, file: '. $fileName;
    }else{
      $timeStamp = getdate();
      $timeNow = $timeStamp['0'];

      $newLoc = '../resource/artwork/'. $category .'/'. strtolower($newFileName);
      $thumbLoc = '../resource/artwork/thumbs/'. $category .'/'. strtolower($newFileName);
      $miniLoc = '../resource/artwork/mini/'. strtolower($newFileName);

      $img = imageManipulation($uploadedLoc, $newLoc, $imgType);
      $thumbImg = thumbManipulation($uploadedLoc, $thumbLoc, $imgType);
      $miniImg = miniManipulation($uploadedLoc, $miniLoc, $imgType);

      $images[$category][] = array(
          'name' => $displayName,
          'image' => $newFileName,
          'dateTime' => date('m-d-Y', $timeNow),
          'timeStamp' => $timeNow
      );
      $miniImgs[] = array(
          'name' => $displayName,
          'image' => $newFileName
      );
    }
  }
}



function imageManipulation($currentImg, $newLoc, $ext){
  list($width, $height) = getimagesize($currentImg);

  $newWidth = $width;
  $newHeight = $height;

  if($width >= $height){
    if($width > 460){
      $newWidth = 460;
      $newHeight = $height / $width * 460;
    }
  }else if($height > $width){
    if($height > 460){
      $newHeight = 460;
      $newWidth= $width / $height * 460;
    }
  }

  $src = imagecreatefromjpeg($currentImg);

  $dst = imagecreatetruecolor($newWidth, $newHeight);

  imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

  imagejpeg($dst, $newLoc, 60);

  setWaterMark($newLoc, $ext);

  imagedestroy($src);
}

function setWaterMark($currentImg, $ext){
  $watermark = '../resource/img/watermark.png';
  $watermark = imagecreatefrompng($watermark);

  $src = imagecreatefromjpeg($currentImg);

  $marge_right = 10;
  $marge_bottom = 10;
  $sx = imagesx($watermark);
  $sy = imagesy($watermark);

  imagecopy($src, $watermark, imagesx($src) - $sx - $marge_right, imagesy($src) - $sy - $marge_bottom, 0, 0, imagesx($watermark), imagesy($watermark));

  imagejpeg($src, $currentImg);
  imagedestroy($src);
}

function thumbManipulation($currentImg, $newLoc, $ext){
  list($width, $height) = getimagesize($currentImg);

  $thumbWidth = $width;
  $thumbHeight = $height;

  if($width >= $height){
    if($width > 50){
      $thumbHeight = 50;
      $thumbWidth = $width / $height * 50;
      $left = $width / 4;
      $top = 0;
    }
  }else if($height > $width){
    if($height > 50){
      $thumbWidth = 50;
      $thumbHeight = $height / $width * 50;
      $left = 0;
      $top = $height / 4;
    }
  }

  $src = imagecreatefromjpeg($currentImg);

  $dst = imagecreatetruecolor($thumbWidth, $thumbHeight);
  imagecopyresampled($dst, $src, 0, 0, $left, $top, $thumbWidth, $thumbHeight, $width, $height);

  imagejpeg($dst, $newLoc, 60);

  $dst = imagecreatetruecolor(50, 50);

  $src = imagecreatefromjpeg($newLoc);

  imagecopy($dst, $src, 0, 0, 0, 0, $width, $height);

  imagejpeg($dst, $newLoc, 60);
  imagedestroy($src);
}


function miniManipulation($currentImg, $newLoc, $ext){
  list($width, $height) = getimagesize($currentImg);

  $thumbWidth = $width;
  $thumbHeight = $height;

  if($width >= $height){
    if($width > 35){
      $thumbHeight = 35;
      $thumbWidth = $width / $height * 35;
      $left = $width / 4;
      $top = 0;
    }
  }else if($height > $width){
    if($height > 35){
      $thumbWidth = 35;
      $thumbHeight = $height / $width * 35;
      $left = 0;
      $top = $height / 4;
    }
  }

  $src = imagecreatefromjpeg($currentImg);

  $dst = imagecreatetruecolor($thumbWidth, $thumbHeight);
  imagecopyresampled($dst, $src, 0, 0, $left, $top, $thumbWidth, $thumbHeight, $width, $height);

  imagejpeg($dst, $newLoc, 60);

  $dst = imagecreatetruecolor(35, 35);

  $src = imagecreatefromjpeg($newLoc);

  imagecopy($dst, $src, 0, 0, 0, 0, $width, $height);

  imagejpeg($dst, $newLoc, 60);
  imagedestroy($src);
}




if(!empty($images)){
  foreach($images as $cat => $imgs){
    $myFile = '../data/tattoos-'. $cat .'.json';
    $origFileData = file_get_contents($myFile) or die('can\'t open original file');
    $origData = json_decode($origFileData);

    if(empty ($origData)){
      $newData = $imgs;
    }else{
      $newData = array_merge(
          $imgs,
          $origData
      );
    }

    $fh = fopen($myFile, 'w') or die('can\'t open file');
    fwrite($fh, json_encode($newData));
    fclose($fh);
  }

  $myFile = '../data/mini-imgs.json';
  $origFileData = file_get_contents($myFile) or die('can\'t open original file');
  $origData = json_decode($origFileData);

  if(empty ($origData)){
    $newData = $miniImgs;
  }else{
    $newData = array_merge(
        $miniImgs,
        $origData
    );
  }

  $fh = fopen($myFile, 'w') or die('can\'t open file');
  fwrite($fh, json_encode($newData));
  fclose($fh);

  $allNew = '../data/last-up-loaded.json';
  $fh = fopen($allNew, 'w') or die('can\'t open file');
  fwrite($fh, json_encode($images));
  fclose($fh);

  $allNew = '../data/errors.json';
  $fh = fopen($allNew, 'w') or die('can\'t open file');
  fwrite($fh, json_encode($errors));
  fclose($fh);
}

header( 'Location: ./' ) ;
?>