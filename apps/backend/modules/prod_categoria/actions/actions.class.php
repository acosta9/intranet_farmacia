<?php

require_once dirname(__FILE__).'/../lib/prod_categoriaGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/prod_categoriaGeneratorHelper.class.php';

/**
 * prod_categoria actions.
 *
 * @package    ired.localhost
 * @subpackage prod_categoria
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class prod_categoriaActions extends autoProd_categoriaActions
{
  public function executeNew(sfWebRequest $request) {
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    if($ename["tipo"]<>2) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso a esta area');
      $this->redirect('prod_categoria');
    }

    $this->form = $this->configuration->getForm();
    $this->prod_categoria = $this->form->getObject();
  }

  public function executeEdit(sfWebRequest $request) { 
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    if($ename["tipo"]<>2) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso a esta area');
      $this->redirect('prod_categoria');
    }

    $this->prod_categoria = $this->getRoute()->getObject();
    $this->form = $this->configuration->getForm($this->prod_categoria);
  }

  public function executeDelete(sfWebRequest $request) {
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    if($ename["tipo"]<>2) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso a esta area');
      $this->redirect('prod_categoria');
    }
    
    $request->checkCSRFProtection();        
    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));

    if ($this->getRoute()->getObject()->delete()) {       
      $this->getUser()->setFlash('notice', 'El registro ha sido eliminado correctamente.');
    }
    $this->redirect('@prod_categoria');
  }

  protected function addSortQuery($query) {
    if (array(null, null) == ($sort = $this->getSort())) {
      return;
    }

    if (!in_array(strtolower($sort[1]), array('asc', 'desc'))) {
      $sort[1] = 'asc';
    }

    switch ($sort[0]) {
      case 'CodFull':
        $sort[0] = 'codigo_full';
        break;
    }
    $query->addOrderBy($sort[0] . ' ' . $sort[1]);
  }

  protected function isValidSortColumn($column) {
    return Doctrine_Core::getTable("ProdCategoria")->hasColumn($column) || $column == "CodFull";
  }

  protected function processForm(sfWebRequest $request, sfForm $form) {
   $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid()) {
      $notice = $form->getObject()->isNew() ? 'datos guardados correctamente.' : 'datos guardados correctamente.';
      try {
        $prod_categoria = $form->save();
        $prod_categoria->getCodFull();
      } catch (Doctrine_Validator_Exception $e) {
        $errorStack = $form->getObject()->getErrorStack();
        $message = get_class($form->getObject()) . ' has ' . count($errorStack) . " field" . (count($errorStack) > 1 ?  's' : null) . " with validation errors: ";
        foreach ($errorStack as $field => $errors) {
          $message .= "$field (" . implode(", ", $errors) . "), ";
        }
        $message = trim($message, ', ');
        $this->getUser()->setFlash('error', $message);
        return sfView::SUCCESS;
      }
      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $prod_categoria)));
      if ($request->hasParameter('_save_and_add')) {
        $this->getUser()->setFlash('notice', $notice.' Puedes agregar otro registro abajo.');
        $this->redirect('@prod_categoria_new');
      } else {
        $this->getUser()->setFlash('notice', $notice);
        $this->redirect(array('sf_route' => 'prod_categoria_show', 'sf_subject' => $prod_categoria));
      }
    } else {
      $this->getUser()->setFlash('error', 'Error, revisa los datos introducidos.', false);
    }
  }
}
