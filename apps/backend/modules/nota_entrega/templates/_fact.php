<?php
if(strlen($nota_entrega["fid"])>0) {
  echo "<a href='".url_for("factura")."/show?id=".$nota_entrega["fid"]."'>".$nota_entrega["fnum"]."</a>";
} else {
  echo "<i class='fas fa-minus-circle'></i>";
}
?>
