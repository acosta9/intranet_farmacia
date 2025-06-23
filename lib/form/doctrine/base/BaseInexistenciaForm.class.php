<?php

/**
 * Inexistencia form base class.
 *
 * @method Inexistencia getObject() Returns the current form's model object
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseInexistenciaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'nombre'           => new sfWidgetFormInputText(),
      'sf_guard_user_id' => new sfWidgetFormInputText(),
      'fecha'            => new sfWidgetFormDate(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'nombre'           => new sfValidatorString(array('max_length' => 100)),
      'sf_guard_user_id' => new sfValidatorInteger(),
      'fecha'            => new sfValidatorDate(),
    ));

    $this->widgetSchema->setNameFormat('inexistencia[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Inexistencia';
  }

}
