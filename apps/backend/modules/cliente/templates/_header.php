<div class="col-md-6">
  <div class="form-group">
    <?php echo $form['empresa_id']->renderLabel()?>
    <select name="cliente[empresa_id]" class="form-control" id="cliente_empresa_id">
      <?php
        $results = Doctrine_Query::create()
          ->select('e.id, e.nombre, eu.user_id')
          ->from('Empresa e')
          ->leftJoin('e.EmpresaUser eu')
          ->where('eu.user_id = ?', $sf_user->getGuardUser()->getId())
          ->orderBy('e.nombre ASC')
          ->execute();
        foreach ($results as $result) {
          echo "<option value='".$result->getId()."'>".$result->getNombre()."</option>";
        }
      ?>
    </select>
  </div>
</div>
<?php if($form->getObject()->isNew()) { ?>
  <div class="col-md-6 col-sm-12">
    <input type="hidden" name="cliente[id]" id="cod" class="form-control" readonly value="1"/>
  </div>
<?php } else {?>
<div class="col-md-3 col-sm-12">
  <div class="form-group">
    <label class="col-sm-12 control-label">Codigo</label>
    <div class="col-sm-12">
      <input readonly type="number" name="cliente[id]" id="cliente_id" class="form-control" min="1" value="<?php echo $form->getObject()->getId() ?>"/>
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
<div class="col-md-3">
  <div class="form-group">
    <?php echo $form['doc_id']->renderLabel()?>
    <?php echo $form['doc_id']->render(array('class' => 'form-control'))?>
    <?php if ($form['doc_id']->renderError())  { echo $form['doc_id']->renderError(); } ?>
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <?php echo $form['activo']->renderLabel()?>
    <?php echo $form['activo']->render(array('class' => 'form-control'))?>
    <?php if ($form['activo']->renderError())  { echo $form['activo']->renderError(); } ?>
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <?php echo $form['telf']->renderLabel()?>
    <?php echo $form['telf']->render(array('class' => 'form-control'))?>
    <?php if ($form['telf']->renderError())  { echo $form['telf']->renderError(); } ?>
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <?php echo $form['celular']->renderLabel()?>
    <?php echo $form['celular']->render(array('class' => 'form-control'))?>
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
<div class="col-md-3">
  <div class="form-group">
    <?php echo $form['sicm']->renderLabel()?>
    <?php echo $form['sicm']->render(array('class' => 'form-control'))?>
    <?php if ($form['sicm']->renderError())  { echo $form['sicm']->renderError(); } ?>
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <?php echo $form['zona']->renderLabel()?>
    <?php echo $form['zona']->render(array('class' => 'form-control'))?>
    <?php if ($form['zona']->renderError())  { echo $form['zona']->renderError(); } ?>
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <?php echo $form['tipo_precio']->renderLabel()?>
    <?php echo $form['tipo_precio']->render(array('class' => 'form-control'))?>
    <?php if ($form['tipo_precio']->renderError())  { echo $form['tipo_precio']->renderError(); } ?>
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <?php echo $form['dias_credito']->renderLabel()?>
    <?php echo $form['dias_credito']->render(array('class' => 'form-control'))?>
    <?php if ($form['dias_credito']->renderError())  { echo $form['dias_credito']->renderError(); } ?>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    <?php if(!$form->getObject()->isNew()){ ?>
      $("#cliente_empresa_id").mousedown(function(e){
        e.preventDefault();
      });
    <?php } ?>
  });
  function GetCodigo() {
    var empresa_id = $("#cliente_empresa_id" ).val();
    $.get("<?php echo url_for('cliente/contador') ?>?id="+empresa_id, function(contador) {
      $("#cod" ).val(contador);
    });
  }
</script>
