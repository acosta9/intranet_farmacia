<?php

/**
 * Empresa form base class.
 *
 * @method Empresa getObject() Returns the current form's model object
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseEmpresaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                       => new sfWidgetFormInputHidden(),
      'nombre'                   => new sfWidgetFormInputText(),
      'acronimo'                 => new sfWidgetFormInputText(),
      'ncontrol'                 => new sfWidgetFormInputText(),
      'nfactura'                 => new sfWidgetFormInputText(),
      'ndespacho'                => new sfWidgetFormInputText(),
      'nentrega'                 => new sfWidgetFormInputText(),
      'npago'                    => new sfWidgetFormInputText(),
      'ncredito'                 => new sfWidgetFormInputText(),
      'ntraslado'                => new sfWidgetFormInputText(),
      'ncompra'                  => new sfWidgetFormInputText(),
      'factcompra'               => new sfWidgetFormInputText(),
      'factgasto'                => new sfWidgetFormInputText(),
      'ordencompra'              => new sfWidgetFormInputText(),
      'coticompra'               => new sfWidgetFormInputText(),
      'rif'                      => new sfWidgetFormInputText(),
      'cod_coorpotulipa'         => new sfWidgetFormInputText(),
      'direccion'                => new sfWidgetFormInputText(),
      'telefono'                 => new sfWidgetFormInputText(),
      'email'                    => new sfWidgetFormInputText(),
      'tipo'                     => new sfWidgetFormInputText(),
      'iva'                      => new sfWidgetFormInputText(),
      'tasa'                     => new sfWidgetFormInputText(),
      'venc_registro_comercio'   => new sfWidgetFormDate(),
      'venc_rif'                 => new sfWidgetFormDate(),
      'venc_bomberos'            => new sfWidgetFormDate(),
      'venc_lic_funcionamiento'  => new sfWidgetFormDate(),
      'venc_uso_conforme'        => new sfWidgetFormDate(),
      'venc_permiso_sanitario'   => new sfWidgetFormDate(),
      'venc_permiso_instalacion' => new sfWidgetFormDate(),
      'venc_destinado_afines'    => new sfWidgetFormDate(),
      'venc_destinado_abastos'   => new sfWidgetFormDate(),
      'descripcion'              => new sfWidgetFormTextarea(),
      'created_at'               => new sfWidgetFormDateTime(),
      'updated_at'               => new sfWidgetFormDateTime(),
      'created_by'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'add_empty' => true)),
      'updated_by'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Updator'), 'add_empty' => true)),
      'user_list'                => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser')),
    ));

    $this->setValidators(array(
      'id'                       => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'nombre'                   => new sfValidatorString(array('max_length' => 200)),
      'acronimo'                 => new sfValidatorString(array('max_length' => 20)),
      'ncontrol'                 => new sfValidatorString(array('max_length' => 200)),
      'nfactura'                 => new sfValidatorString(array('max_length' => 200)),
      'ndespacho'                => new sfValidatorString(array('max_length' => 200)),
      'nentrega'                 => new sfValidatorString(array('max_length' => 200)),
      'npago'                    => new sfValidatorString(array('max_length' => 200)),
      'ncredito'                 => new sfValidatorString(array('max_length' => 200)),
      'ntraslado'                => new sfValidatorString(array('max_length' => 200)),
      'ncompra'                  => new sfValidatorString(array('max_length' => 200)),
      'factcompra'               => new sfValidatorString(array('max_length' => 200)),
      'factgasto'                => new sfValidatorString(array('max_length' => 200)),
      'ordencompra'              => new sfValidatorString(array('max_length' => 200)),
      'coticompra'               => new sfValidatorString(array('max_length' => 200)),
      'rif'                      => new sfValidatorString(array('max_length' => 20)),
      'cod_coorpotulipa'         => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'direccion'                => new sfValidatorString(array('max_length' => 200)),
      'telefono'                 => new sfValidatorString(array('max_length' => 200)),
      'email'                    => new sfValidatorString(array('max_length' => 200)),
      'tipo'                     => new sfValidatorPass(),
      'iva'                      => new sfValidatorInteger(array('required' => false)),
      'tasa'                     => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'venc_registro_comercio'   => new sfValidatorDate(array('required' => false)),
      'venc_rif'                 => new sfValidatorDate(array('required' => false)),
      'venc_bomberos'            => new sfValidatorDate(array('required' => false)),
      'venc_lic_funcionamiento'  => new sfValidatorDate(array('required' => false)),
      'venc_uso_conforme'        => new sfValidatorDate(array('required' => false)),
      'venc_permiso_sanitario'   => new sfValidatorDate(array('required' => false)),
      'venc_permiso_instalacion' => new sfValidatorDate(array('required' => false)),
      'venc_destinado_afines'    => new sfValidatorDate(array('required' => false)),
      'venc_destinado_abastos'   => new sfValidatorDate(array('required' => false)),
      'descripcion'              => new sfValidatorString(array('required' => false)),
      'created_at'               => new sfValidatorDateTime(),
      'updated_at'               => new sfValidatorDateTime(),
      'created_by'               => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'required' => false)),
      'updated_by'               => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Updator'), 'required' => false)),
      'user_list'                => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('empresa[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Empresa';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['user_list']))
    {
      $this->setDefault('user_list', $this->object->User->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveUserList($con);

    parent::doSave($con);
  }

  public function saveUserList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['user_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->User->getPrimaryKeys();
    $values = $this->getValue('user_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('User', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('User', array_values($link));
    }
  }

}
