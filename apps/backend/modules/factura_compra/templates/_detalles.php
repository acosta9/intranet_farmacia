</div></div></div>
<?php
if(!empty($ocdid)):
  $ocd=Doctrine_Core::getTable('OrdenesCompraDet')->findOneBy('id',$ocdid);
  $pid=$ocd->getProductoId();
  $inv = Doctrine_Query::create()
    ->select("i.id as id, p.id as pid, p.nombre as pname, p.serial as serial, p.exento as exento, FORMAT(REPLACE(p.util_usd_1, ' ', ''), 4, 'de_DE') as util1, 
    FORMAT(REPLACE(p.util_usd_8, ' ', ''), 4, 'de_DE') as util8, FORMAT(REPLACE(p.costo_usd_1, ' ', ''), 4, 'de_DE') as costo")
    ->from('Inventario i')
    ->leftJoin('i.Producto p')
    ->where('i.producto_id =?',$pid)
    ->andWhere('i.deposito_id =?',$did)
    ->limit(1)
    ->fetchOne();
  if(empty($inv)): ?>
    <?php $prod=Doctrine_Core::getTable('Producto')->findOneBy('id',$pid); ?>
    <div class="card card-primary items" id="sf_fieldset_det_<?php echo $num; ?>">
      <div class="card-header">
        <h3 class="card-title">item [<?php echo $num ?>]</h3>
        <script>
          $(".btn-guardar").prop('disabled', true);
          $('#loading').fadeOut( "slow", function() {});
        </script>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-8">
            <div class="form-group">
              <input class="form-control is-invalid" type="text" value="<?php echo $prod["nombre"];?>" readonly>
              <ul class="error_list">
                <li>Este producto no existe en el deposito seleccionado, ingresa el producto al inventario seleccionado y recarga esta ventana</li>
              </ul>
            </div>
          </div>
          <div class="col-md-2">
            <input class="form-control is-invalid" type="text" value="<?php echo $prod["serial"];?>" readonly>
          </div>
          <div class="col-md-2">
            <a target="_blank" class="btn btn-warning btn-block text-uppercase btn-align" href="<?php echo url_for("inventario")."/new"; ?>">
              <i class="fa fa-plus-square mr-2"></i>Ingresar prod a inventario
            </a>
          </div>
        </div>
      </div>
    </div>
  <?php else: ?>
  <?php
    $qty="1";  $pusd=""; $option=""; $exento="NO EXENTO";
    if($inv["exento"]){
      $exento="EXENTO";
    }
    if(!empty($ocdid)) {
      $qty=$ocd->getQty();
      $pusd=number_format($ocd->getPriceUnit(),4,",",".");
      $option="<option value='".$inv["id"]."'>".$inv["pname"]." [".$inv["serial"]."]</option>";
    }
  ?>
  <div class="card card-primary items" id="sf_fieldset_det_<?php echo $num; ?>">
    <div class="card-header">
      <h3 class="card-title">item [<?php echo $num ?>]</h3>
      <div class="card-tools">
        <a href="javascript:void(0)" class="btn btn-tool del_servicio" onclick="del_usuario(this)"><i class="fas fa-times"></i></a>
      </div>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <select name="factura_compra[factura_compra_det][<?php echo $num?>][inventario_id]" class="form-control factura_compra_det_inventario_id" id="factura_compra_factura_compra_det_<?php echo $num?>_inventario_id">
              <?php echo $option; ?>
            </select>
          </div>
          <div class="row">
            <div class="col-md-3">
              <select name="factura_compra[factura_compra_det][<?php echo $num?>][exento]" id="factura_compra_factura_compra_det_<?php echo $num?>_exento" class="factura_compra_det_exento det_exento form-control">
                <option value="EXENTO">EXENTO</option>
                <option value="NO_EXENTO">NO EXENTO</option>
              </select>
              <input class="form-control det_unit_usd" type="hidden" id="factura_compra_det_unit_<?php echo $num?>_usd">

            </div>
          </div>
        </div>
        <div class="col-md-1">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">F</span>
            </div>
            <?php echo $form['factura_compra_det'][$num]['qty']->render(array('class' => "form-control onlyqty_intern det_qty factura_compra_det_qty", 'placeholder' => 'Cant.', 'value' => $qty))?>
          </div>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">R</span>
            </div>
             <?php echo $form['factura_compra_det'][$num]['qtyr']->render(array('class' => "form-control   factura_compra_det_qtyr", 'placeholder' => 'Cant.', 'value' => $qty))?>
          </div>
        </div>
        <div class="col-md-2">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">USD</span>
            </div>
            <?php echo $form['factura_compra_det'][$num]['price_unit']->render(array('class' => "form-control det_unit factura_compra_det_price_unit money_intern", 'value' => $pusd))?>
          </div>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">BS</span>
            </div>
             <?php echo $form['factura_compra_det'][$num]['price_unit_bs']->render(array('class' => "form-control  factura_compra_det_price_unit_bs money_intern"))?>
            </div>
        </div>
        <div class="col-md-3">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">USD</span>
            </div>
            <?php echo $form['factura_compra_det'][$num]['price_tot']->render(array('class' => "form-control det_total factura_compra_det_price_tot", 'placeholder' => 'Total', 'readonly' => 'readonly'))?>
          </div>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">BS</span>
            </div>
            <input class="form-control det_total_bs" type="text" id="factura_compra_det_tot_<?php echo $num?>_bs" readonly>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <hr/>
        </div>
        <div class="col-md-2">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">F. VENC.</span>
            </div>
            <?php echo $form['factura_compra_det'][$num]['fecha_venc']->render(array('class' => 'form-control dateonly factura_compra_det_fecha_venc', 'readonly' => 'readonly'))?>
          </div>
        </div>
        <div class="col-md-2">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">LOTE</span>
            </div>
            <?php echo $form['factura_compra_det'][$num]['lote']->render(array('class' => 'form-control factura_compra_det_lote'))?>
          </div>
        </div>
        <div class="col-md-2">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">T. PRECIO</span>
            </div>
            <?php echo $form['factura_compra_det'][$num]['tipo_precio']->render(array('class' => 'form-control det_tipo factura_compra_det_tipo_precio'))?>
          </div>
        </div>
        <div class="col-md-2">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">COSTO ($)</span>
            </div>
            <input class="det_costo_actual" type="hidden" id="factura_compra_det_costo_<?php echo $num?>_actual" readonly value="<?php echo $inv->getCosto(); ?>">
            <?php echo $form['factura_compra_det'][$num]['price_calculado']->render(array('class' => "form-control det_calculado factura_compra_det_price_calculado", 'placeholder' => 'Costo Producto', 'readonly' => 'readonly', 'value' => $inv->getCosto()))?>
          </div>
        </div>
        <?php if($sf_user->hasCredential("farmacia")): ?>
          <?php $util = $inv->getUtil8() ?>
          <div class="col-md-2">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">UTIL 08 (%)</span>
              </div>
              <input class="form-control det_calc_porc" type="text" id="factura_compra_det_calc_<?php echo $num?>_porc" readonly value="<?php echo $util; ?>">
            </div>
          </div>
          <div class="col-md-2">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">P. 08 (BS)</span>
              </div>
              <input class="form-control det_calc_bs" type="text" id="factura_compra_det_calc_<?php echo $num?>_bs" readonly>
            </div>
          </div>
        <?php else: ?>
          <?php $util = $inv->getUtil1() ?>
          <div class="col-md-2">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">UTIL 01 (%)</span>
              </div>
              <input class="form-control det_calc_porc" type="text" id="factura_compra_det_calc_<?php echo $num?>_porc" readonly value="<?php echo $util; ?>">
            </div>
          </div>
          <div class="col-md-2">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">P. 01 (BS)</span>
              </div>
              <input class="form-control det_calc_bs" type="text" id="factura_compra_det_calc_<?php echo $num?>_bs" readonly>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
  
  <script>
    $(document).ready(function() {
      $(".dateonly").datepicker({
        language: 'es',
        format: "yyyy-mm-dd"
      });

      $('.onlyqty_intern').mask("###0", {reverse: true});

      $('.money_intern').mask("#.##0,0000", {
        clearIfNotMatch: true,
        placeholder: "#,####",
        reverse: true
      });

    });

    $(function () {
      $('#loading').fadeOut( "slow", function() {});
      sumar();

      $('#factura_compra_factura_compra_det_<?php echo $num?>_qty').change(function(){
        sumar_item(<?php echo $num; ?>);
        tipoPrecio(<?php echo $num?>);
      });
      
      $('#factura_compra_factura_compra_det_<?php echo $num?>_price_unit').change(function(){
        sumar_item(<?php echo $num; ?>);
        tipoPrecio(<?php echo $num?>);
      });

   /*   $(".det_exento").on('change', function(event){
        sumar();
        tipoPrecio();
      });*/
      $('#factura_compra_factura_compra_det_<?php echo $num?>_tipo_precio').change(function(){
        var tipo_precio = $(this).val();
        if(tipo_precio==1) {
          var costo = $(this).parent().parent().parent().parent().find('.det_costo_actual').val();
          $(this).parent().parent().parent().parent().find('.det_calculado').val(costo);
        } else if(tipo_precio==2) {
          var costo1 = number_float($(this).parent().parent().parent().parent().find('.det_costo_actual').val());
          var costo2 = number_float($(this).parent().parent().parent().parent().parent().find('.det_unit').val());
          var costo = setAndFormat((costo1+costo2)/2);
          $(this).parent().parent().parent().parent().find('.det_calculado').val(SetMoney(costo));
        } else if(tipo_precio==3) {
          var costo = $(this).parent().parent().parent().parent().parent().find('.det_unit').val();
          $(this).parent().parent().parent().parent().find('.det_calculado').val(costo);
        }
         sumar_item(<?php echo $num; ?>);
      });
    /*  $(".det_tipo").on('change', function(event){
        var tipo_precio = $(this).val();
        if(tipo_precio==1) {
          var costo = $(this).parent().parent().parent().parent().find('.det_costo_actual').val();
          $(this).parent().parent().parent().parent().find('.det_calculado').val(costo);
        } else if(tipo_precio==2) {
          var costo1 = number_float($(this).parent().parent().parent().parent().find('.det_costo_actual').val());
          var costo2 = number_float($(this).parent().parent().parent().parent().parent().find('.det_unit').val());
          var costo = setAndFormat((costo1+costo2)/2);
          $(this).parent().parent().parent().parent().find('.det_calculado').val(SetMoney(costo));
        } else if(tipo_precio==3) {
          var costo = $(this).parent().parent().parent().parent().parent().find('.det_unit').val();
          $(this).parent().parent().parent().parent().find('.det_calculado').val(costo);
        }
        sumar();
      });*/
      $('#factura_compra_factura_compra_det_<?php echo $num?>_price_unit_bs').change(function(){
        var tipo_precio = $(this).parent().parent().parent().parent().find('.det_tipo').val();
        if(tipo_precio==3) {
          var costo = $(this).parent().parent().parent().parent().parent().find('.det_unit').val();
          $(this).parent().parent().parent().parent().find('.det_calculado').val(costo);
        }
        sumarBs_item(<?php echo $num; ?>);
        tipoPrecio(<?php echo $num; ?>);
      });

      function tipoPrecio(num) {
         var tipo_precio=$("#factura_compra_factura_compra_det_"+num+"_tipo_precio").val();
         if(tipo_precio==1) {
            var costo=$("#factura_compra_det_costo_"+num+"_actual").val();
            $("#factura_compra_det_"+num+"_price_calculado").val(costo);// det calculado
          } else if(tipo_precio==2) {
            var costo1=$("#factura_compra_det_costo_"+num+"_actual").val();
            var costo2=$("#factura_compra_factura_compra_det_"+num+"_price_unit").val();
            var costo = setAndFormat((costo1+costo2)/2);
            $("#factura_compra_det_"+num+"_price_calculado").val(SetMoney(costo));
          } else if(tipo_precio==3) {
            var costo=$("#factura_compra_factura_compra_det_"+num+"_price_unit").val();
            $("#factura_compra_det_"+num+"_price_calculado").val(costo);
          }
      }
 /*     function tipoPrecio() {  //copia
        $(".det_tipo").each(function() {
          var tipo_precio = $(this).val();
          if(tipo_precio==1) {
            var costo = $(this).parent().parent().parent().parent().find('.det_costo_actual').val();
            $(this).parent().parent().parent().parent().find('.det_calculado').val(costo);
          } else if(tipo_precio==2) {
            var costo1 = number_float($(this).parent().parent().parent().parent().find('.det_costo_actual').val());
            var costo2 = number_float($(this).parent().parent().parent().parent().parent().find('.det_unit').val());
            var costo = setAndFormat((costo1+costo2)/2);
            $(this).parent().parent().parent().parent().find('.det_calculado').val(SetMoney(costo));
          } else if(tipo_precio==3) {
            var costo = $(this).parent().parent().parent().parent().parent().find('.det_unit').val();
            $(this).parent().parent().parent().parent().find('.det_calculado').val(costo);
          }
        });
      }*/
    });
  </script>
  <?php endif; ?>
<?php else:  ?> 
  <div class="card card-primary items" id="sf_fieldset_det_<?php echo $num; ?>">
    <div class="card-header">
      <h3 class="card-title">item [<?php echo $num ?>]</h3>
      <div class="card-tools">
        <a href="javascript:void(0)" class="btn btn-tool del_servicio" onclick="del_usuario(this)"><i class="fas fa-times"></i></a>
      </div>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <select name="factura_compra[factura_compra_det][<?php echo $num?>][inventario_id]" class="form-control factura_compra_det_inventario_id" id="factura_compra_factura_compra_det_<?php echo $num?>_inventario_id">
            </select>
          </div>
          <div class="row">
            <div class="col-md-3">
              <select name="factura_compra[factura_compra_det][<?php echo $num?>][exento]" id="factura_compra_factura_compra_det_<?php echo $num?>_exento" class="factura_compra_det_exento det_exento form-control">
                <option value="EXENTO">EXENTO</option>
                <option value="NO_EXENTO">NO EXENTO</option>
              </select>
              <input class="form-control det_unit_usd" type="hidden" id="factura_compra_det_unit_<?php echo $num?>_usd">
            </div>
          </div>
        </div>
        <div class="col-md-1">
          <div class="form-group">
            <?php echo $form['factura_compra_det'][$num]['qty']->render(array('class' => "form-control onlyqty_intern det_qty factura_compra_det_qty", 'placeholder' => 'Cant.', 'value' => '1'))?>
            <?php echo $form['factura_compra_det'][$num]['qtyr']->render(array('class' => "form-control   factura_compra_det_qtyr", 'placeholder' => 'Cant.', 'type' => 'hidden', 'value' => '1'))?>
          </div>
        </div>
        <div class="col-md-2">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">USD</span>
            </div>
            <?php echo $form['factura_compra_det'][$num]['price_unit']->render(array('class' => "form-control det_unit factura_compra_det_price_unit money_intern"))?>
          </div>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">BS</span>
            </div>
             <?php echo $form['factura_compra_det'][$num]['price_unit_bs']->render(array('class' => "form-control  factura_compra_det_price_unit_bs money_intern"))?>
           </div>
        </div>
        <div class="col-md-3">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">USD</span>
            </div>
            <?php echo $form['factura_compra_det'][$num]['price_tot']->render(array('class' => "form-control det_total factura_compra_det_price_tot", 'placeholder' => 'Total', 'readonly' => 'readonly'))?>
          </div>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">BS</span>
            </div>
            <input class="form-control det_total_bs" type="text" id="factura_compra_det_tot_<?php echo $num?>_bs" readonly>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <hr/>
        </div>
        <div class="col-md-2">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">F. VENC.</span>
            </div>
            <?php echo $form['factura_compra_det'][$num]['fecha_venc']->render(array('class' => 'form-control dateonly factura_compra_det_fecha_venc', 'readonly' => 'readonly'))?>
          </div>
        </div>
        <div class="col-md-2">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">LOTE</span>
            </div>
            <?php echo $form['factura_compra_det'][$num]['lote']->render(array('class' => 'form-control factura_compra_det_lote'))?>
          </div>
        </div>
        <div class="col-md-2">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">T. PRECIO</span>
            </div>
            <?php echo $form['factura_compra_det'][$num]['tipo_precio']->render(array('class' => 'form-control det_tipo factura_compra_det_tipo_precio'))?>
          </div>
        </div>
        <div class="col-md-2">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">COSTO ($)</span>
            </div>
            <input class="det_costo_actual" type="hidden" id="factura_compra_det_costo_<?php echo $num?>_actual" readonly value="">
            <?php echo $form['factura_compra_det'][$num]['price_calculado']->render(array('class' => "form-control det_calculado factura_compra_det_price_calculado", 'placeholder' => 'Costo Producto', 'readonly' => 'readonly'))?>
          </div>
        </div>
        <?php if($sf_user->hasCredential("farmacia")): ?>
          <div class="col-md-2">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">UTIL 08 (%)</span>
              </div>
              <input class="form-control det_calc_porc" type="text" id="factura_compra_det_calc_<?php echo $num?>_porc" readonly>
            </div>
          </div>
          <div class="col-md-2">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">P. 08 (BS)</span>
              </div>
              <input class="form-control det_calc_bs" type="text" id="factura_compra_det_calc_<?php echo $num?>_bs" readonly>
            </div>
          </div>
        <?php else: ?>
          <div class="col-md-2">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">UTIL 01 (%)</span>
              </div>
              <input class="form-control det_calc_porc" type="text" id="factura_compra_det_calc_<?php echo $num?>_porc" readonly>
            </div>
          </div>
          <div class="col-md-2">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">P. 01 (BS)</span>
              </div>
              <input class="form-control det_calc_bs" type="text" id="factura_compra_det_calc_<?php echo $num?>_bs" readonly>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <script>
    $(document).ready(function() {
      $("#factura_compra_factura_compra_det_<?php echo $num; ?>_inventario_id").select2({
        language: {
          inputTooShort: function () {
            return "por favor ingrese 2 o más caracteres...";
          }
        },
        ajax: {
          url: '<?php echo url_for("factura_compra")."/getProductos2"; ?>',
          dataType: 'json',
          headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          delay: 250,
          type: 'GET',
          data: function (params) {
            var query = {
              search: params.term,
              did: $("#factura_compra_deposito_id").val()
            }
            // Query parameters will be ?search=[term]&type=public
            return query;
          },
          processResults: function (data) {
            var arr = []
            $.each(data, function (index, value) {
              var res = value.split("|");
              arr.push({
                id: index,
                text: res[0],
                price: res[1],
                util1: res[2],
                util8: res[3]
              })
            })
            return {
              results: arr
            };
          },
          cache: false
        },
        placeholder: 'Busca un producto',
        minimumInputLength: 2,
        templateSelection: formatRepoSelection
      });

      function formatRepoSelection (repo) {
        var str=repo.price;
        var util1=repo.util1;
        var util8=repo.util8;
        if(str) {
          $("#factura_compra_factura_compra_det_<?php echo $num; ?>_price_unit").val(str);
          $("#factura_compra_det_costo_<?php echo $num; ?>_actual").val(str);
          $("#factura_compra_factura_compra_det_<?php echo $num; ?>_price_calculado").val(str);
          $("#factura_compra_det_calc_<?php echo $num; ?>_porc").val(util8);
        }
        return repo.text;
      }

      $(".dateonly").datepicker({
        language: 'es',
        format: "yyyy-mm-dd"
      });

      $('.onlyqty_intern').mask("###0", {reverse: true});

      $('.money_intern').mask("#.##0,0000", {
        clearIfNotMatch: true,
        placeholder: "#,####",
        reverse: true
      });

    });

    $(function () {
      $('#loading').fadeOut( "slow", function() {});
      var num = <?php echo $num ?>;
      sumar_item(<?php echo $num ?>);

      $("#factura_compra_factura_compra_det_<?php echo $num; ?>_inventario_id").on('change', function(event){
        sumar_item(<?php echo $num ?>);
      });

      $('#factura_compra_factura_compra_det_<?php echo $num?>_qty').change(function(){
        var qty=$(this).val();
        $(this).parent().parent().parent().parent().find('.factura_compra_det_qtyr').val(qty);
        sumar_item(<?php echo $num ?>);
        tipoPrecio(<?php echo $num ?>);
      });
      
      $('#factura_compra_factura_compra_det_<?php echo $num?>_price_unit').change(function(){
        sumar_item(<?php echo $num ?>);
        tipoPrecio(<?php echo $num ?>);
      });

  
      $('#factura_compra_factura_compra_det_<?php echo $num?>_tipo_precio').change(function(){
        var tipo_precio = $(this).val();
        if(tipo_precio==1) {
          var costo = $(this).parent().parent().parent().parent().find('.det_costo_actual').val();
          $(this).parent().parent().parent().parent().find('.det_calculado').val(costo);
        } else if(tipo_precio==2) {
          var costo1 = number_float($(this).parent().parent().parent().parent().find('.det_costo_actual').val());
          var costo2 = number_float($(this).parent().parent().parent().parent().parent().find('.det_unit').val());
          var costo = setAndFormat((costo1+costo2)/2);
          $(this).parent().parent().parent().parent().find('.det_calculado').val(SetMoney(costo));
        } else if(tipo_precio==3) {
          var costo = $(this).parent().parent().parent().parent().parent().find('.det_unit').val();
          $(this).parent().parent().parent().parent().find('.det_calculado').val(costo);
        }
         sumar_item(<?php echo $num; ?>);
      });

     $('#factura_compra_factura_compra_det_<?php echo $num?>_price_unit_bs').change(function(){
        var tipo_precio = $(this).parent().parent().parent().parent().find('.det_tipo').val();
        if(tipo_precio==3) {
          var costo = $(this).parent().parent().parent().parent().parent().find('.det_unit').val();
          $(this).parent().parent().parent().parent().find('.det_calculado').val(costo);
        }
        sumarBs_item(<?php echo $num; ?>);
        tipoPrecio(<?php echo $num; ?>);
      });

      function tipoPrecio(num) {
         var tipo_precio=$("#factura_compra_factura_compra_det_"+num+"_tipo_precio").val();
         if(tipo_precio==1) {
            var costo=$("#factura_compra_det_costo_"+num+"_actual").val();
            $("#factura_compra_det_"+num+"_price_calculado").val(costo);// det calculado
          } else if(tipo_precio==2) {
            var costo1=$("#factura_compra_det_costo_"+num+"_actual").val();
            var costo2=$("#factura_compra_factura_compra_det_"+num+"_price_unit").val();
            var costo = setAndFormat((costo1+costo2)/2);
            $("#factura_compra_det_"+num+"_price_calculado").val(SetMoney(costo));
          } else if(tipo_precio==3) {
            var costo=$("#factura_compra_factura_compra_det_"+num+"_price_unit").val();
            $("#factura_compra_det_"+num+"_price_calculado").val(costo);
          }
      }
    });
  </script>
<?php  endif; ?>
<div><div><div>