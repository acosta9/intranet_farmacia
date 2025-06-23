<?php
if($cuentas_cobrar->getFacturaId()) {
  echo "FA: <a href='".url_for("factura")."/show?id=".$cuentas_cobrar["fid"]."' target='_blank'>".$cuentas_cobrar["fnum"]."</a>";
} else {
  echo "NE: <a href='".url_for("nota_entrega")."/show?id=".$cuentas_cobrar["neid"]."' target='_blank'>".$cuentas_cobrar["nenum"]."</a>";
}
?>
