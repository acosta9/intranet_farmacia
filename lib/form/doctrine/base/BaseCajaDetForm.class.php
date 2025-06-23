<?php

/**
 * CajaDet form base class.
 *
 * @method CajaDet getObject() Returns the current form's model object
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCajaDetForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'caja_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Caja'), 'add_empty' => false)),
      'sf_guard_user_id' => new sfWidgetFormInputText(),
      'fecha'            => new sfWidgetFormDateTime(),
      'status'           => new sfWidgetFormInputCheckbox(),
      'fondo'            => new sfWidgetFormInputText(),
      'descripcion'      => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'caja_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Caja'))),
      'sf_guard_user_id' => new sfValidatorInteger(),
      'fecha'            => new sfValidatorDateTime(),
      'status'           => new sfValidatorBoolean(array('required' => false)),
      'fondo'            => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'descripcion'      => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('caja_det[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CajaDet';
  }

}
