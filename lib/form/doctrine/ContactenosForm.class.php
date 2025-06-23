<?php

/**
 * Contactenos form.
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ContactenosForm extends BaseContactenosForm
{
  public function configure()
  {
    unset(
      $this['created_at'],
      $this['updated_at']
    );
    
    $this->widgetSchema['nombre']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['email']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['mensaje']->setAttributes(array('class' => 'form-control', 'cols' => 45, 'rows' => 10));
    $this->widgetSchema['estatus']->setAttributes(array('class' => 'minimal'));

    $this->setValidators(array(
      'id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'estatus'    => new sfValidatorBoolean(array('required' => false)),
      'email'       => new sfValidatorEmail(array('max_length' => 200, 'required'=> true), array(
        'required'   => 'campo requerido',
        'invalid'   => 'campo invalido',
      )),
      'nombre'  => new sfValidatorString(array('max_length' => 200, 'required'=> true), array(
        'required'   => 'campo requerido',
      )),
      'mensaje'        => new sfValidatorString(array('max_length' => 1000, 'required'=> true), array(
        'required'   => 'campo requerido',
      )),
    ));
  }
}
