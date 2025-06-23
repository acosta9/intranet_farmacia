<?php

/**
 * TrasladoDet filter form base class.
 *
 * @package    ired.localhost
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseTrasladoDetFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'traslado_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Traslado'), 'add_empty' => true)),
      'producto_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Producto'), 'add_empty' => true)),
      'inventario_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Inventario'), 'add_empty' => true)),
      'qty'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'inv_destino_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Inventario2'), 'add_empty' => true)),
      'qty_dest'          => new sfWidgetFormFilterInput(),
      'inv_desglose_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Inventario3'), 'add_empty' => true)),
      'qty_dest_desglose' => new sfWidgetFormFilterInput(),
      'price_unit'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'price_tot'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'descripcion'       => new sfWidgetFormFilterInput(),
      'exento'            => new sfWidgetFormFilterInput(),
      'tasa_cambio'       => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'traslado_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Traslado'), 'column' => 'id')),
      'producto_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Producto'), 'column' => 'id')),
      'inventario_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Inventario'), 'column' => 'id')),
      'qty'               => new sfValidatorPass(array('required' => false)),
      'inv_destino_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Inventario2'), 'column' => 'id')),
      'qty_dest'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'inv_desglose_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Inventario3'), 'column' => 'id')),
      'qty_dest_desglose' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'price_unit'        => new sfValidatorPass(array('required' => false)),
      'price_tot'         => new sfValidatorPass(array('required' => false)),
      'descripcion'       => new sfValidatorPass(array('required' => false)),
      'exento'            => new sfValidatorPass(array('required' => false)),
      'tasa_cambio'       => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('traslado_det_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TrasladoDet';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'traslado_id'       => 'ForeignKey',
      'producto_id'       => 'ForeignKey',
      'inventario_id'     => 'ForeignKey',
      'qty'               => 'Text',
      'inv_destino_id'    => 'ForeignKey',
      'qty_dest'          => 'Number',
      'inv_desglose_id'   => 'ForeignKey',
      'qty_dest_desglose' => 'Number',
      'price_unit'        => 'Text',
      'price_tot'         => 'Text',
      'descripcion'       => 'Text',
      'exento'            => 'Text',
      'tasa_cambio'       => 'Text',
    );
  }
}
