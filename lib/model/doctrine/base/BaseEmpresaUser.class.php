<?php

/**
 * BaseEmpresaUser
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $empresa_id
 * @property integer $user_id
 * @property Empresa $Empresa
 * @property sfGuardUser $User
 * 
 * @method integer     getEmpresaId()  Returns the current record's "empresa_id" value
 * @method integer     getUserId()     Returns the current record's "user_id" value
 * @method Empresa     getEmpresa()    Returns the current record's "Empresa" value
 * @method sfGuardUser getUser()       Returns the current record's "User" value
 * @method EmpresaUser setEmpresaId()  Sets the current record's "empresa_id" value
 * @method EmpresaUser setUserId()     Sets the current record's "user_id" value
 * @method EmpresaUser setEmpresa()    Sets the current record's "Empresa" value
 * @method EmpresaUser setUser()       Sets the current record's "User" value
 * 
 * @package    ired.localhost
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseEmpresaUser extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('empresa_user');
        $this->hasColumn('empresa_id', 'integer', 4, array(
             'type' => 'integer',
             'unsigned' => true,
             'primary' => true,
             'length' => 4,
             ));
        $this->hasColumn('user_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));

        $this->option('symfony', array(
             'form' => false,
             'filter' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Empresa', array(
             'local' => 'empresa_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('sfGuardUser as User', array(
             'local' => 'user_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable(array(
             ));
        $this->actAs($timestampable0);
    }
}