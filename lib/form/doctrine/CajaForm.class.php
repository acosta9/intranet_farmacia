<?php

/**
 * Caja form.
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CajaForm extends BaseCajaForm
{
  public function configure()
  {

    unset(
      $this['created_at'],
      $this['updated_at'],
      $this['created_by'],
      $this['updated_by']
    );

    $this->widgetSchema['empresa_id']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['nombre']->setAttributes(array('class' => 'form-control'));
    $this->setWidget('fecha', new sfWidgetFormInputText());
    $date = date("Y-m-d");
    $this->setDefault("tipo", false);
    $this->setDefault("status", false);
    $this->widgetSchema['descripcion']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['fecha']->setAttributes(array('class' => 'form-control', 'value' => $date, 'data-inputmask' => "'mask': '9999/99/99', 'placeholder': 'yyyy/mm/dd'", 'data-mask' => " "));
   
       $this->setValidators(array(
      'id' => new sfValidatorInteger(array('required' => true)),
      'empresa_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'))),
      'nombre'         => new sfValidatorString(array('max_length' => 200)),
      'tipo'           => new sfValidatorBoolean(array('required' => false)),
      'status'         => new sfValidatorBoolean(array('required' => false)),
      'fecha'          => new sfValidatorDateTime(),
      'descripcion'    => new sfValidatorString(array('required' => false)),
      
      'user_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser', 'required' => false)),

    ));
         

       $this->validatorSchema->setPostValidator(
        new sfValidatorAnd(array(
          new sfValidatorDoctrineUnique(array
          ('model' => 'Caja', 'column' => array('id')), array(
            'invalid'=> 'Codigo ya existente')),
          new sfValidatorCallback(array('callback' => array($this, 'validaciones')))
        ))
      );
  }
   public function validaciones($validator, $values) {
    if(!empty($values['nombre'])) {
        $values['nombre'] = trim(strtoupper($values['nombre']));
      }
      if(!empty($values['descripcion'])) {
        $values['descripcion'] = trim(strtoupper($values['descripcion']));
      }
      return $values;
    }
   

}