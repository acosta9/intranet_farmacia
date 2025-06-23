<div class="product-grid-item wd-with-labels product has-stars product-no-swatches woodmart-hover-base col-md-4 col-6 type-product status-publish instock product_cat-accessories has-post-thumbnail featured shipping-taxable purchasable product-type-variable hover-ready">
	<div class="product-wrapper">
		<div class="content-product-imagin" style="margin-bottom: -141px;"></div>
		<div class="product-element-top">
			<a href="<?php echo url_for('oferta/show?id='.$oferta->getId()); ?>" class="product-image-link">
			<?php if(!empty($oferta->getUrlImagen())): ?>
				<img width="430" height="491" src="/uploads/oferta/<?php echo $oferta->getUrlImagen(); ?>" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="">
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
				<a href="<?php echo url_for('oferta/show?id='.$oferta->getId()); ?>" style="text-transform: capitalize">
					<?php echo mb_strtolower($oferta->getNombre()); ?>
				</a>
			</h3>
			<?php if($sf_user->isAuthenticated()): ?>
			<div class="product-rating-price">
				<div class="wrapp-product-price">
					<span class="price">
						<span class="woocommerce-Price-amount amount">
						<?php							
							if($oferta["precio_usd"]>0) {
								echo '<span class="woocommerce-Price-currencySymbol">$</span>'.$oferta["precio_usd"];
							}							
						?>
						</span>
				</div>
			</div>
			<?php endif; ?>
			<?php if(!empty($oferta->getDescripcion())): ?>
				<div class="fade-in-block">
					<div class="hover-content woodmart-more-desc woodmart-more-desc-active">
						<div class="hover-content-inner woodmart-more-desc-inner">
							<?php echo $oferta->getDescripcion(); ?>
						</div>
						<a href="<?php echo url_for('oferta/show?id='.$oferta->getId()); ?>" class="woodmart-more-desc-btn"><span>mas</span></a>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
