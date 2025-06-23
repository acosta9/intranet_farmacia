<div class="container">
  <div class="row content-layout-wrapper align-items-start">
    <div class="site-content col-lg-12 col-12 col-md-12" role="main">
      <article id="post-1724" class="post-1724 page type-page status-publish hentry">
        <div class="entry-content">
          <div class="vc_row wpb_row vc_row-fluid vc_custom_1533826872352 vc_row-o-content-middle vc_row-flex">
            <div class="wpb_column vc_column_container vc_col-sm-12">
              <div class="vc_column-inner vc_custom_1534490106488">
                <div class="wpb_wrapper">
                  <style>
                    #slider-57 .woodmart-slide {
                      min-height: 600px;
                    }
                    @media (min-width: 1025px) {
                      .browser-Internet #slider-57 .woodmart-slide {
                        height: 600px;
                      }
                    }
                    @media (max-width: 1024px) {
                      #slider-57 .woodmart-slide {
                        min-height: 500px;
                      }
                    }
                    @media (max-width: 767px) {
                      #slider-57 .woodmart-slide {
                        min-height: 640px;
                      }
                    }
                    <?php
                      $slides = Doctrine_Query::create()
                        ->select('g.*')
                        ->from('Galeria g')
                        ->where('g.posicion = ?', 'slider_top')
                        ->orderBy('orden')
                        ->execute();
                        $i=1700;
                      ?>
                      <?php foreach($slides as $slide): ?>
                        <?php echo "#slide-$i"; ?>.woodmart-loaded {
                          background-image:url(<?php echo "/uploads/galeria/".$slide->getUrlImagen(); ?>);
                        }
                        <?php echo "#slide-$i"; ?> {
                          background-color:#353734;
                        }
                        <?php echo "#slide-$i"; ?>.woodmart-slide-inner {
                          max-width:895px;
                        }
                        @media (max-width: 1024px) {
                          <?php echo "#slide-$i"; ?>.woodmart-slide-inner {
                            max-width:645px;
                          }
                        }
                        @media (max-width: 767px) {
                          <?php echo "#slide-$i"; $i++; ?>.woodmart-slide-inner {
                            max-width:300px;
                          }
                        }
                      <?php endforeach; ?>
                  </style>
                  <div id="slider-57" class="woodmart-slider-wrapper arrows-style-1 pagin-style-2 pagin-color-light vc_row vc_row-fluid"
                  data-vc-full-width="true" data-vc-full-width-init="true" data-vc-stretch-content="true"
                  data-owl-carousel data-speed="9000" data-wrap="yes" data-autoheight="yes"
                  data-hide_pagination_control="no" data-hide_prev_next_buttons="no" data-sliding_speed="900"
                  data-content_animation="1" data-desktop="1" data-tablet_landscape="1" data-tablet="1"
                  data-mobile="1">
                    <div class="owl-carousel woodmart-slider  owl-items-lg-1 owl-items-md-1 owl-items-sm-1 owl-items-xs-1">
                      <?php $i=1700; foreach($slides as $slide): ?>
                        <div id="slide-<?php echo $i; $i++;?>" class="woodmart-slide slide-valign-middle slide-halign-center content-fixed">
                          <div class="container woodmart-slide-container">
                            <div class="woodmart-slide-inner slide-animation anim-slide-from-bottom">
                            </div>
                          </div>
                        </div>
                      <?php endforeach; ?>
                    </div>
                  </div>
                  <div class="vc_row-full-width vc_clearfix"></div>
                </div>
              </div>
            </div>
          </div>
          <div data-vc-full-width="true" data-vc-full-width-init="false" class="vc_row wpb_row vc_row-fluid vc_custom_1533819106143 vc_row-has-fill">
            <div class="wpb_column vc_column_container vc_col-sm-12">
              <div class="vc_column-inner vc_custom_1533739411437">
                <div class="wpb_wrapper">
                  <div id="wd-5f55439394a4a" class="title-wrapper  woodmart-title-color-primary woodmart-title-style-underlined woodmart-title-width-100 text-left woodmart-title-size-custom vc_custom_1534493033597">
                    <div class="liner-continer">
                      <span class="left-line"></span>
                      <h4 class="woodmart-title-container title  woodmart-font-weight-600">CATEGORIAS</h4>
                      <span class="right-line"></span>
                    </div>
                  </div>
                  <div id="carousel-119" class="products woocommerce woodmart-carousel-container  categories-style-carousel  woodmart-carousel-spacing-20"
                    data-owl-carousel data-wrap="no" data-hide_pagination_control="yes"
                    data-hide_prev_next_buttons="no" data-desktop="6" data-tablet_landscape="6" data-tablet="3"
                    data-mobile="2">
                    <div class="owl-carousel carousel-items owl-items-lg-3 owl-items-md-3 owl-items-sm-3 owl-items-xs-2">
                      <div class="category-grid-item cat-design-alt product-category product first" data-loop="1">
                        <div class="wrapp-category">
                          <div class="category-image-wrapp">
                            <a href="<?php echo url_for("@oferta"); ?>" class="category-image">
                              <img src="/plugins/wp-content/uploads/2020/09/sales.png" alt="Ofertas" width="300" />
                            </a>
                          </div>
                          <div class="hover-mask">
                            <h3 class="category-title">Ofertas <mark class="count">(1)</mark> </h3>
                            <div class="more-products">
                            <?php
                              $ofers = Doctrine_Query::create()
                                ->select('COUNT(ofer.id) as cont')
                                ->from('Oferta ofer')
                                ->leftJoin('ofer.OfertaDet od')
                                ->leftJoin('od.Inventario i')
                                ->leftJoin('i.Producto p')
                                ->Where('i.deposito_id =111')
                                ->andWhere('i.activo =?', 1)
                                ->andWhere('ofer.activo =?', 1)
                                ->andWhere("ofer.fecha <= '".date("Y-m-d")."' AND ofer.fecha_venc >= '".date("Y-m-d")."' ")
                                ->orderBy('i.cantidad ASC')
                                ->execute();
                                foreach ($ofers as $r) {
                                  echo '<a href="'.url_for("@oferta").'">'.$r["cont"].' producto</a>';
                                }
                              ?>
                            </div>
                          </div>
                          <a href="#" class="category-link"></a>
                        </div>
                      </div>
                      <?php
                        $results = Doctrine_Query::create()
                        ->select('pc.*')
                        ->from('ProdCategoria pc')
                        ->where('pc.codigo_full NOT LIKE "%-%"')
                        ->orderBy('pc.Nombre ASC')
                        ->execute();
                        $k=2;
                      ?>
                      <?php foreach ($results as $result):?>
                        <div class="category-grid-item cat-design-alt product-category product" data-loop="<?php echo $k; $k++; ?>">
                          <div class="wrapp-category">
                            <div class="category-image-wrapp">
                              <a href="<?php echo url_for('producto/index?catname='.$result->getNombre()."&page=1"); ?>" class="category-image">
                                <img src="/uploads/prod_categoria/<?php echo $result->getUrlImagen() ?>" alt="" width="300" />
                              </a>
                            </div>
                            <div class="hover-mask">
                              <h3 class="category-title"><?php echo $result->getNombre() ?></h3>
                              <div class="more-products">
                                <?php
                                  $prods = Doctrine_Query::create()
                                    ->select('COUNT(i.id) as cont')
                                    ->from('Inventario i')
                                    ->leftJoin('i.InvDeposito d')
                                    ->leftJoin('i.Producto p')
                                    ->leftJoin('p.ProdCategoria pc')
                                    ->Where('i.deposito_id=111')
                                    ->andWhere('pc.nombre LIKE "'.$result->getNombre().'%"')
                                    ->orderBy('p.nombre ASC')
                                    ->execute();
                                  foreach ($prods as $prod):
                                ?>
                                  <a href="<?php echo url_for('producto/index?catname='.$result->getNombre()."&page=1"); ?>"><?php echo $prod["cont"]; ?> producto(s)</a>
                                <?php endforeach; ?>
                              </div>
                            </div>
                            <a href="<?php echo url_for('producto/index?catname='.$result->getNombre()."&page=1"); ?>" class="category-link"></a>
                          </div>
                        </div>
                        <?php
                          $results2 = Doctrine_Query::create()
                          ->select('pc.*')
                          ->from('ProdCategoria pc')
                          ->where('pc.codigo_full LIKE "'.$result->getCodigo().'-%"')
                          ->orderBy('pc.Nombre ASC')
                          ->execute();
                        ?>
                        <?php foreach ($results2 as $result2):?>
                          <div class="category-grid-item cat-design-alt product-category product" data-loop="<?php echo $k; $k++; ?>">
                            <div class="wrapp-category">
                              <div class="category-image-wrapp">
                                <a href="<?php echo url_for('producto/index?catname='.$result2->getNombre()."&page=1"); ?>" class="category-image">
                                  <img src="/uploads/prod_categoria/<?php echo $result2->getUrlImagen() ?>"  alt="Farmacia" width="300" />
                                </a>
                              </div>
                              <div class="hover-mask">
                                <h3 class="category-title"><?php list($pre,$name)=explode("/", $result2->getNombre()); echo $name ?></h3>
                                <div class="more-products">
                                <?php
                                  $prods = Doctrine_Query::create()
                                    ->select('COUNT(i.id) as cont')
                                    ->from('Inventario i')
                                    ->leftJoin('i.InvDeposito d')
                                    ->leftJoin('i.Producto p')
                                    ->leftJoin('p.ProdCategoria pc')
                                    ->Where('i.deposito_id =111')
                                    ->andWhere('pc.codigo_full LIKE "'.$result2->getCodigoFull().'"')
                                    ->orderBy('p.nombre ASC')
                                    ->execute();
                                  foreach ($prods as $prod):
                                ?>
                                  <a href="<?php echo url_for('producto/index?catname='.$result2->getNombre()."&page=1"); ?>"><?php echo $prod["cont"]; ?> producto(s)</a>
                                <?php endforeach; ?>
                                </div>
                              </div>
                              <a href="<?php echo url_for('producto/index?catname='.$result2->getNombre()."&page=1"); ?>" class="category-link"></a>
                            </div>
                          </div>
                        <?php endforeach; ?>
                      <?php endforeach; ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="vc_row-full-width vc_clearfix"></div>
          <div class="vc_row wpb_row vc_row-fluid vc_custom_1533813593149">
            <div class="wpb_column vc_column_container vc_col-sm-12 vc_col-lg-5 vc_col-md-12">
              <div class="vc_column-inner vc_custom_1533813532486">
                <div class="wpb_wrapper">
                  <div id="carousel-613" class="woodmart-carousel-container woodmart-highlighted-products with-title slider-type-product woodmart-carousel-spacing-20" data-owl-carousel data-wrap="no" data-hide_pagination_control="yes" data-hide_prev_next_buttons="no" data-desktop="1" data-tablet_landscape="1" data-tablet="1" data-mobile="1">
                    <h4 class="title element-title">OFERTA DEL DIA</h4>
                    <div class="owl-carousel owl-items-lg-1 owl-items-md-1 owl-items-sm-1 owl-items-xs-1">
                      <?php
                        $results = Doctrine_Query::create()
                        ->select('b.*')
                        ->from('Banners b')
                        ->where('b.posicion = ?', 'oferta_del_dia')
                        ->orderBy('RAND()')
                        ->execute();
                        $i=1; $j=1990;
                      ?>
                      <?php foreach($results as $result) { ?>
                        <div class="slide-product owl-carousel-item">
                          <div class="product-grid-item product product-no-swatches woodmart-hover-base product-in-carousel type-product status-publish first instock product_cat-music has-post-thumbnail downloadable virtual purchasable product-type-simple" data-loop="<?php echo $i; $i++; ?>" data-id="<?php echo $j; $j++; ?>">
                            <div class="product-wrapper">
                              <div class="content-product-imagin"></div>
                              <div class="product-element-top">
                                <a href="<?php echo $result->getEnlace(); ?>" class="product-image-link">
                                  <div class="product-labels labels-rectangular">
                                    <span class="onsale product-label" style="background-color: #6a4fa4; font-size: 1.5rem;">
                                      <?php echo $result->getDescripcion(); ?>
                                    </span>
                                  </div>
                                  <img width="300" height="300" src="/uploads/banners/<?php echo $result->getUrlImagen(); ?>" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="" loading="<?php echo $result->getUrlImagenDesc(); ?>" />
                                </a>
                              </div>
                              <div class="product-information">
                                <h3 class="product-title">
                                  <a href="<?php echo $result->getEnlace(); ?>"><?php echo $result->getNombre(); ?></a>
                                </h3>
                              </div>
                            </div>
                          </div>
                        </div>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="wpb_column vc_column_container vc_col-sm-12 vc_col-lg-7 vc_col-md-12">
              <div class="vc_column-inner vc_custom_1533826982227">
                <div class="wpb_wrapper">
                  <div id="wd-5f5543939dde6"
                    class="woodmart-products-tabs tabs-wd-5f5543939dde6 tabs-design-simple ">
                    <div class="woodmart-tabs-header text-center">
                      <div class="woodmart-tabs-loader"></div>
                      <div class="tabs-name" style="border-color:#6b50a5">
                        <span class="tabs-text">OFERTAS ESPECIALES</span>
                      </div>
                    </div>
                    <div class="woodmart-tab-content">
                      <div class="woodmart-products-element">
                        <div class="woodmart-products-loader"></div>
                        <div class="products elements-grid align-items-start row woodmart-products-holder woodmart-spacing-20 grid-columns-3" data-paged="1" data-source="shortcode">
                          <?php
                            $results = Doctrine_Query::create()
                            ->select('b.*')
                            ->from('Banners b')
                            ->where('b.posicion = ?', 'ofertas_especiales')
                            ->orderBy('RAND()')
                            ->limit(8)
                            ->execute();
                            $i=1; $j=1990;
                          ?>
                          <?php foreach ($results as $result): ?>
                            <div class="product-grid-item product product-no-swatches woodmart-hover-base col-md-4 col-6 first  type-product status-publish first instock product_cat-decor has-post-thumbnail shipping-taxable product-type-external" data-loop="<?php echo $i; $i++; ?>" data-id="<?php echo $j; $j++; ?>">
                              <div class="product-wrapper">
                                <div class="content-product-imagin"></div>
                                <div class="product-element-top">
                                  <a href="<?php echo $result->getEnlace();?>" class="product-image-link">
                                    <div class="product-labels labels-rectangular">
                                      <span class="onsale product-label" style="background-color: #6a4fa4;">
                                        <?php echo $result->getDescripcion(); ?>
                                      </span>
                                    </div>
                                    <img width="800" height="800" class="content-product-image attachment-full" alt="" loading="lazy" src="/uploads/banners/<?php echo $result->getUrlImagen();?>"/>
                                  </a>
                                </div>
                                <div class="product-information">
                                  <h3 class="product-title">
                                    <a href="<?php echo $result->getEnlace();?>" style="text-transform: capitalize">
                                      <?php echo mb_strtolower($result->getNombre());?>
                                    </a>
                                  </h3>
                                </div>
                              </div>
                            </div>
                          <?php endforeach; ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php
            $results = Doctrine_Query::create()
              ->select('b.*')
              ->from('Banners b')
              ->where('b.posicion = ?', 'populares')
              ->orderBy('RAND()')
              ->limit(1)
              ->execute();
            foreach ($results as $result):
          ?>
            <div class="vc_row wpb_row vc_row-fluid vc_custom_1534487651375 vc_row-has-fill vc_row-o-content-middle vc_row-flex">
              <div class="wpb_column vc_column_container vc_col-sm-12 vc_col-lg-8 vc_col-md-12">
                <div class="vc_column-inner vc_custom_1533804479805">
                  <div class="wpb_wrapper">
                    <div class="woodmart-image-hotspot-wrapper hotspot-action-hover hotspot-icon-default color-scheme-dark ">
                      <div class="woodmart-image-hotspot-hotspots">
                        <img class="woodmart-image-hotspot-img "
                          src="/uploads/banners/<?php echo $result->getUrlImagen(); ?>" width="800" height="600"
                          alt="<?php echo $result->getNombre(); ?>" title="<?php echo $result->getNombre(); ?>" />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="wpb_column vc_column_container vc_col-sm-12 vc_col-lg-4 vc_col-md-12 vc_hidden-md vc_hidden-sm">
                <div class="vc_column-inner vc_custom_1533808544328">
                  <div class="wpb_wrapper">
                    <div id="wd-5f550f8254496" class="title-wrapper  woodmart-title-color-default woodmart-title-style-simple woodmart-title-width-100 text-center z-index-100 woodmart-title-size-custom vc_custom_1599410092372">
                      <div class="liner-continer">
                        <span class="left-line"></span>
                        <h4 class="woodmart-title-container title  woodmart-font-weight-600"><?php echo mb_strtoupper($result->getNombre()); ?></h4>
                        <span class="right-line"></span>
                      </div>
                      <div class="title-after_title"><?php echo $result->getDescripcion(); ?></div>
                    </div>
                    <div class="vc_row wpb_row vc_inner vc_row-fluid">
                      <div class="wpb_column vc_column_container vc_col-sm-8 vc_col-sm-offset-2">
                        <div class="vc_column-inner">
                          <div class="wpb_wrapper">
                            <div class="vc_btn3-container button_shop vc_btn3-center">
                              <a class="vc_general vc_btn3 vc_btn3-size-lg vc_btn3-shape-rounded vc_btn3-style-modern vc_btn3-color-default"
                                  href="<?php echo $result->getEnlace(); ?>">
                                  VER MAS
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div data-vc-full-width="true" data-vc-full-width-init="false" class="vc_row wpb_row vc_row-fluid vc_custom_1599415063182 vc_row-has-fill vc_row-o-content-top vc_row-flex">
              <div class="wpb_column vc_column_container vc_col-sm-12">
                <div class="vc_column-inner vc_custom_1534490939640">
                  <div class="wpb_wrapper">
                    <div id="wd-5f5522d8a78ef" class="title-wrapper  woodmart-title-color-primary woodmart-title-style-underlined woodmart-title-width-100 text-left woodmart-title-size-custom vc_custom_1599415010187">
                      <div class="liner-continer">
                        <span class="left-line"></span>
                        <h4 class="woodmart-title-container title woodmart-font-weight-600">PRODUCTOS DESTACADOS</h4>
                        <span class="right-line"></span>
                      </div>
                    </div>
                    <div id="wd-5f552157546ce" class="woodmart-products-tabs active-tab-title tabs-wd-5f552157546ce tabs-design-default">
                      <div class="woodmart-tab-content">
                        <div class="woodmart-products-element">
                          <div class="products elements-grid align-items-start row woodmart-products-holder woodmart-spacing-20 grid-columns-4 pagination-" data-paged="1" data-source="shortcode">
                          <?php 
                            $results = Doctrine_Query::create()
                            ->select('i.id as iid, p.id as pid, p.nombre as pname, p.descripcion as desc,
                            p.precio_usd_1 as p01, p.precio_usd_2 as p02, p.precio_usd_3 as p03, p.precio_usd_4 as p04, p.precio_usd_5 as p05, p.precio_usd_6 as p06, p.precio_usd_7 as p07, p.url_imagen as img, p.categoria_id')
                            ->from('Inventario i')
                            ->leftJoin('i.Producto p')
                            ->where('i.deposito_id =?', 111)
                            ->andWhere('p.destacado = ?', 1)
                            ->orderBy("RAND()")
                            ->limit(4)
                            ->execute();
                            foreach ($results as $result):
                          ?>
                            <div class="product-grid-item wd-with-labels product product-no-swatches woodmart-hover-base 
                              col-md-3 col-sm-4 col-6 first  type-product post-9242 status-publish first instock 
                              product_cat-gripe-clothing has-post-thumbnail sale featured shipping-taxable purchasable product-type-simple"
                              data-loop="1" data-id="9242">
                              <div class="product-wrapper">
                                <div class="content-product-imagin"></div>
                                <div class="product-element-top">
                                  <a href="<?php echo url_for('producto/show?id='.$result["pid"]); ?>" class="product-image-link">
                                    <?php if($result["activo"]==0 || $result["cantidad"]<=0): ?>
                                      <div class="product-labels labels-rectangular">
                                        <span class="featured product-label">Agotado</span>
                                      </div>
                                    <?php endif; ?>
                                    <?php if(!empty($result["img"])): ?>
                                      <img width="300" height="300" src="/uploads/producto/<?php echo $result["img"]; ?>" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="" loading="lazy" />
                                    <?php else: ?>
                                      <img width="300" height="300" src="/images/user_icon.png" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="" loading="lazy" />
                                    <?php endif; ?>
                                  </a>
                                </div>
                                <div class="product-information">
                                  <h3 class="product-title">
                                    <a href="<?php echo url_for('producto/show?id='.$result["pid"]); ?>" style="text-transform: capitalize">
                                      <?php echo mb_strtolower($result["pname"]); ?>
                                    </a>
                                  </h3>
                                  <?php if($sf_user->isAuthenticated()): ?>
                                    <div class="product-rating-price">
                                      <div class="wrapp-product-price">
                                        <span class="price">
                                          <span class="woocommerce-Price-amount amount">
                                            <bdi>
                                              <?php 
                                                if(!empty($cid=$sf_user->getGuardUser()->getTipoPrecio())):
                                                    if($result["p0$cid"]>0) {
                                                      echo '<span class="woocommerce-Price-currencySymbol">$</span>'.$result["p0$cid"];
                                                    }
                                                endif;
                                              ?>
                                            </bdi>
                                          </span>
                                        </span>
                                      </div>
                                    </div>
                                  <?php endif; ?>
                                  <?php if(!empty($result["desc"])): ?>
                                    <div class="fade-in-block">
                                      <div class="hover-content woodmart-more-desc">
                                        <div class="hover-content-inner woodmart-more-desc-inner">
                                          <?php echo substr($result["desc"],0,100);?>
                                        </div>
                                      </div>
                                    </div>
                                  <?php endif; ?>
                                </div>
                              </div>
                            </div>
                          <?php endforeach; ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="vc_row-full-width vc_clearfix"></div>
          <?php endforeach; ?>
        <div class="vc_row wpb_row vc_row-fluid">
          <div class="wpb_column vc_column_container vc_col-sm-12">
            <div class="vc_column-inner">
              <div class="wpb_wrapper">
                <div id="wd-5f55247a75197"
                  class="title-wrapper  woodmart-title-color-primary woodmart-title-style-underlined woodmart-title-width-100 text-left woodmart-title-size-default">
                  <div class="liner-continer">
                    <span class="left-line"></span>
                    <h4 class="woodmart-title-container title  woodmart-font-weight-">PRODUCTOS NUEVOS</h4>
                    <span class="right-line"></span>
                  </div>
                </div>
                <div id="wd-5f554306eb5ed" class="woodmart-products-tabs active-tab-title tabs-wd-5f554306eb5ed tabs-design-default">
                  <div class="woodmart-tabs-header text-center">
                    <div class="woodmart-tabs-loader"></div>
                    <div class="tabs-navigation-wrapper">
                      <span class="open-title-menu"></span>
                      <ul class="products-tabs-title"></ul>
                    </div>
                  </div>
                  <div class="woodmart-tab-content">
                    <div id="carousel-381" class="woodmart-carousel-container  slider-type-product woodmart-carousel-spacing-20" data-wrap="no" data-hide_pagination_control="yes" data-hide_prev_next_buttons="no" data-desktop="4" data-tablet_landscape="4" data-tablet="3" data-mobile="2">
                        <div class="owl-carousel owl-items-lg-4 owl-items-md-4 owl-items-sm-3 owl-items-xs-2">
                          <?php
                            $results = Doctrine_Query::create()
                              ->select('i.id as iid, p.id as pid, p.nombre as pname,
                              p.precio_usd_1 as p01, p.precio_usd_2 as p02, p.precio_usd_3 as p03, p.precio_usd_4 as p04, p.precio_usd_5 as p05, p.precio_usd_6 as p06, p.precio_usd_7 as p07,
                              p.url_imagen as img, p.categoria_id')
                              ->from('Inventario i')
                              ->leftJoin('i.Producto p')
                              ->where('i.deposito_id =?', 131)
                              ->andWhere('p.url_imagen IS NOT NULL')
                              ->orderBy("i.updated_at DESC")
                              ->limit(8)
                              ->execute();
                              $i=1; $j=1800;
                          foreach ($results as $result):
                          ?>
                          <div class="slide-product owl-carousel-item">
                            <div class="product-grid-item product product-no-swatches woodmart-hover-base product-in-carousel type-product post-9248 status-publish first instock product_cat-music has-post-thumbnail downloadable virtual purchasable product-type-simple"
                              data-loop="<?php echo $i; $i++; ?>" data-id="<?php echo $j; $j++; ?>">
                              <div class="product-wrapper">
                                <div class="content-product-imagin"></div>
                                <div class="product-element-top">
                                  <a href="<?php echo url_for('producto/show?id='.$result["pid"]); ?>" class="product-image-link">
                                    <?php if($result["activo"]==0 || $result["cantidad"]<=0): ?>
                                      <div class="product-labels labels-rectangular">
                                        <span class="featured product-label">Agotado</span>
                                      </div>
                                    <?php endif; ?>
                                    <?php if(!empty($result["img"])): ?>
                                      <img width="300" height="300" src="/uploads/producto/<?php echo $result["img"]; ?>" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="" loading="lazy" style="max-height: 300px;" />
                                    <?php else: ?>
                                      <img width="300" height="300" src="/images/user_icon.png" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="" loading="lazy" />
                                    <?php endif; ?>
                                  </a>
                                </div>
                                <div class="product-information">
                                  <h3 class="product-title">
                                    <a href="<?php echo url_for('producto/show?id='.$result["pid"]); ?>" style="text-transform: capitalize">
                                      <?php echo mb_strtolower($result["pname"]); ?>
                                    </a>
                                  </h3>
                                  <?php if($sf_user->isAuthenticated()): ?>
                                    <div class="product-rating-price">
                                      <div class="wrapp-product-price">
                                        <span class="price">
                                          <span class="woocommerce-Price-amount amount">
                                            <bdi>
                                              <?php 
                                                if(!empty($cid=$sf_user->getGuardUser()->getTipoPrecio())):
                                                    if($result["p0$cid"]>0) {
                                                      echo '<span class="woocommerce-Price-currencySymbol">$</span>'.$result["p0$cid"];
                                                    }
                                                endif;
                                              ?>
                                            </bdi>
                                          </span>
                                        </span>
                                      </div>
                                    </div>
                                  <?php endif; ?>
                                </div>
                              </div>
                            </div>
                          </div>
                          <?php endforeach; ?>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </article>
    </div>
  </div>
</div>
<script>
  jQuery(document).ready(function ($) {
    var owl = $("#carousel-381 .owl-carousel");
    $(window).bind("vc_js", function () {
      owl.trigger('refresh.owl.carousel');
    });
    var options = {
      rtl: $('body').hasClass('rtl'),
      items: 4,
      responsive: {
        1025: {
          items: 4
        },
        769: {
          items: 4
        },
        577: {
          items: 3
        },
        0: {
          items: 2
        }
      },
      autoplay: false,
      autoplayTimeout: 5000,
      dots: false,
      nav: true,
      autoHeight: false,
      slideBy: 'page',
      navText: false,
      center: false,
      loop: false,
      dragEndSpeed: 200,
      onRefreshed: function () {
        $(window).resize();
      }
    };
    owl.owlCarousel(options);
  });
</script>