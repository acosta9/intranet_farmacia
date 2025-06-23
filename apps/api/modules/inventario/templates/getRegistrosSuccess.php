<?php
  $eid = $sf_params->get('eid');
  $tipo = $sf_params->get('tipo');
  $fecha = date("Y-m-d H:i:s", $sf_params->get('fecha'));

  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  if($tipo=="get_qty") {
    $results = $q->execute("SELECT id, cantidad FROM inventario WHERE empresa_id=$eid ORDER BY id ASC");
  } else if($tipo=="get_act_lim") {
    $results = $q->execute("SELECT id, limite_stock, activo FROM inventario WHERE empresa_id=$eid ORDER BY id ASC");
  } else if($tipo=="get_new_recs") {
    $results = $q->execute("SELECT * FROM inventario WHERE empresa_id=$eid && created_at>'$fecha' ORDER BY id ASC");
  }

  $newData=array();
  foreach ($results as $result) {
    if($tipo=="get_qty") {
      $newData[]=array (
        'i' => $result["id"],
        'c' => $result["cantidad"]
      );
    }else if($tipo=="get_act_lim") {
      $newData[]=array (
        'i' => $result["id"],
        'a' => $result["activo"],
        'l' => $result["limite_stock"],
      );
    } else if($tipo=="get_new_recs") {
      $newData[]=array (
        'id' => $result["id"],
        'did' => $result["deposito_id"],
        'eid' => $result["empresa_id"],
        'pid' => $result["producto_id"],
        'qty' => $result["cantidad"],
        'act' => $result["activo"],
        'lstock' => $result["limite_stock"],
        'cat' => strtotime($result["created_at"]),
        'cby' => $result["created_by"],
      );
    }
  }

  echo json_encode($newData);
?>