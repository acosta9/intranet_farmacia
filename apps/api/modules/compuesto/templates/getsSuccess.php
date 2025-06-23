<?php
  $tipo = $sf_params->get('tipo');
  $fecha1 = date("Y-m-d H:i:s", $sf_params->get('fecha1'));
  $fecha2 = date("Y-m-d H:i:s", $sf_params->get('fecha2'));
 

  $q = Doctrine_Manager::getInstance()->getCurrentConnection();

 // compuesto //
  if($tipo=="createdat") {
    $compuestos=array();
      $results = $q->execute("SELECT * FROM compuesto WHERE created_at>='$fecha1'");

      foreach ($results as $result) {
       
        $compuestos[]=array (
          'id' => $result["id"],
          'nom' => $result["nombre"],
          'des' => $result["descripcion"],
          'cat' => strtotime($result["created_at"]),
          'uat' => strtotime($result["updated_at"]),
          'cby' => $result["created_by"],
          'uby' => $result["updated_by"]   
        );
      }
  } else if($tipo=="updatedat") {
    $compuestos=array();
      $results = $q->execute("SELECT * FROM compuesto WHERE updated_at>='$fecha1'");

      foreach ($results as $result) {
       
        $compuestos[]=array (
          'id' => $result["id"],
          'nom' => $result["nombre"],
          'des' => $result["descripcion"],
          'uat' => strtotime($result["updated_at"]),
          'uby' => $result["updated_by"]   
        );
      }
  }
  
// prod_compuesto //
  if($tipo=="createdat") {
   $prodcps=array();
    $results2 = $q->execute("SELECT prod_compuesto.producto_id, prod_compuesto.compuesto_id FROM producto INNER JOIN prod_compuesto ON producto.id = prod_compuesto.producto_id WHERE producto.created_at>='$fecha2' ");

    foreach ($results2 as $result2) {
     
      $prodcps[]=array (
        'pid' => $result2["producto_id"],
        'cid' => $result2["compuesto_id"]   
      );
    }
  } else if($tipo=="updatedat") {
     $prodcps=array();
    $results2 = $q->execute("SELECT prod_compuesto.producto_id, prod_compuesto.compuesto_id FROM producto INNER JOIN prod_compuesto ON producto.id = prod_compuesto.producto_id WHERE producto.updated_at<>producto.created_at && producto.updated_at>='$fecha2' ");

    foreach ($results2 as $result2) {
     
      $prodcps[]=array (
        'pid' => $result2["producto_id"],
        'cid' => $result2["compuesto_id"]   
      );
    }
  }  
 
$compData = array();
  $compData[]=array (
    'compuesto' => $compuestos,
    'prodcp' => $prodcps
  );
$q->close();
echo json_encode($compData, JSON_PRETTY_PRINT);
?>