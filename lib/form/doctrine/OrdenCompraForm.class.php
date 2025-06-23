<?php

/**
 * OrdenCompra form.
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class OrdenCompraForm extends BaseOrdenCompraForm
{
  public function configure()
  {
    unset(
      $this['created_at'],
      $this['updated_at'],
      $this['created_by'],
      $this['updated_by'],
      $this['titulo']
    );

    $this->setWidget('cliente_id', new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Cliente'), 'table_method' => 'doChoices')));
    $this->widgetSchema['cliente_id']->setAttributes(array('class' => 'form-control', 'style' => 'width: 100%'));
    $this->widgetSchema['empresa_id']->addOption('order_by',array('nombre','asc'));

    $this->widgetSchema->setLabels(array(
      'cliente_id' => 'Cliente'
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorInteger(array('required' => true)),
      'ncontrol'                => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'empresa_id'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'))),
      'deposito_id'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('InvDeposito'))),
      'cliente_id'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Cliente'))),
      'orden_compra_estatus_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('OrdenCompraEstatus'), 'required' => false)),
      'total'                   => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'tasa_cambio'             => new sfValidatorString(array('max_length' => 20, 'required' => false))
    ));

    // EMBEDIR DETALLES GALERIA
    //Empotramos al menos un formulario de detalles_factura
    $detgals = $this->getObject()->getOrdenCompraDet();
    if (!$detgals){
      $detgal = new getOrdenCompraDet();
      $detgal->setOrdenCompra($this->getObject());
      $detgals = array($detgal);
    }
    //Un formulario vacío hará de contenedor para todas los detalles
    $detgals_forms = new SfForm();
    $count = 1;
    foreach ($detgals as $detgal) {
      $detgals_form = new OrdenCompraDetForm($detgal);
      //Empotramos cada formulario en el contenedor
      $detgals_forms->embedForm($count, $detgals_form);
      $count ++;
    }
    //Empotramos el contenedor en el formulario principal
    $this->embedForm('orden_compra_det', $detgals_forms);

    $this->validatorSchema->setPostValidator(
      new sfValidatorCallback(array('callback' => array($this, 'validaciones')))
    );
  }
  public function validaciones($validator, $values) {
    if($this->isNew()) {
      $eid=$values['empresa_id'];
      $count_ccs = Doctrine_Core::getTable('OrdenCompra')
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
      $ncid=floatval($empresa->getNcompra())+1;
      $empresa->ncompra=$ncid;
      $empresa->save();
      $count = $count+1;
      $values['id']=$eid.$count;
      $values['ncontrol']=$ncid;
    }
    $values["orden_compra_estatus_id"]=1;

    if(!empty($values['tasa_cambio'])) {
      $money=str_replace(".","",$values['tasa_cambio']);
      $money=str_replace(",",".",$money);
      $values['tasa_cambio'] = floatval($money);
    } else {
      $values['tasa_cambio']=0;
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
    $detgal = new OrdenCompraDet();
    $detgal->setOrdenCompra($this->getObject());
    $detgal_form = new OrdenCompraDetForm($detgal);

    //Empotramos la nueva pícture en el contenedor
    $this->embeddedForms['orden_compra_det']->embedForm($num, $detgal_form);
    //Volvemos a empotrar el contenedor
    $this->embedForm('orden_compra_det', $this->embeddedForms['orden_compra_det']);
  }
  public function bind(array $taintedValues = null, array $taintedFiles = null)   {
    if(@$taintedValues['orden_compra_det']) {
      foreach($taintedValues['orden_compra_det'] as $key=>$newTodo) {
        if (!isset($this['orden_compra_det'][$key])) {
          $this->addDetalles($key);
        }
      }
    }
    parent::bind($taintedValues, $taintedFiles);
  }
}
