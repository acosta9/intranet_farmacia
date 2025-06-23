<?php
if($cuentas_cobrar->getFacturaId()) {
  if(!empty($cuentas_cobrar["fnum"])) {
    echo "FA: <a href='".url_for("factura")."/show?id=".$cuentas_cobrar["fid"]."'>".$cuentas_cobrar["fnum"]."</a>";
  } else if (!empty($cuentas_cobrar["fdespacho"])) {
    echo "FA: <a href='".url_for("factura")."/show?id=".$cuentas_cobrar["fid"]."'>".$cuentas_cobrar["fdespacho"]."</a>";
  } else {
    echo "FA: <a href='".url_for("factura")."/show?id=".$cuentas_cobrar["fid"]."'>".$cuentas_cobrar["fid"]."</a>";
  }
} else {
  echo "NE: <a href='".url_for("nota_entrega")."/show?id=".$cuentas_cobrar["neid"]."'>".$cuentas_cobrar["nenum"]."</a>";
}
?>
