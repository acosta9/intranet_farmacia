<script type="text/javascript">
  function addDet(num) {
    var r = $.ajax({
      type: 'GET',
      url: '<?php echo url_for('factura_gastos')?>'+'/addDetallesForm/<?php echo ($form->getObject()->isNew()?'':'?id='.$form->getObject()->getId()).($form->getObject()->isNew()?'?num=':'&num=')?>'+num,
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
              <span class="input-group-text">BS</span>
            </div>
            <?php echo $form['subtotal']->render(array('class' => 'form-control subtotal money', 'placeholder' => "#,####"))?>
          </div>
        </div>
      </div>
      <div class="col-md-6"></div>
      <div class="col-md-2">
        <div class="form-group">
          <label>Descuento (%)</label>
          <?php echo $form['descuento']->render(array('class' => 'form-control descuento money', 'placeholder' => "#,####"))?>
          <?php if ($form['descuento']->renderError())  { echo $form['descuento']->renderError(); } ?>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Sub-Total Menos Descuento</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">BS</span>
            </div>
            <?php echo $form['subtotal_desc']->render(array('class' => 'form-control subtotal_desc money', 'placeholder' => "#,####", "value" => "0"))?>
          </div>
        </div>
      </div>
      <div class="col-md-5"></div>
      <div class="col-md-1">
        <div class="form-group">
          <label>Iva (%)</label>
          <?php echo $form['iva']->render(array('class' => 'form-control iva', 'value' => '16', 'readonly' => "readonly"))?>
          <?php if ($form['iva']->renderError())  { echo $form['iva']->renderError(); } ?>
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label>Base Imponible</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">BS</span>
            </div>
            <?php echo $form['base_imponible']->render(array('class' => 'form-control base_imponible money', 'value' => '0', 'placeholder' => "#,####"))?>
            <?php if ($form['base_imponible']->renderError())  { echo $form['base_imponible']->renderError(); } ?>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Iva (Monto)</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">BS</span>
            </div>
            <?php echo $form['iva_monto']->render(array('class' => 'form-control iva_monto money', 'value' => '0', 'placeholder' => "#,####"))?>
          </div>
        </div>
      </div>
      <div class="col-md-8"></div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Total BS</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">BS</span>
            </div>
            <input type="text" name="factura_gastos[total2]" class="form-control money" id="factura_gastos_total2" placeholder="#,####">
          </div>
        </div>
      </div>
      <div class="col-md-8"></div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Total USD</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">USD</span>
            </div>
            <?php echo $form['total']->render(array('class' => 'form-control total money'))?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div><div><div>

<script>
  $(function () {
    $('#factura_gastos_tasa_cambio').keyup(function(){
      sumar();sumarBs();
    });
    $('.descuento').keyup(function(){
      sumarBs();
    });
    $('.base_imponible').keyup(function(){
      calcularIva();
    });
  });
  function sumar() {
    var tasa=number_float($("#factura_gastos_tasa_cambio").val());
    $(".det_qty").each(function() {
      var qty=number_float(this.value);
      var punit=number_float($(this).parent().parent().parent().find('.det_unit').val());
      var total=setAndFormat(qty*punit);
      var unit_bs = setAndFormat(punit*tasa);
      var total_bs = setAndFormat(unit_bs*qty);
      $(this).parent().parent().parent().find('.det_total').val(SetMoney(total));
      $(this).parent().parent().parent().find('.det_unit_bs').val(SetMoney(unit_bs));
      $(this).parent().parent().parent().find('.det_total_bs').val(SetMoney(total_bs));
    });
   calcularTotales();
  }
  function sumarBs() {
    var tasa=number_float($("#factura_gastos_tasa_cambio").val());
    $(".det_qty").each(function() {
      var qty=number_float(this.value);
      var unit_bs=number_float($(this).parent().parent().parent().find('.det_unit_bs').val());
      var punit=setAndFormat(unit_bs/tasa);
      $(this).parent().parent().parent().find('.det_unit').val(SetMoney(punit));
      var total=setAndFormat(qty*punit);
      var total_bs = setAndFormat(unit_bs*qty);
      $(this).parent().parent().parent().find('.det_total').val(SetMoney(total));
      $(this).parent().parent().parent().find('.det_unit_bs').val(SetMoney(unit_bs));
      $(this).parent().parent().parent().find('.det_total_bs').val(SetMoney(total_bs));
    });
    calcularTotales();
  }
  function calcularIva() {
    var ivam=0; var total2=0;
    var tasa=number_float($("#factura_gastos_tasa_cambio").val());
    var sub=number_float($("#factura_gastos_subtotal_desc").val());
    var iva=number_float($("#factura_gastos_iva").val());
    var bi=number_float($("#factura_gastos_base_imponible").val());
    if(bi>0){
      ivam=setAndFormat((bi*iva)/100);
    }
    total2=sub+ivam;
    total=setAndFormat(total2/tasa);
    $("#factura_gastos_iva_monto").val(SetMoney(ivam));
    $("#factura_gastos_total2").val(SetMoney(total2));
    $("#factura_gastos_total").val(SetMoney(total));
  }
  function calcularTotales() {
    var tasa=number_float($("#factura_gastos_tasa_cambio").val());
    var sum=0;
    $(".det_total").each(function() {
      sum += +number_float(this.value);
    });
        var sum=0; var total2=0; var total=0;
    $(".det_total_bs").each(function() {
      sum += +number_float(this.value);
    });
    $("#factura_gastos_subtotal").val(SetMoney(sum));
    var desc=number_float($("#factura_gastos_descuento").val());
    var subminusdesc=sum;
    if(desc>0) {
      var desc_monto = setAndFormat((sum*desc)/100);
      subminusdesc = sum-desc_monto;
    } 
    $("#factura_gastos_subtotal_desc").val(SetMoney(subminusdesc));
    var ivam=number_float($("#factura_gastos_iva_monto").val());
    total2=subminusdesc+ivam;
    total=setAndFormat(total2/tasa);
    $("#factura_gastos_total2").val(SetMoney(total2));
    $("#factura_gastos_total").val(SetMoney(total));
  }
  function del_usuario(e) {
    $(e).parent().parent().parent().remove();
    var cont=1;
    $( ".items" ).each(function( index ) {
      $(this).attr("id","sf_fieldset_det_"+cont);
      $(this).find(".card-title").text("item ["+cont+"]");
      $(this).find(".factura_gastos_det_descripcion").attr("id","factura_gastos_factura_gastos_det_"+cont+"_descripcion");
      $(this).find(".factura_gastos_det_descripcion").attr("name","factura_gastos[factura_gastos_det]["+cont+"][descripcion]");
      $(this).find(".factura_gastos_det_qty").attr("id","factura_gastos_factura_gastos_det_"+cont+"_qty");
      $(this).find(".factura_gastos_det_qty").attr("name","factura_gastos[factura_gastos_det]["+cont+"][qty]");
      $(this).find(".factura_gastos_det_price_unit").attr("id","factura_gastos_factura_gastos_det_"+cont+"_price_unit");
      $(this).find(".factura_gastos_det_price_unit").attr("name","factura_gastos[factura_gastos_det]["+cont+"][price_unit]");
      $(this).find(".factura_gastos_det_price_tot").attr("id","factura_gastos_factura_gastos_det_"+cont+"_price_tot");
      $(this).find(".factura_gastos_det_price_tot").attr("name","factura_gastos[factura_gastos_det]["+cont+"][price_tot]");
      $(this).find(".del_servicio").attr("id","del_"+cont);
      $(this).find(".det_unit_bs").attr("id","factura_gastos_det_unit_"+cont+"_bs");
      $(this).find(".det_total_bs").attr("id","factura_gastos_det_tot_"+cont+"_bs");
      cont+=1;
    });
    sumar();sumarBs();
  };
  $( "form" ).submit(function( event ) {
    var sum=0;
    var cont=0;
    if(!$("#factura_gastos_num_factura").val()) {
      $("#factura_gastos_num_factura").addClass("is-invalid");
      $("#factura_gastos_num_factura").parent().find(".error").remove();
      $("#factura_gastos_num_factura").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
      cont++;
    }else {
      $("#factura_gastos_num_factura").parent().find(".error").remove();
      $("#factura_gastos_num_factura").removeClass("is-invalid");
    }
    if(!$("#factura_gastos_fecha").val()) {
      $("#factura_gastos_fecha").addClass("is-invalid");
      $("#factura_gastos_fecha").parent().find(".error").remove();
      $("#factura_gastos_fecha").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
      cont++;
    }else {
      $("#factura_gastos_fecha").parent().find(".error").remove();
      $("#factura_gastos_fecha").removeClass("is-invalid");
    }
    if(!$("#factura_gastos_fecha_recepcion").val()) {
      $("#factura_gastos_fecha_recepcion").addClass("is-invalid");
      $("#factura_gastos_fecha_recepcion").parent().find(".error").remove();
      $("#factura_gastos_fecha_recepcion").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
      cont++;
    }else {
      $("#factura_gastos_fecha_recepcion").parent().find(".error").remove();
      $("#factura_gastos_fecha_recepcion").removeClass("is-invalid");
    }
    if(!$("#factura_gastos_dias_credito").val()) {
      $("#factura_gastos_dias_credito").addClass("is-invalid");
      $("#factura_gastos_dias_credito").parent().find(".error").remove();
      $("#factura_gastos_dias_credito").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
      cont++;
    }else {
      $("#factura_gastos_dias_credito").parent().find(".error").remove();
      $("#factura_gastos_dias_credito").removeClass("is-invalid");
    }
    if(!$("#factura_gastos_tasa_cambio").val()) {
      $("#factura_gastos_tasa_cambio").addClass("is-invalid");
      $("#factura_gastos_tasa_cambio").parent().find(".error").remove();
      $("#factura_gastos_tasa_cambio").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
      cont++;
    }else {
      var tasa = number_float($("#factura_gastos_tasa_cambio").val());
      if (tasa<1) {
        $("#factura_gastos_tasa_cambio").addClass("is-invalid");
        $("#factura_gastos_tasa_cambio").parent().find(".error").remove();
        $("#factura_gastos_tasa_cambio").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Debe ser mayor a 0.</li></ul></div>" );
        cont++;
      } else {
        $("#factura_gastos_tasa_cambio").parent().find(".error").remove();
        $("#factura_gastos_tasa_cambio").removeClass("is-invalid");
      }
    }
    $(".items").each(function() {
      if(!$(this).find(".factura_gastos_det_descripcion").val()) {
        $(this).find(".factura_gastos_det_descripcion").addClass("is-invalid");
        $(this).find(".factura_gastos_det_descripcion").parent().find(".error").remove();
        $(this).find(".factura_gastos_det_descripcion").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
        cont++;
      }else {
        $(this).find(".factura_gastos_det_descripcion").parent().find(".error").remove();
        $(this).find(".factura_gastos_det_descripcion").removeClass("is-invalid");
      }
      if(!$(this).find(".factura_gastos_det_qty").val()) {
        $(this).find(".factura_gastos_det_qty").addClass("is-invalid");
        $(this).find(".factura_gastos_det_qty").parent().find(".error").remove();
        $(this).find(".factura_gastos_det_qty").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
        cont++;
      }else {
        $(this).find(".factura_gastos_det_qty").parent().find(".error").remove();
        $(this).find(".factura_gastos_det_qty").removeClass("is-invalid");
      }

      if(!$(this).find(".factura_gastos_det_price_unit").val()) {
        $(this).find(".factura_gastos_det_price_unit").addClass("is-invalid");
        $(this).find(".factura_gastos_det_price_unit").parent().parent().find(".error").remove();
        $(this).find(".factura_gastos_det_price_unit").parent().parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
        cont++;
      }else {
        $(this).find(".factura_gastos_det_price_unit").parent().find(".error").remove();
        $(this).find(".factura_gastos_det_price_unit").removeClass("is-invalid");
      }

      if(!$(this).find(".factura_gastos_det_price_tot").val()) {
        $(this).find(".factura_gastos_det_price_tot").addClass("is-invalid");
        $(this).find(".factura_gastos_det_price_tot").parent().parent().find(".error").remove();
        $(this).find(".factura_gastos_det_price_tot").parent().parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
        cont++;
      }else {
        $(this).find(".factura_gastos_det_price_tot").parent().parent().find(".error").remove();
        $(this).find(".factura_gastos_det_price_tot").removeClass("is-invalid");
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
