<?php

/**
 * Retenciones form.
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class RetencionesForm extends BaseRetencionesForm
{
  public function configure()
  {
    unset(
      $this['created_at'],
      $this['updated_at'],
      $this['created_by'],
      $this['updated_by'],
      $this['descripcion']
    );

    $this->setWidget('tipo', new sfWidgetFormChoice(array('choices' => array(1 => 'IVA', 2 => 'ISLR', 3 => 'TIMBRE FISCAL'))));

    $this->setWidget('url_imagen', new sfWidgetFormInputFileEditable(array(
      'file_src'    => '/uploads/retenciones/'.$this->getObject()->getUrlImagen(),
      'edit_mode'   => !$this->isNew(),
      'is_image'    => true,
      'with_delete' => false,
    )));

    $this->setValidators(array(
      'id' => new sfValidatorInteger(array('required' => true)),
      'empresa_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'))),
      'cliente_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Cliente'))),
      'cuentas_cobrar_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CuentasCobrar'))),
      'fecha'     => new sfValidatorDate(array('required' => true), array(
        'required'   => 'Requerido',
        'invalid'=> 'Campo invalido.'
      )),
      'comprobante'    => new sfValidatorString(array('max_length' => 20, 'min_length' => 2, 'required'=> true), array(
        'required'   => 'Requerido',
        'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
        'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
        'invalid'=> 'Campo invalido.'
      )),
      'base_imponible' => new sfValidatorString(array('max_length' => 20, 'min_length' => 1, 'required'=> true), array(
        'required'   => 'Requerido',
        'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
        'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
        'invalid'=> 'Campo invalido.'
      )),
      'iva_impuesto'   => new sfValidatorString(array('max_length' => 20, 'min_length' => 1, 'required'=> true), array(
        'required'   => 'Requerido',
        'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
        'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
        'invalid'=> 'Campo invalido.'
      )),
      'monto'          => new sfValidatorString(array('max_length' => 20, 'min_length' => 1, 'required'=> true), array(
        'required'   => 'Requerido',
        'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
        'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
        'invalid'=> 'Campo invalido.'
      )),
      'monto_usd'          => new sfValidatorString(array('max_length' => 20, 'min_length' => 1, 'required'=> true), array(
        'required'   => 'Requerido',
        'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
        'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
        'invalid'=> 'Campo invalido.'
      )),
      'tipo'           => new sfValidatorInteger(array('required' => true)),
      'descripcion'       => new sfValidatorString(array('max_length' => 2000, 'min_length' => 2, 'required'=> false), array(
        'required'   => 'Requerido',
        'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
        'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
        'invalid'=> 'Campo invalido.'
      )),
      'url_imagen' => new sfValidatorFile(array(
        'path' => sfConfig::get('sf_upload_dir').'/retenciones',
        'required' => false,), array(
          'required'   => 'Campo requerido',
          'invalid'=> 'Campo invalido',
        )),
    ));
    $this->validatorSchema->setPostValidator(
      new sfValidatorCallback(array('callback' => array($this, 'validaciones')))
    );
  }
  public function validaciones($validator, $values) {
    if(!empty($values['cuentas_cobrar_id'])) {
      $cuentas_cobrar=Doctrine::getTable('CuentasCobrar')->findOneBy('id',$values['cuentas_cobrar_id']);
      if($cuentas_cobrar->getEstatus()==3) {
        $error = new sfValidatorError($validator, 'Factura ya se encuentra pagada en su totalidad');
        throw new sfValidatorErrorSchema($validator, array('cuentas_cobrar_id' => $error));
      }
    }

    if($this->isNew()) {
      $eid=$values['empresa_id'];
      $count_ccs = Doctrine_Core::getTable('Retenciones')
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
    
    if(!empty($values['tasa_cambio'])) {
      $money=str_replace(".","",$values['tasa_cambio']);
      $money=str_replace(",",".",$money);
      $values['tasa_cambio'] = floatval($money);
    } else {
      $values['tasa_cambio']=0;
    }
    if(!empty($values['monto'])) {
      $money=str_replace(".","",$values['monto']);
      $money=str_replace(",",".",$money);
      $values['monto'] = floatval($money);
    } else {
      $values['monto']=0;
    }

    if(!empty($values['monto_usd'])) {
      $money=str_replace(".","",$values['monto_usd']);
      $money=str_replace(",",".",$money);
      $values['monto_usd'] = floatval($money);
    } else {
      $values['monto_usd']=0;
    }

    if(!empty($values['iva_impuesto'])) {
      $money=str_replace(".","",$values['iva_impuesto']);
      $money=str_replace(",",".",$money);
      $values['iva_impuesto'] = floatval($money);
    } else {
      $values['iva_impuesto']=0;
    }

    if(!empty($values['base_imponible'])) {
      $money=str_replace(".","",$values['base_imponible']);
      $money=str_replace(",",".",$money);
      $values['base_imponible'] = floatval($money);
    } else {
      $values['base_imponible']=0;
    }

    return $values;
  }
}
