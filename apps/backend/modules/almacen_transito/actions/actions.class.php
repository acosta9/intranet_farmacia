<?php

require_once dirname(__FILE__).'/../lib/almacen_transitoGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/almacen_transitoGeneratorHelper.class.php';

/**
 * almacen_transito actions.
 *
 * @package    ired.localhost
 * @subpackage almacen_transito
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class almacen_transitoActions extends autoAlmacen_transitoActions {
  protected function addSortQuery($query) {
    if (array(null, null) == ($sort = $this->getSort())) {
      return;
    }
    if (!in_array(strtolower($sort[1]), array('asc', 'desc'))) {
      $sort[1] = 'asc';
    }
    switch ($sort[0]) {
      case 'UpdatedAtTxt':
        $sort[0] = 'updated_at';
        break;
    }
    $query->addOrderBy($sort[0] . ' ' . $sort[1]);
  }

  protected function isValidSortColumn($column) {
    return Doctrine_Core::getTable("AlmacenTransito")->hasColumn($column) || $column == "UpdatedAtTxt";
  }
  public function executePrint(sfWebRequest $request){
  }
  public function executeEmbalado(sfWebRequest $request){

    $almacen_transito = Doctrine_Core::getTable('AlmacenTransito')->findOneBy('id', $request->getParameter('id'));
    if($almacen_transito->getEstatus()==1) {
      $almacen_transito->estatus=2;
      $almacen_transito->boxes=$request->getParameter('box');
      $almacen_transito->precinto=$request->getParameter('precinto');
      $almacen_transito->fecha_embalaje=date("Y-m-d H:i:s");
      $almacen_transito->save();
    }

    $this->getUser()->setFlash('notice','Los datos han sido guardados correctamente');
    $this->redirect(array('sf_route' => 'almacen_transito_show', 'sf_subject' => $almacen_transito));
  }
  public function executeDespachar(sfWebRequest $request){
    $almacen_transito = Doctrine_Core::getTable('AlmacenTransito')->findOneBy('id', $request->getParameter('id'));
    if($almacen_transito->getEstatus()==2) {
      $almacen_transito->estatus=3;
      $almacen_transito->fecha_despacho=date("Y-m-d H:i:s");
      $almacen_transito->save();
    }

    $this->getUser()->setFlash('notice','Los datos han sido guardados correctamente');
    $this->redirect(array('sf_route' => 'almacen_transito_show', 'sf_subject' => $almacen_transito));
  }

  public function executeAnular(sfWebRequest $request){
    $almacen_transito = Doctrine_Core::getTable('AlmacenTransito')->findOneBy('id', $request->getParameter('id'));

    if($almacen_transito->getEstatus()==3) {
      $this->getUser()->setFlash('error','No puede anular el documento porque ya ha sido despachado');
      $this->redirect(array('sf_route' => 'almacen_transito_show', 'sf_subject' => $almacen_transito));
    }

    if($almacen_transito->getEstatus()!=4) {
      $almacen_transito->estatus=4;
      $almacen_transito->save();
    }

    $this->getUser()->setFlash('notice','Ha sido anulado correctamente');
    $this->redirect(array('sf_route' => 'almacen_transito_show', 'sf_subject' => $almacen_transito));
  }
}
