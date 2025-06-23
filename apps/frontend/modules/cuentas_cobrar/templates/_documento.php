<?php
if($recibo_pago["fid"]) {
  echo "FA: <a href='".url_for("factura")."/show?id=".$recibo_pago["fid"]."' target='_blank'>".$recibo_pago["fnum"]."</a>";
} else {
  echo "NE: <a href='".url_for("nota_entrega")."/show?id=".$recibo_pago["neid"]."' target='_blank'>".$recibo_pago["nenum"]."</a>";
}
?>
