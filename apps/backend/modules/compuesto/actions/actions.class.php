<?php

require_once dirname(__FILE__).'/../lib/compuestoGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/compuestoGeneratorHelper.class.php';

/**
 * compuesto actions.
 *
 * @package    ired.localhost
 * @subpackage compuesto
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class compuestoActions extends autoCompuestoActions
{
  public function executeNew(sfWebRequest $request) {
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    if($ename["tipo"]<>2) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso a esta area');
      $this->redirect('compuesto');
    }

    $this->form = $this->configuration->getForm();
    $this->compuesto = $this->form->getObject();
  }

  public function executeEdit(sfWebRequest $request) { 
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    if($ename["tipo"]<>2) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso a esta area');
      $this->redirect('compuesto');
    }

    $this->compuesto = $this->getRoute()->getObject();
    $this->form = $this->configuration->getForm($this->compuesto);
  }  

  public function executeDelete(sfWebRequest $request) {
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    if($ename["tipo"]<>2) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso a esta area');
      $this->redirect('compuesto');
    }
    
    $request->checkCSRFProtection();        
    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));

    if ($this->getRoute()->getObject()->delete()) {       
      $this->getUser()->setFlash('notice', 'El registro ha sido eliminado correctamente.');
    }
    $this->redirect('@compuesto');
  }
}
