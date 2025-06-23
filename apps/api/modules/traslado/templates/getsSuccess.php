<?php
  $eid = $sf_params->get('eid');
  $tipo = $sf_params->get('tipo');
  $fecha1 = date("Y-m-d H:i:s", $sf_params->get('fecha1')); 
 
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();

  // traslado //
  if($tipo=="createdat") {
    $traslado=array();
    $results = $q->execute("SELECT * FROM traslado WHERE empresa_hasta = $eid AND created_at = updated_at AND created_at>'$fecha1'");

    foreach ($results as $result) {
       $tid=$result["id"];
       $trasDetalle = $q->execute("SELECT * FROM traslado_det WHERE traslado_id = $tid");
       $detalles = array();
      foreach ($trasDetalle as $detalle) {
        $detalles[] =  array ( 'tid' => $detalle["traslado_id"],
                               'pid' => $detalle["producto_id"],
                               'iid' => $detalle["inventario_id"],
                               'qty' => $detalle["qty"],
                               'pdid' => $detalle["prod_destino_id"],
                               'idid' => $detalle["inv_destino_id"],
                               'qtyd' => $detalle["qty_dest"],
                               'punit' => $detalle["price_unit"],
                               'ptot' => $detalle["price_tot"],
                               'des' => $detalle["descripcion"] ); 
      }     
   
      $traslado[]=array (
        'id' => $result["id"],
        'nctr' => $result["ncontrol"],
        'eidd' => $result["empresa_desde"],
        'didd' => $result["deposito_desde"],
        'eidh' => $result["empresa_hasta"],
        'didh' => $result["deposito_hasta"],
        'est' => $result["estatus"],
        'tas' => $result["tasa_cambio"],
        'mon' => $result["monto"],
        'cat' => strtotime($result["created_at"]),
        'uat' => strtotime($result["updated_at"]),
        'cby' => $result["created_by"],
        'uby' => $result["updated_by"],
        'dets' =>$detalles
      );
    }
  }
   else if($tipo=="updatedat") {
    $traslado=array();
    $results = $q->execute("SELECT * FROM traslado WHERE empresa_hasta=$eid && updated_at>'$fecha1'");

    foreach ($results as $result) {
     
      $traslado[]=array (
        'id' => $result["id"],
        'est' => $result["estatus"],
        'uat' => strtotime($result["updated_at"]),
        'uby' => $result["updated_by"]   
      );
    }
  }

$q->close();
echo json_encode($traslado);
?>