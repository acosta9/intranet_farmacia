<?php
if($factura_gastos->getEstatus()==1) {
  echo "<span class='badge bg-info'>PENDIENTE</span>";
} else if($factura_gastos->getEstatus()==2) {
  echo "<span class='badge bg-warning'>ABONADO</span>";
} else if($factura_gastos->getEstatus()==3) {
  echo "<span class='badge bg-success'>CANCELADO</span>";
} else if($factura_gastos->getEstatus()==4) {
  echo "<span class='badge bg-danger'>ANULADO</span>";
}
?>
