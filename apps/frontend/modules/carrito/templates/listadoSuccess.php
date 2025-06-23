<div class="shopping-cart-widget-body woodmart-scroll">
	<div class="woodmart-scroll-content">
		<ul class="cart_list product_list_widget woocommerce-mini-cart ">
			<?php
			$cars = Doctrine_Query::create()
				->select('c.*')
				->from('Carrito c')
				->where('c.sf_guard_user_id =?', $sf_user->getGuardUser()->getId())
				->execute();
			$i = 0;
			$iid = "";
			$subtotal = 0;
			foreach ($cars as $car):
				$i++;
				if (!empty($car->getInventarioId())):
					$inv = Doctrine::getTable('Inventario')->findOneBy('id', $car->getInventarioId());
					$producto = Doctrine::getTable('Producto')->findOneBy('id', $inv->getProductoId());
			?>
					<li class="woocommerce-mini-cart-item mini_cart_item" id="car_item_<?php echo $car->getId(); ?>">
						<a href="#" class="remove remove_from_cart_button" aria-label="Eliminar este item" onclick="eliminar_item(<?php echo $car->getId(); ?>)">×</a>
						<a href="<?php echo url_for("@producto") . "/" . $producto->getId(); ?>" class="cart-item-image">
							<?php if (!empty($producto->getUrlImagen())): ?>
								<img width="430" height="444" src="/uploads/producto/<?php echo $producto->getUrlImagen(); ?>" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" />
							<?php else: ?>
								<img width="430" height="444" src="/images/no-product.png" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" />
							<?php endif;?>
						</a>
						<div class="cart-info">
							<span class="product-title" style="text-transform: capitalize">
								<a href="<?php echo url_for("@producto") . "/" . $producto->getId(); ?>"><?php echo mb_strtolower($producto->getNombre()); ?></a>
							</span>
							<span class="quantity"><?php echo $car->getCantidad(); ?> ×
								<span class="woocommerce-Price-amount amount">
									<?php 
										if(!empty($cid=$sf_user->getGuardUser()->getTipoPrecio())):
												if($producto["precio_usd_$cid"]>0) {
													echo '<span class="woocommerce-Price-currencySymbol">$</span>'.$producto["precio_usd_$cid"];
													$subtotal+=($producto["precio_usd_$cid"]*$car->getCantidad());
												}
										endif;
									?>
								</span>
							</span>
						</div>
					</li>
				<?php endif; ?>
				<?php if (!empty($car->getOfertaId())): ?>
					<?php $oferta = Doctrine::getTable('Oferta')->findOneBy('id', $car->getOfertaId()); ?>
					<li class="woocommerce-mini-cart-item mini_cart_item" id="car_item_<?php echo $car->getId(); ?>">
						<a href="#" class="remove remove_from_cart_button" aria-label="Eliminar este item" onclick="eliminar_item(<?php echo $car->getId(); ?>)">×</a>
						<a href="<?php echo url_for("@oferta") . "/" . $oferta->getId(); ?>" class="cart-item-image">
							<?php if (!empty($oferta->getUrlImagen())): ?>
								<img width="430" height="444" src="/uploads/oferta/<?php echo $oferta->getUrlImagen(); ?>" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" />
							<?php else: ?>
								<img width="430" height="444" src="/images/no-product.png" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" />
							<?php endif;?>
						</a>
						<div class="cart-info">
							<span class="product-title" style="text-transform: capitalize">
								<a href="<?php echo url_for("@oferta") . "/" . $oferta->getId(); ?>"><?php echo mb_strtolower($oferta->getNombre()); ?></a>
							</span>
							<span class="quantity"><?php echo $car->getCantidad(); ?> ×
								<span class="woocommerce-Price-amount amount">
									<?php 
										echo '<span class="woocommerce-Price-currencySymbol">$</span>'.$oferta["precio_usd"];
										$subtotal+=($oferta["precio_usd"]*$car->getCantidad());
									?>
								</span>
							</span>
						</div>
					</li>
				<?php endif; ?>
			<?php endforeach;?>
		</ul>
	</div>
</div>

<div class="shopping-cart-widget-footer">
	<p class="woocommerce-mini-cart__total total">
		<strong>Subtotal:</strong>
		<span class="woocommerce-Price-amount amount">
			<span class="woocommerce-Price-currencySymbol">$</span><?php echo number_format($subtotal, 2, ".", ""); ?>
		</span>
	</p>
	<p class="woocommerce-mini-cart__buttons buttons">
		<a href="<?php echo url_for("carrito"); ?>" class="button btn-cart wc-forward">Ver carrito</a>
		<a href="<?php echo url_for("carrito"); ?>/procesar" class="button checkout wc-forward">Realizar Orden</a>
	</p>
</div>

<script>
	jQuery(function($) {
		$( ".woodmart-cart-number2" ).each(function() {
			$(this).text("<?php echo $i; ?>");
		});
		$( ".woodmart-cart-tot2" ).each(function() {
			$(this).text("$<?php echo number_format($subtotal, 2, ".", ""); ?>");
		});
	});
</script>