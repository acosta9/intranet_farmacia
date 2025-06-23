<?php foreach ($this->configuration->getValue('list.display') as $name => $field): ?>
<?php
    if($field->getName()=="url_imagen") { ?>
        <?php echo $this->addCredentialCondition(sprintf(<<<EOF
<td class="sf_admin_%s sf_admin_list_td_%s">
[?php if (%s): ?]
  <img class='img-thumbnail' src='/uploads/[?php echo '%s' ?]/[?php echo %s ?]' width='50'/>
[?php else: ?]
    <img class='img-thumbnail' src='/images/user_icon.png'  width='50'/>
[?php endif; ?]
</td>
EOF
, strtolower($field->getType()), $name, $this->renderField($field), $this->getSingularName(), $this->renderField($field)), $field->getConfig()) ?>
    <?php } elseif($field->getName()=="adjunto") { ?>
<?php echo $this->addCredentialCondition(sprintf(<<<EOF
<td class="sf_admin_%s sf_admin_list_td_%s">
[?php if (%s): ?]
  [?php echo '<i class="fa fa-paperclip"></i>' ?]
[?php else: ?]
    [?php echo '' ?]
[?php endif; ?]
</td>
EOF
, strtolower($field->getType()), $name, $this->renderField($field)), $field->getConfig()) ?>
    <?php } elseif($field->getName()=="created_at" || $field->getName()=="updated_at") { ?>
<?php echo $this->addCredentialCondition(sprintf(<<<EOF
<td>
  [?php echo date("d/m/Y H:i", strtotime($%s)) ?]
</td>
EOF
, strtolower($this->getSingularName()."['".$name."']"))) ?>
    <?php }
    else {
?>
<?php if (isset($this->params['route_prefix']) && $this->params['route_prefix']): ?>
<?php echo $this->addCredentialCondition(sprintf(<<<EOF
<td>
  [?php echo %s ?]
</td>

EOF
, $this->renderField($field), $this->renderField($field)), $field->getConfig()) ?>
<?php endif; ?>
    <?php } ?>
<?php endforeach; ?>
