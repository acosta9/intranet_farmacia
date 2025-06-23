<?php
if($cuentas_pagar->getFacturaCompraId()) {
  echo "FC: <a href='".url_for("factura_compra")."/show?id=".$cuentas_pagar["fid"]."'>".$cuentas_pagar["fnum"]."</a>";
} else if($cuentas_pagar->getFacturaGastosId()) {
  echo "FG: <a href='".url_for("factura_gastos")."/show?id=".$cuentas_pagar["fgid"]."'>".$cuentas_pagar["fgnum"]."</a>";
}
?>
