<?php

/**
 * OrdenesCompra form.
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class OrdenesCompraForm extends BaseOrdenesCompraForm
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
      'id'             => new sfValidatorInteger(array('required' => true)),
      'dias_credito'   => new sfValidatorString(array('max_length' => 4)),
      'cotizacion_compra_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CotizacionCompra'))),
      'empresa_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'))),
      'proveedor_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Proveedor'))),
      'razon_social'   => new sfValidatorString(array('max_length' => 200)),
      'doc_id'         => new sfValidatorString(array('max_length' => 20)),
      'telf'           => new sfValidatorString(array('max_length' => 20)),
      'direccion'      => new sfValidatorString(),
      'ncontrol'       => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'tasa_cambio'    => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'descuento'      => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'subtotal'       => new sfValidatorString(array('max_length' => 20)),
      'subtotal_desc'  => new sfValidatorString(array('max_length' => 20)),
      'total'          => new sfValidatorString(array('max_length' => 20)),
      'estatus'        => new sfValidatorInteger(array('required' => false)),
    ));

    // EMBEDIR DETALLES GALERIA
    //Empotramos al menos un formulario de detalles_factura
    $detgals = $this->getObject()->getOrdenesCompraDet();
    if (!$detgals){
      $detgal = new getOrdenesCompraDet();
      $detgal->setOrdenesCompra($this->getObject());
      $detgals = array($detgal);
    }
    //Un formulario vacío hará de contenedor para todas los detalles
    $detgals_forms = new SfForm();
    $count = 1;
    foreach ($detgals as $detgal) {
      $detgals_form = new OrdenesCompraDetForm($detgal);
      //Empotramos cada formulario en el contenedor
      $detgals_forms->embedForm($count, $detgals_form);
      $count ++;
    }
    //Empotramos el contenedor en el formulario principal
    $this->embedForm('ordenes_compra_det', $detgals_forms);

    $this->validatorSchema->setPostValidator(
      new sfValidatorCallback(array('callback' => array($this, 'validaciones')))
    );
  }
  public function validaciones($validator, $values) {
    if($this->isNew()) {
      $eid=$values['empresa_id'];
      $count_ccs = Doctrine_Core::getTable('OrdenesCompra')
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
    if(!empty($values['dias_credito'])) {
      $values['dias_credito']=str_pad($values['dias_credito'], 3, "0", STR_PAD_LEFT);
    }
    if(!empty($values['tasa_cambio'])) {
      $money=str_replace(".","",$values['tasa_cambio']);
      $money=str_replace(",",".",$money);
      $values['tasa_cambio'] = floatval($money);
    } else {
      $values['tasa_cambio']=0;
    }
    if(!empty($values['descuento'])) {
      $money=str_replace(".","",$values['descuento']);
      $money=str_replace(",",".",$money);
      $values['descuento'] = floatval($money);
    } else {
      $values['descuento']=0;
    }
    if(!empty($values['subtotal'])) {
      $money=str_replace(".","",$values['subtotal']);
      $money=str_replace(",",".",$money);
      $values['subtotal'] = floatval($money);
    } else {
      $values['subtotal']=0;
    }
    if(!empty($values['subtotal_desc'])) {
      $money=str_replace(".","",$values['subtotal_desc']);
      $money=str_replace(",",".",$money);
      $values['subtotal_desc'] = floatval($money);
    } else {
      $values['subtotal_desc']=0;
    }
    if(!empty($values['total'])) {
      $money=str_replace(".","",$values['total']);
      $money=str_replace(",",".",$money);
      $values['total'] = floatval($money);
    } else {
      $values['total']=0;
    }
    return $values;
  }
  public function addDetalles($num){
    $detgal = new OrdenesCompraDet();
    $detgal->setOrdenesCompra($this->getObject());
    $detgal_form = new OrdenesCompraDetForm($detgal);

    //Empotramos la nueva pícture en el contenedor
    $this->embeddedForms['ordenes_compra_det']->embedForm($num, $detgal_form);
    //Volvemos a empotrar el contenedor
    $this->embedForm('ordenes_compra_det', $this->embeddedForms['ordenes_compra_det']);
  }
  public function bind(array $taintedValues = null, array $taintedFiles = null)   {
    if(@$taintedValues['ordenes_compra_det']) {
      foreach($taintedValues['ordenes_compra_det'] as $key=>$newTodo) {
        if (!isset($this['ordenes_compra_det'][$key])) {
          $this->addDetalles($key);
        }
      }
    }
    parent::bind($taintedValues, $taintedFiles);
  }
}
