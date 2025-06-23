<?php
if($ordenes_compra->getEstatus()==1) {
  echo "<span class='badge bg-info'>COTIZACION</span>";
} else if($ordenes_compra->getEstatus()==2) {
  echo "<span class='badge bg-lightblue'>OC INGRESADA</span>";
} else if($ordenes_compra->getEstatus()==3) {
  echo "<span class='badge bg-warning'>OC PENDIENTE</span>";
} else if($ordenes_compra->getEstatus()==4) {
  echo "<span class='badge bg-success'>OC CERRADA</span>";
} else if($ordenes_compra->getEstatus()==5) {
  echo "<span class='badge bg-danger'>ANULADO</span>";
}
?>