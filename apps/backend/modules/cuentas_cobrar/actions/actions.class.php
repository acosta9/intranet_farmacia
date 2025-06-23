<?php

require_once dirname(__FILE__).'/../lib/cuentas_cobrarGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/cuentas_cobrarGeneratorHelper.class.php';

/**
 * cuentas_cobrar actions.
 *
 * @package    ired.localhost
 * @subpackage cuentas_cobrar
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class cuentas_cobrarActions extends autoCuentas_cobrarActions
{
  protected function addSortQuery($query) {
    if (array(null, null) == ($sort = $this->getSort())) {
      return;
    }

    if (!in_array(strtolower($sort[1]), array('asc', 'desc'))) {
      $sort[1] = 'asc';
    }

    switch ($sort[0]) {
      case 'empresaName':
        $sort[0] = 'e.acronimo';
        break;
      case 'clienteName':
        $sort[0] = 'c.full_name';
        break;
      case 'forPagoCoin':
        $sort[0] = 'fp.acronimo';
        break;
      case 'CreatedAtTxt':
        $sort[0] = 'created_at';
        break;
    }
    $query->addOrderBy($sort[0] . ' ' . $sort[1]);
  }

  protected function isValidSortColumn($column) {
    return Doctrine_Core::getTable("Retenciones")->hasColumn($column) || $column == "EmpresaName" || $column == "ClienteName" || $column == "forPagoCoin" || $column == "CreatedAtTxt";
  }
}
