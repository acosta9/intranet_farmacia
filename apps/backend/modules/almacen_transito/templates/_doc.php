<?php
if($almacen_transito->getTipo()==1) {
  echo $almacen_transito["fnum"];
} else if($almacen_transito->getTipo()==2) {
  $almacen_transito["nenum"];
} else if($almacen_transito->getTipo()==3) {
  echo $almacen_transito["tid"];
}
?>
