<?php

/**
 * sincinv actions.
 *
 * @package    ired.localhost
 * @subpackage sincinv
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sincinvActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeInvCentral(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
  }
  public function executeInvFarmacia(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
  }
  public function executeProdCentral(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
  }
  public function executeProdFarmacia(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
  }
  public function executeCrearIds(sfWebRequest $request){
  }
}
