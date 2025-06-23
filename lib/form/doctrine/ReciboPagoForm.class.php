<?php

/**
 * ReciboPago form.
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ReciboPagoForm extends BaseReciboPagoForm
{
  public function configure()
  {
    unset(
      $this['anulado'],
      $this['created_at'],
      $this['updated_at'],
      $this['created_by'],
      $this['updated_by']
    );

    $this->setWidget('moneda', new sfWidgetFormChoice(array('choices' => array(1 => 'BOLIVARES', 2 => 'DOLARES'))));
    $this->widgetSchema['moneda']->setAttributes(array('class' => 'form-control'));

    $this->setWidget('url_imagen', new sfWidgetFormInputFileEditable(array(
      'file_src'    => '/uploads/recibo_pago/'.$this->getObject()->getUrlImagen(),
      'edit_mode'   => !$this->isNew(),
      'is_image'    => true,
      'with_delete' => false,
    )));

    $this->setValidator('url_imagen', new sfValidatorFile(array(
      'mime_types' => 'web_images',
      'path' => sfConfig::get('sf_upload_dir').'/recibo_pago',
      'required' => false,
      ), array(
        'required'   => 'Requerido',
        'invalid'=> 'Invalido',
      )
    ));

    $this->setValidators(array(
      'id' => new sfValidatorInteger(array('required' => true)),
      'empresa_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'))),
      'cliente_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Cliente'))),
      'cuentas_cobrar_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CuentasCobrar'))),
      'ncontrol'          => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'moneda'            => new sfValidatorPass(),
      'forma_pago_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('FormaPago'))),
      'num_recibo'        => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'fecha'             => new sfValidatorDate(),
      'monto'             => new sfValidatorString(array('max_length' => 20)),
      'quien_paga'        => new sfValidatorString(array('max_length' => 200)),
      'url_imagen'        => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'tasa_cambio'       => new sfValidatorString(array('max_length' => 20)),
      'descripcion'       => new sfValidatorString(array('required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorDoctrineUnique(array('model' => 'ReciboPago', 'column' => array('id')), array(
          'invalid'=> 'Codigo ya existente')),
        new sfValidatorCallback(array('callback' => array($this, 'validaciones')))
      ))
    );
  }
  public function validaciones($validator, $values) {
    if($this->isNew()) {
      $eid=$values['empresa_id'];
      $count_ccs = Doctrine_Core::getTable('ReciboPago')
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
      $ncid=floatval($empresa->getNpago())+1;
      $empresa->npago=$ncid;
      $empresa->save();
      $count = $count+1;
      $values['id']=$eid.$count;
      $values['ncontrol']=$ncid;

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

    }
    $values['quien_paga'] = trim(strtoupper($values['quien_paga']));
    return $values;
  }
}
