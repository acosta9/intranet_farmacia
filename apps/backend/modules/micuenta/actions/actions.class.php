<?php

/**
 * micuenta actions.
 *
 * @package    ired.localhost
 * @subpackage micuenta
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class micuentaActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $url="micuenta/edit?id=".$this->getUser()->getGuardUser()->getId();
    $this->redirect($url);
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($sf_guard_user = Doctrine_Core::getTable('sfGuardUser')->find(array($request->getParameter('id'))), sprintf('Object sf_guard_user does not exist (%s).', $request->getParameter('id')));
    $this->form = new sfGuardUserAdmin2Form($sf_guard_user);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($sf_guard_user = Doctrine_Core::getTable('sfGuardUser')->find(array($request->getParameter('id'))), sprintf('Object sf_guard_user does not exist (%s).', $request->getParameter('id')));
    $this->form = new sfGuardUserAdmin2Form($sf_guard_user);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $sf_guard_user = $form->save();
      $this->getUser()->setFlash('notice', 'los datos han sido guardados correctamente.');
      $this->redirect('micuenta/edit?id='.$sf_guard_user->getId());
    } else {
      $this->getUser()->setFlash('error', sprintf('verifica los datos ingresados'));
    }
  }
}
