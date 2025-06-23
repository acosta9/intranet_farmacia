<?php
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





