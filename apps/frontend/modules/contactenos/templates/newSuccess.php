<?php use_helper('I18N', 'Date') ?>
<?php include_partial('contactenos/assets') ?>
<?php include_partial('contactenos/flashes') ?>
<?php include_partial('contactenos/form_header', array('contactenos' => $contactenos, 'form' => $form, 'configuration' => $configuration)) ?>
<?php include_partial('contactenos/form', array('contactenos' => $contactenos, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
<?php include_partial('contactenos/form_footer', array('contactenos' => $contactenos, 'form' => $form, 'configuration' => $configuration)) ?>
