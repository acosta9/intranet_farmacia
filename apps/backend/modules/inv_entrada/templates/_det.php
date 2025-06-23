<script type="text/javascript">
  function addDet(num) {
    var r = $.ajax({
      type: 'GET',
      url: '<?php echo url_for('inv_entrada')?>'+'/addDetallesForm/<?php echo ($form->getObject()->isNew()?'':'?id='.$form->getObject()->getId()).($form->getObject()->isNew()?'?num=':'&num=')?>'+num,
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

<script type="text/javascript">
  $(function () {
    $('.det_qty').keyup(function(){
      sumar();
    });
  });
  function sumar() {
    $(".det_qty").each(function() {
      var qty=number_float(this.value);
      var punit=$(this).parent().parent().parent().find('.det_unit').val();
      var total=setAndFormat(qty*punit);
      $(this).parent().parent().parent().find('.det_total').val(total);
      var sum=0;
      $(".det_total").each(function() {
        sum += +number_float(this.value);
      });

      $("#inv_entrada_total").val(sum);
    });
  }
  function del_usuario(e) {
    $(e).parent().parent().parent().remove();
    var cont=1;
    $( ".items" ).each(function( index ) {
      $(this).attr("id","sf_fieldset_det_"+cont);
      $(this).find(".card-title").text("item ["+cont+"]");
      $(this).find(".inv_entrada_det_inventario_id").attr("id","inv_entrada_inv_entrada_det_"+cont+"_inventario_id");
      $(this).find(".inv_entrada_det_inventario_id").attr("name","inv_entrada[inv_entrada_det]["+cont+"][inventario_id]");
      $(this).find(".inv_entrada_det_qty").attr("id","inv_entrada_inv_entrada_det_"+cont+"_qty");
      $(this).find(".inv_entrada_det_qty").attr("name","inv_entrada[inv_entrada_det]["+cont+"][qty]");
      $(this).find(".inv_entrada_det_price_unit").attr("id","inv_entrada_inv_entrada_det_"+cont+"_price_unit");
      $(this).find(".inv_entrada_det_price_unit").attr("name","inv_entrada[inv_entrada_det]["+cont+"][price_unit]");
      $(this).find(".inv_entrada_det_price_tot").attr("id","inv_entrada_inv_entrada_det_"+cont+"_price_tot");
      $(this).find(".inv_entrada_det_price_tot").attr("name","inv_entrada[inv_entrada_det]["+cont+"][price_tot]");
      $(this).find(".inv_entrada_det_fecha_venc").attr("id","inv_entrada_inv_entrada_det_"+cont+"_fecha_venc");
      $(this).find(".inv_entrada_det_fecha_venc").attr("name","inv_entrada[inv_entrada_det]["+cont+"][fecha_venc]");
      $(this).find(".inv_entrada_det_lote").attr("id","inv_entrada_inv_entrada_det_"+cont+"_lote");
      $(this).find(".inv_entrada_det_lote").attr("name","inv_entrada[inv_entrada_det]["+cont+"][lote]");
      $(this).find(".del_servicio").attr("id","del_"+cont);
      cont+=1;
    });
    sumar();
  };
  function valid_productid(id) {
    var cont=0;
    $(".items").each(function() {
      var idprod=$(this).find(".inv_entrada_det_inventario_id").val();
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
    if(!$("#inv_entrada_descripcion").val()) {
      $("#inv_entrada_descripcion").addClass("is-invalid");
      $("#inv_entrada_descripcion").parent().find(".error").remove();
      $("#inv_entrada_descripcion").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
      cont++;
    }else {
      $("#inv_entrada_descripcion").parent().find(".error").remove();
      $("#inv_entrada_descripcion").removeClass("is-invalid");
    }
    if(!$("#inv_entrada_deposito_id").val()) {
      $("#inv_entrada_deposito_id").addClass("is-invalid");
      $("#inv_entrada_deposito_id").parent().find(".error").remove();
      $("#inv_entrada_deposito_id").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
      cont++;
    }else {
      $("#inv_entrada_deposito_id").parent().find(".error").remove();
      $("#inv_entrada_deposito_id").removeClass("is-invalid");
    }
    $(".items").each(function() {
      var idprod=$(this).find(".inv_entrada_det_inventario_id").val();
      if(idprod) {
        if(valid_productid(idprod)==1) {
          $(this).find(".inv_entrada_det_inventario_id").addClass("is-invalid");
          $(this).find(".inv_entrada_det_inventario_id").parent().find(".error").remove();
          $(this).find(".inv_entrada_det_inventario_id").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Item esta duplicado en el documento</li></ul></div>" );
          cont++;
        } else {
          $(this).find(".inv_entrada_det_inventario_id").parent().find(".error").remove();
          $(this).find(".inv_entrada_det_inventario_id").removeClass("is-invalid");
        }
      }
      if(!$(".inv_entrada_det_fecha_venc").val()) {
        $(".inv_entrada_det_fecha_venc").addClass("is-invalid");
        $(".inv_entrada_det_fecha_venc").parent().find(".error").remove();
        $(".inv_entrada_det_fecha_venc").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
        cont++;
      }else {
        $(".inv_entrada_det_fecha_venc").parent().find(".error").remove();
        $(".inv_entrada_det_fecha_venc").removeClass("is-invalid");
      }
      if(!$(".inv_entrada_det_lote").val()) {
        $(".inv_entrada_det_lote").addClass("is-invalid");
        $(".inv_entrada_det_lote").parent().find(".error").remove();
        $(".inv_entrada_det_lote").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
        cont++;
      }else {
        $(".inv_entrada_det_lote").parent().find(".error").remove();
        $(".inv_entrada_det_lote").removeClass("is-invalid");
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
<div id="campo_inv"></div>
<div id="item"></div>

<div><div><div>
