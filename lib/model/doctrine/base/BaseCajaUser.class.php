<?php

/**
 * BaseCajaUser
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $caja_id
 * @property integer $user_id
 * @property Caja $Caja
 * @property sfGuardUser $User
 * 
 * @method integer     getCajaId()  Returns the current record's "caja_id" value
 * @method integer     getUserId()  Returns the current record's "user_id" value
 * @method Caja        getCaja()    Returns the current record's "Caja" value
 * @method sfGuardUser getUser()    Returns the current record's "User" value
 * @method CajaUser    setCajaId()  Sets the current record's "caja_id" value
 * @method CajaUser    setUserId()  Sets the current record's "user_id" value
 * @method CajaUser    setCaja()    Sets the current record's "Caja" value
 * @method CajaUser    setUser()    Sets the current record's "User" value
 * 
 * @package    ired.localhost
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCajaUser extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('caja_user');
        $this->hasColumn('caja_id', 'integer', 4, array(
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
        $this->hasOne('Caja', array(
             'local' => 'caja_id',
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