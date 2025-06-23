<?php
  

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
  
  $desviacion_estandar = 0;
  for($j=0; $j < count($producto['ventas']); $j++){
    $desviacion_estandar = $desviacion_estandar + pow($producto['ventas'][$j]-$demanda_diaria,2);
  }
  $desviacion_estandar = sqrt(($desviacion_estandar / (count($producto['ventas'])-1)));

  $demanda_tiempo_espera = $demanda_diaria * $tiempo_entrega;
  $desviacion_estandar_tiempo_entrega = sqrt($tiempo_entrega) * $desviacion_estandar;
  $nivel_servicio = $config['nivel_servicio'];;
  $safety_stock = $desviacion_estandar_tiempo_entrega * $nivel_servicio;
  $punto_recompra = $demanda_tiempo_espera + $safety_stock;
  $trasladar = ($demanda_diaria * ($tiempo_entrega + $dias_analisis)) - $producto['existencia'];

  return array(
    'demanda_diaria'                     => $demanda_diaria,
    'tiempo_entrega'                     => $tiempo_entrega,
    'dias_analisis'                      => $dias_analisis,
    'demanda_tiempo_espera'              => $demanda_tiempo_espera,
    'desviacion_estandar'                 => $desviacion_estandar,
    'desviacion_estandar_tiempo_entrega' => $desviacion_estandar_tiempo_entrega,
    'nivel_servicio'                     => $nivel_servicio,
    'safety_stock'                       => $safety_stock < 0 ? 0 : $safety_stock,
    'punto_recompra'                     => $punto_recompra < 0 ? 0 : $punto_recompra,
    'trasladar'                          => $trasladar < 0 ? 0 : $trasladar,
    'color_class'                        => $producto['existencia'] < $punto_recompra ? 'table-warning' : 
                                            $producto['existencia'] < $safety_stock ? 'table-danger' : ''
  );
}

function addSafetyStock($productos,$config){
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
  $configs = $q->execute("SELECT ssc.id as id,nv.nivel_servicio as nivel,ssc.tiempo_entrega as tiempo, ssc.dias_analisis as dias, ssc.dias_calculo calculo, ssc.correos_notificacion as correos
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
    'calculo'  => empty($configuracion) ? 30 : $configuracion['calculo'],
  );
}

function guardarSafetyStock($productos, $empresa_id){
  $id_user = 1;
  $fecha = date("Y-m-d H:i:s");

  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $ssfs = $q->execute("SELECT ssf.id as id, ssf.producto_id as producto
      FROM safety_stock_farmacia as ssf where ssf.empresa_id = $empresa_id");

  $productos_e=[];
  foreach($ssfs as $ssf){
    if (array_key_exists($ssf["producto"], $productos)) {
      $productos_e[$ssf["producto"]]=$ssf["id"];
    }
  }
  $lotesUpdate = 100;
  $lotesInsert = 200;
  $countUpdate = 0;
  $countInsert = 0;
  $totalUpdate = 0;
  $totalInsert = 0;
  foreach($productos as $key => $producto){

    if($countInsert == 0)
      $insert = "BEGIN; set foreign_key_checks=0; INSERT INTO safety_stock_farmacia (producto_id, empresa_id, demanda_diaria, desviacion_estandar, punto_reorden_compra, safety_stock, existencia, ventas, trasladar, created_at, updated_at, created_by, updated_by, atendido) VALUES ";
    if($countUpdate == 0)
      $update = "BEGIN; set foreign_key_checks=0; ";

    if(array_key_exists($key, $productos_e)){
      $id=$productos_e[$key];
      $countUpdate++;
      $demanda_diaria = $producto['ss']['demanda_diaria'];
      $desviacion_estandar = $producto['ss']['desviacion_estandar'];
      $punto_reorden_compra = $producto['ss']['punto_recompra'];
      $safety_stock = $producto['ss']['safety_stock'];
      $existencia = $producto['existencia'];
      $ventas = $producto['total'];
      $trasladar = $producto['ss']['trasladar'];
      $update .= "UPDATE safety_stock_farmacia SET demanda_diaria = $demanda_diaria,desviacion_estandar = $desviacion_estandar, punto_reorden_compra=$punto_reorden_compra,safety_stock=$safety_stock,existencia=$existencia,ventas=$ventas,trasladar=$trasladar, updated_at = '$fecha', updated_by =  $id_user, atendido = 0 WHERE id = $id;";
    }else{
      $countInsert++;
      $producto_id = $key;
      $demanda_diaria = $producto['ss']['demanda_diaria'];
      $desviacion_estandar = $producto['ss']['desviacion_estandar'];
      $punto_reorden_compra = $producto['ss']['punto_recompra'];
      $safety_stock = $producto['ss']['safety_stock'];
      $existencia = $producto['existencia'];
      $ventas = $producto['total'];
      $trasladar = $producto['ss']['trasladar'];
      $insert .= "($producto_id, $empresa_id, $demanda_diaria, $desviacion_estandar, $punto_reorden_compra, $safety_stock, $existencia, $ventas, $trasladar, '$fecha', '$fecha', $id_user, $id_user, 0), ";
    }
    if($countInsert==$lotesInsert) {
      $totalInsert = $totalInsert + $countInsert; 
      $countInsert = 0;
      $q->execute(substr($insert, 0, -2)."; COMMIT;");
    }
    if($countUpdate==$lotesUpdate) {
      $totalUpdate = $totalUpdate + $countUpdate; 
      $countUpdate = 0;
      $q->execute($update." COMMIT;");
    }
  }

  if($countInsert>0) {
    $totalInsert = $totalInsert + $countInsert;
    $q->execute(substr($insert, 0, -2)."; COMMIT;");
  }
  if($countUpdate>0) {
    $totalUpdate = $totalUpdate + $countUpdate;
    $q->execute($update." COMMIT;");
  }

  echo 'Registros nuevos ' . $totalInsert . ' Registros modificados ' . $totalUpdate;
  
  $q->close();
}
  
$q = Doctrine_Manager::getInstance()->getCurrentConnection();
$empresas = $q->execute("SELECT sn.srvid as id from server_name as sn");
$empresa_id;
foreach($empresas as $empresa){
  $empresa_id = $empresa['id'];
  break;
}
$config = datosConfig();
$fechahasta=date('Y-m-d');
$fechadesde = date("d-m-Y",strtotime($fechahasta ."- ". $config['calculo'] ." days"));
$desdeQuery=" and f.fecha between '$fechadesde' and '$fechahasta' ";

$ventas_diaria = $q->execute("SELECT p.id pid, p.nombre as pnombre, p.serial as pserial,f.fecha ffecha, sum(fd.qty) as total
FROM factura as f 
inner join factura_det as fd on (f.id=fd.factura_id) 
inner join inventario as i on (fd.inventario_id = i.id)
inner join producto as p on (i.producto_id=p.id)
inner join inv_deposito as d on (i.deposito_id = d.id)
where d.empresa_id = $empresa_id and p.activo = 1 $desdeQuery
group by p.nombre, p.serial, f.fecha
order BY f.fecha");

$productos = obtenerProductos($ventas_diaria, $fechadesde, $fechahasta);

$existencias = $q->execute("SELECT sum(i.cantidad) AS icantidad, i.producto_id pid
        FROM inventario AS i
        INNER JOIN server_name AS sn ON (i.empresa_id=sn.srvid)
        INNER JOIN producto AS p ON (p.id=i.producto_id)
        INNER JOIN inv_deposito AS d ON (d.id=i.deposito_id) WHERE d.tipo = 1
        GROUP BY i.producto_id HAVING icantidad > 0");

$productos = addExistencia($productos, $existencias);
$productos = addSafetyStock($productos,$config);
//$productos = removeSafetyStock($productos, 0);

guardarSafetyStock($productos,$empresa_id);

?>  