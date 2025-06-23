<?php use_helper('I18N', 'Date') ?>
<?php include_partial('banners/assets') ?>


<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Banners <small style="font-size: 60%;">detalle</small></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo url_for('homepage') ?>">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="<?php echo url_for('banners') ?>">Banners</a></li>
          <li class="breadcrumb-item active">detalle</li>
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
                <?php include_partial('banners/show_actions', array('form' => $form, 'banners' => $banners, 'configuration' => $configuration, 'helper' => $helper)) ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include_partial('banners/show', array('form' => $form, 'banners' => $banners, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>
</section>
