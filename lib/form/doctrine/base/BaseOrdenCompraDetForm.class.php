<?php

/**
 * OrdenCompraDet form base class.
 *
 * @method OrdenCompraDet getObject() Returns the current form's model object
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseOrdenCompraDetForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'orden_compra_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('OrdenCompra'), 'add_empty' => true)),
      'qty'             => new sfWidgetFormInputText(),
      'price_unit'      => new sfWidgetFormInputText(),
      'price_tot'       => new sfWidgetFormInputText(),
      'inventario_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Inventario'), 'add_empty' => true)),
      'oferta_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Oferta'), 'add_empty' => true)),
      'descripcion'     => new sfWidgetFormTextarea(),
      'exento'          => new sfWidgetFormInputText(),
      'tasa_cambio'     => new sfWidgetFormInputText(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'orden_compra_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('OrdenCompra'), 'required' => false)),
      'qty'             => new sfValidatorString(array('max_length' => 200)),
      'price_unit'      => new sfValidatorString(array('max_length' => 20)),
      'price_tot'       => new sfValidatorString(array('max_length' => 20)),
      'inventario_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Inventario'), 'required' => false)),
      'oferta_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Oferta'), 'required' => false)),
      'descripcion'     => new sfValidatorString(array('required' => false)),
      'exento'          => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'tasa_cambio'     => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'created_at'      => new sfValidatorDateTime(),
      'updated_at'      => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('orden_compra_det[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'OrdenCompraDet';
  }

}
