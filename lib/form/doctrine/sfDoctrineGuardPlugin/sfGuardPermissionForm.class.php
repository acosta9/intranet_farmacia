<?php

/**
 * sfGuardPermission form.
 *
 * @package    base.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrinePluginFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfGuardPermissionForm extends PluginsfGuardPermissionForm
{
  public function configure()
  {
      $this->widgetSchema['name']->setAttributes(array('class' => 'form-control'));
      $this->widgetSchema['description']->setAttributes(array('class' => 'form-control'));
      $this->widgetSchema['groups_list']->setAttributes(array('class' => 'form-control'));
      $this->widgetSchema['users_list']->setAttributes(array('class' => 'form-control'));

      $this->setValidator('name', new sfValidatorString(array('max_length' => 200, 'min_length' => 2, 'required'=> true), array(
        'required'   => 'Requerido',
        'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
        'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
        'invalid'=> 'Campo invalido.'
      )));
      $this->setValidator('description', new sfValidatorString(array('max_length' => 200, 'min_length' => 2, 'required'=> true), array(
        'required'   => 'Requerido',
        'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
        'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
        'invalid'=> 'Campo invalido.'
      )));
      $this->validatorSchema->setPostValidator(
        new sfValidatorAnd(array(
          new sfValidatorDoctrineUnique(array('model' => 'sfGuardPermission', 'column' => array('name')), array(
            'invalid'=> 'Permiso ya existente.')),
          new sfValidatorCallback(array('callback' => array($this, 'validaciones')))
        ))
      );
  }
  public function validaciones($validator, $values) {
    if(!empty($values['name'])) {
      $valor_first=strlen($values['name']);
      $valor_last=strlen(preg_replace("/[^a-z0-9_-]/", "", $values['name']));

      if($valor_first != $valor_last) {
        $error = new sfValidatorError($validator, 'Solo se permiten letras minusculas y numeros');
        throw new sfValidatorErrorSchema($validator, array('name' => $error));
      }
    }

    $values['name'] = trim(strtolower($values['name'] ));
    $values['description'] = trim(ucwords(strtolower($values['description'] )));
    return $values;
  }
}
