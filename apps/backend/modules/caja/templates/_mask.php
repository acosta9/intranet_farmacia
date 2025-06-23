<div class="col-md-3 col-sm-12">
  <div class="form-group">
    <label class="col-sm-12 control-label">Codigo</label>
    <div class="col-sm-12">
      <?php if($form->getObject()->isNew()) { ?>
        <input type="number" name="caja[id]" id="cod" class="form-control" min="1" readonly/>
      <?php } else { ?>
        <input readonly type="number" name="caja[id]" id="caja_id" class="form-control" min="1" value="<?php echo $form->getObject()->getId() ?>"/>
      <?php } ?>
      <?php if ($form['id']->renderError())  { echo $form['id']->renderError(); } ?>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    GetCodigo();
    $("#caja_user_list").select2({ width: '100%' });
    $('#caja_empresa_id').change(function(){
      GetCodigo();
    });
    $('#caja_nombre').keyup(function(){
      GetCodigo();
    });
    <?php if(!$form->getObject()->isNew()) { ?>
      $("#caja_empresa_id").mousedown(function(e){
        e.preventDefault();
      });
      
    <?php } ?>
  });

  function GetCodigo() {
    var empresa_id = $("#caja_empresa_id" ).val();
    $.get("<?php echo url_for('caja/contador') ?>?id="+empresa_id, function(contador) {
      console.log(contador);
      $("#cod" ).val(contador);
    });
  }
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#loading').fadeOut( "slow", function() {});
    $( "form" ).submit(function( event ) {
      $('#loading').fadeIn( "slow", function() {});
    });
  });
</script>