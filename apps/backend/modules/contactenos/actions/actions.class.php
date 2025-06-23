<?php

require_once dirname(__FILE__).'/../lib/contactenosGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/contactenosGeneratorHelper.class.php';

/**
 * contactenos actions.
 *
 * @package    ired.localhost
 * @subpackage contactenos
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class contactenosActions extends autoContactenosActions
{
  public function executeEstatus(sfWebRequest $request){
    $contactenos = Doctrine_Core::getTable('Contactenos')->findOneBy('id', $request->getParameter('id'));

    if($contactenos->getEstatus()) {
      $contactenos->estatus = 0;
    } else {
      $contactenos->estatus = 1;
    }
    $contactenos->save();

    $this->getUser()->setFlash('notice','Se ha cambiado el estatus correctamente');
    $this->redirect(array('sf_route' => 'contactenos_show', 'sf_subject' => $contactenos));
  }
}
