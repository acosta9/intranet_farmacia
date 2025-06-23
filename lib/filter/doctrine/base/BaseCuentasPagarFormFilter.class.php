<?php

/**
 * CuentasPagar filter form base class.
 *
 * @package    ired.localhost
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCuentasPagarFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'fecha'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'fecha_recepcion'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'empresa_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'), 'add_empty' => true)),
      'proveedor_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Proveedor'), 'add_empty' => true)),
      'factura_compra_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('FacturaCompra'), 'add_empty' => true)),
      'factura_gastos_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('FacturaGastos'), 'add_empty' => true)),
      'total'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'monto_faltante'    => new sfWidgetFormFilterInput(),
      'monto_pagado'      => new sfWidgetFormFilterInput(),
      'total_bs'          => new sfWidgetFormFilterInput(),
      'monto_faltante_bs' => new sfWidgetFormFilterInput(),
      'monto_pagado_bs'   => new sfWidgetFormFilterInput(),
      'tasa_cambio'       => new sfWidgetFormFilterInput(),
      'estatus'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'fecha'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'fecha_recepcion'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'empresa_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Empresa'), 'column' => 'id')),
      'proveedor_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Proveedor'), 'column' => 'id')),
      'factura_compra_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('FacturaCompra'), 'column' => 'id')),
      'factura_gastos_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('FacturaGastos'), 'column' => 'id')),
      'total'             => new sfValidatorPass(array('required' => false)),
      'monto_faltante'    => new sfValidatorPass(array('required' => false)),
      'monto_pagado'      => new sfValidatorPass(array('required' => false)),
      'total_bs'          => new sfValidatorPass(array('required' => false)),
      'monto_faltante_bs' => new sfValidatorPass(array('required' => false)),
      'monto_pagado_bs'   => new sfValidatorPass(array('required' => false)),
      'tasa_cambio'       => new sfValidatorPass(array('required' => false)),
      'estatus'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('cuentas_pagar_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CuentasPagar';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'fecha'             => 'Date',
      'fecha_recepcion'   => 'Date',
      'empresa_id'        => 'ForeignKey',
      'proveedor_id'      => 'ForeignKey',
      'factura_compra_id' => 'ForeignKey',
      'factura_gastos_id' => 'ForeignKey',
      'total'             => 'Text',
      'monto_faltante'    => 'Text',
      'monto_pagado'      => 'Text',
      'total_bs'          => 'Text',
      'monto_faltante_bs' => 'Text',
      'monto_pagado_bs'   => 'Text',
      'tasa_cambio'       => 'Text',
      'estatus'           => 'Number',
      'created_at'        => 'Date',
      'updated_at'        => 'Date',
    );
  }
}
