<?php if($sf_params->get('cc')=="1"): ?>
  <?php 
    $cc=Doctrine_Core::getTable('CotizacionCompra')->findOneBy('id',$sf_params->get('id'));
    $emp=Doctrine_Core::getTable('Empresa')->findOneBy('id',$cc->getEmpresaId());
    $proveedor=Doctrine_Core::getTable('Proveedor')->findOneBy('id',$cc->getProveedorId());
  ?>

<?php if($form->getObject()->isNew()) { ?>
  <input type="hidden" name="ordenes_compra[id]" id="cod" readonly value="1"/>
  <input type="hidden" name="ordenes_compra[cotizacion_compra_id]" id="cod2" readonly value="<?php echo $cc->getId(); ?>"/>
<?php } else { ?>
  <input readonly type="hidden" name="ordenes_compra[id]" id="ordenes_compra_id" value="<?php echo $form->getObject()->getId() ?>"/>
  <input readonly type="hidden" name="ordenes_compra[cotizacion_compra_id]" id="ordenes_compra_cotizacion_compra_id" value="<?php echo $form->getObject()->getCotizacionCompraId() ?>"/>
<?php } ?>

  <div class="col-md-6">
    <div class="form-group">
      <label for="ordenes_compra_empresa_id">Empresa</label>
      <select name="ordenes_compra[empresa_id]" class="form-control" id="ordenes_compra_empresa_id">
        <option value="<?php echo $emp->getId(); ?>"><?php echo $emp->getNombre(); ?></option>
      </select>
    </div>
  </div>
  <div class="col-md-8">
    <div class="form-group">
      <label for="ordenes_compra_proveedor_id">Proveedor</label>
      <select name="ordenes_compra[proveedor_id]" class="form-control" id="ordenes_compra_proveedor_id">
        <option value="<?php echo $proveedor->getId(); ?>"><?php echo $proveedor->getFullName()." [".$proveedor->getDocId()."]"; ?></option>
      </select>
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label for="ordenes_compra_dias_credito">Dias credito</label>
      <input type="text" name="ordenes_compra[dias_credito]" value="<?php echo $cc->getDiasCredito(); ?>" class="form-control diascredito" id="ordenes_compra_dias_credito">
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label for="ordenes_compra_tasa_cambio">Tasa cambio</label>
      <input type="text" name="ordenes_compra[tasa_cambio]" class="form-control money" id="ordenes_compra_tasa_cambio" value="<?php echo $cc->getTasaCambio(); ?>">
    </div>
  </div>
  </div></div></div>

  <div class="card card-primary cliente" id="sf_fieldset">
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="ordenes_compra_razon_social">Razon social</label>
            <input value="<?php echo $proveedor->getFullName()?>" type="text" name="ordenes_compra[razon_social]" class="form-control" readonly="readonly" id="ordenes_compra_razon_social">
          </div>
        </div>
        <div class="col-md-3"></div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="ordenes_compra_doc_id">Doc. de Identidad</label>
            <input value="<?php echo $proveedor->getDocId()?>" type="text" name="ordenes_compra[doc_id]" class="form-control" readonly="readonly" id="ordenes_compra_doc_id">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="ordenes_compra_direccion">Direccion</label>
            <input value="<?php echo ($proveedor->getDireccion()) ?>" type="text" name="ordenes_compra[direccion]" class="form-control" readonly="readonly" id="ordenes_compra_direccion">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3">
          <div class="form-group">
            <label for="ordenes_compra_telf">Telf</label>
            <input value="<?php echo $proveedor->getTelf()?>" type="text" name="ordenes_compra[telf]" class="form-control" readonly="readonly" id="ordenes_compra_telf">
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
                <span class="input-group-text">USD</span>
              </div>
              <?php echo $form['subtotal']->render(array('class' => 'form-control subtotal', 'readonly' => 'readonly'))?>
            </div>
          </div>
        </div>
        <div class="col-md-6"></div>
        <div class="col-md-2">
          <div class="form-group">
            <label>Descuento (%)</label>
            <?php echo $form['descuento']->render(array('value' => $cc->getDescuento(), 'class' => 'form-control descuento money', 'required' => 'required'))?>
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
    function addDet(num) {
      var r = $.ajax({
        type: 'GET',
        url: '<?php echo url_for('ordenes_compra')?>'+'/addDetallesForm/<?php echo ($form->getObject()->isNew()?'':'?id='.$form->getObject()->getId()).($form->getObject()->isNew()?'?num=':'&num=')?>'+num,
        async: false
      }).responseText;
      return r;
    }
    function addDet2(num, ccdid) {
      var r = $.ajax({
        type: 'GET',
        url: '<?php echo url_for('ordenes_compra')?>'+'/addDetallesForm/<?php echo ($form->getObject()->isNew()?'':'?id='.$form->getObject()->getId()).($form->getObject()->isNew()?'?num=':'&num=')?>'+num+'&ccdid='+ccdid,
        async: false
      }).responseText;
      return r;
    }
    <?php
      $results = Doctrine_Query::create()
        ->select('ccd.id as id')
        ->from('CotizacionCompraDet ccd')
        ->where('ccd.cotizacion_compra_id = ?', $cc->getId())
        ->orderBy('ccd.id ASC')
        ->execute();
      foreach ($results as $result){
        echo "addItem2(".$result["id"].");";
      }
      echo "sumar()";
    ?>
    
    $('.add_item').click(function() {
      var items = $(".items").length + 1;
      $("#item").append(addDet(items));
      items = items + 1;
    });

    function addItem2(ccid) {
      var items = $(".items").length + 1;
      $("#item").append(addDet2(items, ccid));      
    }

    $(function () {
      $('#ordenes_compra_tasa_cambio').keyup(function(){
        sumar();
      });
      $('.descuento').keyup(function(){
        sumar();
      });
    });
    function sumar() {
      $(".det_qty").each(function() {
        var tasa=number_float($("#ordenes_compra_tasa_cambio").val());
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
      $("#ordenes_compra_subtotal").val(SetMoney(sum));
      var desc=number_float($("#ordenes_compra_descuento").val());
      var subminusdesc=sum;
      if(desc>0) {
        var desc_monto = setAndFormat((sum*desc)/100);
        subminusdesc = sum-desc_monto;
        $("#descuento_monto").val(SetMoney(desc_monto));
      } else {
        $("#descuento_monto").val("0,0000");
      }
      $("#ordenes_compra_subtotal_desc").val(SetMoney(subminusdesc));
      $("#ordenes_compra_total").val(SetMoney(subminusdesc));
    }
    function sumarBs() {
      $(".det_qty").each(function() {
        var tasa=number_float($("#ordenes_compra_tasa_cambio").val());
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
      $("#ordenes_compra_subtotal").val(SetMoney(sum));
      var desc=number_float($("#ordenes_compra_descuento").val());
      var subminusdesc=sum;
      if(desc>0) {
        var desc_monto = setAndFormat((sum*desc)/100);
        subminusdesc = sum-desc_monto;
        $("#descuento_monto").val(SetMoney(desc_monto));
      } else {
        $("#descuento_monto").val("0,0000");
      }
      $("#ordenes_compra_subtotal_desc").val(SetMoney(subminusdesc));
      $("#ordenes_compra_total").val(SetMoney(subminusdesc));
    }
    function del_usuario(e) {
      $(e).parent().parent().parent().remove();
      var cont=1;
      $( ".items" ).each(function( index ) {
        $(this).attr("id","sf_fieldset_det_"+cont);
        $(this).find(".card-title").text("item ["+cont+"]");
        $(this).find(".ordenes_compra_det_producto_id").attr("id","ordenes_compra_ordenes_compra_det_"+cont+"_producto_id");
        $(this).find(".ordenes_compra_det_producto_id").attr("name","ordenes_compra[ordenes_compra_det]["+cont+"][producto_id]");
        $(this).find(".ordenes_compra_det_qty").attr("id","ordenes_compra_ordenes_compra_det_"+cont+"_qty");
        $(this).find(".ordenes_compra_det_qty").attr("name","ordenes_compra[ordenes_compra_det]["+cont+"][qty]");
        $(this).find(".ordenes_compra_det_price_unit").attr("id","ordenes_compra_ordenes_compra_det_"+cont+"_price_unit");
        $(this).find(".ordenes_compra_det_price_unit").attr("name","ordenes_compra[ordenes_compra_det]["+cont+"][price_unit]");
        $(this).find(".ordenes_compra_det_price_tot").attr("id","ordenes_compra_ordenes_compra_det_"+cont+"_price_tot");
        $(this).find(".ordenes_compra_det_price_tot").attr("name","ordenes_compra[ordenes_compra_det]["+cont+"][price_tot]");
        $(this).find(".del_servicio").attr("id","del_"+cont);
        $(this).find(".det_unit_bs").attr("id","ordenes_compra_det_unit_"+cont+"_bs");
        $(this).find(".det_total_bs").attr("id","ordenes_compra_det_tot_"+cont+"_bs");
        cont+=1;
      });
      sumar();
    };
    function valid_productid(id) {
      var cont=0;
      $(".items").each(function() {
        var idprod=$(this).find(".ordenes_compra_det_producto_id").val();
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
      if(!$("#ordenes_compra_dias_credito").val()) {
        $("#ordenes_compra_dias_credito").addClass("is-invalid");
        $("#ordenes_compra_dias_credito").parent().find(".error").remove();
        $("#ordenes_compra_dias_credito").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
        cont++;
      }else {
        $("#ordenes_compra_dias_credito").parent().find(".error").remove();
        $("#ordenes_compra_dias_credito").removeClass("is-invalid");
      }
      if(!$("#ordenes_compra_tasa_cambio").val()) {
        $("#ordenes_compra_tasa_cambio").addClass("is-invalid");
        $("#ordenes_compra_tasa_cambio").parent().find(".error").remove();
        $("#ordenes_compra_tasa_cambio").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
        cont++;
      }else {
        var tasa = number_float($("#ordenes_compra_tasa_cambio").val());
        if (tasa<1) {
          $("#ordenes_compra_tasa_cambio").addClass("is-invalid");
          $("#ordenes_compra_tasa_cambio").parent().find(".error").remove();
          $("#ordenes_compra_tasa_cambio").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Debe ser mayor a 0.</li></ul></div>" );
          cont++;
        } else {
          $("#ordenes_compra_tasa_cambio").parent().find(".error").remove();
          $("#ordenes_compra_tasa_cambio").removeClass("is-invalid");
        }
      }
      $(".items").each(function() {
        if(!$(this).find(".ordenes_compra_det_producto_id").val()) {
          $(this).find(".ordenes_compra_det_producto_id").addClass("is-invalid");
          $(this).find(".ordenes_compra_det_producto_id").parent().find(".error").remove();
          $(this).find(".ordenes_compra_det_producto_id").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
          cont++;
        }else {
          $(this).find(".ordenes_compra_det_producto_id").parent().find(".error").remove();
          $(this).find(".ordenes_compra_det_producto_id").removeClass("is-invalid");
        }

        var idprod=$(this).find(".ordenes_compra_det_producto_id").val();
        if(idprod) {
          if(valid_productid(idprod)==1) {
            $(this).find(".ordenes_compra_det_producto_id").addClass("is-invalid");
            $(this).find(".ordenes_compra_det_producto_id").parent().find(".error").remove();
            $(this).find(".ordenes_compra_det_producto_id").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Item esta duplicado</li></ul></div>" );
            cont++;
          } else {
            $(this).find(".ordenes_compra_det_producto_id").parent().find(".error").remove();
            $(this).find(".ordenes_compra_det_producto_id").removeClass("is-invalid");
          }
        }
        if(!$(this).find(".ordenes_compra_det_qty").val()) {
          $(this).find(".ordenes_compra_det_qty").addClass("is-invalid");
          $(this).find(".ordenes_compra_det_qty").parent().find(".error").remove();
          $(this).find(".ordenes_compra_det_qty").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
          cont++;
        }else {
          $(this).find(".ordenes_compra_det_qty").parent().find(".error").remove();
          $(this).find(".ordenes_compra_det_qty").removeClass("is-invalid");
        }

        if(!$(this).find(".ordenes_compra_det_price_unit").val()) {
          $(this).find(".ordenes_compra_det_price_unit").addClass("is-invalid");
          $(this).find(".ordenes_compra_det_price_unit").parent().parent().find(".error").remove();
          $(this).find(".ordenes_compra_det_price_unit").parent().parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
          cont++;
        }else {
          $(this).find(".ordenes_compra_det_price_unit").parent().find(".error").remove();
          $(this).find(".ordenes_compra_det_price_unit").removeClass("is-invalid");
        }

        if(!$(this).find(".ordenes_compra_det_price_tot").val()) {
          $(this).find(".ordenes_compra_det_price_tot").addClass("is-invalid");
          $(this).find(".ordenes_compra_det_price_tot").parent().parent().find(".error").remove();
          $(this).find(".ordenes_compra_det_price_tot").parent().parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
          cont++;
        }else {
          $(this).find(".ordenes_compra_det_price_tot").parent().parent().find(".error").remove();
          $(this).find(".ordenes_compra_det_price_tot").removeClass("is-invalid");
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
          var id = $("#cod2").val();
          var json_obj = JSON.parse(Get("<?php echo url_for("ordenes_compra");?>/prefijo?search="+id));
          if(json_obj !== "0") {
            cont++;
          }
          if(cont>0) {
            $('#flash-error').html('<div id="alert" class="alert alert-warning alert-dismissible" style="margin: 15px 15px 0px 15px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fas fa-exclamation-triangle"></i> Alerta!</h4>ERROR, ESTA COTIZACION DE COMPRA YA HA SIDO PROCESADA PREVIAMENTE.</div>');
            event.preventDefault();
            $("html, body").animate({ scrollTop: 0 }, 1000);
          } else {
            $('#loading').fadeIn( "slow", function() {});
          }
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
<?php endif; ?>