<?php use_helper('I18N', 'Date') ?>
<?php include_partial('orden_compra/assets') ?>
<div class="main-page-wrapper">
  <?php if (!empty($sf_params->get('success'))): ?>
    <script>
      alert("Su orden de compra ha sido guardada con exito");
    </script>
  <?php endif; ?>
  <div class="page-title page-title-default title-size-default title-design-centered color-scheme-light" style="#background-color: #4c2d95">
		<div class="container">
			<header class="entry-header">
				<h1 class="entry-title">ORDENES DE COMPRA</h1>
				<div class="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
					<a href="<?php echo url_for("@inicio"); ?>" rel="v:url" property="v:title">Inicio</a> » 
					<span class="current">Ordenes de compra</span>
				</div>
			</header>
		</div>
	</div>
  <div class="container">
    <div class="row content-layout-wrapper align-items-start" style="margin-top: 1rem">
      <div class="site-content shop-content-area col-lg-12 col-12 col-md-12 description-area-before content-with-products" role="main">
        <div class="woocommerce-notices-wrapper"></div>
        <div class="shop-loop-head" style="display: block">
          <div class="woodmart-shop-tools">
            <div class="woodmart-products-per-page" style="width: 100%; border-bottom: 1px solid #000;">             
              <?php include_partial('orden_compra/pagination', array('pager' => $pager)) ?>
            </div>
          </div>
        </div>
        <div class="woodmart-active-filters"></div>
        <div class="woodmart-shop-loader hidden-loader hidden-from-top" style="margin-left: 138px;"></div>
        <div class="products elements-grid align-items-start woodmart-products-holder woodmart-spacing-20 pagination-pagination row grid-columns-3">
          <?php include_partial('orden_compra/list_header', array('pager' => $pager)) ?>
          <?php include_partial('orden_compra/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
          <?php include_partial('orden_compra/list_footer', array('pager' => $pager)) ?>
        </div>
      </div>
    </div>
  </div>
</div>
<style>
	#ver_detalles:hover {
		background-color: #0a9073 !important;
	}
</style>