<?php
if($cliente->getActivo()==1) {
  echo "<span class='badge bg-success'>HABILITADO</span>";
} else {
  echo "<span class='badge bg-danger'>DES-HABILITADO</span>";
}
?>
