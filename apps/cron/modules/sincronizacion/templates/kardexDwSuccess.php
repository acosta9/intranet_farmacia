<?php
// kardex //
$eid = $sf_params->get('eid');
$domain = $sf_params->get('d');

 exec("ping -c 3 " . $domain, $output, $result);
  if ($result == 0) {
    echo "<br/>Ping successful!<br/>";
  } else {
    echo "<br/>Ping unsuccessful!<br/>";
    die();
  }

$q = Doctrine_Manager::getInstance()->getCurrentConnection();
  
  $results = $q->execute("SELECT fecha as fecha FROM kardex WHERE empresa_id=$eid ORDER BY fecha DESC LIMIT 1");
  foreach ($results as $result) {
    $fecha1=strtotime($result["fecha"]);
  }
 
  $q->close();
  
 
 $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "http://$domain/api.php/kardex/gets?eid=$eid&fecha1=$fecha1",
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

 // print_r($response);
  $object = json_decode($response, true);

// kardex //
$cIds=array(); $i=0;
if($object){
 foreach ($object as $item => $value) { 
    $cIds[$i]="'".$value["id"]."'";
    $i++;
  }  
 
$q = Doctrine_Manager::getInstance()->getCurrentConnection();
$ids=implode(",", $cIds);
$ids_existentesc=array();
if(!empty($ids)){
  $results2 = $q->execute("SELECT id FROM kardex WHERE id IN ($ids)");
  foreach ($results2 as $result2) {
     $ids_existentesc[$result2["id"]]=$result2["id"];
  }
}
$newDatac=array();
  $insertc="BEGIN; set foreign_key_checks=0; INSERT INTO kardex (id, empresa_id, deposito_id, producto_id, user_id, tabla, tabla_id, fecha, cantidad, price_unit, price_tot, tipo, concepto, lote, fvenc) VALUES ";
  
  $k=0;
  foreach ($object as $key => $value) { 
    $id=$value["id"];
    $empresa_id=$value["eid"];
    $deposito_id=$value["did"];
    $producto_id=$value["pid"];
    $user_id=$value["uid"];
    $tabla=$value["tabla"];
    $tabla_id=$value["tid"];
    $fecha=$value["fe"];
    $cantidad=$value["cant"];
    $price_unit=$value["punit"];
    $price_tot=$value["ptot"];
    $tipo=$value["tipo"];
    $concepto=$value["con"];
    $lote=$value["lote"];
    $fvenc=$value["fvenc"];
   
  if(empty($ids_existentesc[$id])) {
    $insertc=$insertc."('$id', $empresa_id, $deposito_id, $producto_id, $user_id, '$tabla', $tabla_id, '$fecha', $cantidad,'$price_unit', '$price_tot', $tipo,'$concepto', '$lote', '$fvenc'), ";
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