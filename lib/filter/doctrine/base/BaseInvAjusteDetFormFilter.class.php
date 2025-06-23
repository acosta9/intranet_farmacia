<?php

/**
 * InvAjusteDet filter form base class.
 *
 * @package    ired.localhost
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseInvAjusteDetFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'inv_ajuste_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('InvAjuste'), 'add_empty' => true)),
      'qty'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'price_unit'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'price_tot'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'inventario_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Inventario'), 'add_empty' => true)),
      'inventario_det_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('InventarioDet'), 'add_empty' => true)),
      'tipo'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'fecha_venc'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'lote'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'devolucion'        => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'inv_ajuste_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('InvAjuste'), 'column' => 'id')),
      'qty'               => new sfValidatorPass(array('required' => false)),
      'price_unit'        => new sfValidatorPass(array('required' => false)),
      'price_tot'         => new sfValidatorPass(array('required' => false)),
      'inventario_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Inventario'), 'column' => 'id')),
      'inventario_det_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('InventarioDet'), 'column' => 'id')),
      'tipo'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'fecha_venc'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'lote'              => new sfValidatorPass(array('required' => false)),
      'devolucion'        => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('inv_ajuste_det_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'InvAjusteDet';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'inv_ajuste_id'     => 'ForeignKey',
      'qty'               => 'Text',
      'price_unit'        => 'Text',
      'price_tot'         => 'Text',
      'inventario_id'     => 'ForeignKey',
      'inventario_det_id' => 'ForeignKey',
      'tipo'              => 'Number',
      'fecha_venc'        => 'Date',
      'lote'              => 'Text',
      'devolucion'        => 'Text',
    );
  }
}
