<?php

/**
 * Producto form.
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ProductoForm extends BaseProductoForm
{
  public function configure()
  {
    unset(
      $this['created_at'],
      $this['updated_at'],
      $this['created_by'],
      $this['updated_by']
    );

    $choices_prods = array();

    $choices_tags = array();

    $this->setWidget('subproducto_id', new sfWidgetFormSelect(array('choices' =>  $choices_prods)));
    $this->setWidget('tags', new sfWidgetFormSelect(array('choices' =>  $choices_tags, 'multiple' => 'multiple')));

    $this->setWidget('tasa', new sfWidgetFormChoice(array('choices' => array("" => "", "T01" => 'TASA MEDICAMENTOS', "T02" => 'TASA MISCELANEOS', "T03" => 'TASA DEL DIA'))));        
    $this->setWidget('nombre', new sfWidgetFormInputText());
    $this->setWidget('tipo', new sfWidgetFormChoice(array('choices' => array(0 => 'NACIONAL', 1 => 'IMPORTADO'))));
    $this->setWidget('activo', new sfWidgetFormChoice(array('choices' => array(0 => 'DES-HABILITADO', 1 => 'HABILITADO'))));
    $this->setWidget('exento', new sfWidgetFormChoice(array('choices' => array(0 => 'NO', 1 => 'SI'))));
    $this->setWidget('destacado', new sfWidgetFormChoice(array('choices' => array(0 => 'NO', 1 => 'SI'))));
    $this->widgetSchema['laboratorio_id']->addOption('order_by',array('nombre','asc'));
    $this->widgetSchema['categoria_id']->addOption('order_by',array('nombre','asc'));
    $this->widgetSchema['unidad_id']->addOption('order_by',array('nombre','asc'));
    $this->setDefault("util_usd_1", "0.1000");
    $this->setDefault("util_usd_2", "0.1000");
    $this->setDefault("util_usd_3", "0.1000");
    $this->setDefault("util_usd_4", "0.1000");
    $this->setDefault("util_usd_5", "0.1000");
    $this->setDefault("util_usd_6", "0.1000");
    $this->setDefault("util_usd_7", "0.1000");
    $this->setDefault("util_usd_8", "0.1000");

    $this->widgetSchema['nombre']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['serial']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['codigo']->setAttributes(array('class' => 'form-control', 'readonly' => 'readonly'));
    $this->widgetSchema['unidad_id']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['tipo']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['activo']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['costo_usd_1']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['util_usd_1']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['util_usd_2']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['util_usd_3']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['util_usd_4']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['util_usd_5']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['util_usd_6']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['util_usd_7']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['util_usd_8']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['precio_usd_1']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['precio_usd_2']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['precio_usd_3']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['precio_usd_4']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['precio_usd_5']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['precio_usd_6']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['precio_usd_7']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['precio_usd_8']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['destacado']->setAttributes(array('class' => 'form-control'));

    $this->setWidget('url_imagen_desc', new sfWidgetFormInputText());
    $this->widgetSchema['url_imagen_desc']->setAttributes(array('class' => 'form-control'));

    $this->setWidget('url_imagen', new sfWidgetFormInputFileEditable(array(
      'file_src'    => '/uploads/producto/'.$this->getObject()->getUrlImagen(),
      'edit_mode'   => !$this->isNew(),
      'is_image'    => true,
      'with_delete' => false,
    )));

    $this->setValidator('url_imagen', new sfValidatorFile(array(
      'mime_types' => 'web_images',
      'path' => sfConfig::get('sf_upload_dir').'/producto',
      'required' => false,), array(
        'required'   => 'Requerido',
        'invalid'=> 'Invalido',
      )
    ));

    $this->setValidator('tags', new sfValidatorPass());

    // EMBEDIR DETALLES GALERIA
    //Empotramos al menos un formulario de detalles_factura
    $detgals = $this->getObject()->getProductoImg();
    if (!$detgals){
      $detgal = new getProductoImg();
      $detgal->setProducto($this->getObject());
      $detgals = array($detgal);
    }
    //Un formulario vacío hará de contenedor para todas los detalles
    $detgals_forms = new SfForm();
    $count = 1;
    foreach ($detgals as $detgal) {
      $detgals_form = new ProductoImgForm($detgal);
      //Empotramos cada formulario en el contenedor
      $detgals_forms->embedForm($count, $detgals_form);
      $count ++;
    }
    //Empotramos el contenedor en el formulario principal
    $this->embedForm('producto_img', $detgals_forms);
/*
    $subForm = new sfForm();
    for ($i = 0; $i < 1; $i++) {
      $productoHijo = new ProductoHijo();
      $productoHijo->Producto = $this->getObject();
      $form = new ProductoHijoForm($productoHijo);
      $subForm->embedForm($i, $form);
    }
    $this->embedForm('newHijos', $subForm);
*/
    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorDoctrineUnique(array('model' => 'Producto', 'column' => array('serial')), array(
          'invalid'=> 'Serial ya existente')),
        new sfValidatorDoctrineUnique(array('model' => 'Producto', 'column' => array('serial_bulto1')), array(
          'invalid'=> 'Serial ya existente')),
        new sfValidatorDoctrineUnique(array('model' => 'Producto', 'column' => array('serial_bulto2')), array(
          'invalid'=> 'Serial ya existente')),
        new sfValidatorCallback(array('callback' => array($this, 'validaciones')))
      ))
    );
  }
  public function validaciones($validator, $values) {
    if(!empty($values['nombre'])) {
      $values['nombre'] = trim(strtoupper($values['nombre']));
    }
    if(!empty($values['subproducto_id']) && empty($values['qty_desglozado'])) {
      $error = new sfValidatorError($validator, 'Cantidad es un campo requerido');
      throw new sfValidatorErrorSchema($validator, array('qty_desglozado' => $error));
    }
    if(!empty($values['subproducto_id']) && !$this->isNew()) {
      if($values['id']==$values['subproducto_id']) {
        $error = new sfValidatorError($validator, 'SubProducto no puede ser el mismo serial del producto padre');
        throw new sfValidatorErrorSchema($validator, array('subproducto_id' => $error));
      }
    }
    if(!empty($values['serial_bulto1']) && empty($values['cantidad_bulto1'])) {
      $error = new sfValidatorError($validator, 'Campo requerido');
      throw new sfValidatorErrorSchema($validator, array('cantidad_bulto1' => $error));
    }

    if(!empty($values['serial_bulto2']) && empty($values['cantidad_bulto2'])) {
      $error = new sfValidatorError($validator, 'Campo requerido');
      throw new sfValidatorErrorSchema($validator, array('cantidad_bulto2' => $error));
    }

    if(!empty($values['cantidad_bulto1']) && empty($values['serial_bulto1'])) {
      $error = new sfValidatorError($validator, 'Campo requerido');
      throw new sfValidatorErrorSchema($validator, array('serial_bulto1' => $error));
    }

    if(!empty($values['cantidad_bulto2']) && empty($values['serial_bulto2'])) {
      $error = new sfValidatorError($validator, 'Campo requerido');
      throw new sfValidatorErrorSchema($validator, array('serial_bulto2' => $error));
    }

    if(empty($values['subproducto_id'])) {
      $values['subproducto_id']=NULL;
      $values['qty_desglozado']=NULL;
    }
    if(!empty($values['url_imagen_desc'])) {
      $values['url_imagen_desc']=trim(strtoupper($values['url_imagen_desc']));
    }
    $values['activo']=1;

    //print_r($values["tags"]);
    //print_r(implode(";",$values["tags"]));
    $tags=implode(";",$values["tags"]);
    $values["tags"]=mb_strtoupper($tags);

    if(empty($values['serial_bulto1'])) {
      $values['serial_bulto1']=NULL;
    }
    if(empty($values['serial_bulto2'])) {
      $values['serial_bulto2']=NULL;
    }

    if(!empty($values['costo_usd_1'])) {
      $money=str_replace(".","",$values['costo_usd_1']);
      $money=str_replace(",",".",$money);
      $values['costo_usd_1'] = floatval($money);
    }

    if(!empty($values['util_usd_1'])) {
      $money=str_replace(".","",$values['util_usd_1']);
      $money=str_replace(",",".",$money);
      $values['util_usd_1'] = floatval($money);
    }

    if(!empty($values['util_usd_2'])) {
      $money=str_replace(".","",$values['util_usd_2']);
      $money=str_replace(",",".",$money);
      $values['util_usd_2'] = floatval($money);
    }

    if(!empty($values['util_usd_3'])) {
      $money=str_replace(".","",$values['util_usd_3']);
      $money=str_replace(",",".",$money);
      $values['util_usd_3'] = floatval($money);
    }

    if(!empty($values['util_usd_4'])) {
      $money=str_replace(".","",$values['util_usd_4']);
      $money=str_replace(",",".",$money);
      $values['util_usd_4'] = floatval($money);
    }

    if(!empty($values['util_usd_5'])) {
      $money=str_replace(".","",$values['util_usd_5']);
      $money=str_replace(",",".",$money);
      $values['util_usd_5'] = floatval($money);
    }

    if(!empty($values['util_usd_6'])) {
      $money=str_replace(".","",$values['util_usd_6']);
      $money=str_replace(",",".",$money);
      $values['util_usd_6'] = floatval($money);
    }

    if(!empty($values['util_usd_7'])) {
      $money=str_replace(".","",$values['util_usd_7']);
      $money=str_replace(",",".",$money);
      $values['util_usd_7'] = floatval($money);
    }

    if(!empty($values['util_usd_8'])) {
      $money=str_replace(".","",$values['util_usd_8']);
      $money=str_replace(",",".",$money);
      $values['util_usd_8'] = floatval($money);
    }

    if(!empty($values['precio_usd_1'])) {
      $money=str_replace(".","",$values['precio_usd_1']);
      $money=str_replace(",",".",$money);
      $values['precio_usd_1'] = floatval($money);
    }

    if(!empty($values['precio_usd_2'])) {
      $money=str_replace(".","",$values['precio_usd_2']);
      $money=str_replace(",",".",$money);
      $values['precio_usd_2'] = floatval($money);
    }

    if(!empty($values['precio_usd_3'])) {
      $money=str_replace(".","",$values['precio_usd_3']);
      $money=str_replace(",",".",$money);
      $values['precio_usd_3'] = floatval($money);
    }

    if(!empty($values['precio_usd_4'])) {
      $money=str_replace(".","",$values['precio_usd_4']);
      $money=str_replace(",",".",$money);
      $values['precio_usd_4'] = floatval($money);
    }

    if(!empty($values['precio_usd_5'])) {
      $money=str_replace(".","",$values['precio_usd_5']);
      $money=str_replace(",",".",$money);
      $values['precio_usd_5'] = floatval($money);
    }

    if(!empty($values['precio_usd_6'])) {
      $money=str_replace(".","",$values['precio_usd_6']);
      $money=str_replace(",",".",$money);
      $values['precio_usd_6'] = floatval($money);
    }

    if(!empty($values['precio_usd_7'])) {
      $money=str_replace(".","",$values['precio_usd_7']);
      $money=str_replace(",",".",$money);
      $values['precio_usd_7'] = floatval($money);
    }

    if(!empty($values['precio_usd_8'])) {
      $money=str_replace(".","",$values['precio_usd_8']);
      $money=str_replace(",",".",$money);
      $values['precio_usd_8'] = floatval($money);
    }
    
    return $values;
  }
  public function addDetalles($num){
    $detgal = new ProductoImg();
    $detgal->setProducto($this->getObject());
    $detgal_form = new ProductoImgForm($detgal);

    //Empotramos la nueva pícture en el contenedor
    $this->embeddedForms['producto_img']->embedForm($num, $detgal_form);
    //Volvemos a empotrar el contenedor
    $this->embedForm('producto_img', $this->embeddedForms['producto_img']);
  }
  public function bind(array $taintedValues = null, array $taintedFiles = null)   {
    if(@$taintedValues['producto_img']) {
      foreach($taintedValues['producto_img'] as $key=>$newTodo) {
        if (!isset($this['producto_img'][$key])) {
          $this->addDetalles($key);
        }
      }
    }
    parent::bind($taintedValues, $taintedFiles);
  }
}
