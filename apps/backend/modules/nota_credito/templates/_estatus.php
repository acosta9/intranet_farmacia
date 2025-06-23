<?php
if($nota_credito->getEstatus()==1) {
  echo "<span class='badge bg-info'>PENDIENTE</span>";
} else if($nota_credito->getEstatus()==2) {
  echo "<span class='badge bg-success'>PROCESADO</span>";
} else {
  echo "<span class='badge bg-danger'>ANULADO</span>";
}
?>
