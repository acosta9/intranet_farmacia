<?php

/**
 * Compuesto form.
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CompuestoForm extends BaseCompuestoForm
{
  public function configure()
  {
    unset(
      $this['created_at'],
      $this['updated_at'],
      $this['created_by'],
      $this['updated_by']
    );

    $this->setWidget('nombre', new sfWidgetFormInputText());
    $this->setWidget('descripcion', new sfWidgetFormInputText());
    $this->widgetSchema['nombre']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['descripcion']->setAttributes(array('class' => 'form-control'));

    $this->setValidators(array(
       'id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
       'nombre'   => new sfValidatorString(array('max_length' => 400, 'min_length' => 2, 'required'=> true), array(
         'required'   => 'Requerido',
          'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
          'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
          'invalid'=> 'Campo invalido.'
       )),
      'descripcion'   => new sfValidatorString(array('max_length' => 2000, 'min_length' => 2, 'required'=> false), array(
          'required'   => 'Requerido',
          'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
          'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
          'invalid'=> 'Campo invalido.'
       )),
      ));

      $this->validatorSchema->setPostValidator(
        new sfValidatorAnd(array(
          new sfValidatorDoctrineUnique(array('model' => 'Compuesto', 'column' => array('nombre')), array(
            'invalid'=> 'Compuesto ya existente.')),
          new sfValidatorCallback(array('callback' => array($this, 'validaciones')))
        ))
      );
  }

  public function validaciones($validator, $values) {
    if(!empty($values['nombre'])) {
      $valor_first=strlen($values['nombre']);
      $valor_last=strlen(preg_replace("/[^a-z0-9A-Z_ ñÑ]/", "", $values['nombre']));

      if($valor_first != $valor_last) {
        $error = new sfValidatorError($validator, 'Solo se permiten letras y numeros');
        throw new sfValidatorErrorSchema($validator, array('nombre' => $error));
      }
    }

    $values['nombre'] = trim(mb_strtoupper($values['nombre']));
    if(!empty($values['descripcion'])) {
      $values['descripcion'] = trim(strtoupper($values['descripcion']));
    }
    return $values;
  }
}
