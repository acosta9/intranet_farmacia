<?php

/**
 * Producto filter form.
 *
 * @package    ired.localhost
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ProductoFormFilter extends BaseProductoFormFilter
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

    $choices_cat = array();
    $results = Doctrine_Query::create()
      ->select('c.nombre, c.id')
      ->from('ProdCategoria c')
      ->orderBy('c.nombre ASC')
      ->execute();
    $choices_cat[""]="";
    foreach ($results as $result) {
        $choices_cat[$result->getNombre()]=$result["nombre"];
    }

    $choices_tags = array();
    $results = Doctrine_Query::create()
      ->select('p.tags')
      ->from('Producto p')
      ->where('p.tags IS NOT NULL')
      ->execute();
    foreach ($results as $result) {
      $words=explode(";",$result["tags"]);
      foreach ($words as $word) {
        $choices_tags[$word]=$word;
      }
    }

    $choices_empty = array();

    $this->setWidget('tag_back', new sfWidgetFormSelect(array('choices' =>  $choices_tags, 'multiple' => 'multiple')));
    $this->setWidget('creado_por', new sfWidgetFormSelect(array('choices' =>  $choices_user, 'multiple' => 'multiple')));
    $this->setWidget('updated_por', new sfWidgetFormSelect(array('choices' =>  $choices_user, 'multiple' => 'multiple')));
    $this->setWidget('catname', new sfWidgetFormSelect(array('choices' =>  $choices_cat)));
    $this->setWidget('laboratorio_id', new sfWidgetFormSelect(array('choices' =>  $choices_empty, 'multiple' => 'multiple')));
    $this->setWidget('compuesto_id', new sfWidgetFormSelect(array('choices' =>  $choices_empty, 'multiple' => 'multiple')));

    $this->setWidget('categoria_id', new sfWidgetFormDoctrineChoice(array('multiple' => 'multiple', 'model' => $this->getRelatedModelName('ProdCategoria'), 'add_empty' => false)));
    $this->setWidget('unidad_id', new sfWidgetFormDoctrineChoice(array('multiple' => 'multiple', 'model' => $this->getRelatedModelName('ProdUnidad'), 'add_empty' => false)));

    $this->setWidget('destacado', new sfWidgetFormChoice(array('choices' => array('' => '', 1 => 'SI', 0 => 'NO'))));
    $this->setWidget('activo', new sfWidgetFormChoice(array('choices' => array('' => '', 1 => 'HABILITADO', 0 => 'DES-HABILITADO'))));
    $this->setWidget('tipo', new sfWidgetFormChoice(array('choices' => array('' => '', 0 => 'NACIONAL', 1 => 'IMPORTADO'))));

    $this->widgetSchema['destacado']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['nombre']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['serial']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['codigo']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['tipo']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['activo']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['unidad_id']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['laboratorio_id']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['compuesto_id']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['categoria_id']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['catname']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['created_by']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['updated_by']->setAttributes(array('class' => 'form-control'));

    $this->setWidget('created_at', new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'to_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'with_empty' => false)));
    $this->setWidget('updated_at', new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'to_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'with_empty' => false)));

    $this->validatorSchema ['laboratorio_id'] = new sfValidatorPass();
    $this->validatorSchema ['categoria_id'] = new sfValidatorPass();
    $this->validatorSchema ['unidad_id'] = new sfValidatorPass();
    $this->validatorSchema ['creado_por'] = new sfValidatorPass();
    $this->validatorSchema ['updated_por'] = new sfValidatorPass();
    $this->validatorSchema ['catname'] = new sfValidatorPass();
    $this->validatorSchema ['busqueda'] = new sfValidatorPass();
    $this->validatorSchema ['compuesto_id'] = new sfValidatorPass();
    $this->validatorSchema ['tag'] = new sfValidatorPass();
    $this->validatorSchema ['tag_back'] = new sfValidatorPass();
  }
  public function getFields() {
    $fields = parent::getFields();
    $fields['laboratorio_id'] = 'Text';
    $fields['categoria_id'] = 'Text';
    $fields['unidad_id'] = 'Text';
    $fields['creado_por'] = 'Text';
    $fields['updated_por'] = 'Text';
    $fields['catname'] = 'Text';
    $fields['busqueda'] = 'Text';
    $fields['tag'] = 'Text';
    $fields['tag_back'] = 'Text';
    $fields['compuesto_id'] = 'Text';
    return $fields;
  }
  public function addTagColumnQuery($query, $field, $value) {
    $rootAlias = $query->getRootAlias();
    return $query->andwhere($rootAlias.'.tags REGEXP ?', "$value");
  }
  public function addTagBackColumnQuery($query, $field, $value) {
    if(!empty($value)) {
      $valor= implode("|",$value);
      $rootAlias = $query->getRootAlias();
      return $query->andwhere($rootAlias.'.tags REGEXP ?', "$valor");
    }
  }
  public function addBusquedaColumnQuery($query, $field, $value) {
    $rootAlias = $query->getRootAlias();
    return $query->AndWhere("nombre LIKE '%".$value."%'")->orWhere("pc.nombre LIKE '%".$value."%'");
  }
  public function addCatnameColumnQuery($query, $field, $value) {
    $rootAlias = $query->getRootAlias();
    return $query->AndWhere("pc.nombre LIKE '%".$value."%'");
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
  public function addLaboratorioIdColumnQuery($query, $field, $value) {
    $rootAlias = $query->getRootAlias();
    if (!is_array($value)) {
      $value = array($value);
    }
    if (!count($value)) {
      return;
    }
    return $query->andWhereIn($rootAlias.'.laboratorio_id', $value);
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
  public function addCategoriaIdColumnQuery($query, $field, $value) {
    $rootAlias = $query->getRootAlias();
    if (!is_array($value)) {
      $value = array($value);
    }
    if (!count($value)) {
      return;
    }
    //return $query->andWhereIn($rootAlias.'.categoria_id', $value);
  }
  public function addUnidadIdColumnQuery($query, $field, $value) {
    $rootAlias = $query->getRootAlias();
    if (!is_array($value)) {
      $value = array($value);
    }
    if (!count($value)) {
      return;
    }
    return $query->andWhereIn($rootAlias.'.unidad_id', $value);
  }
}
