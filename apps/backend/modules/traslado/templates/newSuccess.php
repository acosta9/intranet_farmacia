<?php use_helper('I18N', 'Date') ?>
<?php include_partial('traslado/assets') ?>


<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Traslados  <small style="font-size: 60%;"> nuevo </small></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo url_for('homepage') ?>">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="<?php echo url_for('traslado') ?>">Traslados </a></li>
          <li class="breadcrumb-item active"> nuevo </li>
        </ol>
      </div>
    </div>
  </div>
</section>

<?php echo form_tag_for($form, '@traslado') ?>
<section class="content">
  <div class="container-fluid">
    <div class="card card-default">
      <div class="card-header" style="padding: 0.75rem 1.25rem 0rem 1.25rem">
        <div class="row">
          <div class="col-md-9 col-sm-12">
            <div class="container-fluid p-0">
              <div class="row">
                <?php include_partial('traslado/form_actions', array('traslado' => $traslado, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include_partial('traslado/form', array('traslado' => $traslado, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>
</section>
</form>
