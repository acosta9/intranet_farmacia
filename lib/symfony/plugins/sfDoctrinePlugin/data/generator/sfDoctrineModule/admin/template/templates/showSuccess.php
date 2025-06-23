[?php use_helper('I18N', 'Date') ?]
[?php include_partial('<?php echo $this->getModuleName() ?>/assets') ?]

<?php
  $var=$this->getI18NString('show.title');
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

<section class="content">
  <div class="container-fluid">
    <div class="card card-default">
      <div class="card-header" style="padding: 0.75rem 1.25rem 0rem 1.25rem">
        <div class="row">
          <div class="col-md-9 col-sm-12">
            <div class="container-fluid p-0">
              <div class="row">
                [?php include_partial('<?php echo $this->getModuleName() ?>/show_actions', array('form' => $form, '<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'configuration' => $configuration, 'helper' => $helper)) ?]
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    [?php include_partial('<?php echo $this->getModuleName() ?>/show', array('form' => $form, '<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'configuration' => $configuration, 'helper' => $helper)) ?]
  </div>
</section>
