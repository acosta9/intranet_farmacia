<div class="col-md-3 col-sm-12">
  <div class="form-group">
    <label class="col-sm-12 control-label">Codigo</label>
    <div class="col-sm-12">
      <?php if($form->getObject()->isNew()) { ?>
        <input type="number" min="1" name="inventario[id]" id="cod" class="form-control" readonly/>
      <?php } else { ?>
        <input readonly type="number" name="inventario[id]" id="inventario_id" class="form-control" min="1" value="<?php echo $form->getObject()->getId() ?>"/>
      <?php } ?>
      <?php if ($form['id']->renderError())  { echo $form['id']->renderError(); } ?>
    </div>
  </div>
</div>
<div class="col-md-9"></div>
