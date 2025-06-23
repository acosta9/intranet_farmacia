<?php

/**
 * NotaEntrega filter form base class.
 *
 * @package    ired.localhost
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseNotaEntregaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'fecha'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'dias_credito'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'empresa_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'), 'add_empty' => true)),
      'deposito_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('InvDeposito'), 'add_empty' => true)),
      'cliente_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Cliente'), 'add_empty' => true)),
      'razon_social'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'doc_id'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'telf'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'direccion'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'direccion_entrega' => new sfWidgetFormFilterInput(),
      'ncontrol'          => new sfWidgetFormFilterInput(),
      'forma_pago'        => new sfWidgetFormFilterInput(),
      'tasa_cambio'       => new sfWidgetFormFilterInput(),
      'subtotal'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'subtotal_desc'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'iva'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'base_imponible'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'iva_monto'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'total'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'descuento'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'monto_faltante'    => new sfWidgetFormFilterInput(),
      'monto_pagado'      => new sfWidgetFormFilterInput(),
      'estatus'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_by'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'add_empty' => true)),
      'updated_by'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Updator'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'fecha'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'dias_credito'      => new sfValidatorPass(array('required' => false)),
      'empresa_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Empresa'), 'column' => 'id')),
      'deposito_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('InvDeposito'), 'column' => 'id')),
      'cliente_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Cliente'), 'column' => 'id')),
      'razon_social'      => new sfValidatorPass(array('required' => false)),
      'doc_id'            => new sfValidatorPass(array('required' => false)),
      'telf'              => new sfValidatorPass(array('required' => false)),
      'direccion'         => new sfValidatorPass(array('required' => false)),
      'direccion_entrega' => new sfValidatorPass(array('required' => false)),
      'ncontrol'          => new sfValidatorPass(array('required' => false)),
      'forma_pago'        => new sfValidatorPass(array('required' => false)),
      'tasa_cambio'       => new sfValidatorPass(array('required' => false)),
      'subtotal'          => new sfValidatorPass(array('required' => false)),
      'subtotal_desc'     => new sfValidatorPass(array('required' => false)),
      'iva'               => new sfValidatorPass(array('required' => false)),
      'base_imponible'    => new sfValidatorPass(array('required' => false)),
      'iva_monto'         => new sfValidatorPass(array('required' => false)),
      'total'             => new sfValidatorPass(array('required' => false)),
      'descuento'         => new sfValidatorPass(array('required' => false)),
      'monto_faltante'    => new sfValidatorPass(array('required' => false)),
      'monto_pagado'      => new sfValidatorPass(array('required' => false)),
      'estatus'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_by'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Creator'), 'column' => 'id')),
      'updated_by'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Updator'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('nota_entrega_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'NotaEntrega';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'fecha'             => 'Date',
      'dias_credito'      => 'Text',
      'empresa_id'        => 'ForeignKey',
      'deposito_id'       => 'ForeignKey',
      'cliente_id'        => 'ForeignKey',
      'razon_social'      => 'Text',
      'doc_id'            => 'Text',
      'telf'              => 'Text',
      'direccion'         => 'Text',
      'direccion_entrega' => 'Text',
      'ncontrol'          => 'Text',
      'forma_pago'        => 'Text',
      'tasa_cambio'       => 'Text',
      'subtotal'          => 'Text',
      'subtotal_desc'     => 'Text',
      'iva'               => 'Text',
      'base_imponible'    => 'Text',
      'iva_monto'         => 'Text',
      'total'             => 'Text',
      'descuento'         => 'Text',
      'monto_faltante'    => 'Text',
      'monto_pagado'      => 'Text',
      'estatus'           => 'Number',
      'created_at'        => 'Date',
      'updated_at'        => 'Date',
      'created_by'        => 'ForeignKey',
      'updated_by'        => 'ForeignKey',
    );
  }
}
