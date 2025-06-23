<script type="text/javascript">
  function addDet(num, tipo) {
    var eid = $("#orden_compra_empresa_id").val();
    var did = $("#orden_compra_deposito_id").val();
    var cid = $("#orden_compra_cliente_id").val();
    var r = $.ajax({
      type: 'GET',
      url: '<?php echo url_for('orden_compra')?>'+'/addDetallesForm/<?php echo ($form->getObject()->isNew()?'':'?id='.$form->getObject()->getId()).($form->getObject()->isNew()?'?num=':'&num=')?>'+num+'&eid='+eid+"&cid="+cid+"&tipo="+tipo+"&did="+did,
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
<?php if ($form['orden_compra_det']) : ?>
  <?php $numero=1 ?>
  <?php foreach ($form['orden_compra_det'] as $det): ?>
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
            <?php echo $form['total']->render(array('class' => 'form-control total money', 'readonly' => 'readonly'))?>
          </div>
        </div>
      </div>
      <div class="col-md-8"></div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Sub-Total BS</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">BS</span>
            </div>
            <input type="text" class="form-control total money" readonly="readonly" id="total_bs">
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
      var tasa=number_float($("#orden_compra_tasa_cambio").val());
      var qty=number_float(this.value);
      var punit=number_float($(this).parent().parent().parent().find('.det_unit').val());
      var total=qty*punit;
      var unit_bs = punit*tasa;
      var total_bs = total*tasa;
      $(this).parent().parent().parent().find('.det_total').val(SetMoney(total));
      $(this).parent().parent().parent().find('.det_unit_bs').val(SetMoney(unit_bs));
      $(this).parent().parent().parent().find('.det_total_bs').val(SetMoney(total_bs));
      var sum=0, base_imponible=0;
      $(".det_total").each(function() {
        sum += +number_float(this.value);
      });
      var sum_bs=sum*tasa;
      $("#orden_compra_total").val(SetMoney(sum));
      $("#total_bs").val(SetMoney(sum_bs));
    });
  }
  function item_prod(num) {
    var id=$("#orden_compra_orden_compra_det_"+num+"_inventario_id").val();
    var tasa=number_float($("#orden_compra_tasa_cambio").val());
    var tipo_precio = $("#cliente_price").text();
    var max = number_float($("#prods").find("#"+id+" .max").text());
    var precio = number_float($("#prods").find("#"+id+" .price_"+tipo_precio).text());

    $("#orden_compra_orden_compra_det_"+num+"_max_item").val(max);
    $("#orden_compra_orden_compra_det_"+num+"_price_unit").val(SetMoney(precio));
    var qty = number_float($("#orden_compra_orden_compra_det_"+num+"_qty").val());
    var total = qty*precio;
    var unit_bs = precio*tasa;
    var total_bs = total*tasa;
    $("#orden_compra_orden_compra_det_"+num+"_price_tot").val(SetMoney(total));
    $("#orden_compra_det_unit_"+num+"_bs").val(SetMoney(unit_bs));
    $("#orden_compra_det_tot_"+num+"_bs").val(SetMoney(total_bs));

  }
  function item_prod2(num) {
    var id=$("#orden_compra_orden_compra_det_"+num+"_oferta_id").val();
    var tasa=number_float($("#orden_compra_tasa_cambio").val());
    var max = number_float($("#orden_compra_orden_compra_det_"+num+"_oferta_id").parent().find("#"+id+" .max").text());
    var precio = number_float($("#orden_compra_orden_compra_det_"+num+"_oferta_id").parent().find("#"+id+" .price").text());

    $("#orden_compra_orden_compra_det_"+num+"_max_item").val(max);
    $("#orden_compra_orden_compra_det_"+num+"_price_unit").val(SetMoney(precio));
    var qty = number_float($("#orden_compra_orden_compra_det_"+num+"_qty").val());
    var total = qty*precio;
    var unit_bs = precio*tasa;
    var total_bs = total*tasa;
    $("#orden_compra_orden_compra_det_"+num+"_price_tot").val(SetMoney(total));
    $("#orden_compra_det_unit_"+num+"_bs").val(SetMoney(unit_bs));
    $("#orden_compra_det_tot_"+num+"_bs").val(SetMoney(total_bs));
  }
  function del_usuario(e) {
    $(e).parent().parent().parent().remove();
    var cont=1;
    $( ".items" ).each(function( index ) {
      $(this).attr("id","sf_fieldset_det_"+cont);
      $(this).find(".card-title").text("item ["+cont+"]");
      $(this).find(".orden_compra_det_inventario_id").attr("id","orden_compra_orden_compra_det_"+cont+"_inventario_id");
      $(this).find(".orden_compra_det_inventario_id").attr("name","orden_compra[orden_compra_det]["+cont+"][inventario_id]");
      $(this).find(".orden_compra_det_oferta_id").attr("id","orden_compra_orden_compra_det_"+cont+"_oferta_id");
      $(this).find(".orden_compra_det_oferta_id").attr("name","orden_compra[orden_compra_det]["+cont+"][oferta_id]");
      $(this).find(".orden_compra_det_qty").attr("id","orden_compra_orden_compra_det_"+cont+"_qty");
      $(this).find(".orden_compra_det_qty").attr("name","orden_compra[orden_compra_det]["+cont+"][qty]");
      $(this).find(".orden_compra_det_price_unit").attr("id","orden_compra_orden_compra_det_"+cont+"_price_unit");
      $(this).find(".orden_compra_det_price_unit").attr("name","orden_compra[orden_compra_det]["+cont+"][price_unit]");
      $(this).find(".orden_compra_det_price_tot").attr("id","orden_compra_orden_compra_det_"+cont+"_price_tot");
      $(this).find(".orden_compra_det_price_tot").attr("name","orden_compra[orden_compra_det]["+cont+"][price_tot]");
      $(this).find(".del_servicio").attr("id","del_"+cont);
      $(this).find(".max_item").attr("id","orden_compra_orden_compra_det_"+cont+"_max_item");
      $(this).find(".det_unit_bs").attr("id","orden_compra_det_unit_"+cont+"_bs");
      $(this).find(".det_total_bs").attr("id","orden_compra_det_tot_"+cont+"_bs");
      cont+=1;
    });
    sumar();
  };
  function valid_productid(id) {
    var cont=0;
    $(".items").each(function() {
      var idprod=$(this).find(".orden_compra_det_inventario_id").val();
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
      var idprod=$(this).find(".orden_compra_det_oferta_id").val();
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
    $(".items").each(function() {
      var idprod=$(this).find(".orden_compra_det_inventario_id").val();
      if(idprod) {
        if(valid_productid(idprod)==1) {
          $(this).find(".orden_compra_det_inventario_id").addClass("is-invalid");
          $(this).find(".orden_compra_det_inventario_id").parent().find(".error").remove();
          $(this).find(".orden_compra_det_inventario_id").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Item esta duplicado en la nota de entrega</li></ul></div>" );
          cont++;
        } else {
          $(this).find(".orden_compra_det_inventario_id").parent().find(".error").remove();
          $(this).find(".orden_compra_det_inventario_id").removeClass("is-invalid");
        }
      }
      if($(this).find(".orden_compra_det_inventario_id").length > 0) {
        if(!$(this).find(".orden_compra_det_inventario_id").val()) {
          $(this).find(".orden_compra_det_inventario_id").addClass("is-invalid");
          $(this).find(".orden_compra_det_inventario_id").parent().find(".error").remove();
          $(this).find(".orden_compra_det_inventario_id").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Campo requerido</li></ul></div>" );
          cont++;
        } else {
          $(this).find(".orden_compra_det_inventario_id").parent().find(".error").remove();
          $(this).find(".orden_compra_det_inventario_id").removeClass("is-invalid");
        }
      }
      var idoferta=$(this).find(".orden_compra_det_oferta_id").val();
      if(idoferta) {
        if(valid_ofertaid(idoferta)==1) {
          $(this).find(".orden_compra_det_oferta_id").addClass("is-invalid");
          $(this).find(".orden_compra_det_oferta_id").parent().find(".error").remove();
          $(this).find(".orden_compra_det_oferta_id").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Item esta duplicado en la nota de entrega</li></ul></div>" );
          cont++;
        } else {
          $(this).find(".orden_compra_det_oferta_id").parent().find(".error").remove();
          $(this).find(".orden_compra_det_oferta_id").removeClass("is-invalid");
        }
      }
      if($(this).find(".orden_compra_det_oferta_id").length > 0) {
        if(!$(this).find(".orden_compra_det_oferta_id").val()) {
          $(this).find(".orden_compra_det_oferta_id").addClass("is-invalid");
          $(this).find(".orden_compra_det_oferta_id").parent().find(".error").remove();
          $(this).find(".orden_compra_det_oferta_id").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Campo requerido</li></ul></div>" );
          cont++;
        } else {
          $(this).find(".orden_compra_det_oferta_id").parent().find(".error").remove();
          $(this).find(".orden_compra_det_oferta_id").removeClass("is-invalid");
        }
      }

      if(!$(this).find(".orden_compra_det_qty").val()) {
        $(this).find(".orden_compra_det_price_tot").addClass("is-invalid");
        $(this).find(".orden_compra_det_price_tot").parent().parent().find(".error").remove();
        $(this).find(".orden_compra_det_price_tot").parent().parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Cantidad requerida</li></ul></div>" );
        cont++;
      } else {
        $(this).find(".orden_compra_det_price_tot").parent().parent().find(".error").remove();
        $(this).find(".orden_compra_det_price_tot").removeClass("is-invalid");
      }

      var max = number_float($(this).find(".max_item").val());
      var qty = number_float($(this).find(".orden_compra_det_qty").val());
      if(qty>max) {
        $(this).find(".orden_compra_det_qty").addClass("is-invalid");
        $(this).find(".orden_compra_det_qty").parent().find(".error").remove();
        $(this).find(".orden_compra_det_qty").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Excede la cant. en inventario</li></ul></div>" );
        cont++;
      }else {
        $(this).find(".orden_compra_det_qty").parent().find(".error").remove();
        $(this).find(".orden_compra_det_qty").removeClass("is-invalid");
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
