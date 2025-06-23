<?php
if($factura_compra->getEstatus()==1) {
  echo "<span class='badge bg-info'>PENDIENTE</span>";
} else if($factura_compra->getEstatus()==2) {
  echo "<span class='badge bg-warning'>ABONADO</span>";
} else if($factura_compra->getEstatus()==3) {
  echo "<span class='badge bg-success'>CANCELADO</span>";
} else if($factura_compra->getEstatus()==4) {
  echo "<span class='badge bg-danger'>ANULADO</span>";
}
?>
