<div class="dataTables_paginate paging_simple_numbers float-md-right" style="padding-right: 1.5rem!important;">
  <ul class="pagination">

    <li class="paginate_button page-item previous">
      <a href="[?php echo url_for('@<?php echo $this->getUrlForAction('list') ?>') ?]?page=[?php echo $pager->getPreviousPage() ?]" class="page-link">Anterior</a>
    </li>

    [?php foreach ($pager->getLinks() as $page): ?]
      [?php if ($page == $pager->getPage()): ?]
        <li class="paginate_button page-item active">
          <a href="#" class="page-link">[?php echo $page; ?]</a>
        </li>
      [?php else: ?]
        <li class="paginate_button page-item">
          <a href="[?php echo url_for('@<?php echo $this->getUrlForAction('list') ?>') ?]?page=[?php echo $page ?]" class="page-link">[?php echo $page; ?]</a>
        </li>
      [?php endif; ?]
    [?php endforeach; ?]

    <li class="paginate_button page-item next">
      <a href="[?php echo url_for('@<?php echo $this->getUrlForAction('list') ?>') ?]?page=[?php echo $pager->getNextPage() ?]" class="page-link">Siguiente</a>
    </li>
  </ul>
</div>
