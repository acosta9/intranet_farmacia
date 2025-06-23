<?php
if($traslado->getEstatus()==1) {
  echo "<span class='badge bg-info'>PENDIENTE</span>";
} else if($traslado->getEstatus()==2) {
  echo "<span class='badge bg-success'>PROCESADO</span>";
} else if($traslado->getEstatus()==3) {
  echo "<span class='badge bg-danger'>ANULADO</span>";
}
?>
