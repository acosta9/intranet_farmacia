<?php
$dcreditos=$cuentas_pagar["diascredito"].$cuentas_pagar["gdiascredito"];
if ($cuentas_pagar->getEstatus()==3) {
  $fecha_uno=strtotime($cuentas_pagar->getFechaRecepcion());
  $fecha_dos=strtotime($cuentas_pagar->getUpdatedAt());
  $fecha_diff=($fecha_dos - $fecha_uno)/60/60/24;
  $fecha_diff-=$dcreditos;
  if($fecha_diff<0) {
    echo "<span class='badge bg-success'>0</span>";
  } else {
    echo "<span class='badge bg-warning'>".number_format($fecha_diff,0)."</span>";
  }
} else if($cuentas_pagar->getEstatus()==4) {
  echo "<span class='badge bg-info'>0</span>";
} else {
  $fecha_uno=strtotime($cuentas_pagar->getFechaRecepcion());
  $fecha_dos=strtotime(date("Y-m-d H:i:s"));
  $fecha_diff=($fecha_dos - $fecha_uno)/60/60/24;
  $fecha_diff-=$dcreditos;
  if($fecha_diff<0) {
    echo "<span class='badge bg-success'>0</span>";
  } else {
    echo "<span class='badge bg-danger'>".number_format($fecha_diff,0)."</span>";
  }
}
?>