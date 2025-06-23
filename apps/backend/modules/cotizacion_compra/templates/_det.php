<script type="text/javascript">
  function addDet(num) {
    var r = $.ajax({
      type: 'GET',
      url: '<?php echo url_for('cotizacion_compra')?>'+'/addDetallesForm/<?php echo ($form->getObject()->isNew()?'':'?id='.$form->getObject()->getId()).($form->getObject()->isNew()?'?num=':'&num=')?>'+num,
      async: false
    }).responseText;
    return r;
  }
  $( document ).ready(function() {
    $('.add_item').click(function() {
      var items = $(".items").length + 1;
      $("#item").append(addDet(items));
      items = items + 1;
    });
  });
</script>

</div></div></div>

<div class="card card-primary proveedor" id="sf_fieldset">
  <div class="card-body">
    <div id="campo_det">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <?php echo $form['razon_social']->renderLabel()?>
            <?php echo $form['razon_social']->render(array('class' => 'form-control', 'readonly' => 'readonly'))?>
            <?php if ($form['razon_social']->renderError())  { echo $form['razon_social']->renderError(); } ?>
          </div>
        </div>
        <div class="col-md-3"></div>
        <div class="col-md-3">
          <div class="form-group">
            <?php echo $form['doc_id']->renderLabel()?>
            <?php echo $form['doc_id']->render(array('class' => 'form-control', 'readonly' => 'readonly'))?>
            <?php if ($form['doc_id']->renderError())  { echo $form['doc_id']->renderError(); } ?>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <?php echo $form['direccion']->renderLabel()?>
            <?php echo $form['direccion']->render(array('class' => 'form-control', 'readonly' => 'readonly'))?>
            <?php if ($form['direccion']->renderError())  { echo $form['direccion']->renderError(); } ?>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3">
          <div class="form-group">
            <?php echo $form['telf']->renderLabel()?>
            <?php echo $form['telf']->render(array('class' => 'form-control', 'readonly' => 'readonly'))?>
            <?php if ($form['telf']->renderError())  { echo $form['telf']->renderError(); } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php if ($form['cotizacion_compra_det']) : ?>
  <?php $numero=1 ?>
  <?php foreach ($form['cotizacion_compra_det'] as $det): ?>
    <div class="card card-primary items" id="sf_fieldset_det_<?php echo $numero?>">
      <div class="card-body">
        <div class="row">
          <div class="col-md-1">
            <div class="form-group">
              <?php echo $det['qty']->render(array('class' => 'form-control det_qty', 'type' => 'number', 'placeholder' => 'Cant.', 'min' => '1'))?>
              <?php if ($det['qty']->renderError())  { echo $det['qty']->renderError(); } ?>
            </div>
          </div>
          <div class="col-md-7">
            <div class="form-group">
              <?php echo $det['descripcion']->render(array('class' => 'textarea', 'placeholder' => 'Concepto o Descrición.'))?>
              <?php if ($det['descripcion']->renderError())  { echo $det['descripcion']->renderError(); } ?>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <?php echo $det['price_unit']->render(array('class' => 'form-control det_unit', 'type' => 'number', 'placeholder' => 'P. Unitario', 'min' => '1', 'step' => '.01'))?>
              <?php if ($det['price_unit']->renderError())  { echo $det['price_unit']->renderError(); } ?>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <?php echo $det['price_tot']->render(array('class' => 'form-control det_total', 'type' => 'number', 'placeholder' => 'Total', 'readonly' => 'readonly', 'min' => '1', 'step' => '.01'))?>
              <?php if ($det['price_tot']->renderError())  { echo $det['price_tot']->renderError(); } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php $numero= $numero + 1 ?>
  <?php endforeach; ?>
<?php endif; ?>
<div id="item"></div>
<div class="row">
  <div class="col-md-2 col-sm-12">
    <a class="btn btn-default btn-block text-uppercase btn-align add_item" href="javascript:void(0)">
      <i class="fa fa-plus-square mr-2"></i>Agregar item
    </a>
  </div>
</div>
<div class="card card-primary usuarios" id="sf_fieldset">
  <div class="card-body">
    <div class="row">
      <div class="col-md-8"></div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Sub-Total</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">USD</span>
            </div>
            <?php echo $form['subtotal']->render(array('class' => 'form-control subtotal numeroo2', 'readonly' => 'readonly'))?>
          </div>
        </div>
      </div>
      <div class="col-md-6"></div>
      <div class="col-md-2">
        <div class="form-group">
          <label>Descuento (%)</label>
          <?php echo $form['descuento']->render(array('class' => 'form-control descuento money', 'required' => 'required'))?>
          <?php if ($form['descuento']->renderError())  { echo $form['subtotal']->renderError(); } ?>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Descuento (Monto)</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">USD</span>
            </div>
            <input type="text" value="0" class="form-control descuento_monto" readonly="readonly" id="descuento_monto">
          </div>
        </div>
      </div>          
      <div class="col-md-8"></div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Total</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">USD</span>
            </div>
            <?php echo $form['subtotal_desc']->render(array('class' => 'subtotal_desc', 'readonly' => 'readonly', 'type' => 'hidden'))?>
            <?php echo $form['total']->render(array('class' => 'form-control total', 'readonly' => 'readonly'))?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div><div><div>

<script>
  $(function () {
    $('#cotizacion_compra_tasa_cambio').keyup(function(){
      sumar();
    });
    $('.descuento').keyup(function(){
      sumar();
    });
  });
  function sumar() {
    $(".det_qty").each(function() {
      var tasa=number_float($("#cotizacion_compra_tasa_cambio").val());
      var qty=number_float(this.value);
      var punit=number_float($(this).parent().parent().parent().find('.det_unit').val());
      var total=setAndFormat(qty*punit);
      var unit_bs = setAndFormat(punit*tasa);
      var total_bs = setAndFormat(unit_bs*qty);
      $(this).parent().parent().parent().find('.det_total').val(SetMoney(total));
      $(this).parent().parent().parent().find('.det_unit_bs').val(SetMoney(unit_bs));
      $(this).parent().parent().parent().find('.det_total_bs').val(SetMoney(total_bs));
    });
    var sum=0;
    $(".det_total").each(function() {
      sum += +number_float(this.value);
    });
    $("#cotizacion_compra_subtotal").val(SetMoney(sum));
    var desc=number_float($("#cotizacion_compra_descuento").val());
    var subminusdesc=sum;
    if(desc>0) {
      var desc_monto = setAndFormat((sum*desc)/100);
      subminusdesc = sum-desc_monto;
      $("#descuento_monto").val(SetMoney(desc_monto));
    } else {
      $("#descuento_monto").val("0,0000");
    }
    $("#cotizacion_compra_subtotal_desc").val(SetMoney(subminusdesc));
    $("#cotizacion_compra_total").val(SetMoney(subminusdesc));
  }
  function sumarBs() {
    $(".det_qty").each(function() {
      var tasa=number_float($("#cotizacion_compra_tasa_cambio").val());
      var qty=number_float(this.value);
      var unit_bs=number_float($(this).parent().parent().parent().find('.det_unit_bs').val());
      var punit=setAndFormat(unit_bs/tasa);
      $(this).parent().parent().parent().find('.det_unit').val(SetMoney(punit));
      var total=setAndFormat(qty*punit);
      var total_bs = setAndFormat(unit_bs*qty);
      $(this).parent().parent().parent().find('.det_total').val(SetMoney(total));
      $(this).parent().parent().parent().find('.det_total_bs').val(SetMoney(total_bs));
    });
    var sum=0;
    $(".det_total").each(function() {
      sum += +number_float(this.value);
    });
    $("#cotizacion_compra_subtotal").val(SetMoney(sum));
    var desc=number_float($("#cotizacion_compra_descuento").val());
    var subminusdesc=sum;
    if(desc>0) {
      var desc_monto = setAndFormat((sum*desc)/100);
      subminusdesc = sum-desc_monto;
      $("#descuento_monto").val(SetMoney(desc_monto));
    } else {
      $("#descuento_monto").val("0,0000");
    }
    $("#cotizacion_compra_subtotal_desc").val(SetMoney(subminusdesc));
    $("#cotizacion_compra_total").val(SetMoney(subminusdesc));
  }
  function del_usuario(e) {
    $(e).parent().parent().parent().remove();
    var cont=1;
    $( ".items" ).each(function( index ) {
      $(this).attr("id","sf_fieldset_det_"+cont);
      $(this).find(".card-title").text("item ["+cont+"]");
      $(this).find(".cotizacion_compra_det_producto_id").attr("id","cotizacion_compra_cotizacion_compra_det_"+cont+"_producto_id");
      $(this).find(".cotizacion_compra_det_producto_id").attr("name","cotizacion_compra[cotizacion_compra_det]["+cont+"][producto_id]");
      $(this).find(".cotizacion_compra_det_qty").attr("id","cotizacion_compra_cotizacion_compra_det_"+cont+"_qty");
      $(this).find(".cotizacion_compra_det_qty").attr("name","cotizacion_compra[cotizacion_compra_det]["+cont+"][qty]");
      $(this).find(".cotizacion_compra_det_price_unit").attr("id","cotizacion_compra_cotizacion_compra_det_"+cont+"_price_unit");
      $(this).find(".cotizacion_compra_det_price_unit").attr("name","cotizacion_compra[cotizacion_compra_det]["+cont+"][price_unit]");
      $(this).find(".cotizacion_compra_det_price_tot").attr("id","cotizacion_compra_cotizacion_compra_det_"+cont+"_price_tot");
      $(this).find(".cotizacion_compra_det_price_tot").attr("name","cotizacion_compra[cotizacion_compra_det]["+cont+"][price_tot]");
      $(this).find(".del_servicio").attr("id","del_"+cont);
      $(this).find(".det_unit_bs").attr("id","cotizacion_compra_det_unit_"+cont+"_bs");
      $(this).find(".det_total_bs").attr("id","cotizacion_compra_det_tot_"+cont+"_bs");
      cont+=1;
    });
    sumar();
  };
  function valid_productid(id) {
    var cont=0;
    $(".items").each(function() {
      var idprod=$(this).find(".cotizacion_compra_det_producto_id").val();
      if(idprod==id){
        cont+=1;
      }
    });
    if(cont>1){
      return 1;
    }
    return 0;
  }
  $( "form" ).submit(function( event ) {
    var sum=0;
    var cont=0;
    if(!$("#cotizacion_compra_dias_credito").val()) {
      $("#cotizacion_compra_dias_credito").addClass("is-invalid");
      $("#cotizacion_compra_dias_credito").parent().find(".error").remove();
      $("#cotizacion_compra_dias_credito").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
      cont++;
    }else {
      $("#cotizacion_compra_dias_credito").parent().find(".error").remove();
      $("#cotizacion_compra_dias_credito").removeClass("is-invalid");
    }
    if(!$("#cotizacion_compra_tasa_cambio").val()) {
      $("#cotizacion_compra_tasa_cambio").addClass("is-invalid");
      $("#cotizacion_compra_tasa_cambio").parent().find(".error").remove();
      $("#cotizacion_compra_tasa_cambio").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
      cont++;
    }else {
      var tasa = number_float($("#cotizacion_compra_tasa_cambio").val());
      if (tasa<1) {
        $("#cotizacion_compra_tasa_cambio").addClass("is-invalid");
        $("#cotizacion_compra_tasa_cambio").parent().find(".error").remove();
        $("#cotizacion_compra_tasa_cambio").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Debe ser mayor a 0.</li></ul></div>" );
        cont++;
      } else {
        $("#cotizacion_compra_tasa_cambio").parent().find(".error").remove();
        $("#cotizacion_compra_tasa_cambio").removeClass("is-invalid");
      }
    }
    $(".items").each(function() {
      if(!$(this).find(".cotizacion_compra_det_producto_id").val()) {
        $(this).find(".cotizacion_compra_det_producto_id").addClass("is-invalid");
        $(this).find(".cotizacion_compra_det_producto_id").parent().find(".error").remove();
        $(this).find(".cotizacion_compra_det_producto_id").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
        cont++;
      }else {
        $(this).find(".cotizacion_compra_det_producto_id").parent().find(".error").remove();
        $(this).find(".cotizacion_compra_det_producto_id").removeClass("is-invalid");
      }

      var idprod=$(this).find(".cotizacion_compra_det_producto_id").val();
      if(idprod) {
        if(valid_productid(idprod)==1) {
          $(this).find(".cotizacion_compra_det_producto_id").addClass("is-invalid");
          $(this).find(".cotizacion_compra_det_producto_id").parent().find(".error").remove();
          $(this).find(".cotizacion_compra_det_producto_id").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Item esta duplicado</li></ul></div>" );
          cont++;
        } else {
          $(this).find(".cotizacion_compra_det_producto_id").parent().find(".error").remove();
          $(this).find(".cotizacion_compra_det_producto_id").removeClass("is-invalid");
        }
      }
      if(!$(this).find(".cotizacion_compra_det_qty").val()) {
        $(this).find(".cotizacion_compra_det_qty").addClass("is-invalid");
        $(this).find(".cotizacion_compra_det_qty").parent().find(".error").remove();
        $(this).find(".cotizacion_compra_det_qty").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
        cont++;
      }else {
        $(this).find(".cotizacion_compra_det_qty").parent().find(".error").remove();
        $(this).find(".cotizacion_compra_det_qty").removeClass("is-invalid");
      }

      if(!$(this).find(".cotizacion_compra_det_price_unit").val()) {
        $(this).find(".cotizacion_compra_det_price_unit").addClass("is-invalid");
        $(this).find(".cotizacion_compra_det_price_unit").parent().parent().find(".error").remove();
        $(this).find(".cotizacion_compra_det_price_unit").parent().parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
        cont++;
      }else {
        $(this).find(".cotizacion_compra_det_price_unit").parent().find(".error").remove();
        $(this).find(".cotizacion_compra_det_price_unit").removeClass("is-invalid");
      }

      if(!$(this).find(".cotizacion_compra_det_price_tot").val()) {
        $(this).find(".cotizacion_compra_det_price_tot").addClass("is-invalid");
        $(this).find(".cotizacion_compra_det_price_tot").parent().parent().find(".error").remove();
        $(this).find(".cotizacion_compra_det_price_tot").parent().parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
        cont++;
      }else {
        $(this).find(".cotizacion_compra_det_price_tot").parent().parent().find(".error").remove();
        $(this).find(".cotizacion_compra_det_price_tot").removeClass("is-invalid");
      }

      sum += 1;
    });

    if(sum==0) {
      $('#flash-error').html('<div id="alert" class="alert alert-warning alert-dismissible" style="margin: 15px 15px 0px 15px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fas fa-exclamation-triangle"></i> Alerta!</h4>ERROR, DEBE INTRODUCIR AL MENOS 1 ITEM.</div>');
      event.preventDefault();
      $("html, body").animate({ scrollTop: 0 }, 1000);
    } else {
      if(cont>0) {
        $('#flash-error').html('<div id="alert" class="alert alert-warning alert-dismissible" style="margin: 15px 15px 0px 15px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fas fa-exclamation-triangle"></i> Alerta!</h4>ERROR, REVISA LOS DATOS INTRODUCIDOS.</div>');
        event.preventDefault();
        $("html, body").animate({ scrollTop: 0 }, 1000);
      } else {
        $('#loading').fadeIn( "slow", function() {});
      }
    }
  });
  $(document).on('keyup keypress', 'form input[type="text"]', function(e) {
    if(e.which == 13) {
      e.preventDefault();
      return false;
    }
  });
</script>
