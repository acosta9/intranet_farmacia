<div class="product-grid-item wd-with-labels product has-stars product-no-swatches woodmart-hover-base col-md-4 col-6 type-product status-publish instock product_cat-accessories has-post-thumbnail featured shipping-taxable purchasable product-type-variable hover-ready">
	<div class="product-wrapper">
		<div class="content-product-imagin" style="margin-bottom: -141px;"></div>
		<div class="product-element-top">
			<a href="<?php echo url_for('producto/show?id='.$producto->getId()); ?>" class="product-image-link">
			<?php if($producto["iact"]==0 || $producto["qty"]<=0): ?>
				<div class="product-labels labels-rectangular">
						<span class="featured product-label">Agotado</span>
				</div>
			<?php endif; ?>
			<?php if(!empty($producto->getUrlImagen())): ?>
				<img width="430" height="491" src="/uploads/producto/<?php echo $producto->getUrlImagen(); ?>" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="">
			<?php else: ?>
				<img width="430" height="491" src="/images/no-product.png" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="">
			<?php endif; ?>
			</a>
			<div class="wrapp-swatches"></div>
			<div class="quick-shop-wrapper">
				<div class="quick-shop-close wd-cross-button wd-size-s wd-with-text-left"><span>Cerrar</span></div>
				<div class="quick-shop-form"></div>
			</div>
		</div>
		<div class="product-information">
			<h3 class="product-title">
				<a href="<?php echo url_for('producto/show?id='.$producto->getId()); ?>" style="text-transform: capitalize">
					<?php echo mb_strtolower($producto->getNombre()); ?>
				</a>
			</h3>
			<div class="woodmart-product-cats">
				<a href="<?php echo url_for('producto')."?catname=".$producto["pcname"]; ?>" rel="tag" style="text-transform: capitalize">
					<?php $cats=explode("/",$producto["pcname"]); echo mb_strtolower(end($cats)); ?>
				</a>
			</div>
			<?php if($sf_user->isAuthenticated()): ?>
			<div class="product-rating-price">
				<div class="wrapp-product-price">
					<span class="price">
						<span class="woocommerce-Price-amount amount">
						<?php 
							if(!empty($cid=$sf_user->getGuardUser()->getTipoPrecio())):
									if($producto["precio_usd_$cid"]>0) {
										echo '<span class="woocommerce-Price-currencySymbol">$</span>'.$producto["precio_usd_$cid"];
									}
							endif;
						?>
						</span>
				</div>
			</div>
			<?php endif; ?>
			<?php if(!empty($producto->getDescripcion())): ?>
				<div class="fade-in-block">
					<div class="hover-content woodmart-more-desc woodmart-more-desc-active">
						<div class="hover-content-inner woodmart-more-desc-inner">
							<?php echo $producto->getDescripcion(); ?>
						</div>
						<a href="<?php echo url_for('producto/show?id='.$producto->getId()); ?>" class="woodmart-more-desc-btn"><span>mas</span></a>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
