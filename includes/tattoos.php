<?php
  $activeCat = $_REQUEST['category'];

  $feed = $fullFeed = (!empty($activeCat)) ? file_get_contents("./data/tattoos-". $activeCat .".json") : '' ;
  $feed = json_decode($feed);

//  echo '<pre>';
//  print_r($feed);
//  die;

  foreach($tattooCategories as $key => $category){
    $last = (0 === $key) ? ' last' : '' ;
    $cat = preg_replace("/ /", "-", strtolower($category));

    $cats .= "<li><a class=\"". $cat ."\" href=\"?page=tattoos&category=". $cat ."\"><span>". $category ."</span></a></li>";

    $className = ($activeCat === $cat) ? ' active' : '' ;
    $breadCrumb .= "<li class=\"crumb ". $className . $last ."\"><a href=\"?page=tattoos&category=". $cat ."\">". $category ."</a></li>";
  }

  if(empty($feed)) {
?>
<h2>Tattoos</h2>
<ul class="category">
  <?= $cats; ?>
</ul>
<?php } else {
  switch ($activeCat){
    case "black-and-grey":
      $headerTxt = "Black & Grey";
      break;
    case "color":
      $headerTxt = "Color";
      break;
    case "in-progress":
      $headerTxt = "In Progress";
      break;
    case "my-photos":
      $headerTxt = "My Photos";
      break;
  }
?>

<div class="galleryHeader"><?= $headerTxt; ?></div>

<div class="imgViewer">
  <ul class="breadCrumb">
    <?= $breadCrumb ?>
  </ul>
  <div class="column smallCol">
    <div id="thumbs">
      <div id="thumbsMove">
        <?php
        $blanks = 18 - (count($feed) % 18);
        foreach($feed as $key => $image){
          echo _makeThumb($key, $image, $activeCat);
        }
        for($i=0; $i<$blanks; $i++){
        ?>
        <div class="thumbNail blank"></div>
        <?php
        }
        ?>
      </div>
    </div>
    <div id="nextPrev" class="nextPrev">
      <?php
      $nextCSS = (count($feed) > 18) ? '' : ' hide' ;
      ?>
      <a href="#" class="next<?= $nextCSS ?>"></a>
      <a href="#" class="prev hide"></a>
      <div id="imgName" class="imgName"><?= $feed[0]->name; ?></div>
    </div>
  </div>
  <div id="imageViewer" class="column largeCol">
    <img src="./resource/artwork/<?= $activeCat; ?>/<?= $feed[0]->image; ?>" />
  </div>
</div>
<?php }

function _makeThumb($key, $img, $activeCat){
  $jsData = array(
      'cat'=>(string)$activeCat,
      'img'=>(string)$img->image,
      'name'=>(string)$img->name
  );
  ?>
  <div class="thumbNail">
    <a href="javascript:void(0);" js-data='<?= json_encode($jsData); ?>'>
      <img src="./resource/artwork/thumbs/<?= $activeCat; ?>/<?=
      $img->image; ?>" alt="<?=
      $img->name; ?>" title="<?=
      $img->name; ?>" />
    </a>
  </div>
<?php
}
?>

<script type="text/javascript">
  var allImgs = <?= $fullFeed; ?>;
</script>