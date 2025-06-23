<?php

/**
 * InventarioDet form base class.
 *
 * @method InventarioDet getObject() Returns the current form's model object
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseInventarioDetForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'inventario_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Inventario'), 'add_empty' => false)),
      'fecha_venc'    => new sfWidgetFormDate(),
      'lote'          => new sfWidgetFormInputText(),
      'cantidad'      => new sfWidgetFormInputText(),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'inventario_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Inventario'))),
      'fecha_venc'    => new sfValidatorDate(),
      'lote'          => new sfValidatorString(array('max_length' => 200)),
      'cantidad'      => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'created_at'    => new sfValidatorDateTime(),
      'updated_at'    => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('inventario_det[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'InventarioDet';
  }

}
