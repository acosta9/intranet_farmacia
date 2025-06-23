<?php
$tipo = $sf_params->get('tipo');
// Only allow POST requests
if (strtoupper($_SERVER['REQUEST_METHOD']) != 'POST') {
  throw new Exception('Only POST requests are allowed');
}

// Make sure Content-Type is application/json 
$content_type = isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : '';
if (stripos($content_type, 'application/json') === false) {
  throw new Exception('Content-Type must be application/json');
}

// Read the input stream
$body = file_get_contents("php://input");

$object = json_decode($body, true);

// Throw an exception if decoding failed
if (!is_array($object)) {
  throw new Exception('Failed to decode JSON object');
}
// traslado //
$otIds=array(); $i=0;
if($object && $tipo == "createdat"){
  foreach ($object as $item => $value) { 
      $otIds[$i]=$value["id"];
      $i++;
    }  
   
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $ids=implode(",", $otIds);
  $ids_existentes=array();
  if(!empty($ids)){
    $results = $q->execute("SELECT id FROM traslado WHERE id IN ($ids)");
    foreach ($results as $result) {
      $ids_existentes[$result["id"]]=$result["id"];
    }
  }
  $newDatat=array();
  $insertt="BEGIN; set foreign_key_checks=0; INSERT INTO traslado (id, ncontrol, empresa_desde, deposito_desde, empresa_hasta, deposito_hasta, estatus, tasa_cambio, monto, created_at, updated_at, created_by, updated_by) VALUES ";
  $inserttd="INSERT INTO traslado_det (traslado_id, producto_id, inventario_id, qty, prod_destino_id, inv_destino_id, qty_dest, price_unit, price_tot, descripcion) VALUES ";
   $k=0; $y=0;
  foreach ($object as $key => $value) { 
    $id=$value["id"];
    $ncontrol=$value["nctr"];
    $empresa_desde=$value["eidd"];
    $deposito_desde=$value["didd"];
    $empresa_hasta=$value["eidh"];
    $deposito_hasta=$value["didh"];
    $estatus=$value["est"];
    $tasa_cambio=$value["tas"];
    $monto=$value["mon"];
    $created_at=date("Y-m-d H:i:s", $value["cat"]);
    $updated_at=date("Y-m-d H:i:s", $value["uat"]);
    $created_by=$value["cby"];
    $updated_by=$value["uby"];
    $dets=$value["dets"];

    if(empty($ids_existentes[$id])) {
      $insertt=$insertt."($id, '$ncontrol', $empresa_desde, $deposito_desde, $empresa_hasta, $deposito_hasta, $estatus, '$tasa_cambio', '$monto', '$created_at', '$created_at', '$created_by', '$updated_by'), ";
      $k++;
      foreach ($value["dets"] as $key => $detalle) {
          $traslado_id=$detalle["tid"];
          $producto_id=$detalle["pid"];
          $inventario_id=$detalle["iid"];
          $qty=$detalle["qty"];
          $prod_destino_id=$detalle["pdid"];
          $inv_destino_id=$detalle["idid"];
          $qty_dest=$detalle["qtyd"];
          $price_unit=$detalle["punit"];
          $price_tot=$detalle["ptot"];
          $descripcion=$detalle["des"];
       
        $inserttd=$inserttd."($traslado_id, $producto_id, $inventario_id, '$qty', $prod_destino_id, $inv_destino_id, $qty_dest, '$price_unit', '$price_tot', '$descripcion'), ";
       $y++;
      }
    }
    $newDatat[]=$value;
   } // foreach tras

  $insertt=substr($insertt, 0, -2)."; ";
  $inserttd=substr($inserttd, 0, -2)."; COMMIT;";
  echo $sentencia=$insertt.$inserttd;
  if($k>0) {
    $error2 = $q->execute($sentencia);
  }
 // echo json_encode($newDatat);
  $q->close();
}
elseif($object && $tipo == "updatedat"){
     foreach ($object as $item => $value) { 
      $otIds[$i]=$value["id"];
      $i++;
    }  
   
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $ids=implode(",", $otIds);
  $ids_existentes=array();
  if(!empty($ids)){
    $results = $q->execute("SELECT id FROM traslado WHERE id IN ($ids)");
    foreach ($results as $result) {
      $ids_existentes[$result["id"]]=$result["id"];
    }
  }
  $newDatat=array();
  $updatet="BEGIN; set foreign_key_checks=0; ";
  $j=0; 
  foreach ($object as $key => $value) { 
    $id=$value["id"];
    $estatus=$value["est"];
    $updated_at=date("Y-m-d H:i:s", $value["uat"]);
    $updated_by=$value["uby"];

    if(!empty($ids_existentes[$id])) {
      $updatet=$updatet." UPDATE traslado SET  estatus=$estatus, updated_at='$updated_at', updated_by='$updated_by' WHERE id=$id; ";
      $j++;
    } 
    $newDatat[]=$value;
   }

  $updatet=$updatet."COMMIT; ";

  if($j>0) {
    $error3 = $q->execute($updatet);
  }

  echo json_encode($newDatat);
  $q->close();
}
