<?php

/**
 * InvAjusteDet form base class.
 *
 * @method InvAjusteDet getObject() Returns the current form's model object
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseInvAjusteDetForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'inv_ajuste_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('InvAjuste'), 'add_empty' => false)),
      'qty'               => new sfWidgetFormInputText(),
      'price_unit'        => new sfWidgetFormInputText(),
      'price_tot'         => new sfWidgetFormInputText(),
      'inventario_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Inventario'), 'add_empty' => false)),
      'inventario_det_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('InventarioDet'), 'add_empty' => false)),
      'tipo'              => new sfWidgetFormInputText(),
      'fecha_venc'        => new sfWidgetFormDate(),
      'lote'              => new sfWidgetFormInputText(),
      'devolucion'        => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'inv_ajuste_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('InvAjuste'))),
      'qty'               => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'price_unit'        => new sfValidatorString(array('max_length' => 20)),
      'price_tot'         => new sfValidatorString(array('max_length' => 20)),
      'inventario_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Inventario'))),
      'inventario_det_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('InventarioDet'))),
      'tipo'              => new sfValidatorInteger(array('required' => false)),
      'fecha_venc'        => new sfValidatorDate(),
      'lote'              => new sfValidatorString(array('max_length' => 200)),
      'devolucion'        => new sfValidatorString(array('max_length' => 200, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('inv_ajuste_det[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'InvAjusteDet';
  }

}
