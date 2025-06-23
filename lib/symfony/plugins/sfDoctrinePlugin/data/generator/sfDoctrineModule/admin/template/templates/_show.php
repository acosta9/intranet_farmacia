
[?php use_helper('I18N', 'Date') ?]
[?php if (has_component_slot('show_header')) include_component_slot('show_header') ?]
[?php include_partial('<?php echo $this->getModuleName() ?>/show_header', array( '<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'helper' => $helper)) ?]

[?php foreach ($configuration->getFormFields($form, 'show') as $fieldset => $fields): ?]
<div class="card card-primary" id="sf_fieldset_[?php echo preg_replace('/[^a-z0-9_]/', '_', strtolower($fieldset)) ?]">
  <div class="card-header">
    <h3 class="card-title">[?php echo ('NONE' != $fieldset) ?   __($fieldset, array(), '<?php echo $this->getI18nCatalogue() ?>') : ''  ?]</h3>
  </div>
  <div class="card-body">
    <div class="row">
      [?php foreach ($fields as $name => $field): ?]
  		    [?php $attributes = $field->getConfig('attributes', array()); ?]
          [?php if ($field->isPartial()): ?]
            [?php include_partial('<?php echo $this->getModuleName() ?>/'.$name, array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?]
          [?php elseif ($field->isComponent()): ?]
  		      [?php include_component('<?php echo $this->getModuleName() ?>', $name, array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?]
  		    [?php else: ?]
          <div class="col-md-3 col-sm-12">
            <div class="form-group">
              <label>[?php echo $field->getConfig('label')? $field->getConfig('label'): $field->getName() ?]:</label>
            [?php if (($field->getConfig('tipo')=="url_imagen")): ?]
              [?php if ($form->getObject()->get($name)): ?]
                <div class="col-sm-12">
                  <a class="thumbnail" href='#' data-toggle="modal" data-target="#exampleModal">
                    <img class="foto2_show" src='/uploads/<?php echo $this->getSingularName() ?>/[?php echo $form->getObject()->get($name) ? $form->getObject()->get($name) : "&nbsp;" ?]' />
                  </a>
                </div>
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Img Thumbnail</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body" style="text-align: center">
                        <img src='/uploads/<?php echo $this->getSingularName() ?>/[?php echo $form->getObject()->get($name) ? $form->getObject()->get($name) : "&nbsp;" ?]' />
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                      </div>
                    </div>
                  </div>
                </div>
              [?php else: ?]
                <div class="col-sm-12">
                  <a class="thumbnail" href='#' data-toggle="modal" data-target="#exampleModal">
                    <img class="foto2_show" src='/images/user_icon.png' />
                  </a>
                </div>
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Img Thumbnail</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body" style="text-align: center">>
                        <img src='/images/user_icon.png' />
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                      </div>
                    </div>
                  </div>
                </div>
              [?php endif; ?]
            [?php elseif($field->getConfig('tipo')=="checkbox_tag"): ?]
              [?php if ($form->getObject()->get($name)): ?]
                <input type="text" class="form-control is-valid" value="SI" readonly>
              [?php else: ?]
                <input type="text" class="form-control is-invalid" value="NO" readonly>
              [?php endif; ?]
            [?php elseif($form->getObject()->get($name)==""): ?]
            <br/>
            [?php else: ?]
              <input type="text" value='[?php echo $form->getObject()->get($name) ? $form->getObject()->get($name) : "&nbsp;" ?]' class="form-control" readonly="">
            [?php endif; ?]
          </div>
        </div>
          [?php endif; ?]

      [?php endforeach; ?]
    </div>
  </div>
</div>
[?php endforeach; ?]

[?php include_partial('<?php echo $this->getModuleName() ?>/show_footer', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'helper' => $helper)) ?]
[?php if (has_component_slot('show_footer')) include_component_slot('show_footer') ?]
<script>
  $(document).ready(function() {
    $('#loading').fadeOut( "slow", function() {});
  });
</script>