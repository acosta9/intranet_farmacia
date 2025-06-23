<style>
.dropdown-item {
    color: #212529 !important;
}
</style>
<?php if ($form['ncontrol']) : ?>
  <?php echo $form['ncontrol']->render(array('readonly' => 'readonly', 'type' => 'hidden'))?>
<?php endif;?>
<?php if ($form['num_factura']) : ?>
  <?php echo $form['num_factura']->render(array('readonly' => 'readonly', 'type' => 'hidden'))?>
<?php endif;?>
<div class="col-md-6">
  <div class="form-group">
    <?php echo $form['empresa_id']->renderLabel()?>
    <select name="factura[empresa_id]" class="form-control" id="factura_empresa_id">
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
    <select name="factura[deposito_id]" class="form-control" id="factura_deposito_id">
    </select>
  </div>
</div>
<div class="col-md-12">
  <div class="form-group" id="cliente_form">
    <?php echo $form['cliente_id']->renderLabel()?>
    <select name="factura[cliente_id]" class="form-control" id="factura_cliente_id" required>
    </select>
    <?php if ($form['cliente_id']->renderError())  { echo $form['cliente_id']->renderError(); } ?>
  </div>
</div>
<div id="campo_inv"></div>
<div class="col-md-2">
  <div class="form-group">
    <?php echo $form['fecha']->renderLabel()?>
    <input type="text" name="factura[fecha]" value="<?php $date2 = new DateTime(); echo $date2->format('Y-m-d'); ?>" class="form-control dateonly" id="factura_fecha" readonly="readonly">
    <?php if ($form['fecha']->renderError())  { echo $form['fecha']->renderError(); } ?>
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
    <?php echo $form['tasa_cambio']->render(array('class' =>'form-control money'))?>
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
  <input type="hidden" name="factura[id]" id="cod" class="form-control" readonly value="1"/>
<?php } else { ?>
  <input readonly type="hidden" name="factura[id]" id="factura_id" class="form-control" value="<?php echo $form->getObject()->getId() ?>"/>
<?php } ?>

<script src="/plugins/inputmask/jquery.inputmask.bundle.js"></script>

<?php if($sf_params->get('oc')=="1"): ?>
  <?php
    $orden_compra=Doctrine_Core::getTable('OrdenCompra')->findOneBy('id',$sf_params->get('id'));
  ?>
  <input readonly type="hidden" name="factura[orden_compra_id]" id="factura_orden_compra_id" class="form-control" value="<?php echo $orden_compra->getId(); ?>"/>
  <script type="text/javascript">
    $( document ).ready(function() {
      $("[data-mask]").inputmask();
      selectElement('factura_empresa_id', '11');
      $('#deposito_form').load('<?php echo url_for('factura/deposito') ?>?id='+<?php echo $orden_compra->getEmpresaId(); ?>).fadeIn("slow");
      $('#cliente_form').load('<?php echo url_for('factura/getClientes') ?>?id='+<?php echo $orden_compra->getEmpresaId(); ?>+'&cid=<?php echo $orden_compra->getClienteId(); ?>').fadeIn("slow");

      $("#factura_empresa_id").mousedown(function(e){
        e.preventDefault();
      });
      $("#factura_deposito_id").mousedown(function(e){
        e.preventDefault();
      });
    });
    function selectElement(id, valueToSelect) {    
      let element = document.getElementById(id);
      element.value = valueToSelect;
    }
  </script>
<?php else: ?>
  <script type="text/javascript">
    $( document ).ready(function() {
      $("[data-mask]").inputmask();
      $('#deposito_form').load('<?php echo url_for('factura/deposito') ?>?id='+$("#factura_empresa_id").val()).fadeIn("slow");
      $('#cliente_form').load('<?php echo url_for('factura/getClientes') ?>?id='+$("#factura_empresa_id").val()).fadeIn("slow");

      $("#factura_empresa_id").on('change', function(event){
        $('#cliente_form').load('<?php echo url_for('factura/getClientes') ?>?id='+this.value).fadeIn("slow");
        $('#deposito_form').load('<?php echo url_for('factura/deposito') ?>?id='+this.value).fadeIn("slow");
        $( "#item" ).empty();
      });
    });
  </script>
<?php endif; ?>
<script type="text/javascript">
  $(document).ready(function() {
    $('#loading').fadeOut( "slow", function() {});
  });
</script>
