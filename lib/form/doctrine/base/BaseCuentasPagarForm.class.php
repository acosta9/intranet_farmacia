<?php

/**
 * CuentasPagar form base class.
 *
 * @method CuentasPagar getObject() Returns the current form's model object
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCuentasPagarForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'fecha'             => new sfWidgetFormDate(),
      'fecha_recepcion'   => new sfWidgetFormDate(),
      'empresa_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'), 'add_empty' => false)),
      'proveedor_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Proveedor'), 'add_empty' => false)),
      'factura_compra_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('FacturaCompra'), 'add_empty' => true)),
      'factura_gastos_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('FacturaGastos'), 'add_empty' => true)),
      'total'             => new sfWidgetFormInputText(),
      'monto_faltante'    => new sfWidgetFormInputText(),
      'monto_pagado'      => new sfWidgetFormInputText(),
      'total_bs'          => new sfWidgetFormInputText(),
      'monto_faltante_bs' => new sfWidgetFormInputText(),
      'monto_pagado_bs'   => new sfWidgetFormInputText(),
      'tasa_cambio'       => new sfWidgetFormInputText(),
      'estatus'           => new sfWidgetFormInputText(),
      'created_at'        => new sfWidgetFormDateTime(),
      'updated_at'        => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'fecha'             => new sfValidatorDate(),
      'fecha_recepcion'   => new sfValidatorDate(),
      'empresa_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'))),
      'proveedor_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Proveedor'))),
      'factura_compra_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('FacturaCompra'), 'required' => false)),
      'factura_gastos_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('FacturaGastos'), 'required' => false)),
      'total'             => new sfValidatorString(array('max_length' => 20)),
      'monto_faltante'    => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'monto_pagado'      => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'total_bs'          => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'monto_faltante_bs' => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'monto_pagado_bs'   => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'tasa_cambio'       => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'estatus'           => new sfValidatorInteger(array('required' => false)),
      'created_at'        => new sfValidatorDateTime(),
      'updated_at'        => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('cuentas_pagar[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CuentasPagar';
  }

}
