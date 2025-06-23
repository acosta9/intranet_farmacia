<?php foreach ($this->configuration->getValue('show.actions') as $name => $params): ?>
  <?php if ('_list' == $name): ?>
    <div class="col-md-2  col-sm-12">
      <?php echo $this->addCredentialCondition('[?php echo $helper->linkToList('.$this->asPhp($params).') ?]', $params) ?>
    </div>
  <?php elseif ('_edit' == $name): ?>
    <div class="col-md-2  col-sm-12">
      <?php echo $this->addCredentialCondition('[?php echo $helper->linkToEdit($'.$this->getSingularName().', '.$this->asPhp($params).') ?]', $params) ?>
    </div>
  <?php elseif ('_new' == $name): ?>
    <div class="col-md-2  col-sm-12">
      <?php echo $this->addCredentialCondition('[?php echo $helper->linkToNew('.$this->asPhp($params).') ?]', $params) ?>
    </div>
  <?php elseif ('_delete' == $name): ?>
    <div class="col-md-2  col-sm-12">
      <?php echo $this->addCredentialCondition('[?php echo $helper->linkToDelete($form->getObject(), '.$this->asPhp($params).') ?]', $params) ?>
    </div>
  <?php elseif ('_homepage' == $name): ?>
    <div class="col-md-2  col-sm-12">
      <?php echo $this->addCredentialCondition('[?php echo $helper->linkToHomepage($form->getObject(), '.$this->asPhp($params).') ?]', $params) ?>
    </div>
  <?php else: ?>
    <li class="sf_admin_action_<?php echo $params['class_suffix'] ?>">
      [?php if (method_exists($helper, 'linkTo<?php echo $method = ucfirst(sfInflector::camelize($name)) ?>')): ?]
        <?php echo $this->addCredentialCondition('[?php echo $helper->linkTo'.$method.'($this->getSingularName(), '.$this->asPhp($params).') ?]', $params) ?>
      [?php else: ?]
        <?php echo $this->addCredentialCondition($this->getLinkToAction($name, $params, true), $params) ?>
      [?php endif; ?]
    </li>
  <?php endif; ?>
<?php endforeach; ?>
