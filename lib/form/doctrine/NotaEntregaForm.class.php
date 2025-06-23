<?php

/**
 * NotaEntrega form.
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class NotaEntregaForm extends BaseNotaEntregaForm
{
  public function configure()
  {
    unset(
      $this['created_at'],
      $this['updated_at'],
      $this['created_by'],
      $this['updated_by'],
      $this['forma_pago']
    );

    $this->setWidget('direccion_entrega', new sfWidgetFormInputText());
    $this->setWidget('fecha', new sfWidgetFormInputText());
    $date = date("Y/m/d");
    $date2 = date("d/m/Y");
    $this->widgetSchema['fecha']->setAttributes(array('class' => 'form-control update_fecha', 'value' => $date2, 'data-inputmask' => "'mask': '99/99/9999', 'placeholder': 'dd/mm/yyyy'", 'data-mask' => " "));
    //$fecha_plus=date('d/m/Y', strtotime($date. ' + 10 days'));

    $this->setWidget('cliente_id', new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Cliente'), 'table_method' => 'doChoices')));
    $this->widgetSchema['cliente_id']->setAttributes(array('class' => 'form-control', 'style' => 'width: 100%'));
    $this->widgetSchema['empresa_id']->addOption('order_by',array('nombre','asc'));
    $this->widgetSchema['dias_credito']->setAttributes(array('class' => 'form-control number2'));

    $this->setWidget('direccion', new sfWidgetFormInputText());

    $this->widgetSchema->setLabels(array(
      'cliente_id' => 'Cliente',
      'direccion' => 'Dirección Fiscal',
      'doc_id' => 'Doc. de Identidad',
      'fecha' => 'Fecha de Emisión',
      'dias_credito' => 'Dias de credito'
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorInteger(array('required' => true)),
      'fecha'             => new sfValidatorDate(),
      'dias_credito'      => new sfValidatorInteger(array('required' => true)),
      'empresa_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'))),
      'deposito_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('InvDeposito'))),
      'cliente_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Cliente'))),
      'razon_social'      => new sfValidatorString(array('max_length' => 200)),
      'doc_id'            => new sfValidatorString(array('max_length' => 20)),
      'telf'              => new sfValidatorString(array('max_length' => 20)),
      'direccion'         => new sfValidatorString(),
      'direccion_entrega' => new sfValidatorString(array('required' => false)),
      'ncontrol'          => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'forma_pago'        => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'tasa_cambio'       => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'subtotal'          => new sfValidatorString(array('max_length' => 20)),
      'subtotal_desc'     => new sfValidatorString(array('max_length' => 20)),
      'iva'               => new sfValidatorString(array('max_length' => 20)),
      'iva_monto'         => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'total'             => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'base_imponible'    => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'descuento'         => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'monto_faltante'    => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'monto_pagado'      => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'estatus'           => new sfValidatorInteger(array('required' => false)),
    ));

    // EMBEDIR DETALLES GALERIA
    //Empotramos al menos un formulario de detalles_factura
    $detgals = $this->getObject()->getNotaEntregaDet();
    if (!$detgals){
      $detgal = new getNotaEntregaDet();
      $detgal->setNotaEntrega($this->getObject());
      $detgals = array($detgal);
    }
    //Un formulario vacío hará de contenedor para todas los detalles
    $detgals_forms = new SfForm();
    $count = 1;
    foreach ($detgals as $detgal) {
      $detgals_form = new NotaEntregaDetForm($detgal);
      //Empotramos cada formulario en el contenedor
      $detgals_forms->embedForm($count, $detgals_form);
      $count ++;
    }
    //Empotramos el contenedor en el formulario principal
    $this->embedForm('nota_entrega_det', $detgals_forms);

    $this->validatorSchema->setPostValidator(
      new sfValidatorCallback(array('callback' => array($this, 'validaciones')))
    );
  }
  public function validaciones($validator, $values) {
    if($this->isNew()) {
      $eid=$values['empresa_id'];
      $count_ccs = Doctrine_Core::getTable('NotaEntrega')
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

      $empresa = Doctrine_Core::getTable('Empresa')->findOneBy('id', $eid);
      $ncid=0;
      $ncid=floatval($empresa->getNentrega())+1;
      $empresa->nentrega=$ncid;
      $empresa->save();
      $count = $count+1;
      $values['id']=$eid.$count;
      $values['ncontrol']=$ncid;
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
    $detgal = new NotaEntregaDet();
    $detgal->setNotaEntrega($this->getObject());
    $detgal_form = new NotaEntregaDetForm($detgal);

    //Empotramos la nueva pícture en el contenedor
    $this->embeddedForms['nota_entrega_det']->embedForm($num, $detgal_form);
    //Volvemos a empotrar el contenedor
    $this->embedForm('nota_entrega_det', $this->embeddedForms['nota_entrega_det']);
  }
  public function bind(array $taintedValues = null, array $taintedFiles = null)   {
    if(@$taintedValues['nota_entrega_det']) {
      foreach($taintedValues['nota_entrega_det'] as $key=>$newTodo) {
        if (!isset($this['nota_entrega_det'][$key])) {
          $this->addDetalles($key);
        }
      }
    }
    parent::bind($taintedValues, $taintedFiles);
  }
}
