<?php

/**
 * CajaDet filter form base class.
 *
 * @package    ired.localhost
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCajaDetFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'caja_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Caja'), 'add_empty' => true)),
      'sf_guard_user_id' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'fecha'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'status'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'fondo'            => new sfWidgetFormFilterInput(),
      'descripcion'      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'caja_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Caja'), 'column' => 'id')),
      'sf_guard_user_id' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'fecha'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'status'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'fondo'            => new sfValidatorPass(array('required' => false)),
      'descripcion'      => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('caja_det_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CajaDet';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'caja_id'          => 'ForeignKey',
      'sf_guard_user_id' => 'Number',
      'fecha'            => 'Date',
      'status'           => 'Boolean',
      'fondo'            => 'Text',
      'descripcion'      => 'Text',
    );
  }
}
