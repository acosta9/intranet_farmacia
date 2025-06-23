<?php

require_once dirname(__FILE__).'/../lib/prod_laboratorioGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/prod_laboratorioGeneratorHelper.class.php';

/**
 * prod_laboratorio actions.
 *
 * @package    ired.localhost
 * @subpackage prod_laboratorio
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class prod_laboratorioActions extends autoProd_laboratorioActions
{
  public function executeNew(sfWebRequest $request) {
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    if($ename["tipo"]<>2) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso a esta area');
      $this->redirect('prod_laboratorio');
    }

    $this->form = $this->configuration->getForm();
    $this->prod_laboratorio = $this->form->getObject();
  }

  public function executeEdit(sfWebRequest $request) { 
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    if($ename["tipo"]<>2) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso a esta area');
      $this->redirect('prod_laboratorio');
    }

    $this->prod_laboratorio = $this->getRoute()->getObject();
    $this->form = $this->configuration->getForm($this->prod_laboratorio);
  }

  public function executeDelete(sfWebRequest $request) {
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    if($ename["tipo"]<>2) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso a esta area');
      $this->redirect('prod_laboratorio');
    }
    
    $request->checkCSRFProtection();        
    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));

    if ($this->getRoute()->getObject()->delete()) {       
      $this->getUser()->setFlash('notice', 'El registro ha sido eliminado correctamente.');
    }
    $this->redirect('@prod_laboratorio');
  }
}
