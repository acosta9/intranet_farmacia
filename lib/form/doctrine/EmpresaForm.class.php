<?php

/**
 * Empresa form.
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class EmpresaForm extends BaseEmpresaForm
{
  public function configure()
  {
    unset(
      $this['created_at'],
      $this['updated_at'],
      $this['created_by'],
      $this['updated_by'],
      $this['user_list']
    );


    $this->setWidget('venc_registro_comercio', new sfWidgetFormInputText());
    $this->setWidget('venc_rif', new sfWidgetFormInputText());
    $this->setWidget('venc_bomberos', new sfWidgetFormInputText());
    $this->setWidget('venc_lic_funcionamiento', new sfWidgetFormInputText());
    $this->setWidget('venc_uso_conforme', new sfWidgetFormInputText());
    $this->setWidget('venc_permiso_sanitario', new sfWidgetFormInputText());
    $this->setWidget('venc_permiso_instalacion', new sfWidgetFormInputText());
    $this->setWidget('venc_destinado_afines', new sfWidgetFormInputText());
    $this->setWidget('venc_destinado_abastos', new sfWidgetFormInputText());

    $this->widgetSchema['venc_registro_comercio']->setAttributes(array('class' => 'form-control dateonly', 'readonly' => 'readonly', 'required' => 'required'));
    $this->widgetSchema['venc_rif']->setAttributes(array('class' => 'form-control dateonly', 'readonly' => 'readonly', 'required' => 'required'));
    $this->widgetSchema['venc_bomberos']->setAttributes(array('class' => 'form-control dateonly', 'readonly' => 'readonly', 'required' => 'required'));
    $this->widgetSchema['venc_uso_conforme']->setAttributes(array('class' => 'form-control dateonly', 'readonly' => 'readonly', 'required' => 'required'));
    $this->widgetSchema['venc_lic_funcionamiento']->setAttributes(array('class' => 'form-control dateonly', 'readonly' => 'readonly', 'required' => 'required'));
    $this->widgetSchema['venc_permiso_sanitario']->setAttributes(array('class' => 'form-control dateonly', 'readonly' => 'readonly', 'required' => 'required'));
    $this->widgetSchema['venc_permiso_instalacion']->setAttributes(array('class' => 'form-control dateonly', 'readonly' => 'readonly', 'required' => 'required'));
    $this->widgetSchema['venc_destinado_afines']->setAttributes(array('class' => 'form-control dateonly', 'readonly' => 'readonly', 'required' => 'required'));
    $this->widgetSchema['venc_destinado_abastos']->setAttributes(array('class' => 'form-control dateonly', 'readonly' => 'readonly', 'required' => 'required'));

    $this->setWidget('tipo', new sfWidgetFormChoice(array('choices' => array('1' => 'CASA MATRIZ', '2' => 'DROGUERIA', '3' => 'FARMACIA', '4' => 'ALIMENTOS'))));
    $this->setWidget('tasa', new sfWidgetFormChoice(array('choices' => array('T01' => 'TASA MEDICAMENTOS', 'T02' => 'TASA MISCELANEOS', '00' => 'AMBAS TASAS'))));
    $this->setWidget('direccion', new sfWidgetFormTextarea());
    $this->widgetSchema['nombre']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['iva']->setAttributes(array('class' => 'form-control iva'));
    $this->widgetSchema['rif']->setAttributes(array('class' => 'form-control rifcompany'));
    $this->widgetSchema['telefono']->setAttributes(array('class' => 'form-control celphone'));
    $this->widgetSchema['tipo']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['tasa']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['direccion']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['descripcion']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['ncontrol']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['nfactura']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['ndespacho']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['nentrega']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['ncredito']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['ntraslado']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['npago']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['ncompra']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['factcompra']->setAttributes(array('class' => 'form-control integer_nomask'));
    $this->widgetSchema['factgasto']->setAttributes(array('class' => 'form-control integer_nomask'));
    $this->widgetSchema['ordencompra']->setAttributes(array('class' => 'form-control integer_nomask'));
    $this->widgetSchema['coticompra']->setAttributes(array('class' => 'form-control integer_nomask'));
    $this->widgetSchema['acronimo']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['cod_coorpotulipa']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['email']->setAttributes(array('class' => 'form-control', 'type' => 'email'));

    $this->setValidators(array(
       'id' => new sfValidatorInteger(array('required' => true)),
       'nombre'   => new sfValidatorString(array('max_length' => 400, 'min_length' => 1, 'required'=> true), array(
         'required'   => 'Requerido',
          'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
          'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
          'invalid'=> 'Campo invalido.'
       )),
       'iva' => new sfValidatorInteger(array('required' => true, 'min' => '0')),
       'rif'   => new sfValidatorString(array('max_length' => 20, 'min_length' => 1, 'required'=> true), array(
         'required'   => 'Requerido',
          'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
          'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
          'invalid'=> 'Campo invalido.'
       )),
       'telefono'   => new sfValidatorString(array('max_length' => 20, 'min_length' => 1, 'required'=> true), array(
         'required'   => 'Requerido',
          'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
          'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
          'invalid'=> 'Campo invalido.'
       )),
       'tipo'   => new sfValidatorPass(),
       'tasa'   => new sfValidatorPass(),
       'direccion'   => new sfValidatorString(array('max_length' => 600, 'min_length' => 2, 'required'=> false), array(
           'required'   => 'Requerido',
           'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
           'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
           'invalid'=> 'Campo invalido.'
        )),
        'acronimo'   => new sfValidatorString(array('max_length' => 6, 'min_length' => 2, 'required'=> true), array(
          'required'   => 'Requerido',
          'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
          'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
          'invalid'=> 'Campo invalido.'
       )),
        'ncontrol'   => new sfValidatorString(array('max_length' => 20, 'min_length' => 2, 'required'=> true), array(
            'required'   => 'Requerido',
            'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
            'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
            'invalid'=> 'Campo invalido.'
         )),
         'nfactura'   => new sfValidatorString(array('max_length' => 20, 'min_length' => 2, 'required'=> true), array(
             'required'   => 'Requerido',
             'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
             'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
             'invalid'=> 'Campo invalido.'
          )),
          'ndespacho'   => new sfValidatorString(array('max_length' => 20, 'min_length' => 2, 'required'=> true), array(
              'required'   => 'Requerido',
              'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
              'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
              'invalid'=> 'Campo invalido.'
           )),
           'nentrega'   => new sfValidatorString(array('max_length' => 20, 'min_length' => 2, 'required'=> true), array(
               'required'   => 'Requerido',
               'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
               'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
               'invalid'=> 'Campo invalido.'
            )),
          'npago'   => new sfValidatorString(array('max_length' => 20, 'min_length' => 2, 'required'=> true), array(
              'required'   => 'Requerido',
              'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
              'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
              'invalid'=> 'Campo invalido.'
           )),
         'ncredito'   => new sfValidatorString(array('max_length' => 20, 'min_length' => 2, 'required'=> true), array(
             'required'   => 'Requerido',
             'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
             'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
             'invalid'=> 'Campo invalido.'
          )),
          'ntraslado'   => new sfValidatorString(array('max_length' => 20, 'min_length' => 2, 'required'=> true), array(
              'required'   => 'Requerido',
              'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
              'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
              'invalid'=> 'Campo invalido.'
           )),
           'ncompra'   => new sfValidatorString(array('max_length' => 20, 'min_length' => 2, 'required'=> true), array(
            'required'   => 'Requerido',
            'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
            'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
            'invalid'=> 'Campo invalido.'
         )),
         'factcompra'   => new sfValidatorString(array('max_length' => 20, 'min_length' => 2, 'required'=> true), array(
          'required'   => 'Requerido',
          'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
          'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
          'invalid'=> 'Campo invalido.'
       )),
         'factgasto'   => new sfValidatorString(array('max_length' => 20, 'min_length' => 2, 'required'=> true), array(
          'required'   => 'Requerido',
          'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
          'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
          'invalid'=> 'Campo invalido.'
       )),         
       'ordencompra'   => new sfValidatorString(array('max_length' => 20, 'min_length' => 2, 'required'=> true), array(
        'required'   => 'Requerido',
        'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
        'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
        'invalid'=> 'Campo invalido.'
     )),
         'coticompra'   => new sfValidatorString(array('max_length' => 20, 'min_length' => 2, 'required'=> true), array(
          'required'   => 'Requerido',
          'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
          'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
          'invalid'=> 'Campo invalido.'
       )),
          'cod_coorpotulipa'   => new sfValidatorString(array('max_length' => 20, 'min_length' => 2, 'required'=> false), array(
              'required'   => 'Requerido',
              'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
              'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
              'invalid'=> 'Campo invalido.'
           )),
          'email'   => new sfValidatorString(array('max_length' => 200, 'min_length' => 2, 'required'=> false), array(
              'required'   => 'Requerido',
              'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
              'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
              'invalid'=> 'Campo invalido.'
           )),
        'descripcion'   => new sfValidatorString(array('max_length' => 2000, 'min_length' => 2, 'required'=> false), array(
            'required'   => 'Requerido',
            'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
            'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
            'invalid'=> 'Campo invalido.'
         )),
         'venc_registro_comercio'   => new sfValidatorDate(array('required' => true)),
         'venc_rif'                 => new sfValidatorDate(array('required' => true)),
         'venc_bomberos'            => new sfValidatorDate(array('required' => true)),
         'venc_lic_funcionamiento'  => new sfValidatorDate(array('required' => true)),
         'venc_uso_conforme'        => new sfValidatorDate(array('required' => true)),
         'venc_permiso_sanitario'   => new sfValidatorDate(array('required' => true)),
         'venc_permiso_instalacion' => new sfValidatorDate(array('required' => true)),
         'venc_destinado_afines' => new sfValidatorDate(array('required' => true)),
         'venc_destinado_abastos' => new sfValidatorDate(array('required' => true)),
      ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorDoctrineUnique(array('model' => 'Empresa', 'column' => array('rif')), array(
          'invalid'=> 'Rif ya existente')),
        new sfValidatorDoctrineUnique(array('model' => 'Empresa', 'column' => array('id')), array(
          'invalid'=> 'Codigo ya existente')),
        new sfValidatorCallback(array('callback' => array($this, 'validaciones')))
      ))
    );
  }
  public function validaciones($validator, $values) {
    if(!empty($values['rif'])) {
      $values['rif'] = trim(strtoupper($values['rif']));
    }
    if(!empty($values['nombre'])) {
      $values['nombre'] = trim(strtoupper($values['nombre']));
    }
    if(!empty($values['acronimo'])) {
      $values['acronimo'] = trim(strtoupper($values['acronimo']));
    }
    if(!empty($values['direccion'])) {
      $values['direccion'] = trim(strtoupper($values['direccion']));
    }
    if(!empty($values['descripcion'])) {
      $values['descripcion'] = trim(strtoupper($values['descripcion']));
    }
    if(!empty($values['cod_coorpotulipa'])) {
      $values['cod_coorpotulipa'] = trim(strtoupper($values['cod_coorpotulipa']));
    }
    if(!empty($values['iva'])) {
      $money=str_replace(".","",$values['iva']);
      $money=str_replace(",",".",$money);
      $values['iva'] = floatval($money);
    }
    return $values;
  }
}
