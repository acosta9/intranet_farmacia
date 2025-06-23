<?php
$empresa_id=$sf_params->get('id');
$deposito_id=$sf_params->get('did');


if(strlen($deposito_id)==0) {
    $results = Doctrine_Query::create()
    ->select('id.*')
    ->from('InvDeposito id')
    ->where('id.empresa_id = ?', $empresa_id)
    ->orderBy('id.nombre ASC')
    ->execute();
} else {
    $results = Doctrine_Query::create()
    ->select('id.*')
    ->from('InvDeposito id')
    ->where('id.empresa_id = ?', $empresa_id)
    ->orderBy('id.nombre ASC')
    ->execute();
}
?>
<option value="">Seleccione una opción</option>
  <?php
  foreach ($results as $result) {
    $pid="";
    if($sf_params->get('did')) { $pid=$sf_params->get('did'); }

    if (strcmp($pid,str_replace(' ','',$result->getId()))==0) { ?>
      <option selected="selected" value="<?php echo $result->getId() ?>"><?php echo $result->getNombre() ?></option>
    <?php }else { ?>
      <option value="<?php echo $result->getId() ?>"><?php echo $result->getNombre() ?></option>
    <?php }
  }
