<?php

/**
 * DevolverCompra form.
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class DevolverCompraForm extends BaseDevolverCompraForm
{
  public function configure()
  {
  	unset(
      $this['created_at'],
      $this['updated_at'],
      $this['created_by'],
      $this['updated_by']
    );
   

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'empresa_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'))),
      'tasa_cambio'        => new sfValidatorString(array('max_length' => 20, 'required' => true)),
      'factura_compra_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('FacturaCompra'))),
      'proveedor_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Proveedor'))),
      'fecha'             => new sfValidatorDate(),
      'estatus'        => new sfValidatorInteger(array('required' => false)),
      'descripcion'       => new sfValidatorString(array('required' => false)),
    ));
        // EMBEDIR DETALLES GALERIA
    //Empotramos al menos un formulario de detalles_factura
    $detgals = $this->getObject()->getDevolverCompraDet();
    if (!$detgals){
      $detgal = new getDevolverCompraDet();
      $detgal->setDevolverCompra($this->getObject());
      $detgals = array($detgal);
    }
    //Un formulario vacío hará de contenedor para todas los detalles
    $detgals_forms = new SfForm();
    $count = 1;
    foreach ($detgals as $detgal) {
      $detgals_form = new DevolverCompraDetForm($detgal);
      //Empotramos cada formulario en el contenedor
      $detgals_forms->embedForm($count, $detgals_form);
      $count ++;
    }
    //Empotramos el contenedor en el formulario principal
    $this->embedForm('devolver_compra_det', $detgals_forms);

    $this->validatorSchema->setPostValidator(
      new sfValidatorCallback(array('callback' => array($this, 'validaciones')))
    );
  }

  public function validaciones($validator, $values) {
    if($this->isNew()) {
      $eid=$values['empresa_id'];
      $count_ccs = Doctrine_Core::getTable('DevolverCompra')
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
/*
    if(!empty($values['tasa_cambio'])) {
      $money=str_replace(".","",$values['tasa_cambio']);
      $money=str_replace(",",".",$money);
      $values['tasa_cambio'] = floatval($money);
    } else {
      $values['tasa_cambio']=0;
    }
    */
    return $values;
  }

  public function addDetalles($num){
    $detgal = new DevolverCompraDet();
    $detgal->setDevolverCompra($this->getObject());
    $detgal_form = new DevolverCompraDetForm($detgal);

    //Empotramos la nueva pícture en el contenedor
    $this->embeddedForms['devolver_compra_det']->embedForm($num, $detgal_form);
    //Volvemos a empotrar el contenedor
    $this->embedForm('devolver_compra_det', $this->embeddedForms['devolver_compra_det']);
  }
  public function bind(array $taintedValues = null, array $taintedFiles = null)   {
    if(@$taintedValues['devolver_compra_det']) {
      foreach($taintedValues['devolver_compra_det'] as $key=>$newTodo) {
        if (!isset($this['devolver_compra_det'][$key])) {
          $this->addDetalles($key);
        }
      }
    }
    parent::bind($taintedValues, $taintedFiles);
  }

}
