<div class="col-md-6">
  <div class="form-group">
    <?php echo $form['empresa_id']->renderLabel()?>
    <select name="factura_gastos[empresa_id]" class="form-control" id="factura_gastos_empresa_id">
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
  <div class="form-group" id="proveedor_form">
    <?php echo $form['proveedor_id']->renderLabel()?>
    <select name="factura_gastos[proveedor_id]" class="form-control" id="factura_gastos_proveedor_id" required>
    </select>
    <?php if ($form['proveedor_id']->renderError())  { echo $form['proveedor_id']->renderError(); } ?>
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <label for="factura_gastos_gastos_tipo_id">Tipo de gasto</label>
    <?php echo $form['gastos_tipo_id']->render(array("class" => "form-control"))?>
  </div>
</div>
<div class="col-md-2">
  <div class="form-group">
    <label for="factura_gastos_libro_compras">Libro de compras</label>
    <?php echo $form['libro_compras']->render(array("class" => "form-control"))?>
  </div>
</div>
<div class="col-md-2">
  <div class="form-group">
    <label for="factura_gastos_tipo">Tipo de Factura</label>
    <?php echo $form['tipo']->render(array("class" => "form-control"))?>
  </div>
</div>
<div class="col-md-2">
  <div class="form-group">
    <label for="factura_gastos_num_factura">N° de Factura</label>
    <?php echo $form['num_factura']->render(array("class" => "form-control"))?>
    <?php if ($form['num_factura']->renderError())  { echo $form['num_factura']->renderError(); } ?>
  </div>
</div>
<div class="col-md-2">
  <div class="form-group">
    <label for="factura_gastos_ncontrol">N° de Control</label>
    <?php echo $form['ncontrol']->render(array("class" => "form-control"))?>
    <?php if ($form['ncontrol']->renderError())  { echo $form['ncontrol']->renderError(); } ?>
  </div>
</div>
<div class="col-md-2">
  <div class="form-group">
    <label for="factura_gastos_fecha">Fecha de Emisión</label>
    <input type="text" name="factura_gastos[fecha]" value="<?php $date2 = new DateTime(); echo $date2->format('Y-m-d'); ?>" class="form-control dateonly" id="factura_gastos_fecha" readonly="readonly">
  </div>
</div>
<div class="col-md-2">
  <div class="form-group">
    <label for="factura_gastos_fecha">Fecha de Recepción</label>
    <input type="text" name="factura_gastos[fecha_recepcion]" value="<?php echo $date2->format('Y-m-d'); ?>" class="form-control dateonly" id="factura_gastos_fecha_recepcion" readonly="readonly">
  </div>
</div>
<div class="col-md-2">
  <div class="form-group">
    <label for="factura_gastos_num_factura">Dias Credito</label>
    <?php echo $form['dias_credito']->render(array("class" => "form-control diascredito", "value" => "0"))?>
    <?php if ($form['dias_credito']->renderError())  { echo $form['dias_credito']->renderError(); } ?>
  </div>
</div>
<div class="col-md-2">
  <div class="form-group">
    <label for="factura_gastos_tasa_cambio">Tasa cambio</label>
    <?php echo $form['tasa_cambio']->render(array('class' =>'form-control money'))?>
    <?php if ($form['tasa_cambio']->renderError())  { echo $form['tasa_cambio']->renderError(); } ?>
  </div>
</div>
<?php if($form->getObject()->isNew()) { ?>
  <input type="hidden" name="factura_gastos[id]" id="cod" class="form-control" readonly value="1"/>
<?php } else { ?>
  <input readonly type="hidden" name="factura_gastos[id]" id="factura_gastos_id" class="form-control" value="<?php echo $form->getObject()->getId() ?>"/>
<?php } ?>

<script type="text/javascript">
  $( document ).ready(function() {
    $("#factura_gastos_gastos_tipo_id").select2({ width: '100%' });
    $('#proveedor_form').load('<?php echo url_for('factura_gastos/getProveedores') ?>?id='+$("#factura_gastos_empresa_id").val()).fadeIn("slow");

    $("#factura_gastos_empresa_id").on('change', function(event){
      $('#proveedor_form').load('<?php echo url_for('factura_gastos/getProveedores') ?>?id='+this.value).fadeIn("slow");
    });
  });
</script>