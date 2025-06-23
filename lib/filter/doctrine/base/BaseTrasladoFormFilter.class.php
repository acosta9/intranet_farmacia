<?php

/**
 * Traslado filter form base class.
 *
 * @package    ired.localhost
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseTrasladoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'ncontrol'       => new sfWidgetFormFilterInput(),
      'empresa_desde'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'), 'add_empty' => true)),
      'deposito_desde' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('InvDeposito'), 'add_empty' => true)),
      'empresa_hasta'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa2'), 'add_empty' => true)),
      'deposito_hasta' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('InvDeposito2'), 'add_empty' => true)),
      'estatus'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'tasa_cambio'    => new sfWidgetFormFilterInput(),
      'monto'          => new sfWidgetFormFilterInput(),
      'created_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_by'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'add_empty' => true)),
      'updated_by'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Updator'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'ncontrol'       => new sfValidatorPass(array('required' => false)),
      'empresa_desde'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Empresa'), 'column' => 'id')),
      'deposito_desde' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('InvDeposito'), 'column' => 'id')),
      'empresa_hasta'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Empresa2'), 'column' => 'id')),
      'deposito_hasta' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('InvDeposito2'), 'column' => 'id')),
      'estatus'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'tasa_cambio'    => new sfValidatorPass(array('required' => false)),
      'monto'          => new sfValidatorPass(array('required' => false)),
      'created_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_by'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Creator'), 'column' => 'id')),
      'updated_by'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Updator'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('traslado_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Traslado';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'ncontrol'       => 'Text',
      'empresa_desde'  => 'ForeignKey',
      'deposito_desde' => 'ForeignKey',
      'empresa_hasta'  => 'ForeignKey',
      'deposito_hasta' => 'ForeignKey',
      'estatus'        => 'Number',
      'tasa_cambio'    => 'Text',
      'monto'          => 'Text',
      'created_at'     => 'Date',
      'updated_at'     => 'Date',
      'created_by'     => 'ForeignKey',
      'updated_by'     => 'ForeignKey',
    );
  }
}
