<?php
  $cat=str_replace("_"," ",str_replace("-","/",$sf_params->get('cat')));
  $com=$sf_params->get('com');
  $lab=$sf_params->get('lab');
  $pre=$sf_params->get('pre');
  $tipo=$sf_params->get('tipo');
  $nombre=$sf_params->get('nombre');
  $max=$sf_params->get('cant');

  $catQuery="";
  if(!empty($cat)) {
    $catQuery=" && pc.nombre LIKE '$cat%' ";
  }

  $comQuery="";
  if(!empty($com)) {
    $com=str_replace(",","','",$com);
    $comQuery=" && pcomp.compuesto_id IN ('$com')";
  }

  $labQuery="";
  if(!empty($lab)) {
    $lab=str_replace(",","','",$lab);
    $labQuery=" && p.laboratorio_id IN ('$lab')";
  }

  $preQuery="";
  if(!empty($pre)) {
    $pre=str_replace(",","','",$pre);
    $preQuery=" && p.unidad_id IN ('$pre')";
  }

  $tipoQuery="";
  if($tipo!="z") {
    $tipoQuery=" && p.tipo='$tipo' ";
  }

  $nombreQuery="";
  if(!empty($nombre)) {
    $words=explode(" ",$nombre);
    foreach ($words as $word) {
      $nombreQuery=$nombreQuery."&& (p.nombre LIKE '%".$word."%' || p.serial LIKE '%".$word."%') ";
    }
  }

  if($max=="todos") {
    $limit="";
  } else {
    $limit=" LIMIT $max";
  }

  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $query = $q->execute("SELECT LOWER(p.nombre) as nombre, p.serial as serial, FORMAT(REPLACE(p.costo_usd_1, ' ', ''), 4, 'de_DE') as costo, 
    FORMAT(REPLACE(p.precio_usd_8, ' ', ''), 4, 'de_DE') as pusd8, FORMAT(REPLACE(p.util_usd_8, ' ', ''), 4, 'de_DE') as util8,
    p.url_imagen as img, p.updated_at as updatedat, p.id as prodId,
    CASE p.tipo
      WHEN 1 THEN 'Importado'
      ELSE 'Nacional'
    end tipoTxt,
    lower(pl.nombre) as lab, lower(pu.nombre) as presentacion
    FROM producto as p
    LEFT JOIN prod_laboratorio as pl ON p.laboratorio_id=pl.id
    LEFT JOIN prod_unidad as pu ON p.unidad_id=pu.id
    LEFT JOIN prod_categoria as pc ON p.categoria_id=pc.id
    LEFT JOIN prod_compuesto as pcomp ON p.id=pcomp.producto_id
    WHERE 1 $catQuery $comQuery $labQuery $preQuery $tipoQuery $nombreQuery
    GROUP BY p.id
    ORDER BY p.updated_at DESC
    $limit");
?>

<table id="listadoProd" class="table table-striped" style="width:100%">
  <thead>
    <tr>
      <th></th>
      <th>Nombre</th>
      <th>Serial</th>
      <th>Laboratorio</th>
      <th>Presentacion</th>
      <th>Tipo</th>
      <th>Costo</th>
      <th>Util (8)</th>
      <th>P. USD (8)</th>
      <th>Ult. Act</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($query as $item): ?>
      <tr>
        <td><a href="javascript:void(0)" class="btn btn-info btn-sm" onclick="p(<?php echo $item["prodId"]; ?>);">Mostrar</a></td>
        <td><?php echo ucwords($item["nombre"]); ?></td>
        <td><?php echo $item["serial"]; ?></td>
        <td><?php echo ucwords($item["lab"]); ?></td>
        <td><?php echo ucwords($item["presentacion"]); ?></td>
        <td><?php echo $item["tipoTxt"]; ?></td>
        <td><?php echo "$".$item["costo"]; ?></td>
        <td><?php echo $item["util8"]."%"; ?></td>
        <td><?php echo "$".$item["pusd8"]; ?></td>
        <td><?php echo date("d/m/y H:i", strtotime($item["updatedat"])); ?></td>
        <td><?php echo strtotime($item["updatedat"]); ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
  <tfoot>
    <tr>
      <th></th>
      <th>Nombre</th>
      <th>Serial</th>
      <th>Laboratorio</th>
      <th>Presentacion</th>
      <th>Tipo</th>
      <th>Costo</th>
      <th>Util (8)</th>
      <th>P. USD (8)</th>
      <th>Ult. Act</th>
      <th></th>
    </tr>
  </tfoot>
</table>

<link rel="stylesheet" href="/plugins/datatables/datatables.min.css">
<script src="/plugins/datatables/datatables.min.js"></script>
<script src="/plugins/datatables/ellipsis.js"></script>
<script src="/plugins/datatables/dataTables.buttons.min.js"></script>
<script src="/plugins/datatables/jszip.min.js"></script>
<script src="/plugins/datatables/buttons.html5.min.js"></script>

<script>
  $(document).ready(function(){
    $('#listadoProd').DataTable( {
      columnDefs: [
        {
          targets: 0,
          "visible": true,
          "searchable": false,
          "orderable": false,
          render: function ( data, type, row ) {
            if ( type === 'display' || type === 'filter' ) {
              return data;
            }
            return "";
          }
        },
        {
          targets: 1,
          render: $.fn.dataTable.render.ellipsis(30)
        },
        {
          targets: 3,
          render: $.fn.dataTable.render.ellipsis(12)
        },
        {
          targets: 4,
          render: $.fn.dataTable.render.ellipsis(12)
        },
        {
          targets: 6,
          render: function ( data, type, row ) {
            if ( type === 'display' || type === 'filter' ) {
              return data;
            }
            var numero = number_float(data.replace('$',''));
            return numero;
          }
        },
        {
          targets: 7,
          render: function ( data, type, row ) {
            if ( type === 'display' || type === 'filter' ) {
              return data;
            }
            var numero = number_float(data.replace('%',''));
            return numero+"%";
          }
        },
        {
          targets: 8,
          render: function ( data, type, row ) {
            if ( type === 'display' || type === 'filter' ) {
              return data;
            }
            var numero = number_float(data.replace('$',''));
            return numero;
          }
        },
        {
          targets: 9,
          render: function ( data, type, row ) {
            if ( type === 'display' || type === 'filter' ) {
              return "<span style='display:none'>"+row[10]+"</span>"+data;
            }
            return data;
          }
        },
        {
          targets: 10,
          "visible": false,
          "searchable": false,
          "orderable": false,
        },
      ],
      "lengthMenu": [[20, 50, 100, 200, 500, -1], [20, 50, 100, 200, 500, "Todos"]],
      "order": [[ 9, 'desc' ]],
      "language": {
        "lengthMenu": "Mostrar _MENU_ registros",
        "zeroRecords":    "No se encontraron resultados",
        "info": "Mostrando pagina _PAGE_ de _PAGES_ de _TOTAL_ registro(s)",
        "infoFiltered": "(filtrado de _MAX_ total de registro(s))",
        "search": "",
        "paginate": {
          "first":    "Primero",
          "last":     "Último",
          "next":     "Siguiente",
          "previous": "Anterior"
        },
      },
      dom: 'lBfrtip',
      buttons: [
        {
          extend: 'excelHtml5',
          className: 'btn btn-success ml-3',
          text: 'Exportar Excel',
          title: 'Listado de productos',
          exportOptions: {
            columns: ':visible',
            orthogonal: 'export' 
          }
        },
      ]
    });

    $('#listadoProd_filter input').addClass('form-control');
    $("#listadoProd_filter input").attr("placeholder", "Buscar...");
    $('#loading').fadeOut( "slow", function() {});
  });
  function p (id) {
    window.open('<?php echo url_for("producto"); ?>/'+id, '_blank')
  }
</script>

<style>
  table#listadoProd tbody tr td:nth-child(7),
  table#listadoProd tbody tr td:nth-child(8),
  table#listadoProd tbody tr td:nth-child(9) {
    text-align: right;
  }
  table#listadoProd thead tr th:nth-child(7),
  table#listadoProd thead tr th:nth-child(8),
  table#listadoProd thead tr th:nth-child(9) {
    text-align: right;
  }
  .buttons-html5 {
    border-radius: 0px !important;
  }
  .dt-buttons {
    float: right;
  }
  #listadoProd_filter input {
    width: 20rem !important;
  }
</style>