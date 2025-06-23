[?php use_helper('I18N', 'Date') ?]
[?php include_partial('<?php echo $this->getModuleName() ?>/assets') ?]

<?php
  $var=$this->getI18NString('list.title');
  $var=str_replace("__('", "", $var);
  $var= str_replace("', array(), 'messages')", "", $var);
  list($var1,$var2,$var3) = explode("nn", $var);
?>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1><?php echo $var1; ?> <small style="font-size: 60%;"><?php echo $var2; ?></small></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="[?php echo url_for('homepage') ?]">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="[?php echo url_for('<?php echo trim($var3); ?>') ?]"><?php echo $var1; ?></a></li>
          <li class="breadcrumb-item active"><?php echo $var2; ?></li>
        </ol>
      </div>
    </div>
  </div>
</section>


<?php if ($this->configuration->hasFilterForm()): ?>
  <section class="content" id="filtros" style="display: none">
    <div class="container-fluid">
      <div class="card card-default">
        <div class="card-body">
          <div id="prod_hidden" style="display:none">[?php if(!empty($prods)) { echo $prods; } ?]</div>
          <div id="comp_hidden" style="display:none">[?php if(!empty($comps)) { echo $comps; } ?]</div>
          <div id="lab_hidden" style="display:none">[?php if(!empty($labs)) { echo $labs; } ?]</div>
          [?php include_partial('<?php echo $this->getModuleName() ?>/filters', array('form' => $filters, 'configuration' => $configuration)) ?]
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>

<section class="content">
  <div class="container-fluid">
    <div class="card card-default">
      <div class="card-header" style="padding: 0.75rem 1.25rem 0rem 1.25rem">
        <div class="row">
          <div class="col-md-2 col-sm-12">
              [?php include_partial('<?php echo $this->getModuleName() ?>/list_actions', array('helper' => $helper)) ?]
          </div>
          <div class="col-md-10 col-sm-12">
            <div class="row float-sm-right">
              <div class="filter">
                [?php include_partial('<?php echo $this->getModuleName() ?>/list_batch_actions', array('helper' => $helper)) ?]
              </div>
              <div class="filter">
                <a class="btn btn-default btn-block btn-align" href="#" id="boton_filtro">
                  <i class="fas fa-filter"></i>
                  BUSQUEDA
                </a>
                <script>
                    $('#boton_filtro').on('click', function(e) {
                      $('#filtros').fadeToggle( "slow", "linear" );
                    });
                </script>
              </div>
              <div>
                [?php include_partial('<?php echo $this->getModuleName() ?>/pagination_list_select', array( 'pager' => $pager)) ?]
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body table-responsive p-0" style="border-bottom: 1px solid rgba(0,0,0,.125);">
        [?php include_partial('<?php echo $this->getModuleName() ?>/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?]
      </div>
      <div class="row mt-2 mb-2">
        <div class="col-sm-12 col-md-5">
          <div class="dataTables_info" id="example1_info" role="status" aria-live="polite" style="padding-left: 1.5rem!important;">
            [?php echo format_number_choice('[0] sin resultados |[1] 1 resultado|(1,+Inf] %1% registros en total', array('%1%' => $pager->getNbResults()), $pager->getNbResults(), 'sf_admin') ?]
          </div>
        </div>

        <div class="col-sm-12 col-md-7">
          [?php if ($pager->haveToPaginate()): ?]
            [?php include_partial('<?php echo $this->getModuleName() ?>/pagination', array('pager' => $pager)) ?]
          [?php endif; ?]
        </div>
      </div>
    </div>
  </div>
</section>
<script>
  $(document).ready(function() {
    $('#loading').fadeOut( "slow", function() {});
  });
</script>