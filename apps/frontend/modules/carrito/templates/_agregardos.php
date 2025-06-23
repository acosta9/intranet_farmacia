<p class="bold">Cantidad</p>
<div class="m-t-10 no-padding">

<?php echo form_tag('@carrito') ?>
	<?php echo $form->renderHiddenFields(false) ?>
	<div class="form-cart">
		<a id="min" style="cursor:pointer;" class="black"><i class="fa fa-minus fa-lg" aria-hidden="true"></i></a>
    <input name="carrito[cantidad]" id="quantity" value="1" min="1" max="9999999999" type="number"/>
    <a id="plus" style="cursor:pointer;" class="black"><i class="fa fa-plus fa-lg" aria-hidden="true"></i></a><br><br>
	</div>
	<input type="hidden" id="carrito_foodfit_id" name="carrito[foodfit_id]" value="<?php echo $foodfit_id ?>">
	<input type="hidden" id="carrito_sf_guard_user_id" name="carrito[sf_guard_user_id]" value="<?php if ($sf_user->isAuthenticated()) echo $sf_user->getGuardUser()->getId() ?>">

	<input type="submit" class="btn btn-susc" value="COMPRAR"/>

</form>
