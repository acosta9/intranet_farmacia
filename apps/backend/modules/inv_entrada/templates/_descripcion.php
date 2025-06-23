<?php 
  $desc=$inv_entrada->getDescripcion();
  if(strlen($inv_entrada->getDescripcion())>200) {
    $desc=substr($inv_entrada->getDescripcion(),0,200)."...";
  }
  echo "<div class='desc_id'>".$desc."</div>";
?>