<?php foreach ($this->configuration->getValue('list.display') as $name => $field): ?>
[?php slot('sf_admin.current_header') ?]
<th class="th_admin sf_admin_<?php echo strtolower($field->getType()) ?> sf_admin_list_th_<?php echo $name ?>">

<?php if ($field->isReal()): ?>
  [?php if ('<?php echo $name ?>' == $sort[0]): ?]
    [?php echo link_to(__('<?php echo $field->getConfig('label', '', true) ?>', array(), '<?php echo $this->getI18nCatalogue() ?>'), '@<?php echo $this->getUrlForAction('list') ?>', array('query_string' => 'sort=<?php echo $name ?>&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?]

    [?php if($sort[1]=="desc"): ?]
      <i class="fas fa-sort-alpha-up-alt"  style="color: #1987fe;"></i>
    [?php else: ?]
      <i class="fas fa-sort-alpha-down" style="color: #1987fe;"></i>
    [?php endif; ?]

  [?php else: ?]
    [?php echo link_to(__('<?php echo $field->getConfig('label', '', true) ?>', array(), '<?php echo $this->getI18nCatalogue() ?>'), '@<?php echo $this->getUrlForAction('list') ?>', array('query_string' => 'sort=<?php echo $name ?>&sort_type=asc')) ?]
    <i class="fas fa-sort" style="color: #1987fe;"></i>
  [?php endif; ?]
<?php else: ?>
  [?php echo __('<?php echo $field->getConfig('label', '', true) ?>', array(), '<?php echo $this->getI18nCatalogue() ?>') ?]
<?php endif; ?>
</th>
[?php end_slot(); ?]
<?php echo $this->addCredentialCondition("[?php include_slot('sf_admin.current_header') ?]", $field->getConfig()) ?>
<?php endforeach; ?>
