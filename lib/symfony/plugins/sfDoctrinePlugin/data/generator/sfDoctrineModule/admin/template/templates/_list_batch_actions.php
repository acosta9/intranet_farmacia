<?php if ($listActions = $this->configuration->getValue('list.batch_actions')): ?>
  <div class="btn-group">
    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="padding: .345rem .75rem; margin-top: 0.05rem;">+ OPCIONES</button>
    <div class="dropdown-menu" role="menu" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(68px, -2px, 0px);">
      <?php foreach ((array) $listActions as $action => $params): ?>
        <?php echo $this->addCredentialCondition('<a target="'.$params['target'].'" class="dropdown-item" href="'.$this->getUrlForAction('list').'/'.$action.'">'.$params['label'].'</a>', $params) ?>
      <?php endforeach; ?>
    </div>
  </div>
<?php endif; ?>
