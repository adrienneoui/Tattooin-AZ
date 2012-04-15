<?php
//phpinfo();
//die;

  $upLoadedFeed = file_get_contents("../data/last-up-loaded.json");
  $upLoadedFeed = json_decode($upLoadedFeed, true);
  $errorFeed = file_get_contents("../data/errors.json");
  $errorFeed = json_decode($errorFeed, true);

  $allNew = '../data/errors.json';
  $fh = fopen($allNew, 'w') or die("can't open file");
  fwrite($fh, '[]');
  fclose($fh);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<?php
  $categories = array(
      'Color',
      'Black and Grey',
      'In Progress',
      'My Photos'
  );
  $count = (!empty($_REQUEST['count'])) ? $_REQUEST['count'] : 5 ;
?>

<html>
  <head>
    <title>TattooIn-Az</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="description" content="TattooIn-Az: A one man shop. Here is his online porfolio." />
    <meta name="keywords" content="tattoo, tattoos, tattoo arizona, arizona tattoo, tattoos arizona, arizona tattoos, tattoo az, az tattoo, tattoos az, az tattoos, tattoo artist, arizona tattoo artist, az tattoo artist" />
    <link rel="stylesheet" href="./admin.css" type="text/css" />
    <script type="text/javascript" src="../resource/jQuery.js"></script>
    <script type="text/javascript" src="../resource/json2.js"></script>
    <script type="text/javascript" src="./admin.js"></script>
  </head>
  <body>
    <form id="imageUpload" method="post" enctype="multipart/form-data" action="./uploader.php">
      <fieldset>
        <legend>Uploader</legend>
        <div class="LFloat" id="imgFilesContainer">
          <?php
          for($i = 1; $i <= $count; $i += 1) { ?>
          <div><input type="file" value="img_<?= $i; ?>" name="img[]" /></div>
            <?php }
          ?>
        </div>
        <div class="LFloat">
          <?php
            for($i = 1; $i <= $count; $i += 1) { ?>
          <div id="img_<?= $i; ?>">
            <input type="text" id="img_<?= $i; ?>_name" name="img_<?= $i; ?>_name" value="display name"/>
            <?php
              foreach($categories as $k => $cat) { ?>
            <input type="radio" id="img_<?= $i; ?>_cat_<?= $k+1; ?>" name="img_<?= $i; ?>" value="color"/><label for="img_<?= $i; ?>_cat_<?= $k+1; ?>"><?= $cat; ?></label>
              <?php }
            ?>
          </div>
            <?php }
          ?>
        </div>
        <br  style="clear: both;" />
        <input id="imgUploadSubmit" type="submit" value="Upload" />
      </fieldset>
    </form>

<!--    <form id="zipUpload" method="post" enctype="multipart/form-data" action="./zipuploader.php">
      <fieldset>
        <legend>Zip Uploader</legend>
        <div class="LFloat" id="imgFilesContainer">
          <div><input type="file" value="zip" name="zip_file" /></div>
        </div>
        <div class="LFloat">
          <div id="zip">
            <input type="radio" id="zip_1" name="zip_1" value="color"/><label for="zip_1">Color</label>
            <input type="radio" id="zip_2" name="zip_1" value="black-and-grey"/><label for="zip_2">Black and Grey</label>
            <input type="radio" id="zip_3" name="zip_1" value="in-progress"/><label for="zip_3">In Progress</label>
            <input type="radio" id="zip_4" name="zip_1" value="my-photos"/><label for="zip_4">My Photos</label>
          </div>
        </div>
        <br  style="clear: both;" />
        <input id="zipUploadSubmit" type="submit" value="Upload" />
      </fieldset>
    </form>-->
    <div id="loading">Loading...</div>
    <div id="alerts"></div>
    <div class="">
    <?php
    if(!empty ($errorFeed)){
    ?>
    <p>Errors</p>
    <ul class="lastUpLoaded">
      <?php
      foreach($errorFeed as $error){
      ?>
        <li><?= $error; ?></li>
      <?php
      }
      ?>
    </ul>
    <?php
    }
    if(!empty ($upLoadedFeed)){
    ?>
    <p>Last Uploaded</p>
    <ul class="lastUpLoaded">
    <?php
      foreach($upLoadedFeed as $category => $imgGroup){
        foreach($imgGroup as $img){
        ?>
          <li class="imgLabel"><?= $img['name']; ?></li>
          <li><img src="../resource/artwork/<?= $category .'/'. $img['image']; ?>" alt="<?= $img['name']; ?>" title="<?= $img['name']; ?>" /></li>
        <?php
        }
      }
    ?>
    </ul>
    <?php
    }
    ?>
    </div>
  </body>
</html>