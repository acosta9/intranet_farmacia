<?php
// recibo_pago, prod_vendidos //
  $eid = $sf_params->get('eid');
  $tipo = $sf_params->get('tipo');
  $fecha1 = date("Y-m-d H:i:s", $sf_params->get('fecha1')); 
  $fecha2 = date("Y-m-d H:i:s", $sf_params->get('fecha2'));
  

  $q = Doctrine_Manager::getInstance()->getCurrentConnection();

 // recibo_pago //
  if($tipo=="createdat") {
    $recibos=array();
      $results = $q->execute("SELECT * FROM recibo_pago WHERE empresa_id = '$eid' AND created_at >= '$fecha1' ORDER BY created_at ASC LIMIT 100");

     foreach ($results as $result) {
     
      $recibos[]=array (
        'id' => $result["id"],
        'eid' => $result["empresa_id"],
        'cid' => $result["cliente_id"],
        'ccid' => $result["cuentas_cobrar_id"],
        'nc' => $result["ncontrol"],
        'mone' => $result["moneda"],
        'fp' => $result["forma_pago_id"],
        'numr' => $result["num_recibo"],
        'fe' => $result["fecha"],
        'mon' => $result["monto"],
        'mon2' => $result["monto2"],
        'quien' => $result["quien_paga"],
        'urli' => $result["url_imagen"],
        'tasa' => $result["tasa_cambio"],
        'des' => $result["descripcion"],
        'anu' => $result["anulado"],
        'cat' => strtotime($result["created_at"]),
        'uat' => strtotime($result["updated_at"]),
        'cby' => $result["created_by"],
        'uby' => $result["updated_by"]   
      );
    }
  } else if($tipo=="updatedat") {
    $recibos=array();
      $results = $q->execute("SELECT * FROM recibo_pago WHERE empresa_id = '$eid' AND updated_at >= '$fecha1' LIMIT 100");

     foreach ($results as $result) {
     
      $recibos[]=array (
        'id' => $result["id"],
        'anu' => $result["anulado"],
        'uat' => strtotime($result["updated_at"]),
        'uby' => $result["updated_by"]   
      );
    }
  }
  
 // prod_vendidos //
  if($tipo=="createdat") {
   $pvendidos=array();
    $results2 = $q->execute("SELECT * FROM prod_vendidos WHERE empresa_id = '$eid' AND fecha >= '$fecha2' ORDER BY fecha ASC LIMIT 200");

    foreach ($results2 as $result2) {
     
      $pvendidos[]=array (
        'id' => $result2["id"],
        'eid' => $result2["empresa_id"],
        'did' => $result2["deposito_id"],
        'pid' => $result2["producto_id"],
        'cid' => $result2["cliente_id"],
        'uid' => $result2["user_id"],
        'punit' => $result2["price_unit"],
        'ptot' => $result2["price_tot"],
        'tabla' => $result2["tabla"],
        'tid' => $result2["tabla_id"],
        'fe' => $result2["fecha"],
        'cant' => $result2["cantidad"],
        'of' => $result2["oferta"],
        'anu' => $result2["anulado"]
       );
    }
  }else if($tipo=="updatedat") {
    $pvendidos=array();
    $NuevaFecha = strtotime ( '-5 days' , strtotime ($fecha2) ) ;
    $nfecha =date("Y-m-d H:i:s", $NuevaFecha);

    $results2 = $q->execute("SELECT prod_vendidos.id FROM prod_vendidos INNER JOIN factura ON prod_vendidos.tabla_id = factura.id WHERE prod_vendidos.tabla = 'factura' AND factura.estatus = '4' AND factura.created_at >= '$nfecha' AND prod_vendidos.empresa_id = '$eid'");

    foreach ($results2 as $result2) {
     
      $pvendidos[]=array (
        'id' => $result2["id"]
      );
    }
  }
 $recData = array();
  $recData[]=array (
    'recibo' => $recibos,
    'pvendido' => $pvendidos
  );

$q->close();
echo json_encode($recData, JSON_PRETTY_PRINT);
?>