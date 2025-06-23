<div class="col-md-4">
  <div class="form-group">
    <label>CODIGO</label>
    <input type="text" value="<?php echo $form->getObject()->get('id') ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-8"></div>
<div class="col-md-3">
  <div class="form-group">
    <label>EMPRESA</label>
    <input type="text" value="<?php echo $form->getObject()->get('Empresa') ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <label>DEPOSITO</label>
    <input type="text" value="<?php echo $form->getObject()->get('InvDeposito') ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-6">
  <div class="form-group">
    <label>PRODUCTO</label>
    <?php $producto=Doctrine_Core::getTable('Producto')->findOneBy('id', $inventario["producto_id"]); ?>
    <input type="text" value="<?php echo $producto->getNombre()." [".$producto->getSerial()."]"; ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <label>ESTATUS</label>
    <input type="text" value="<?php echo $form->getObject()->get('Estatus') ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <label>TOTAL DISPONIBLE</label>
    <input type="text" value="<?php echo $form->getObject()->get('cantidad') ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <label>ALERTA MINIMO STOCK</label>
    <input type="text" value="<?php echo $form->getObject()->get('limite_stock') ?>" class="form-control" readonly="">
  </div>
</div>

<?php if ($form['inventario_det']): ?>
  </div></div></div></div>
  <?php
    $results = Doctrine_Core::getTable('InventarioDet')
      ->createQuery('a')
      ->where('inventario_id=?', $form->getObject()->get('id'))
      ->orderBy("id DESC")
      ->limit(10)
      ->execute();
      $num=0;
    foreach ($results as $result) {
      $num+=1;
    }
    foreach ($results as $result):
?>
<div class="card card-primary" id="sf_fieldset_detalles_<?php echo $num?>">
  <div class="card-header">
    <h3 class="card-title">LOTE #<?php echo $num; $num--;?></h3>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <label>FECHA DE INGRESO</label>
          <input type="text" value="<?php echo strtoupper(format_datetime($result->getCreatedAt(), 'f', 'es_ES')) ?>" class="form-control" readonly="">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>CODIGO LOTE</label>
          <input type="text" value="<?php echo $result->getLote() ?>" class="form-control" readonly="">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>FECHA DE VENCIMIENTO</label>
          <input type="text" value="<?php echo strtoupper(format_datetime($result->getFechaVenc(), 'D', 'es_ES')) ?>" class="form-control" readonly="">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>CANTIDAD</label>
          <input type="text" value="<?php echo $result->getCantidad() ?>" class="form-control" readonly="">
        </div>
      </div>
    </div>
  </div>
</div>
<?php endforeach; ?>
<div><div><div><div>
<?php endif; ?>

<div class="row no-print">
<?php 
if($form->getObject()->get('activo')) {
  $class="btn-danger";
  $estatus="Des-Habilitar";
  $icon="fa-minus-circle";
} else {  
  $class="btn-success";
  $estatus="habilitar";
  $icon="fa-check";
}
?>
  <div class="col-12">
    <button onclick="estatus()" class="btn <?php echo $class; ?> float-right" style="margin-right: 5px;">
      <i class="fas <?php echo $icon; ?>"></i> <?php echo " ".$estatus; ?>
    </button>
  </div>
</div>
  <br/><br/>
<script>
  function estatus() {
    var retVal = confirm("¿Estas seguro de cambiar el estatus del producto en inventario?");
    if( retVal == true ){
        location.href = "<?php echo url_for("inventario")."/estatus?id=".$form->getObject()->get('id')?>";
    }else{
     return false;
    }
  }
</script>