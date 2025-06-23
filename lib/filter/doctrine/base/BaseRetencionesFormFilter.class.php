<?php

/**
 * Retenciones filter form base class.
 *
 * @package    ired.localhost
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseRetencionesFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'empresa_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'), 'add_empty' => true)),
      'cliente_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Cliente'), 'add_empty' => true)),
      'cuentas_cobrar_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CuentasCobrar'), 'add_empty' => true)),
      'fecha'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'comprobante'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'base_imponible'    => new sfWidgetFormFilterInput(),
      'iva_impuesto'      => new sfWidgetFormFilterInput(),
      'monto'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'monto_usd'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'url_imagen'        => new sfWidgetFormFilterInput(),
      'tipo'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'descripcion'       => new sfWidgetFormFilterInput(),
      'anulado'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_by'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'add_empty' => true)),
      'updated_by'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Updator'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'empresa_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Empresa'), 'column' => 'id')),
      'cliente_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Cliente'), 'column' => 'id')),
      'cuentas_cobrar_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('CuentasCobrar'), 'column' => 'id')),
      'fecha'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'comprobante'       => new sfValidatorPass(array('required' => false)),
      'base_imponible'    => new sfValidatorPass(array('required' => false)),
      'iva_impuesto'      => new sfValidatorPass(array('required' => false)),
      'monto'             => new sfValidatorPass(array('required' => false)),
      'monto_usd'         => new sfValidatorPass(array('required' => false)),
      'url_imagen'        => new sfValidatorPass(array('required' => false)),
      'tipo'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'descripcion'       => new sfValidatorPass(array('required' => false)),
      'anulado'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_by'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Creator'), 'column' => 'id')),
      'updated_by'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Updator'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('retenciones_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Retenciones';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'empresa_id'        => 'ForeignKey',
      'cliente_id'        => 'ForeignKey',
      'cuentas_cobrar_id' => 'ForeignKey',
      'fecha'             => 'Date',
      'comprobante'       => 'Text',
      'base_imponible'    => 'Text',
      'iva_impuesto'      => 'Text',
      'monto'             => 'Text',
      'monto_usd'         => 'Text',
      'url_imagen'        => 'Text',
      'tipo'              => 'Number',
      'descripcion'       => 'Text',
      'anulado'           => 'Boolean',
      'created_at'        => 'Date',
      'updated_at'        => 'Date',
      'created_by'        => 'ForeignKey',
      'updated_by'        => 'ForeignKey',
    );
  }
}
