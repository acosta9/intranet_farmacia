<?php
  /** @var Array of menu items */ $items = $sf_data->getRaw('items');
?>

<?php foreach ($items as $key => $item): ?>
  <?php if (sfAdminDash::hasPermission($item, $sf_user)): ?>
    <?php if (($items_in_menu && $item['in_menu']) || (!$items_in_menu && !$item['in_menu'])): ?>
      <li class="nav-item">
        <a href="<?php echo url_for($item['url']) ?>" title="<?php echo $item['name']; ?>" class="nav-link" id='child<?php echo strtolower(preg_replace("/[^a-zA-Z]/", "", $item['name'])); ?>'>
          <i class="far fa-circle nav-icon"></i>
          <p><?php echo $item['name']; ?></p>
        </a>
      </li>
    <?php endif; ?>
  <?php endif; ?>
<?php endforeach; ?>
