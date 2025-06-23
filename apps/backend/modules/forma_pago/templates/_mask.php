<div class="col-md-3 col-sm-12">
  <div class="form-group">
    <label class="col-sm-12 control-label">Codigo</label>
    <div class="col-sm-12">
      <?php if($form->getObject()->isNew()) { ?>
        <?php echo $form['id']->render() ?>
      <?php } else { ?>
        <input readonly type="text" name="forma_pago[id]" id="forma_pago_id" class="form-control number3" value="<?php echo $form->getObject()->getId() ?>"/>
      <?php } ?>
      <?php if ($form['id']->renderError())  { echo $form['id']->renderError(); } ?>
    </div>
  </div>
</div>
<div class="col-md-9"></div>
<script type="text/javascript">
  $(document).ready(function() {
    <?php if(!$form->getObject()->isNew()) { ?>
      $("#forma_pago_moneda").mousedown(function(e){
        e.preventDefault();
      });
      $("#forma_pago_nombre").prop('readonly', 'readonly');
      $("#forma_pago_acronimo").prop('readonly', 'readonly');
    <?php } ?>
  });
</script>
