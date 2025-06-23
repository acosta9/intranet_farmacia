<?php

/**
 * AlmacenTransito form base class.
 *
 * @method AlmacenTransito getObject() Returns the current form's model object
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseAlmacenTransitoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'empresa_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'), 'add_empty' => false)),
      'deposito_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('InvDeposito'), 'add_empty' => false)),
      'cliente_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Cliente'), 'add_empty' => false)),
      'factura_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Factura'), 'add_empty' => true)),
      'nota_entrega_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('NotaEntrega'), 'add_empty' => true)),
      'traslado_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Traslado'), 'add_empty' => true)),
      'estatus'         => new sfWidgetFormInputText(),
      'fecha_embalaje'  => new sfWidgetFormInputText(),
      'fecha_despacho'  => new sfWidgetFormInputText(),
      'tipo'            => new sfWidgetFormInputText(),
      'boxes'           => new sfWidgetFormTextarea(),
      'precinto'        => new sfWidgetFormTextarea(),
      'descripcion'     => new sfWidgetFormTextarea(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'empresa_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'))),
      'deposito_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('InvDeposito'))),
      'cliente_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Cliente'))),
      'factura_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Factura'), 'required' => false)),
      'nota_entrega_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('NotaEntrega'), 'required' => false)),
      'traslado_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Traslado'), 'required' => false)),
      'estatus'         => new sfValidatorInteger(array('required' => false)),
      'fecha_embalaje'  => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'fecha_despacho'  => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'tipo'            => new sfValidatorInteger(array('required' => false)),
      'boxes'           => new sfValidatorString(array('required' => false)),
      'precinto'        => new sfValidatorString(array('required' => false)),
      'descripcion'     => new sfValidatorString(array('required' => false)),
      'created_at'      => new sfValidatorDateTime(),
      'updated_at'      => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('almacen_transito[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AlmacenTransito';
  }

}
