<?php

/**
 * Retenciones form base class.
 *
 * @method Retenciones getObject() Returns the current form's model object
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseRetencionesForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'empresa_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'), 'add_empty' => false)),
      'cliente_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Cliente'), 'add_empty' => false)),
      'cuentas_cobrar_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CuentasCobrar'), 'add_empty' => false)),
      'fecha'             => new sfWidgetFormDate(),
      'comprobante'       => new sfWidgetFormInputText(),
      'base_imponible'    => new sfWidgetFormInputText(),
      'iva_impuesto'      => new sfWidgetFormInputText(),
      'monto'             => new sfWidgetFormInputText(),
      'monto_usd'         => new sfWidgetFormInputText(),
      'url_imagen'        => new sfWidgetFormInputText(),
      'tipo'              => new sfWidgetFormInputText(),
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
      'fecha'             => new sfValidatorDate(),
      'comprobante'       => new sfValidatorString(array('max_length' => 20)),
      'base_imponible'    => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'iva_impuesto'      => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'monto'             => new sfValidatorString(array('max_length' => 20)),
      'monto_usd'         => new sfValidatorString(array('max_length' => 20)),
      'url_imagen'        => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'tipo'              => new sfValidatorInteger(),
      'descripcion'       => new sfValidatorString(array('required' => false)),
      'anulado'           => new sfValidatorBoolean(array('required' => false)),
      'created_at'        => new sfValidatorDateTime(),
      'updated_at'        => new sfValidatorDateTime(),
      'created_by'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'required' => false)),
      'updated_by'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Updator'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('retenciones[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Retenciones';
  }

}
