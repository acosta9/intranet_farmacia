<?php

require_once dirname(__FILE__).'/../lib/devolver_compraGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/devolver_compraGeneratorHelper.class.php';

/**
 * devolver_compra actions.
 *
 * @package    ired.localhost
 * @subpackage devolver_compra
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class devolver_compraActions extends autoDevolver_compraActions
{
  protected function addSortQuery($query) {
    if (array(null, null) == ($sort = $this->getSort())) {
      return;
    }
    if (!in_array(strtolower($sort[1]), array('asc', 'desc'))) {
      $sort[1] = 'asc';
    }
    switch ($sort[0]) {
      case 'nfactura':
        $sort[0] = 'nfactura';
        break;
      case 'pname':
        $sort[0] = 'pname';
        break;        
      case 'date':
        $sort[0] = 'fecha';
        break;
    }
    $query->addOrderBy($sort[0] . ' ' . $sort[1]);
  }
  protected function isValidSortColumn($column) {
    return Doctrine_Core::getTable("DevolverCompra")->hasColumn($column) || $column == "nfactura" || $column == "date";
  }
   public function executeNew(sfWebRequest $request) {
    if(empty($request->getParameter('id'))) {
      $this->getUser()->setFlash('error','La devolucion solo se puede hacer al registrar una factura de compra');
      $this->redirect(array('sf_route' => 'ordenes_compra'));
    }

    $this->form = $this->configuration->getForm();
    $this->factura_compra = $this->form->getObject();
  }
}
