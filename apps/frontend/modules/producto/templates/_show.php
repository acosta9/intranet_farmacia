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
                                 <?php
                                    $results = Doctrine_Query::create()
                                    ->select('pi.*')
                                    ->from('ProductoImg pi')
                                    ->where('pi.producto_id = ?', $producto->getId())
                                    ->orderBy('pi.id ASC')
                                    ->execute();
                                    $i=1; $j=1990;
                                 ?>
                                 <?php if(!empty($producto->getUrlImagen())): ?>
                                    <div class="slide-product owl-carousel-item">
                                       <div class="product-grid-item product product-no-swatches woodmart-hover-base product-in-carousel type-product status-publish first instock product_cat-music has-post-thumbnail downloadable virtual purchasable product-type-simple" data-loop="<?php echo $i; $i++; ?>" data-id="<?php echo $j; $j++; ?>">
                                          <div class="product-wrapper">
                                             <div class="content-product-imagin"></div>
                                             <div class="product-element-top">
                                                <a href="#" class="product-image-link">
                                                   <img width="300" height="300" src="/uploads/producto/<?php echo $producto->getUrlImagen(); ?>" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="<?php echo $producto->getUrlImagenDesc(); ?>" loading="lazy" />
                                                </a>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 <?php endif; ?>
                                 <?php foreach($results as $result) { ?>
                                    <div class="slide-product owl-carousel-item">
                                       <div class="product-grid-item product product-no-swatches woodmart-hover-base product-in-carousel type-product status-publish first instock product_cat-music has-post-thumbnail downloadable virtual purchasable product-type-simple" data-loop="<?php echo $i; $i++; ?>" data-id="<?php echo $j; $j++; ?>">
                                          <div class="product-wrapper">
                                             <div class="content-product-imagin"></div>
                                             <div class="product-element-top">
                                                <a href="#" class="product-image-link">
                                                   <img width="300" height="300" src="/uploads/producto_img/<?php echo $result->getUrlImagen(); ?>" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="<?php echo $result->getDescripcion(); ?>" loading="lazy" />
                                                </a>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 <?php } ?>
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
                                    <a href="<?php echo url_for('producto')?>" class="breadcrumb-link ">Productos</a>
                                    <span class="breadcrumb-last" style="text-transform: capitalize"> <?php echo mb_strtolower($producto->getNombre()); ?></span>
                                 </nav>
                                 <div class="woodmart-products-nav">
                                    <a href="<?php echo url_for('producto')."?cat=".$producto->getCategoriaId(); ?>" class="woodmart-back-btn" data-original-title="" title="">
                                       <span> Regresar a productos </span>
                                    </a>
                                    </div>
                                 </div>
                              </div>
                              <h1 itemprop="name" class="product_title entry-title"><?php echo $producto->getNombre(); ?></h1>
                              <p class="price">
                              <?php if($sf_user->isAuthenticated()): ?>
                                 <span class="woocommerce-Price-amount amount">
                                    <?php 
                                       $showcar=0;
                                       if(!empty($cid=$sf_user->getGuardUser()->getTipoPrecio())):
                                          if($producto->getProdWeb($cid)>0) {
                                             $showcar=1;
                                             echo '<span class="woocommerce-Price-currencySymbol">$</span>'.$producto->getProdWeb($cid); 
                                          }
                                       endif;
                                    ?>
                                 </span>
                              <?php endif; ?>
                              </p>
                              <div class="woocommerce-product-details__short-description">
                                 <p style="text-align: justify"><?php echo $producto->getDescripcion(); ?></p>
                              </div>
                              <table class="woocommerce-product-attributes shop_attributes">
                                 <tbody>
                                    <tr class="woocommerce-product-attributes-item woocommerce-product-attributes-item--attribute_pa_color">
                                       <th class="woocommerce-product-attributes-item__label">Unidad</th>
                                       <td class="woocommerce-product-attributes-item__value">
                                          <p><?php echo $producto->getProdUnidad(); ?></p>
                                       </td>
                                    </tr>
                                    <tr class="woocommerce-product-attributes-item woocommerce-product-attributes-item--attribute_pa_brand">
                                       <th class="woocommerce-product-attributes-item__label">Laboratorio</th>
                                       <td class="woocommerce-product-attributes-item__value">
                                          <p><?php echo $producto->getProdLaboratorio(); ?></p>
                                       </td>
                                    </tr>
                                    <tr class="woocommerce-product-attributes-item woocommerce-product-attributes-item--attribute_thickness">
                                       <th class="woocommerce-product-attributes-item__label">Compuesto</th>
                                       <td class="woocommerce-product-attributes-item__value">
                                          <p><?php echo $producto->getProdCompuestos(); ?></p>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                              <?php
                                 $invs = Doctrine_Query::create()
                                    ->select('i.*')
                                    ->from('Inventario i')
                                    ->where('i.producto_id =?', $producto->getId())
                                    ->AndWhere('i.deposito_id =?', 111)
                                    ->execute();
                                 $iid="";
                                 foreach ($invs as $inv) {
                                    $iid=$inv->getId();
                                 }
                              ?>
                              
                              <?php
                                 if($showcar==1):
                                    include_component('carrito', 'agregartres', array('inventario_id' => $iid));
                                 endif;
                              ?>
                              <div class="product_meta">
                                 <span class="sku_wrapper">Serial: <span class="sku"><?php echo $producto->getSerial(); ?></span></span>
                                 <span class="posted_in">Categorias: 
                                 <?php $cats = explode ("/",$producto->getProdCategoria()); ?>
                                    <?php foreach ($cats as $cat): ?>
                                       <a href="<?php echo url_for('producto')."?catname=".$cat; ?>" class="breadcrumb-link breadcrumb-link-last" style="text-transform: capitalize">
                                          <?php echo mb_strtolower($cat); ?>
                                       </a>, 
                                    <?php endforeach; ?>
                                 </span>
                                 <span class="posted_in">Tags: 
                                    <?php 
                                       $tags = explode(";", $producto->getTags());
                                       $total = count($tags);
                                       $i=1;
                                       $busqueda = "";
                                       foreach ($tags as $item) {
                                          if($total == $i) {
                                             $busqueda = $busqueda.trim($item);
                                          } else {
                                             $busqueda = $busqueda.trim($item)."|";
                                          }
                                          echo "<a style='text-transform: capitalize' href='".url_for("producto")."?tag=".trim($item)."'>".mb_strtolower($item)."</a>, ";
                                          $i++;
                                       }
                                    ?>
                                 </span>
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
         </div><
         <?php if(!empty($producto->getMasDetalles())): ?>
            <div class="product-tabs-wrapper">
               <div class="container">
                  <div class="row">
                     <div class="col-12 poduct-tabs-inner">
                        <div class="woocommerce-tabs wc-tabs-wrapper tabs-layout-tabs">
                           <ul class="tabs wc-tabs">
                              <li class="description_tab active"> <a href="#tab-description">Descripcion</a></li>
                           </ul>
                           <div class="woodmart-tab-wrapper">
                              <a href="#tab-description" class="woodmart-accordion-title tab-title-description active">Descripcion</a>
                              <div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--description panel entry-content wc-tab" id="tab-description" style="display: block;">
                                 <div class="wc-tab-inner">
                                 <?php  echo html_entity_decode($producto->getMasDetalles());?>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         <?php endif; ?>
         <div class="container related-and-upsells">
            <div class="related-products">
               <h3 class="title slider-title">Productos relacionados</h3>
               <div id="carousel-560" class="woodmart-carousel-container slider-type-product woodmart-carousel-spacing-20" data-owl-carousel="" data-desktop="4" data-tablet_landscape="4" data-tablet="3" data-mobile="2">
                  <div class="owl-carousel owl-items-lg-4 owl-items-md-4 owl-items-sm-3 owl-items-xs-2 owl-loaded owl-drag">
                     <div class="owl-stage-outer">
                        <div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 2424px;">
                        <?php
                           $arr_compuesto=array();
                           $results = Doctrine_Query::create()
                           ->select('pc.*')
                           ->from('ProdCompuesto pc')
                           ->where('pc.producto_id =?', $producto->getId())
                           ->execute();
                           $i=0;
                           foreach ($results as $result) {
                              $arr_compuesto[$i]=$result->getCompuestoId();
                              $i++;
                           }
                           $results = Doctrine_Query::create()
                           ->select('i.id as iid, i.activo as activo, i.cantidad as cantidad,
                               p.id as pid, p.nombre as pname, p.precio_usd_1 as p01, p.precio_usd_2 as p02, p.precio_usd_3 as p03, p.precio_usd_4 as p04, p.precio_usd_5 as p05, p.precio_usd_6 as p06, p.precio_usd_7 as p07, p.url_imagen as img, p.categoria_id, 
                               c.id as cid, c.nombre as catname')
                           ->from('Inventario i')
                           ->leftJoin('i.Producto p')
                           ->leftJoin('p.ProdCompuesto pc')
                           ->leftJoin('p.ProdCategoria c')
                           ->WhereIn('pc.compuesto_id', $arr_compuesto)
                           ->andWhere('i.deposito_id=101')
                           ->orderBy("RAND()")
                           ->limit(4)
                           ->execute();
                           $i=1; $j=1725;
                        foreach ($results as $result):
                           if($producto->getId()!=$result["pid"]):
                        ?>
                           <div class="owl-item active" style="width: 303px;">
                              <div class="slide-product owl-carousel-item">
                                 <div class="product-grid-item product woodmart-hover-base product-in-carousel type-product post-1170 status-publish last instock product_cat-clocks has-post-thumbnail shipping-taxable purchasable product-type-variable" data-loop="<?php echo $i; $i++; ?>" data-id="<?php echo $j; $j++; ?>">
                                    <div class="product-wrapper" style="border: 2px solid #8c7caf7a; min-height: 390px">
                                       <div class="content-product-imagin"></div>
                                       <div class="product-element-top">
                                          <a href="<?php echo url_for('producto/show?id='.$result["pid"]); ?>" class="product-image-link">
                                             <?php if($result["activo"]==0 || $result["cantidad"]<=0): ?>
                                                <div class="product-labels labels-rectangular">
                                                   <span class="featured product-label">Agotado</span>
                                                </div>
                                             <?php endif; ?>
                                          <?php if(!empty($result["img"])): ?>
                                             <img width="430" height="491" src="/uploads/producto/<?php echo $result["img"];?>" 
                                             class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="" sizes="(max-width: 430px) 100vw, 430px">
                                          <?php else: ?>
                                             <img width="430" height="491" src="/images/no-product.png" 
                                             class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="" sizes="(max-width: 430px) 100vw, 430px">
                                          <?php endif; ?>
                                          </a>
                                       </div>
                                       <div class="product-information">
                                          <h3 class="product-title">
                                             <a href="<?php echo url_for('producto/show?id='.$result["pid"]); ?>" style="text-transform: capitalize">
                                                <?php echo mb_strtolower($result["pname"]); ?>
                                             </a>
                                          </h3>
                                          <div class="woodmart-product-cats">
                                             <a href="<?php echo url_for('producto')."?catname=".$result["catname"]; ?>" rel="tag" style="text-transform: capitalize">
                                                <?php $cats=explode("/",$result["catname"]); echo mb_strtolower(end($cats))?>
                                             </a>
                                          </div>
                                          <?php if($sf_user->isAuthenticated()): ?>
                                             <div class="product-rating-price">
                                                <div class="wrapp-product-price">
                                                   <span class="price">
                                                      <span class="woocommerce-Price-amount amount">
                                                         <?php 
                                                            if(!empty($cid=$sf_user->getGuardUser()->getTipoPrecio())):
                                                               if($result["p0$cid"]>0) {
                                                                  echo '<span class="woocommerce-Price-currencySymbol">$</span>'.$result["p0$cid"];
                                                               }
                                                            endif;
                                                         ?>
                                                      </span>
                                                   </span>
                                                </div>
                                             </div>
                                          <?php endif; ?>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        <?php endif; endforeach; ?>
                        <?php if($i<5):
                           $results = Doctrine_Query::create()
                              ->select('i.id as iid, i.activo as activo, i.cantidad as cantidad,
                               p.id as pid, p.nombre as pname, p.precio_usd_1 as p01, p.precio_usd_2 as p02, p.precio_usd_3 as p03, p.precio_usd_4 as p04, p.precio_usd_5 as p05, p.precio_usd_6 as p06, p.precio_usd_7 as p07, p.url_imagen as img, p.categoria_id, 
                               c.id as cid, c.nombre as catname')
                              ->from('Inventario i')
                              ->leftJoin('i.Producto p')
                              ->leftJoin('p.ProdCategoria c')
                              ->where('p.tags REGEXP ?', $busqueda)
                              ->andWhere('i.deposito_id=111')
                              ->orderBy("RAND()")
                              ->limit(5-$i)
                              ->execute();
                           foreach ($results as $result):
                              if($producto->getId()!=$result["pid"]):
                           ?>
                              <div class="owl-item active" style="width: 303px;">
                                 <div class="slide-product owl-carousel-item">
                                    <div class="product-grid-item product woodmart-hover-base product-in-carousel type-product post-1170 status-publish last instock product_cat-clocks has-post-thumbnail shipping-taxable purchasable product-type-variable" data-loop="<?php echo $i; $i++; ?>" data-id="<?php echo $j; $j++; ?>">
                                       <div class="product-wrapper" style="border: 2px solid #8c7caf7a; min-height: 390px">
                                          <div class="content-product-imagin"></div>
                                          <div class="product-element-top">
                                             <a href="<?php echo url_for('producto/show?id='.$result["pid"]); ?>" class="product-image-link">
                                             <?php if($result["activo"]==0 || $result["cantidad"]<=0): ?>
                                                <div class="product-labels labels-rectangular">
                                                   <span class="featured product-label">Agotado</span>
                                                </div>
                                             <?php endif; ?>
                                             <?php if(!empty($result["img"])): ?>
                                                <img width="430" height="491" src="/uploads/producto/<?php echo $result["img"];?>" 
                                                class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="" sizes="(max-width: 430px) 100vw, 430px">
                                             <?php else: ?>
                                                <img width="430" height="491" src="/images/no-product.png" 
                                                class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="" sizes="(max-width: 430px) 100vw, 430px">
                                             <?php endif; ?>
                                             </a>
                                          </div>
                                          <div class="product-information">
                                             <h3 class="product-title">
                                                <a href="<?php echo url_for('producto/show?id='.$result["pid"]); ?>" style="text-transform: capitalize">
                                                   <?php echo mb_strtolower($result["pname"]); ?>
                                                </a>
                                             </h3>
                                             <div class="woodmart-product-cats">
                                                <a href="<?php echo url_for('producto')."?catname=".$result["catname"]; ?>" rel="tag" style="text-transform: capitalize">
                                                   <?php $cats=explode("/",$result["catname"]); echo mb_strtolower(end($cats))?>
                                                </a>
                                             </div>
                                             <?php if($sf_user->isAuthenticated()): ?>
                                                <div class="product-rating-price">
                                                   <div class="wrapp-product-price">
                                                      <span class="price">
                                                         <span class="woocommerce-Price-amount amount">
                                                            <?php 
                                                               if(!empty($cid=$sf_user->getGuardUser()->getTipoPrecio())):
                                                                  if($result["p0$cid"]>0) {
                                                                     echo '<span class="woocommerce-Price-currencySymbol">$</span>'.$result["p0$cid"];
                                                                  }
                                                               endif;
                                                            ?>
                                                         </span>
                                                      </span>
                                                   </div>
                                                </div>
                                             <?php endif; ?>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           <?php endif; endforeach; ?>
                        <?php endif; ?>
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