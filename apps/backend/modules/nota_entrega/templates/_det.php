<script type="text/javascript">
  function addDet(num, tipo) {
    var eid = $("#nota_entrega_empresa_id").val();
    var did = $("#nota_entrega_deposito_id").val();
    var cid = $("#nota_entrega_cliente_id").val();
    var r = $.ajax({
      type: 'GET',
      url: '<?php echo url_for('nota_entrega')?>'+'/addDetallesForm/<?php echo ($form->getObject()->isNew()?'':'?id='.$form->getObject()->getId()).($form->getObject()->isNew()?'?num=':'&num=')?>'+num+'&eid='+eid+"&cid="+cid+"&tipo="+tipo+"&did="+did,
      async: false
    }).responseText;
    return r;
  }
  $( document ).ready(function() {
    $('.add_item').click(function() {
     var items = $(".items").length + 1;
     if(items>30){
       $('#flash-error').html('<div id="alert" class="alert alert-warning alert-dismissible" style="margin: 15px 15px 0px 15px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fas fa-exclamation-triangle"></i> Alerta!</h4>ERROR, SOLO PUEDE INTRODUCIR 30 ITEMS EN LA NOTA DE ENTREGA.</div>');
       event.preventDefault();
       $("html, body").animate({ scrollTop: 0 }, 1000);
     } else {
       $("#item").append(addDet(items, 1));
       items = items + 1;
     }
    });
    $('.add_oferta').click(function() {
     var items = $(".items").length + 1;
     if(items>30){
       $('#flash-error').html('<div id="alert" class="alert alert-warning alert-dismissible" style="margin: 15px 15px 0px 15px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fas fa-exclamation-triangle"></i> Alerta!</h4>ERROR, SOLO PUEDE INTRODUCIR 30 ITEMS EN LA NOTA DE ENTREGA.</div>');
       event.preventDefault();
       $("html, body").animate({ scrollTop: 0 }, 1000);
     } else {
       $("#item").append(addDet(items, 2));
       items = items + 1;
     }
    });
  });
</script>

</div></div></div>

<div class="card card-primary cliente" id="sf_fieldset">
  <div class="card-body">
    <div id="campo_det">
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
  <div class="col-md-2 col-sm-12">
    <a class="btn btn-warning btn-block text-uppercase btn-align add_oferta" href="javascript:void(0)">
      <i class="fa fa-plus-square mr-2"></i>Agregar oferta
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
            <?php echo $form['subtotal']->render(array('class' => 'form-control subtotal money', 'readonly' => 'readonly'))?>
          </div>
        </div>
      </div>
      <div class="col-md-4"></div>
      <div class="col-md-2">
        <div class="form-group">
          <label>Descuento (%)</label>
          <?php echo $form['descuento']->render(array('class' => 'form-control descuento money'))?>
          <?php if ($form['descuento']->renderError())  { echo $form['subtotal']->renderError(); } ?>
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label>Descuento (Monto)</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">USD</span>
            </div>
            <input type="text" value="0" class="form-control descuento_monto money" readonly="readonly" id="descuento_monto">
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Subtotal menos descuento</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">USD</span>
            </div>
            <?php echo $form['subtotal_desc']->render(array('class' => 'form-control subtotal_desc money', 'readonly' => 'readonly'))?>
          </div>
        </div>
      </div>
      <div class="col-md-4"></div>
      <div class="col-md-2">
        <div class="form-group">
          <label>Iva (%)</label>
          <?php echo $form['iva']->render(array('class' => 'form-control iva money', 'readonly' => 'readonly', 'value' => '0'))?>
          <?php if ($form['iva']->renderError())  { echo $form['iva']->renderError(); } ?>
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label>Base Imponible</label>
          <?php echo $form['base_imponible']->render(array('class' => 'form-control base_imponible money', 'readonly' => 'readonly', 'value' => '0'))?>
          <?php if ($form['base_imponible']->renderError())  { echo $form['base_imponible']->renderError(); } ?>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Iva (Monto)</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">USD</span>
            </div>
            <?php echo $form['iva_monto']->render(array('class' => 'form-control iva_monto money', 'readonly' => 'readonly', 'value' => '0'))?>
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
            <?php echo $form['total']->render(array('class' => 'form-control total money', 'readonly' => 'readonly'))?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div><div><div>

<script>
  $(function () {
    $('.descuento').keyup(function(){
      sumar();
    });
    $('.det_qty').keyup(function(){
      sumar();
    });
  })
  function sumar() {
    $(".det_qty").each(function() {
      var tasa=number_float($("#nota_entrega_tasa_cambio").val());
      var qty=number_float(this.value);
      var punit=number_float($(this).parent().parent().parent().find('.det_unit').val());
      var total=qty*punit;
      var unit_bs = punit*tasa;
      var total_bs = total*tasa;
      var desc=number_float($("#nota_entrega_descuento").val());
      $(this).parent().parent().parent().find('.det_total').val(SetMoney(total));
      $(this).parent().parent().parent().find('.det_unit_bs').val(SetMoney(unit_bs));
      $(this).parent().parent().parent().find('.det_total_bs').val(SetMoney(total_bs));
      var sum=0, base_imponible=0;
      $(".det_total").each(function() {
        sum += +number_float(this.value);
        if($(this).parent().parent().parent().find(".det_exento").val().replace(/ /g,"_")=="NO_EXENTO") {
          base_imponible += +number_float(this.value);
        }
      });

      $("#nota_entrega_subtotal").val(SetMoney(sum));
      $("#nota_entrega_base_imponible").val(SetMoney(base_imponible));

      var subminusdesc=sum;
      if(desc>0) {
        var desc_monto = (sum*desc)/100;
        subminusdesc = sum-desc_monto;
        $("#descuento_monto").val(SetMoney(desc_monto));
      } else {
        $("#descuento_monto").val(0);
      }
      var iva=number_float($("#nota_entrega_iva").val());
      var iva_monto=(iva*base_imponible)/100;
      $("#nota_entrega_subtotal_desc").val(SetMoney(subminusdesc));
      $("#nota_entrega_iva_monto").val(SetMoney(iva_monto));
      var tot=subminusdesc+iva_monto;
      $("#nota_entrega_total").val(SetMoney(tot));
    });
  }

  function item_prod(num) {
    var id=$("#nota_entrega_nota_entrega_det_"+num+"_inventario_id").val();
    var tasa=number_float($("#nota_entrega_tasa_cambio").val());
    var tipo_precio = $("#cliente_price").text();
    var max = number_float($("#prods").find("#"+id+" .max").text());
    var precio = number_float($("#prods").find("#"+id+" .price_"+tipo_precio).text());
    var exento=$("#prods").find("#"+id+" .exento").text();
    $("#nota_entrega_nota_entrega_det_"+num+"_exento").val(exento);

    $("#nota_entrega_nota_entrega_det_"+num+"_max_item").val(max);
    $("#nota_entrega_nota_entrega_det_"+num+"_price_unit").val(SetMoney(precio));
    var qty = number_float($("#nota_entrega_nota_entrega_det_"+num+"_qty").val());
    var total = qty*precio;
    var unit_bs = precio*tasa;
    var total_bs = total*tasa;
    $("#nota_entrega_nota_entrega_det_"+num+"_price_tot").val(SetMoney(total));
    $("#nota_entrega_det_unit_"+num+"_bs").val(SetMoney(unit_bs));
    $("#nota_entrega_det_tot_"+num+"_bs").val(SetMoney(total_bs));

  }
  function item_prod2(num) {
    var id=$("#nota_entrega_nota_entrega_det_"+num+"_oferta_id").val();
    var tasa=number_float($("#nota_entrega_tasa_cambio").val());
    var max = number_float($("#nota_entrega_nota_entrega_det_"+num+"_oferta_id").parent().find("#"+id+" .max").text());
    var precio = number_float($("#nota_entrega_nota_entrega_det_"+num+"_oferta_id").parent().find("#"+id+" .price").text());
    var exento = $("#nota_entrega_nota_entrega_det_"+num+"_oferta_id").parent().find("#"+id+" .exento").text();
    $("#nota_entrega_nota_entrega_det_"+num+"_exento").val(exento);

    $("#nota_entrega_nota_entrega_det_"+num+"_max_item").val(max);
    $("#nota_entrega_nota_entrega_det_"+num+"_price_unit").val(SetMoney(precio));
    var qty = number_float($("#nota_entrega_nota_entrega_det_"+num+"_qty").val());
    var total = qty*precio;
    var unit_bs = precio*tasa;
    var total_bs = total*tasa;
    $("#nota_entrega_nota_entrega_det_"+num+"_price_tot").val(SetMoney(total));
    $("#nota_entrega_det_unit_"+num+"_bs").val(SetMoney(unit_bs));
    $("#nota_entrega_det_tot_"+num+"_bs").val(SetMoney(total_bs));
  }
  function del_usuario(e) {
    $(e).parent().parent().parent().remove();
    var cont=1;
    $( ".items" ).each(function( index ) {
      $(this).attr("id","sf_fieldset_det_"+cont);
      $(this).find(".card-title").text("item ["+cont+"]");
      $(this).find(".nota_entrega_det_inventario_id").attr("id","nota_entrega_nota_entrega_det_"+cont+"_inventario_id");
      $(this).find(".nota_entrega_det_inventario_id").attr("name","nota_entrega[nota_entrega_det]["+cont+"][inventario_id]");
      $(this).find(".nota_entrega_det_oferta_id").attr("id","nota_entrega_nota_entrega_det_"+cont+"_oferta_id");
      $(this).find(".nota_entrega_det_oferta_id").attr("name","nota_entrega[nota_entrega_det]["+cont+"][oferta_id]");
      $(this).find(".nota_entrega_det_qty").attr("id","nota_entrega_nota_entrega_det_"+cont+"_qty");
      $(this).find(".nota_entrega_det_qty").attr("name","nota_entrega[nota_entrega_det]["+cont+"][qty]");
      $(this).find(".nota_entrega_det_exento").attr("id","nota_entrega_nota_entrega_det_"+cont+"_exento");
      $(this).find(".nota_entrega_det_exento").attr("name","nota_entrega[nota_entrega_det]["+cont+"][exento]");
      $(this).find(".nota_entrega_det_price_unit").attr("id","nota_entrega_nota_entrega_det_"+cont+"_price_unit");
      $(this).find(".nota_entrega_det_price_unit").attr("name","nota_entrega[nota_entrega_det]["+cont+"][price_unit]");
      $(this).find(".nota_entrega_det_price_tot").attr("id","nota_entrega_nota_entrega_det_"+cont+"_price_tot");
      $(this).find(".nota_entrega_det_price_tot").attr("name","nota_entrega[nota_entrega_det]["+cont+"][price_tot]");
      $(this).find(".del_servicio").attr("id","del_"+cont);
      $(this).find(".max_item").attr("id","nota_entrega_nota_entrega_det_"+cont+"_max_item");
      $(this).find(".det_unit_bs").attr("id","nota_entrega_det_unit_"+cont+"_bs");
      $(this).find(".det_total_bs").attr("id","nota_entrega_det_tot_"+cont+"_bs");
      cont+=1;
    });
    sumar();
  };
  function valid_productid(id) {
    var cont=0;
    $(".items").each(function() {
      var idprod=$(this).find(".nota_entrega_det_inventario_id").val();
      if(idprod==id){
        cont+=1;
      }
    });
    if(cont>1){
      return 1;
    }
    return 0;
  }
  function valid_ofertaid(id) {
    var cont=0;
    $(".items").each(function() {
      var idprod=$(this).find(".nota_entrega_det_oferta_id").val();
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
    if(!$("#nota_entrega_fecha").val()) {
      $("#nota_entrega_fecha").addClass("is-invalid");
      $("#nota_entrega_fecha").parent().find(".error").remove();
      $("#nota_entrega_fecha").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
      cont++;
    }else {
      $("#nota_entrega_fecha").parent().find(".error").remove();
      $("#nota_entrega_fecha").removeClass("is-invalid");
    }
    if(!$("#nota_entrega_dias_credito").val()) {
      $("#nota_entrega_dias_credito").addClass("is-invalid");
      $("#nota_entrega_dias_credito").parent().find(".error").remove();
      $("#nota_entrega_dias_credito").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
      cont++;
    }else {
      $("#nota_entrega_dias_credito").parent().find(".error").remove();
      $("#nota_entrega_dias_credito").removeClass("is-invalid");
    }
    if(!$("#nota_entrega_tasa_cambio").val()) {
      $("#nota_entrega_tasa_cambio").addClass("is-invalid");
      $("#nota_entrega_tasa_cambio").parent().find(".error").remove();
      $("#nota_entrega_tasa_cambio").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
      cont++;
    }else {
      var tasa = number_float($("#nota_entrega_tasa_cambio").val());
      if (tasa<1) {
        $("#nota_entrega_tasa_cambio").addClass("is-invalid");
        $("#nota_entrega_tasa_cambio").parent().find(".error").remove();
        $("#nota_entrega_tasa_cambio").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Debe ser mayor a 0.</li></ul></div>" );
        cont++;
      } else {
        $("#nota_entrega_tasa_cambio").parent().find(".error").remove();
        $("#nota_entrega_tasa_cambio").removeClass("is-invalid");
      }
    }
    $(".items").each(function() {
      var idprod=$(this).find(".nota_entrega_det_inventario_id").val();
      if(idprod) {
        if(valid_productid(idprod)==1) {
          $(this).find(".nota_entrega_det_inventario_id").addClass("is-invalid");
          $(this).find(".nota_entrega_det_inventario_id").parent().find(".error").remove();
          $(this).find(".nota_entrega_det_inventario_id").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Item esta duplicado en la nota de entrega</li></ul></div>" );
          cont++;
        } else {
          $(this).find(".nota_entrega_det_inventario_id").parent().find(".error").remove();
          $(this).find(".nota_entrega_det_inventario_id").removeClass("is-invalid");
        }
      }
      var idoferta=$(this).find(".nota_entrega_det_oferta_id").val();
      if(idoferta) {
        if(valid_ofertaid(idoferta)==1) {
          $(this).find(".nota_entrega_det_oferta_id").addClass("is-invalid");
          $(this).find(".nota_entrega_det_oferta_id").parent().find(".error").remove();
          $(this).find(".nota_entrega_det_oferta_id").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Item esta duplicado en la nota de entrega</li></ul></div>" );
          cont++;
        } else {
          $(this).find(".nota_entrega_det_oferta_id").parent().find(".error").remove();
          $(this).find(".nota_entrega_det_oferta_id").removeClass("is-invalid");
        }
      }
      var max = number_float($(this).find(".max_item").val());
      var qty = number_float($(this).find(".nota_entrega_det_qty").val());
      if(qty>max) {
        $(this).find(".nota_entrega_det_qty").addClass("is-invalid");
        $(this).find(".nota_entrega_det_qty").parent().find(".error").remove();
        $(this).find(".nota_entrega_det_qty").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Excede la cant. en inventario</li></ul></div>" );
        cont++;
      }else {
        $(this).find(".nota_entrega_det_qty").parent().find(".error").remove();
        $(this).find(".nota_entrega_det_qty").removeClass("is-invalid");
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
