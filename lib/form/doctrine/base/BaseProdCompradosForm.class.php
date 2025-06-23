<?php

/**
 * ProdComprados form base class.
 *
 * @method ProdComprados getObject() Returns the current form's model object
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseProdCompradosForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'empresa_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'), 'add_empty' => false)),
      'deposito_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('InvDeposito'), 'add_empty' => false)),
      'producto_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Producto'), 'add_empty' => false)),
      'cliente_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Cliente'), 'add_empty' => false)),
      'user_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => false)),
      'price_unit'  => new sfWidgetFormInputText(),
      'price_tot'   => new sfWidgetFormInputText(),
      'tabla'       => new sfWidgetFormInputText(),
      'tabla_id'    => new sfWidgetFormInputText(),
      'fecha'       => new sfWidgetFormDateTime(),
      'cantidad'    => new sfWidgetFormInputText(),
      'oferta'      => new sfWidgetFormInputCheckbox(),
      'anulado'     => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'empresa_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'))),
      'deposito_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('InvDeposito'))),
      'producto_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Producto'))),
      'cliente_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Cliente'))),
      'user_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'))),
      'price_unit'  => new sfValidatorString(array('max_length' => 20)),
      'price_tot'   => new sfValidatorString(array('max_length' => 20)),
      'tabla'       => new sfValidatorString(array('max_length' => 20)),
      'tabla_id'    => new sfValidatorInteger(),
      'fecha'       => new sfValidatorDateTime(),
      'cantidad'    => new sfValidatorInteger(),
      'oferta'      => new sfValidatorBoolean(),
      'anulado'     => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('prod_comprados[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProdComprados';
  }

}
