<?php

/**
 * Banners form.
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BannersForm extends BaseBannersForm
{
  public function configure()
  {
    unset(
			$this['created_at'],
			$this['updated_at'],
			$this['created_by'],
			$this['updated_by']
		);

		$this->widgetSchema['nombre']->setAttributes(array('class' => 'form-control', 'size' => 50));
		$this->widgetSchema['enlace']->setAttributes(array('class' => 'form-control', 'size' => 50));
		$this->widgetSchema['posicion']->setAttributes(array('class' => 'form-control', 'size' => 50));
		$this->widgetSchema['orden']->setAttributes(array('class' => 'form-control', 'size' => 50));
		
		$this->widgetSchema['descripcion']->setAttributes(array('class' => 'form-control', 'cols' => 45, 'rows' => 5));

		$this->setWidget('url_imagen', new sfWidgetFormInputFileEditable(array(
			'file_src'    => '/uploads/banners/'.$this->getObject()->getUrlImagen(),
			'edit_mode'   => !$this->isNew(),
			'is_image'    => true,
			'with_delete' => false,
		)));

		$this->setValidators(array(
			'id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
			'nombre'       => new sfValidatorString(array('max_length' => 200, 'min_length' => 2, 'required'=> true), array(
				'required'   => 'Requerido',
				'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
				'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
				'invalid'=> 'Campo invalido.'
			)),
			'posicion'       => new sfValidatorString(array('max_length' => 200, 'min_length' => 2, 'required'=> true), array(
				'required'   => 'Requerido',
				'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
				'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
				'invalid'=> 'Campo invalido.'
			)),
			'orden'       => new sfValidatorInteger(array('max' => 9999, 'min' => 1, 'required'=> true), array(
				'required'   => 'Requerido',
				'invalid'=> 'Campo invalido.'
			)),
			'enlace'       => new sfValidatorString(array('required'=> true), array(
				'required'   => 'Requerido',
				'invalid'=> 'Campo invalido, debe ser una url valida.'
			)),
			'descripcion'   => new sfValidatorString(array('max_length' => 4000, 'required'=> false), array(
				'required'   => 'Requerido',
				'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
				'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
				'invalid'=> 'Campo invalido.'
			)),
			'url_imagen' => new sfValidatorFile(array(
				'mime_types' => 'web_images',
				'path' => sfConfig::get('sf_upload_dir').'/banners',
				'required' => false,), array(
					'required'   => 'Campo requerido',
					'invalid'=> 'Campo invalido',
			)),
		));
	}
}
