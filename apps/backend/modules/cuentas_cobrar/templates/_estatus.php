<?php
if($cuentas_cobrar->getEstatus()==1) {
  echo "<span class='badge bg-info'>PENDIENTE</span>";
} else if($cuentas_cobrar->getEstatus()==2) {
  echo "<span class='badge bg-warning'>ABONADO</span>";
} else if($cuentas_cobrar->getEstatus()==3) {
  echo "<span class='badge bg-success'>CANCELADO</span>";
} else if($cuentas_cobrar->getEstatus()==4) {
  echo "<span class='badge bg-danger'>ANULADO</span>";
}
?>
