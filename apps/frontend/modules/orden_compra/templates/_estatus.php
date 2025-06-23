<?php
if($orden_compra->getOrdenCompraEstatusId()==1) {
  echo "<span class='badge bg-info'>PENDIENTE</span>";
} else if($orden_compra->getOrdenCompraEstatusId()==2) {
  echo "<span class='badge bg-success'>PROCESADO</span>";
} else if($orden_compra->getOrdenCompraEstatusId()==3) {
  echo "<span class='badge bg-danger'>ANULADO</span>";
}
?>
