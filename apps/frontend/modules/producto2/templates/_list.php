<?php if (!$pager->getNbResults()): ?>
	<div class="row">
		<div class=" col-xs-12 col-md-12 col-lg-12">
			<p><?php echo __('No se encontraron resultados', array(), 'sf_admin') ?></p>
		</div>
	</div>
<?php else: ?>
	<?php include_partial('producto/list_th_tabular', array('sort' => $sort)) ?>
	<div class="row">
			<?php foreach ($pager->getResults() as $i => $producto): $odd = fmod(++$i, 2) ? 'odd' : 'even' ?>
				<?php include_partial('producto/list_td_tabular', array('producto' => $producto)) ?>
			<?php endforeach; ?>
	</div>

	<?php if ($pager->haveToPaginate()): ?>
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12 m-t-40">
	      <div class="text-center">
					<?php include_partial('producto/pagination', array('pager' => $pager)) ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
<?php endif; ?>
