<?php

/**
 * recibo actions.
 *
 * @package    ired.localhost
 * @subpackage recibo
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class reciboActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeGetFecha(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
  }
  public function executePost(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
  }
  public function executeGets(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
  }
}
