<?php
//die("hola");
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

// caja_arqueo //
$cIds=array(); $i=0;
if($object[0]['cajaar']){
 foreach ($object[0]['cajaar'] as $item => $value) { 
    $cIds[$i]=$value["id"];
    $i++;
  }  
 
$q = Doctrine_Manager::getInstance()->getCurrentConnection();
$ids=implode(",", $cIds);

$results = $q->execute("SELECT id FROM caja_arqueo WHERE id IN ($ids)");
$ids_existentes=array();
foreach ($results as $result) {
  $ids_existentes[$result["id"]]=$result["id"];
}

$newDatac=array();
$insertc="BEGIN; set foreign_key_checks=0; INSERT INTO caja_arqueo (id, caja_id, sf_guard_user_id,fecha, moneda, forma_pago_id, monto, descripcion) VALUES ";
$updatec="BEGIN; ";
$j=0; $k=0;
foreach ($object[0]['cajaar'] as $key => $value) { 
  $id=$value["id"];
  $caja_id=$value["cid"];
  $sf_guard_user_id=$value["uid"];
  $fecha=$value["fe"];
  $moneda=$value["mon"];
  $forma_pago_id=$value["fpid"];
  $monto=$value["monto"];
  $descripcion=$value["des"];
  
  if(!empty($ids_existentes[$id])) {
    $updatec=$updatec." UPDATE caja_arqueo SET caja_id=$caja_id, sf_guard_user_id=$sf_guard_user_id, fecha='$fecha',  moneda=$moneda, forma_pago_id=$forma_pago_id, monto='$monto', descripcion='$descripcion' WHERE id=$id; ";
    $j++;
  } else {
    $insertc=$insertc."($id, $caja_id,$sf_guard_user_id,'$fecha', $moneda, $forma_pago_id, '$monto', '$descripcion'), ";
    $k++;
  }
  $newDatac[]=array (
    'id' => $id,
    'cid' => $caja_id,
    'uid' => $sf_guard_user_id,
    'fe' => $fecha,
    'mon' => $moneda,
    'fpid' => $forma_pago_id,
    'monto' => $monto,
    'des' => $descripcion  
  );
 }

$insertc=substr($insertc, 0, -2)."; COMMIT;";
$updatec=$updatec."COMMIT; ";

if($j>0) {
  $error3 = $q->execute($updatec);
}

if($k>0) {
  $error2 = $q->execute($insertc);
} 
echo json_encode($newDatac);
$q->close();
}

// caja_corte //
$crIds=array(); $i=0;
if($object[0]['cajacorte']){
 foreach ($object[0]['cajacorte'] as $item => $value) { 
    $crIds[$i]=$value["id"];
    $i++;
  }  
 
$q = Doctrine_Manager::getInstance()->getCurrentConnection();
$ids=implode(",", $crIds);

$results2 = $q->execute("SELECT id FROM caja_corte WHERE id IN ($ids)");
$ids_existentescr=array();
foreach ($results2 as $result2) {
  $ids_existentescr[$result2["id"]]=$result2["id"];
}

$newDatacr=array();
$insertcr="BEGIN; set foreign_key_checks=0; INSERT INTO caja_corte (id, caja_id, sf_guard_user_id, tipo, fecha_ini, fecha_fin, ult_repz, fecha_repz, hora_repz, ult_fact, fecha_ult_fact, hora_ult_fact, ult_nc, exento_fact, base_impt1_fact, iva_t1_fact, exento_nc, base_impt1_nc, iva_t1_nc, codigof, cant_fact, cant_nc
) VALUES ";
$updatecr="BEGIN; ";
$j=0; $k=0;
foreach ($object[0]['cajacorte'] as $key => $value) { 
  $id=$value["id"];
  $caja_id=$value["cid"];
  $sf_guard_user_id=$value["uid"];
  $tipo=$value["tipo"];
  $fecha_ini=$value["fini"];
  $fecha_fin=$value["fin"];
  $ult_repz=$value["uz"];
  $fecha_repz=$value["fz"];
  $hora_repz=$value["hz"];
  $ult_fact=$value["uf"];
  $fecha_ult_fact=$value["fuf"];
  $hora_ult_fact=$value["huf"];
  $ult_nc=$value["unc"];
  $exento_fact=$value["exf"];
  $base_impt1_fact=$value["bif"];
  $iva_t1_fact=$value["it1f"];
  $exento_nc=$value["exnc"];
  $base_impt1_nc=$value["binc"];
  $iva_t1_nc=$value["it1nc"];
  $codigof=$value["codf"];
  $cant_fact=$value["cantf"];
  $cant_nc=$value["cantnc"];
  
  
  if(!empty($ids_existentescr[$id])) {
    $updatecr=$updatecr." UPDATE caja_corte SET caja_id=$caja_id, sf_guard_user_id=$sf_guard_user_id, tipo=$tipo, fecha_ini='$fecha_ini', fecha_fin='$fecha_fin', ult_repz='$ult_repz', fecha_repz='$fecha_repz', hora_repz='$hora_repz', ult_fact='$ult_fact', fecha_ult_fact='$fecha_ult_fact', hora_ult_fact='$hora_ult_fact', ult_nc='$ult_nc', exento_fact='$exento_fact', base_impt1_fact='$base_impt1_fact', iva_t1_fact='$iva_t1_fact', exento_nc='$exento_nc', base_impt1_nc='$base_impt1_nc', iva_t1_nc='$iva_t1_nc', codigof='$codigof', cant_fact=$cant_fact, cant_nc=$cant_nc WHERE id=$id; ";
    $j++;
  } else {
     $insertcr=$insertcr."($id, $caja_id,$sf_guard_user_id, $tipo, '$fecha_ini', '$fecha_fin', '$ult_repz', '$fecha_repz', '$hora_repz', '$ult_fact', '$fecha_ult_fact', '$hora_ult_fact', '$ult_nc', '$exento_fact', '$base_impt1_fact', '$iva_t1_fact', '$exento_nc', '$base_impt1_nc', '$iva_t1_nc', '$codigof', $cant_fact, $cant_nc), ";
    $k++;
  }
  $newDatacr[]=array (
    'id' => $id,
    'cid' => $caja_id,
    'uid' => $sf_guard_user_id,
    'tipo' => $tipo,
    'fini' => $fecha_ini,
    'fin' => $fecha_fin,
    'uz' => $ult_repz,
    'fz' => $fecha_repz,
    'hz' => $hora_repz,
    'uf' => $ult_fact,
    'fuf' => $fecha_ult_fact,
    'huf' => $hora_ult_fact,
    'unc' => $ult_nc,
    'exf' => $exento_fact,
    'bif' => $base_impt1_fact,
    'it1f' => $iva_t1_fact,
    'exnc' => $exento_nc,
    'binc' => $base_impt1_nc,
    'it1nc' => $iva_t1_nc,
    'codf' => $codigof,
    'cantf' => $cant_fact,
    'cantnc' => $cant_nc  
  );
 }

$insertcr=substr($insertcr, 0, -2)."; COMMIT;";
$updatecr=$updatecr."COMMIT; ";

if($j>0) {
  $error3 = $q->execute($updatecr);
}

if($k>0) {
  $error2 = $q->execute($insertcr);
} 
echo json_encode($newDatacr);
$q->close();
}

// caja_det //
$cdIds=array(); $i=0;
if($object[0]['cajadet']){
 foreach ($object[0]['cajadet'] as $item => $value) { 
    $cdIds[$i]=$value["id"];
    $i++;
  }  
 
$q = Doctrine_Manager::getInstance()->getCurrentConnection();
$ids=implode(",", $cdIds);

$results3 = $q->execute("SELECT id FROM caja_det WHERE id IN ($ids)");
$ids_existentescd=array();
foreach ($results3 as $result3) {
  $ids_existentescd[$result3["id"]]=$result3["id"];
}

$newDatacd=array();
$insertcd="BEGIN; set foreign_key_checks=0; INSERT INTO caja_det (id, caja_id,sf_guard_user_id,fecha, status, fondo,  descripcion) VALUES ";
$updatecd="BEGIN; ";
$j=0; $k=0;
foreach ($object[0]['cajadet'] as $key => $value) { 
  $id=$value["id"];
  $caja_id=$value["cid"];
  $sf_guard_user_id=$value["uid"];
  $fecha=$value["fe"];
  $status=$value["st"];
  $fondo=$value["fon"];
  $descripcion=$value["des"];
  
  if(!empty($ids_existentescd[$id])) {
   $updatecd=$updatecd." UPDATE caja_det SET caja_id=$caja_id, sf_guard_user_id=$sf_guard_user_id, fecha='$fecha',  status=$status, fondo='$fondo', descripcion='$descripcion' WHERE id=$id; ";
    $j++;
  } else {
    $insertcd=$insertcd."($id, $caja_id,$sf_guard_user_id,'$fecha', $status, '$fondo', '$descripcion'), ";
    $k++;
  }
  $newDatacd[]=array (
    'id' => $id,
    'cid' => $caja_id,
    'uid' => $sf_guard_user_id,
    'fe' => $fecha,
    'st' => $status,
    'fon' => $fondo,
    'des' => $descripcion  
  );
 }

$insertcd=substr($insertcd, 0, -2)."; COMMIT;";
$updatecd=$updatecd."COMMIT; ";

if($j>0) {
  $error3 = $q->execute($updatecd);
}

if($k>0) {
  $error2 = $q->execute($insertcd);
} 
echo json_encode($newDatacd);
$q->close();
}

// caja_efectivo //
$ceIds=array(); $i=0;
if($object[0]['cajaef']){
 foreach ($object[0]['cajaef'] as $item => $value) { 
    $ceIds[$i]=$value["id"];
    $i++;
  }  
 
$q = Doctrine_Manager::getInstance()->getCurrentConnection();
$ids=implode(",", $ceIds);

$results4 = $q->execute("SELECT id FROM caja_efectivo WHERE id IN ($ids)");
$ids_existentesce=array();
foreach ($results4 as $result4) {
  $ids_existentesce[$result4["id"]]=$result4["id"];
}

$newDatace=array();
$insertce="BEGIN; set foreign_key_checks=0; INSERT INTO caja_efectivo (id, caja_id, sf_guard_user_id, fecha, moneda, billete, cantidad, descripcion) VALUES ";
$updatece="BEGIN; ";
$j=0; $k=0;
foreach ($object[0]['cajaef'] as $key => $value) { 
  $id=$value["id"];
  $caja_id=$value["cid"];
  $sf_guard_user_id=$value["uid"];
  $fecha=$value["fe"];
  $moneda=$value["mon"];
  $billete=$value["bil"];
  $cantidad=$value["cant"];
  $descripcion=$value["des"];
  
  if(!empty($ids_existentesce[$id])) {
     $updatece=$updatece." UPDATE caja_efectivo SET caja_id=$caja_id, sf_guard_user_id=$sf_guard_user_id, fecha='$fecha',  moneda=$moneda, billete='$billete', cantidad='$cantidad', descripcion='$descripcion' WHERE id=$id; ";
    $j++;
  } else {
    $insertce=$insertce."($id, $caja_id,$sf_guard_user_id,'$fecha', $moneda, '$billete', '$cantidad', '$descripcion'), ";
    $k++;
  }
  $newDatace[]=array (
    'id' => $id,
    'cid' => $caja_id,
    'uid' => $sf_guard_user_id,
    'fe' => $fecha,
    'mon' => $moneda,
    'bil' => $billete,
    'cant' => $cantidad,
    'des' => $descripcion  
  );
 }

$insertce=substr($insertce, 0, -2)."; COMMIT;";
$updatece=$updatece."COMMIT; ";

if($j>0) {
  $error3 = $q->execute($updatece);
}

if($k>0) {
  $error2 = $q->execute($insertce);
} 
echo json_encode($newDatace);
$q->close();
}
