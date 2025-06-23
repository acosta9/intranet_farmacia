<?php

/**
 * TrasladoDet form base class.
 *
 * @method TrasladoDet getObject() Returns the current form's model object
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseTrasladoDetForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'traslado_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Traslado'), 'add_empty' => false)),
      'producto_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Producto'), 'add_empty' => true)),
      'prod_destino_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Producto2'), 'add_empty' => true)),
      'inventario_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Inventario'), 'add_empty' => true)),
      'qty'               => new sfWidgetFormInputText(),
      'inv_destino_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Inventario2'), 'add_empty' => true)),
      'qty_dest'          => new sfWidgetFormInputText(),
      'price_unit'        => new sfWidgetFormInputText(),
      'price_tot'         => new sfWidgetFormInputText(),
      'descripcion'       => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'traslado_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Traslado'))),
      'producto_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Producto'), 'required' => false)),
      'prod_destino_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Producto2'), 'required' => false)),
      'inventario_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Inventario'), 'required' => false)),
      'qty'               => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'inv_destino_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Inventario2'), 'required' => false)),
      'qty_dest'          => new sfValidatorInteger(array('required' => false)),
      'price_unit'        => new sfValidatorString(array('max_length' => 20)),
      'price_tot'         => new sfValidatorString(array('max_length' => 20)),
      'descripcion'       => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('traslado_det[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TrasladoDet';
  }

}
