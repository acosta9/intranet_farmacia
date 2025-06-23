<?php

/**
 * usuarios actions.
 *
 * @package    maguey
 * @subpackage usuarios
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class userActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request) {
    if($this->getUser()->isAuthenticated()) {
      $this->redirect('user/historial');
    }
  }
  public function executeHistorial(sfWebRequest $request) {
    $this->sf_guard_user = Doctrine::getTable('sfGuardUser')->find($this->getUser()->getGuardUser()->getId());
    $this->forward404Unless($this->sf_guard_user);

		$this->results = Doctrine_Query::create()
		->select('o.*')
		->from('Orders o')
		->where('o.sf_guard_user_id = ?', $this->getUser()->getGuardUser()->getId())
		->orderBy('o.id DESC')
		->execute();

  }
  public function executeFavoritos(sfWebRequest $request) {
    $this->sf_guard_user = Doctrine::getTable('sfGuardUser')->find($this->getUser()->getGuardUser()->getId());
    $this->forward404Unless($this->sf_guard_user);

    $this->favoritos = Doctrine_Core::getTable('ProductosFavoritos')
    ->createQuery('a')
    ->where('sf_guard_user_id =? ', $this->getUser()->getGuardUser()->getId())
    ->orderBy('id DESC')
    ->execute();
  }
  public function executeMicuenta(sfWebRequest $request) {
    $this->sf_guard_user = Doctrine::getTable('sfGuardUser')->find($this->getUser()->getGuardUser()->getId());
    $this->forward404Unless($this->sf_guard_user);
  }
}
