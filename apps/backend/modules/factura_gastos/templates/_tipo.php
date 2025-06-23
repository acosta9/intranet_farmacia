<?php
if($factura_gastos->getTipo()==1) {
  echo "<span class='badge bg-info'>FACTURA DE GASTOS</span>";
} else if($factura_gastos->getTipo()==2) {
  echo "<span class='badge bg-warning'>NOTA DE DEBITO</span>";
} 
?>
