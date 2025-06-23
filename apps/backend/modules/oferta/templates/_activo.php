<?php
if($oferta->getActivo()==1) {
  echo "<span class='badge bg-success'>ACTIVO</span>";
} else {
  echo "<span class='badge bg-danger'>NULO</span>";
}
?>
