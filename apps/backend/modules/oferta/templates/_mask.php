<div class="col-md-3 col-sm-12">
  <div class="form-group">
    <label class="col-sm-12 control-label">Tipo de Tasa</label>
    <div class="col-sm-12">
      <?php echo $form['tasa']->render(); ?>
      <?php if ($form['tasa']->renderError())  { echo $form['tasa']->renderError(); } ?>
    </div>
  </div>
</div>
<div class="col-md-3 col-sm-12">
  <div class="form-group">
    <label>Tasa</label>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">BS</span>
      </div>
      <input class="form-control" type="text" id="tasa" readonly>
    </div>
  </div>
</div>
<div class="col-md-3 col-sm-12"></div>
<div class="col-md-3 col-sm-12">
  <div class="form-group">
    <label class="col-sm-12 control-label">Tipo de Oferta</label>
    <div class="col-sm-12">
      <?php echo $form['tipo_oferta']->render(); ?>
      <?php if ($form['tipo_oferta']->renderError())  { echo $form['tipo_oferta']->renderError(); } ?>
    </div>
  </div>
</div>
<div class="col-md-3 col-sm-12" id="qty" style="display:none">
  <div class="form-group">
    <label class="col-sm-12 control-label">Cantidad</label>
    <div class="col-sm-12">
      <?php echo $form['qty']->render(array('class' => 'form-control onlyinteger')); ?>
      <?php if ($form['qty']->renderError())  { echo $form['qty']->renderError(); } ?>
    </div>
  </div>
</div>
<div class="col-md-3 col-sm-12">
  <div class="form-group">
    <label>Precio USD</label>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">USD</span>
      </div>
      <?php echo $form['precio_usd']->render(); ?>
      <?php if ($form['precio_usd']->renderError())  { echo $form['precio_usd']->renderError(); } ?>
    </div>
  </div>
</div>
<div class="col-md-3 col-sm-12">
  <div class="form-group">
    <label>Precio BS</label>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">BS</span>
      </div>
      <input class="form-control" type="text" id="precio_bs" readonly>
    </div>
  </div>
</div>
<div class="col-md-6">
  <div class="form-group">
    <label for="oferta_descripcion">Descripcion</label>
    <?php echo $form['descripcion']->render(array('class' => 'form-control'))?>
  </div>
</div>
<?php if($form->getObject()->isNew()) { ?>
  <input type="hidden" name="oferta[id]" id="cod" readonly value="1"/>
  <input type="hidden" name="oferta[ncontrol]" id="cod2" readonly value="1"/>
<?php } else { ?>
  <input readonly type="hidden" name="oferta[id]" id="oferta_id" value="<?php echo $form->getObject()->getId() ?>"/>
  <input readonly type="hidden" name="oferta[ncontrol]" id="oferta_ncontrol" value="<?php echo $form->getObject()->getNcontrol() ?>"/>
<?php } ?>
</div></div></div>
<div class="card card-primary" id="sf_fieldset_img_principal">
  <div class="card-header">
    <h3 class="card-title">Imagen Principal</h3>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <div class="col-sm-12 control-label pl-0">
            <label for="producto_url_imagen">Imagen</label>
          </div>
          <div class="col-sm-12 foto2 pl-0">
            <?php echo $form['url_imagen']->render(array('class' => 'url_imagen form-control'))?>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="producto_url_imagen_desc">Descripcion</label>
          <?php echo $form['url_imagen_desc']->render(array('class' => 'form-control'))?>
        </div>
      </div>
    </div>
  </div>
</div>
<div><div><div>

<script type="text/javascript">
  $(document).ready(function() {
    $('#deposito_form').load('<?php echo url_for('oferta/deposito') ?>?id='+$("#oferta_empresa_id").val()).fadeIn("slow");
    var json_obj = JSON.parse(Get("<?php echo url_for("oferta");?>/tasa?id="+$("#oferta_empresa_id").val()+'&t='+$("#oferta_tasa").val()));
    $('#tasa').val(json_obj);
    sumar();
  });
  $('#oferta_empresa_id').change(function(){
    $('#deposito_form').load('<?php echo url_for('oferta/deposito') ?>?id='+this.value).fadeIn("slow");
    var json_obj = JSON.parse(Get("<?php echo url_for("oferta");?>/tasa?id="+$("#oferta_empresa_id").val()+'&t='+$("#oferta_tasa").val()));
    $('#tasa').val(json_obj);
    sumar();
  });
  $('#oferta_tasa').change(function(){
    var json_obj = JSON.parse(Get("<?php echo url_for("oferta");?>/tasa?id="+$("#oferta_empresa_id").val()+'&t='+$("#oferta_tasa").val()));
    $('#tasa').val(json_obj);
    sumar();
  });
  $('#oferta_tipo_oferta').change(function(){
    var tipo = this.value;
    if(tipo==2) {
      $("#qty").show();
      $("#oferta_qty").val("2");
      $("#oferta_qty").prop( "readonly", false );
    } else {
      $("#qty").hide();
      $("#oferta_qty").val("1");
      $("#oferta_qty").prop( "readonly", true );
    }
  });
</script>
