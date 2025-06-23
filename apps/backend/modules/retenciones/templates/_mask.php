<div class="col-md-6">
  <div class="form-group">
    <?php echo $form['empresa_id']->renderLabel()?>
    <select name="retenciones[empresa_id]" class="form-control" id="retenciones_empresa_id">
    <?php
        $results = Doctrine_Query::create()
          ->select('sc.id as scid, e.id as eid, e.nombre as nombre, eu.user_id')
          ->from('ServerConf sc')
          ->leftJoin('sc.Empresa e')
          ->leftJoin('e.EmpresaUser eu')
          ->where('eu.user_id = ?', $sf_user->getGuardUser()->getId())
          ->orderBy('e.nombre ASC')
          ->execute();
        foreach ($results as $result) {
          echo "<option value='".$result["eid"]."'>".$result["nombre"]."</option>";
        }
      ?>
    </select>
  </div>
</div>
<div class="col-md-6">
  <div class="form-group" id="cliente_form">
    <?php echo $form['cliente_id']->renderLabel()?>
    <select name="retenciones[cliente_id]" class="form-control" id="retenciones_cliente_id" required>
    </select>
    <?php if ($form['cliente_id']->renderError())  { echo $form['cliente_id']->renderError(); } ?>
  </div>
</div>
</div></div></div>
<div id="campo_det"></div>
<?php if($form->getObject()->isNew()) { ?>
  <input type="hidden" name="retenciones[id]" id="cod" class="form-control" readonly value="1"/>
<?php } else { ?>
  <input readonly type="hidden" name="retenciones[id]" id="retenciones_id" class="form-control" value="<?php echo $form->getObject()->getId() ?>"/>
<?php } ?>
<script type="text/javascript">
  $( document ).ready(function() {
    $('#loading').fadeOut( "slow", function() {});
    $('#cliente_form').load('<?php echo url_for('retenciones/getClientes') ?>?id='+$("#retenciones_empresa_id").val()).fadeIn("slow");
    $("#retenciones_empresa_id").on('change', function(event){
      $('#cliente_form').load('<?php echo url_for('retenciones/getClientes') ?>?id='+$("#retenciones_empresa_id").val()).fadeIn("slow");
    });
  });
  function GetCodigo() {
    var empresa_id = $("#retenciones_empresa_id" ).val();
    $.get("<?php echo url_for('retenciones/contador') ?>?id="+empresa_id, function(contador) {
      $("#cod" ).val(contador);
    });
  }

  $( "form" ).submit(function( event ) {
    var cont=0;
    if(!$("#retenciones_cuentas_cobrar_id").val()) {
      $("#retenciones_cuentas_cobrar_id").addClass("is-invalid");
      $("#retenciones_cuentas_cobrar_id").parent().find(".error").remove();
      $("#retenciones_cuentas_cobrar_id").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
      cont++;
    }else {
      $("#retenciones_cuentas_cobrar_id").parent().find(".error").remove();
      $("#retenciones_cuentas_cobrar_id").removeClass("is-invalid");
    }

    if(!$("#retenciones_comprobante").val()) {
      $("#retenciones_comprobante").addClass("is-invalid");
      $("#retenciones_comprobante").parent().find(".error").remove();
      $("#retenciones_comprobante").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
      cont++;
    }else {
      $("#retenciones_comprobante").parent().find(".error").remove();
      $("#retenciones_comprobante").removeClass("is-invalid");
    }
    if(!$("#retenciones_fecha").val()) {
      $("#retenciones_fecha").addClass("is-invalid");
      $("#retenciones_fecha").parent().find(".error").remove();
      $("#retenciones_fecha").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
      cont++;
    }else {
      $("#retenciones_fecha").parent().find(".error").remove();
      $("#retenciones_fecha").removeClass("is-invalid");
    }

    if(!$("#retenciones_monto").val()) {
      $("#retenciones_monto").addClass("is-invalid");
      $("#retenciones_monto").parent().parent().find(".error").remove();
      $("#retenciones_monto").parent().parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
      cont++;
    }else {
      $("#retenciones_monto").parent().parent().find(".error").remove();
      $("#retenciones_monto").removeClass("is-invalid");

      var monto_usd = number_float($("#retenciones_monto_usd").val());
      var cc_id=$('#retenciones_cuentas_cobrar_id').val();
      var max_ammount = number_float($("#cuentas_cobrar_table").find('.pendiente_'+cc_id).text());
      if(monto_usd>max_ammount && $("#retenciones_cuentas_cobrar_id").val()>0) {
        $("#retenciones_monto").addClass("is-invalid");
        $("#retenciones_monto").parent().find(".error").remove();
        $("#retenciones_monto").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Monto Exede el monto pendiente por pagar.</li></ul></div>" );
        cont++;
      } else {
        $("#retenciones_monto").parent().find(".error").remove();
        $("#retenciones_monto").removeClass("is-invalid");
      }
    }

    if(cont>0) {
      $('#flash-error').html('<div id="alert" class="alert alert-warning alert-dismissible" style="margin: 15px 15px 0px 15px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fas fa-exclamation-triangle"></i> Alerta!</h4>ERROR, REVISA LOS DATOS INTRODUCIDOS.</div>');
      event.preventDefault();
      $("html, body").animate({ scrollTop: 0 }, 1000);
    } else {
      $('#loading').fadeIn( "slow", function() {});
    }
  });
</script>
<div><div><div>
