  [?php
    $currentSearch = $sf_user->getAttribute('<?php echo $this->getModuleName(); ?>'.'.search', '', 'admin_module');
    printf('<form action="%s" method="get">', url_for('@<?php echo $this->getUrlForAction('list') ?>'));
    printf('<div class="input-group mb-3"><input id="module_search_input" class="form-control input-sm" type="text" title="%s" value="%s" name="search" placeholder="Busqueda rapida"/><div class="input-group-append"><span class="input-group-text"><i class="fas fa-search"></i></span></div></div>',
      __('Buscar en ') . '<?php echo $this->getModuleName() ?>',
      $currentSearch
    );
    printf('<span class="glyphicon glyphicon-search form-control-feedback"></span>');
  ?]
  </form>
