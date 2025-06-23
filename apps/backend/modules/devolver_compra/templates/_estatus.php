<?php
if($devolver_compra->getEstatus()==1) {
  echo "<span class='badge bg-info'>PENDIENTE</span>";
} else if($devolver_compra->getEstatus()==2) {
  echo "<span class='badge bg-warning'>PROCESADO</span>";
} else if($devolver_compra->getEstatus()==3) {
  echo "<span class='badge bg-danger'>ANULADO</span>";
}
?>
