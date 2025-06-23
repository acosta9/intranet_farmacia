<?php
$moneda=$sf_params->get('id');
$forma_pago_id=$sf_params->get('fid');

$results = Doctrine_Query::create()
  ->select('fp.*')
  ->from('FormaPago fp')
  ->where('fp.moneda = ?', $moneda)
  ->orderBy('fp.nombre ASC')
  ->execute();
?>
<option value="">Seleccione una opcion</option>
<?php
foreach ($results as $result) {
    $pid="";
    if($sf_params->get('fid')) { $pid=$sf_params->get('fid'); }

    if (strcmp($pid,str_replace(' ','',$result->getId()))==0) { ?>
      <option selected="selected" value="<?php echo $result->getId() ?>"><?php echo $result->getNombre() ?></option>
    <?php }else { ?>
      <option value="<?php echo $result->getId() ?>"><?php echo $result->getNombre() ?></option>
    <?php }
}
