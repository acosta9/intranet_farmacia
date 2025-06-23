<?php if (!$pager->getNbResults()): ?>
	<div class="row">
		<div class=" col-xs-12 col-md-12 col-lg-12">
			<p><?php echo __('No se encontraron resultados', array(), 'sf_admin') ?></p>
		</div>
	</div>
<?php else: ?>
	<?php include_partial('oferta/list_th_tabular', array('sort' => $sort)) ?>
	<?php foreach ($pager->getResults() as $i => $oferta): $odd = fmod(++$i, 2) ? 'odd' : 'even' ?>
		<?php include_partial('oferta/list_td_tabular', array('oferta' => $oferta)) ?>
	<?php endforeach; ?>
<?php endif; ?>
