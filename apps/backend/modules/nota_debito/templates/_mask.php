<div class="col-md-4">
  <div class="form-group">
    <?php echo $form['empresa_id']->renderLabel()?>
    <select name="nota_debito[empresa_id]" class="form-control" id="nota_debito_empresa_id">
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
    <select name="nota_debito[proveedor_id]" class="form-control" id="nota_debito_proveedor_id" required>
    </select>
    <?php if ($form['proveedor_id']->renderError())  { echo $form['proveedor_id']->renderError(); } ?>
  </div>
</div>
</div></div></div>

<div class="card card-primary proveedor" id="sf_fieldset">
  <div class="card-body">
    <div id="campo_det">
    </div>
  </div>
</div>

<?php use_helper('Date'); ?>
<div class="card card-primary">
  <div class="card-body">
    <div class="row">
      <div class="col-md-2">
        <div class="form-group">
          <label for="nota_debito_moneda">Moneda</label>
          <select name="nota_debito[moneda]" class="form-control" id="nota_debito_moneda">
            <option value="1">BOLIVARES</option>
            <option value="2" selected>DOLARES</option>
          </select>
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label for="nota_debito_fecha">Fecha</label>
          <?php $date2 = date("d/m/Y"); ?>
          <input type="text" name="nota_debito[fecha]" value="<?php $date2 = new DateTime(); echo $date2->format('Y-m-d'); ?>" class="form-control dateonly" id="nota_debito_fecha" readonly="readonly">
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label for="nota_debito_quien_paga">N° de Nota de credito</label>
          <input type="text" name="nota_debito[quien_paga]" class="form-control" id="nota_debito_quien_paga"/>
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label for="nota_debito_num_recibo">N° de Control</label>
          <input type="text" name="nota_debito[num_recibo]" class="form-control" id="nota_debito_num_recibo"/>
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label for="factura_gastos_libro_compras">Libro de compras</label>
          <?php echo $form['libro_compras']->render(array("class" => "form-control"))?>
        </div>
      </div>
      <div class="col-md-4">
        <label for="nota_debito_tasa_cambio">Monto</label>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">USD</span>
          </div>
          <input class="form-control money" type="text" name="nota_debito[monto]" id="nota_debito_monto">
        </div>
      </div>
      <div class="col-md-4">
        <label for="nota_debito_tasa_cambio">Monto</label>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">BS</span>
          </div>
          <input class="form-control money" type="text" id="monto_bs">
        </div>
      </div>
      <div class="col-md-4">
        <label for="nota_debito_tasa_cambio">Tasa</label>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">BS</span>
          </div>
          <input class="form-control money" type="text" name="nota_debito[tasa_cambio]" id="nota_debito_tasa_cambio">
        </div>
      </div>
      <div class="col-md-6">
        <label for="nota_debito_descripcion">Descripcion</label>
        <textarea class="form-control" name="nota_debito[descripcion]" id="nota_debito_descripcion"></textarea>
      </div>
    </div>
  </div>
</div>
<div id="form_pago" style="display:none"></div>
<?php if($form->getObject()->isNew()) { ?>
  <input type="hidden" name="nota_debito[id]" id="cod" class="form-control" readonly value="1"/>
<?php } else { ?>
  <input readonly type="hidden" name="nota_debito[id]" id="nota_debito_id" class="form-control" value="<?php echo $form->getObject()->getId() ?>"/>
<?php } ?>
<script type="text/javascript">
  $( document ).ready(function() {
    $(".dateonly").datepicker({
      language: 'es',
      format: "yyyy-mm-dd"
    });
    $('#proveedores_form').load('<?php echo url_for('nota_debito/getProveedores') ?>?id='+$("#nota_debito_empresa_id").val()).fadeIn("slow");
    $('#form_pago').load('<?php echo url_for('nota_debito/getForma') ?>?id='+$("#nota_debito_moneda").val()).fadeIn("slow");
    $("#nota_debito_empresa_id").on('change', function(event){
      $('#proveedores_form').load('<?php echo url_for('nota_debito/getProveedores') ?>?id='+this.value).fadeIn("slow");
    });
  });
  $("#nota_debito_moneda").on('change', function(event){
    $('#form_pago').load('<?php echo url_for('nota_debito/getForma') ?>?id='+this.value).fadeIn("slow");
  });
  $('#nota_debito_monto').keyup(function(){
    sumar();
  });

  $('#monto_bs').keyup(function(){
    sumar();
  });

  $('#nota_debito_tasa_cambio').keyup(function(){
    sumar();
  });
  function sumar() {
    var tasa = 0;
    var monto = 0;
    var monto_bs = 0;
    if($("#nota_debito_tasa_cambio").val()) {
      tasa = number_float($("#nota_debito_tasa_cambio").val());
    }
    if($("#nota_debito_monto").val()) {
      monto = number_float($("#nota_debito_monto").val());
    }
    if($("#monto_bs").val()) {
      monto_bs = number_float($("#monto_bs").val());
    }

    if($("#nota_debito_moneda").val()==1) {
      var total=monto_bs/tasa;
      $("#nota_debito_monto").val(SetMoney(total));
    } else {
      var total=monto*tasa;
      $("#monto_bs").val(SetMoney(total));
    }
  }
  $( "form" ).submit(function( event ) {
    var cont=0;
    if(!$("#nota_debito_quien_paga").val()) {
      $("#nota_debito_quien_paga").addClass("is-invalid");
      $("#nota_debito_quien_paga").parent().find(".error").remove();
      $("#nota_debito_quien_paga").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
      cont++;
    }else {
      $("#nota_debito_quien_paga").parent().find(".error").remove();
      $("#nota_debito_quien_paga").removeClass("is-invalid");
    }
    if(!$("#nota_debito_fecha").val()) {
      $("#nota_debito_fecha").addClass("is-invalid");
      $("#nota_debito_fecha").parent().find(".error").remove();
      $("#nota_debito_fecha").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
      cont++;
    }else {
      $("#nota_debito_fecha").parent().find(".error").remove();
      $("#nota_debito_fecha").removeClass("is-invalid");
    }
    if(!$("#nota_debito_moneda").val()) {
      $("#nota_debito_moneda").addClass("is-invalid");
      $("#nota_debito_moneda").parent().find(".error").remove();
      $("#nota_debito_moneda").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
      cont++;
    }else {
      $("#nota_debito_moneda").parent().find(".error").remove();
      $("#nota_debito_moneda").removeClass("is-invalid");
    }

    if(!$("#nota_debito_monto").val()) {
      $("#nota_debito_monto").addClass("is-invalid");
      $("#nota_debito_monto").parent().parent().find(".error").remove();
      $("#nota_debito_monto").parent().parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
      cont++;
    }else {
      $("#nota_debito_monto").parent().parent().find(".error").remove();
      $("#nota_debito_monto").removeClass("is-invalid");
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

    if(!$("#nota_debito_tasa_cambio").val()) {
      $("#nota_debito_tasa_cambio").addClass("is-invalid");
      $("#nota_debito_tasa_cambio").parent().parent().find(".error").remove();
      $("#nota_debito_tasa_cambio").parent().parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
      cont++;
    }else {
      $("#nota_debito_tasa_cambio").parent().parent().find(".error").remove();
      $("#nota_debito_tasa_cambio").removeClass("is-invalid");
    }

    if(cont>0) {
      $('#flash-error').html('<div id="alert" class="alert alert-warning alert-dismissible" style="margin: 15px 15px 0px 15px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fas fa-exclamation-triangle"></i> Alerta!</h4>ERROR, REVISA LOS DATOS INTRODUCIDOS.</div>');
      event.preventDefault();
    } else {
      $('#loading').fadeIn( "slow", function() {});
    }
  });
</script>
<div><div><div>
