<div class="card card-primary" id="sf_fieldset_[?php echo preg_replace('/[^a-z0-9_]/', '_', strtolower($fieldset)) ?]">
  [?php if ('NONE' != $fieldset): ?]
    <div class="card-header">
      <h3 class="card-title">[?php echo __($fieldset, array(), '<?php echo $this->getI18nCatalogue() ?>') ?]</h3>
    </div>
  [?php endif; ?]
  <div class="card-body">
    <div class="row">
      [?php foreach ($fields as $name => $field): ?]
        [?php if ((isset($form[$name]) && $form[$name]->isHidden()) || (!isset($form[$name]) && $field->isReal())) continue ?]
          [?php include_partial('<?php echo $this->getModuleName() ?>/form_field', array(
            'name'       => $name,
            'attributes' => $field->getConfig('attributes', array()),
            'label'      => $field->getConfig('label'),
            'help'       => $field->getConfig('help'),
            'form'       => $form,
            'field'      => $field,
            'class'      => 'form-group sf_admin_'.strtolower($field->getType()).' sf_admin_form_field_'.$name,
          )) ?]
      [?php endforeach; ?]
    </div>
  </div>
</div>
