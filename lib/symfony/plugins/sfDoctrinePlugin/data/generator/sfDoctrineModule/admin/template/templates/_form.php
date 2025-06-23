[?php use_stylesheets_for_form($form) ?]
[?php use_javascripts_for_form($form) ?]
[?php use_helper('jQuery') ?]

[?php echo $form->renderHiddenFields(false) ?]

[?php if ($form->hasGlobalErrors()): ?]
  [?php echo $form->renderGlobalErrors() ?]
[?php endif; ?]

[?php foreach ($configuration->getFormFields($form, $form->isNew() ? 'new' : 'edit') as $fieldset => $fields): ?]
  [?php include_partial('<?php echo $this->getModuleName() ?>/form_fieldset', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'fields' => $fields, 'fieldset' => $fieldset)) ?]
[?php endforeach; ?]


<script type="text/javascript">
$(document).ready(function(){
	$(':checkbox[readonly=readonly]').click(function(){
		return false;
	});
});
</script>
