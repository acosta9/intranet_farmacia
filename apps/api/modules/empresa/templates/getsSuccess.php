<?php
// empresa//
  $eid = $sf_params->get('eid');
  $fecha = date("Y-m-d H:i:s", $sf_params->get('fecha'));

 $q = Doctrine_Manager::getInstance()->getCurrentConnection(); 
    $results = $q->execute("SELECT * FROM empresa WHERE id=$eid && updated_at>'$fecha'");

    $newData=array();
      foreach ($results as $result) {
  
      $newData[]=array (
        'id' => $result["id"],
        'nom' => $result["nombre"],
        'acr' => $result["acronimo"],
        'rif' => $result["rif"],
        'corpt' => $result["cod_coorpotulipa"],
        'dir' => $result["direccion"],
        'tlf' => $result["telefono"],
        'email' => $result["email"],
        'tipo' => $result["tipo"],
        'iva' => $result["iva"],
        'tasa' => $result["tasa"],
        'fvrc' => $result["venc_registro_comercio"],
        'fvrif' => $result["venc_rif"],
        'fvb' => $result["venc_bomberos"],
        'fvl' => $result["venc_lic_funcionamiento"],
        'fvuc' => $result["venc_uso_conforme"],
        'fvps' => $result["venc_permiso_sanitario"],
        'fvpi' => $result["venc_permiso_instalacion"],
        'fvda' => $result["venc_destinado_afines"],
        'fvdab' => $result["venc_destinado_abastos"],
        'des' => $result["descripcion"],
        'uat' => strtotime($result["updated_at"]),
        'uby' => $result["updated_by"]
      );
    }

  echo json_encode($newData, JSON_PRETTY_PRINT);