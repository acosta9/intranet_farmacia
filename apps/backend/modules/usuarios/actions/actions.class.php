<?php
require_once dirname(__FILE__).'/../lib/usuariosGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/usuariosGeneratorHelper.class.php';
/**
 * usuarios actions.
 *
 * @package    policarirubana
 * @subpackage usuarios
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class usuariosActions extends autoUsuariosActions
{
    protected function processForm(sfWebRequest $request, sfForm $form)
  {
   $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $notice = $form->getObject()->isNew() ? 'datos guardados correctamente.' : 'datos guardados correctamente.';

      try {
        $sf_guard_user = $form->save();

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

      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $sf_guard_user)));

      if ($request->hasParameter('_save_and_add'))
      {
        $this->getUser()->setFlash('notice', $notice.' Puedes agregar otro registro abajo.');

        $this->redirect('@sf_guard_user_new');
      }
      else
      {
        $this->getUser()->setFlash('notice', $notice);

        if ($sf_guard_user->getId()==$this->getUser()->getGuardUser()->getId()) {
            $this->redirect(array('sf_route' => 'sf_guard_user_show', 'sf_subject' => $sf_guard_user));
        }

        $this->redirect(array('sf_route' => 'sf_guard_user_show', 'sf_subject' => $sf_guard_user));
      }
    }
    else
    {
      $this->getUser()->setFlash('error', 'Error, revisa los datos introducidos.', false);
    }
  }
}
