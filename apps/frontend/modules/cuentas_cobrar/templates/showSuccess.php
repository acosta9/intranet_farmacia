<?php use_helper('I18N', 'Date') ?>
<?php include_partial('recibo_pago/assets') ?>

<?php include_partial('recibo_pago/show', array('form' => $form, 'recibo_pago' => $recibo_pago, 'configuration' => $configuration, 'helper' => $helper)) ?>

