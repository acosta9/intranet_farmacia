<span class="per-page-title">Pagina</span> 
  <?php foreach ($pager->getLinks() as $page): ?>
    <?php if ($page == $pager->getPage()): ?>
      <a rel="nofollow" href="<?php echo url_for('@nota_entrega') ?>?page=<?php echo $page ?>" class="per-page-variation current-variation"> 
        <span><?php echo $page ?></span>
      </a>
    <?php else: ?>
      <a rel="nofollow" href="<?php echo url_for('@nota_entrega') ?>?page=<?php echo $page ?>" class="per-page-variation"> 
        <span><?php echo $page ?></span>
      </a>
    <?php endif; ?>
  <?php endforeach; ?>