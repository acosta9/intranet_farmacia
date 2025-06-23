<?php

/**
 * NotaEntregaDet filter form base class.
 *
 * @package    ired.localhost
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseNotaEntregaDetFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'nota_entrega_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('NotaEntrega'), 'add_empty' => true)),
      'qty'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'price_unit'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'price_tot'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'inventario_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Inventario'), 'add_empty' => true)),
      'oferta_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Oferta'), 'add_empty' => true)),
      'descripcion'     => new sfWidgetFormFilterInput(),
      'exento'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'tasa_cambio'     => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'nota_entrega_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('NotaEntrega'), 'column' => 'id')),
      'qty'             => new sfValidatorPass(array('required' => false)),
      'price_unit'      => new sfValidatorPass(array('required' => false)),
      'price_tot'       => new sfValidatorPass(array('required' => false)),
      'inventario_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Inventario'), 'column' => 'id')),
      'oferta_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Oferta'), 'column' => 'id')),
      'descripcion'     => new sfValidatorPass(array('required' => false)),
      'exento'          => new sfValidatorPass(array('required' => false)),
      'tasa_cambio'     => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('nota_entrega_det_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'NotaEntregaDet';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'nota_entrega_id' => 'ForeignKey',
      'qty'             => 'Text',
      'price_unit'      => 'Text',
      'price_tot'       => 'Text',
      'inventario_id'   => 'ForeignKey',
      'oferta_id'       => 'ForeignKey',
      'descripcion'     => 'Text',
      'exento'          => 'Text',
      'tasa_cambio'     => 'Text',
    );
  }
}
