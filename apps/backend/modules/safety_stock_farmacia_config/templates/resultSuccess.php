<?php

$id=$sf_params->get('id');
$id_user = $sf_user->getGuardUser()->getId();
$empresa_id=$sf_params->get('empresa_id');
$tiempo_entrega=$sf_params->get('tiempo_entrega');
$dias_analisis=$sf_params->get('dias_analisis');
$nivel_servicio_id=$sf_params->get('nivel_servicio_id');
$dias_calculo=$sf_params->get('dias_calculo');
$correos_notificacion=$sf_params->get('correos_notificacion');

$fecha = date("Y-m-d H:i:s");

$q = Doctrine_Manager::getInstance()->getCurrentConnection();
if(empty($id)){
  $q->execute("BEGIN; INSERT INTO safety_stock_farmacia_config (empresa_id, tiempo_entrega, dias_analisis, nivel_servicio_id, dias_calculo, correos_notificacion,created_at,updated_at,created_by,updated_by) VALUES " .
    "($empresa_id, $tiempo_entrega, $dias_analisis,$nivel_servicio_id,$dias_calculo,'$correos_notificacion', '$fecha', '$fecha', $id_user, $id_user) ; COMMIT;");
}else{
  $q->execute("BEGIN; UPDATE safety_stock_farmacia_config SET
    empresa_id = $empresa_id, tiempo_entrega = $tiempo_entrega, dias_analisis = $dias_analisis, nivel_servicio_id = $nivel_servicio_id,
    dias_calculo = '$dias_calculo',correos_notificacion = '$correos_notificacion', updated_at = '$fecha', updated_by =  $id_user WHERE id = $id; COMMIT;");
}

$q->close();

?>
<div id="alert" class="alert alert-success alert-dismissable" style="margin: 0px 0px 15px 0px;">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <h4><i class="icon fa fa-check"></i> Alerta!</h4>
  <?php echo empty($id) ? 'Datos guardados con exito!':'Datos editados con exito!'  ?>
</div>
<script>
  $(document).ready(function(){
    $('#loading').fadeOut( "slow", function() {});
  });
</script>