<?php

/**
 * NotaCredito filter form base class.
 *
 * @package    ired.localhost
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseNotaCreditoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'empresa_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'), 'add_empty' => true)),
      'cliente_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Cliente'), 'add_empty' => true)),
      'ncontrol'       => new sfWidgetFormFilterInput(),
      'moneda'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'forma_pago_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('FormaPago'), 'add_empty' => true)),
      'num_recibo'     => new sfWidgetFormFilterInput(),
      'fecha'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'monto'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'monto_faltante' => new sfWidgetFormFilterInput(),
      'quien_paga'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'url_imagen'     => new sfWidgetFormFilterInput(),
      'tasa_cambio'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'descripcion'    => new sfWidgetFormFilterInput(),
      'estatus'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_by'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'add_empty' => true)),
      'updated_by'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Updator'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'empresa_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Empresa'), 'column' => 'id')),
      'cliente_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Cliente'), 'column' => 'id')),
      'ncontrol'       => new sfValidatorPass(array('required' => false)),
      'moneda'         => new sfValidatorPass(array('required' => false)),
      'forma_pago_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('FormaPago'), 'column' => 'id')),
      'num_recibo'     => new sfValidatorPass(array('required' => false)),
      'fecha'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'monto'          => new sfValidatorPass(array('required' => false)),
      'monto_faltante' => new sfValidatorPass(array('required' => false)),
      'quien_paga'     => new sfValidatorPass(array('required' => false)),
      'url_imagen'     => new sfValidatorPass(array('required' => false)),
      'tasa_cambio'    => new sfValidatorPass(array('required' => false)),
      'descripcion'    => new sfValidatorPass(array('required' => false)),
      'estatus'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_by'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Creator'), 'column' => 'id')),
      'updated_by'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Updator'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('nota_credito_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'NotaCredito';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'empresa_id'     => 'ForeignKey',
      'cliente_id'     => 'ForeignKey',
      'ncontrol'       => 'Text',
      'moneda'         => 'Text',
      'forma_pago_id'  => 'ForeignKey',
      'num_recibo'     => 'Text',
      'fecha'          => 'Date',
      'monto'          => 'Text',
      'monto_faltante' => 'Text',
      'quien_paga'     => 'Text',
      'url_imagen'     => 'Text',
      'tasa_cambio'    => 'Text',
      'descripcion'    => 'Text',
      'estatus'        => 'Number',
      'created_at'     => 'Date',
      'updated_at'     => 'Date',
      'created_by'     => 'ForeignKey',
      'updated_by'     => 'ForeignKey',
    );
  }
}
