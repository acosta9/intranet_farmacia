<?php

/**
 * Inventario filter form.
 *
 * @package    ired.localhost
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class InventarioFormFilter extends BaseInventarioFormFilter
{
  public function configure()
  {
    $choices_user = array();
    $results = Doctrine_Query::create()
      ->select('u.full_name, u.username')
      ->from('SfGuardUser u')
      ->orderBy('u.full_name ASC')
      ->execute();
    foreach ($results as $result) {
        $choices_user[$result->getId()]=$result["full_name"]." (".$result["username"].")";
    }

    $choices_emp = array();
    $results = Doctrine_Query::create()
      ->select('e.acronimo')
      ->from('Empresa e')
      ->orderBy('e.acronimo ASC')
      ->execute();
    foreach ($results as $result) {
        $choices_emp[$result->getId()]=$result["acronimo"];
    }

    $choices_unidad = array();
    $results = Doctrine_Query::create()
      ->select('pu.nombre')
      ->from('ProdUnidad pu')
      ->orderBy('pu.nombre ASC')
      ->execute();
    foreach ($results as $result) {
        $choices_unidad[$result->getId()]=$result["nombre"];
    }

    $choices_cat = array();
    $results = Doctrine_Query::create()
      ->select('pc.nombre')
      ->from('ProdCategoria pc')
      ->orderBy('pc.nombre ASC')
      ->execute();
    foreach ($results as $result) {
        $choices_cat[$result["nombre"]]=$result["nombre"];
    }

    $choices_compuesto = array();
    /*$results = Doctrine_Query::create()
      ->select('c.nombre')
      ->from('Compuesto c')
      ->orderBy('c.nombre ASC')
      ->execute();
    foreach ($results as $result) {
        $choices_compuesto[$result->getId()]=$result["nombre"];
    }*/

    $choices_lab = array();
    /*$results = Doctrine_Query::create()
      ->select('pl.nombre')
      ->from('ProdLaboratorio pl')
      ->orderBy('pl.nombre ASC')
      ->execute();
    foreach ($results as $result) {
        $choices_lab[$result->getId()]=$result["nombre"];
    }*/

    $choices_producto = array();
    /*$results = Doctrine_Query::create()
      ->select('p.nombre, p.serial')
      ->from('Producto p')
      ->orderBy('p.nombre ASC')
      ->execute();
    foreach ($results as $result) {
      $choices_producto[$result->getId()]=$result["nombre"]."[".$result["serial"]."]";
    }*/

    $this->setWidget('unidad_id', new sfWidgetFormSelect(array('choices' =>  $choices_unidad, 'multiple' => 'multiple')));
    $this->setWidget('categoria_id', new sfWidgetFormSelect(array('choices' =>  $choices_cat, 'multiple' => 'multiple')));
    $this->setWidget('compuesto_id', new sfWidgetFormSelect(array('choices' =>  $choices_compuesto, 'multiple' => 'multiple')));
    $this->setWidget('laboratorio_id', new sfWidgetFormSelect(array('choices' =>  $choices_lab, 'multiple' => 'multiple')));

    $this->setWidget('vencido', new sfWidgetFormChoice(array('choices' => array('' => '', 0 => 'NO', 1 => 'SI'))));
    $this->setWidget('tipo', new sfWidgetFormChoice(array('choices' => array('' => '', 0 => 'NACIONAL', 1 => 'IMPORTADO'))));
    $this->setWidget('activo', new sfWidgetFormChoice(array('choices' => array('' => '', 1 => 'HABILITADO', 0 => 'DES-HABILITADO'))));
    $this->setWidget('destacado', new sfWidgetFormChoice(array('choices' => array('' => '', 1 => 'SI', 0 => 'NO'))));
    $this->setWidget('empresa_id', new sfWidgetFormSelect(array('choices' =>  $choices_emp, 'multiple' => 'multiple')));
    $this->setWidget('creado_por', new sfWidgetFormSelect(array('choices' =>  $choices_user, 'multiple' => 'multiple')));
    $this->setWidget('updated_por', new sfWidgetFormSelect(array('choices' =>  $choices_user, 'multiple' => 'multiple')));
    $this->setWidget('producto', new sfWidgetFormSelect(array('choices' =>  $choices_producto, 'multiple' => 'multiple')));

    $this->setWidget('proximo_vencer', new sfWidgetFormFilterInput(array('with_empty' => false)));
    $this->setWidget('cod', new sfWidgetFormFilterInput(array('with_empty' => false)));
    $this->setWidget('serial', new sfWidgetFormFilterInput(array('with_empty' => false)));
    $this->setWidget('qty_mayor', new sfWidgetFormFilterInput(array('with_empty' => false)));
    $this->setWidget('qty_menor', new sfWidgetFormFilterInput(array('with_empty' => false)));

    $this->widgetSchema['cod']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['activo']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['empresa_id']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['producto']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['serial']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['deposito_id']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['created_by']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['updated_by']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['destacado']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['tipo']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['qty_mayor']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['qty_menor']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['vencido']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['proximo_vencer']->setAttributes(array('class' => 'form-control'));

    $this->setWidget('created_at', new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'to_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'with_empty' => false)));
    $this->setWidget('updated_at', new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'to_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'with_empty' => false)));

    $this->validatorSchema ['creado_por'] = new sfValidatorPass();
    $this->validatorSchema ['updated_por'] = new sfValidatorPass();
    $this->validatorSchema ['empresa_id'] = new sfValidatorPass();
    $this->validatorSchema ['producto'] = new sfValidatorPass();
    $this->validatorSchema ['serial'] = new sfValidatorPass();
    $this->validatorSchema ['unidad_id'] = new sfValidatorPass();
    $this->validatorSchema ['categoria_id'] = new sfValidatorPass();
    $this->validatorSchema ['compuesto_id'] = new sfValidatorPass();
    $this->validatorSchema ['laboratorio_id'] = new sfValidatorPass();
    $this->validatorSchema ['destacado'] = new sfValidatorPass();
    $this->validatorSchema ['tipo'] = new sfValidatorPass();
    $this->validatorSchema ['cod'] = new sfValidatorPass();
    $this->validatorSchema ['qty_mayor'] = new sfValidatorPass();
    $this->validatorSchema ['qty_menor'] = new sfValidatorPass();
    $this->validatorSchema ['vencido'] = new sfValidatorPass();
    $this->validatorSchema ['proximo_vencer'] = new sfValidatorPass();
  }

  public function getFields() {
    $fields = parent::getFields();
    $fields['creado_por'] = 'Text';
    $fields['updated_por'] = 'Text';
    $fields['empresa_id'] = 'Text';
    $fields['producto'] = 'Text';
    $fields['serial'] = 'Text';
    $fields['destacado'] = 'Text';
    $fields['tipo'] = 'Text';
    $fields['qty_mayor'] = 'Text';
    $fields['qty_menor'] = 'Text';
    $fields['vencido'] = 'Text';
    $fields['proximo_vencer'] = 'Text';
    return $fields;
  }
  public function addQtyMayorColumnQuery($query, $field, $value) {
    $valor=implode($value);
    if(strlen($valor)>0) {
      return $query->andwhere("CAST(cantidad AS INTEGER) >= $valor");
    }
  }
  public function addQtyMenorColumnQuery($query, $field, $value) {
    $valor=implode($value);
    if(strlen($valor)>0) {
      return $query->andwhere("CAST(cantidad AS INTEGER) <= $valor");
    }
  }
  public function addVencidoColumnQuery($query, $field, $value) {
    if(strlen($value)>0) {
      $fecha=date("Y-m-d");
      if($value==1) {
        return $query->andwhere("idet.cantidad > 0 AND idet.fecha_venc <= ? ",$fecha);
      } else {
        return $query->andwhere("idet.cantidad > 0 AND idet.fecha_venc > ? ",$fecha);
      }
    }
  }
  public function addProximoVencerColumnQuery($query, $field, $value) {
    $valor=implode($value);
    if(strlen($valor)>0) {
      $fecha=date('Y-m-d');
      return $query->andwhere("idet.cantidad > 0 AND idet.fecha_venc BETWEEN '$fecha' AND '$valor' ");
    }
  }
  public function addCodColumnQuery($query, $field, $value) {
    $valor=implode($value);
    if(strlen($valor)>1) {
      return $query->andwhere("id LIKE '%".$valor."%'");
    }
  }
  public function addTipoColumnQuery($query, $field, $value) {
    if(!empty($value)) {
      $rootAlias = $query->getRootAlias();
      return $query->andwhere('p.tipo = ?', "$value");
    }
  }
  public function addDestacadoColumnQuery($query, $field, $value) {
    return $query->andwhere("p.destacado = ?", $value);
  }
  public function addCategoriaIdColumnQuery($query, $field, $value) {
    $rootAlias = $query->getRootAlias();
    if (!is_array($value)) {
      $value = array($value);
    }
    if (!count($value)) {
      return;
    }

    $word="";
    if(!empty($value)) {
      $i=0;
      foreach($value as $val) {
        if($i==0) {
          $word=$val;
        } else {
          $word=$word."|".$val;
        }
      }
      //echo $word; die();
    }

    return $query->andWhere("pc.nombre REGEXP '$word'");    
  }
  public function addLaboratorioIdColumnQuery($query, $field, $value) {
    $rootAlias = $query->getRootAlias();
    if (!is_array($value)) {
      $value = array($value);
    }
    if (!count($value)) {
      return;
    }
    return $query->andWhereIn('p.laboratorio_id', $value);
  }
  public function addUnidadIdColumnQuery($query, $field, $value) {
    $rootAlias = $query->getRootAlias();
    if (!is_array($value)) {
      $value = array($value);
    }
    if (!count($value)) {
      return;
    }
    return $query->andWhereIn('p.unidad_id', $value);
  }
  public function addCompuestoIdColumnQuery($query, $field, $value) {
    $rootAlias = $query->getRootAlias();
    if (!is_array($value)) {
      $value = array($value);
    }
    if (!count($value)) {
      return;
    }
    return $query->andWhereIn('pcomp.compuesto_id', $value);
  }
  public function addProductoColumnQuery($query, $field, $value) {
    $rootAlias = $query->getRootAlias();
    if (!is_array($value)) {
      $value = array($value);
    }
    if (!count($value)) {
      return;
    }
    return $query->andWhereIn('p.id', $value);    
  }
  public function addSerialColumnQuery($query, $field, $value) {
    $valor=implode($value);
    if(strlen($valor)>1) {
      return $query->andwhere("p.serial LIKE '%$valor%'");
    }
  }
  public function addCreadoPorColumnQuery($query, $field, $value) {
    $rootAlias = $query->getRootAlias();
    if (!is_array($value)) {
      $value = array($value);
    }
    if (!count($value)) {
      return;
    }
    return $query->andWhereIn($rootAlias.'.created_by', $value);
  }
  public function addUpdatedPorColumnQuery($query, $field, $value) {
    $rootAlias = $query->getRootAlias();
    if (!is_array($value)) {
      $value = array($value);
    }
    if (!count($value)) {
      return;
    }
    return $query->andWhereIn($rootAlias.'.updated_by', $value);
  }
  public function addEmpresaIdColumnQuery($query, $field, $value) {
    $rootAlias = $query->getRootAlias();
    if (!is_array($value)) {
      $value = array($value);
    }
    if (!count($value)) {
      return;
    }
    return $query->andWhereIn($rootAlias.'.empresa_id', $value);
  }
}
