<?php
if($almacen_transito->getTipo()==1) {
  echo "FACTURA";
} else if($almacen_transito->getTipo()==2) {
  echo "NOTA EN.";
} else if($almacen_transito->getTipo()==3) {
  echo "TRASLADO";
}
?>
