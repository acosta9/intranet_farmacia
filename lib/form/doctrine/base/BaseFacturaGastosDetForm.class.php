<?php

/**
 * FacturaGastosDet form base class.
 *
 * @method FacturaGastosDet getObject() Returns the current form's model object
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseFacturaGastosDetForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'factura_gastos_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('FacturaGastos'), 'add_empty' => false)),
      'qty'               => new sfWidgetFormInputText(),
      'price_unit'        => new sfWidgetFormInputText(),
      'price_tot'         => new sfWidgetFormInputText(),
      'exento'            => new sfWidgetFormInputText(),
      'descripcion'       => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'factura_gastos_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('FacturaGastos'))),
      'qty'               => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'price_unit'        => new sfValidatorString(array('max_length' => 20)),
      'price_tot'         => new sfValidatorString(array('max_length' => 20)),
      'exento'            => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'descripcion'       => new sfValidatorString(),
    ));

    $this->widgetSchema->setNameFormat('factura_gastos_det[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'FacturaGastosDet';
  }

}
