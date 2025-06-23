<?php if (!$pager->getNbResults()): ?>
	<div class="main-page-wrapper">
		<div class="page-title page-title-default title-size-default title-design-centered color-scheme-light" style="">
			<div class="container">
				<header class="entry-header">
					<div class="woodmart-checkout-steps">
						<ul>
							<li class="step-cart step-active">
								<a href="#">
									<span>Cesta de productos</span>
								</a>
							</li>
							<li class="step-checkout step-inactive">
								<a href="#">
									<span>Realizar orden</span>
								</a>
							</li>
							<li class="step-complete step-inactive">
								<span>Orden completa</span>
							</li>
						</ul>
					</div>
				</header>
			</div>
		</div>
		<div class="container">
			<div class="row content-layout-wrapper align-items-start">
				<div class="site-content col-lg-12 col-12 col-md-12" role="main">
					<article id="post-7" class="post-7 page type-page status-publish hentry">
						<div class="entry-content">
							<div class="woocommerce">
								<div class="woocommerce cart-content-wrapper row">
									<div class="woocommerce-notices-wrapper"></div>
										<div class="cart-table-section">
											<h3>Tu carrito esta vacio</h3>
										</div>
									</div>
								</div>
							</div>
						</div>
					</article>
				</div>
			</div>
		</div>
	</div>
<?php else: ?>
	<div class="main-page-wrapper">
		<div class="page-title page-title-default title-size-default title-design-centered color-scheme-light" style="">
			<div class="container">
				<header class="entry-header">
					<div class="woodmart-checkout-steps">
						<ul>
							<li class="step-cart step-active">
								<a href="#">
									<span>Cesta de productos</span>
								</a>
							</li>
							<li class="step-checkout step-inactive">
								<a href="#">
									<span>Realizar orden</span>
								</a>
							</li>
							<li class="step-complete step-inactive">
								<span>Orden completa</span>
							</li>
						</ul>
					</div>
				</header>
			</div>
		</div>
		<div class="container">
			<div class="row content-layout-wrapper align-items-start">
				<div class="site-content col-lg-12 col-12 col-md-12" role="main">
					<article id="post-7" class="post-7 page type-page status-publish hentry">
						<div class="entry-content">
							<div class="woocommerce">
								<div class="woocommerce cart-content-wrapper row">
									<div class="woocommerce-notices-wrapper"></div>
									<div class="cart-table-section col-12 col-lg-7 col-xl-8">
										<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
											<thead>
												<tr>
													<th class="product-remove">&nbsp;</th>
													<th class="product-thumbnail">&nbsp;</th>
													<th class="product-name">Producto</th>
													<th class="product-price">Precio</th>
													<th class="product-quantity">Cantidad</th>
													<th class="product-subtotal">Subtotal</th>
												</tr>
											</thead>
											<tbody>
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
													<tr class="woocommerce-cart-form__cart-item cart_item">
														<td class="product-remove">
															<a href="#" class="remove" aria-label="Eliminar este item" onclick="eliminar_item2(<?php echo $car->getId(); ?>)">×</a>								
														</td>
														<td class="product-thumbnail">
															<a href="<?php echo url_for("@producto")."/".$producto->getId(); ?>">
																<?php if (!empty($producto->getUrlImagen())): ?>
																	<img width="430" height="444" src="/uploads/producto/<?php echo $producto->getUrlImagen(); ?>" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" />
																<?php else: ?>
																	<img width="430" height="444" src="/images/no-product.png" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" />
																<?php endif;?>
															</a>								
														</td>
														<td class="product-name" data-title="Product">
															<a href="<?php echo url_for("@producto")."/".$producto->getId(); ?>" style="text-transform: capitalize">
																<?php echo mb_strtolower($producto->getNombre()); ?>
															</a>
														</td>
														<td class="product-price" data-title="Price">
															<span class="woocommerce-Price-amount amount">
																<?php 
																	if(!empty($cid=$sf_user->getGuardUser()->getTipoPrecio())):
																			if($producto["precio_usd_$cid"]>0) {
																				echo "$<span id='price_".$car->getId()."'>".number_format($producto["precio_usd_$cid"], 2, ".", "")."</span>";
																				$subtotal+=($producto["precio_usd_$cid"]*$car->getCantidad());
																				$subtotal2=($producto["precio_usd_$cid"]*$car->getCantidad());
																			}
																	endif;
																?>
															</span>								
														</td>
														<td class="product-quantity" data-title="Quantity">
															<div class="quantity">
																	<input type="button" value="-" class="minus">
																	<input type="number" id="qty_<?php echo $car->getId(); ?>" class="input-text qty text cantidad" step="1" min="0" max=""
																	value="<?php echo $car->getCantidad(); ?>" title="Qty" size="4" placeholder="" inputmode="numeric">
																	<input type="button" value="+" class="plus">
															</div>
														</td>
														<td class="product-subtotal" data-title="Subtotal">
															<span class="woocommerce-Price-amount amount">
																$<span class="price_sub" id="price_sub_<?php echo $car->getId(); ?>">
																	<?php echo number_format($subtotal2, 2, ".", ""); ?>
																</span>
															</span>								
														</td>
													</tr>
												<?php endif;?>
												<?php if (!empty($car->getOfertaId())):
														$oferta = Doctrine::getTable('Oferta')->findOneBy('id', $car->getOfertaId());
													?>
													<tr class="woocommerce-cart-form__cart-item cart_item">
														<td class="product-remove">
															<a href="#" class="remove" aria-label="Eliminar este item" onclick="eliminar_item2(<?php echo $car->getId(); ?>)">×</a>								
														</td>
														<td class="product-thumbnail">
															<a href="<?php echo url_for("@oferta")."/".$oferta->getId(); ?>">
																<?php if (!empty($oferta->getUrlImagen())): ?>
																	<img width="430" height="444" src="/uploads/oferta/<?php echo $oferta->getUrlImagen(); ?>" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" />
																<?php else: ?>
																	<img width="430" height="444" src="/images/no-product.png" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" />
																<?php endif;?>
															</a>								
														</td>
														<td class="product-name" data-title="Product">
															<a href="<?php echo url_for("@oferta")."/".$oferta->getId(); ?>" style="text-transform: capitalize">
																<?php echo mb_strtolower($oferta->getNombre()); ?>
															</a>
														</td>
														<td class="product-price" data-title="Price">
															<span class="woocommerce-Price-amount amount">
																<?php
																	echo "$<span id='price_".$car->getId()."'>".number_format($oferta["precio_usd"], 2, ".", "")."</span>";
																	$subtotal+=($oferta["precio_usd"]*$car->getCantidad());
																	$subtotal2=($oferta["precio_usd"]*$car->getCantidad());
																			
																?>
															</span>								
														</td>
														<td class="product-quantity" data-title="Quantity">
															<div class="quantity">
																	<input type="button" value="-" class="minus">
																	<input type="number" id="qty_<?php echo $car->getId(); ?>" class="input-text qty text cantidad" step="1" min="0" max=""
																	value="<?php echo $car->getCantidad(); ?>" title="Qty" size="4" placeholder="" inputmode="numeric">
																	<input type="button" value="+" class="plus">
															</div>
														</td>
														<td class="product-subtotal" data-title="Subtotal">
															<span class="woocommerce-Price-amount amount">
																$<span class="price_sub" id="price_sub_<?php echo $car->getId(); ?>">
																	<?php echo number_format($subtotal2, 2, ".", ""); ?>
																</span>
															</span>								
														</td>
													</tr>
												<?php endif;?>
												<?php endforeach; ?>
											</tbody>
										</table>
										<div class="row cart-actions">
											<div class="col-12 order-last order-md-first col-md">
												<div class="coupon">
													<a href="<?php echo url_for("carrito"); ?>" class="button" name="apply_coupon" value="Apply coupon">Actualizar Carrito</a>
												</div>
											</div>
										</div>
									</div>
									<div class="cart-totals-section col-12 col-lg-5 col-xl-4">
										<div class="cart_totals ">
											<div class="cart-totals-inner">
												<h2>Totales de la orden</h2>
												<table cellspacing="0" class="shop_table shop_table_responsive">
													<tbody>
														<tr class="order-total">
															<th>Total</th>
															<td data-title="Total">
																<strong>
																	<span class="woocommerce-Price-amount amount">
																		<span class="woocommerce-Price-currencySymbol">$</span>
																		<span id="total_total"><?php echo number_format($subtotal, 2, ".", ""); ?></span>
																	</span>
																</strong>
															</td>
														</tr>
													</tbody>
												</table>
												<div class="wc-proceed-to-checkout">
													<a href="<?php echo url_for("carrito"); ?>/procesar" class="checkout-button button alt wc-forward">
														Proceeder a realizar orden
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="cart-collaterals"></div>
							</div>
						</div>
					</article>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>

<script>
	jQuery(function($) {
		$(".cantidad").on("change", function () {
			var id = $(this).attr('id');
			var price = $("#price_"+id.substr(4)).text();
			var price_new=parseFloat(this.value)*parseFloat(price);
			$("#price_sub_"+id.substr(4)).text(Math.round(price_new*100)/100);
			$.get("<?php echo url_for('carrito/actualizarItem') ?>?id="+id.substr(4)+"&cantidad="+this.value, function(contador) {
				console.log(contador);
				update_cart();
			});
			var subtotal=0;
			$( ".price_sub" ).each(function() {
				var subn = $(this).text();
				subtotal+=parseFloat(subn);
			});
			$("#total_total").text(Math.round(subtotal*100)/100);
			//update_cart();
		});
	});
	function eliminar_item2(id) {
		jQuery(function($) {
			$.get("<?php echo url_for('carrito/eliminarItem') ?>?id="+id, function(contador) {
				location.reload();
			});
		});
	}
</script>