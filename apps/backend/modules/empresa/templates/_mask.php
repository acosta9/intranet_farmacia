<div class="col-md-3 col-sm-12">
  <div class="form-group">
    <label class="col-sm-12 control-label">Codigo</label>
    <div class="col-sm-12">
      <?php if($form->getObject()->isNew()) { ?>
        <input type="text" name="empresa[id]" id="empresa_id" class="form-control" required/>
      <?php } else { ?>
        <input readonly type="text" name="empresa[id]" id="empresa_id" class="form-control" value="<?php echo $form->getObject()->getId() ?>"/>
      <?php } ?>
      <?php if ($form['id']->renderError())  { echo $form['id']->renderError(); } ?>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    $('#loading').fadeOut( "slow", function() {});
    $( "form" ).submit(function( event ) {
      $('#loading').fadeIn( "slow", function() {});
    });
  });
</script>
