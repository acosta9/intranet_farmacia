<?php

require_once dirname(__FILE__).'/../lib/orden_compraGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/orden_compraGeneratorHelper.class.php';

/**
 * orden_compra actions.
 *
 * @package    ired.localhost
 * @subpackage orden_compra
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class orden_compraActions extends autoOrden_compraActions
{
  public function executeGetClientes(sfWebRequest $request){
  }

  public function executeHeader(sfWebRequest $request){
  }

  public function executeDeposito(sfWebRequest $request){
  }

  public function executeInv(sfWebRequest $request){
  }

  public function executeDetalles(sfWebRequest $request) {
  }

  public function executeDetalles2(sfWebRequest $request) {
  }

  public function executeAddDetallesForm(sfWebRequest $request) {
    $this->forward404unless($request->isXmlHttpRequest());
    $number = $request->getParameter('num');

    if($card = Doctrine_Core::getTable('OrdenCompra')->find($request->getParameter('id'))){
      $form = new OrdenCompraForm($card);
    }else{
      $form = new OrdenCompraForm(null);
    }

    $form->addDetalles($number);
    if($request->getParameter('tipo')==1) {
      return $this->renderPartial('orden_compra/detalles',array('form' => $form, 'num' => $number, 'eid' => $request->getParameter('eid'), 'cid' => $request->getParameter('cid')));
    } else {
      return $this->renderPartial('orden_compra/detalles2',array('form' => $form, 'num' => $number, 'eid' => $request->getParameter('eid'), 'did' => $request->getParameter('did'), 'cid' => $request->getParameter('cid')));
    }

  }
  
  protected function addSortQuery($query) {
    if (array(null, null) == ($sort = $this->getSort())) {
      return;
    }
    if (!in_array(strtolower($sort[1]), array('asc', 'desc'))) {
      $sort[1] = 'asc';
    }
    switch ($sort[0]) {
      case 'nulo':
        $sort[0] = 'anulado';
        break;
      case 'TotalCoin':
        $sort[0] = 'total';
        break;
      case 'estatus':
        $sort[0] = 'oce.nombre';
        break;
    }
    $query->addOrderBy($sort[0] . ' ' . $sort[1]);
  }

  protected function isValidSortColumn($column) {
    return Doctrine_Core::getTable("OrdenCompra")->hasColumn($column) || $column == "TotalCoin" || $column == "nulo" || $column == "estatus";
  }

  public function executeAnular(sfWebRequest $request){
    $orden_compra = Doctrine_Core::getTable('OrdenCompra')->findOneBy('id', $request->getParameter('id'));

    if($orden_compra->getOrdenCompraEstatusId()==3){
      $this->getUser()->setFlash('error','No puedes anular el registro, porque la orden de compra ya esta anulada');
      $this->redirect(array('sf_route' => 'orden_compra_show', 'sf_subject' => $orden_compra));
    }

    if($factura = Doctrine_Core::getTable('Factura')->findOneBy('orden_compra_id', $orden_compra->getId())) {
      $this->getUser()->setFlash('error','No puedes anular el registro, porque la orden de compra tiene una factura asociada');
      $this->redirect(array('sf_route' => 'orden_compra_show', 'sf_subject' => $orden_compra));
    }


    $orden_compra->orden_compra_estatus_id = 3;
    $orden_compra->save();


    $this->getUser()->setFlash('notice','La orden de compra ha sido anulada correctamente');
    $this->redirect(array('sf_route' => 'orden_compra_show', 'sf_subject' => $orden_compra));
  }
}
