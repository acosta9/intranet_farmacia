<?php if(!empty($factura["num_factura"])): ?>
  <a href="<?php echo url_for("factura")."/".$factura["id"]; ?>"><?php echo $factura["num_factura"]; ?></a>
<?php elseif(!empty($factura["ndespacho"])): ?>
  <a href="<?php echo url_for("factura")."/".$factura["id"]; ?>"><?php echo $factura["ndespacho"]; ?></a>
<?php else: ?>
  <a href="<?php echo url_for("factura")."/".$factura["id"]; ?>"><?php echo $factura["id"]; ?></a>
<?php endif; ?>