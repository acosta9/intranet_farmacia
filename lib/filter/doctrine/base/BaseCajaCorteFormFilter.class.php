<?php

/**
 * CajaCorte filter form base class.
 *
 * @package    ired.localhost
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCajaCorteFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'caja_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Caja'), 'add_empty' => true)),
      'sf_guard_user_id' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'tipo'             => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'fecha_ini'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'fecha_fin'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'ult_repz'         => new sfWidgetFormFilterInput(),
      'fecha_repz'       => new sfWidgetFormFilterInput(),
      'hora_repz'        => new sfWidgetFormFilterInput(),
      'ult_fact'         => new sfWidgetFormFilterInput(),
      'fecha_ult_fact'   => new sfWidgetFormFilterInput(),
      'hora_ult_fact'    => new sfWidgetFormFilterInput(),
      'ult_nc'           => new sfWidgetFormFilterInput(),
      'exento_fact'      => new sfWidgetFormFilterInput(),
      'base_impt1_fact'  => new sfWidgetFormFilterInput(),
      'iva_t1_fact'      => new sfWidgetFormFilterInput(),
      'exento_nc'        => new sfWidgetFormFilterInput(),
      'base_impt1_nc'    => new sfWidgetFormFilterInput(),
      'iva_t1_nc'        => new sfWidgetFormFilterInput(),
      'codigof'          => new sfWidgetFormFilterInput(),
      'cant_fact'        => new sfWidgetFormFilterInput(),
      'cant_nc'          => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'caja_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Caja'), 'column' => 'id')),
      'sf_guard_user_id' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'tipo'             => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'fecha_ini'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'fecha_fin'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'ult_repz'         => new sfValidatorPass(array('required' => false)),
      'fecha_repz'       => new sfValidatorPass(array('required' => false)),
      'hora_repz'        => new sfValidatorPass(array('required' => false)),
      'ult_fact'         => new sfValidatorPass(array('required' => false)),
      'fecha_ult_fact'   => new sfValidatorPass(array('required' => false)),
      'hora_ult_fact'    => new sfValidatorPass(array('required' => false)),
      'ult_nc'           => new sfValidatorPass(array('required' => false)),
      'exento_fact'      => new sfValidatorPass(array('required' => false)),
      'base_impt1_fact'  => new sfValidatorPass(array('required' => false)),
      'iva_t1_fact'      => new sfValidatorPass(array('required' => false)),
      'exento_nc'        => new sfValidatorPass(array('required' => false)),
      'base_impt1_nc'    => new sfValidatorPass(array('required' => false)),
      'iva_t1_nc'        => new sfValidatorPass(array('required' => false)),
      'codigof'          => new sfValidatorPass(array('required' => false)),
      'cant_fact'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'cant_nc'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('caja_corte_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CajaCorte';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'caja_id'          => 'ForeignKey',
      'sf_guard_user_id' => 'Number',
      'tipo'             => 'Boolean',
      'fecha_ini'        => 'Date',
      'fecha_fin'        => 'Date',
      'ult_repz'         => 'Text',
      'fecha_repz'       => 'Text',
      'hora_repz'        => 'Text',
      'ult_fact'         => 'Text',
      'fecha_ult_fact'   => 'Text',
      'hora_ult_fact'    => 'Text',
      'ult_nc'           => 'Text',
      'exento_fact'      => 'Text',
      'base_impt1_fact'  => 'Text',
      'iva_t1_fact'      => 'Text',
      'exento_nc'        => 'Text',
      'base_impt1_nc'    => 'Text',
      'iva_t1_nc'        => 'Text',
      'codigof'          => 'Text',
      'cant_fact'        => 'Number',
      'cant_nc'          => 'Number',
    );
  }
}
