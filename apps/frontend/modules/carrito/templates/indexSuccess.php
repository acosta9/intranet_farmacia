<?php use_helper('I18N', 'Date') ?>
<?php include_partial('carrito/assets') ?>

<?php include_partial('carrito/list_header', array('pager' => $pager)) ?>
<?php include_partial('carrito/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>

<?php include_partial('carrito/list_footer', array('pager' => $pager)) ?>
