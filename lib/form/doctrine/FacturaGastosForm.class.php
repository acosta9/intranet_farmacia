<?php

/**
 * FacturaGastos form.
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class FacturaGastosForm extends BaseFacturaGastosForm
{
  public function configure()
  {
    unset(
      $this['created_at'],
      $this['updated_at'],
      $this['created_by'],
      $this['updated_by']
    );

    $this->setWidget('libro_compras', new sfWidgetFormChoice(array('choices' => array('1' => 'SI', '2' => 'NO'))));
    $this->widgetSchema['gastos_tipo_id']->addOption('order_by',array('nombre','asc'));
    $this->setWidget('tipo', new sfWidgetFormChoice(array('choices' => array('1' => 'FACTURA DE GASTOS', '2' => 'NOTA DE DEBITO'))));

    $this->setValidators(array(
      'id'             => new sfValidatorInteger(array('required' => true)),
      'gastos_tipo_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('GastosTipo'), 'required' => false)),
      'fecha'          => new sfValidatorDate(),
      'fecha_recepcion' => new sfValidatorDate(),
      'dias_credito'    => new sfValidatorString(array('max_length' => 4)),
      'empresa_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'))),
      'proveedor_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Proveedor'))),
      'razon_social'   => new sfValidatorString(array('max_length' => 200)),
      'doc_id'         => new sfValidatorString(array('max_length' => 20)),
      'telf'           => new sfValidatorString(array('max_length' => 20)),
      'direccion'      => new sfValidatorString(),
      'ncontrol'       => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'num_factura'    => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'tasa_cambio'    => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'descuento'      => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'iva'            => new sfValidatorString(array('max_length' => 20)),
      'base_imponible' => new sfValidatorString(array('max_length' => 20)),
      'iva_monto'      => new sfValidatorString(array('max_length' => 20)),
      'subtotal'       => new sfValidatorString(array('max_length' => 20)),
      'subtotal_desc'  => new sfValidatorString(array('max_length' => 20)),
      'total'          => new sfValidatorString(array('max_length' => 20)),
      'total2'         => new sfValidatorString(array('max_length' => 20)),
      'monto_faltante' => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'monto_pagado'   => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'estatus'        => new sfValidatorInteger(array('required' => false)),
      'libro_compras'  => new sfValidatorInteger(array('required' => false)),
      'tipo'           => new sfValidatorInteger(array('required' => false))
    ));

    // EMBEDIR DETALLES GALERIA
    //Empotramos al menos un formulario de detalles_factura
    $detgals = $this->getObject()->getFacturaGastosDet();
    if (!$detgals){
      $detgal = new getFacturaGastosDet();
      $detgal->setFacturaGastos($this->getObject());
      $detgals = array($detgal);
    }
    //Un formulario vacío hará de contenedor para todas los detalles
    $detgals_forms = new SfForm();
    $count = 1;
    foreach ($detgals as $detgal) {
      $detgals_form = new FacturaGastosDetForm($detgal);
      //Empotramos cada formulario en el contenedor
      $detgals_forms->embedForm($count, $detgals_form);
      $count ++;
    }
    //Empotramos el contenedor en el formulario principal
    $this->embedForm('factura_gastos_det', $detgals_forms);

    $this->validatorSchema->setPostValidator(
      new sfValidatorCallback(array('callback' => array($this, 'validaciones')))
    );
  }
  public function validaciones($validator, $values) {
    if($this->isNew()) {
      $eid=$values['empresa_id'];
      $count_ccs = Doctrine_Core::getTable('FacturaGastos')
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
    if(!empty($values['total2'])) {
      $money=str_replace(".","",$values['total2']);
      $money=str_replace(",",".",$money);
      $values['total2'] = floatval($money);
    } else {
      $values['total2']=0;
    }
    if(!empty($values['iva'])) {
      $money=str_replace(".","",$values['iva']);
      $money=str_replace(",",".",$money);
      $values['iva'] = floatval($money);
    } else {
      $values['iva']=0;
    }
    if(!empty($values['base_imponible'])) {
      $money=str_replace(".","",$values['base_imponible']);
      $money=str_replace(",",".",$money);
      $values['base_imponible'] = floatval($money);
    } else {
      $values['base_imponible']=0;
    }
    if(!empty($values['iva_monto'])) {
      $money=str_replace(".","",$values['iva_monto']);
      $money=str_replace(",",".",$money);
      $values['iva_monto'] = floatval($money);
    } else {
      $values['iva_monto']=0;
    }
    
    return $values;
  }
  public function addDetalles($num){
    $detgal = new FacturaGastosDet();
    $detgal->setFacturaGastos($this->getObject());
    $detgal_form = new FacturaGastosDetForm($detgal);

    //Empotramos la nueva pícture en el contenedor
    $this->embeddedForms['factura_gastos_det']->embedForm($num, $detgal_form);
    //Volvemos a empotrar el contenedor
    $this->embedForm('factura_gastos_det', $this->embeddedForms['factura_gastos_det']);
  }
  public function bind(array $taintedValues = null, array $taintedFiles = null)   {
    if(@$taintedValues['factura_gastos_det']) {
      foreach($taintedValues['factura_gastos_det'] as $key=>$newTodo) {
        if (!isset($this['factura_gastos_det'][$key])) {
          $this->addDetalles($key);
        }
      }
    }
    parent::bind($taintedValues, $taintedFiles);
  }
}
