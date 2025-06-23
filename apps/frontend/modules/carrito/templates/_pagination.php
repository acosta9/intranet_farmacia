<div class="sf_admin_pagination">
  <a href="<?php echo url_for('@carrito') ?>?page=1">
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/first.png', array('alt' => __('Primera pagina', array(), 'sf_admin'), 'title' => __('Primera pagina', array(), 'sf_admin'))) ?>
  </a>

  <a href="<?php echo url_for('@carrito') ?>?page=<?php echo $pager->getPreviousPage() ?>">
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/previous.png', array('alt' => __('Pagina anterior', array(), 'sf_admin'), 'title' => __('Pagina anterior', array(), 'sf_admin'))) ?>
  </a>

  <?php foreach ($pager->getLinks() as $page): ?>
    <?php if ($page == $pager->getPage()): ?>
      <?php echo $page ?>
    <?php else: ?>
      <a href="<?php echo url_for('@carrito') ?>?page=<?php echo $page ?>"><?php echo $page ?></a>
    <?php endif; ?>
  <?php endforeach; ?>

  <a href="<?php echo url_for('@carrito') ?>?page=<?php echo $pager->getNextPage() ?>">
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/next.png', array('alt' => __('Proxima pagina', array(), 'sf_admin'), 'title' => __('Proxima pagina', array(), 'sf_admin'))) ?>
  </a>

  <a href="<?php echo url_for('@carrito') ?>?page=<?php echo $pager->getLastPage() ?>">
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/last.png', array('alt' => __('Ultima pagina', array(), 'sf_admin'), 'title' => __('Ultima pagina', array(), 'sf_admin'))) ?>
  </a>
</div>
