<?php
//die("hola");
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
//echo $object[0]['cajacorte']; die();
// Throw an exception if decoding failed
if (!is_array($object)) {
  throw new Exception('Failed to decode JSON object');
}

// factura //
$fIds=array(); $i=0;
if($object[0]['factura'] && $tipo == "createdat"){
 foreach ($object[0]['factura'] as $item => $value) { 
    $fIds[$i]=$value["id"];
    $i++;
  }  
 
$q = Doctrine_Manager::getInstance()->getCurrentConnection();
$ids=implode(",", $fIds);
$ids_existentes=array();
if(!empty($ids)){
  $results = $q->execute("SELECT id FROM factura WHERE id IN ($ids)");
  foreach ($results as $result) {
    $ids_existentes[$result["id"]]=$result["id"];
  }
}
$newDataf=array();
$insertf="BEGIN; set foreign_key_checks=0; INSERT INTO factura (id, fecha, dias_credito, empresa_id, deposito_id, cliente_id,  caja_id, razon_social, doc_id, telf, direccion, direccion_entrega, ncontrol, num_factura, num_fact_fiscal, codigof, ndespacho, forma_pago, tasa_cambio , subtotal, subtotal_desc, iva, base_imponible, iva_monto, total, total2, descuento, monto_faltante, monto_pagado, has_invoice, estatus, created_at, updated_at, created_by, updated_by) VALUES ";
$k=0;
foreach ($object[0]['factura'] as $key => $value) { 
  $id=$value["id"];
  $fecha=$value["fe"];
  $dias_credito=$value["dc"];
  $empresa_id=$value["eid"];
  $deposito_id=$value["did"];
  $cliente_id=$value["cid"];
  $caja_id=$value["cid"];
  $razon_social=$value["rs"];
  $doc_id=$value["doc"];
  $telf=$value["telf"];
  $direccion=$value["dir"];
  $direccion_entrega=$value["dire"];
  $ncontrol=$value["nc"];
  $num_factura=$value["nfac"];
  $num_fact_fiscal=$value["nfacf"];
  $codigof=$value["codf"];
  $ndespacho=$value["ndes"];
  $forma_pago=$value["fp"];
  $tasa_cambio=$value["tasa"];
  $subtotal=$value["subt"];
  $subtotal_desc=$value["subtd"];
  $iva=$value["iva"];
  $base_imponible=$value["bi"];
  $iva_monto=$value["ivam"];
  $total=$value["total"];
  $total2=$value["total2"];
  $descuento=$value["desc"];
  $monto_faltante=$value["monf"]; 
  $monto_pagado=$value["monp"];
  $has_invoice=$value["hinv"];
  $estatus=$value["est"];
  $created_at=date("Y-m-d H:i:s", $value["cat"]);
  $updated_at=date("Y-m-d H:i:s", $value["uat"]);
  $created_by=$value["cby"];
  $updated_by=$value["uby"]; 
  
  if(empty($ids_existentes[$id])) {
    $insertf=$insertf."($id, '$fecha', '$dias_credito', $empresa_id, $deposito_id, $cliente_id, $caja_id, '$razon_social', '$doc_id', '$telf', '$direccion', '$direccion_entrega', '$ncontrol', '$num_factura', '$num_fact_fiscal', '$codigof', '$ndespacho', '$forma_pago', '$tasa_cambio' , '$subtotal', '$subtotal_desc', '$iva', '$base_imponible', '$iva_monto', '$total', '$total2', '$descuento', '$monto_faltante', '$monto_pagado', $has_invoice, $estatus, '$created_at', '$created_at', '$created_by', '$updated_by'), ";
    $k++;
  }
  $newDataf[]=$value;
   
 }

 $insertf=substr($insertf, 0, -2)."; COMMIT;";

  if($k>0) {
    $error2 = $q->execute($insertf);
  } 
 
  echo json_encode($newDataf);
  $q->close();
} 
elseif($object[0]['factura'] && $tipo == "updatedat") {

  foreach ($object[0]['factura'] as $item => $value) { 
      $fIds[$i]=$value["id"];
      $i++;
    }  
   
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $ids=implode(",", $fIds);
  $ids_existentes=array();
if(!empty($ids)){
  $results = $q->execute("SELECT id FROM factura WHERE id IN ($ids)");
   foreach ($results as $result) {
    $ids_existentes[$result["id"]]=$result["id"];
  }
 }
  $newDataf=array();
  $updatef="BEGIN; set foreign_key_checks=0;";
  $j=0; 
  foreach ($object[0]['factura'] as $key => $value) { 
    $id=$value["id"];
    $estatus=$value["est"];
    $updated_at=date("Y-m-d H:i:s", $value["uat"]);
    $updated_by=$value["uby"]; 
    
    if(!empty($ids_existentes[$id])) {
       $updatef=$updatef." UPDATE factura SET estatus = $estatus,  updated_at = '$updated_at', updated_by =  '$updated_by' WHERE id=$id; ";
      $j++;
    }
    $newDataf[]=$value;
   }

   $updatef=$updatef."COMMIT; ";

    if($j>0) {
      $error3 = $q->execute($updatef);
    }
    
    echo json_encode($newDataf);
    $q->close();
}

// cliente //
$cIds=array(); $i=0;
if($object[0]['cliente'] && $tipo == "createdat"){
 foreach ($object[0]['cliente'] as $item => $value) { 
    $cIds[$i]=$value["id"];
    $i++;
  }  
 
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $ids=implode(",", $cIds);
  $ids_existentesc=array();
  if(!empty($ids)){
    $results2 = $q->execute("SELECT id FROM cliente WHERE id IN ($ids)");
    foreach ($results2 as $result2) {
      $ids_existentesc[$result2["id"]]=$result2["id"];
  }
  }
  $newDatac=array();
  $insertc="BEGIN; set foreign_key_checks=0; INSERT INTO cliente (id, empresa_id, full_name, doc_id, sicm, zona, direccion, telf, celular, email, tipo_precio, dias_credito, activo, descripcion, created_at, updated_at, created_by, updated_by
  ) VALUES ";
   $k=0;
  foreach ($object[0]['cliente'] as $key => $value) { 
    $id=$value["id"];
    $empresa_id=$value["eid"];
    $full_name=$value["fna"];
    $doc_id=$value["doc"];
    $sicm=$value["sicm"];
    $zona=$value["zona"];
    $direccion=$value["dir"];
    $telf=$value["telf"];
    $celular=$value["cel"];
    $email=$value["email"];
    $tipo_precio=$value["tp"];
    $dias_credito=$value["dc"];
    $activo=$value["act"];
    $descripcion=$value["des"];
    $created_at=date("Y-m-d H:i:s", $value["cat"]);
    $updated_at=date("Y-m-d H:i:s", $value["uat"]);
    $created_by=$value["cby"];
    $updated_by=$value["uby"];
    
    
    if(empty($ids_existentesc[$id])) {
      $insertc=$insertc."($id, $empresa_id, '$full_name', '$doc_id', '$sicm', '$zona', '$direccion', '$telf', '$celular', '$email', $tipo_precio, $dias_credito, $activo, '$descripcion', '$created_at', '$created_at', '$created_by', '$updated_by'), ";
      $k++;
    }
    $newDatac[]=$value;
   }

  $insertc=substr($insertc, 0, -2)."; COMMIT;";

  if($k>0) {
    $error2 = $q->execute($insertc);
  } 
  echo json_encode($newDatac);
  $q->close();
}
elseif($object[0]['cliente'] && $tipo == "updatedat"){
 foreach ($object[0]['cliente'] as $item => $value) { 
    $cIds[$i]=$value["id"];
    $i++;
  }  
 
$q = Doctrine_Manager::getInstance()->getCurrentConnection();
$ids=implode(",", $cIds);
$ids_existentesc=array();
  if(!empty($ids)){
$results2 = $q->execute("SELECT id FROM cliente WHERE id IN ($ids)");
  foreach ($results2 as $result2) {
    $ids_existentesc[$result2["id"]]=$result2["id"];
  }
}
$newDatac=array();
$updatec="BEGIN; set foreign_key_checks=0;";
$j=0;
foreach ($object[0]['cliente'] as $key => $value) { 
  $id=$value["id"];
  $full_name=$value["fna"];
  $doc_id=$value["doc"];
  $direccion=$value["dir"];
  $telf=$value["telf"];
  $updated_at=date("Y-m-d H:i:s", $value["uat"]);
  $updated_by=$value["uby"];
 
  if(!empty($ids_existentesc[$id])) {
    $updatec=$updatec." UPDATE cliente SET  full_name = '$full_name', doc_id = '$doc_id', direccion = '$direccion', telf = '$telf', updated_at = '$updated_at', updated_by = '$updated_by' WHERE id=$id; ";
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

// cuentas_cobrar //
$cdIds=array(); $i=0;
if($object[0]['ctascobrar'] && $tipo == "createdat"){
   foreach ($object[0]['ctascobrar'] as $item => $value) { 
      $cdIds[$i]=$value["id"];
      $i++;
    }  
   
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $ids=implode(",", $cdIds);
  $ids_existentescd=array();
  if(!empty($ids)){
    $results3 = $q->execute("SELECT id FROM cuentas_cobrar WHERE id IN ($ids)");
    foreach ($results3 as $result3) {
      $ids_existentescd[$result3["id"]]=$result3["id"];
    }
  }
  $newDatacd=array();
  $insertcd="BEGIN; set foreign_key_checks=0; INSERT INTO cuentas_cobrar (id, fecha, dias_credito, empresa_id, cliente_id, factura_id, nota_entrega_id, total, monto_faltante, monto_pagado, tasa_cambio, estatus, created_at, updated_at) VALUES ";
   $k=0;
  foreach ($object[0]['ctascobrar'] as $key => $value) { 
    $id=$value["id"];
    $fecha=$value["fe"];
    $dias_credito=$value["dc"];
    $empresa_id=$value["eid"];
    $cliente_id=$value["cid"];
    $factura_id=$value["fid"];
    $nota_entrega_id=$value["neid"];
    $total=$value["total"];
    $monto_faltante=$value["monf"];
    $monto_pagado=$value["monp"];
    $tasa_cambio=$value["tasa"];
    $estatus=$value["est"];
    $created_at=date("Y-m-d H:i:s", $value["cat"]);
    $updated_at=date("Y-m-d H:i:s", $value["uat"]);
    if($nota_entrega_id==NULL || $nota_entrega_id=="" || $nota_entrega_id==null){
        $nota_entrega_id='NULL';
      } 

    if(empty($ids_existentescd[$id])) {
       $insertcd=$insertcd."($id, '$fecha', '$dias_credito', $empresa_id, $cliente_id, $factura_id, $nota_entrega_id, '$total', '$monto_faltante', '$monto_pagado', '$tasa_cambio', $estatus, '$created_at', '$created_at'), ";
      $k++;
    }
    $newDatacd[]=$value;
   }

  $insertcd=substr($insertcd, 0, -2)."; COMMIT;";
  if($k>0) {
    $error2 = $q->execute($insertcd);
  } 
  echo json_encode($newDatacd);
  $q->close();
}
elseif($object[0]['ctascobrar'] && $tipo == "updatedat"){
   foreach ($object[0]['ctascobrar'] as $item => $value) { 
      $cdIds[$i]=$value["id"];
      $i++;
    }  
   
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $ids=implode(",", $cdIds);
  $ids_existentescd=array();
  if(!empty($ids)){
  $results3 = $q->execute("SELECT id FROM cuentas_cobrar WHERE id IN ($ids)");
    foreach ($results3 as $result3) {
      $ids_existentescd[$result3["id"]]=$result3["id"];
    }
  }
  $newDatacd=array();
  $updatecd="BEGIN; set foreign_key_checks=0; ";
  $j=0;
  foreach ($object[0]['ctascobrar'] as $key => $value) { 
    $id=$value["id"];
    $estatus=$value["est"];
    $updated_at=date("Y-m-d H:i:s", $value["uat"]);
   
    if(!empty($ids_existentescd[$id])) {
       $updatecd=$updatecd." UPDATE cuentas_cobrar SET estatus = $estatus,  updated_at = '$updated_at' WHERE id=$id; ";
      $j++;
    } 
    $newDatacd[]=$value;
   }

  $updatecd=$updatecd."COMMIT; ";

  if($j>0) {
    $error3 = $q->execute($updatecd);
  }

  echo json_encode($newDatacd);
  $q->close();
}
