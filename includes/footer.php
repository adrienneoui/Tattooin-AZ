<div class="clusterBox">
  <?php
    $minis = file_get_contents('./data/mini-imgs.json');
    $minis = json_decode($minis, true);

    if(is_array($minis)){
      shuffle($minis);
      $minis = array_slice($minis, 0, 60);

      foreach($minis as $key => $mini){ ?>
        <div class="imgCluster" id="cluster_<?= $key; ?>">
          <img src="./resource/artwork/mini/<?= $mini['image']; ?>" alt="<?= $mini['name']; ?>" title="<?= $mini['name']; ?>" />
        </div>
    <?php }
    }
  ?>
</div>
<footer class="footer">
  <p><a href="http://www.tattooin-az.com">www.tattooin-az.com</a> | by: Dave | All images are personal property of artist.</p>
</footer>