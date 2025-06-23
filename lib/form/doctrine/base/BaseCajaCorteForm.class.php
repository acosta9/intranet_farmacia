<?php

/**
 * CajaCorte form base class.
 *
 * @method CajaCorte getObject() Returns the current form's model object
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCajaCorteForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'caja_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Caja'), 'add_empty' => false)),
      'sf_guard_user_id' => new sfWidgetFormInputText(),
      'tipo'             => new sfWidgetFormInputCheckbox(),
      'fecha_ini'        => new sfWidgetFormDateTime(),
      'fecha_fin'        => new sfWidgetFormDateTime(),
      'ult_repz'         => new sfWidgetFormInputText(),
      'fecha_repz'       => new sfWidgetFormInputText(),
      'hora_repz'        => new sfWidgetFormInputText(),
      'ult_fact'         => new sfWidgetFormInputText(),
      'fecha_ult_fact'   => new sfWidgetFormInputText(),
      'hora_ult_fact'    => new sfWidgetFormInputText(),
      'ult_nc'           => new sfWidgetFormInputText(),
      'exento_fact'      => new sfWidgetFormInputText(),
      'base_impt1_fact'  => new sfWidgetFormInputText(),
      'iva_t1_fact'      => new sfWidgetFormInputText(),
      'exento_nc'        => new sfWidgetFormInputText(),
      'base_impt1_nc'    => new sfWidgetFormInputText(),
      'iva_t1_nc'        => new sfWidgetFormInputText(),
      'codigof'          => new sfWidgetFormInputText(),
      'cant_fact'        => new sfWidgetFormInputText(),
      'cant_nc'          => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'caja_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Caja'))),
      'sf_guard_user_id' => new sfValidatorInteger(),
      'tipo'             => new sfValidatorBoolean(array('required' => false)),
      'fecha_ini'        => new sfValidatorDateTime(),
      'fecha_fin'        => new sfValidatorDateTime(),
      'ult_repz'         => new sfValidatorString(array('max_length' => 5, 'required' => false)),
      'fecha_repz'       => new sfValidatorString(array('max_length' => 6, 'required' => false)),
      'hora_repz'        => new sfValidatorString(array('max_length' => 4, 'required' => false)),
      'ult_fact'         => new sfValidatorString(array('max_length' => 8, 'required' => false)),
      'fecha_ult_fact'   => new sfValidatorString(array('max_length' => 8, 'required' => false)),
      'hora_ult_fact'    => new sfValidatorString(array('max_length' => 4, 'required' => false)),
      'ult_nc'           => new sfValidatorString(array('max_length' => 8, 'required' => false)),
      'exento_fact'      => new sfValidatorString(array('max_length' => 18, 'required' => false)),
      'base_impt1_fact'  => new sfValidatorString(array('max_length' => 18, 'required' => false)),
      'iva_t1_fact'      => new sfValidatorString(array('max_length' => 18, 'required' => false)),
      'exento_nc'        => new sfValidatorString(array('max_length' => 18, 'required' => false)),
      'base_impt1_nc'    => new sfValidatorString(array('max_length' => 18, 'required' => false)),
      'iva_t1_nc'        => new sfValidatorString(array('max_length' => 18, 'required' => false)),
      'codigof'          => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'cant_fact'        => new sfValidatorInteger(array('required' => false)),
      'cant_nc'          => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('caja_corte[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CajaCorte';
  }

}
