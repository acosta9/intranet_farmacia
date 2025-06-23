<?php
if($pre_factura->getHasInvoice()==1) {
  echo "<a href='".url_for("factura")."/show?id=".$pre_factura["fid"]."'>".$pre_factura["factura"]."</a>";
} else {
  echo "<i class='fas fa-minus-circle'></i>";
}
?>
