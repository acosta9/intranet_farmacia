<?php

/**
 * Carrito form base class.
 *
 * @method Carrito getObject() Returns the current form's model object
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCarritoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'sf_guard_user_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => false)),
      'inventario_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Inventario'), 'add_empty' => true)),
      'oferta_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Oferta'), 'add_empty' => true)),
      'cantidad'         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'sf_guard_user_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'))),
      'inventario_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Inventario'), 'required' => false)),
      'oferta_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Oferta'), 'required' => false)),
      'cantidad'         => new sfValidatorString(array('max_length' => 100)),
    ));

    $this->widgetSchema->setNameFormat('carrito[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Carrito';
  }

}
