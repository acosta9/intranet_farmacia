</div></div></div>
<div class="card card-primary items" id="sf_fieldset_det_<?php echo $num?>">
  <div class="card-header">
    <h3 class="card-title">producto [<?php echo $num?>]</h3>
    <div class="card-tools">
      <a href="javascript:void(0)" class="btn btn-tool del_servicio" onclick="del_item(this)"><i class="fas fa-times"></i></a>
    </div>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <?php echo $form['oferta_det'][$num]['inventario_id']->renderLabel(); ?>
          <select name="oferta[oferta_det][<?php echo $num?>][inventario_id]" class="form-control oferta_det_inventario_id" id="oferta_oferta_det_<?php echo $num?>_inventario_id" required>
          </select>
        </div>
      </div>
    </div>
  </div>
</div>
<div><div><div>

<script type="text/javascript">
  $(document).ready(function() {
    $("#oferta_oferta_det_<?php echo $num; ?>_inventario_id").select2({
      language: {
        inputTooShort: function () {
          return "por favor ingrese 2 o más caracteres...";
        }
      },
      ajax: {
        url: '<?php echo url_for("oferta")."/getProductos"; ?>',
        dataType: 'json',
        headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        delay: 250,
        type: 'GET',
        data: function (params) {
          var query = {
            search: params.term,
            did: '<?php echo $did; ?>'
          }
          // Query parameters will be ?search=[term]&type=public
          return query;
        },
        processResults: function (data) {
          var arr = []
          $.each(data, function (index, value) {
            arr.push({
              id: index,
              text: value
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
    });

    $('#loading').fadeOut( "slow", function() {});
  });
</script>
