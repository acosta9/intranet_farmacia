  [?php if (!$pager->getNbResults()): ?]
  <table class="table table-hover table-striped">
      <tbody>
          <tr>
            <td id="sin_resultados">[?php echo __('sin resultados', array(), 'sf_admin') ?]</td>
          </tr>
       </tbody>
  </table>
  [?php else: ?]
    <table class="table table-hover table-striped table-list">
        <thead>
          <tr role="row">
            [?php include_partial('<?php echo $this->getModuleName() ?>/list_th_<?php echo $this->configuration->getValue('list.layout') ?>', array('sort' => $sort)) ?]
          </tr>
        </thead>
         <tbody>
        [?php foreach ($pager->getResults() as $i => $<?php echo $this->getSingularName() ?>): $odd = fmod(++$i, 2) ? 'odd' : 'even' ?]
          <tr>
<?php if ($this->configuration->getValue('list.batch_actions')): ?>
            [?php include_partial('<?php echo $this->getModuleName() ?>/list_td_batch_actions', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'helper' => $helper)) ?]
<?php endif; ?>
            [?php include_partial('<?php echo $this->getModuleName() ?>/list_td_<?php echo $this->configuration->getValue('list.layout') ?>', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>)) ?]

          </tr>
        [?php endforeach; ?]
      </tbody>
    </table>
    <script type="text/javascript">
      $('a').each(function() {
          var $this = $(this),
          aHref = $this.attr('href');  //get the value of an attribute 'href'
          $this.attr('href', aHref.replace('/edit','/show')); //set the value of an attribute 'href'
      });
    </script>
  [?php endif; ?]
