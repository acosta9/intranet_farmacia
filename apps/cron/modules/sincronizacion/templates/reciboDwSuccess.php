<?php
// recibo_pago, prod_vendidos //
$eid = $sf_params->get('eid');
$domain = $sf_params->get('d');
$tipo = $sf_params->get('t');

 exec("ping -c 3 " . $domain, $output, $result);
  if ($result == 0) {
    echo "<br/>Ping successful!<br/>";
  } else {
    echo "<br/>Ping unsuccessful!<br/>";
    die();
  }

$q = Doctrine_Manager::getInstance()->getCurrentConnection();
  if($tipo=="createdat") {
  $results = $q->execute("SELECT created_at as fecha FROM recibo_pago WHERE empresa_id=$eid AND updated_at=created_at ORDER BY created_at DESC LIMIT 1");
  } else {
    $results = $q->execute("SELECT updated_at as fecha FROM recibo_pago WHERE empresa_id=$eid AND updated_at<>created_at ORDER BY updated_at DESC LIMIT 1");
  }
  foreach ($results as $result) {
    $fecha1=strtotime($result["fecha"]);
  }
 $results2 = $q->execute("SELECT fecha as fecha FROM prod_vendidos WHERE empresa_id=$eid ORDER BY fecha DESC LIMIT 1");
  foreach ($results2 as $result2) {
    $fecha2=strtotime($result2["fecha"]);
  }
  $q->close();
 

 $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "http://$domain/api.php/recibo/gets?eid=$eid&tipo=$tipo&fecha1=$fecha1&fecha2=$fecha2",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 45,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
      'Content-Type: application/json',
      'Accept: application/json'
    ),
  ));
  $response = curl_exec($curl);
  curl_close($curl);
  $object = json_decode($response, true);


// recibo_pago //
$Ids=array(); $i=0;
if($object[0]['recibo'] && $tipo == "createdat"){
 foreach ($object[0]['recibo'] as $item => $value) { 
    $Ids[$i]=$value["id"];
    $i++;
  }  
 
$q = Doctrine_Manager::getInstance()->getCurrentConnection();
$ids=implode(",", $Ids);
$ids_existentes=array();
if(!empty($ids)){
  $results = $q->execute("SELECT id FROM recibo_pago WHERE id IN ($ids)");
  foreach ($results as $result) {
    $ids_existentes[$result["id"]]=$result["id"];
  }
}
$newData=array();
$insert="BEGIN; set foreign_key_checks=0; INSERT INTO recibo_pago (id, empresa_id, cliente_id, cuentas_cobrar_id, ncontrol, moneda, forma_pago_id, num_recibo, fecha, monto, monto2, quien_paga, url_imagen, tasa_cambio, descripcion, anulado, created_at, updated_at, created_by, updated_by) VALUES ";
 $k=0;
foreach ($object[0]['recibo'] as $key => $value) { 
  $id=$value["id"];
  $empresa_id=$value["eid"];
  $cliente_id=$value["cid"];
  $cuentas_cobrar_id=$value["ccid"];
  $ncontrol=$value["nc"];
  $moneda=$value["mone"];
  $forma_pago_id=$value["fp"];
  $num_recibo=$value["numr"];
  $fecha=$value["fe"];
  $monto=$value["mon"];
  $monto2=$value["mon2"];
  $quien_paga=$value["quien"];
  $url_imagen=$value["urli"];
  $tasa_cambio=$value["tasa"];
  $descripcion=$value["des"];
  $anulado=$value["anu"];
  $created_at=date("Y-m-d H:i:s", $value["cat"]);
  $updated_at=date("Y-m-d H:i:s", $value["uat"]);
  $created_by=$value["cby"];
  $updated_by=$value["uby"]; 
  

  if(empty($ids_existentes[$id])) {
    $insert=$insert."($id, $empresa_id, $cliente_id, $cuentas_cobrar_id, '$ncontrol', $moneda, $forma_pago_id, '$num_recibo', '$fecha', '$monto', '$monto2', '$quien_paga', '$url_imagen', '$tasa_cambio', '$descripcion', $anulado, '$created_at', '$created_at', $created_by, $updated_by), ";
    $k++;
  }
  $newData[]=$value;
 }

$insert=substr($insert, 0, -2)."; COMMIT;";
if($k>0) {
  $error2 = $q->execute($insert);
} 
echo json_encode($newData);
$q->close();
} 
elseif($object[0]['recibo'] && $tipo == "updatedat"){
 foreach ($object[0]['recibo'] as $item => $value) { 
    $Ids[$i]=$value["id"];
    $i++;
  }  
 
$q = Doctrine_Manager::getInstance()->getCurrentConnection();
$ids=implode(",", $Ids);
$ids_existentes=array();
if(!empty($ids)){
  $results = $q->execute("SELECT id FROM recibo_pago WHERE id IN ($ids)");
  foreach ($results as $result) {
    $ids_existentes[$result["id"]]=$result["id"];
  }
}
$newData=array();
$update="BEGIN; set foreign_key_checks=0; ";
$j=0; 
foreach ($object[0]['recibo'] as $key => $value) { 
  $id=$value["id"];
  $anulado=$value["anu"];
  $updated_at=date("Y-m-d H:i:s", $value["uat"]);
  $updated_by=$value["uby"]; 
 
  if(!empty($ids_existentes[$id])) {
    $update=$update." UPDATE recibo_pago SET anulado = $anulado,  updated_at = '$updated_at', updated_by = $updated_by WHERE id=$id; ";
    $j++;
  } 
  $newData[]=$value;
 }

$update=$update."COMMIT; ";

if($j>0) {
  $error3 = $q->execute($update);
}

echo json_encode($newData);
$q->close();
}


// prod_vendidos //
$cIds=array(); $i=0;
if($object[0]['pvendido'] && $tipo == "createdat"){
 foreach ($object[0]['pvendido'] as $item => $value) { 
    $cIds[$i]="'".$value["id"]."'";
    $i++;
  }  
 
$q = Doctrine_Manager::getInstance()->getCurrentConnection();
$ids=implode(",", $cIds);
$ids_existentesc=array();
if(!empty($ids)){
  $results2 = $q->execute("SELECT id FROM prod_vendidos WHERE id IN ($ids)");
  foreach ($results2 as $result2) {
     $ids_existentesc[$result2["id"]]=$result2["id"];
  }
}
$newDatac=array();
$insertc="BEGIN; set foreign_key_checks=0; INSERT INTO prod_vendidos (id,empresa_id, deposito_id, producto_id, cliente_id, user_id, price_unit, price_tot,  tabla, tabla_id, fecha, cantidad, oferta, anulado) VALUES ";
$k=0;
foreach ($object[0]['pvendido'] as $key => $value) { 
  $id=$value["id"];
  $empresa_id=$value["eid"];
  $deposito_id=$value["did"];
  $producto_id=$value["pid"];
  $cliente_id=$value["cid"];
  $user_id=$value["uid"];
  $price_unit=$value["punit"];
  $price_tot=$value["ptot"];
  $tabla=$value["tabla"];
  $tabla_id=$value["tid"];
  $fecha=$value["fe"];
  $cantidad=$value["cant"];
  $oferta=$value["of"];
  $anulado=$value["anu"];
   
  if(empty($ids_existentesc[$id])) {
    $insertc=$insertc."('$id', $empresa_id, $deposito_id, $producto_id, $cliente_id, $user_id, '$price_unit', '$price_tot',  '$tabla', $tabla_id, '$fecha', $cantidad, $oferta, $anulado), ";
    $k++;
  }
  $newDatac[]=$value;
 }

echo $insertc=substr($insertc, 0, -2)."; COMMIT;";

if($k>0) {
  $error2 = $q->execute($insertc);
} 
echo json_encode($newDatac);
$q->close();
} 
elseif($object[0]['pvendido'] && $tipo == "updatedat"){
 foreach ($object[0]['pvendido'] as $item => $value) { 
    $cIds[$i]="'".$value["id"]."'";
    $i++;
  }  
 
$q = Doctrine_Manager::getInstance()->getCurrentConnection();
$ids=implode(",", $cIds);
$ids_existentesc=array();
if(!empty($ids)){
$results2 = $q->execute("SELECT id FROM prod_vendidos WHERE id IN ($ids)");
  foreach ($results2 as $result2) {
     $ids_existentesc[$result2["id"]]=$result2["id"];
  }
}
$newDatac=array();
$updatec="BEGIN; set foreign_key_checks=0; ";
$j=0; 
foreach ($object[0]['pvendido'] as $key => $value) { 
  $id=$value["id"];
    
  if(!empty($ids_existentesc[$id])) {
   $updatec=$updatec." UPDATE prod_vendidos SET anulado = 1  WHERE id='$id'; ";
    $j++;
  } 
  $newDatac[]=$value;
 }

$updatec=$updatec."COMMIT; ";

if($j>0) {
  $error3 = $q->execute($updatec);
}

echo json_encode($newDatac);
$q->close();
}
