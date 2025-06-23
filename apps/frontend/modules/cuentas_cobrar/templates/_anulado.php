<?php
if($recibo_pago->getAnulado()==1) {
  echo "<span class='badge bg-danger'>ANULADO</span>";
} else {
  echo "<span class='badge bg-success'>PROCESADO</span>";
}
?>
