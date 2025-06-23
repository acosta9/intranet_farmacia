<?php

/**
 * OrdenCompra form base class.
 *
 * @method OrdenCompra getObject() Returns the current form's model object
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseOrdenCompraForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                      => new sfWidgetFormInputHidden(),
      'ncontrol'                => new sfWidgetFormInputText(),
      'tasa_cambio'             => new sfWidgetFormInputText(),
      'empresa_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'), 'add_empty' => false)),
      'deposito_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('InvDeposito'), 'add_empty' => false)),
      'cliente_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Cliente'), 'add_empty' => false)),
      'orden_compra_estatus_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('OrdenCompraEstatus'), 'add_empty' => true)),
      'titulo'                  => new sfWidgetFormInputText(),
      'total'                   => new sfWidgetFormInputText(),
      'created_at'              => new sfWidgetFormDateTime(),
      'updated_at'              => new sfWidgetFormDateTime(),
      'created_by'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'add_empty' => true)),
      'updated_by'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Updator'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'ncontrol'                => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'tasa_cambio'             => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'empresa_id'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'))),
      'deposito_id'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('InvDeposito'))),
      'cliente_id'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Cliente'))),
      'orden_compra_estatus_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('OrdenCompraEstatus'), 'required' => false)),
      'titulo'                  => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'total'                   => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'created_at'              => new sfValidatorDateTime(),
      'updated_at'              => new sfValidatorDateTime(),
      'created_by'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'required' => false)),
      'updated_by'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Updator'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('orden_compra[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'OrdenCompra';
  }

}
