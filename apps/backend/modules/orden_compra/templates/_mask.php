<?php if ($form['ncontrol']) : ?>
  <?php echo $form['ncontrol']->render(array('readonly' => 'readonly', 'type' => 'hidden'))?>
  <input type="hidden" name="orden_compra[orden_compra_estatus_id]" readonly="readonly" id="orden_compra_orden_compra_estatus_id">
<?php endif;?>
<div class="col-md-6">
  <div class="form-group">
    <?php echo $form['empresa_id']->renderLabel()?>
    <select name="orden_compra[empresa_id]" class="form-control" id="orden_compra_empresa_id">
      <?php
        $results = Doctrine_Query::create()
          ->select('sc.id as scid, e.id as eid, e.nombre as nombre, eu.user_id')
          ->from('ServerConf sc')
          ->leftJoin('sc.Empresa e')
          ->leftJoin('e.EmpresaUser eu')
          ->where('eu.user_id = ?', $sf_user->getGuardUser()->getId())
          ->orderBy('e.nombre ASC')
          ->execute();
        foreach ($results as $result) {
          echo "<option value='".$result["eid"]."'>".$result["nombre"]."</option>";
        }
      ?>
    </select>
  </div>
</div>
<div class="col-md-6">
  <div class="form-group" id="deposito_form">
    <?php echo $form['deposito_id']->renderLabel()?>
    <select name="orden_compra[deposito_id]" class="form-control" id="orden_compra_deposito_id">
    </select>
  </div>
</div>
<div class="col-md-12">
  <div class="form-group" id="cliente_form">
    <?php echo $form['cliente_id']->renderLabel()?>
    <select name="orden_compra[cliente_id]" class="form-control" id="orden_compra_cliente_id" required>
    </select>
    <?php if ($form['cliente_id']->renderError())  { echo $form['cliente_id']->renderError(); } ?>
  </div>
</div>
<div id="campo_inv"></div>
<div class="col-md-2">
  <div class="form-group">
    <?php echo $form['tasa_cambio']->renderLabel()?>
    <?php echo $form['tasa_cambio']->render(array('class' =>'form-control number'))?>
    <?php if ($form['tasa_cambio']->renderError())  { echo $form['tasa_cambio']->renderError(); } ?>
  </div>
</div>
<?php if($form->getObject()->isNew()) { ?>
  <input type="hidden" name="orden_compra[id]" id="cod" class="form-control" readonly value="1"/>
<?php } else { ?>
  <input readonly type="hidden" name="orden_compra[id]" id="orden_compra_id" class="form-control" value="<?php echo $form->getObject()->getId() ?>"/>
<?php } ?>

<script type="text/javascript">
  $( document ).ready(function() {
    $('#loading').fadeOut( "slow", function() {}); 
    
    $('#deposito_form').load('<?php echo url_for('orden_compra/deposito') ?>?id='+$("#orden_compra_empresa_id").val()).fadeIn("slow");
    $('#cliente_form').load('<?php echo url_for('orden_compra/getClientes') ?>?id='+$("#orden_compra_empresa_id").val()).fadeIn("slow");

    $("#orden_compra_empresa_id").on('change', function(event){
      $('#cliente_form').load('<?php echo url_for('orden_compra/getClientes') ?>?id='+this.value).fadeIn("slow");
      $('#deposito_form').load('<?php echo url_for('orden_compra/deposito') ?>?id='+this.value).fadeIn("slow");
      $( "#item" ).empty();
      $("#orden_compra_total").val("0.00");
    });
  });
</script>
