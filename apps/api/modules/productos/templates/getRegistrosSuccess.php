<?php
  $eid = $sf_params->get('eid');
  $tipo = $sf_params->get('tipo');
  $fecha = date("Y-m-d H:i:s", $sf_params->get('fecha'));

  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  if($tipo=="get_update") {
    $results = $q->execute("SELECT * FROM producto WHERE updated_at>='$fecha' ORDER BY id ASC");
  } else if($tipo=="get_new_recs") {
    $results = $q->execute("SELECT * FROM producto WHERE created_at>'$fecha' ORDER BY id ASC");
  }

  $newData=array();
  foreach ($results as $result) {
    if($tipo=="get_update") {
      $newData[]=array (
        'id' => $result["id"],
        'nombre' => "'".str_replace(['"',"'"], "",$result["nombre"])."'",
        'serial' => $result["serial"],
        'serial2' => $result["serial2"],
        'serial3' => $result["serial3"],
        'serial4' => $result["serial4"],
        'tasa' => $result["tasa"],
        'serial_bulto1' => $result["serial_bulto1"],
        'cantidad_bulto1' => $result["cantidad_bulto1"],
        'serial_bulto2' => $result["serial_bulto2"],
        'cantidad_bulto2' => $result["cantidad_bulto2"],
        'codigo' => $result["codigo"],
        'laboratorio_id' => $result["laboratorio_id"],
        'categoria_id' => $result["categoria_id"],
        'unidad_id' => $result["unidad_id"],
        'subproducto_id' => $result["subproducto_id"],
        'qty_desglozado' => $result["qty_desglozado"],
        'tipo' => $result["tipo"],
        'activo' => $result["activo"],
        'costo_usd_1' => $result["costo_usd_1"],
        'util_usd_1' => $result["util_usd_1"],
        'util_usd_2' => $result["util_usd_2"],
        'util_usd_3' => $result["util_usd_3"],
        'util_usd_4' => $result["util_usd_4"],
        'util_usd_5' => $result["util_usd_5"],
        'util_usd_6' => $result["util_usd_6"],
        'util_usd_7' => $result["util_usd_7"],
        'util_usd_8' => $result["util_usd_8"],
        'precio_usd_1' => $result["precio_usd_1"],
        'precio_usd_2' => $result["precio_usd_2"],
        'precio_usd_3' => $result["precio_usd_3"],
        'precio_usd_4' => $result["precio_usd_4"],
        'precio_usd_5' => $result["precio_usd_5"],
        'precio_usd_6' => $result["precio_usd_6"],
        'precio_usd_7' => $result["precio_usd_7"],
        'precio_usd_8' => $result["precio_usd_8"],
        'exento' => $result["exento"],
        'destacado' => $result["destacado"],
        'tags' => $result["tags"],
        'url_imagen' => $result["url_imagen"],
        'url_imagen_desc' => $result["url_imagen_desc"],
        'descripcion' => $result["descripcion"],
        'mas_detalles' => $result["mas_detalles"],
        'uat' => strtotime($result["updated_at"]),
        'uby' => $result["updated_by"],
      );
    } else if($tipo=="get_new_recs") {
      $newData[]=array (
        'id' => $result["id"],
        'nombre' => "'".str_replace(['"',"'"], "",$result["nombre"])."'",
        'serial' => $result["serial"],
        'serial2' => $result["serial2"],
        'serial3' => $result["serial3"],
        'serial4' => $result["serial4"],
        'tasa' => $result["tasa"],
        'serial_bulto1' => $result["serial_bulto1"],
        'cantidad_bulto1' => $result["cantidad_bulto1"],
        'serial_bulto2' => $result["serial_bulto2"],
        'cantidad_bulto2' => $result["cantidad_bulto2"],
        'codigo' => $result["codigo"],
        'laboratorio_id' => $result["laboratorio_id"],
        'categoria_id' => $result["categoria_id"],
        'unidad_id' => $result["unidad_id"],
        'subproducto_id' => $result["subproducto_id"],
        'qty_desglozado' => $result["qty_desglozado"],
        'tipo' => $result["tipo"],
        'activo' => $result["activo"],
        'costo_usd_1' => $result["costo_usd_1"],
        'util_usd_1' => $result["util_usd_1"],
        'util_usd_2' => $result["util_usd_2"],
        'util_usd_3' => $result["util_usd_3"],
        'util_usd_4' => $result["util_usd_4"],
        'util_usd_5' => $result["util_usd_5"],
        'util_usd_6' => $result["util_usd_6"],
        'util_usd_7' => $result["util_usd_7"],
        'util_usd_8' => $result["util_usd_8"],
        'precio_usd_1' => $result["precio_usd_1"],
        'precio_usd_2' => $result["precio_usd_2"],
        'precio_usd_3' => $result["precio_usd_3"],
        'precio_usd_4' => $result["precio_usd_4"],
        'precio_usd_5' => $result["precio_usd_5"],
        'precio_usd_6' => $result["precio_usd_6"],
        'precio_usd_7' => $result["precio_usd_7"],
        'precio_usd_8' => $result["precio_usd_8"],
        'exento' => $result["exento"],
        'destacado' => $result["destacado"],
        'tags' => $result["tags"],
        'url_imagen' => $result["url_imagen"],
        'url_imagen_desc' => $result["url_imagen_desc"],
        'descripcion' => $result["descripcion"],
        'mas_detalles' => $result["mas_detalles"],
        'cat' => strtotime($result["created_at"]),
        'cby' => $result["created_by"],
      );
    }
  }

  echo json_encode($newData);
?>