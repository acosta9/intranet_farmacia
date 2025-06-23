<?php
if($cuentas_pagar->getEstatus()==1) {
  echo "<span class='badge bg-info'>PENDIENTE</span>";
} else if($cuentas_pagar->getEstatus()==2) {
  echo "<span class='badge bg-warning'>ABONADO</span>";
} else if($cuentas_pagar->getEstatus()==3) {
  echo "<span class='badge bg-success'>CANCELADO</span>";
} else if($cuentas_pagar->getEstatus()==4) {
  echo "<span class='badge bg-danger'>ANULADO</span>";
}
?>
