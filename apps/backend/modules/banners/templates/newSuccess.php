<?php use_helper('I18N', 'Date') ?>
<?php include_partial('banners/assets') ?>


<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Banners <small style="font-size: 60%;">nuevo</small></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo url_for('homepage') ?>">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="<?php echo url_for('banners') ?>">Banners</a></li>
          <li class="breadcrumb-item active">nuevo</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<?php echo form_tag_for($form, '@banners') ?>
<section class="content">
  <div class="container-fluid">
    <div class="card card-default">
      <div class="card-header" style="padding: 0.75rem 1.25rem 0rem 1.25rem">
        <div class="row">
          <div class="col-md-9 col-sm-12">
            <div class="container-fluid p-0">
              <div class="row">
                <?php include_partial('banners/form_actions', array('banners' => $banners, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include_partial('banners/form', array('banners' => $banners, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
    <div class="row">
                        <?php if ($form->isNew()): ?>
                            <?php if (method_exists($helper, 'linkTo_list')): ?>
              <?php if ($sf_user->hasCredential(array(  0 => 'sysadmin',))): ?>
<?php echo $helper->linkTo_list($form->getObject(), array(  'label' => 'Listado',  'credentials' =>   array(    0 => 'sysadmin',  ),  'params' =>   array(  ),  'class_suffix' => 'list',)) ?>
<?php endif; ?>
            <?php else: ?>
                                                        <?php endif; ?>
                    <?php if (method_exists($helper, 'linkTo_save')): ?>
              <?php if ($sf_user->hasCredential(array(  0 => 'sysadmin',))): ?>
<?php echo $helper->linkTo_save($form->getObject(), array(  'label' => 'Guardar',  'credentials' =>   array(    0 => 'sysadmin',  ),  'params' =>   array(  ),  'class_suffix' => 'save',)) ?>
<?php endif; ?>
            <?php else: ?>
                                                        <?php endif; ?>
                                <?php else: ?>
                            <?php if (method_exists($helper, 'linkTo_list')): ?>
              <?php if ($sf_user->hasCredential(array(  0 => 'sysadmin',))): ?>
<?php echo $helper->linkTo_list($form->getObject(), array(  'label' => 'Listado',  'credentials' =>   array(    0 => 'sysadmin',  ),  'params' =>   array(  ),  'class_suffix' => 'list',)) ?>
<?php endif; ?>
            <?php else: ?>
                                                        <?php endif; ?>
                    <?php if (method_exists($helper, 'linkTo_new')): ?>
              <?php if ($sf_user->hasCredential(array(  0 => 'sysadmin',))): ?>
<?php echo $helper->linkTo_new($form->getObject(), array(  'label' => 'Nuevo',  'credentials' =>   array(    0 => 'sysadmin',  ),  'params' =>   array(  ),  'class_suffix' => 'new',)) ?>
<?php endif; ?>
            <?php else: ?>
                                                        <?php endif; ?>
                    <?php if (method_exists($helper, 'linkTo_show')): ?>
              <?php if ($sf_user->hasCredential(array(  0 => 'sysadmin',))): ?>
<?php echo $helper->linkTo_show($form->getObject(), array(  'label' => 'Mostrar',  'credentials' =>   array(    0 => 'sysadmin',  ),  'params' =>   array(  ),  'class_suffix' => 'show',)) ?>
<?php endif; ?>
            <?php else: ?>
                                                        <?php endif; ?>
                    <?php if (method_exists($helper, 'linkTo_save')): ?>
              <?php if ($sf_user->hasCredential(array(  0 => 'sysadmin',))): ?>
<?php echo $helper->linkTo_save($form->getObject(), array(  'label' => 'Guardar',  'credentials' =>   array(    0 => 'sysadmin',  ),  'params' =>   array(  ),  'class_suffix' => 'save',)) ?>
<?php endif; ?>
            <?php else: ?>
                                                        <?php endif; ?>
                    <?php endif; ?>
      <div class="col-md-2 col-sm-12">
        <input type="submit" value="guardar" class="btn btn-primary btn-block text-uppercase btn-align"/>
      </div>
    </div>
  </div>
</section>
</form>
