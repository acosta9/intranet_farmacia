<?php

/**
 * CotizacionCompraDet form base class.
 *
 * @method CotizacionCompraDet getObject() Returns the current form's model object
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCotizacionCompraDetForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'cotizacion_compra_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CotizacionCompra'), 'add_empty' => false)),
      'qty'                  => new sfWidgetFormInputText(),
      'price_unit'           => new sfWidgetFormInputText(),
      'price_tot'            => new sfWidgetFormInputText(),
      'producto_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Producto'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'cotizacion_compra_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CotizacionCompra'))),
      'qty'                  => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'price_unit'           => new sfValidatorString(array('max_length' => 20)),
      'price_tot'            => new sfValidatorString(array('max_length' => 20)),
      'producto_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Producto'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('cotizacion_compra_det[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CotizacionCompraDet';
  }

}
