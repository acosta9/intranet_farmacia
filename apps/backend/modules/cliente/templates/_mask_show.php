<div class="col-md-6">
  <div class="form-group">
    <label>EMPRESA</label>
    <input type="text" value="<?php echo $form->getObject()->get('Empresa') ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <label>CODIGO</label>
    <input type="text" value="<?php echo $form->getObject()->get('id') ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-3"></div>
<div class="col-md-6">
  <div class="form-group">
    <label>NOMBRE</label>
    <input type="text" value="<?php echo $form->getObject()->get('full_name') ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <label>RIF/CI</label>
    <input type="text" value="<?php echo $form->getObject()->get('doc_id') ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <label>ESTATUS</label>
    <input type="text" value="<?php echo $cliente->getEstatusTxt() ?>" class="form-control <?php if($cliente->getActivo()==0){echo "anuladoo";}?>" readonly="">
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <label>TELEFONO (1)</label>
    <input type="text" value="<?php echo $form->getObject()->get('telf') ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <label>TELEFONO (2)</label>
    <input type="text" value="<?php echo $form->getObject()->get('celular') ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-6">
  <div class="form-group">
    <label>CORREO ELECTRONICO</label>
    <input type="text" value="<?php echo $form->getObject()->get('email') ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <label>SICM</label>
    <input type="text" value="<?php echo $form->getObject()->get('sicm') ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <label>ZONA</label>
    <input type="text" value="<?php echo str_replace("_", " ",$form->getObject()->get('zona')) ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <label>TIPO PRECIO</label>
    <input type="text" value="<?php echo $form->getObject()->get('TipoDePrecio') ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <label>DIAS CREDITO</label>
    <input type="text" value="<?php echo $form->getObject()->get('dias_credito') ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-6">
  <div class="form-group">
    <label>DIRECCION</label>
    <textarea class="form-control" readonly=""><?php echo $form->getObject()->get('direccion') ?></textarea>
  </div>
</div>
<div class="col-md-6">
  <div class="form-group">
    <label>DESCRIPCION</label>
    <textarea class="form-control" readonly=""><?php echo $form->getObject()->get('descripcion') ?></textarea>
  </div>
</div>
</div></div></div></div>
<div class="card card-primary" id="sf_fieldset_detalles">
  <div class="card-header">
    <h3 class="card-title">comisiones</h3>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label>VENDEDOR 01</label>
          <input type="text" value="<?php echo strtoupper($form->getObject()->get('User')) ?>" class="form-control" readonly="">
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label>VENDEDOR 01(%)</label>
          <input type="text" value="<?php echo strtoupper($form->getObject()->get('vendedor_01_profit')) ?>" class="form-control" readonly="">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>VENDEDOR 02</label>
          <input type="text" value="<?php echo strtoupper($form->getObject()->get('User2')) ?>" class="form-control" readonly="">
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label>VENDEDOR 02 (%)</label>
          <input type="text" value="<?php echo strtoupper($form->getObject()->get('vendedor_02_profit')) ?>" class="form-control" readonly="">
        </div>
      </div>
    </div>
  </div>
</div>
<div><div><div><div>
