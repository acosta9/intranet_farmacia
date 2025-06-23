<?php

/**
 * Otros form.
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class OtrosForm extends BaseOtrosForm
{
  public function configure()
  {
    unset(
      $this['created_at'],
      $this['updated_at'],
      $this['created_by'],
      $this['updated_by']
    );


    $this->widgetSchema['nombre']->setAttributes(array('class' => 'form-control', 'required' => 'required'));
    $this->widgetSchema['valor']->setAttributes(array('class' => 'form-control money', 'required' => 'required'));

    $this->setValidators(array(
       'id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
       'empresa_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'))),
       'nombre'   => new sfValidatorString(array('max_length' => 100, 'min_length' => 2, 'required'=> true), array(
         'required'   => 'Requerido',
          'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
          'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
          'invalid'=> 'Campo invalido.'
       )),
       'valor'   => new sfValidatorString(array('max_length' => 100, 'min_length' => 1, 'required'=> true), array(
         'required'   => 'Requerido',
          'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
          'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
          'invalid'=> 'Campo invalido.'
       )),
    ));
    $this->validatorSchema->setPostValidator(
      new sfValidatorCallback(array('callback' => array($this, 'validaciones')))
    );
  }
  public function validaciones($validator, $values) {
    if(!empty($values['valor'])) {
      $money=str_replace(".","",$values['valor']);
      $money=str_replace(",",".",$money);
      $values['valor'] = floatval($money);
    } else {
      $error = new sfValidatorError($validator, 'Campo requerido');
      throw new sfValidatorErrorSchema($validator, array('valor' => $error));
    }
    return $values;
  }
}
