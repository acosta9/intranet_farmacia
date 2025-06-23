<?php
/*
function dias($fecha_inicial,$fecha_final){
  $date1 = new DateTime($fecha_inicial);
  $date2 = new DateTime($fecha_final);
  $diff = $date1->diff($date2);
  return $diff->invert == 1 ? -1*$diff->days : $diff->days;
  //return floor(abs((strtotime($fecha_inicial)-strtotime($fecha_final))/86400));
}

function obtenerProductos($ventas_diaria, $fechadesde, $fechahasta){
  $productos = [];

  foreach($ventas_diaria as $venta){
    if (!array_key_exists($venta["pid"], $productos)) {
        $datos = array(
          'nombre' =>$venta["pnombre"],
          'serial' => $venta["pserial"],
          'ventas' => array(array($venta["ffecha"],$venta["total"])),
          'existencia' => 0
        );
        $productos[$venta["pid"]] = $datos;
    }else{
      array_push($productos[$venta["pid"]]['ventas'], array($venta["ffecha"],$venta["total"]));
    }
  }

  foreach($productos as $key => $producto){
    $fecha_inicial = $fechadesde;
    $nuevo_array = array();
    $total = 0;
    foreach($producto['ventas'] as $venta){
      $diferencia_dias = dias($fecha_inicial , $venta[0]);
      $fecha_inicial = date("d-m-Y",strtotime($venta[0]."+ 1 days"));
      for($i=0; $i < $diferencia_dias; $i++){
        array_push($nuevo_array, 0);
      }
      array_push($nuevo_array, $venta[1]);
      $total = $total + $venta[1];
    }
    $diferencia_dias = dias($fecha_inicial , $fechahasta);
    for($i=0; $i <= $diferencia_dias; $i++){
      array_push($nuevo_array, 0);
    }
    $productos[$key]['ventas'] = $nuevo_array;
    $productos[$key]['total'] = $total;
  }

  return $productos;
}

function addExistencia($productos, $existencias){
  foreach($existencias as $existencia){
    if (array_key_exists($existencia["pid"], $productos)) {
      $productos[$existencia["pid"]]['existencia'] = $existencia["icantidad"];
    }
  }
  return $productos;
}

function calcularSafetyStock($producto, $config){
  $tiempo_entrega = $config['tiempo_entrega'];
  $dias_analisis = $config['dias_analisis'];
  $demanda_diaria = $producto['total'] / count($producto['ventas']);
 
  $desvicion_estandar = 0;
  for($j=0; $j < count($producto['ventas']); $j++){
    $desvicion_estandar = $desvicion_estandar + pow($producto['ventas'][$j]-$demanda_diaria,2);
  }
  $desvicion_estandar = sqrt(($desvicion_estandar / (count($producto['ventas'])-1)));

  $demanda_tiempo_espera = $demanda_diaria * $tiempo_entrega;
  $desviacion_estandar_tiempo_entrega = sqrt($tiempo_entrega) * $desvicion_estandar;
  $nivel_servicio = $config['nivel_servicio'];;
  $safety_stock = $desviacion_estandar_tiempo_entrega * $nivel_servicio;
  $punto_recompra = $demanda_tiempo_espera + $safety_stock;
  $trasladar = ($demanda_diaria * ($tiempo_entrega + $dias_analisis)) - $producto['existencia'];

  return array(
    'demanda_diaria'                     => $demanda_diaria,
    'tiempo_entrega'                     => $tiempo_entrega,
    'dias_analisis'                      => $dias_analisis,
    'demanda_tiempo_espera'              => $demanda_tiempo_espera,
    'desvicion_estandar'                 => $desvicion_estandar,
    'desviacion_estandar_tiempo_entrega' => $desviacion_estandar_tiempo_entrega,
    'nivel_servicio'                     => $nivel_servicio,
    'safety_stock'                       => $safety_stock < 0 ? 0 : $safety_stock,
    'punto_recompra'                     => $punto_recompra < 0 ? 0 : $punto_recompra,
    'trasladar'                          => $trasladar < 0 ? 0 : $trasladar,
    'color_class'                        => $producto['existencia'] < $punto_recompra ? 'table-warning' : 
                                            $producto['existencia'] < $safety_stock ? 'table-danger' : ''
  );
}

function addSafetyStock($productos){
  $config = datosConfig();
  foreach($productos as $key => $producto){
    $ss = calcularSafetyStock($producto,$config);
    $productos[$key]['ss'] = $ss; 
  }
  return $productos;
}

function removeSafetyStock($productos, $i){
  if($i == 0) return $productos;

  foreach($productos as $key => $producto){
    if($i == 1 && $producto['existencia'] > $producto['ss']['punto_recompra']){
        unset($productos[$key]);
    }else if($i == 2 && $producto['existencia'] > $producto['ss']['safety_stock']){
        unset($productos[$key]);
    }
  }
  return $productos;
}

function datosConfig(){
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $configs = $q->execute("SELECT ssc.id as id,nv.nivel_servicio as nivel,ssc.tiempo_entrega as tiempo, ssc.dias_analisis as dias,ssc.correos_notificacion as correos
    FROM safety_stock_farmacia_config as ssc
    inner join empresa as e on (e.id = ssc.empresa_id) 
    inner join server_name as sn on (e.id =sn.srvid)
    inner join nivel_servicio as nv on (nv.id = ssc.nivel_servicio_id) ");
  $configuracion;
  foreach($configs as $config){
    $configuracion= $config;
    break;
  }
  $q->close();
  return array(
    'tiempo_entrega'  => empty($configuracion) ? 12 : $configuracion['tiempo'],
    'dias_analisis'   => empty($configuracion) ? 8 : $configuracion['dias'],
    'nivel_servicio'  => empty($configuracion) ? 2.053748911 : $configuracion['nivel'],
  );;
}

$fecha=date('Y-m-d');
$dep=$sf_params->get('dep');
$cat=$sf_params->get('cat');
$pre=$sf_params->get('pre');
$tipo=$sf_params->get('tipo');
$prodId=$sf_params->get('prodId');
$proveedor=$sf_params->get('provId');
$fechadesde=$sf_params->get('fechadesde');
$fechahasta=$sf_params->get('fechahasta');
$tiempo=10;

$depQuery=" i.deposito_id='$dep'";

$desdeQuery=" and f.fecha between '$fechadesde' and '$fechahasta' ";

$prodQuery=""; $prodQueryCD="";
if(!empty($prodId)) {
  $prodQuery=" && i.producto_id='$prodId'";
}

$catQuery="";
if(!empty($cat)) {
  $catQuery=" && p.categoria_id = '$cat' ";
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

$provQuery="";
if (!empty($proveedor)) {
  $provQuery = " && p.laboratorio_id = '$proveedor' ";
}

$q = Doctrine_Manager::getInstance()->getCurrentConnection();
$ventas_diaria = $q->execute("SELECT p.id pid, p.nombre as pnombre, p.serial as pserial,f.fecha ffecha, sum(fd.qty) as total
FROM factura as f 
inner join factura_det as fd on (f.id=fd.factura_id) 
inner join inventario as i on (fd.inventario_id = i.id)
inner join producto as p on (i.producto_id=p.id)
where $depQuery $desdeQuery $prodQuery $catQuery $tipoQuery $preQuery $provQuery and p.activo =1
group by p.nombre, p.serial, f.fecha
order BY f.fecha");

$productos = obtenerProductos($ventas_diaria, $fechadesde, $fechahasta);

$existencias = $q->execute("SELECT sum(i.cantidad) AS icantidad, i.producto_id pid
        FROM inventario AS i
        INNER JOIN server_name AS sn ON (i.empresa_id=sn.srvid)
        GROUP BY i.cantidad HAVING icantidad > 0");

$productos = addExistencia($productos, $existencias);
$productos = addSafetyStock($productos);
$productos = removeSafetyStock($productos, 0);*/

$emp=$sf_params->get('emp');
$cat=$sf_params->get('cat');
$pre=$sf_params->get('pre');
$tipo=$sf_params->get('tipo');
$prodId=$sf_params->get('prodId');
$proveedor=$sf_params->get('provId');
$filtro=$sf_params->get('filtroId');

$empQuery=" ssf.empresa_id=$emp";

$prodQuery="";
if(!empty($prodId)) {
  $prodQuery=" AND ssf.producto_id=$prodId";
}

$catQuery="";
if(!empty($cat)) {
  $catQuery=" AND p.categoria_id = '$cat' ";
}

$preQuery="";
if(!empty($pre)) {
  $pre=str_replace(",","','",$pre);
  $preQuery=" AND p.unidad_id IN ('$pre')";
}

$tipoQuery="";
if($tipo!="z") {
  $tipoQuery=" AND p.tipo='$tipo' ";
}

$provQuery="";
if (!empty($proveedor)) {
  $provQuery = " AND p.laboratorio_id = '$proveedor' ";
}

$filtroQuery="";
if (!empty($filtro)) {
  if($filtro == 1){ // existencia
    $filtroQuery = " AND ssf.existencia > 0 ";
  }else if($filtro == 2){ // punto de reorden 
    $filtroQuery = " AND ssf.existencia < ssf.punto_reorden_compra AND ssf.existencia > ssf.safety_stock";
  }else if($filtro == 3){ // safety stock
    $filtroQuery = " AND ssf.existencia < ssf.safety_stock";
  }
  
}

$q = Doctrine_Manager::getInstance()->getCurrentConnection();
$ssfs = $q->execute("SELECT ssf.id, p.nombre, p.serial, ssf.existencia, ssf.punto_reorden_compra, ssf.safety_stock, ssf.trasladar, ssf.demanda_diaria, ssf.ventas
    FROM safety_stock_farmacia as ssf 
    inner join producto as p on (ssf.producto_id=p.id)
    where $empQuery $prodQuery $catQuery $tipoQuery $preQuery $provQuery $filtroQuery
    Order by ssf.ventas DESC");
?>

<table id="listadoProd" class="cell-border compact stripe" style="width:100%">
  <thead>
    <tr>
      <th class="first-col">Nombre</th>
      <th class="first-col">Serial</th>
      <th>Existencia</th>
      <th>Punto de reorden compra</th>
      <th>Stock de reserva</th>
      <th>Trasladar</th>
      <th>Demanda diaria</th>
      <th>Total Ventas</th>
      
    </tr>
  </thead>
  <tbody>
    <?php foreach ($ssfs as $ssf): ?>
      <tr class="<?php 
            if($ssf['existencia'] < $ssf['safety_stock'])
              echo 'table-danger';
            else if($ssf['existencia'] < $ssf['punto_reorden_compra'])
              echo 'table-warning'; 
      ?>">
        <td><?= ucwords($ssf['nombre']); ?></td>
        <td><?= $ssf['serial']; ?></td>
        <td><?= $ssf['existencia']; ?></td>
        <td><?= round($ssf['punto_reorden_compra']); ?></td>
        <td><?= round($ssf['safety_stock']); ?></td>
        <td><?= round($ssf['trasladar']); ?></td>
        <td><?= round($ssf['demanda_diaria'],2); ?></td>
        <td><?= $ssf['ventas']; ?></td>
        
      </tr>
    <?php endforeach; ?>
  </tbody>
  <tfoot>
    <tr>
      <th class="first-col">Nombre</th>
      <th class="first-col">Serial</th>
      <th>Existencia</th>
      <th>Punto de reorden compra</th>
      <th>Stock de reserva</th>
      <th>Trasladar</th>
      <th>Demanda diaria</th>
      <th>Total Ventas</th>
    </tr>
  </tfoot>
</table>

<div class="modal fade" id="modal_procesar" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="container-fluid" id="procesar">
        </div>
      </div>
    </div>
  </div>
</div>

<link rel="stylesheet" href="/plugins/datatables/datatables.min.css">
<script src="/plugins/datatables/datatables.min.js"></script>
<script src="/plugins/datatables/ellipsis.js"></script>
<script src="/plugins/datatables/dataTables.buttons.min.js"></script>
<script src="/plugins/datatables/jszip.min.js"></script>
<script src="/plugins/datatables/buttons.html5.min.js"></script>

<script>
  $(document).ready(function(){
    $('.min').mask("###0", {reverse: true});

    $('#listadoProd').DataTable( {
      "lengthMenu": [[-1], ["Todos"]],
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
          title: 'Safety Stock',
          exportOptions: {
            modifier: {
              page: 'all'
            },
            format: {
                header: function ( data, columnIdx ) {
                    if(columnIdx==1){
                    return 'Nombre';
                    }
                    else{
                    return data;
                    }
                }
            }
          }
        },
      ]
    });

    $('#listadoProd_filter input').addClass('form-control');
    $("#listadoProd_filter input").attr("placeholder", "Buscar...");
    $('#loading').fadeOut( "slow", function() {});
  });
</script>

<style>
  table#listadoProd tbody tr td:nth-child(3),
  table#listadoProd tbody tr td:nth-child(4),
  table#listadoProd tbody tr td:nth-child(5),
  table#listadoProd tbody tr td:nth-child(6),
  table#listadoProd tbody tr td:nth-child(7),
  table#listadoProd tbody tr td:nth-child(8),
  table#listadoProd tbody tr td:nth-child(9),
  table#listadoProd tbody tr td:nth-child(10),
  table#listadoProd tbody tr td:nth-child(11),
  table#listadoProd tbody tr td:nth-child(12),
  table#listadoProd tbody tr td:nth-child(13) {
    text-align: center;
  }
  .buttons-html5 {
    border-radius: 0px !important;
  }

  th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        margin: 0 auto;
  }

  .dt-buttons {
    float: right;
  }
  #listadoProd_filter input {
    width: 20rem !important;
  }
  .nm {
    width: 4rem !important;
    text-align: center;
    height: calc(1.8125rem + 2px);
    padding: .25rem .5rem;
    font-size: .875rem;
    line-height: 1.5;
    font-weight: 400;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    box-shadow: inset 0 0 0 transparent;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
  }
  .blue {
    color: #007bff;
  }
  .blue.is-valid {
    color: #28a745;
  }
  .blue.is-invalid {
    color: #dc3545;
  }
  .nm.is-invalid {
    border: 3px solid #dc3545;
  }
  .nm.is-valid {
    border: 3px solid #28a745;
  }
  .nm.fill {
    border: 3px solid #007bff;
  }
  table.dataTable.compact tbody th, table.dataTable.compact tbody td {
    padding: 2px 1px;
  }
</style>