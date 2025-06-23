<?php

/**
 * inicio actions.
 *
 * @package    maguey
 * @subpackage inicio
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class inicioActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request) {
  }
  public function executeFaq(sfWebRequest $request) {
  }
  public function executeCambiar(sfWebRequest $request) {
    $this->forward404unless($request->isXmlHttpRequest());
    $userid=$request->getParameter('userid');
    $id=$request->getParameter('id');

    $user = Doctrine_Core::getTable('SfGuardUser')->findOneBy('id', $userid);
    $user->cliente_id=$id;
    $user->save();
    
    return $this->renderText("success");
  }
}
