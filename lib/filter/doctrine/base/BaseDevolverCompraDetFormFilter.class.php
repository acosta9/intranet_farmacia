<?php

/**
 * DevolverCompraDet filter form base class.
 *
 * @package    ired.localhost
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseDevolverCompraDetFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'devolver_compra_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DevolverCompra'), 'add_empty' => true)),
      'qty'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'price_unit'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'price_tot'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'inventario_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Inventario'), 'add_empty' => true)),
      'exento'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'devolver_compra_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('DevolverCompra'), 'column' => 'id')),
      'qty'                => new sfValidatorPass(array('required' => false)),
      'price_unit'         => new sfValidatorPass(array('required' => false)),
      'price_tot'          => new sfValidatorPass(array('required' => false)),
      'inventario_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Inventario'), 'column' => 'id')),
      'exento'             => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('devolver_compra_det_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'DevolverCompraDet';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'devolver_compra_id' => 'ForeignKey',
      'qty'                => 'Text',
      'price_unit'         => 'Text',
      'price_tot'          => 'Text',
      'inventario_id'      => 'ForeignKey',
      'exento'             => 'Text',
    );
  }
}
