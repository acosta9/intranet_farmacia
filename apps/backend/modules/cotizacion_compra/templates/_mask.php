<div class="col-md-6">
  <div class="form-group">
    <?php echo $form['empresa_id']->renderLabel()?>
    <select name="cotizacion_compra[empresa_id]" class="form-control" id="cotizacion_compra_empresa_id">
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
<div class="col-md-8">
  <div class="form-group" id="proveedor_form">
    <?php echo $form['proveedor_id']->renderLabel()?>
    <select name="cotizacion_compra[proveedor_id]" class="form-control" id="cotizacion_compra_proveedor_id" required>
    </select>
    <?php if ($form['proveedor_id']->renderError())  { echo $form['proveedor_id']->renderError(); } ?>
  </div>
</div>
<div class="col-md-2">
  <div class="form-group">
    <?php echo $form['dias_credito']->renderLabel()?>
    <?php echo $form['dias_credito']->render(array("value" => "0", "class" => "form-control diascredito"))?>
    <?php if ($form['dias_credito']->renderError())  { echo $form['dias_credito']->renderError(); } ?>
  </div>
</div>
<div class="col-md-2">
  <div class="form-group">
    <?php echo $form['tasa_cambio']->renderLabel()?>
    <?php echo $form['tasa_cambio']->render(array('class' =>'form-control money'))?>
    <?php if ($form['tasa_cambio']->renderError())  { echo $form['tasa_cambio']->renderError(); } ?>
  </div>
</div>
<?php if($form->getObject()->isNew()) { ?>
  <input type="hidden" name="cotizacion_compra[id]" id="cod" class="form-control" readonly value="1"/>
<?php } else { ?>
  <input readonly type="hidden" name="cotizacion_compra[id]" id="cotizacion_compra_id" class="form-control" value="<?php echo $form->getObject()->getId() ?>"/>
<?php } ?>

<script type="text/javascript">
  $( document ).ready(function() {
    $('#proveedor_form').load('<?php echo url_for('cotizacion_compra/getProveedores') ?>?id='+$("#cotizacion_compra_empresa_id").val()).fadeIn("slow");

    $("#cotizacion_compra_empresa_id").on('change', function(event){
      $('#proveedor_form').load('<?php echo url_for('cotizacion_compra/getProveedores') ?>?id='+this.value).fadeIn("slow");
    });
  });
</script>