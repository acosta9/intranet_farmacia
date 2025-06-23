<?php

/**
 * AlmacenTransito filter form base class.
 *
 * @package    ired.localhost
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseAlmacenTransitoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'empresa_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'), 'add_empty' => true)),
      'deposito_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('InvDeposito'), 'add_empty' => true)),
      'cliente_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Cliente'), 'add_empty' => true)),
      'factura_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Factura'), 'add_empty' => true)),
      'nota_entrega_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('NotaEntrega'), 'add_empty' => true)),
      'traslado_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Traslado'), 'add_empty' => true)),
      'estatus'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'fecha_embalaje'  => new sfWidgetFormFilterInput(),
      'fecha_despacho'  => new sfWidgetFormFilterInput(),
      'tipo'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'boxes'           => new sfWidgetFormFilterInput(),
      'precinto'        => new sfWidgetFormFilterInput(),
      'descripcion'     => new sfWidgetFormFilterInput(),
      'created_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'empresa_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Empresa'), 'column' => 'id')),
      'deposito_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('InvDeposito'), 'column' => 'id')),
      'cliente_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Cliente'), 'column' => 'id')),
      'factura_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Factura'), 'column' => 'id')),
      'nota_entrega_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('NotaEntrega'), 'column' => 'id')),
      'traslado_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Traslado'), 'column' => 'id')),
      'estatus'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'fecha_embalaje'  => new sfValidatorPass(array('required' => false)),
      'fecha_despacho'  => new sfValidatorPass(array('required' => false)),
      'tipo'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'boxes'           => new sfValidatorPass(array('required' => false)),
      'precinto'        => new sfValidatorPass(array('required' => false)),
      'descripcion'     => new sfValidatorPass(array('required' => false)),
      'created_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('almacen_transito_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AlmacenTransito';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'empresa_id'      => 'ForeignKey',
      'deposito_id'     => 'ForeignKey',
      'cliente_id'      => 'ForeignKey',
      'factura_id'      => 'ForeignKey',
      'nota_entrega_id' => 'ForeignKey',
      'traslado_id'     => 'ForeignKey',
      'estatus'         => 'Number',
      'fecha_embalaje'  => 'Text',
      'fecha_despacho'  => 'Text',
      'tipo'            => 'Number',
      'boxes'           => 'Text',
      'precinto'        => 'Text',
      'descripcion'     => 'Text',
      'created_at'      => 'Date',
      'updated_at'      => 'Date',
    );
  }
}
