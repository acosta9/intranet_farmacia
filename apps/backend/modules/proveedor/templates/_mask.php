<?php if($form->getObject()->isNew()) { ?>
  <div class="col-md-1 col-sm-1" style="display: none;">
    <input type="hidden" name="proveedor[id]" id="cod" class="form-control" readonly value="1"/>
  </div>
<?php } else {?>
<div class="col-md-3 col-sm-12">
  <div class="form-group">
    <label class="col-sm-12 control-label">Codigo</label>
    <div class="col-sm-12">
      <input readonly type="number" name="proveedor[id]" id="proveedor_id" class="form-control" min="1" value="<?php echo $form->getObject()->getId() ?>"/>
      <?php if ($form['id']->renderError())  { echo $form['id']->renderError(); } ?>
    </div>
  </div>
</div>
<div class="col-md-3"></div>
<?php } ?>
<div class="col-md-6">
  <div class="form-group">
    <?php echo $form['full_name']->renderLabel()?>
    <?php echo $form['full_name']->render(array('class' => 'form-control'))?>
    <?php if ($form['full_name']->renderError())  { echo $form['full_name']->renderError(); } ?>
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <?php echo $form['doc_id']->renderLabel()?>
    <?php echo $form['doc_id']->render(array('class' => 'form-control docid'))?>
    <?php if ($form['doc_id']->renderError())  { echo $form['doc_id']->renderError(); } ?>
  </div>
</div>
<div class="col-md-2">
  <div class="form-group">
    <label for="proveedor_tipo">TIPO DE PROVEEDOR</label>
    <?php echo $form['tipo']->render(array('class' => 'form-control'))?>
    <?php if ($form['tipo']->renderError())  { echo $form['tipo']->renderError(); } ?>
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <?php echo $form['telf']->renderLabel()?>
    <?php echo $form['telf']->render(array('class' => 'form-control celphone'))?>
    <?php if ($form['telf']->renderError())  { echo $form['telf']->renderError(); } ?>
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <?php echo $form['celular']->renderLabel()?>
    <?php echo $form['celular']->render(array('class' => 'form-control celphone'))?>
    <?php if ($form['celular']->renderError())  { echo $form['celular']->renderError(); } ?>
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <?php echo $form['email']->renderLabel()?>
    <?php echo $form['email']->render(array('class' => 'form-control'))?>
    <?php if ($form['email']->renderError())  { echo $form['email']->renderError(); } ?>
  </div>
</div>
<div class="col-md-6">
  <div class="form-group">
    <?php echo $form['direccion']->renderLabel()?>
    <?php echo $form['direccion']->render(array('class' => 'form-control'))?>
    <?php if ($form['direccion']->renderError())  { echo $form['direccion']->renderError(); } ?>
  </div>
</div>
<div class="col-md-6">
  <div class="form-group">
    <?php echo $form['descripcion']->renderLabel()?>
    <?php echo $form['descripcion']->render(array('class' => 'form-control'))?>
    <?php if ($form['descripcion']->renderError())  { echo $form['descripcion']->renderError(); } ?>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    <?php if(!$form->getObject()->isNew()){ ?>
      $("#proveedor_empresa_id").mousedown(function(e){
        e.preventDefault();
      });
    <?php } ?>
    $('#loading').fadeOut( "slow", function() {});

    $( "form" ).submit(function( event ) {
      $('#loading').fadeIn( "slow", function() {});
    });
  });
</script>
