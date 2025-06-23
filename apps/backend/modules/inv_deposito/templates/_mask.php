<div class="col-md-3 col-sm-12">
  <div class="form-group">
    <label class="col-sm-12 control-label">Codigo</label>
    <div class="col-sm-12">
      <?php if($form->getObject()->isNew()) { ?>
        <input type="number" name="inv_deposito[id]" id="cod" class="form-control" min="1" readonly/>
      <?php } else { ?>
        <input readonly type="number" name="inv_deposito[id]" id="inv_deposito_id" class="form-control" min="1" value="<?php echo $form->getObject()->getId() ?>"/>
      <?php } ?>
      <?php if ($form['id']->renderError())  { echo $form['id']->renderError(); } ?>
    </div>
  </div>
</div>
<?php if($form->getObject()->isNew()) { ?>
  <div class="col-md-3">
    <div class="form-group">
      <?php echo $form['empresa_id']->renderLabel()?>
      <select name="inv_deposito[empresa_id]" class="form-control" id="inv_deposito_empresa_id">
        <?php
          $results = Doctrine_Query::create()
            ->select('e.id as eid, e.nombre as nombre, eu.user_id')
            ->from('Empresa e')
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
<?php } else { ?>
  <div class="col-md-3">
    <div class="form-group">
      <?php echo $form['empresa_id']->renderLabel()?>
      <?php $dep=Doctrine_Core::getTable('InvDeposito')->findOneBy('id',$form->getObject()->getId()); ?>
      <select name="inv_deposito[empresa_id]" class="form-control" id="inv_deposito_empresa_id">
        <option value="<?php echo $dep->getEmpresaId(); ?>"><?php echo $dep->getEmpresa(); ?><option>
      </select>
    </div>
  </div>
<?php } ?>

<script type="text/javascript">
  $(document).ready(function() {
    GetCodigo();
    $('#loading').fadeOut( "slow", function() {});
    $('#inv_deposito_empresa_id').change(function(){
      GetCodigo();
    });
    <?php if(!$form->getObject()->isNew()) { ?>
      $("#inv_deposito_empresa_id").mousedown(function(e){
        e.preventDefault();
      });
    <?php } ?>
    $( "form" ).submit(function( event ) {
      $('#loading').fadeIn( "slow", function() {});
    });
  });

  function GetCodigo() {
    var empresa_id = $("#inv_deposito_empresa_id" ).val();
    $.get("<?php echo url_for('inv_deposito/contador') ?>?id="+empresa_id, function(contador) {
      $("#cod" ).val(contador);
    });
  }
</script>
