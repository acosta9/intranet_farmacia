<?php

/**
 * NotaDebitoDet form base class.
 *
 * @method NotaDebitoDet getObject() Returns the current form's model object
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseNotaDebitoDetForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'nota_debito_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('NotaDebito'), 'add_empty' => false)),
      'cuentas_pagar_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CuentasPagar'), 'add_empty' => false)),
      'monto'            => new sfWidgetFormInputText(),
      'descripcion'      => new sfWidgetFormTextarea(),
      'anulado'          => new sfWidgetFormInputCheckbox(),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
      'created_by'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'add_empty' => true)),
      'updated_by'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Updator'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'nota_debito_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('NotaDebito'))),
      'cuentas_pagar_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CuentasPagar'))),
      'monto'            => new sfValidatorString(array('max_length' => 20)),
      'descripcion'      => new sfValidatorString(array('required' => false)),
      'anulado'          => new sfValidatorBoolean(array('required' => false)),
      'created_at'       => new sfValidatorDateTime(),
      'updated_at'       => new sfValidatorDateTime(),
      'created_by'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'required' => false)),
      'updated_by'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Updator'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('nota_debito_det[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'NotaDebitoDet';
  }

}
