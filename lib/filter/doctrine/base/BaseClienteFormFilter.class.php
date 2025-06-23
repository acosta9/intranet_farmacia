<?php

/**
 * Cliente filter form base class.
 *
 * @package    ired.localhost
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseClienteFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'empresa_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'), 'add_empty' => true)),
      'full_name'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'doc_id'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'sicm'               => new sfWidgetFormFilterInput(),
      'zona'               => new sfWidgetFormFilterInput(),
      'direccion'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'telf'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'celular'            => new sfWidgetFormFilterInput(),
      'email'              => new sfWidgetFormFilterInput(),
      'tipo_precio'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'dias_credito'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'activo'             => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'descripcion'        => new sfWidgetFormFilterInput(),
      'vendedor_01'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'vendedor_01_profit' => new sfWidgetFormFilterInput(),
      'vendedor_02'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User2'), 'add_empty' => true)),
      'vendedor_02_profit' => new sfWidgetFormFilterInput(),
      'created_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_by'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'add_empty' => true)),
      'updated_by'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Updator'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'empresa_id'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Empresa'), 'column' => 'id')),
      'full_name'          => new sfValidatorPass(array('required' => false)),
      'doc_id'             => new sfValidatorPass(array('required' => false)),
      'sicm'               => new sfValidatorPass(array('required' => false)),
      'zona'               => new sfValidatorPass(array('required' => false)),
      'direccion'          => new sfValidatorPass(array('required' => false)),
      'telf'               => new sfValidatorPass(array('required' => false)),
      'celular'            => new sfValidatorPass(array('required' => false)),
      'email'              => new sfValidatorPass(array('required' => false)),
      'tipo_precio'        => new sfValidatorPass(array('required' => false)),
      'dias_credito'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'activo'             => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'descripcion'        => new sfValidatorPass(array('required' => false)),
      'vendedor_01'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('User'), 'column' => 'id')),
      'vendedor_01_profit' => new sfValidatorPass(array('required' => false)),
      'vendedor_02'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('User2'), 'column' => 'id')),
      'vendedor_02_profit' => new sfValidatorPass(array('required' => false)),
      'created_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_by'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Creator'), 'column' => 'id')),
      'updated_by'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Updator'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('cliente_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Cliente';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'empresa_id'         => 'ForeignKey',
      'full_name'          => 'Text',
      'doc_id'             => 'Text',
      'sicm'               => 'Text',
      'zona'               => 'Text',
      'direccion'          => 'Text',
      'telf'               => 'Text',
      'celular'            => 'Text',
      'email'              => 'Text',
      'tipo_precio'        => 'Text',
      'dias_credito'       => 'Number',
      'activo'             => 'Boolean',
      'descripcion'        => 'Text',
      'vendedor_01'        => 'ForeignKey',
      'vendedor_01_profit' => 'Text',
      'vendedor_02'        => 'ForeignKey',
      'vendedor_02_profit' => 'Text',
      'created_at'         => 'Date',
      'updated_at'         => 'Date',
      'created_by'         => 'ForeignKey',
      'updated_by'         => 'ForeignKey',
    );
  }
}
