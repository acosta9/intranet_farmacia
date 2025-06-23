<?php

/**
 * InvEntrada filter form.
 *
 * @package    ired.localhost
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class InvEntradaFormFilter extends BaseInvEntradaFormFilter
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

    $choices_producto = array();
    /*$results = Doctrine_Query::create()
      ->select('p.nombre, p.serial')
      ->from('Producto p')
      ->orderBy('p.nombre ASC')
      ->execute();
    foreach ($results as $result) {
      $choices_producto[$result->getId()]=$result["nombre"]."[".$result["serial"]."]";
    }*/

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
    $choices_cat[""]="";
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

    $this->setWidget('anulado', new sfWidgetFormChoice(array('choices' => array('' => '', 0 => 'PROCESADO', 1 => 'ANULADO'))));
    $this->setWidget('empresa_id', new sfWidgetFormSelect(array('choices' =>  $choices_emp, 'multiple' => 'multiple')));
    $this->setWidget('creado_por', new sfWidgetFormSelect(array('choices' =>  $choices_user, 'multiple' => 'multiple')));
    $this->setWidget('updated_por', new sfWidgetFormSelect(array('choices' =>  $choices_user, 'multiple' => 'multiple')));
    $this->setWidget('producto', new sfWidgetFormSelect(array('choices' =>  $choices_producto, 'multiple' => 'multiple')));
    $this->setWidget('unidad_id', new sfWidgetFormSelect(array('choices' =>  $choices_unidad, 'multiple' => 'multiple')));
    $this->setWidget('categoria_id', new sfWidgetFormSelect(array('choices' =>  $choices_cat)));
    $this->setWidget('compuesto_id', new sfWidgetFormSelect(array('choices' =>  $choices_compuesto, 'multiple' => 'multiple')));
    $this->setWidget('laboratorio_id', new sfWidgetFormSelect(array('choices' =>  $choices_lab, 'multiple' => 'multiple')));
    $this->setWidget('tipo', new sfWidgetFormChoice(array('choices' => array('' => '', 0 => 'NACIONAL', 1 => 'IMPORTADO'))));

    $this->setWidget('cod', new sfWidgetFormFilterInput(array('with_empty' => false)));
    $this->setWidget('descripcion', new sfWidgetFormFilterInput(array('with_empty' => false)));
    //$this->setWidget('producto', new sfWidgetFormFilterInput(array('with_empty' => false)));

    $this->widgetSchema['anulado']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['empresa_id']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['deposito_id']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['created_by']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['updated_by']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['cod']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['producto']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['descripcion']->setAttributes(array('class' => 'form-control'));

    $this->setWidget('created_at', new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'to_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'with_empty' => false)));
    $this->setWidget('updated_at', new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'to_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'with_empty' => false)));

    $this->validatorSchema ['creado_por'] = new sfValidatorPass();
    $this->validatorSchema ['updated_por'] = new sfValidatorPass();
    $this->validatorSchema ['empresa_id'] = new sfValidatorPass();
    $this->validatorSchema ['cod'] = new sfValidatorPass();
    $this->validatorSchema ['producto'] = new sfValidatorPass();
    $this->validatorSchema ['unidad_id'] = new sfValidatorPass();
    $this->validatorSchema ['categoria_id'] = new sfValidatorPass();
    $this->validatorSchema ['compuesto_id'] = new sfValidatorPass();
    $this->validatorSchema ['laboratorio_id'] = new sfValidatorPass();
    $this->validatorSchema ['tipo'] = new sfValidatorPass();
  }

  public function getFields() {
    $fields = parent::getFields();
    $fields['creado_por'] = 'Text';
    $fields['updated_por'] = 'Text';
    $fields['empresa_id'] = 'Text';
    $fields['cod'] = 'Text';
    $fields['producto'] = 'Text';
    $fields['unidad_id'] = 'Text';
    $fields['categoria_id'] = 'Text';
    $fields['compuesto_id'] = 'Text';
    $fields['laboratorio_id'] = 'Text';
    $fields['tipo'] = 'Text';
    return $fields;
  }
  public function addTipoColumnQuery($query, $field, $value) {
    if(!empty($value)) {
      $rootAlias = $query->getRootAlias();
      return $query->andwhere('p.tipo = ?', "$value");
    }
  }
  public function addProductoColumnQuery($query, $field, $value) {
    $rootAlias = $query->getRootAlias();
    if (!is_array($value)) {
      $value = array($value);
    }
    if (!count($value)) {
      return;
    }
    return $query->andWhereIn('i.producto_id', $value);    
  }
  public function addCategoriaIdColumnQuery($query, $field, $value) {
    $rootAlias = $query->getRootAlias();
    return $query->andWhere("pc.nombre LIKE '%".$value."%'");    
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
  public function addCodColumnQuery($query, $field, $value) {
    $valor=implode($value);
    if(strlen($valor)>1) {
      //echo $valor; die();
      return $query->andwhere("id LIKE '%".$valor."%'");
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
