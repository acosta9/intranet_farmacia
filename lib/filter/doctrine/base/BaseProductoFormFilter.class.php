<?php

/**
 * Producto filter form base class.
 *
 * @package    ired.localhost
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseProductoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'nombre'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'serial'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'serial2'         => new sfWidgetFormFilterInput(),
      'serial3'         => new sfWidgetFormFilterInput(),
      'serial4'         => new sfWidgetFormFilterInput(),
      'tasa'            => new sfWidgetFormFilterInput(),
      'serial_bulto1'   => new sfWidgetFormFilterInput(),
      'cantidad_bulto1' => new sfWidgetFormFilterInput(),
      'serial_bulto2'   => new sfWidgetFormFilterInput(),
      'cantidad_bulto2' => new sfWidgetFormFilterInput(),
      'codigo'          => new sfWidgetFormFilterInput(),
      'laboratorio_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ProdLaboratorio'), 'add_empty' => true)),
      'categoria_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ProdCategoria'), 'add_empty' => true)),
      'unidad_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ProdUnidad'), 'add_empty' => true)),
      'subproducto_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Producto'), 'add_empty' => true)),
      'qty_desglozado'  => new sfWidgetFormFilterInput(),
      'tipo'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'activo'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'costo_usd_1'     => new sfWidgetFormFilterInput(),
      'util_usd_1'      => new sfWidgetFormFilterInput(),
      'util_usd_2'      => new sfWidgetFormFilterInput(),
      'util_usd_3'      => new sfWidgetFormFilterInput(),
      'util_usd_4'      => new sfWidgetFormFilterInput(),
      'util_usd_5'      => new sfWidgetFormFilterInput(),
      'util_usd_6'      => new sfWidgetFormFilterInput(),
      'util_usd_7'      => new sfWidgetFormFilterInput(),
      'util_usd_8'      => new sfWidgetFormFilterInput(),
      'precio_usd_1'    => new sfWidgetFormFilterInput(),
      'precio_usd_2'    => new sfWidgetFormFilterInput(),
      'precio_usd_3'    => new sfWidgetFormFilterInput(),
      'precio_usd_4'    => new sfWidgetFormFilterInput(),
      'precio_usd_5'    => new sfWidgetFormFilterInput(),
      'precio_usd_6'    => new sfWidgetFormFilterInput(),
      'precio_usd_7'    => new sfWidgetFormFilterInput(),
      'precio_usd_8'    => new sfWidgetFormFilterInput(),
      'exento'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'destacado'       => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'tags'            => new sfWidgetFormFilterInput(),
      'url_imagen'      => new sfWidgetFormFilterInput(),
      'url_imagen_desc' => new sfWidgetFormFilterInput(),
      'descripcion'     => new sfWidgetFormFilterInput(),
      'mas_detalles'    => new sfWidgetFormFilterInput(),
      'created_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_by'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'add_empty' => true)),
      'updated_by'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Updator'), 'add_empty' => true)),
      'compuesto_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Compuesto')),
    ));

    $this->setValidators(array(
      'nombre'          => new sfValidatorPass(array('required' => false)),
      'serial'          => new sfValidatorPass(array('required' => false)),
      'serial2'         => new sfValidatorPass(array('required' => false)),
      'serial3'         => new sfValidatorPass(array('required' => false)),
      'serial4'         => new sfValidatorPass(array('required' => false)),
      'tasa'            => new sfValidatorPass(array('required' => false)),
      'serial_bulto1'   => new sfValidatorPass(array('required' => false)),
      'cantidad_bulto1' => new sfValidatorPass(array('required' => false)),
      'serial_bulto2'   => new sfValidatorPass(array('required' => false)),
      'cantidad_bulto2' => new sfValidatorPass(array('required' => false)),
      'codigo'          => new sfValidatorPass(array('required' => false)),
      'laboratorio_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ProdLaboratorio'), 'column' => 'id')),
      'categoria_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ProdCategoria'), 'column' => 'id')),
      'unidad_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ProdUnidad'), 'column' => 'id')),
      'subproducto_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Producto'), 'column' => 'id')),
      'qty_desglozado'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'tipo'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'activo'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'costo_usd_1'     => new sfValidatorPass(array('required' => false)),
      'util_usd_1'      => new sfValidatorPass(array('required' => false)),
      'util_usd_2'      => new sfValidatorPass(array('required' => false)),
      'util_usd_3'      => new sfValidatorPass(array('required' => false)),
      'util_usd_4'      => new sfValidatorPass(array('required' => false)),
      'util_usd_5'      => new sfValidatorPass(array('required' => false)),
      'util_usd_6'      => new sfValidatorPass(array('required' => false)),
      'util_usd_7'      => new sfValidatorPass(array('required' => false)),
      'util_usd_8'      => new sfValidatorPass(array('required' => false)),
      'precio_usd_1'    => new sfValidatorPass(array('required' => false)),
      'precio_usd_2'    => new sfValidatorPass(array('required' => false)),
      'precio_usd_3'    => new sfValidatorPass(array('required' => false)),
      'precio_usd_4'    => new sfValidatorPass(array('required' => false)),
      'precio_usd_5'    => new sfValidatorPass(array('required' => false)),
      'precio_usd_6'    => new sfValidatorPass(array('required' => false)),
      'precio_usd_7'    => new sfValidatorPass(array('required' => false)),
      'precio_usd_8'    => new sfValidatorPass(array('required' => false)),
      'exento'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'destacado'       => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'tags'            => new sfValidatorPass(array('required' => false)),
      'url_imagen'      => new sfValidatorPass(array('required' => false)),
      'url_imagen_desc' => new sfValidatorPass(array('required' => false)),
      'descripcion'     => new sfValidatorPass(array('required' => false)),
      'mas_detalles'    => new sfValidatorPass(array('required' => false)),
      'created_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_by'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Creator'), 'column' => 'id')),
      'updated_by'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Updator'), 'column' => 'id')),
      'compuesto_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Compuesto', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('producto_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addCompuestoListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.ProdCompuesto ProdCompuesto')
      ->andWhereIn('ProdCompuesto.compuesto_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Producto';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'nombre'          => 'Text',
      'serial'          => 'Text',
      'serial2'         => 'Text',
      'serial3'         => 'Text',
      'serial4'         => 'Text',
      'tasa'            => 'Text',
      'serial_bulto1'   => 'Text',
      'cantidad_bulto1' => 'Text',
      'serial_bulto2'   => 'Text',
      'cantidad_bulto2' => 'Text',
      'codigo'          => 'Text',
      'laboratorio_id'  => 'ForeignKey',
      'categoria_id'    => 'ForeignKey',
      'unidad_id'       => 'ForeignKey',
      'subproducto_id'  => 'ForeignKey',
      'qty_desglozado'  => 'Number',
      'tipo'            => 'Boolean',
      'activo'          => 'Boolean',
      'costo_usd_1'     => 'Text',
      'util_usd_1'      => 'Text',
      'util_usd_2'      => 'Text',
      'util_usd_3'      => 'Text',
      'util_usd_4'      => 'Text',
      'util_usd_5'      => 'Text',
      'util_usd_6'      => 'Text',
      'util_usd_7'      => 'Text',
      'util_usd_8'      => 'Text',
      'precio_usd_1'    => 'Text',
      'precio_usd_2'    => 'Text',
      'precio_usd_3'    => 'Text',
      'precio_usd_4'    => 'Text',
      'precio_usd_5'    => 'Text',
      'precio_usd_6'    => 'Text',
      'precio_usd_7'    => 'Text',
      'precio_usd_8'    => 'Text',
      'exento'          => 'Boolean',
      'destacado'       => 'Boolean',
      'tags'            => 'Text',
      'url_imagen'      => 'Text',
      'url_imagen_desc' => 'Text',
      'descripcion'     => 'Text',
      'mas_detalles'    => 'Text',
      'created_at'      => 'Date',
      'updated_at'      => 'Date',
      'created_by'      => 'ForeignKey',
      'updated_by'      => 'ForeignKey',
      'compuesto_list'  => 'ManyKey',
    );
  }
}
