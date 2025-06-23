<?php
if($nota_entrega->getEstatus()==1) {
  echo "<span class='badge bg-info'>PENDIENTE</span>";
} else if($nota_entrega->getEstatus()==2) {
  echo "<span class='badge bg-warning'>ABONADO</span>";
} else if($nota_entrega->getEstatus()==3) {
  echo "<span class='badge bg-success'>CANCELADO</span>";
} else if($nota_entrega->getEstatus()==4) {
  echo "<span class='badge bg-danger'>ANULADO</span>";
}
?>
