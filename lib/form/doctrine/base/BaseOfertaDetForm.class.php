<?php

/**
 * OfertaDet form base class.
 *
 * @method OfertaDet getObject() Returns the current form's model object
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseOfertaDetForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'oferta_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Oferta'), 'add_empty' => false)),
      'inventario_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Inventario'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'oferta_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Oferta'))),
      'inventario_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Inventario'))),
    ));

    $this->widgetSchema->setNameFormat('oferta_det[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'OfertaDet';
  }

}
