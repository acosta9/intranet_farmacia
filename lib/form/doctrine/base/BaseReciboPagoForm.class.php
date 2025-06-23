<?php

/**
 * ReciboPago form base class.
 *
 * @method ReciboPago getObject() Returns the current form's model object
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseReciboPagoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'empresa_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'), 'add_empty' => false)),
      'cliente_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Cliente'), 'add_empty' => false)),
      'cuentas_cobrar_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CuentasCobrar'), 'add_empty' => false)),
      'ncontrol'          => new sfWidgetFormInputText(),
      'moneda'            => new sfWidgetFormInputText(),
      'forma_pago_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('FormaPago'), 'add_empty' => false)),
      'num_recibo'        => new sfWidgetFormInputText(),
      'fecha'             => new sfWidgetFormDate(),
      'monto'             => new sfWidgetFormInputText(),
      'monto2'            => new sfWidgetFormInputText(),
      'quien_paga'        => new sfWidgetFormInputText(),
      'url_imagen'        => new sfWidgetFormInputText(),
      'tasa_cambio'       => new sfWidgetFormInputText(),
      'descripcion'       => new sfWidgetFormTextarea(),
      'anulado'           => new sfWidgetFormInputCheckbox(),
      'created_at'        => new sfWidgetFormDateTime(),
      'updated_at'        => new sfWidgetFormDateTime(),
      'created_by'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'add_empty' => true)),
      'updated_by'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Updator'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'empresa_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'))),
      'cliente_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Cliente'))),
      'cuentas_cobrar_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CuentasCobrar'))),
      'ncontrol'          => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'moneda'            => new sfValidatorPass(),
      'forma_pago_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('FormaPago'))),
      'num_recibo'        => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'fecha'             => new sfValidatorDate(),
      'monto'             => new sfValidatorString(array('max_length' => 20)),
      'monto2'            => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'quien_paga'        => new sfValidatorString(array('max_length' => 200)),
      'url_imagen'        => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'tasa_cambio'       => new sfValidatorString(array('max_length' => 20)),
      'descripcion'       => new sfValidatorString(array('required' => false)),
      'anulado'           => new sfValidatorBoolean(array('required' => false)),
      'created_at'        => new sfValidatorDateTime(),
      'updated_at'        => new sfValidatorDateTime(),
      'created_by'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'required' => false)),
      'updated_by'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Updator'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('recibo_pago[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ReciboPago';
  }

}
