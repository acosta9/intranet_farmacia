<?php use_helper('I18N', 'Date') ?>
<?php include_partial('producto/assets') ?>


<div class="section two p-t-105">
  <div class="container p-b-60 ">
    <div class="row title-filtro">
      <div class="title p-b-40 text-center">
          <h3 class="bold">RESULTADO DE BÚSQUEDA</h3>
          <img src="/images/separador.png" class="img-responsive" alt="Image">
          <p class="col-md-6 col-md-offset-3">Se muestra a continuación los resultados.</p>
      </div>
		</div>
		<div class="col-xs-12 col-md-3 col-lg-3 sidebar-left">
			<h3 class="bold filtro">FILTRAR POR:</h3>
			<?php include_partial('producto/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
    </div>
    <div class="col-xs-12 col-md-9 col-lg-9">

			<?php include_partial('producto/list_header', array('pager' => $pager)) ?>
			<?php include_partial('producto/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
			<?php include_partial('producto/list_footer', array('pager' => $pager)) ?>
		</div>
	</div>
</div>

<div class="section four">
  <div class="container">
    <div class="row">
		<?php
			$results = Doctrine_Query::create()
			->select('b.*')
			->from('Banners b')
      ->where('b.posicion = ?', 'producto')
			->orderBy('RAND()')
			->limit(1)
			->execute();
		?>
		<?php foreach($results as $result) { ?>
      <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="banner" style="background: url('/uploads/banners/<?php echo $result->getUrlImagen(); ?>') no-repeat center center; background-size: cover; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover;">
          <div class="col-md-12">
            <h4 class="text-white bold" style="text-align: center; margin: 0px !important; height: 120px; display: table; width: 100%;">
              <span style="vertical-align:middle; display: table-cell;">
                <div class="desc-banner">"<?php echo $result->getNombre(); ?>"</div>
              </span>
            </h4>
            <button type="button" class="btn" onclick="window.location.href='<?php echo $result->getEnlace(); ?>'" style="margin: -77px 0px 0px 0px; !important">VER MÁS</button>
          </div>
        </div>
      </div>
		<?php } ?>
  </div>
  </div>
</div>
