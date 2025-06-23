<?php 
  $num=$sf_params->get('num');
  $id=$sf_params->get('id');
  if(empty($inventario = Doctrine_Core::getTable('Inventario')->findOneBy('id', $id))) {
    $cantidad=0;
  } else {
    $cantidad=$inventario->getCantidad();
  }
?>

<label for="">Cant Act.</label>
<input type="text" value="<?php echo $cantidad; ?>" class="form-control qty_max" id="qty_act_<?php echo $num;?>" readonly="">