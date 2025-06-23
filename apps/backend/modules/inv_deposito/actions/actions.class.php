<?php

require_once dirname(__FILE__).'/../lib/inv_depositoGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/inv_depositoGeneratorHelper.class.php';

/**
 * inv_deposito actions.
 *
 * @package    ired.localhost
 * @subpackage inv_deposito
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class inv_depositoActions extends autoInv_depositoActions
{
  public function executeNew(sfWebRequest $request) {
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    if($ename["tipo"]<>2) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso a esta area');
      $this->redirect('inv_deposito');
    }

    $this->form = $this->configuration->getForm();
    $this->inv_deposito = $this->form->getObject();
  }

  public function executeEdit(sfWebRequest $request) { 
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    if($ename["tipo"]<>2) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso a esta area');
      $this->redirect('inv_deposito');
    }

    $this->inv_deposito = $this->getRoute()->getObject();
    $this->form = $this->configuration->getForm($this->inv_deposito);
  }

  public function executeDelete(sfWebRequest $request) {
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    if($ename["tipo"]<>2) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso a esta area');
      $this->redirect('inv_deposito');
    }
    
    $request->checkCSRFProtection();        
    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));

    if ($this->getRoute()->getObject()->delete()) {       
      $this->getUser()->setFlash('notice', 'El registro ha sido eliminado correctamente.');
    }
    $this->redirect('@inv_deposito');
  }

  public function executeContador(sfWebRequest $request){
    $id = $request->getParameter('id');

    $dets = Doctrine_Core::getTable('InvDeposito')
      ->createQuery('a')
      ->select('COUNT(id) as contador')
      ->Where("id LIKE '$id%'")
      ->execute();
    $count = 0;
    foreach ($dets as $det) {
      $count=$det["contador"];
      break;
    }
    $count = $id.$count+1;
    $this->getResponse()->setContentType('application/json');
    return $this->renderText(json_encode($count));
  }

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
      case 'TipoDeposito':
        $sort[0] = 'tipo';
        break;
    }
    $query->addOrderBy($sort[0] . ' ' . $sort[1]);
  }

  protected function isValidSortColumn($column) {
    return Doctrine_Core::getTable("InvDeposito")->hasColumn($column) || $column == "TipoDeposito" || $column == "company";
  }
}
