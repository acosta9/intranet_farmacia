<?php
  $eid = $sf_params->get('eid');
  $tipo = $sf_params->get('tipo');
  if($sf_params->get('fecha1'))
  $fecha1 = date("Y-m-d H:i:s", $sf_params->get('fecha1')); 
  if($sf_params->get('fecha2'))
  $fecha2 = date("Y-m-d H:i:s", $sf_params->get('fecha2'));
  if($sf_params->get('fecha3'))
  $fecha3 = date("Y-m-d H:i:s", $sf_params->get('fecha3'));


  $q = Doctrine_Manager::getInstance()->getCurrentConnection();

 // otros //
  $otros=array();

      $results = $q->execute("SELECT * FROM otros WHERE empresa_id = '$eid' AND id IN ( SELECT MAX(id) FROM otros as o2 WHERE empresa_id = '$eid' GROUP BY o2.nombre )");

      foreach ($results as $result) {
       
        $otros[]=array (
          'id' => $result["id"],
          'eid' => $result["empresa_id"],
          'nom' => $result["nombre"],
          'val' => $result["valor"],
          'cat' => strtotime($result["created_at"]),
          'uat' => strtotime($result["updated_at"]),
          'cby' => $result["created_by"],
          'uby' => $result["updated_by"]   
        );
      } 

 // forma_pago //
  $formasp=array();
  if($fecha2){
  if($tipo=="createdat") {
   
    $results2 = $q->execute("SELECT * FROM forma_pago WHERE created_at>'$fecha2'");

    foreach ($results2 as $result2) {
     
      $formasp[]=array (
        'id' => $result2["id"],
        'mon' => $result2["moneda"],
        'nom' => $result2["nombre"],
        'acr' => $result2["acronimo"],
        'act' => $result2["activo"],
        'des' => $result2["descripcion"],
        'cat' => strtotime($result2["created_at"]),
        'uat' => strtotime($result2["updated_at"]),
        'cby' => $resul2["created_by"],
        'uby' => $result2["updated_by"]    
      );
    }
  } else if($tipo=="updatedat") {
    $formasp=array();
    $results2 = $q->execute("SELECT * FROM forma_pago WHERE updated_at>'$fecha2'");

    foreach ($results2 as $result2) {
     
      $formasp[]=array (
        'id' => $result2["id"],
        'mon' => $result2["moneda"],
        'nom' => $result2["nombre"],
        'acr' => $result2["acronimo"],
        'act' => $result2["activo"],
        'des' => $result2["descripcion"],
        'uat' => strtotime($result2["updated_at"]),
        'uby' => $result2["updated_by"]    
      );
    }
  }  
  }
// oferta //
$ofertas=array();
if($fecha3){
  if($tipo=="createdat") {
   
     $results3 = $q->execute("SELECT * FROM oferta WHERE empresa_id=$eid && created_at>'$fechaof'");

    foreach ($results3 as $result3) {
      $oid=$result3["id"];
       $ofertasDetalle = $q->execute("SELECT * FROM oferta_det WHERE oferta_id = $oid");
       $detalles = array();
      foreach ($ofertasDetalle as $detalle) {
        $detalles[] =  array ( 'oid' => $detalle["oferta_id"],
                               'iid' => $detalle["inventario_id"] );  
      }     
     
      $ofertas[]=array (
        'id' => $result3["id"],
        'nom' => $result3["nombre"],
        'fe' => $result3["fecha"],
        'fev' => $result3["fecha_venc"],
        'eid' => $result3["empresa_id"],
        'did' => $result3["deposito_id"],
        'nc' => $result3["ncontrol"],
        'tof' => $result3["tipo_oferta"],
        'act' => $result3["activo"],
        'pusd' => $result3["precio_usd"],
        'qty' => $result3["qty"],
        'ex' => $result3["exento"],
        'tasa' => $result3["tasa"],
        'urli' => $result3["url_imagen"],
        'urlid' => $result3["url_imagen_desc"],
        'des' => $result3["descripcion"],
        'cat' => strtotime($result3["created_at"]),
        'uat' => strtotime($result3["updated_at"]),
        'cby' => $result3["created_by"],
        'uby' => $result3["updated_by"],
        'dets' =>$detalles  
      );
    }
  } 
  else if($tipo=="updatedat") {
   
    $results3 = $q->execute("SELECT * FROM oferta WHERE empresa_id = '$eid' AND  updated_at>'$fecha3'");

    foreach ($results3 as $result3) {
     
      $ofertas[]=array (
        'id' => $result3["id"],
        'fev' => $result3["fecha_venc"],
        'act' => $result3["activo"],
        'uat' => strtotime($result3["updated_at"]),
        'uby' => $result3["updated_by"]   
      );
    }
  }  
 }


 $otData = array();
  $otData[]=array (
    'otro' => $otros,
    'formap' => $formasp,
    'oferta' => $ofertas  
  );

$q->close();
echo json_encode($otData, JSON_PRETTY_PRINT);
?>