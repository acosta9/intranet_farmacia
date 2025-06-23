<?php

/**
 * CotizacionCompra form base class.
 *
 * @method CotizacionCompra getObject() Returns the current form's model object
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCotizacionCompraForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'dias_credito'  => new sfWidgetFormInputText(),
      'empresa_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'), 'add_empty' => false)),
      'proveedor_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Proveedor'), 'add_empty' => false)),
      'razon_social'  => new sfWidgetFormInputText(),
      'doc_id'        => new sfWidgetFormInputText(),
      'telf'          => new sfWidgetFormInputText(),
      'direccion'     => new sfWidgetFormTextarea(),
      'ncontrol'      => new sfWidgetFormInputText(),
      'tasa_cambio'   => new sfWidgetFormInputText(),
      'descuento'     => new sfWidgetFormInputText(),
      'subtotal'      => new sfWidgetFormInputText(),
      'subtotal_desc' => new sfWidgetFormInputText(),
      'total'         => new sfWidgetFormInputText(),
      'estatus'       => new sfWidgetFormInputText(),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
      'created_by'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'add_empty' => true)),
      'updated_by'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Updator'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'dias_credito'  => new sfValidatorString(array('max_length' => 4)),
      'empresa_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'))),
      'proveedor_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Proveedor'))),
      'razon_social'  => new sfValidatorString(array('max_length' => 200)),
      'doc_id'        => new sfValidatorString(array('max_length' => 20)),
      'telf'          => new sfValidatorString(array('max_length' => 20)),
      'direccion'     => new sfValidatorString(),
      'ncontrol'      => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'tasa_cambio'   => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'descuento'     => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'subtotal'      => new sfValidatorString(array('max_length' => 20)),
      'subtotal_desc' => new sfValidatorString(array('max_length' => 20)),
      'total'         => new sfValidatorString(array('max_length' => 20)),
      'estatus'       => new sfValidatorInteger(array('required' => false)),
      'created_at'    => new sfValidatorDateTime(),
      'updated_at'    => new sfValidatorDateTime(),
      'created_by'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'required' => false)),
      'updated_by'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Updator'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('cotizacion_compra[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CotizacionCompra';
  }

}
