<div class="col-md-6">
  <div class="form-group">
    <?php echo $form['empresa_id']->renderLabel()?>
    <select name="nota_credito[empresa_id]" class="form-control" id="nota_credito_empresa_id">
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
    <select name="nota_credito[cliente_id]" class="form-control" id="nota_credito_cliente_id" required>
    </select>
    <?php if ($form['cliente_id']->renderError())  { echo $form['cliente_id']->renderError(); } ?>
  </div>
</div>
</div></div></div>

<?php
use_helper('Date');
if(!$sf_params->get('id')=='0') {
  $client=Doctrine_Core::getTable('Cliente')->findOneBy('id',$sf_params->get('id'));
}
?>
<div class="card card-primary">
  <div class="card-body">
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label for="nota_credito_fecha">Fecha</label>
          <input type="text" name="nota_credito[fecha]" id="nota_credito_fecha" value="<?php $date2 = new DateTime(); echo $date2->format('Y-m-d'); ?>" class="form-control dateonly" readonly="readonly">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="nota_credito_quien_paga">Emisor</label>
          <input type="text" name="nota_credito[quien_paga]" class="form-control" id="nota_credito_quien_paga"/>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="nota_credito_num_recibo">N° de Referencia</label>
          <input type="text" name="nota_credito[num_recibo]" class="form-control" id="nota_credito_num_recibo"/>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="nota_credito_moneda">Moneda</label>
          <select name="nota_credito[moneda]" class="form-control" id="nota_credito_moneda">
            <option value="1">BOLIVARES</option>
            <option value="2" selected>DOLARES</option>
          </select>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group" id="form_pago">
        </div>
      </div>
      <div class="col-md-4"></div>
      <div class="col-md-4">
        <label for="nota_credito_tasa_cambio">Monto</label>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">USD</span>
          </div>
          <input class="form-control money" type="text" name="nota_credito[monto]" id="nota_credito_monto">
        </div>
      </div>
      <div class="col-md-4">
        <label for="nota_credito_tasa_cambio">Monto</label>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">BS</span>
          </div>
          <input class="form-control money" type="text" id="monto_bs">
        </div>
      </div>
      <div class="col-md-4">
        <label for="nota_credito_tasa_cambio">Tasa</label>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">BS</span>
          </div>
          <input class="form-control money" type="text" name="nota_credito[tasa_cambio]" id="nota_credito_tasa_cambio">
        </div>
      </div>
      <div class="col-md-6">
        <label for="nota_credito_descripcion">Descripcion</label>
        <textarea class="form-control" name="nota_credito[descripcion]" id="nota_credito_descripcion"></textarea>
      </div>
    </div>
  </div>
</div>

<?php if($form->getObject()->isNew()) { ?>
  <input type="hidden" name="nota_credito[id]" id="cod" class="form-control" readonly value="1"/>
<?php } else { ?>
  <input readonly type="hidden" name="nota_credito[id]" id="nota_credito_id" class="form-control" value="<?php echo $form->getObject()->getId() ?>"/>
<?php } ?>
<script type="text/javascript">
  $( document ).ready(function() {
    $('#cliente_form').load('<?php echo url_for('nota_credito/getClientes') ?>?id='+$("#nota_credito_empresa_id").val()).fadeIn("slow");
    $("#nota_credito_empresa_id").on('change', function(event){
      $('#cliente_form').load('<?php echo url_for('nota_credito/getClientes') ?>?id='+$("#nota_credito_empresa_id").val()).fadeIn("slow");
    });
  });
  function GetCodigo() {
    var empresa_id = $("#nota_credito_empresa_id" ).val();
    $.get("<?php echo url_for('nota_credito/contador') ?>?id="+empresa_id, function(contador) {
      $("#cod" ).val(contador);
    });
  }
</script>
<script>
$( document ).ready(function() {
  $('#loading').fadeOut( "slow", function() {});
  $('#form_pago').load('<?php echo url_for('nota_credito/getForma') ?>?id='+$("#nota_credito_moneda").val()).fadeIn("slow");
  $( "form" ).submit(function( event ) {
    var cont=0;
    if(!$("#nota_credito_quien_paga").val()) {
      $("#nota_credito_quien_paga").addClass("is-invalid");
      $("#nota_credito_quien_paga").parent().find(".error").remove();
      $("#nota_credito_quien_paga").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
      cont++;
    }else {
      $("#nota_credito_quien_paga").parent().find(".error").remove();
      $("#nota_credito_quien_paga").removeClass("is-invalid");
    }
    if(!$("#nota_credito_fecha").val()) {
      $("#nota_credito_fecha").addClass("is-invalid");
      $("#nota_credito_fecha").parent().find(".error").remove();
      $("#nota_credito_fecha").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
      cont++;
    }else {
      $("#nota_credito_fecha").parent().find(".error").remove();
      $("#nota_credito_fecha").removeClass("is-invalid");
    }
    if(!$("#nota_credito_moneda").val()) {
      $("#nota_credito_moneda").addClass("is-invalid");
      $("#nota_credito_moneda").parent().find(".error").remove();
      $("#nota_credito_moneda").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
      cont++;
    }else {
      $("#nota_credito_moneda").parent().find(".error").remove();
      $("#nota_credito_moneda").removeClass("is-invalid");
    }

    if(!$("#nota_credito_monto").val()) {
      $("#nota_credito_monto").addClass("is-invalid");
      $("#nota_credito_monto").parent().parent().find(".error").remove();
      $("#nota_credito_monto").parent().parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
      cont++;
    }else {
      $("#nota_credito_monto").parent().parent().find(".error").remove();
      $("#nota_credito_monto").removeClass("is-invalid");

      var monto_usd = number_float($("#nota_credito_monto").val());
      var cc_id=$('#nota_credito_cuentas_cobrar_id').val();
      var max_ammount = number_float($("#cuentas_cobrar_table").find('.pendiente_'+cc_id).text());
      if(monto_usd>max_ammount && $("#nota_credito_cuentas_cobrar_id").val()>0) {
        $("#nota_credito_monto").addClass("is-invalid");
        $("#nota_credito_monto").parent().find(".error").remove();
        $("#nota_credito_monto").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Monto Exede el monto pendiente por pagar.</li></ul></div>" );
        cont++;
      } else {
        $("#nota_credito_monto").parent().find(".error").remove();
        $("#nota_credito_monto").removeClass("is-invalid");
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
    }

    if(!$("#nota_credito_tasa_cambio").val()) {
      $("#nota_credito_tasa_cambio").addClass("is-invalid");
      $("#nota_credito_tasa_cambio").parent().parent().find(".error").remove();
      $("#nota_credito_tasa_cambio").parent().parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
      cont++;
    }else {
      $("#nota_credito_tasa_cambio").parent().parent().find(".error").remove();
      $("#nota_credito_tasa_cambio").removeClass("is-invalid");
    }

    if(cont>0) {
      $('#flash-error').html('<div id="alert" class="alert alert-warning alert-dismissible" style="margin: 15px 15px 0px 15px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fas fa-exclamation-triangle"></i> Alerta!</h4>ERROR, REVISA LOS DATOS INTRODUCIDOS.</div>');
      event.preventDefault();
      $("html, body").animate({ scrollTop: 0 }, 1000);
    } else {
      $('#loading').fadeIn( "slow", function() {});
    }
  });
});

$("#nota_credito_moneda").on('change', function(event){
  $('#form_pago').load('<?php echo url_for('nota_credito/getForma') ?>?id='+this.value).fadeIn("slow");
});

$('#nota_credito_monto').keyup(function(){
  sumar();
});

$('#monto_bs').keyup(function(){
  sumar();
});

$('#nota_credito_tasa_cambio').keyup(function(){
  sumar();
});

function getTasa() {
  var tasa = number_float($("#ttasa").text());
  if(tasa) {
    $('#nota_credito_tasa_cambio').val(SetMoney(tasa));
  } else {
    $('#nota_credito_tasa_cambio').val("0");
  }
}

function sumar() {
  var tasa = 0;
  var monto = 0;
  var monto_bs = 0;
  if($("#nota_credito_tasa_cambio").val()) {
    tasa = number_float($("#nota_credito_tasa_cambio").val());
  }
  if($("#nota_credito_monto").val()) {
    monto = number_float($("#nota_credito_monto").val());
  }
  if($("#monto_bs").val()) {
    monto_bs = number_float($("#monto_bs").val());
  }

  if($("#nota_credito_moneda").val()==1) {
    var total=monto_bs/tasa;
    $("#nota_credito_monto").val(SetMoney(total));
  } else {
    var total=monto*tasa;
    $("#monto_bs").val(SetMoney(total));
  }

}
</script>
<div><div><div>
