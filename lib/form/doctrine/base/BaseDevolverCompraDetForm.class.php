<?php

/**
 * DevolverCompraDet form base class.
 *
 * @method DevolverCompraDet getObject() Returns the current form's model object
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseDevolverCompraDetForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'devolver_compra_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DevolverCompra'), 'add_empty' => false)),
      'qty'                => new sfWidgetFormInputText(),
      'price_unit'         => new sfWidgetFormInputText(),
      'price_tot'          => new sfWidgetFormInputText(),
      'inventario_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Inventario'), 'add_empty' => true)),
      'exento'             => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'devolver_compra_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DevolverCompra'))),
      'qty'                => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'price_unit'         => new sfValidatorString(array('max_length' => 20)),
      'price_tot'          => new sfValidatorString(array('max_length' => 20)),
      'inventario_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Inventario'), 'required' => false)),
      'exento'             => new sfValidatorString(array('max_length' => 20)),
    ));

    $this->widgetSchema->setNameFormat('devolver_compra_det[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'DevolverCompraDet';
  }

}
