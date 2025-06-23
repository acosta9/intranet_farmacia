<?php

require_once dirname(__FILE__).'/../lib/forma_pagoGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/forma_pagoGeneratorHelper.class.php';

/**
 * forma_pago actions.
 *
 * @package    ired.localhost
 * @subpackage forma_pago
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class forma_pagoActions extends autoForma_pagoActions
{
  protected function addSortQuery($query) {
    if (array(null, null) == ($sort = $this->getSort())) {
      return;
    }

    if (!in_array(strtolower($sort[1]), array('asc', 'desc'))) {
      $sort[1] = 'asc';
    }

    switch ($sort[0]) {
      case 'coin':
        $sort[0] = 'moneda';
        break;
    }
    $query->addOrderBy($sort[0] . ' ' . $sort[1]);
  }

  protected function isValidSortColumn($column) {
    return Doctrine_Core::getTable("FormaPago")->hasColumn($column) || $column == "coin";
  }
}
