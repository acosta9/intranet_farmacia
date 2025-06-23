<?php
require_once(sfConfig::get('sf_plugins_dir').'/sfDoctrineGuardPlugin/modules/sfGuardAuth/lib/BasesfGuardAuthActions.class.php');

class sfGuardAuthComponents extends sfComponents {
  public function executeUpdate() {
    $user= Doctrine_Core::getTable('sfGuardUser')->find($this->getUser()->getGuardUser()->getId());
    $this->form = new sfGuardUserAdminForm($user);
  }

  public function executePassword() {
    $user= Doctrine_Core::getTable('sfGuardUser')->find($this->getUser()->getGuardUser()->getId());
    $this->form = new sfGuardUserAdminForm($user);
  }

  public function executeSignin() {
    $class = sfConfig::get('app_sf_guard_plugin_signin_form', 'sfGuardFormSignin');
    $this->form = new $class;
  }

  public function executeRegister() {
    $class = sfConfig::get('app_sf_guard_plugin_admin_form', 'sfGuardUserAdminForm');
    $this->form = new $class;
  }

}
?>
