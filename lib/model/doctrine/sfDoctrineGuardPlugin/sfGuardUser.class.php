<?php

/**
 * sfGuardUser
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    base.localhost
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class sfGuardUser extends PluginsfGuardUser
{
  public function  __toString()
  {
    return sprintf('%s', $this->getFullName()." (".$this->getUsername().")");
  }
  public function getNombre() {
    return $this->getFullName();
  }
  public function getAdjunto() {
    return $this->getUrlImagen();
  }
  public function getTipoPrecio() {
    $precio=NULL;
    if(!empty($this->getClienteId())) {
      $cliente = Doctrine_Core::getTable('Cliente')->findOneBy('id', $this->getClienteId());
      $precio=$cliente->getTipoPrecio();  
    }
    return $precio;
  }
}