<?php

/**
 * InvEntradaDet form base class.
 *
 * @method InvEntradaDet getObject() Returns the current form's model object
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseInvEntradaDetForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'inv_entrada_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('InvEntrada'), 'add_empty' => false)),
      'qty'            => new sfWidgetFormInputText(),
      'price_unit'     => new sfWidgetFormInputText(),
      'price_tot'      => new sfWidgetFormInputText(),
      'inventario_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Inventario'), 'add_empty' => false)),
      'fecha_venc'     => new sfWidgetFormDate(),
      'lote'           => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'inv_entrada_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('InvEntrada'))),
      'qty'            => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'price_unit'     => new sfValidatorString(array('max_length' => 20)),
      'price_tot'      => new sfValidatorString(array('max_length' => 20)),
      'inventario_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Inventario'))),
      'fecha_venc'     => new sfValidatorDate(),
      'lote'           => new sfValidatorString(array('max_length' => 200)),
    ));

    $this->widgetSchema->setNameFormat('inv_entrada_det[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'InvEntradaDet';
  }

}
