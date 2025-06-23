<div class="col-md-6">
  <div class="form-group">
    <?php echo $form['empresa_id']->renderLabel()?>
    <select name="inv_ajuste[empresa_id]" class="form-control" id="inv_ajuste_empresa_id">
      <?php
        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
        $userid=$sf_user->getGuardUser()->getId();
        $eid=$ename["srvid"];
        $results = $q->execute("SELECT e.id as eid, e.nombre as nombre, e.acronimo as acronimo 
          FROM empresa as e
          LEFT JOIN empresa_user as eu ON e.id=eu.empresa_id
          WHERE eu.user_id=$userid && e.id IN ($eid)
          ORDER BY e.nombre ASC");
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
    <select name="inv_ajuste[deposito_id]" class="form-control" id="inv_ajuste_deposito_id">
    </select>
  </div>
</div>
<div class="col-md-12">
  <div class="form-group">
    <?php echo $form['descripcion']->renderLabel()?>
    <?php echo $form['descripcion']->render(array('class' => 'form-control'))?>
    <?php if ($form['descripcion']->renderError())  { echo $form['descripcion']->renderError(); } ?>
  </div>
</div>

<?php if($form->getObject()->isNew()) { ?>
  <input type="hidden" name="inv_ajuste[id]" id="cod" readonly value="1"/>
  <input type="hidden" name="inv_ajuste[total]" id="inv_ajuste_total" readonly value="1"/>
<?php } else { ?>
  <input type="hidden" name="inv_ajuste[id]" id="inv_ajuste_id" readonly value="<?php echo $form->getObject()->getId() ?>"/>
  <input type="hidden" name="inv_ajuste[total]" id="inv_ajuste_total" readonly value="<?php echo $form->getObject()->getTotal() ?>"/>
<?php } ?>
<?php if ($form['id']->renderError())  { echo $form['id']->renderError(); } ?>

<script type="text/javascript">
  $(document).ready(function() {
    $('#deposito_form').load('<?php echo url_for('inv_ajuste/deposito') ?>?id='+$("#inv_ajuste_empresa_id").val()).fadeIn("slow");
    $('#inv_ajuste_empresa_id').change(function(){
      $('#deposito_form').load('<?php echo url_for('inv_ajuste/deposito') ?>?id='+this.value).fadeIn("slow");
      $( "#item" ).empty();
    });
  });
</script>
