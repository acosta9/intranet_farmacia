<?php

/**
 * Producto form base class.
 *
 * @method Producto getObject() Returns the current form's model object
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseProductoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'nombre'          => new sfWidgetFormInputText(),
      'serial'          => new sfWidgetFormInputText(),
      'serial2'         => new sfWidgetFormInputText(),
      'serial3'         => new sfWidgetFormInputText(),
      'serial4'         => new sfWidgetFormInputText(),
      'tasa'            => new sfWidgetFormInputText(),
      'serial_bulto1'   => new sfWidgetFormInputText(),
      'cantidad_bulto1' => new sfWidgetFormInputText(),
      'serial_bulto2'   => new sfWidgetFormInputText(),
      'cantidad_bulto2' => new sfWidgetFormInputText(),
      'codigo'          => new sfWidgetFormInputText(),
      'laboratorio_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ProdLaboratorio'), 'add_empty' => true)),
      'categoria_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ProdCategoria'), 'add_empty' => false)),
      'unidad_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ProdUnidad'), 'add_empty' => false)),
      'subproducto_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Producto'), 'add_empty' => true)),
      'qty_desglozado'  => new sfWidgetFormInputText(),
      'tipo'            => new sfWidgetFormInputCheckbox(),
      'activo'          => new sfWidgetFormInputCheckbox(),
      'costo_usd_1'     => new sfWidgetFormInputText(),
      'util_usd_1'      => new sfWidgetFormInputText(),
      'util_usd_2'      => new sfWidgetFormInputText(),
      'util_usd_3'      => new sfWidgetFormInputText(),
      'util_usd_4'      => new sfWidgetFormInputText(),
      'util_usd_5'      => new sfWidgetFormInputText(),
      'util_usd_6'      => new sfWidgetFormInputText(),
      'util_usd_7'      => new sfWidgetFormInputText(),
      'util_usd_8'      => new sfWidgetFormInputText(),
      'precio_usd_1'    => new sfWidgetFormInputText(),
      'precio_usd_2'    => new sfWidgetFormInputText(),
      'precio_usd_3'    => new sfWidgetFormInputText(),
      'precio_usd_4'    => new sfWidgetFormInputText(),
      'precio_usd_5'    => new sfWidgetFormInputText(),
      'precio_usd_6'    => new sfWidgetFormInputText(),
      'precio_usd_7'    => new sfWidgetFormInputText(),
      'precio_usd_8'    => new sfWidgetFormInputText(),
      'exento'          => new sfWidgetFormInputCheckbox(),
      'destacado'       => new sfWidgetFormInputCheckbox(),
      'tags'            => new sfWidgetFormInputText(),
      'url_imagen'      => new sfWidgetFormInputText(),
      'url_imagen_desc' => new sfWidgetFormTextarea(),
      'descripcion'     => new sfWidgetFormTextarea(),
      'mas_detalles'    => new sfWidgetFormTextarea(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
      'created_by'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'add_empty' => true)),
      'updated_by'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Updator'), 'add_empty' => true)),
      'compuesto_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Compuesto')),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'nombre'          => new sfValidatorString(array('max_length' => 200)),
      'serial'          => new sfValidatorString(array('max_length' => 100)),
      'serial2'         => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'serial3'         => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'serial4'         => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'tasa'            => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'serial_bulto1'   => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'cantidad_bulto1' => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'serial_bulto2'   => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'cantidad_bulto2' => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'codigo'          => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'laboratorio_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ProdLaboratorio'), 'required' => false)),
      'categoria_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ProdCategoria'))),
      'unidad_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ProdUnidad'))),
      'subproducto_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Producto'), 'required' => false)),
      'qty_desglozado'  => new sfValidatorInteger(array('required' => false)),
      'tipo'            => new sfValidatorBoolean(array('required' => false)),
      'activo'          => new sfValidatorBoolean(array('required' => false)),
      'costo_usd_1'     => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'util_usd_1'      => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'util_usd_2'      => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'util_usd_3'      => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'util_usd_4'      => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'util_usd_5'      => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'util_usd_6'      => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'util_usd_7'      => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'util_usd_8'      => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'precio_usd_1'    => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'precio_usd_2'    => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'precio_usd_3'    => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'precio_usd_4'    => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'precio_usd_5'    => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'precio_usd_6'    => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'precio_usd_7'    => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'precio_usd_8'    => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'exento'          => new sfValidatorBoolean(array('required' => false)),
      'destacado'       => new sfValidatorBoolean(array('required' => false)),
      'tags'            => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'url_imagen'      => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'url_imagen_desc' => new sfValidatorString(array('required' => false)),
      'descripcion'     => new sfValidatorString(array('required' => false)),
      'mas_detalles'    => new sfValidatorString(array('required' => false)),
      'created_at'      => new sfValidatorDateTime(),
      'updated_at'      => new sfValidatorDateTime(),
      'created_by'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'required' => false)),
      'updated_by'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Updator'), 'required' => false)),
      'compuesto_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Compuesto', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorDoctrineUnique(array('model' => 'Producto', 'column' => array('serial'))),
        new sfValidatorDoctrineUnique(array('model' => 'Producto', 'column' => array('serial_bulto1'))),
        new sfValidatorDoctrineUnique(array('model' => 'Producto', 'column' => array('serial_bulto2'))),
      ))
    );

    $this->widgetSchema->setNameFormat('producto[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Producto';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['compuesto_list']))
    {
      $this->setDefault('compuesto_list', $this->object->Compuesto->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveCompuestoList($con);

    parent::doSave($con);
  }

  public function saveCompuestoList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['compuesto_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Compuesto->getPrimaryKeys();
    $values = $this->getValue('compuesto_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Compuesto', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Compuesto', array_values($link));
    }
  }

}
