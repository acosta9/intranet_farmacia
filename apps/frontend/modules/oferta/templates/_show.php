<div class="container-fluid">
  <div class="row content-layout-wrapper align-items-start">
    <div class="site-content shop-content-area col-12 breadcrumbs-location-summary content-with-products" role="main">
      <div class="container"></div>
      <div id="product-851" style="margin-top: 2rem" class="single-product-page single-product-content product-design-default tabs-location-standard tabs-type-tabs meta-location-add_to_cart reviews-location-tabs product-no-bg product type-product post-851 status-publish first instock product_cat-accessories product_cat-clocks has-post-thumbnail shipping-taxable purchasable product-type-variable">
         <div class="container">
            <div class="woocommerce-notices-wrapper"></div>
               <div class="row product-image-summary-wrap">
                  <div class="product-image-summary col-lg-12 col-12 col-md-12">
                     <div class="row product-image-summary-inner">
                        <div class="col-lg-6 col-12 col-md-6 product-images">
                           <div id="carousel-613" class="woodmart-carousel-container woodmart-highlighted-products with-title slider-type-product woodmart-carousel-spacing-20" data-owl-carousel data-wrap="no" data-hide_pagination_control="yes" data-hide_prev_next_buttons="no" data-desktop="1" data-tablet_landscape="1" data-tablet="1" data-mobile="1">
                              <h4 class="title element-title">DETALLES</h4>
                              <div class="owl-carousel owl-items-lg-1 owl-items-md-1 owl-items-sm-1 owl-items-xs-1">
                                 <?php $i=0; if(!empty($oferta->getUrlImagen())): $i++;?>
                                    <div class="slide-product owl-carousel-item">
                                       <div class="product-grid-item product product-no-swatches woodmart-hover-base product-in-carousel type-product status-publish first instock product_cat-music has-post-thumbnail downloadable virtual purchasable product-type-simple" data-loop="<?php echo $i; $i++; ?>" data-id="<?php echo $j; $j++; ?>">
                                          <div class="product-wrapper">
                                             <div class="content-product-imagin"></div>
                                             <div class="product-element-top">
                                                <a href="#" class="product-image-link">
                                                   <img width="300" height="300" src="/uploads/oferta/<?php echo $oferta->getUrlImagen(); ?>" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="<?php echo $oferta->getUrlImagenDesc(); ?>" loading="lazy" />
                                                </a>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 <?php endif; ?>
                                 <?php if($i==1): ?>
                                    <div class="slide-product owl-carousel-item">
                                       <div class="product-grid-item product product-no-swatches woodmart-hover-base product-in-carousel type-product status-publish first instock product_cat-music has-post-thumbnail downloadable virtual purchasable product-type-simple" data-loop="<?php echo $i; $i++; ?>" data-id="<?php echo $j; $j++; ?>">
                                          <div class="product-wrapper">
                                             <div class="content-product-imagin"></div>
                                             <div class="product-element-top">
                                                <a href="#" class="product-image-link">
                                                   <img width="300" height="300" src="/images/coming-soon.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="" loading="lazy" />
                                                </a>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 <?php endif; ?>
                              </div>
                           </div>
                        </div>
                        <div class="col-lg-6 col-12 col-md-6 summary entry-summary">
                        <div class="summary-inner">
                           <div class="single-breadcrumbs-wrapper">
                              <div class="single-breadcrumbs">
                                 <nav class="woocommerce-breadcrumb">
                                    <a href="<?php echo url_for('inicio')?>" class="breadcrumb-link ">Inicio</a>
                                    <a href="<?php echo url_for('oferta')?>" class="breadcrumb-link ">Ofertas</a>
                                    <span class="breadcrumb-last" style="text-transform: capitalize"> <?php echo mb_strtolower($oferta->getNombre()); ?></span>
                                 </nav>
                                 <div class="woodmart-products-nav">
                                    <a href="<?php echo url_for('oferta'); ?>" class="woodmart-back-btn" data-original-title="" title="">
                                       <span> Regresar a ofertas </span>
                                    </a>
                                    </div>
                                 </div>
                              </div>
                              <h1 itemprop="name" class="product_title entry-title"><?php echo $oferta->getNombre(); ?></h1>
                              <p class="price">
                              <?php
                                 $showcar=0; 
                                 if($sf_user->isAuthenticated()): ?>
                                 <span class="woocommerce-Price-amount amount">
                                    <?php 
                                       $showcar=1;
                                       echo '<span class="woocommerce-Price-currencySymbol">$</span>'.$oferta->getPrecioUsd(); 
                                    ?>
                                 </span>
                              <?php endif; ?>
                              </p>
                              <div class="woocommerce-product-details__short-description">
                                 <p style="text-align: justify"><?php echo $oferta->getDescripcion(); ?></p>
                              </div>                            
                              <?php
                                 if($showcar==1):
                                    include_component('carrito', 'agregarcuatro', array('oferta_id' => $oferta->getId()));
                                 endif;
                              ?>
                              <div class="product_meta">
                                 <span class="sku_wrapper">Serial: <span class="sku"><?php echo $oferta->getId(); ?></span></span>
                              </div>
                              <div class="product-share">
                                 <span class="share-title">Compartir</span>
                                 <?php $actual_link =  "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"; ?>
                                 <div class="woodmart-social-icons text-center icons-design-default icons-size-small color-scheme-dark social-share social-form-circle">
                                    <a rel="nofollow" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $actual_link; ?>" target="_blank" class="woodmart-social-icon social-facebook">
                                       <i></i>
                                       <span class="woodmart-social-icon-name">Facebook</span> 
                                    </a>
                                    <a rel="nofollow" href="https://twitter.com/share?url=<?php echo $actual_link; ?>" target="_blank" class="woodmart-social-icon social-twitter">
                                       <i></i>
                                       <span class="woodmart-social-icon-name">Twitter</span>
                                    </a>
                                    <a rel="nofollow" href="https://telegram.me/share/url?url=<?php echo $actual_link; ?>" target="_blank" class="woodmart-social-icon social-tg">
                                       <i></i>
                                       <span class="woodmart-social-icon-name">Telegram</span>
                                    </a>
                                    <a rel="nofollow" href="whatsapp://send?text=<<<?php echo $actual_link; ?>>> data-action="share/whatsapp/share" target="_blank" class="woodmart-social-icon social-whatsapp">
                                       <i></i>
                                       <span class="woodmart-social-icon-name">Whatsapp</span>
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
      </div>
   </div>
</div>