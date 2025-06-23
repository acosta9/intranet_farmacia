<?php

 $tipo = $sf_params->get('tipo');
 $q = Doctrine_Manager::getInstance()->getCurrentConnection();
// compuesto //
 if($tipo=="createdat") {
    $results = $q->execute("SELECT created_at as fecha FROM compuesto WHERE updated_at=created_at ORDER BY created_at DESC LIMIT 1");
 } else if($tipo=="updatedat") {
    $results = $q->execute("SELECT updated_at as fecha FROM compuesto WHERE updated_at<>created_at ORDER BY updated_at DESC LIMIT 1");
 }
 foreach ($results as $result) {
    $fecha1=strtotime($result["fecha"]);
 }

 // prod_compuesto // Busco la fecha de modificacion del producto
 if($tipo=="createdat") {
    $results2 = $q->execute("SELECT created_at as fecha FROM producto WHERE updated_at=created_at ORDER BY created_at DESC LIMIT 1");
 } else if($tipo=="updatedat") {
    $results2 = $q->execute("SELECT updated_at as fecha FROM producto WHERE updated_at<>created_at ORDER BY updated_at DESC LIMIT 1");
 }
 foreach ($results2 as $result2) {
    $fecha2=strtotime($result2["fecha"]);
 }

 $data = array();
 $data1 = array();

 $data1['fecha1'] = $fecha1;
 $data1['fecha2'] = $fecha2;

 $data[] = $data1;

 echo json_encode($data, JSON_PRETTY_PRINT);
?>