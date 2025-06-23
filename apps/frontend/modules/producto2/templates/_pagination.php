<ul class="pagination">
  <li class="before">
    <a href="<?php echo url_for('@producto') ?>?page=<?php echo $pager->getPreviousPage() ?>" class="before">
      <i class="fa fa-angle-left fa-2x" aria-hidden="true"></i>
    </a>
  </li>
  <?php foreach ($pager->getLinks() as $page): ?>
    <?php if ($page == $pager->getPage()): ?>
      <li class="active pagination-number"><a href="<?php echo url_for('@producto') ?>?page=<?php echo $page ?>"><?php echo $page ?></a></li>
    <?php else: ?>
      <li class="pagination-number"><a href="<?php echo url_for('@producto') ?>?page=<?php echo $page ?>"><?php echo $page ?></a></li>
    <?php endif; ?>
  <?php endforeach; ?>
  <li class="next">
    <a href="<?php echo url_for('@producto') ?>?page=<?php echo $pager->getNextPage() ?>" class="next">
      <i class="fa fa-angle-right fa-2x" aria-hidden="true"></i>
    </a>
  </li>

</div>
