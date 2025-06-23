<?php $inventario=Doctrine::getTable('Inventario')->findOneBy('id',$inventario_id); ?>
<?php if($inventario->getActivo()==0 || $inventario->getCantidad()<=0): ?>
	<div class="product-labels labels-rectangular" style="position: inherit; margin-bottom: 10px;">
		<span class="featured product-label" style="font-size: 1rem">Agotado</span>
	</div>
<?php else: ?>
	<?php if($sf_user->isAuthenticated()): ?>
		<?php echo form_tag('@carrito', 'id=carritotres') ?>
			<?php echo $form->renderHiddenFields(false) ?>
			<div class="quantity">
				<input type="button" value="-" class="minus">
				<input type="number" name="carrito[cantidad]" id="quantity" class="input-text qty text" step="1" min="1" max="9999999999" 
				value="1" title="Qty" size="4" placeholder="" inputmode="numeric">
				<input type="button" value="+" class="plus">
			</div>

			<input type="hidden" id="carrito_inventario_id" name="carrito[inventario_id]" value="<?php echo $inventario_id ?>">
			<input type="hidden" id="carrito_sf_guard_user_id" name="carrito[sf_guard_user_id]" value="<?php if ($sf_user->isAuthenticated()) echo $sf_user->getGuardUser()->getId() ?>">

			<input type="submit" class="single_add_to_cart_button button alt" value="AGREGAR AL CARRITO"/>
		</form>
		<p><b>DISPONIBILIDAD:</b> <?php echo round(($inventario->getCantidad()/2)); ?> Unit(s)</p>
	<?php endif; ?>
<?php endif; ?>
<script type="text/javascript">
  jQuery(function($) {
		$("#carritotres").submit(function(event) {
			$.ajax({
				type: $(this).attr('method'),
				url: $(this).attr('action'),
				data: $(this).serialize(),
				success: function(responseText) {
					console.log(responseText);
				}
      });
			if($("#cart-widget-side").hasClass("woodmart-cart-opened")) {
				console.log("already open");
			} else {
				$("#btn_cart").click();
			}
			setTimeout(function(){
				update_cart();
			}, 200);
			//update_cart();
			event.preventDefault();
		});
	});
</script>