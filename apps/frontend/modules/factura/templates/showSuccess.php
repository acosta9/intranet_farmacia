<?php use_helper('I18N', 'Date') ?>
<?php include_partial('factura/assets') ?>

<?php include_partial('factura/show', array('form' => $form, 'factura' => $factura, 'configuration' => $configuration, 'helper' => $helper)) ?>

