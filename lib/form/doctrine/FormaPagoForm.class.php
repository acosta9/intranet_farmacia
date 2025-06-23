<?php

/**
 * FormaPago form.
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class FormaPagoForm extends BaseFormaPagoForm
{
  public function configure()
  {
    unset(
      $this['created_at'],
      $this['updated_at'],
      $this['created_by'],
      $this['updated_by']
    );

    $this->setWidget('id', new sfWidgetFormInputText());
    $this->setWidget('moneda', new sfWidgetFormChoice(array('choices' => array(1 => 'BOLIVARES', 2 => 'DOLARES'))));
    $this->setWidget('activo', new sfWidgetFormChoice(array('choices' => array(0 => 'DES-HABILITADO', 1 => 'HABILITADO'))));

    $this->widgetSchema['id']->setAttributes(array('class' => 'form-control number3', 'required' => 'required'));
    $this->widgetSchema['moneda']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['nombre']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['acronimo']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['activo']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['descripcion']->setAttributes(array('class' => 'form-control'));

    $this->setValidators(array(
       'id' => new sfValidatorInteger(array('required' => true)),
       'nombre'   => new sfValidatorString(array('max_length' => 200, 'min_length' => 2, 'required'=> true), array(
         'required'   => 'Requerido',
          'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
          'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
          'invalid'=> 'Campo invalido.'
       )),
       'acronimo'   => new sfValidatorString(array('max_length' => 20, 'min_length' => 2, 'required'=> true), array(
        'required'   => 'Requerido',
        'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
        'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
        'invalid'=> 'Campo invalido.'
       )),
      'moneda'   => new sfValidatorPass(),
      'activo'   => new sfValidatorPass(),
      'descripcion'   => new sfValidatorString(array('max_length' => 2000, 'min_length' => 2, 'required'=> false), array(
          'required'   => 'Requerido',
          'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
          'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
          'invalid'=> 'Campo invalido.'
       )),
      ));

      $this->validatorSchema->setPostValidator(
        new sfValidatorAnd(array(
          new sfValidatorDoctrineUnique(array('model' => 'FormaPago', 'column' => array('id')), array(
            'invalid'=> 'Codigo ya existente')),
          new sfValidatorCallback(array('callback' => array($this, 'validaciones')))
        ))
      );

  }

  public function validaciones($validator, $values) {
    if(!empty($values['id']) && $this->isNew()) {
      $result=Doctrine_Core::getTable('FormaPago')->findOneBy('id',$values['id']);
      if($result) {
        $error = new sfValidatorError($validator, 'Codigo ya existente');
        throw new sfValidatorErrorSchema($validator, array('id' => $error));
      }
    }

    if(!empty($values['nombre'])) {
      $valor_first=strlen($values['nombre']);
      $valor_last=strlen(preg_replace("/[^a-z0-9A-Z ]/", "", $values['nombre']));

      if($valor_first != $valor_last) {
        $error = new sfValidatorError($validator, 'Solo se permiten letras y numeros');
        throw new sfValidatorErrorSchema($validator, array('nombre' => $error));
      }
    }

    if(!empty($values['acronimo'])) {
      $valor_first=strlen($values['acronimo']);
      $valor_last=strlen(preg_replace("/[^a-z0-9A-Z ]/", "", $values['acronimo']));

      if($valor_first != $valor_last) {
        $error = new sfValidatorError($validator, 'Solo se permiten letras y numeros');
        throw new sfValidatorErrorSchema($validator, array('acronimo' => $error));
      }
    }

    $values['nombre'] = trim(strtoupper($values['nombre']));
    $values['acronimo'] = trim(strtoupper($values['acronimo']));
    if(!empty($values['descripcion'])) {
      $values['descripcion'] = trim(strtoupper($values['descripcion']));
    } else {
      $values['descripcion'] = NULL;
    }
    return $values;
  }
}
