<?php
if($inv_entrada->getAnulado()==0) {
  echo "<span class='badge bg-success'>PROCESADO</span>";
} else {
  echo "<span class='badge bg-danger'>ANULADO</span>";
}
?>
