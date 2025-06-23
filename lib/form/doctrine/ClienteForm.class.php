<?php

/**
 * Cliente form.
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ClienteForm extends BaseClienteForm
{
  public function configure() {
    unset(
      $this['created_at'],
      $this['updated_at'],
      $this['created_by'],
      $this['updated_by']
    );

    $this->setWidget('activo', new sfWidgetFormChoice(array('choices' => array(
      0 => 'DES-HABILITADO',
      1 => 'HABILITADO'
    ))));

    $this->setWidget('tipo_precio', new sfWidgetFormChoice(array('choices' => array(
      1 => 'PRECIO 01',
      2 => 'PRECIO 02',
      3 => 'PRECIO 03',
      4 => 'PRECIO 04',
      5 => 'PRECIO 05',
      6 => 'PRECIO 06',
      7 => 'PRECIO 07'
    ))));
    $this->setWidget('zona', new sfWidgetFormChoice(array('choices' => array(
      '' => '',
      'CENTRO' => 'CENTRO',
      'ORIENTE' => 'ORIENTE',
      'OCCIDENTE' => 'OCCIDENTE',
      'LOS_LLANOS' => 'LOS LLANOS'
    ))));

    $this->widgetSchema->setLabels(array(
      'activo' => 'Estatus',
      'full_name' => 'Nombre',
      'doc_id' => 'RIF ó CI',
      'sicm' => 'SICM',
      'telf' => 'Telefono (1)',
      'celular' => 'Telefono (2)',
      'email' => 'Correo Electronico',
      'dias_credito' => 'Dias de credito',
      'tipo_precio' => 'Tipo de Precio',
    ));

    $this->widgetSchema['full_name']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['doc_id']->setAttributes(array('class' => 'form-control', 'data-inputmask' => "'mask': 'A-99999999[-9]'", 'data-mask' => " "));
    $this->widgetSchema['email']->setAttributes(array('class' => 'form-control', 'type' => 'email'));
    $this->widgetSchema['telf']->setAttributes(array('class' => 'form-control', 'data-inputmask' => "'mask': '(9999) 999-9999'", 'data-mask' => " "));
    $this->widgetSchema['celular']->setAttributes(array('class' => 'form-control', 'data-inputmask' => "'mask': '(9999) 999-9999'", 'data-mask' => " "));
    $this->widgetSchema['tipo_precio']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['dias_credito']->setAttributes(array('class' => 'form-control number2'));
    $this->widgetSchema['direccion']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['descripcion']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['zona']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['sicm']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['activo']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['vendedor_01_profit']->setAttributes(array('class' => 'form-control number'));
    $this->widgetSchema['vendedor_02_profit']->setAttributes(array('class' => 'form-control number'));

    $this->setValidators(array(
      'id' => new sfValidatorInteger(array('required' => true)),
      'empresa_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'))),
      'full_name'       => new sfValidatorString(array('max_length' => 200, 'min_length' => 2, 'required'=> true), array(
        'required'   => 'Requerido',
        'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
        'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
        'invalid'=> 'Campo invalido.'
      )),
      'doc_id'          => new sfValidatorString(array('max_length' => 200, 'min_length' => 2, 'required'=> true), array(
        'required'   => 'Requerido',
        'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
        'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
        'invalid'=> 'Campo invalido.'
      )),
      'dias_credito'          => new sfValidatorString(array('max_length' => 3, 'min_length' => 1, 'required'=> false), array(
        'required'   => 'Requerido',
        'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
        'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
        'invalid'=> 'Campo invalido.'
      )),
      'sicm'          => new sfValidatorString(array('max_length' => 20, 'min_length' => 2, 'required'=> false), array(
        'required'   => 'Requerido',
        'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
        'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
        'invalid'=> 'Campo invalido.'
      )),
      'tipo_precio'   => new sfValidatorPass(),
      'zona'   => new sfValidatorPass(),
      'activo'   => new sfValidatorPass(),
      'telf'            => new sfValidatorString(array('max_length' => 20, 'min_length' => 2, 'required'=> true), array(
        'required'   => 'Requerido',
        'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
        'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
        'invalid'=> 'Campo invalido.'
      )),
      'celular'         => new sfValidatorString(array('max_length' => 20, 'min_length' => 2, 'required'=> false), array(
        'required'   => 'Requerido',
        'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
        'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
        'invalid'=> 'Campo invalido.'
      )),
      'email'           => new sfValidatorString(array('max_length' => 200, 'min_length' => 2, 'required'=> false), array(
        'required'   => 'Requerido',
        'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
        'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
        'invalid'=> 'Campo invalido.'
      )),
      'direccion'       => new sfValidatorString(array('max_length' => 200, 'min_length' => 2, 'required'=> true), array(
        'required'   => 'Requerido',
        'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
        'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
        'invalid'=> 'Campo invalido.'
      )),
      'descripcion'     => new sfValidatorString(array('max_length' => 2000, 'min_length' => 2, 'required'=> false), array(
        'required'   => 'Requerido',
        'min_length' => 'Campo invalido, "%value%" es muyfalse corto debe ser de %min_length% caracteres minimo',
        'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
        'invalid'=> 'Campo invalido.'
      )),
      'vendedor_01' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'required' => false)),
      'vendedor_01_profit'       => new sfValidatorString(array('max_length' => 20, 'min_length' => 1, 'required'=> false), array(
        'required'   => 'Requerido',
        'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
        'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
        'invalid'=> 'Campo invalido.'
      )),
      'vendedor_02' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User2'), 'required' => false)),
      'vendedor_02_profit'       => new sfValidatorString(array('max_length' => 20, 'min_length' => 1, 'required'=> false), array(
        'required'   => 'Requerido',
        'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
        'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
        'invalid'=> 'Campo invalido.'
      )),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorCallback(array('callback' => array($this, 'validaciones')))
    );
  }
  public function validaciones($validator, $values) {
    if(!empty($values['doc_id']) && $this->isNew()) {
      $results = Doctrine_Core::getTable('Cliente')
        ->createQuery('a')
        ->select('COUNT(id) as contador')
        ->Where("empresa_id =?", $values['empresa_id'])
        ->AndWhere("doc_id =?", $values['doc_id'])
        ->limit(1)
        ->execute();
      $count = 0;
      foreach ($results as $result) {
        $count=$result["contador"];
        break;
      }
      if($count>0) {
        $error = new sfValidatorError($validator, 'Ya esta ingresado este RIF o CI en la empresa seleccionada');
        throw new sfValidatorErrorSchema($validator, array('doc_id' => $error));
      }
    } else if(!empty($values['doc_id']) && !$this->isNew()) {
      $results = Doctrine_Core::getTable('Cliente')
        ->createQuery('a')
        ->select('id')
        ->Where("empresa_id =?", $values['empresa_id'])
        ->AndWhere("doc_id =?", $values['doc_id'])
        ->execute();
      $cont=0; $id_search="";
      foreach ($results as $result) {
        $id_search=$result["id"];
        if($result["id"]!=$values['id']) {
          $cont++;
        }
      }
      if($cont>0) {
        $error = new sfValidatorError($validator, 'Ya esta ingresado este RIF o CI en la empresa seleccionada');
        throw new sfValidatorErrorSchema($validator, array('doc_id' => $error));
      }
    }

    if(empty($values['celular'])) {
      $values['celular'] = NULL;
    }
    if(empty($values['email'])) {
      $values['email'] = NULL;
    } else {
      $values['email'] = trim(strtolower($values['email']));
    }
    if(empty($values['descripcion'])) {
      $values['descripcion'] = NULL;
    } else {
      $values['descripcion'] = trim(strtoupper($values['descripcion']));
    }

    if(!empty($values['vendedor_01'])) {
      if(empty($values['vendedor_01_profit'])) {
        $error = new sfValidatorError($validator, 'Campo requerido');
        throw new sfValidatorErrorSchema($validator, array('vendedor_01_profit' => $error));
      }
    }

    if(!empty($values['vendedor_02'])) {
      if(empty($values['vendedor_02_profit'])) {
        $error = new sfValidatorError($validator, 'Campo requerido');
        throw new sfValidatorErrorSchema($validator, array('vendedor_02_profit' => $error));
      }
    }

    if(empty($values['dias_credito'])) {
      $values['dias_credito']=NULL;
    }
    if(empty($values['sicm'])) {
      $values['sicm']=NULL;
    }
    if(empty($values['zona'])) {
      $values['zona']=NULL;
    }

    $values['full_name'] = trim(strtoupper($values['full_name']));
    $values['direccion'] = trim(strtoupper($values['direccion']));

    if($this->isNew()) {
      $eid=$values['empresa_id'];
      $count_ccs = Doctrine_Core::getTable('Cliente')
        ->createQuery('a')
        ->select('COUNT(id) as contador')
        ->Where("id LIKE '$eid%'")
        ->limit(1)
        ->execute();
      $count = 0;
      foreach ($count_ccs as $count_cc) {
        $count=$count_cc["contador"];
        break;
      }
      $count = $count+1;
      $values['id']=$eid.$count;
    }

    if(!empty($values['doc_id'])) {
      $values['doc_id']=str_replace("_","",$values['doc_id']);
      if(strlen($values['doc_id'])<12) {
        list($pre,$num)=explode("-",$values['doc_id']);
        $num_new=str_pad((string)$num, 8, "0", STR_PAD_LEFT);
        $doc_new=$pre."-".$num_new;
        $values['doc_id']=$doc_new;
      }
    }
    return $values;
  }
}
