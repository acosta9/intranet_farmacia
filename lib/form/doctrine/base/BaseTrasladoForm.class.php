<?php

/**
 * Traslado form base class.
 *
 * @method Traslado getObject() Returns the current form's model object
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseTrasladoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'ncontrol'       => new sfWidgetFormInputText(),
      'empresa_desde'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'), 'add_empty' => false)),
      'deposito_desde' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('InvDeposito'), 'add_empty' => false)),
      'empresa_hasta'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa2'), 'add_empty' => false)),
      'deposito_hasta' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('InvDeposito2'), 'add_empty' => false)),
      'estatus'        => new sfWidgetFormInputText(),
      'tasa_cambio'    => new sfWidgetFormInputText(),
      'monto'          => new sfWidgetFormInputText(),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
      'created_by'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'add_empty' => true)),
      'updated_by'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Updator'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'ncontrol'       => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'empresa_desde'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'))),
      'deposito_desde' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('InvDeposito'))),
      'empresa_hasta'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa2'))),
      'deposito_hasta' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('InvDeposito2'))),
      'estatus'        => new sfValidatorInteger(array('required' => false)),
      'tasa_cambio'    => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'monto'          => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'created_at'     => new sfValidatorDateTime(),
      'updated_at'     => new sfValidatorDateTime(),
      'created_by'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'required' => false)),
      'updated_by'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Updator'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('traslado[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Traslado';
  }

}
