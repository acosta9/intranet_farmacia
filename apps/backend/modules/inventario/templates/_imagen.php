<?php if(!empty($inventario->getUrlImagen())): ?>
  <img class="img-thumbnail" src="/uploads/producto/<?php echo $inventario->getUrlImagen() ?>" width="70">
<?php else: ?>
  <img class="img-thumbnail" src="/images/user_icon.png" width="70">
<?php endif; ?>