<?php

/**
 * inventario actions.
 *
 * @package    ired.localhost
 * @subpackage inventario
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class inventarioActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeGetRegistros(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
  }
  public function executePost(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
  }
  public function executeGetFecha(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
  }
}
