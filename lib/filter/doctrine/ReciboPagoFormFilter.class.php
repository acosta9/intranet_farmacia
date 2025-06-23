<?php

/**
 * ReciboPago filter form.
 *
 * @package    ired.localhost
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ReciboPagoFormFilter extends BaseReciboPagoFormFilter
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
      ->select('e.nombre')
      ->from('Empresa e')
      ->orderBy('e.nombre ASC')
      ->execute();
    foreach ($results as $result) {
        $choices_emp[$result->getId()]=$result["nombre"];
    }

    $this->setWidget('ncontrol', new sfWidgetFormFilterInput(array('with_empty' => false)));
    $this->setWidget('num_recibo', new sfWidgetFormFilterInput(array('with_empty' => false)));
    $this->setWidget('cliente', new sfWidgetFormFilterInput(array('with_empty' => false)));
    $this->setWidget('creado_por', new sfWidgetFormSelect(array('choices' =>  $choices_user, 'multiple' => 'multiple')));
    $this->setWidget('empresa_id', new sfWidgetFormSelect(array('choices' =>  $choices_emp, 'multiple' => 'multiple')));
    $this->setWidget('coin', new sfWidgetFormChoice(array('choices' => array('' => '', 1 => 'BOLIVARES', 2 => 'DOLARES'))));
    $this->setWidget('anulado', new sfWidgetFormChoice(array('choices' => array('' => '', 1 => 'ANULADO', 0 => 'PROCESADO'))));

    $this->widgetSchema['cliente']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['coin']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['ncontrol']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['num_recibo']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['forma_pago_id']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['empresa_id']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['creado_por']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['anulado']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['fecha']->setAttributes(array('class' => 'form-control'));

    $this->setWidget('fecha', new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'to_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'with_empty' => false)));
    $this->setWidget('created_at', new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'to_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'with_empty' => false)));
    $this->setWidget('updated_at', new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'to_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'with_empty' => false)));

    $this->validatorSchema ['coin'] = new sfValidatorPass();
    $this->validatorSchema ['creado_por'] = new sfValidatorPass();
    $this->validatorSchema ['empresa_id'] = new sfValidatorPass();
    $this->validatorSchema ['cliente'] = new sfValidatorPass();
  }
  public function getFields() {
    $fields = parent::getFields();
    $fields['coin'] = 'Text';
    $fields['creado_por'] = 'Text';
    $fields['empresa_id'] = 'Text';
    $fields['cliente'] = 'Text';
    return $fields;
  }
  public function addClienteColumnQuery($query, $field, $value) {
    $valor=implode($value);
    if(strlen($valor)>1) {
      return $query->andwhere("c.full_name LIKE '%$valor%'");
    }
  }
  public function addCoinColumnQuery($query, $field, $value) {
      $rootAlias = $query->getRootAlias();
      return $query->andwhere($rootAlias.'.moneda = ?', "$value");
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
