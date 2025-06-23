
<div class="row">
    <div class=" col-xs-12 col-md-12 form-search">
        <div class="box" style="border: none !important;">
            <div class="box-body no-padding">
                <?php if ($form->hasGlobalErrors()): ?>
                  <?php echo $form->renderGlobalErrors() ?>
                <?php endif; ?>

                <form action="<?php echo url_for('producto_collection', array('action' => 'filter')) ?>" method="post">
                  <table  >
                    <tfoot>
                      <tr>
                        <td>
                          <?php echo $form->renderHiddenFields() ?>
                          <?php echo link_to(__('Limpiar ', array(), 'sf_admin'), 'producto_collection', array('action' => 'filter'), array('query_string' => '_reset', 'method' => 'post', 'class' => 'btn btn-clean', 'style' => 'width: 49% !important; height: 35px;')) ?>
                          <input style="margin: 0px !important; width: 49% !important" class="btn btn-susc" type="submit" value="<?php echo __('Buscar', array(), 'sf_admin') ?>" />
                        </td>
                      </tr>
                    </tfoot>
                    <tbody>
                      <?php foreach ($configuration->getFormFilterFields($form) as $name => $field): ?>
                      <?php if ((isset($form[$name]) && $form[$name]->isHidden()) || (!isset($form[$name]) && $field->isReal())) continue ?>
                        <?php include_partial('producto/filters_field', array(
                          'name'       => $name,
                          'attributes' => $field->getConfig('attributes', array()),
                          'label'      => $field->getConfig('label'),
                          'help'       => $field->getConfig('help'),
                          'form'       => $form,
                          'field'      => $field,
                          'class'      => 'sf_admin_form_row sf_admin_'.strtolower($field->getType()).' sf_admin_filter_field_'.$name,
                        )) ?>
                      <?php endforeach; ?>
											<tr>
												<td>
													<div class="filter_label" style="padding:10px 0 0 10px;">
														<label for="producto_filters_producto_tipo_id">Precio</label>
													</div>
												</td>
											</tr>
											<tr>
										    <td style="border-top: none; padding-top: 0px; padding-bottom: 30px;">
													<div class="dropdown search" id="mydiv">
								            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
								                Selecciona orden de precio <span class="caret"></span>
								            </button>
								            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
								              <li><a href="<?php echo url_for("producto")?>?sort=precio&sort_type=desc">Mayor a Menor</a></li>
															<li><a href="<?php echo url_for("producto")?>?sort=precio&sort_type=asc">Menor a Mayor</a></li>
								            </ul>
								          </div>
												</td>
										  </tr>
                    </tbody>
                  </table>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
$("#producto_filters_producto_cat_id").addClass("empty");
$("#producto_filters_producto_tipo_id").addClass("empty");
$("#producto_filters_producto_marca_id").addClass("empty");

$("#producto_filters_producto_cat_id").change(function () {
    if(!$(this).val()){
			$(this).addClass("empty");
		} else {
			$(this).removeClass("empty");
		}
});

$("#producto_filters_producto_tipo_id").change(function () {
    if(!$(this).val()){
			$(this).addClass("empty");
		} else {
			$(this).removeClass("empty");
		}
});

$("#producto_filters_producto_marca_id").change(function () {
    if(!$(this).val()) {
			$(this).addClass("empty");
		} else {
			$(this).removeClass("empty");
		}
});

$("#producto_filters_producto_cat_id").parent().append("<span class='caret'></span>");
$("#producto_filters_producto_tipo_id").parent().append("<span class='caret'></span>");
$("#producto_filters_producto_marca_id").parent().append("<span class='caret'></span>");

</script>
