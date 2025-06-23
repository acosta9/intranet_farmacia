<?php

/**
 * NotaDebito form base class.
 *
 * @method NotaDebito getObject() Returns the current form's model object
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseNotaDebitoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'empresa_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'), 'add_empty' => false)),
      'proveedor_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Proveedor'), 'add_empty' => false)),
      'ncontrol'       => new sfWidgetFormInputText(),
      'moneda'         => new sfWidgetFormInputText(),
      'forma_pago_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('FormaPago'), 'add_empty' => true)),
      'num_recibo'     => new sfWidgetFormInputText(),
      'fecha'          => new sfWidgetFormDate(),
      'monto'          => new sfWidgetFormInputText(),
      'monto_faltante' => new sfWidgetFormInputText(),
      'quien_paga'     => new sfWidgetFormInputText(),
      'url_imagen'     => new sfWidgetFormInputText(),
      'tasa_cambio'    => new sfWidgetFormInputText(),
      'descripcion'    => new sfWidgetFormTextarea(),
      'estatus'        => new sfWidgetFormInputText(),
      'libro_compras'  => new sfWidgetFormInputText(),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
      'created_by'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'add_empty' => true)),
      'updated_by'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Updator'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'empresa_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'))),
      'proveedor_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Proveedor'))),
      'ncontrol'       => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'moneda'         => new sfValidatorPass(),
      'forma_pago_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('FormaPago'), 'required' => false)),
      'num_recibo'     => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'fecha'          => new sfValidatorDate(),
      'monto'          => new sfValidatorString(array('max_length' => 20)),
      'monto_faltante' => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'quien_paga'     => new sfValidatorString(array('max_length' => 200)),
      'url_imagen'     => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'tasa_cambio'    => new sfValidatorString(array('max_length' => 20)),
      'descripcion'    => new sfValidatorString(array('required' => false)),
      'estatus'        => new sfValidatorInteger(array('required' => false)),
      'libro_compras'  => new sfValidatorInteger(array('required' => false)),
      'created_at'     => new sfValidatorDateTime(),
      'updated_at'     => new sfValidatorDateTime(),
      'created_by'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'required' => false)),
      'updated_by'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Updator'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('nota_debito[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'NotaDebito';
  }

}
