<?php

/**
 * Traslado form.
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TrasladoForm extends BaseTrasladoForm
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
      'id'             => new sfValidatorInteger(array('required' => false)),
      'empresa_desde'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'))),
      'deposito_desde' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('InvDeposito'))),
      'empresa_hasta'  => new sfValidatorInteger(),
      'deposito_hasta' => new sfValidatorInteger(),
      'estatus'       => new sfValidatorInteger(array('required' => false)),
      'tasa_cambio'    => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'monto'          => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'ncontrol'    => new sfValidatorString(array('max_length' => 20, 'required' => false)),
    ));

    // EMBEDIR DETALLES GALERIA
    //Empotramos al menos un formulario de detalles_factura
    $detgals = $this->getObject()->getTrasladoDet();
    if (!$detgals){
      $detgal = new getTrasladoDet();
      $detgal->setTraslado($this->getObject());
      $detgals = array($detgal);
    }
    //Un formulario vacío hará de contenedor para todas los detalles
    $detgals_forms = new SfForm();
    $count = 1;
    foreach ($detgals as $detgal) {
      $detgals_form = new TrasladoDetForm($detgal);
      //Empotramos cada formulario en el contenedor
      $detgals_forms->embedForm($count, $detgals_form);
      $count ++;
    }
    //Empotramos el contenedor en el formulario principal
    $this->embedForm('traslado_det', $detgals_forms);

    $this->validatorSchema->setPostValidator(
      new sfValidatorCallback(array('callback' => array($this, 'validaciones')))
    );
  }
  public function validaciones($validator, $values) {
    if($this->isNew()) {
      $eid=$values['empresa_desde'];
      $count_ccs = Doctrine_Core::getTable('Traslado')
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

      if(!empty($values['tasa'])) {
        $money=str_replace(".","",$values['tasa']);
        $money=str_replace(",",".",$money);
        $values['tasa'] = floatval($money);
      } else {
        $values['tasa']=0;
      }
      if(!empty($values['monto'])) {
        $money=str_replace(".","",$values['monto']);
        $money=str_replace(",",".",$money);
        $values['monto'] = floatval($money);
      } else {
        $values['monto']=0;
      }
    }
    return $values;
  }
  public function addDetalles($num){
    $detgal = new TrasladoDet();
    $detgal->setTraslado($this->getObject());
    $detgal_form = new TrasladoDetForm($detgal);

    //Empotramos la nueva pícture en el contenedor
    $this->embeddedForms['traslado_det']->embedForm($num, $detgal_form);
    //Volvemos a empotrar el contenedor
    $this->embedForm('traslado_det', $this->embeddedForms['traslado_det']);
  }
  public function bind(array $taintedValues = null, array $taintedFiles = null)   {
    if(@$taintedValues['traslado_det']) {
      foreach($taintedValues['traslado_det'] as $key=>$newTodo) {
        if (!isset($this['traslado_det'][$key])) {
          $this->addDetalles($key);
        }
      }
    }
    parent::bind($taintedValues, $taintedFiles);
  }
}
