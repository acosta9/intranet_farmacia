<?php use_helper('jQuery') ?>
<?php
if($sf_params->get('d')!='0') {
    $results = Doctrine_Query::create()
      ->select('c.*')
      ->from('Ciudad c')
			->where('c.estado_id = ?', $sf_params->get('d'))
			->orderBy('c.nombre ASC')
      ->execute();

    echo '<option value="0">Selecciona Uno...</option>';
    foreach ($results as $result) {
			echo '<option value="'.$result->getId().'">'.$result->getNombre().'</option>';
		}

} else {
    echo "";
}
?>
