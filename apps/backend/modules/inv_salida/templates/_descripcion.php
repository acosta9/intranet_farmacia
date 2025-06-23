<?php 
  $desc=$inv_salida->getDescripcion();
  if(strlen($inv_salida->getDescripcion())>200) {
    $desc=substr($inv_salida->getDescripcion(),0,200)."...";
  }
  echo "<div class='desc_id'>".$desc."</div>";
?>