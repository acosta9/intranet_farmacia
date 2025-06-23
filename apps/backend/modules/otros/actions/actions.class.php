<?php

require_once dirname(__FILE__).'/../lib/otrosGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/otrosGeneratorHelper.class.php';

/**
 * otros actions.
 *
 * @package    ired.localhost
 * @subpackage otros
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class otrosActions extends autoOtrosActions
{
  protected function addSortQuery($query) {
    if (array(null, null) == ($sort = $this->getSort())) {
      return;
    }
    if (!in_array(strtolower($sort[1]), array('asc', 'desc'))) {
      $sort[1] = 'asc';
    }
    switch ($sort[0]) {
      case 'company':
        $sort[0] = 'e.acronimo';
        break;
      case 'TipoTasa':
        $sort[0] = 'nombre';
        break;
    }
    $query->addOrderBy($sort[0] . ' ' . $sort[1]);
  }

  protected function isValidSortColumn($column) {
    return Doctrine_Core::getTable("Otros")->hasColumn($column) || $column == "company" || $column == "category" || $column == "TipoTasa";
  }
}
