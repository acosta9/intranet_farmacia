<?php
  echo $inventario->getProductoName()." ";
  echo "<a href='".url_for("producto")."/".$inventario->getProductoId()."'><span class='badge badge-primary'>VER MAS</span></a>";
?>