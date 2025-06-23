<?php
if($almacen_transito->getEstatus()==1) {
  echo "<span class='badge bg-info'>EN PROCESO</span>";
} else if($almacen_transito->getEstatus()==2) {
  echo "<span class='badge bg-warning'>EMBALADO</span>";
} else if($almacen_transito->getEstatus()==3) {
  echo "<span class='badge bg-success'>DESPACHADO</span>";
} else if($almacen_transito->getEstatus()==4) {
  echo "<span class='badge bg-danger'>ANULADO</span>";
}
?>
