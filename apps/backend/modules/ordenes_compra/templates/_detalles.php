</div></div></div>
<?php
  $qty="1"; 
  $pusd="";
  $option="";
  if(!empty($ccdid)) {
    $ccd=Doctrine_Core::getTable('CotizacionCompraDet')->findOneBy('id',$ccdid);
    $prod=Doctrine_Core::getTable('Producto')->findOneBy('id',$ccd->getProductoId());
    $qty=$ccd->getQty();
    $pusd=number_format($ccd->getPriceUnit(),4,",",".");
    $option="<option value='".$prod["id"]."'>".$prod["nombre"]." [".$prod["serial"]."]</option>";
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
          <select name="ordenes_compra[ordenes_compra_det][<?php echo $num?>][producto_id]" class="form-control ordenes_compra_det_producto_id" id="ordenes_compra_ordenes_compra_det_<?php echo $num?>_producto_id">
            <?php echo $option; ?>
          </select>
        </div>
      </div>
      <div class="col-md-1">
        <div class="form-group">
          <?php echo $form['ordenes_compra_det'][$num]['qty']->render(array('class' => "form-control onlyqty_intern det_qty ordenes_compra_det_qty", 'placeholder' => 'Cant.', 'value' => $qty))?>
        </div>
      </div>
      <div class="col-md-2">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">USD</span>
          </div>
          <?php echo $form['ordenes_compra_det'][$num]['price_unit']->render(array('class' => "form-control det_unit ordenes_compra_det_price_unit money_intern", 'value' => $pusd))?>
        </div>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">BSS</span>
          </div>
          <input class="form-control money_intern det_unit_bs" type="text" id="ordenes_compra_det_unit_<?php echo $num?>_bs">
        </div>
      </div>
      <div class="col-md-3">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">USD</span>
          </div>
          <?php echo $form['ordenes_compra_det'][$num]['price_tot']->render(array('class' => "form-control det_total ordenes_compra_det_price_tot", 'placeholder' => 'Total', 'readonly' => 'readonly'))?>
        </div>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">BSS</span>
          </div>
          <input class="form-control det_total_bs" type="text" id="ordenes_compra_det_tot_<?php echo $num?>_bs" readonly>
        </div>
      </div>
    </div>
  </div>
</div>
<div><div><div>
<script>
  var select = document.getElementById("ordenes_compra_ordenes_compra_det_<?php echo $num; ?>_producto_id");
  $(document).ready(function() {
    $("#ordenes_compra_ordenes_compra_det_<?php echo $num; ?>_producto_id").select2({
      language: {
        inputTooShort: function () {
          return "por favor ingrese 2 o más caracteres...";
        }
      },
      ajax: {
        url: '<?php echo url_for("ordenes_compra")."/getProductos2"; ?>',
        dataType: 'json',
        headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        delay: 250,
        type: 'GET',
        data: function (params) {
          var query = {
            search: params.term
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
              price: res[1]
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
      if(str) {
        $("#ordenes_compra_ordenes_compra_det_<?php echo $num; ?>_price_unit").val(str);
      }
      return repo.text;
    }

    $('.onlyqty_intern').mask("###0", {reverse: true});

    $('.money_intern').mask("#.##0,0000", {
      clearIfNotMatch: true,
      placeholder: "#,####",
      reverse: true
    });

  });

  $(function () {
    $('#loading').fadeOut( "slow", function() {});

    $("#ordenes_compra_ordenes_compra_det_<?php echo $num; ?>_producto_id").on('change', function(event){
      sumar();
    });

    $('.det_qty').keyup(function(){
      sumar();
    });

    $('.det_unit').keyup(function(){
      sumar();
    });

    $('.det_unit_bs').keyup(function(){
      sumarBs();
    });
  });
</script>