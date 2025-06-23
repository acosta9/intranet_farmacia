<div class="col-md-4">
  <div class="form-group">
    <?php echo $form['empresa_id']->renderLabel()?>
    <select name="recibo_pago_compra[empresa_id]" class="form-control" id="recibo_pago_compra_empresa_id">
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
  <div class="form-group" id="proveedores_form">
    <?php echo $form['proveedor_id']->renderLabel()?>
    <select name="recibo_pago_compra[proveedor_id]" class="form-control" id="recibo_pago_compra_proveedor_id" required>
    </select>
    <?php if ($form['proveedor_id']->renderError())  { echo $form['proveedor_id']->renderError(); } ?>
  </div>
</div>
</div></div></div>

<div id="campo_det"></div>
<?php if($form->getObject()->isNew()) { ?>
  <input type="hidden" name="recibo_pago_compra[id]" id="cod" class="form-control" readonly value="1"/>
<?php } else { ?>
  <input readonly type="hidden" name="recibo_pago_compra[id]" id="recibo_pago_compra_id" class="form-control" value="<?php echo $form->getObject()->getId() ?>"/>
<?php } ?>
<script type="text/javascript">
  $( document ).ready(function() {
    $('#proveedores_form').load('<?php echo url_for('recibo_pago_compra/getProveedores') ?>?id='+$("#recibo_pago_compra_empresa_id").val()).fadeIn("slow");
    $("#recibo_pago_compra_empresa_id").on('change', function(event){
      $('#proveedores_form').load('<?php echo url_for('recibo_pago_compra/getProveedores') ?>?id='+$("#recibo_pago_compra_empresa_id").val()).fadeIn("slow");
    });
  });
  $( "form" ).submit(function( event ) {
    var cont=0;
    if(!$("#recibo_pago_compra_quien_paga").val()) {
      $("#recibo_pago_compra_quien_paga").addClass("is-invalid");
      $("#recibo_pago_compra_quien_paga").parent().find(".error").remove();
      $("#recibo_pago_compra_quien_paga").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
      cont++;
    }else {
      $("#recibo_pago_compra_quien_paga").parent().find(".error").remove();
      $("#recibo_pago_compra_quien_paga").removeClass("is-invalid");
    }
    if(!$("#recibo_pago_compra_fecha").val()) {
      $("#recibo_pago_compra_fecha").addClass("is-invalid");
      $("#recibo_pago_compra_fecha").parent().find(".error").remove();
      $("#recibo_pago_compra_fecha").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
      cont++;
    }else {
      $("#recibo_pago_compra_fecha").parent().find(".error").remove();
      $("#recibo_pago_compra_fecha").removeClass("is-invalid");
    }
    if(!$("#recibo_pago_compra_moneda").val()) {
      $("#recibo_pago_compra_moneda").addClass("is-invalid");
      $("#recibo_pago_compra_moneda").parent().find(".error").remove();
      $("#recibo_pago_compra_moneda").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
      cont++;
    }else {
      $("#recibo_pago_compra_moneda").parent().find(".error").remove();
      $("#recibo_pago_compra_moneda").removeClass("is-invalid");
    }

    if(!$("#recibo_pago_compra_monto").val()) {
      $("#recibo_pago_compra_monto").addClass("is-invalid");
      $("#recibo_pago_compra_monto").parent().parent().find(".error").remove();
      $("#recibo_pago_compra_monto").parent().parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
      cont++;
    }else {
      $("#recibo_pago_compra_monto").parent().parent().find(".error").remove();
      $("#recibo_pago_compra_monto").removeClass("is-invalid");

      if($("#recibo_pago_compra_moneda").val()==2) {
      var monto_usd = number_float($("#recibo_pago_compra_monto").val());
      var cc_id=$('#recibo_pago_compra_cuentas_pagar_id').val();
      var max_ammount = number_float($("#cuentas_pagar_table").find('.pendiente_'+cc_id).text());
      if(monto_usd>max_ammount && $("#recibo_pago_compra_cuentas_pagar_id").val()>0) {
        $("#recibo_pago_compra_monto").addClass("is-invalid");
        $("#recibo_pago_compra_monto").parent().find(".error").remove();
        $("#recibo_pago_compra_monto").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Monto Exede el monto pendiente por pagar.</li></ul></div>" );
        cont++;
      } else {
        $("#recibo_pago_compra_monto").parent().find(".error").remove();
        $("#recibo_pago_compra_monto").removeClass("is-invalid");
      }
     }
    }
    if(!$("#monto_bs").val()) {
      $("#monto_bs").addClass("is-invalid");
      $("#monto_bs").parent().parent().find(".error").remove();
      $("#monto_bs").parent().parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
      cont++;
    }else {
      $("#monto_bs").parent().parent().find(".error").remove();
      $("#monto_bs").removeClass("is-invalid");

      if($("#recibo_pago_compra_moneda").val()==1) {
        var monto_bs = number_float($("#monto_bs").val());
        var cc_id=$('#recibo_pago_compra_cuentas_pagar_id').val();
        var max_ammount = number_float($("#cuentas_pagar_table").find('.pendientebs_'+cc_id).text());
        if(monto_bs>max_ammount && $("#recibo_pago_compra_cuentas_pagar_id").val()>0) {
          $("#monto_bs").addClass("is-invalid");
          $("#monto_bs").parent().find(".error").remove();
          $("#monto_bs").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Monto Exede el monto pendiente por pagar.</li></ul></div>" );
          cont++;
        } else {
          $("#monto_bs").parent().find(".error").remove();
          $("#monto_bs").removeClass("is-invalid");
        }
       }
    }

    if(!$("#recibo_pago_compra_tasa_cambio").val()) {
      $("#recibo_pago_compra_tasa_cambio").addClass("is-invalid");
      $("#recibo_pago_compra_tasa_cambio").parent().parent().find(".error").remove();
      $("#recibo_pago_compra_tasa_cambio").parent().parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
      cont++;
    }else {
      $("#recibo_pago_compra_tasa_cambio").parent().parent().find(".error").remove();
      $("#recibo_pago_compra_tasa_cambio").removeClass("is-invalid");
    }

    if(cont>0) {
      $('#flash-error').html('<div id="alert" class="alert alert-warning alert-dismissible" style="margin: 15px 15px 0px 15px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fas fa-exclamation-triangle"></i> Alerta!</h4>ERROR, REVISA LOS DATOS INTRODUCIDOS.</div>');
      event.preventDefault();
    } else {
      if($("#nota_debito_ccid").length){
        $('#flash-error').html('<div id="alert" class="alert alert-warning alert-dismissible" style="margin: 15px 15px 0px 15px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fas fa-exclamation-triangle"></i> Alerta!</h4>ERROR, DEBE PROCESAR LA NOTA DE DEBITO PRIMERO.</div>');
        event.preventDefault();
        $("html, body").animate({scrollTop: 0}, 1000);
      } else {
        $('#loading').fadeIn( "slow", function() {});
      }
    }
  });
</script>
<div><div><div>
