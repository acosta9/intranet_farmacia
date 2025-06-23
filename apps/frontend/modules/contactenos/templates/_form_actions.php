<ul class="sf_admin_actions" id="sf_admin_actions">
<?php if ($form->isNew()): ?>

  
  
  <?php echo $helper->linkToSave($form->getObject(), array(  'label' => 'Enviar',  'params' =>   array(  ),  'class_suffix' => 'save',)) ?>
  
<?php else: ?>
  
  
  <?php echo $helper->linkToList(array(  'label' => 'Inicio',  'params' =>   array(  ),  'class_suffix' => 'list',)) ?>  
  
  <?php echo $helper->linkToSave($form->getObject(), array(  'label' => 'Guardar',  'params' =>   array(  ),  'class_suffix' => 'save',)) ?>
  
<?php endif; ?>
</ul>