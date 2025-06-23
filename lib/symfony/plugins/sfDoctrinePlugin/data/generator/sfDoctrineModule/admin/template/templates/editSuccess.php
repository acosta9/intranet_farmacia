[?php use_helper('I18N', 'Date') ?]
[?php include_partial('<?php echo $this->getModuleName() ?>/assets') ?]

<?php
  $var=$this->getI18NString('edit.title');
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

[?php echo form_tag_for($form, '@<?php echo $this->params['route_prefix'] ?>', array('id' => 'myForm')) ?]
  <section class="content">
    <div class="container-fluid">
      <div class="card card-default">
        <div class="card-header" style="padding: 0.75rem 1.25rem 0rem 1.25rem">
          <div class="row">
            <div class="col-md-9 col-sm-12">
              <div class="container-fluid p-0">
                <div class="row">
                  [?php include_partial('<?php echo $this->getModuleName() ?>/form_actions', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?]
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      [?php include_partial('<?php echo $this->getModuleName() ?>/form', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?]
      <div class="row">
        <?php foreach (array('new', 'edit') as $action): ?>
          <?php if ('new' == $action): ?>
            [?php if ($form->isNew()): ?]
          <?php else: ?>
            [?php else: ?]
          <?php endif; ?>
          <?php foreach ($this->configuration->getValue($action.'.actions') as $name => $params): ?>
              [?php if (method_exists($helper, 'linkTo<?php echo $method = ucfirst(sfInflector::camelize($name)) ?>')): ?]
                <?php echo $this->addCredentialCondition('[?php echo $helper->linkTo'.$method.'($form->getObject(), '.$this->asPhp($params).') ?]', $params) ?>
              [?php else: ?]
                <?php if ('_show' == $name && 'new' == $action): ?>
                <?php else: ?>
                  <?php if (strpos($params['class_suffix'], "add_")!== false) : ?>
                    <div class="col-md-2 col-sm-12">
                      <a class="btn btn-default btn-block text-uppercase btn-align <?php echo $params['class_suffix'] ?>" href="javascript:void(0)">
                        <i class="fa fa-plus-square mr-2"></i><?php echo $params['label'] ?>
                      </a>
                    </div>
                  <?php endif; ?>
                <?php endif; ?>
              [?php endif; ?]
          <?php endforeach; ?>
        <?php endforeach; ?>
        [?php endif; ?]
        <div class="col-md-2 col-sm-12">
          <input type="submit" value="guardar" class="btn-guardar btn btn-primary btn-block text-uppercase btn-align"/>
        </div>
      </div>
    </div>
  </section>
</form>
