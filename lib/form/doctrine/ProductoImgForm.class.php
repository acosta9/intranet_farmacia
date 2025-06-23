<?php

/**
 * ProductoImg form.
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ProductoImgForm extends BaseProductoImgForm
{
  public function configure()
  {
    unset(
      $this['producto_id']
    );

    $this->setWidget('url_imagen', new sfWidgetFormInputFileEditable(array(
      'file_src'    => '/uploads/producto_img/'.$this->getObject()->getUrlImagen(),
      'edit_mode'   => !$this->isNew(),
      'is_image'    => true,
      'with_delete' => false,
    )));

    $this->setWidget('descripcion', new sfWidgetFormInputText());
    $this->widgetSchema['descripcion']->setAttributes(array('class' => 'form-control'));

    $this->widgetSchema->setLabels(array(
      'url_imagen' => 'Imagen',
      'descripcion' => 'Descripcion',
    ));

    $this->setValidators(array(
      'id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'descripcion'       => new sfValidatorString(array('max_length' => 2000, 'min_length' => 2, 'required'=> true), array(
        'required'   => 'Requerido',
        'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
        'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
        'invalid'=> 'Campo invalido.'
      )),
      'url_imagen' => new sfValidatorFile(array(
        'mime_types' => 'web_images',
        'path' => sfConfig::get('sf_upload_dir').'/producto_img',
        'required' => false,
      ), array(
          'required'   => 'Campo requerido',
          'invalid'=> 'Campo invalido',
      ))
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorCallback(array('callback' => array($this, 'validaciones')))
    );
  }
  public function validaciones($validator, $values) {
    if(!empty($values['descripcion'])) {
      $values['descripcion'] = trim(strtoupper($values['descripcion']));
    }
    return $values;
  }
}
