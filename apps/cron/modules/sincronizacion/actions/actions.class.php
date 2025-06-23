<?php

/**
 * sincronizacion actions.
 *
 * @package    ired.localhost
 * @subpackage sincronizacion
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sincronizacionActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeUsUpInsert(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
  }
  public function executeUsUpUpdate(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
  }
  public function executeOtUpInsert(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
  }
  public function executeOtUpUpdate(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
  }
  public function executeVpUpInsert(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
  }
  public function executeVpUpUpdate(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
  }
  public function executeCompUpInsert(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
  }
  public function executeCompUpUpdate(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
  }
  public function executeTrasUpInsert(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
  }
  public function executeTrasUpUpdate(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
  }
  public function executeCajaUpInsert(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
  }
  public function executeCajaUpUpdate(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
  }
  public function executeCajafDw(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
  }
  public function executeFactDw(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
  }
  public function executeReciboDw(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
  }
  public function executeKardexDw(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
  }
  public function executeUsDw(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
  }
  public function executeCajaDw(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
  }
  public function executeCompDw(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
  }
  public function executeOtDw(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
  }
  public function executeTrasDw(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
  }
  public function executeVpDw(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
  }
  public function executeCajafUpInsert(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
  }
  public function executeFactUpInsert(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
  }
  public function executeFactUpUpdate(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
  }
  public function executeReciboUpInsert(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
  }
  public function executeReciboUpUpdate(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
  }
  public function executeKardexUpInsert(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
  }
  public function executeInvdepUp(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
  }
  public function executeInvdepDw(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
  }
  public function executeEmpresaUp(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
  }
  public function executeEmpresaDw(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
  }
  public function executeTrasladoUp(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
  }
  public function executeTrasladoDw(sfWebRequest $request){
    $this->getResponse()->setContentType('application/json');
  }
}
