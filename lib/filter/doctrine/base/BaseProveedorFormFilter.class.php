<?php

/**
 * Proveedor filter form base class.
 *
 * @package    ired.localhost
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseProveedorFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'full_name'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'doc_id'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'direccion'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'telf'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'celular'     => new sfWidgetFormFilterInput(),
      'email'       => new sfWidgetFormFilterInput(),
      'tipo'        => new sfWidgetFormFilterInput(),
      'activo'      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'descripcion' => new sfWidgetFormFilterInput(),
      'created_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_by'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'add_empty' => true)),
      'updated_by'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Updator'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'full_name'   => new sfValidatorPass(array('required' => false)),
      'doc_id'      => new sfValidatorPass(array('required' => false)),
      'direccion'   => new sfValidatorPass(array('required' => false)),
      'telf'        => new sfValidatorPass(array('required' => false)),
      'celular'     => new sfValidatorPass(array('required' => false)),
      'email'       => new sfValidatorPass(array('required' => false)),
      'tipo'        => new sfValidatorPass(array('required' => false)),
      'activo'      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'descripcion' => new sfValidatorPass(array('required' => false)),
      'created_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_by'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Creator'), 'column' => 'id')),
      'updated_by'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Updator'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('proveedor_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Proveedor';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'full_name'   => 'Text',
      'doc_id'      => 'Text',
      'direccion'   => 'Text',
      'telf'        => 'Text',
      'celular'     => 'Text',
      'email'       => 'Text',
      'tipo'        => 'Text',
      'activo'      => 'Boolean',
      'descripcion' => 'Text',
      'created_at'  => 'Date',
      'updated_at'  => 'Date',
      'created_by'  => 'ForeignKey',
      'updated_by'  => 'ForeignKey',
    );
  }
}
