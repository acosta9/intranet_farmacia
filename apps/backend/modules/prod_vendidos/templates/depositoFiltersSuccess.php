<?php
$empresa_id=explode(",",$sf_params->get('id'));
$deposito_id=$sf_params->get('did');

$results = Doctrine_Query::create()
  ->select('d.id as did, d.nombre as dname, e.id as eid, e.nombre as ename, e.acronimo as emin')
  ->from('InvDeposito d, d.Empresa e')
  ->whereIn('d.empresa_id', $empresa_id)
  ->orderBy('e.nombre ASC, d.nombre ASC')
  ->groupBy('d.id')
  ->execute();
?>
<option value="">Seleccione una opcion</option>
  <?php
  foreach ($results as $result) {
    $pid="";
    if($sf_params->get('did')) { $pid=$sf_params->get('did'); }

    if (strcmp($pid,str_replace(' ','',$result->getId()))==0) { ?>
      <option selected="selected" value="<?php echo $result["did"] ?>"><?php echo $result["ename"]." / ".$result["dname"] ?></option>
    <?php }else { ?>
      <option value="<?php echo $result["did"] ?>"><?php echo "[".$result["emin"]."] ".$result["dname"] ?></option>
    <?php }
  }
