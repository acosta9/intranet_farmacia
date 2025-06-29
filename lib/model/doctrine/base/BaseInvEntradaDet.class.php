<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('InvEntradaDet', 'doctrine');

/**
 * BaseInvEntradaDet
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $inv_entrada_id
 * @property string $qty
 * @property string $price_unit
 * @property string $price_tot
 * @property integer $inventario_id
 * @property date $fecha_venc
 * @property string $lote
 * @property InvEntrada $InvEntrada
 * @property Inventario $Inventario
 * 
 * @method integer       getId()             Returns the current record's "id" value
 * @method integer       getInvEntradaId()   Returns the current record's "inv_entrada_id" value
 * @method string        getQty()            Returns the current record's "qty" value
 * @method string        getPriceUnit()      Returns the current record's "price_unit" value
 * @method string        getPriceTot()       Returns the current record's "price_tot" value
 * @method integer       getInventarioId()   Returns the current record's "inventario_id" value
 * @method date          getFechaVenc()      Returns the current record's "fecha_venc" value
 * @method string        getLote()           Returns the current record's "lote" value
 * @method InvEntrada    getInvEntrada()     Returns the current record's "InvEntrada" value
 * @method Inventario    getInventario()     Returns the current record's "Inventario" value
 * @method InvEntradaDet setId()             Sets the current record's "id" value
 * @method InvEntradaDet setInvEntradaId()   Sets the current record's "inv_entrada_id" value
 * @method InvEntradaDet setQty()            Sets the current record's "qty" value
 * @method InvEntradaDet setPriceUnit()      Sets the current record's "price_unit" value
 * @method InvEntradaDet setPriceTot()       Sets the current record's "price_tot" value
 * @method InvEntradaDet setInventarioId()   Sets the current record's "inventario_id" value
 * @method InvEntradaDet setFechaVenc()      Sets the current record's "fecha_venc" value
 * @method InvEntradaDet setLote()           Sets the current record's "lote" value
 * @method InvEntradaDet setInvEntrada()     Sets the current record's "InvEntrada" value
 * @method InvEntradaDet setInventario()     Sets the current record's "Inventario" value
 * 
 * @package    ired.localhost
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseInvEntradaDet extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('inv_entrada_det');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'unsigned' => true,
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('inv_entrada_id', 'integer', 4, array(
             'type' => 'integer',
             'unsigned' => true,
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('qty', 'string', 20, array(
             'type' => 'string',
             'notnull' => true,
             'default' => 1,
             'length' => 20,
             ));
        $this->hasColumn('price_unit', 'string', 20, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 20,
             ));
        $this->hasColumn('price_tot', 'string', 20, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 20,
             ));
        $this->hasColumn('inventario_id', 'integer', 4, array(
             'type' => 'integer',
             'unsigned' => true,
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('fecha_venc', 'date', 25, array(
             'type' => 'date',
             'notnull' => true,
             'length' => 25,
             ));
        $this->hasColumn('lote', 'string', 200, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 200,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('InvEntrada', array(
             'local' => 'inv_entrada_id',
             'foreign' => 'id'));

        $this->hasOne('Inventario', array(
             'local' => 'inventario_id',
             'foreign' => 'id'));
    }
}