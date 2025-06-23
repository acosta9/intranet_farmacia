<?php use_helper('jQuery') ?>
<?php
if($sf_params->get('d')!='0') {
    $results = Doctrine_Query::create()
      ->select('m.*')
      ->from('Municipio m')
			->where('m.ciudad_id = ?', $sf_params->get('d'))
			->orderBy('m.nombre ASC')
      ->execute();

    echo '<option value="0">Selecciona Uno...</option>';
    foreach ($results as $result) {
			echo '<option value="'.$result->getId().'">'.$result->getNombre().'</option>';
		}

} else {
    echo "";
}
?>
