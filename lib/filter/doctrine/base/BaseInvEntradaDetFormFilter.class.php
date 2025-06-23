<?php

/**
 * InvEntradaDet filter form base class.
 *
 * @package    ired.localhost
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseInvEntradaDetFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'inv_entrada_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('InvEntrada'), 'add_empty' => true)),
      'qty'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'price_unit'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'price_tot'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'inventario_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Inventario'), 'add_empty' => true)),
      'fecha_venc'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'lote'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'inv_entrada_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('InvEntrada'), 'column' => 'id')),
      'qty'            => new sfValidatorPass(array('required' => false)),
      'price_unit'     => new sfValidatorPass(array('required' => false)),
      'price_tot'      => new sfValidatorPass(array('required' => false)),
      'inventario_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Inventario'), 'column' => 'id')),
      'fecha_venc'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'lote'           => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('inv_entrada_det_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'InvEntradaDet';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'inv_entrada_id' => 'ForeignKey',
      'qty'            => 'Text',
      'price_unit'     => 'Text',
      'price_tot'      => 'Text',
      'inventario_id'  => 'ForeignKey',
      'fecha_venc'     => 'Date',
      'lote'           => 'Text',
    );
  }
}
