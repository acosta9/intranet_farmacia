<?php

/**
 * FacturaGastosTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class FacturaGastosTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object FacturaGastosTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('FacturaGastos');
    }
    public static function doSelectJoinOtros($query)
    {
      $rootAlias = $query->getRootAlias();
      return $query->select($rootAlias.'.*, LPAD(ncontrol, 6, 0) as ncontrol, CAST(ncontrol AS UNSIGNED) as ninteger, e.nombre as ename, e.acronimo as emin, g.nombre as gnombre, g.descripcion as gdescripcion')
        ->leftJoin($rootAlias . '.Empresa e')
        ->leftJoin($rootAlias . '.GastosTipo g');
    }
}