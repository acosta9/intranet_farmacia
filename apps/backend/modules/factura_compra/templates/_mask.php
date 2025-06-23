<?php if($sf_params->get('oc')=="1"): ?>
  <?php 
    $oc=Doctrine_Core::getTable('OrdenesCompra')->findOneBy('id',$sf_params->get('id'));
    $emp=Doctrine_Core::getTable('Empresa')->findOneBy('id',$oc->getEmpresaId());
    $proveedor=Doctrine_Core::getTable('Proveedor')->findOneBy('id',$oc->getProveedorId());
  ?>

<?php if($form->getObject()->isNew()) { ?>
  <input type="hidden" name="factura_compra[id]" id="cod" readonly value="1"/>
  <input type="hidden" name="factura_compra[ordenes_compra_id]" id="cod2" readonly value="<?php echo $oc->getId(); ?>"/>
<?php } else { ?>
  <input readonly type="hidden" name="factura_compra[id]" id="factura_compra_id" value="<?php echo $form->getObject()->getId() ?>"/>
  <input readonly type="hidden" name="factura_compra[ordenes_compra_id]" id="factura_compra_ordenes_compra_id" value="<?php echo $form->getObject()->getOrdenesCompraId() ?>"/>
<?php } ?>

  <div class="col-md-6">
    <div class="form-group">
      <label for="factura_compra_empresa_id">Empresa</label>
      <select name="factura_compra[empresa_id]" class="form-control" id="factura_compra_empresa_id">
        <option value="<?php echo $emp->getId(); ?>"><?php echo $emp->getNombre(); ?></option>
      </select>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label for="factura_compra_deposito_id">Deposito</label>
      <select name="factura_compra[deposito_id]" class="form-control" id="factura_compra_deposito_id">
      <?php
        $results = Doctrine_Query::create()
          ->select('sc.id as scid, e.id as eid, e.acronimo as emin, eu.user_id, id.id as idid, id.nombre as idname')
          ->from('ServerConf sc')
          ->leftJoin('sc.Empresa e')
          ->leftJoin('sc.InvDeposito id')
          ->leftJoin('e.EmpresaUser eu')
          ->where('eu.user_id = ?', $sf_user->getGuardUser()->getId())
          ->andWhere('id.tipo = ?', 0)
          ->orderBy('id.nombre ASC')
          ->groupBy('id.nombre')
          ->execute();
        foreach ($results as $result) {
          echo "<option value='".$result["idid"]."'>".$result["emin"]." - ".$result["idname"]."</option>";
        }
      ?>
      </select>
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label for="factura_compra_proveedor_id">Proveedor</label>
      <select name="factura_compra[proveedor_id]" class="form-control" id="factura_compra_proveedor_id">
        <option value="<?php echo $proveedor->getId(); ?>"><?php echo $proveedor->getFullName()." [".$proveedor->getDocId()."]"; ?></option>
      </select>
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label for="factura_compra_num_factura">N° de Factura</label>
      <input type="text" name="factura_compra[num_factura]" class="form-control" id="factura_compra_num_factura">
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label for="factura_compra_ncontrol">N° de Control</label>
      <input type="text" name="factura_compra[ncontrol]" class="form-control" id="factura_compra_ncontrol">
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label for="factura_compra_fecha">Fecha de Emisión</label>
      <input type="text" name="factura_compra[fecha]" value="<?php $date2 = new DateTime(); echo $date2->format('Y-m-d'); ?>" class="form-control dateonly" id="factura_compra_fecha" readonly="readonly">
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label for="factura_compra_fecha_recepcion">Fecha de recepcion</label>
      <input type="text" name="factura_compra[fecha_recepcion]" value="<?php echo $date2->format('Y-m-d'); ?>" class="form-control dateonly" id="factura_compra_fecha_recepcion" readonly="readonly">
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label for="factura_compra_tasa_cambio">Tasa cambio</label>
      <input type="text" name="factura_compra[tasa_cambio]" class="form-control money" id="factura_compra_tasa_cambio" value="<?php echo $oc->getTasaCambio(); ?>">
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label for="factura_compra_dias_credito">Dias credito</label>
      <input type="text" name="factura_compra[dias_credito]" value="<?php echo $oc->getDiasCredito(); ?>" class="form-control diascredito" id="factura_compra_dias_credito">
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label for="factura_compra_estatus_oc">Estatus OC</label>
      <?php echo $form['estatus_oc']->render(array('class' => 'form-control'))?>
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label for="factura_compra_sumar_inv">Sumar a Inv.</label>
      <?php echo $form['sumar_inv']->render(array('class' => 'form-control'))?>
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label for="factura_compra_libro_compras">Libro de compras</label>
      <?php echo $form['libro_compras']->render(array('class' => 'form-control'))?>
    </div>
  </div>
  </div></div></div>

  <div class="card card-primary cliente" id="sf_fieldset">
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="factura_compra_razon_social">Razon social</label>
            <input value="<?php echo $proveedor->getFullName()?>" type="text" name="factura_compra[razon_social]" class="form-control" readonly="readonly" id="factura_compra_razon_social">
          </div>
        </div>
        <div class="col-md-3"></div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="factura_compra_doc_id">Doc. de Identidad</label>
            <input value="<?php echo $proveedor->getDocId()?>" type="text" name="factura_compra[doc_id]" class="form-control" readonly="readonly" id="factura_compra_doc_id">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="factura_compra_direccion">Direccion</label>
            <input value="<?php echo ($proveedor->getDireccion()) ?>" type="text" name="factura_compra[direccion]" class="form-control" readonly="readonly" id="factura_compra_direccion">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3">
          <div class="form-group">
            <label for="factura_compra_telf">Telf</label>
            <input value="<?php echo $proveedor->getTelf()?>" type="text" name="factura_compra[telf]" class="form-control" readonly="readonly" id="factura_compra_telf">
            <input class="form-control hide" type="text" name="num_items2" readonly="readonly" value="0"  id="num_items2">
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
            <label>Descuento (Monto)</label>
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
              <input type="text" name="factura_compra[total2]" class="form-control money" id="factura_compra_total2" placeholder="#,####">
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
    function addDet(num) {
      var ielim =$("#num_items2").val(); 
      var r = $.ajax({
        type: 'GET',
        url: '<?php echo url_for('factura_compra')?>'+'/addDetallesForm/<?php echo ($form->getObject()->isNew()?'':'?id='.$form->getObject()->getId()).($form->getObject()->isNew()?'?num=':'&num=')?>'+num+'&elim='+ielim,
        async: false
      }).responseText;
      return r;
    }
    function addDet2(num, ocdid) {
      var did = $("#factura_compra_deposito_id").val();
      var r = $.ajax({
        type: 'GET',
        url: '<?php echo url_for('factura_compra')?>'+'/addDetallesForm/<?php echo ($form->getObject()->isNew()?'':'?id='.$form->getObject()->getId()).($form->getObject()->isNew()?'?num=':'&num=')?>'+num+'&ocdid='+ocdid+'&did='+did,
        async: false
      }).responseText;
      return r;
    }
    
    $('.add_item').click(function() {
      var items = $(".items").length + 1;
      $("#item").append(addDet(items));
      items = items + 1;
    });

    function addItemsBd() {
      <?php
        $results = Doctrine_Query::create()
          ->select('ocd.id as id')
          ->from('OrdenesCompraDet ocd')
          ->where('ocd.ordenes_compra_id = ?', $oc->getId())
          ->orderBy('ocd.id ASC')
          ->execute();
        foreach ($results as $result){
          echo "addItem2(".$result["id"].");";
        }
      ?>
    }

    function addItem2(ocdid) {
      var items = $(".items").length + 1;
      $("#item").append(addDet2(items, ocdid));      
    }

    $(function () {
      $("#factura_compra_estatus_oc").val($("#factura_compra_estatus_oc option:first").val());
      $("#factura_compra_sumar_inv").val($("#factura_compra_sumar_inv option:first").val());
      addItemsBd();
      $("#factura_compra_deposito_id").on('change', function(event){
        $( "#item" ).empty();
        addItemsBd();
      });
      $('#factura_compra_tasa_cambio').keyup(function(){
        sumar();
      });
      $('.descuento').keyup(function(){
        sumar();
      });
    });
    function sumar() {
      $(".det_qty").each(function() {
        var tasa=number_float($("#factura_compra_tasa_cambio").val());
        var qty=number_float(this.value);
        var punit=number_float($(this).parent().parent().parent().find('.det_unit').val());
        var total=setAndFormat(qty*punit);
        var unit_bs = setAndFormat(punit*tasa);
        var total_bs = setAndFormat(unit_bs*qty);
        $(this).parent().parent().parent().find('.det_total').val(SetMoney(total));
        $(this).parent().parent().parent().find('.factura_compra_det_price_unit_bs').val(SetMoney(unit_bs));
        $(this).parent().parent().parent().find('.det_unit_usd').val(punit);
        $(this).parent().parent().parent().find('.det_total_bs').val(SetMoney(total_bs));

        var costo_calc = number_float($(this).parent().parent().parent().parent().find(".det_calculado").val());
        var porc = number_float($(this).parent().parent().parent().parent().find(".det_calc_porc").val());
        var porc_calc=setAndFormat((costo_calc*porc)/100);
        var costo_calc_bs=setAndFormat((costo_calc+porc_calc)*tasa);
        $(this).parent().parent().parent().parent().find('.det_calc_bs').val(SetMoney(costo_calc_bs));
      });
      var sum=0; base_imponible=0;
      $(".det_total").each(function() {
        sum += +number_float(this.value);
        if($(this).parent().parent().parent().find(".det_exento").val().replace(/ /g,"_")=="NO_EXENTO") {
          base_imponible += +number_float(this.value);
        }
      });
      //$("#factura_compra_subtotal").val(SetMoney(sum));
      //$("#factura_compra_base_imponible").val(SetMoney(base_imponible));
      var desc=number_float($("#factura_compra_descuento").val());
      var subminusdesc=sum;
      if(desc>0) {
        var desc_monto = setAndFormat((sum*desc)/100);
        subminusdesc = sum-desc_monto;
        //$("#descuento_monto").val(SetMoney(desc_monto));
      } else {
        //$("#descuento_monto").val("0,0000");
      }

      var iva=number_float($("#factura_compra_iva").val());
      var iva_monto=setAndFormat((iva*base_imponible)/100);

      //$("#factura_compra_iva_monto").val(SetMoney(iva_monto));
      //$("#factura_compra_subtotal_desc").val(SetMoney(subminusdesc));

      var tot=subminusdesc+iva_monto;

      //$("#factura_compra_total").val(SetMoney(tot));
    }
    function sumar_item(num) {
        var tasa=number_float($("#factura_compra_tasa_cambio").val());
        var qty=number_float($("#factura_compra_factura_compra_det_"+num+"_qty").val());
        var punit=number_float($("#factura_compra_factura_compra_det_"+num+"_price_unit").val());
        var total=setAndFormat(qty*punit);
        var unit_bs = setAndFormat(punit*tasa);
        var total_bs = setAndFormat(unit_bs*qty);
        $("#factura_compra_factura_compra_det_"+num+"_price_tot").val(SetMoney(total));
        $("#factura_compra_factura_compra_det_"+num+"_price_unit_bs").val(SetMoney(unit_bs));
        $("#factura_compra_det_unit_"+num+"_usd").val(SetMoney(punit));
        $("#factura_compra_det_tot_"+num+"_bs").val(SetMoney(total_bs));
        
        var costo_calc = number_float($("#factura_compra_factura_compra_det_"+num+"_price_calculado").val());
        var porc = number_float($("#factura_compra_det_calc_"+num+"_porc").val());
        var porc_calc=setAndFormat((costo_calc*porc)/100);
        var costo_calc_bs=setAndFormat((costo_calc+porc_calc)*tasa);
        $("#factura_compra_det_calc_"+num+"_bs").val(SetMoney(costo_calc_bs));
    }
    function sumarBs() {
      $(".det_qty").each(function() {
        var tasa=number_float($("#factura_compra_tasa_cambio").val());
        var qty=number_float(this.value);
        var unit_bs=number_float($(this).parent().parent().parent().find('.factura_compra_det_price_unit_bs').val());
        var punit=setAndFormat(unit_bs/tasa);
        var punit2=unit_bs/tasa;
        $(this).parent().parent().parent().find('.det_unit').val(SetMoney(punit));
        $(this).parent().parent().parent().find('.det_unit_usd').val(punit2);
        var total=setAndFormat(qty*punit);
        var total_bs = setAndFormat(unit_bs*qty);
        $(this).parent().parent().parent().find('.det_total').val(SetMoney(total));
        $(this).parent().parent().parent().find('.det_total_bs').val(SetMoney(total_bs));
      });
    }
    function sumarBs_item(num) {
        var tasa=number_float($("#factura_compra_tasa_cambio").val());
        var qty=number_float($("#factura_compra_factura_compra_det_"+num+"_qty").val());
        var unit_bs=number_float($("#factura_compra_factura_compra_det_"+num+"_price_unit_bs").val());
        var punit=setAndFormat(unit_bs/tasa);
        var punit2=unit_bs/tasa;
        $("#factura_compra_factura_compra_det_"+num+"_price_unit").val(SetMoney(punit));
        $("#factura_compra_det_unit_"+num+"_usd").val(punit2);
  
        var total=setAndFormat(qty*punit);
        var total_bs = setAndFormat(unit_bs*qty);
        $("#factura_compra_factura_compra_det_"+num+"_price_tot").val(SetMoney(total));
        $("#factura_compra_det_tot_"+num+"_bs").val(SetMoney(total_bs));
    }
    function del_usuario(e) {
      $(e).parent().parent().parent().remove();
      var cont=1;
       var items_elim =$("#num_items2").val();
        items_elim++;
        $("#num_items2").val(items_elim);
      $( ".items" ).each(function( index ) {
        $(this).attr("id","sf_fieldset_det_"+cont);
        $(this).find(".card-title").text("item ["+cont+"]");
       
        cont+=1;
      });
      sumar();
    };
    function valid_productid(id) {
      var cont=0;
      $(".items").each(function() {
        var idprod=$(this).find(".factura_compra_det_inventario_id").val();
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
      if(!$("#factura_compra_subtotal").val()) {
        $("#factura_compra_subtotal").addClass("is-invalid");
        $("#factura_compra_subtotal").parent().find(".error").remove();
        $("#factura_compra_subtotal").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
        cont++;
      }else {
        $("#factura_compra_subtotal").parent().find(".error").remove();
        $("#factura_compra_subtotal").removeClass("is-invalid");
      }

      if(!$("#factura_compra_descuento").val()) {
        $("#factura_compra_descuento").addClass("is-invalid");
        $("#factura_compra_descuento").parent().find(".error").remove();
        $("#factura_compra_descuento").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
        cont++;
      }else {
        $("#factura_compra_descuento").parent().find(".error").remove();
        $("#factura_compra_descuento").removeClass("is-invalid");
      }

      if(!$("#factura_compra_subtotal_desc").val()) {
        $("#factura_compra_subtotal_desc").addClass("is-invalid");
        $("#factura_compra_subtotal_desc").parent().find(".error").remove();
        $("#factura_compra_subtotal_desc").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
        cont++;
      }else {
        $("#factura_compra_subtotal_desc").parent().find(".error").remove();
        $("#factura_compra_subtotal_desc").removeClass("is-invalid");
      }

      if(!$("#factura_compra_base_imponible").val()) {
        $("#factura_compra_base_imponible").addClass("is-invalid");
        $("#factura_compra_base_imponible").parent().find(".error").remove();
        $("#factura_compra_base_imponible").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
        cont++;
      }else {
        $("#factura_compra_base_imponible").parent().find(".error").remove();
        $("#factura_compra_base_imponible").removeClass("is-invalid");
      }

      if(!$("#factura_compra_iva_monto").val()) {
        $("#factura_compra_iva_monto").addClass("is-invalid");
        $("#factura_compra_iva_monto").parent().find(".error").remove();
        $("#factura_compra_iva_monto").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
        cont++;
      }else {
        $("#factura_compra_iva_monto").parent().find(".error").remove();
        $("#factura_compra_iva_monto").removeClass("is-invalid");
      }

      if(!$("#factura_compra_total").val()) {
        $("#factura_compra_total").addClass("is-invalid");
        $("#factura_compra_total").parent().find(".error").remove();
        $("#factura_compra_total").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
        cont++;
      }else {
        $("#factura_compra_total").parent().find(".error").remove();
        $("#factura_compra_total").removeClass("is-invalid");
      }

      if(!$("#factura_compra_total2").val()) {
        $("#factura_compra_total2").addClass("is-invalid");
        $("#factura_compra_total2").parent().find(".error").remove();
        $("#factura_compra_total2").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
        cont++;
      }else {
        $("#factura_compra_total2").parent().find(".error").remove();
        $("#factura_compra_total2").removeClass("is-invalid");
      }
      if(!$("#factura_compra_estatus_oc").val()) {
        $("#factura_compra_estatus_oc").addClass("is-invalid");
        $("#factura_compra_estatus_oc").parent().find(".error").remove();
        $("#factura_compra_estatus_oc").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
        cont++;
      }else {
        $("#factura_compra_estatus_oc").parent().find(".error").remove();
        $("#factura_compra_estatus_oc").removeClass("is-invalid");
      }
      if(!$("#factura_compra_sumar_inv").val()) {
        $("#factura_compra_sumar_inv").addClass("is-invalid");
        $("#factura_compra_sumar_inv").parent().find(".error").remove();
        $("#factura_compra_sumar_inv").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
        cont++;
      }else {
        $("#factura_compra_sumar_inv").parent().find(".error").remove();
        $("#factura_compra_sumar_inv").removeClass("is-invalid");
      }
      if(!$("#factura_compra_fecha").val()) {
        $("#factura_compra_fecha").addClass("is-invalid");
        $("#factura_compra_fecha").parent().find(".error").remove();
        $("#factura_compra_fecha").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
        cont++;
      }else {
        $("#factura_compra_fecha").parent().find(".error").remove();
        $("#factura_compra_fecha").removeClass("is-invalid");
      }
      
      if(!$("#factura_compra_num_factura").val()) {
        $("#factura_compra_num_factura").addClass("is-invalid");
        $("#factura_compra_num_factura").parent().find(".error").remove();
        $("#factura_compra_num_factura").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
        cont++;
      }else {
        $("#factura_compra_num_factura").parent().find(".error").remove();
        $("#factura_compra_num_factura").removeClass("is-invalid");
      }
      if(!$("#factura_compra_fecha_recepcion").val()) {
        $("#factura_compra_fecha_recepcion").addClass("is-invalid");
        $("#factura_compra_fecha_recepcion").parent().find(".error").remove();
        $("#factura_compra_fecha_recepcion").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
        cont++;
      }else {
        $("#factura_compra_fecha_recepcion").parent().find(".error").remove();
        $("#factura_compra_fecha_recepcion").removeClass("is-invalid");
      }
      if(!$("#factura_compra_dias_credito").val()) {
        $("#factura_compra_dias_credito").addClass("is-invalid");
        $("#factura_compra_dias_credito").parent().find(".error").remove();
        $("#factura_compra_dias_credito").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
        cont++;
      }else {
        $("#factura_compra_dias_credito").parent().find(".error").remove();
        $("#factura_compra_dias_credito").removeClass("is-invalid");
      }
      if(!$("#factura_compra_tasa_cambio").val()) {
        $("#factura_compra_tasa_cambio").addClass("is-invalid");
        $("#factura_compra_tasa_cambio").parent().find(".error").remove();
        $("#factura_compra_tasa_cambio").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
        cont++;
      }else {
        var tasa = number_float($("#factura_compra_tasa_cambio").val());
        if (tasa<1) {
          $("#factura_compra_tasa_cambio").addClass("is-invalid");
          $("#factura_compra_tasa_cambio").parent().find(".error").remove();
          $("#factura_compra_tasa_cambio").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Debe ser mayor a 0.</li></ul></div>" );
          cont++;
        } else {
          $("#factura_compra_tasa_cambio").parent().find(".error").remove();
          $("#factura_compra_tasa_cambio").removeClass("is-invalid");
        }
      }
      $(".items").each(function() {
        if(!$(this).find(".factura_compra_det_inventario_id").val()) {
          $(this).find(".factura_compra_det_inventario_id").addClass("is-invalid");
          $(this).find(".factura_compra_det_inventario_id").parent().find(".error").remove();
          $(this).find(".factura_compra_det_inventario_id").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
          cont++;
        }else {
          $(this).find(".factura_compra_det_inventario_id").parent().find(".error").remove();
          $(this).find(".factura_compra_det_inventario_id").removeClass("is-invalid");
        }
        if(!$(this).find(".factura_compra_det_fecha_venc").val()) {
          $(this).find(".factura_compra_det_fecha_venc").addClass("is-invalid");
          $(this).find(".factura_compra_det_fecha_venc").parent().parent().find(".error").remove();
          $(this).find(".factura_compra_det_fecha_venc").parent().parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
          cont++;
        }else {
          $(this).find(".factura_compra_det_fecha_venc").parent().parent().find(".error").remove();
          $(this).find(".factura_compra_det_fecha_venc").removeClass("is-invalid");
        }

        if(!$(this).find(".factura_compra_det_lote").val()) {
          $(this).find(".factura_compra_det_lote").addClass("is-invalid");
          $(this).find(".factura_compra_det_lote").parent().parent().find(".error").remove();
          $(this).find(".factura_compra_det_lote").parent().parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
          cont++;
        }else {
          $(this).find(".factura_compra_det_lote").parent().parent().find(".error").remove();
          $(this).find(".factura_compra_det_lote").removeClass("is-invalid");
        }

        if(!$(this).find(".factura_compra_det_price_calculado").val()) {
          $(this).find(".factura_compra_det_price_calculado").addClass("is-invalid");
          $(this).find(".factura_compra_det_price_calculado").parent().parent().find(".error").remove();
          $(this).find(".factura_compra_det_price_calculado").parent().parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
          cont++;
        }else {
          $(this).find(".factura_compra_det_price_calculado").parent().parent().find(".error").remove();
          $(this).find(".factura_compra_det_price_calculado").removeClass("is-invalid");
        }

        var idprod=$(this).find(".factura_compra_det_inventario_id").val();
        if(idprod) {
          if(valid_productid(idprod)==1) {
            $(this).find(".factura_compra_det_inventario_id").addClass("is-invalid");
            $(this).find(".factura_compra_det_inventario_id").parent().find(".error").remove();
            $(this).find(".factura_compra_det_inventario_id").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Item esta duplicado</li></ul></div>" );
            cont++;
          } else {
            $(this).find(".factura_compra_det_inventario_id").parent().find(".error").remove();
            $(this).find(".factura_compra_det_inventario_id").removeClass("is-invalid");
          }
        }
        if(!$(this).find(".factura_compra_det_qty").val()) {
          $(this).find(".factura_compra_det_qty").addClass("is-invalid");
          $(this).find(".factura_compra_det_qty").parent().find(".error").remove();
          $(this).find(".factura_compra_det_qty").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
          cont++;
        }else {
          $(this).find(".factura_compra_det_qty").parent().find(".error").remove();
          $(this).find(".factura_compra_det_qty").removeClass("is-invalid");
        }

        if(!$(this).find(".factura_compra_det_price_unit").val()) {
          $(this).find(".factura_compra_det_price_unit").addClass("is-invalid");
          $(this).find(".factura_compra_det_price_unit").parent().parent().find(".error").remove();
          $(this).find(".factura_compra_det_price_unit").parent().parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
          cont++;
        }else {
          $(this).find(".factura_compra_det_price_unit").parent().find(".error").remove();
          $(this).find(".factura_compra_det_price_unit").removeClass("is-invalid");
        }

        if(!$(this).find(".factura_compra_det_price_tot").val()) {
          $(this).find(".factura_compra_det_price_tot").addClass("is-invalid");
          $(this).find(".factura_compra_det_price_tot").parent().parent().find(".error").remove();
          $(this).find(".factura_compra_det_price_tot").parent().parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
          cont++;
        }else {
          $(this).find(".factura_compra_det_price_tot").parent().parent().find(".error").remove();
          $(this).find(".factura_compra_det_price_tot").removeClass("is-invalid");
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
          var json_obj = JSON.parse(Get("<?php echo url_for("factura_compra");?>/prefijo?search="+id));
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