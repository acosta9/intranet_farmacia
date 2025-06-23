<?php

/**
 * Factura form base class.
 *
 * @method Factura getObject() Returns the current form's model object
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseFacturaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'fecha'             => new sfWidgetFormDate(),
      'dias_credito'      => new sfWidgetFormInputText(),
      'empresa_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'), 'add_empty' => false)),
      'deposito_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('InvDeposito'), 'add_empty' => false)),
      'cliente_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Cliente'), 'add_empty' => false)),
      'nota_entrega_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('NotaEntrega'), 'add_empty' => true)),
      'orden_compra_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('OrdenCompra'), 'add_empty' => true)),
      'caja_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Caja'), 'add_empty' => true)),
      'razon_social'      => new sfWidgetFormInputText(),
      'doc_id'            => new sfWidgetFormInputText(),
      'telf'              => new sfWidgetFormInputText(),
      'direccion'         => new sfWidgetFormTextarea(),
      'direccion_entrega' => new sfWidgetFormTextarea(),
      'ncontrol'          => new sfWidgetFormInputText(),
      'num_factura'       => new sfWidgetFormInputText(),
      'num_fact_fiscal'   => new sfWidgetFormInputText(),
      'codigof'           => new sfWidgetFormInputText(),
      'ndespacho'         => new sfWidgetFormInputText(),
      'forma_pago'        => new sfWidgetFormInputText(),
      'tasa_cambio'       => new sfWidgetFormInputText(),
      'subtotal'          => new sfWidgetFormInputText(),
      'subtotal_desc'     => new sfWidgetFormInputText(),
      'iva'               => new sfWidgetFormInputText(),
      'base_imponible'    => new sfWidgetFormInputText(),
      'iva_monto'         => new sfWidgetFormInputText(),
      'total'             => new sfWidgetFormInputText(),
      'total2'            => new sfWidgetFormInputText(),
      'descuento'         => new sfWidgetFormInputText(),
      'monto_faltante'    => new sfWidgetFormInputText(),
      'monto_pagado'      => new sfWidgetFormInputText(),
      'has_invoice'       => new sfWidgetFormInputCheckbox(),
      'estatus'           => new sfWidgetFormInputText(),
      'created_at'        => new sfWidgetFormDateTime(),
      'updated_at'        => new sfWidgetFormDateTime(),
      'created_by'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'add_empty' => true)),
      'updated_by'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Updator'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'fecha'             => new sfValidatorDate(),
      'dias_credito'      => new sfValidatorString(array('max_length' => 4)),
      'empresa_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'))),
      'deposito_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('InvDeposito'))),
      'cliente_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Cliente'))),
      'nota_entrega_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('NotaEntrega'), 'required' => false)),
      'orden_compra_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('OrdenCompra'), 'required' => false)),
      'caja_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Caja'), 'required' => false)),
      'razon_social'      => new sfValidatorString(array('max_length' => 200)),
      'doc_id'            => new sfValidatorString(array('max_length' => 20)),
      'telf'              => new sfValidatorString(array('max_length' => 20)),
      'direccion'         => new sfValidatorString(),
      'direccion_entrega' => new sfValidatorString(array('required' => false)),
      'ncontrol'          => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'num_factura'       => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'num_fact_fiscal'   => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'codigof'           => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'ndespacho'         => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'forma_pago'        => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'tasa_cambio'       => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'subtotal'          => new sfValidatorString(array('max_length' => 20)),
      'subtotal_desc'     => new sfValidatorString(array('max_length' => 20)),
      'iva'               => new sfValidatorString(array('max_length' => 20)),
      'base_imponible'    => new sfValidatorString(array('max_length' => 20)),
      'iva_monto'         => new sfValidatorString(array('max_length' => 20)),
      'total'             => new sfValidatorString(array('max_length' => 20)),
      'total2'            => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'descuento'         => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'monto_faltante'    => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'monto_pagado'      => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'has_invoice'       => new sfValidatorBoolean(array('required' => false)),
      'estatus'           => new sfValidatorInteger(array('required' => false)),
      'created_at'        => new sfValidatorDateTime(),
      'updated_at'        => new sfValidatorDateTime(),
      'created_by'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'required' => false)),
      'updated_by'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Updator'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('factura[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Factura';
  }

}
