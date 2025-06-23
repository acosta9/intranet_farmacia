<?php
if($recibo_pago_compra["fid"]) {
  echo "FC: <a href='".url_for("factura")."/show?id=".$recibo_pago_compra["fid"]."'>".$recibo_pago_compra["fnum"]."</a>";
} else if($recibo_pago_compra["fgid"]) {
  echo "FG: <a href='".url_for("factura_compra")."/show?id=".$recibo_pago_compra["fgid"]."'>".$recibo_pago_compra["fgnum"]."</a>";
}
?>
