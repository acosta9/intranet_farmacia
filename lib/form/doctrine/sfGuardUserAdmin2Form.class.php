<?php

/**
 * sfGuardUserAdminForm for admin generators
 *
 * @package    sfDoctrineGuardPlugin
 * @subpackage form
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfGuardUserAdminForm.class.php 23536 2009-11-02 21:41:21Z Kris.Wallsmith $
 */
class sfGuardUserAdmin2Form extends BasesfGuardUserAdminForm
{
  /**
   * @see sfForm
   */
  public function configure()
  {
	   parent::configure();

     unset($this['is_active']);
     unset($this['is_super_admin']);
     unset($this['groups_list']);
     unset($this['permissions_list']);
     unset($this['empresa_list']);
     unset($this['cliente_id']);
     unset($this['clave']);

     $this->setWidget('url_imagen', new sfWidgetFormInputFileEditable(array(
        'file_src'    => '/uploads/sf_guard_user/'.$this->getObject()->getUrlImagen(),
        'edit_mode'   => !$this->isNew(),
        'is_image'    => true,
        'with_delete' => false,
     )));

     $this->setValidator('url_imagen', new sfValidatorFile(array(
       'mime_types' => 'web_images',
       'path' => sfConfig::get('sf_upload_dir').'/sf_guard_user',
       'required' => false,
       ), array(
         'required'   => 'Requerido',
         'invalid'=> 'Invalido',
       )
     ));

     $this->setValidator('cargo', new sfValidatorString(array('max_length' => 200, 'min_length' => 2, 'required'=> true), array(
       'required'   => 'Requerido',
       'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
       'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
       'invalid'=> 'Campo invalido.'
     )));

     $this->validatorSchema->setPostValidator(
       new sfValidatorAnd(array(
         new sfValidatorDoctrineUnique(array('model' => 'sfGuardUser', 'column' => array('username')), array(
           'invalid'=> 'Nombre de usuario ya existente.')),
         new sfValidatorDoctrineUnique(array('model' => 'sfGuardUser', 'column' => array('email_address')), array(
           'invalid'=> 'Correo electronico ya existente.')),
         new sfValidatorCallback(array('callback' => array($this, 'validaciones')))
       ))
     );
   }

  public function validaciones($validator, $values) {
    if(!empty($values['password'])) {
      if(empty($values['password_again'])) {
        $error = new sfValidatorError($validator, 'Requerido');
        throw new sfValidatorErrorSchema($validator, array('password_again' => $error));
      } else {
        if(strcmp($values['password'],$values['password_again'])<>0) {
          $error = new sfValidatorError($validator, 'Ambas contraseñas deben coincidir');
          throw new sfValidatorErrorSchema($validator, array('password' => $error));
        }
        $re = "/^(?=.*[a-z])(?=.*\\d).{6,}$/i";
        if(!preg_match($re, $values['password'])) {
          $error = new sfValidatorError($validator, 'Contraseña debe contener minimo 1 letra, 1 numero y 6 caracteres');
          throw new sfValidatorErrorSchema($validator, array('password' => $error));
        }
      }
    }
    if(!empty($values['username'])) {
      $valor_first=strlen($values['username']);
      $valor_last=strlen(preg_replace("/[^a-z0-9]/", "", $values['username']));

      if($valor_first != $valor_last) {
        $error = new sfValidatorError($validator, 'Solo se permiten letras minusculas y numeros');
        throw new sfValidatorErrorSchema($validator, array('username' => $error));
      }
    }

    $values['cargo'] = trim(ucwords(strtolower($values['cargo'] )));
    $values['email_address'] = trim(strtolower($values['email_address'] ));
    $values['full_name'] = trim(ucwords(strtolower($values['full_name'] )));
    return $values;
  }
}
