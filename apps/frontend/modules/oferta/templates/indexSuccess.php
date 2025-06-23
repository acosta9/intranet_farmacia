<?php use_helper('I18N', 'Date') ?>
<?php include_partial('oferta/assets') ?>

<div class="container">
  <div class="row content-layout-wrapper align-items-start" style="margin-top: 5rem">
    <aside class="sidebar-container col-lg-3 col-md-3 col-12 order-last order-md-first sidebar-left area-sidebar-shop" role="complementary">
      <div class="sidebar-inner woodmart-sidebar-scroll">
        <div class="widget-area woodmart-sidebar-content">
          <?php include_partial('oferta/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
        </div>
      </div>
    </aside>
    <div class="site-content shop-content-area col-lg-9 col-12 col-md-9 description-area-before content-with-products" role="main">
      <div class="woocommerce-notices-wrapper"></div>
      <div class="shop-loop-head">
        <div class="woodmart-woo-breadcrumbs">
          <nav class="woocommerce-breadcrumb">
            <a href="<?php echo url_for("@inicio") ?>" class="breadcrumb-link ">Inicio</a>
            <span class="breadcrumb-last">Ofertas</span>
          </nav>
        </div>
        <div class="woodmart-shop-tools">
          <div class="woodmart-products-per-page">
            <?php if ($pager->haveToPaginate()): ?>
                <?php include_partial('oferta/pagination', array('pager' => $pager)) ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <div class="woodmart-active-filters"></div>
      <div class="woodmart-shop-loader hidden-loader hidden-from-top" style="margin-left: 138px;"></div>
      <div class="products elements-grid align-items-start woodmart-products-holder woodmart-spacing-20 pagination-pagination row grid-columns-3">
        <?php include_partial('oferta/list_header', array('pager' => $pager)) ?>
        <?php include_partial('oferta/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
        <?php include_partial('oferta/list_footer', array('pager' => $pager)) ?>
      </div>
    </div>
  </div>
</div>