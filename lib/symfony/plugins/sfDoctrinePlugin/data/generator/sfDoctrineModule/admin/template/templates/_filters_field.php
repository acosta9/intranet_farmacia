[?php if ($field->isPartial()): ?]
  [?php include_partial('<?php echo $this->getModuleName() ?>/'.$name, array('type' => 'filter', 'form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?]
[?php elseif ($field->isComponent()): ?]
  [?php include_component('<?php echo $this->getModuleName() ?>', $name, array('type' => 'filter', 'form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?]
[?php else: ?]

<div class="col-md-3">
      [?php echo $form[$name]->renderError() ?]
        <div class="form-group" id='campo_[?php echo $name ?]'>
          <div class="filter_label">
            [?php echo $form[$name]->renderLabel($label) ?]
          </div>
          [?php
            $var=$field->getConfig();
            if (isset($var["tipo"])) {
              $tipo=$var["tipo"];
              switch ($tipo) {
                case "fecha_two":
                  echo "<div class='input-group'><div class='input-group-prepend'><span class='input-group-text'><i class='far fa-calendar-alt'></i></span></div>";
                  echo $form[$name]->render($attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes);
                  echo "<div class='container-fluid'><div class='row'><div class='col-md-1'></div><div class='col'>Desde:</div><div class='col'>Hasta:</div></div></div>";
                  echo "</div>";
                  break;
                default:
                  echo $form[$name]->render($attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes);
                  break;
              }
            } else {
              echo $form[$name]->render($attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes);
            }
          ?]
        </div>
      [?php if ($help || $help = $form[$name]->renderHelp()): ?]
        <div class="help">[?php echo __($help, array(), '<?php echo $this->getI18nCatalogue() ?>') ?]</div>
      [?php endif; ?]
</div>

[?php endif; ?]
