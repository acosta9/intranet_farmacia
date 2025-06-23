<?php

/**
 * NotaCreditoDet form base class.
 *
 * @method NotaCreditoDet getObject() Returns the current form's model object
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseNotaCreditoDetForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'nota_credito_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('NotaCredito'), 'add_empty' => false)),
      'cuentas_cobrar_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CuentasCobrar'), 'add_empty' => false)),
      'monto'             => new sfWidgetFormInputText(),
      'descripcion'       => new sfWidgetFormTextarea(),
      'anulado'           => new sfWidgetFormInputCheckbox(),
      'created_at'        => new sfWidgetFormDateTime(),
      'updated_at'        => new sfWidgetFormDateTime(),
      'created_by'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'add_empty' => true)),
      'updated_by'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Updator'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'nota_credito_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('NotaCredito'))),
      'cuentas_cobrar_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CuentasCobrar'))),
      'monto'             => new sfValidatorString(array('max_length' => 20)),
      'descripcion'       => new sfValidatorString(array('required' => false)),
      'anulado'           => new sfValidatorBoolean(array('required' => false)),
      'created_at'        => new sfValidatorDateTime(),
      'updated_at'        => new sfValidatorDateTime(),
      'created_by'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'required' => false)),
      'updated_by'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Updator'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('nota_credito_det[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'NotaCreditoDet';
  }

}
