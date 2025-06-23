<?php

/**
 * CuentasCobrar filter form base class.
 *
 * @package    ired.localhost
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCuentasCobrarFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'fecha'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'dias_credito'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'empresa_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'), 'add_empty' => true)),
      'cliente_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Cliente'), 'add_empty' => true)),
      'factura_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Factura'), 'add_empty' => true)),
      'nota_entrega_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('NotaEntrega'), 'add_empty' => true)),
      'total'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'monto_faltante'  => new sfWidgetFormFilterInput(),
      'monto_pagado'    => new sfWidgetFormFilterInput(),
      'tasa_cambio'     => new sfWidgetFormFilterInput(),
      'estatus'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'fecha'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'dias_credito'    => new sfValidatorPass(array('required' => false)),
      'empresa_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Empresa'), 'column' => 'id')),
      'cliente_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Cliente'), 'column' => 'id')),
      'factura_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Factura'), 'column' => 'id')),
      'nota_entrega_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('NotaEntrega'), 'column' => 'id')),
      'total'           => new sfValidatorPass(array('required' => false)),
      'monto_faltante'  => new sfValidatorPass(array('required' => false)),
      'monto_pagado'    => new sfValidatorPass(array('required' => false)),
      'tasa_cambio'     => new sfValidatorPass(array('required' => false)),
      'estatus'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('cuentas_cobrar_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CuentasCobrar';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'fecha'           => 'Date',
      'dias_credito'    => 'Text',
      'empresa_id'      => 'ForeignKey',
      'cliente_id'      => 'ForeignKey',
      'factura_id'      => 'ForeignKey',
      'nota_entrega_id' => 'ForeignKey',
      'total'           => 'Text',
      'monto_faltante'  => 'Text',
      'monto_pagado'    => 'Text',
      'tasa_cambio'     => 'Text',
      'estatus'         => 'Number',
      'created_at'      => 'Date',
      'updated_at'      => 'Date',
    );
  }
}
