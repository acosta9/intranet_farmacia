<?php

/**
 * InvAjuste filter form base class.
 *
 * @package    ired.localhost
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseInvAjusteFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'empresa_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'), 'add_empty' => true)),
      'deposito_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('InvDeposito'), 'add_empty' => true)),
      'ncontrol'    => new sfWidgetFormFilterInput(),
      'tasa_cambio' => new sfWidgetFormFilterInput(),
      'total'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'anulado'     => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'descripcion' => new sfWidgetFormFilterInput(),
      'created_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_by'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'add_empty' => true)),
      'updated_by'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Updator'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'empresa_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Empresa'), 'column' => 'id')),
      'deposito_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('InvDeposito'), 'column' => 'id')),
      'ncontrol'    => new sfValidatorPass(array('required' => false)),
      'tasa_cambio' => new sfValidatorPass(array('required' => false)),
      'total'       => new sfValidatorPass(array('required' => false)),
      'anulado'     => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'descripcion' => new sfValidatorPass(array('required' => false)),
      'created_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_by'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Creator'), 'column' => 'id')),
      'updated_by'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Updator'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('inv_ajuste_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'InvAjuste';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'empresa_id'  => 'ForeignKey',
      'deposito_id' => 'ForeignKey',
      'ncontrol'    => 'Text',
      'tasa_cambio' => 'Text',
      'total'       => 'Text',
      'anulado'     => 'Boolean',
      'descripcion' => 'Text',
      'created_at'  => 'Date',
      'updated_at'  => 'Date',
      'created_by'  => 'ForeignKey',
      'updated_by'  => 'ForeignKey',
    );
  }
}
