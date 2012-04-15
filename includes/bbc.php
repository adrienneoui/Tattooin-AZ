<?php
  function BBC($data) {
    $data = preg_replace("/\[link:(.*)\](.*)\[\/link\]/", "<a class=\"textLink\" href='?page=$1'>$2</a>", $data);
    $data = preg_replace("/\[p\](.*)\[\/p\]/", "<p>$1</p>", $data);

    return($data);
  }
?>
