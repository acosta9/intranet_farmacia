<?php if ($form->hasGlobalErrors()): ?>
  <?php echo $form->renderGlobalErrors() ?>
<?php endif; ?>

<form action="<?php echo url_for('oferta_collection', array('action' => 'filter')) ?>" method="post">
  <table  style="width: 100%">
    <tfoot>
      <tr>
        <td>
          <?php echo $form->renderHiddenFields() ?>
          <?php echo link_to(__('Limpiar ', array(), 'sf_admin'), 'oferta_collection', array('action' => 'filter'), array('query_string' => '_reset', 'method' => 'post', 'class' => 'button', 'style' => '')) ?>
          <input style="float: right; background-color: #add31c; color: #fff;" class="button checkout wc-forward" type="submit" value="<?php echo __('Buscar', array(), 'sf_admin') ?>" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php foreach ($configuration->getFormFilterFields($form) as $name => $field): ?>
      <?php if ((isset($form[$name]) && $form[$name]->isHidden()) || (!isset($form[$name]) && $field->isReal())) continue ?>
        <?php include_partial('oferta/filters_field', array(
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
        <td style="border-top: none; padding-top: 0px; padding-bottom: 30px;">
          <div class="woodmart-woocommerce-layered-nav-17">
            <div id="wd-widget-stock-status-2" class="woodmart-widget widget sidebar-widget wd-widget-stock-status" style="margin-top: 1rem;">
              <h5 class="widget-title">PRECIO</h5>
              <ul>
                <li><a href="<?php echo url_for("oferta")?>?sort=precio_usd&sort_type=desc" class=""> Mayor a Menor </a></li>
                <li><a href="<?php echo url_for("oferta")?>?sort=precio_usd&sort_type=asc" class=""> Menor a Mayor </a></li>
              </ul>
            </div>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</form>
<style>
  #oferta_filters_categoria_id {
    height: 140px;
  }
</style>