<?php

/**
 * Galeria form.
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class GaleriaForm extends BaseGaleriaForm
{
  public function configure()
  {
    unset(
      $this['created_at'],
      $this['updated_at'],
      $this['created_by'],
      $this['updated_by']
    );

    $this->setWidget('url_imagen', new sfWidgetFormInputFileEditable(array(
      'file_src'    => '/uploads/galeria/'.$this->getObject()->getUrlImagen(),
      'edit_mode'   => !$this->isNew(),
      'is_image'    => true,
      'with_delete' => false,
    )));

    $this->widgetSchema['nombre']->setAttributes(array('size' => 45));
    $this->widgetSchema['orden']->setAttributes(array('size' => 45));
    $this->widgetSchema['enlace']->setAttributes(array('size' => 45));
    $this->widgetSchema['posicion']->setAttributes(array('size' => 45));

    $this->widgetSchema['nombre']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['texto']->setAttributes(array('class' => 'form-control', 'cols' => 45, 'rows' => 10));
    $this->widgetSchema['orden']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['enlace']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['posicion']->setAttributes(array('class' => 'form-control'));

    $this->setValidators(array(
         'id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
         'nombre'   => new sfValidatorString(array('max_length' => 200, 'min_length' => 2, 'required'=> true), array(
                    'required'   => 'Requerido',
                    'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
                    'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
                    'invalid'=> 'Campo invalido.'
          )),
          'posicion'   => new sfValidatorString(array('max_length' => 200, 'min_length' => 2, 'required'=> true), array(
                     'required'   => 'Requerido',
                     'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
                     'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
                     'invalid'=> 'Campo invalido.'
           )),
          'orden'       => new sfValidatorInteger(array('max' => 9999, 'min' => 1, 'required'=> true), array(
                          'required'   => 'Requerido',
                          'invalid'=> 'Campo invalido.'
                   )),
          'enlace'       => new sfValidatorUrl(array('required'=> true), array(
                          'required'   => 'Requerido',
                          'invalid'=> 'Campo invalido, debe ser una url valida.'
                   )),
          'texto'   => new sfValidatorString(array('max_length' => 5000, 'min_length' => 2, 'required'=> false), array(
                    'required'   => 'Requerido',
                    'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
                    'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
                    'invalid'=> 'Campo invalido.'
             )),
          'url_imagen' => new sfValidatorFile(array(
                 'mime_types' => 'web_images',
                 'path' => sfConfig::get('sf_upload_dir').'/galeria',
                 'required' => false,), array(
                     'required'   => 'Campo requerido',
                     'invalid'=> 'Campo invalido',
                 )),
          ));
  }
}

