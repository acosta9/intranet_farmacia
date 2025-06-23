<?php

/**
 * CajaArqueo form base class.
 *
 * @method CajaArqueo getObject() Returns the current form's model object
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCajaArqueoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'caja_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Caja'), 'add_empty' => false)),
      'sf_guard_user_id' => new sfWidgetFormInputText(),
      'fecha'            => new sfWidgetFormDate(),
      'moneda'           => new sfWidgetFormInputText(),
      'forma_pago_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('FormaPago'), 'add_empty' => false)),
      'monto'            => new sfWidgetFormInputText(),
      'descripcion'      => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'caja_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Caja'))),
      'sf_guard_user_id' => new sfValidatorInteger(),
      'fecha'            => new sfValidatorDate(),
      'moneda'           => new sfValidatorPass(),
      'forma_pago_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('FormaPago'))),
      'monto'            => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'descripcion'      => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('caja_arqueo[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CajaArqueo';
  }

}
