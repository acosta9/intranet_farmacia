[?php use_stylesheets_for_form($form) ?]
[?php use_javascripts_for_form($form) ?]

  [?php if ($form->hasGlobalErrors()): ?]
    [?php echo $form->renderGlobalErrors() ?]
  [?php endif; ?]

  <form action="[?php echo url_for('<?php echo $this->getUrlForAction('collection') ?>', array('action' => 'filter')) ?]" method="post" id="form_filter">
    [?php echo $form->renderHiddenFields() ?]

    <div class="row">
    [?php foreach ($configuration->getFormFilterFields($form) as $name => $field): ?]
        [?php if ((isset($form[$name]) && $form[$name]->isHidden()) || (!isset($form[$name]) && $field->isReal())) continue ?]
          [?php include_partial('<?php echo $this->getModuleName() ?>/filters_field', array(
            'name'       => $name,
            'attributes' => $field->getConfig('attributes', array()),
            'label'      => $field->getConfig('label'),
            'help'       => $field->getConfig('help'),
            'form'       => $form,
            'field'      => $field,
            'class'      => 'sf_admin_form_row sf_admin_'.strtolower($field->getType()).' sf_admin_filter_field_'.$name,
      )) ?]
    [?php endforeach; ?]
    </div>
    <div class="row float-sm-right">
      [?php echo link_to(__('LIMPIAR BUSQUEDA', array(), 'sf_admin'), '<?php echo $this->getUrlForAction('collection') ?>', array('action' => 'filter'), array('query_string' => '_reset', 'method' => 'post', 'class' => 'btn btn-default')) ?]
      <input class="btn btn-primary ml-3" type="submit" value="[?php echo __('BUSCAR', array(), 'sf_admin') ?]" />
    </div>
  </form>
