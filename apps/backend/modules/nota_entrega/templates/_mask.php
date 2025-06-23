<style>
.dropdown-item {
    color: #212529 !important;
}
</style>
<?php if ($form['ncontrol']) : ?>
  <?php echo $form['ncontrol']->render(array('readonly' => 'readonly', 'type' => 'hidden'))?>
<?php endif;?>
<div class="col-md-6">
  <div class="form-group">
    <?php echo $form['empresa_id']->renderLabel()?>
    <select name="nota_entrega[empresa_id]" class="form-control" id="nota_entrega_empresa_id">
      <?php
        $results = Doctrine_Query::create()
          ->select('sc.id as scid, e.id as eid, e.nombre as nombre, eu.user_id')
          ->from('ServerConf sc')
          ->leftJoin('sc.Empresa e')
          ->leftJoin('e.EmpresaUser eu')
          ->where('eu.user_id = ?', $sf_user->getGuardUser()->getId())
          ->orderBy('e.nombre ASC')
          ->groupBy('e.nombre')
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
    <select name="nota_entrega[deposito_id]" class="form-control" id="nota_entrega_deposito_id">
    </select>
  </div>
</div>
<div class="col-md-12">
  <div class="form-group" id="cliente_form">
    <?php echo $form['cliente_id']->renderLabel()?>
    <select name="nota_entrega[cliente_id]" class="form-control" id="nota_entrega_cliente_id" required>
    </select>
    <?php if ($form['cliente_id']->renderError())  { echo $form['cliente_id']->renderError(); } ?>
  </div>
</div>
<div id="campo_inv"></div>
<div class="col-md-2">
  <div class="form-group">
    <?php echo $form['fecha']->renderLabel()?>
    <input type="text" name="nota_entrega[fecha]" value="<?php $date2 = new DateTime(); echo $date2->format('Y-m-d'); ?>" class="form-control dateonly" id="nota_entrega_fecha" readonly="readonly">
  </div>
</div>
<div class="col-md-2">
  <div class="form-group">
    <?php echo $form['dias_credito']->renderLabel()?>
    <?php echo $form['dias_credito']->render()?>
    <?php if ($form['dias_credito']->renderError())  { echo $form['dias_credito']->renderError(); } ?>
  </div>
</div>
<div class="col-md-2">
  <div class="form-group">
    <?php echo $form['tasa_cambio']->renderLabel()?>
    <?php echo $form['tasa_cambio']->render(array('class' =>'form-control number'))?>
    <?php if ($form['tasa_cambio']->renderError())  { echo $form['tasa_cambio']->renderError(); } ?>
  </div>
</div>
<div class="col-md-6">
  <div class="form-group">
    <?php echo $form['direccion_entrega']->renderLabel()?>
    <?php echo $form['direccion_entrega']->render(array('class' => 'form-control'))?>
    <?php if ($form['direccion_entrega']->renderError())  { echo $form['direccion_entrega']->renderError(); } ?>
  </div>
</div>
<?php if($form->getObject()->isNew()) { ?>
  <input type="hidden" name="nota_entrega[id]" id="cod" class="form-control" readonly value="1"/>
<?php } else { ?>
  <input readonly type="hidden" name="nota_entrega[id]" id="nota_entrega_id" class="form-control" value="<?php echo $form->getObject()->getId() ?>"/>
<?php } ?>

<script src="/plugins/inputmask/jquery.inputmask.bundle.js"></script>
<script type="text/javascript">
  $( document ).ready(function() {
    $('#loading').fadeOut( "slow", function() {});
    $("[data-mask]").inputmask();
    $('#deposito_form').load('<?php echo url_for('nota_entrega/deposito') ?>?id='+$("#nota_entrega_empresa_id").val()).fadeIn("slow");
    $('#cliente_form').load('<?php echo url_for('nota_entrega/getClientes') ?>?id='+$("#nota_entrega_empresa_id").val()).fadeIn("slow");

    $("#nota_entrega_empresa_id").on('change', function(event){
      $('#cliente_form').load('<?php echo url_for('nota_entrega/getClientes') ?>?id='+this.value).fadeIn("slow");
      $('#deposito_form').load('<?php echo url_for('nota_entrega/deposito') ?>?id='+this.value).fadeIn("slow");
      $( "#item" ).empty();
    });
  });
</script>
