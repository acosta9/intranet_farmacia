<?php $pd=Doctrine_Core::getTable('Producto')->findOneBy('id',$sf_params->get('id')); ?>

<input value="<?php echo $pd->getNombre()." [".$pd->getSerial()."]";?>" type="text" readonly="readonly" id="traslado_traslado_det_1_producto_name" class="form-control det_producto">
