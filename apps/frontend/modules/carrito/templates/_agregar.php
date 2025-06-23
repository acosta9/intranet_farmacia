<?php echo form_tag('@carrito', 'class=add-cart') ?>

<?php echo $form->renderHiddenFields(false) ?>

    <button type="submit" title="Agregar a carrito" class="cart alt"></button>
    <div class="quantity">
        <input type="number" step="1" min="1" name="carrito[cantidad]" value="1" title="Qty" class="input-text qty text" id="carrito_cantidad">
        <input type="hidden" id="carrito_producto_id" name="carrito[producto_id]" value="<?php echo $producto_id ?>">
        <input type="hidden" id="carrito_sf_guard_user_id" name="carrito[sf_guard_user_id]" value="<?php if ($sf_user->isAuthenticated()) echo $sf_user->getGuardUser()->getId() ?>">
    </div>
</form>
