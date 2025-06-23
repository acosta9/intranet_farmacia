<?php
  $depId=$sf_params->get('depId');
  $prodId=$sf_params->get('prodId');
  $fdesde=$sf_params->get('fdesde');
  $fhasta=$sf_params->get('fhasta');

  $productoRow=Doctrine::getTable('Producto')->findOneBy('id',$prodId);

  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $kardex = $q->execute("SELECT MONTH(k.fecha) as mes,
    case 
      when day(k.fecha) between 1 and 10 then '01'
      when day(k.fecha) between 11 and 20 then '02'
      when day(k.fecha) between 21 and 31 then '03'
    end as the_range,
    SUM(CASE 
      WHEN k.tipo = 1
      THEN k.cantidad 
      ELSE 0 
      END) AS entrante, 
    SUM(CASE 
      WHEN k.tipo = 2
      THEN k.cantidad 
      ELSE 0 
      END) AS saliente
    FROM kardex as k
    LEFT JOIN producto as p ON k.producto_id=p.id
    WHERE k.deposito_id='$depId' && k.producto_id='$prodId' && k.fecha>='$fdesde 00:00:00' && k.fecha<='$fhasta 23:59:59'
    GROUP BY mes, the_range, k.producto_id
    ORDER BY mes ASC, the_range ASC");
$mes = [1=>'Enero', 2=>'Febrero', 3=>'Marzo', 4=>'Abril', 5=>'Mayo', 6=>'Junio', 7=>'Julio', 8=>'Agosto', 9=>'Septiembre', 10=>'Octubre', 11=>'Noviembre', 12=>'Diciembre'];
$old="";
?>
<h5 style="text-align: center"><?php echo $productoRow["nombre"]." [".$productoRow["serial"]."]"; ?></h5>
<?php if($sf_params->get('provId')=="0"): ?>
  <div class="col-md-12">
    <div class="form-group">
      <label for="prod_vendidos_filters_cod">Seleccione un proveedor</label>
      <select class="form-control" id="proveedor_interno_id">
      </select>
    </div>
  </div>
<?php endif; ?>
<table class="table table-striped" id="detalle_incidencia">
  <thead>
    <tr>
      <th>Mes</th>
      <th>Periodo</th>
      <th>Entrada</th>
      <th>Salida</th>
      <th>Total</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($kardex as $item): ?>
      <tr>
        <td>
          <?php 
            if($mes[$item["mes"]]!=$old) {
              echo $mes[$item["mes"]];
            }
            $old=$mes[$item["mes"]];
          ?>
        </td>
        <td><?php echo $entrante=$item["the_range"]; ?></td>
        <td><?php echo $entrante=$item["entrante"]; ?></td>
        <td><?php echo $saliente=$item["saliente"]; ?></td>
        <td><?php echo round($entrante-$saliente); ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<script>
  $('#modal_procesar').modal('show');
  $('#modal_procesar').draggable({
    handle: ".modal-body"
  });
  $("#proveedor_interno_id").select2({
    width: '100%',
    language: {
      inputTooShort: function () {
        return "por favor ingrese 2 o más caracteres...";
      }
    },
    ajax: {
      url: '<?php echo url_for("turnover")."/getProveedor"; ?>',
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
    placeholder: 'Busca un proveedor',
    minimumInputLength: 2,
  });
  $("#proveedor_interno_id").change(function() {
    var provId=$("#proveedor_interno_id").val();
    var provName=$( "#proveedor_interno_id option:selected" ).text();
    var table = $('#listadoProd').DataTable();
    table.cell({row:<?php echo $sf_params->get('row'); ?>, column:14}).data(provName);

    var pid=<?php echo $prodId; ?>;

    var r = $.ajax({
      type: 'GET',
      url: '<?php echo url_for('turnover')?>/proveedor?pid='+pid+'&provId='+provId,
      async: false
    }).responseText;
    if(r=="success") {
      $("#p<?php echo $prodId; ?>").removeClass("is-invalid");
      $("#p<?php echo $prodId; ?>").addClass("is-valid");
      alert("Se guardo exitosamente");
    } else {
      $("#p<?php echo $prodId; ?>").removeClass("is-valid");
      $("#p<?php echo $prodId; ?>").addClass("is-invalid");
      alert("Ha ocurrido un error por favor intentelo de nuevo");
    }
  });
</script>