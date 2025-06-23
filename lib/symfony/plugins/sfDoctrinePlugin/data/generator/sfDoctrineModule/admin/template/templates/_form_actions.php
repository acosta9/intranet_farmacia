<?php foreach (array('new', 'edit') as $action): ?>
  <?php if ('new' == $action): ?>
    [?php if ($form->isNew()): ?]
  <?php else: ?>
    [?php else: ?]
  <?php endif; ?>
  <?php foreach ($this->configuration->getValue($action.'.actions') as $name => $params): ?>
    <?php if ('_delete' == $name): ?>
      <div class="col-md-2  col-sm-12">
        <?php echo $this->addCredentialCondition('[?php echo $helper->linkToDelete($form->getObject(), '.$this->asPhp($params).') ?]', $params) ?>
      </div>
    <?php elseif ('_list' == $name): ?>
      <div class="col-md-2  col-sm-12">
        <?php echo $this->addCredentialCondition('[?php echo $helper->linkToList('.$this->asPhp($params).') ?]', $params) ?>
      </div>
    <?php elseif ('_new' == $name): ?>
      <div class="col-md-2  col-sm-12">
        <?php echo $this->addCredentialCondition('[?php echo $helper->linkToNew('.$this->asPhp($params).') ?]', $params) ?>
      </div>
    <?php elseif ('_save' == $name): ?>
      <div class="col-md-2  col-sm-12">
        <?php echo $this->addCredentialCondition('[?php echo $helper->linkToSave($form->getObject(), '.$this->asPhp($params).') ?]', $params) ?>
      </div>
    <?php elseif ('_save_and_add' == $name): ?>
      <div class="col-md-2  col-sm-12">
        <?php echo $this->addCredentialCondition('[?php echo $helper->linkToSaveAndAdd($form->getObject(), '.$this->asPhp($params).') ?]', $params) ?>
      </div>
    <?php elseif ('_show' == $name && 'new' != $action): ?>
      <div class="col-md-2  col-sm-12">
        <?php echo $this->addCredentialCondition('[?php echo $helper->linkToShow($form->getObject(), '.$this->asPhp($params).') ?]', $params) ?>
      </div>
    <?php elseif ('_homepage' == $name): ?>
      <div class="col-md-2  col-sm-12">
        <?php echo $this->addCredentialCondition('[?php echo $helper->linkToHomepage($form->getObject(), '.$this->asPhp($params).') ?]', $params) ?>
      </div>
    <?php else: ?>
      [?php if (method_exists($helper, 'linkTo<?php echo $method = ucfirst(sfInflector::camelize($name)) ?>')): ?]
        <?php echo $this->addCredentialCondition('[?php echo $helper->linkTo'.$method.'($form->getObject(), '.$this->asPhp($params).') ?]', $params) ?>
      [?php else: ?]
        <?php if ('_show' == $name && 'new' == $action): ?>
        <?php else: ?>
          
        <?php endif; ?>
      [?php endif; ?]
    <?php endif; ?>
  <?php endforeach; ?>
<?php endforeach; ?>
[?php endif; ?]
