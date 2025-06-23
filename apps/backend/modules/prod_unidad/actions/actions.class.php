<?php

require_once dirname(__FILE__).'/../lib/prod_unidadGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/prod_unidadGeneratorHelper.class.php';

/**
 * prod_unidad actions.
 *
 * @package    ired.localhost
 * @subpackage prod_unidad
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class prod_unidadActions extends autoProd_unidadActions
{
  public function executeNew(sfWebRequest $request) {
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    if($ename["tipo"]<>2) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso a esta area');
      $this->redirect('prod_unidad');
    }

    $this->form = $this->configuration->getForm();
    $this->prod_unidad = $this->form->getObject();
  }

  public function executeEdit(sfWebRequest $request) { 
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    if($ename["tipo"]<>2) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso a esta area');
      $this->redirect('prod_unidad');
    }

    $this->prod_unidad = $this->getRoute()->getObject();
    $this->form = $this->configuration->getForm($this->prod_unidad);
  }

  public function executeDelete(sfWebRequest $request) {
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    if($ename["tipo"]<>2) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso a esta area');
      $this->redirect('prod_unidad');
    }
    
    $request->checkCSRFProtection();
    $id=$request->getParameter('id');
    $producto=Doctrine_Core::getTable('Producto')->findOneBy('unidad_id', $id);
    if(!empty($producto)) {
      $prod_unidad=Doctrine_Core::getTable('Producto')->findOneBy('id', $id);
      $this->getUser()->setFlash('error','No puedes eliminar el registro, porque tiene asociado varios productos');
      $this->redirect(array('sf_route' => 'prod_unidad_show', 'sf_subject' => $prod_unidad));
    }

    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));
    if ($this->getRoute()->getObject()->delete()) {       
      $this->getUser()->setFlash('notice', 'El registro ha sido eliminado correctamente.');
    }
    $this->redirect('@compuesto');
  }
}
