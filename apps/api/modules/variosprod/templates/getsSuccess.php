<?php
  $tipo = $sf_params->get('tipo');
  $fecha1 = date("Y-m-d H:i:s", $sf_params->get('fecha1'));
  $fecha2 = date("Y-m-d H:i:s", $sf_params->get('fecha2'));
  $fecha3 = date("Y-m-d H:i:s", $sf_params->get('fecha3'));

  $q = Doctrine_Manager::getInstance()->getCurrentConnection();

// prod_unidad //
  if($tipo=="createdat") {
    $produs=array();
    $results = $q->execute("SELECT * FROM prod_unidad WHERE created_at>'$fecha1'");

      foreach ($results as $result) {
       
        $produs[]=array (
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
     $produs=array();
    $results = $q->execute("SELECT * FROM prod_unidad WHERE updated_at>'$fecha1'");

      foreach ($results as $result) {
       
        $produs[]=array (
          'id' => $result["id"],
          'nom' => $result["nombre"],
          'des' => $result["descripcion"],
          'uat' => strtotime($result["updated_at"]),
          'uby' => $result["updated_by"]   
        );
      }
  }
  
// prod_laboratorio //
  if($tipo=="createdat") {
    $prodls=array();
      $results2 = $q->execute("SELECT * FROM prod_laboratorio WHERE created_at>'$fecha2'");

      foreach ($results2 as $result2) {
       
        $prodls[]=array (
          'id' => $result2["id"],
          'nom' => $result2["nombre"],
          'des' => $result2["descripcion"],
          'cat' => strtotime($result2["created_at"]),
          'uat' => strtotime($result2["updated_at"]),
          'cby' => $result2["created_by"],
          'uby' => $result2["updated_by"]     
        );
      }
  } else if($tipo=="updatedat") {
    $prodls=array();
      $results2 = $q->execute("SELECT * FROM prod_laboratorio WHERE updated_at>'$fecha2'");

      foreach ($results2 as $result2) {
       
        $prodls[]=array (
          'id' => $result2["id"],
          'nom' => $result2["nombre"],
          'des' => $result2["descripcion"],
          'uat' => strtotime($result2["updated_at"]),
          'uby' => $result2["updated_by"]     
        );
      }
  }  
  
// prod_categoria //
  if($tipo=="createdat") {
    $prodcs=array();
      $results3 = $q->execute("SELECT * FROM prod_categoria WHERE created_at>'$fecha3'");

      foreach ($results3 as $result3) {
       
        $prodcs[]=array (
          'id' => $result3["id"],
          'cod' => $result3["codigo"],
          'codf' => $result3["codigo_full"],
          'nom' => $result3["nombre"],
          'des' => $result3["descripcion"],
          'urli' => $result3["url_imagen"],
          'cat' => strtotime($result3["created_at"]),
          'uat' => strtotime($result3["updated_at"]),
          'cby' => $result3["created_by"],
          'uby' => $result3["updated_by"]     
        );
      }
  } else if($tipo=="updatedat") {
    $prodcs=array();
      $results3 = $q->execute("SELECT * FROM prod_categoria WHERE updated_at>'$fecha3'");

      foreach ($results3 as $result3) {
       
        $prodcs[]=array (
          'id' => $result3["id"],
          'cod' => $result3["codigo"],
          'codf' => $result3["codigo_full"],
          'nom' => $result3["nombre"],
          'des' => $result3["descripcion"],
          'urli' => $result3["url_imagen"],
          'uat' => strtotime($result3["updated_at"]),
          'uby' => $result3["updated_by"]     
        );
      }
  }  
 
$vpData = array();
  $vpData[]=array (
    'produ' => $produs,
    'prodl' => $prodls,
    'prodc' => $prodcs
  );
$q->close();
echo json_encode($vpData, JSON_PRETTY_PRINT);
?>