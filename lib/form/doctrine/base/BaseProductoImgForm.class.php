<?php

/**
 * ProductoImg form base class.
 *
 * @method ProductoImg getObject() Returns the current form's model object
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseProductoImgForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'producto_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Producto'), 'add_empty' => false)),
      'url_imagen'  => new sfWidgetFormInputText(),
      'descripcion' => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'producto_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Producto'))),
      'url_imagen'  => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'descripcion' => new sfValidatorString(),
    ));

    $this->widgetSchema->setNameFormat('producto_img[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProductoImg';
  }

}
