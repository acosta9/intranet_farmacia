<?php

/**
 * Oferta form.
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class OfertaForm extends BaseOfertaForm
{
  public function configure()
  {
    unset(
      $this['created_at'],
      $this['updated_at'],
      $this['created_by'],
      $this['updated_by']
    );

    $this->setWidget('tasa', new sfWidgetFormChoice(array('choices' => array('T01' => 'TASA DE MEDICAMENTOS', 'T02' => 'TASA DE MISCELANEOS', 'T03' => 'TASA DEL DIA'))));
    $this->setWidget('exento', new sfWidgetFormChoice(array('choices' => array(0 => 'NO', 1 => 'SI'))));
    $this->setWidget('activo', new sfWidgetFormChoice(array('choices' => array(0 => 'DES-HABILITADO', 1 => 'HABILITADO'))));
    $this->setWidget('tipo_oferta', new sfWidgetFormChoice(array('choices' => array(1 => 'DESCUENTO', 2 => 'LLEVATE XX PAGA Y', 3 => 'COMBO'))));

    $date = date("Y-m-d");
    $this->setWidget('fecha', new sfWidgetFormInputText());
    $this->widgetSchema['fecha']->setAttributes(array('class' => 'form-control dateonly', 'value' => $date, 'readonly' => 'readonly', 'required' => 'required'));
    $fecha_plus=date('Y-m-d', strtotime($date. ' + 7 days'));
    $this->setWidget('fecha_venc', new sfWidgetFormInputText());
    $this->widgetSchema['fecha_venc']->setAttributes(array('class' => 'form-control dateonly', 'value' => $fecha_plus, 'readonly' => 'readonly', 'required' => 'required'));

    $this->widgetSchema['empresa_id']->addOption('order_by',array('nombre','asc'));

    $this->setWidget('nombre', new sfWidgetFormInputText());

    $this->widgetSchema['nombre']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['empresa_id']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['deposito_id']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['activo']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['tipo_oferta']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['exento']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['precio_usd']->setAttributes(array('class' => 'form-control money'));
    $this->widgetSchema['qty']->setAttributes(array('class' => 'form-control', 'readonly' => true));
    $this->widgetSchema['tasa']->setAttributes(array('class' => 'form-control'));

    $this->setDefault("qty", "0");

    $this->setWidget('url_imagen_desc', new sfWidgetFormInputText());
    $this->widgetSchema['url_imagen_desc']->setAttributes(array('class' => 'form-control'));

    $this->setWidget('url_imagen', new sfWidgetFormInputFileEditable(array(
      'file_src'    => '/uploads/oferta/'.$this->getObject()->getUrlImagen(),
      'edit_mode'   => !$this->isNew(),
      'is_image'    => true,
      'with_delete' => false,
    )));

    $this->setValidators(array(
      'id' => new sfValidatorInteger(array('required' => true)),
      'nombre'      => new sfValidatorString(array('required' => true, 'max_length' => 200)),
      'fecha'       => new sfValidatorDate(),
      'fecha_venc'  => new sfValidatorDate(),
      'empresa_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'))),
      'deposito_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('InvDeposito'))),
      'ncontrol'    => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'tasa'    => new sfValidatorString(array('max_length' => 20, 'required' => true)),
      'tipo_oferta' => new sfValidatorInteger(array('required' => true)),
      'activo'      => new sfValidatorBoolean(array('required' => true)),
      'exento'      => new sfValidatorBoolean(array('required' => true)),
      'precio_usd'  => new sfValidatorString(array('max_length' => 20)),
      'descripcion'    => new sfValidatorString(array('required' => false)),
      'qty'         => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'url_imagen_desc'    => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'url_imagen'         => new sfValidatorFile(array(
        'mime_types' => 'web_images',
        'path' => sfConfig::get('sf_upload_dir').'/oferta',
        'required' => false,), array(
          'required'   => 'Requerido',
          'invalid'=> 'Invalido',
        )
      ),
    ));

    // EMBEDIR DETALLES GALERIA
    //Empotramos al menos un formulario de detalles_factura
    $detgals = $this->getObject()->getOfertaDet();
    if (!$detgals){
      $detgal = new getOfertaDet();
      $detgal->setOferta($this->getObject());
      $detgals = array($detgal);
    }
    //Un formulario vacío hará de contenedor para todas los detalles
    $detgals_forms = new SfForm();
    $count = 1;
    foreach ($detgals as $detgal) {
      $detgals_form = new OfertaDetForm($detgal);
      //Empotramos cada formulario en el contenedor
      $detgals_forms->embedForm($count, $detgals_form);
      $count ++;
    }
    //Empotramos el contenedor en el formulario principal
    $this->embedForm('oferta_det', $detgals_forms);

    $this->validatorSchema->setPostValidator(
      new sfValidatorCallback(array('callback' => array($this, 'validaciones')))
    );
  }
  public function validaciones($validator, $values) {
    if($this->isNew()) {
      $eid=$values['deposito_id'];
      $count_ccs = Doctrine_Core::getTable('Oferta')
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
      $values['ncontrol']=$eid.$count;
    }

    if(!empty($values['nombre'])) {
      $valor_first=strlen($values['nombre']);
      $valor_last=strlen(preg_replace("/[^a-z0-9A-Z_ \/]/", "", $values['nombre']));

      if($valor_first != $valor_last) {
        $error = new sfValidatorError($validator, 'Solo se permiten letras y numeros');
        throw new sfValidatorErrorSchema($validator, array('nombre' => $error));
      }
    }

    if(!empty($values['precio_usd'])) {
      $money=str_replace(".","",$values['precio_usd']);
      $money=str_replace(",",".",$money);
      $values['precio_usd'] = floatval($money);
    } else {
      $error = new sfValidatorError($validator, 'Campo requerido');
      throw new sfValidatorErrorSchema($validator, array('precio_usd' => $error));
    }

    $values['nombre'] = trim(strtoupper($values['nombre']));
    return $values;
  }

  public function addDetalles($num){
    $detgal = new OfertaDet();
    $detgal->setOferta($this->getObject());
    $detgal_form = new OfertaDetForm($detgal);

    //Empotramos la nueva pícture en el contenedor
    $this->embeddedForms['oferta_det']->embedForm($num, $detgal_form);
    //Volvemos a empotrar el contenedor
    $this->embedForm('oferta_det', $this->embeddedForms['oferta_det']);
  }
  public function bind(array $taintedValues = null, array $taintedFiles = null)   {
    if(@$taintedValues['oferta_det']) {
      foreach($taintedValues['oferta_det'] as $key=>$newTodo) {
        if (!isset($this['oferta_det'][$key])) {
          $this->addDetalles($key);
        }
      }
    }
    parent::bind($taintedValues, $taintedFiles);
  }
}
