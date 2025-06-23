[?php if ($field->isPartial()): ?]
  [?php include_partial('<?php echo $this->getModuleName() ?>/'.$name, array('form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?]
[?php elseif ($field->isComponent()): ?]
  [?php include_component('<?php echo $this->getModuleName() ?>', $name, array('form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?]
[?php else: ?]
<div class="col-md-3 col-sm-12">
  <div class="form-group">

      <label class="col-sm-12 control-label">[?php echo $label ?]</label>
      [?php if(strtolower($label)=="avatar"): ?]
        <div class="col-sm-12 foto2">
      [?php else: ?]
        <div class="col-sm-12">
      [?php endif; ?]
        [?php echo $form[$name]->render($attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes) ?]
        [?php echo $form[$name]->renderError() ?]

        [?php if ($help): ?]
          <p class="help-block">[?php echo __($help, array(), '<?php echo $this->getI18nCatalogue() ?>') ?]</p>
        [?php elseif ($help = $form[$name]->renderHelp()): ?]
          <p class="help-block">[?php echo $help ?]</p>
        [?php endif; ?]
      </div>
  </div>
</div>
[?php endif; ?]
