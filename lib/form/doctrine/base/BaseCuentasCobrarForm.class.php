<?php

/**
 * CuentasCobrar form base class.
 *
 * @method CuentasCobrar getObject() Returns the current form's model object
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCuentasCobrarForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'fecha'           => new sfWidgetFormDate(),
      'dias_credito'    => new sfWidgetFormInputText(),
      'empresa_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'), 'add_empty' => false)),
      'cliente_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Cliente'), 'add_empty' => false)),
      'factura_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Factura'), 'add_empty' => true)),
      'nota_entrega_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('NotaEntrega'), 'add_empty' => true)),
      'total'           => new sfWidgetFormInputText(),
      'monto_faltante'  => new sfWidgetFormInputText(),
      'monto_pagado'    => new sfWidgetFormInputText(),
      'tasa_cambio'     => new sfWidgetFormInputText(),
      'estatus'         => new sfWidgetFormInputText(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'fecha'           => new sfValidatorDate(),
      'dias_credito'    => new sfValidatorString(array('max_length' => 4)),
      'empresa_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'))),
      'cliente_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Cliente'))),
      'factura_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Factura'), 'required' => false)),
      'nota_entrega_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('NotaEntrega'), 'required' => false)),
      'total'           => new sfValidatorString(array('max_length' => 20)),
      'monto_faltante'  => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'monto_pagado'    => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'tasa_cambio'     => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'estatus'         => new sfValidatorInteger(array('required' => false)),
      'created_at'      => new sfValidatorDateTime(),
      'updated_at'      => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('cuentas_cobrar[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CuentasCobrar';
  }

}
