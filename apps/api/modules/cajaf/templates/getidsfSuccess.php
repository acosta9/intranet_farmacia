<?php
  $eid = $sf_params->get('eid');
 // $tipo = $sf_params->get('tipo');
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
// caja_arqueo //
 $results = $q->execute("SELECT id as idar FROM caja_arqueo WHERE id LIKE '$eid%'  ORDER BY id DESC LIMIT 1");
 foreach ($results as $result) {
    $idar=$result["idar"];
 }

// caja_corte //
  $results2 = $q->execute("SELECT id as idcr FROM caja_corte WHERE id  LIKE '$eid%'  ORDER BY id DESC LIMIT 1");
 foreach ($results2 as $result2) {
    $idcr=$result2["idcr"];
 }

// caja_det //
   $results3 = $q->execute("SELECT id as iddt FROM caja_det WHERE id LIKE '$eid%'  ORDER BY id DESC LIMIT 1");
 foreach ($results3 as $result3) {
    $iddt=$result3["iddt"];
 }

 // caja_efectivo //
   $results4 = $q->execute("SELECT id as idef FROM caja_efectivo WHERE id LIKE '$eid%'  ORDER BY id DESC LIMIT 1");
 foreach ($results4 as $result4) {
    $idef=$result4["idef"];
 }

  $data = array();
  $data1 = array();

  $data1['idar'] = $idar;
  $data1['idcr'] = $idcr;
  $data1['iddt'] = $iddt;
  $data1['idef'] = $idef;

  $data[] = $data1;
  
  echo json_encode($data, JSON_PRETTY_PRINT);
?>