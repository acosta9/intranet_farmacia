<?php

/**
 * sfGuardUser filter form base class.
 *
 * @package    ired.localhost
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasesfGuardUserFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'full_name'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'email_address'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'clave'            => new sfWidgetFormFilterInput(),
      'username'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'cliente_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Cliente'), 'add_empty' => true)),
      'url_imagen'       => new sfWidgetFormFilterInput(),
      'cargo'            => new sfWidgetFormFilterInput(),
      'algorithm'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'salt'             => new sfWidgetFormFilterInput(),
      'password'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_active'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_super_admin'   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'last_login'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'created_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'groups_list'      => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardGroup')),
      'permissions_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardPermission')),
      'empresa_list'     => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Empresa')),
      'caja_list'        => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Caja')),
    ));

    $this->setValidators(array(
      'full_name'        => new sfValidatorPass(array('required' => false)),
      'email_address'    => new sfValidatorPass(array('required' => false)),
      'clave'            => new sfValidatorPass(array('required' => false)),
      'username'         => new sfValidatorPass(array('required' => false)),
      'cliente_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Cliente'), 'column' => 'id')),
      'url_imagen'       => new sfValidatorPass(array('required' => false)),
      'cargo'            => new sfValidatorPass(array('required' => false)),
      'algorithm'        => new sfValidatorPass(array('required' => false)),
      'salt'             => new sfValidatorPass(array('required' => false)),
      'password'         => new sfValidatorPass(array('required' => false)),
      'is_active'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_super_admin'   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'last_login'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'groups_list'      => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardGroup', 'required' => false)),
      'permissions_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardPermission', 'required' => false)),
      'empresa_list'     => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Empresa', 'required' => false)),
      'caja_list'        => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Caja', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('sf_guard_user_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addGroupsListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.sfGuardUserGroup sfGuardUserGroup')
      ->andWhereIn('sfGuardUserGroup.group_id', $values)
    ;
  }

  public function addPermissionsListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.sfGuardUserPermission sfGuardUserPermission')
      ->andWhereIn('sfGuardUserPermission.permission_id', $values)
    ;
  }

  public function addEmpresaListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.EmpresaUser EmpresaUser')
      ->andWhereIn('EmpresaUser.empresa_id', $values)
    ;
  }

  public function addCajaListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.CajaUser CajaUser')
      ->andWhereIn('CajaUser.caja_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'sfGuardUser';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'full_name'        => 'Text',
      'email_address'    => 'Text',
      'clave'            => 'Text',
      'username'         => 'Text',
      'cliente_id'       => 'ForeignKey',
      'url_imagen'       => 'Text',
      'cargo'            => 'Text',
      'algorithm'        => 'Text',
      'salt'             => 'Text',
      'password'         => 'Text',
      'is_active'        => 'Boolean',
      'is_super_admin'   => 'Boolean',
      'last_login'       => 'Date',
      'created_at'       => 'Date',
      'updated_at'       => 'Date',
      'groups_list'      => 'ManyKey',
      'permissions_list' => 'ManyKey',
      'empresa_list'     => 'ManyKey',
      'caja_list'        => 'ManyKey',
    );
  }
}
