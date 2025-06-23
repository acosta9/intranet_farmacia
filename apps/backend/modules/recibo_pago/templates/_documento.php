<?php
if($recibo_pago["fid"]) {
  if(!empty($recibo_pago["fnum"])) {
    echo "FA: <a href='".url_for("factura")."/show?id=".$recibo_pago["fid"]."'>".$recibo_pago["fnum"]."</a>";
  } else if(!empty($recibo_pago["fdespacho"])) {
    echo "FA: <a href='".url_for("factura")."/show?id=".$recibo_pago["fid"]."'>".$recibo_pago["fdespacho"]."</a>";
  } else {
    echo "FA: <a href='".url_for("factura")."/show?id=".$recibo_pago["fid"]."'>".$recibo_pago["fid"]."</a>";
  }
} else {
  echo "NE: <a href='".url_for("nota_entrega")."/show?id=".$recibo_pago["neid"]."'>".$recibo_pago["nenum"]."</a>";
}
?>
