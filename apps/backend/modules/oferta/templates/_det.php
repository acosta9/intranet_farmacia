<script type="text/javascript">
  function addDet(num) {
    var r = $.ajax({
      type: 'GET',
      url: '<?php echo url_for('oferta')?>'+'/addDetallesForm/<?php echo ($form->getObject()->isNew()?'':'?id='.$form->getObject()->getId()).($form->getObject()->isNew()?'?num=':'&num=')?>'+num+'&did='+$("#oferta_deposito_id").val(),
      async: false
    }).responseText;
    return r;
  }
  $( document ).ready(function() {
    $('.add_item').click(function() {
      var items = $(".items").length + 1;
      var tipo = $("#oferta_tipo_oferta").val();
      if((tipo==1 || tipo==2) && items==1) {
        $("#item").append(addDet(items));
        items = items + 1;
      } else if(tipo==3){
        $("#item").append(addDet(items));
        items = items + 1;
      } else {
        $('#flash-error').html('<div id="alert" class="alert alert-warning alert-dismissible" style="margin: 15px 15px 0px 15px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fas fa-exclamation-triangle"></i> Alerta!</h4>ERROR, SOLO PUEDE INTRODUCIR 1 ITEM PARA EL TIPO DE OFERTA.</div>');
        event.preventDefault();
        $("html, body").animate({ scrollTop: 0 }, 1000);
      }
    });
  });
</script>

</div></div></div>

<?php if ($form['oferta_det']) : ?>
    <?php $numero=1 ?>
    <?php foreach ($form['oferta_det'] as $det){ ?>
      <div class="card card-primary items" id="sf_fieldset_det_<?php echo $numero?>">
        <div class="card-header">
          <h3 class="card-title">producto [<?php echo $numero?>]</h3>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <?php echo $det['inventario_id']->renderLabel()?>
                <?php echo $det['inventario_id']->render(array('class' => 'form-control oferta_det_inventario_id'))?>
                <?php if ($det['inventario_id']->renderError())  { echo $det['inventario_id']->renderError(); } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php $numero=$numero+1; ?>
  <?php } ?>
<?php endif; ?>
<script type="text/javascript">
  $(function () {
    $('#oferta_precio_usd').keyup(function(){
      sumar();
    });
  })
  function sumar() {
    var tasa=number_float($("#tasa").val());
    var pusd=number_float($('#oferta_precio_usd').val());
    var pbs=tasa*pusd;
    $("#precio_bs").val(SetMoney(pbs));
  }
  function del_item(e) {
    $(e).parent().parent().parent().remove();
    var cont=1;
    $( ".items" ).each(function( index ) {
      $(this).attr("id","sf_fieldset_det_"+cont);
      $(this).find(".card-title").text("producto ["+cont+"]");
      $(this).find(".oferta_det_inventario_id").attr("id","oferta_oferta_det_"+cont+"_inventario_id");
      $(this).find(".oferta_det_inventario_id").attr("name","oferta[oferta_det]["+cont+"][inventario_id]");
      $(this).find(".del_servicio").attr("id","del_"+cont);
      cont+=1;
    });
  };
  function valid_id(id) {
    var cont=0;
    $(".items").each(function() {
      var idprod=$(this).find(".oferta_det_inventario_id").val();
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

    if(!$("#oferta_nombre").val()) {
      $("#oferta_nombre").addClass("is-invalid");
      $("#oferta_nombre").parent().find(".error").remove();
      $("#oferta_nombre").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
      cont++;
    }else {
      $("#oferta_nombre").parent().find(".error").remove();
      $("#oferta_nombre").removeClass("is-invalid");
    }

    if(!$("#oferta_empresa_id").val()) {
      $("#oferta_empresa_id").addClass("is-invalid");
      $("#oferta_empresa_id").parent().find(".error").remove();
      $("#oferta_empresa_id").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
      cont++;
    }else {
      $("#oferta_empresa_id").parent().find(".error").remove();
      $("#oferta_empresa_id").removeClass("is-invalid");
    }

    if(!$("#oferta_deposito_id").val()) {
      $("#oferta_deposito_id").addClass("is-invalid");
      $("#oferta_deposito_id").parent().find(".error").remove();
      $("#oferta_deposito_id").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
      cont++;
    }else {
      $("#oferta_deposito_id").parent().find(".error").remove();
      $("#oferta_deposito_id").removeClass("is-invalid");
    }

    if(!$("#oferta_fecha").val()) {
      $("#oferta_fecha").addClass("is-invalid");
      $("#oferta_fecha").parent().find(".error").remove();
      $("#oferta_fecha").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
      cont++;
    }else {
      $("#oferta_fecha").parent().find(".error").remove();
      $("#oferta_fecha").removeClass("is-invalid");
    }

    if(!$("#oferta_fecha_venc").val()) {
      $("#oferta_fecha_venc").addClass("is-invalid");
      $("#oferta_fecha_venc").parent().find(".error").remove();
      $("#oferta_fecha_venc").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
      cont++;
    }else {
      $("#oferta_fecha_venc").parent().find(".error").remove();
      $("#oferta_fecha_venc").removeClass("is-invalid");
    }

    if(!$("#oferta_precio_usd").val()) {
      $("#oferta_precio_usd").addClass("is-invalid");
      $("#oferta_precio_usd").parent().parent().find(".error").remove();
      $("#oferta_precio_usd").parent().parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
      cont++;
    }else {
      if(number_float($("#oferta_precio_usd").val())<0.0100) {          
        $("#oferta_precio_usd").addClass("is-invalid");
        $("#oferta_precio_usd").parent().parent().find(".error").remove();
        $("#oferta_precio_usd").parent().parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Debe ser un numero mayor o igual a 0,0100</li></ul></div>" );
        cont++;
      } else {
        $("#oferta_precio_usd").parent().parent().find(".error").remove();
        $("#oferta_precio_usd").removeClass("is-invalid");
      }
    }

    var tipo = $("#oferta_tipo_oferta").val();
    if(tipo==2) {
      if(!$("#oferta_qty").val()) {
        $("#oferta_qty").addClass("is-invalid");
        $("#oferta_qty").parent().find(".error").remove();
        $("#oferta_qty").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
        cont++;
      }else {
        if(number_float($("#oferta_qty").val())<2) {          
          $("#oferta_qty").addClass("is-invalid");
          $("#oferta_qty").parent().find(".error").remove();
          $("#oferta_qty").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Debe ser un numero mayor o igual a 2.</li></ul></div>" );
          cont++;
        } else {
          $("#oferta_qty").parent().find(".error").remove();
          $("#oferta_qty").removeClass("is-invalid");
        }
      }
    }

    $(".items").each(function() {
      var idprod=$(this).find(".oferta_det_inventario_id").val();
      if(valid_id(idprod)==1) {
        $(this).find(".oferta_det_inventario_id").addClass("is-invalid");
        $(this).find(".oferta_det_inventario_id").parent().find(".error").remove();
        $(this).find(".oferta_det_inventario_id").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Item esta duplicado</li></ul></div>" );
        cont++;
      } else {
        $(this).find(".oferta_det_inventario_id").parent().find(".error").remove();
        $(this).find(".oferta_det_inventario_id").removeClass("is-invalid");
      }
      if(!$(this).find(".oferta_det_inventario_id").val()) {
        $(this).find(".oferta_det_inventario_id").addClass("is-invalid");
        $(this).find(".oferta_det_inventario_id").parent().find(".error").remove();
        $(this).find(".oferta_det_inventario_id").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Campo requerido</li></ul></div>" );
        cont++;
      } else {
        $(this).find(".oferta_det_inventario_id").parent().find(".error").remove();
        $(this).find(".oferta_det_inventario_id").removeClass("is-invalid");
      }
      sum += 1;
    });
    if(sum==0) {
      $('#flash-error').html('<div id="alert" class="alert alert-warning alert-dismissible" style="margin: 15px 15px 0px 15px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fas fa-exclamation-triangle"></i> Alerta!</h4>ERROR, DEBE INTRODUCIR AL MENOS 1 PRODUCTO.</div>');
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
</script>

<div id="item"></div>
<div><div><div>
