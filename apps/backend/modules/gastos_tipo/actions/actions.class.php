<?php

require_once dirname(__FILE__).'/../lib/gastos_tipoGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/gastos_tipoGeneratorHelper.class.php';

/**
 * gastos_tipo actions.
 *
 * @package    ired.localhost
 * @subpackage gastos_tipo
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class gastos_tipoActions extends autoGastos_tipoActions
{
  public function executeNew(sfWebRequest $request) {
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    if($ename["tipo"]<>2) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso a esta area');
      $this->redirect('gastos_tipo');
    }

    $this->form = $this->configuration->getForm();
    $this->gastos_tipo = $this->form->getObject();
  }
  public function executeEdit(sfWebRequest $request) { 
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    if($ename["tipo"]<>2) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso a esta area');
      $this->redirect('gastos_tipo');
    }

    $this->gastos_tipo = $this->getRoute()->getObject();
    $this->form = $this->configuration->getForm($this->gastos_tipo);
  }  

  public function executeDelete(sfWebRequest $request) {
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    if($ename["tipo"]<>2) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso a esta area');
      $this->redirect('gastos_tipo');
    }
    
    $request->checkCSRFProtection();        
    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));

    if ($this->getRoute()->getObject()->delete()) {       
      $this->getUser()->setFlash('notice', 'El registro ha sido eliminado correctamente.');
    }
    $this->redirect('@gastos_tipo');
  }
}
