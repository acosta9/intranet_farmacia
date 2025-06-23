<?php
$fecha=date('Y-m-d');
$emp=$sf_params->get('emp');
$dep=$sf_params->get('dep');
$st=$sf_params->get('st');
$qtyMy=$sf_params->get('qtyMy');
$qtyMn=$sf_params->get('qtyMn');
$venc=$sf_params->get('venc');
$pvenc=$sf_params->get('pvenc');
$cat=str_replace("_"," ",str_replace("-","/",$sf_params->get('cat')));
$com=$sf_params->get('com');
$lab=$sf_params->get('lab');
$pre=$sf_params->get('pre');
$tipo=$sf_params->get('tipo');
$prodId=$sf_params->get('prodId');
$max=$sf_params->get('cant');

$empQuery="";
if(!empty($emp)) {
  $emp=str_replace(",","','",$emp);
  $empQuery=" && inv.empresa_id IN ('$emp')";
}

$depQuery="";
if(!empty($dep)) {
  $dep=str_replace(",","','",$dep);
  $depQuery=" && inv.deposito_id IN ('$dep')";
}

$stQuery="";
if($st!="z") {
  $stQuery=" && inv.activo='$st' ";
}

$qtyMyQuery="";
if(!empty($qtyMy)) {
  $qtyMyQuery=" && CAST(inv.cantidad AS INTEGER) >=$qtyMy ";
}

$qtyMnQuery="";
if(!empty($qtyMn)) {
  $qtyMnQuery=" && CAST(inv.cantidad AS INTEGER) <=$qtyMn ";
}

$vencQuery="";
if($venc!="z") {
  if($venc==1) {
    $vencQuery="&& (CAST(invDet.cantidad AS INTEGER) > 0 && invDet.fecha_venc<='$fecha') ";
  } else {
    $vencQuery="&& (CAST(invDet.cantidad AS INTEGER) > 0 && invDet.fecha_venc>'$fecha') ";
  }
}

$pvencQuery="";
if(!empty($pvenc)) {
  $pvencQuery=" && (CAST(invDet.cantidad AS INTEGER) > 0 && invDet.fecha_venc BETWEEN '$fecha' AND '$pvenc') ";
}

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

$prodQuery="";
if(!empty($prodId)) {
  $prodId=str_replace(",","','",$prodId);
  $prodQuery=" && inv.producto_id IN ('$prodId')";
}

if($max=="todos") {
  $limit="";
} else {
  $limit=" LIMIT $max";
}

$q = Doctrine_Manager::getInstance()->getCurrentConnection();
$query = $q->execute("SELECT inv.id as invId, inv.cantidad as qty, inv.activo as estatus,
  LOWER(p.nombre) as nombre, p.serial as serial,
  CASE p.tipo
    WHEN 1 THEN 'Imp'
    ELSE 'Nac'
  end tipoTxt,
  lower(pl.nombre) as lab, lower(pu.nombre) as presentacion,
  lower(e.acronimo) as ename, lower(dep.acronimo) as dname,
  p.precio_usd_8 AS precio8
  FROM inventario as inv
  LEFT JOIN inventario_det as invDet ON inv.id=invDet.inventario_id
  LEFT JOIN empresa as e ON inv.empresa_id=e.id
  LEFT JOIN inv_deposito as dep ON inv.deposito_id=dep.id
  LEFT JOIN producto as p ON inv.producto_id=p.id
  LEFT JOIN prod_laboratorio as pl ON p.laboratorio_id=pl.id
  LEFT JOIN prod_unidad as pu ON p.unidad_id=pu.id
  LEFT JOIN prod_categoria as pc ON p.categoria_id=pc.id
  LEFT JOIN prod_compuesto as pcomp ON p.id=pcomp.producto_id
  WHERE 1 $empQuery $depQuery $stQuery $qtyMyQuery $qtyMnQuery $vencQuery $pvencQuery $catQuery $comQuery $labQuery $preQuery $tipoQuery $prodQuery
  GROUP BY inv.id
  ORDER BY p.nombre ASC
  $limit");

?>

<table id="listadoProd" class="table table-striped" style="width:100%">
  <thead>
    <tr>
      <th></th>
      <th>Cod</th>
      <th>Emp</th>
      <th>Dep</th>
      <th>Producto</th>
      <th>Serial</th>
      <th>Laboratorio</th>
      <th>Presentacion</th>
      <th>Tipo</th>
      <th>Cant.</th>
      <th>precio</th>
      <th>Estatus</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($query as $item): ?>
      <tr>
        <td><a href="javascript:void(0)" class="btn btn-info btn-sm" onclick="i(<?php echo $item["invId"]; ?>);">Mostrar</a></td>
        <td><?php echo $item["invId"]; ?></td>
        <td><?php echo $item["ename"]; ?></td>
        <td><?php echo $item["dname"]; ?></td>
        <td><?php echo ucwords($item["nombre"]); ?></td>
        <td><?php echo $item["serial"]; ?></td>
        <td><?php echo ucwords($item["lab"]); ?></td>
        <td><?php echo ucwords($item["presentacion"]); ?></td>
        <td><?php echo $item["tipoTxt"]; ?></td>
        <td><?php echo $item["qty"]; ?></td>
        <td><?php echo $item["precio8"]; ?></td>
        <td><?php echo $item["estatus"]; ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
  <tfoot>
    <tr>
      <th></th>
      <th>Cod</th>
      <th>Empresa</th>
      <th>Deposito</th>
      <th>Producto</th>
      <th>Serial</th>
      <th>Laboratorio</th>
      <th>Presentacion</th>
      <th>Tipo</th>
      <th>Estatus</th>
      <th>Cant.</th>
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
          targets: 4,
          render: $.fn.dataTable.render.ellipsis(30)
        },
        {
          targets: 6,
          render: $.fn.dataTable.render.ellipsis(12)
        },
        {
          targets: 7,
          render: $.fn.dataTable.render.ellipsis(12)
        },
        {
          targets: [11],
          render: function ( data, type, row ) {
            if ( type === 'display' || type === 'filter' ) {
              var datos = "<span style='display:none'>"+data+"</span>";
              if(data==1) {
                datos=datos+"<span class='badge bg-success'>ACTIVO</span>";
              } else {
                datos=datos+"<span class='badge bg-danger'>NO ACTIVO</span>";
              }
              return datos;
            }
            return data;
          }
        },
      ],
      "lengthMenu": [[20, 50, 100, 200, 500, -1], [20, 50, 100, 200, 500, "Todos"]],
      "order": [],
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
          title: 'Listado de inventario',
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
  function i (id) {
    window.open('<?php echo url_for("inventario"); ?>/'+id, '_blank')
  }
</script>

<style>
  table#listadoProd tbody tr td:nth-child(2) {
    text-align: right;
  }
  table#listadoProd tbody tr td:nth-child(11) {
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