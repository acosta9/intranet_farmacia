<?php

/**
 * sfGuardGroup filter form.
 *
 * @package    base.localhost
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrinePluginFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfGuardGroupFormFilter extends PluginsfGuardGroupFormFilter
{
  public function configure()
  {
    $this->setWidget('name', new sfWidgetFormFilterInput(array('with_empty' => false)));
    $this->setWidget('description', new sfWidgetFormFilterInput(array('with_empty' => false)));
    $this->setWidget('created_at', new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'to_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'with_empty' => false)));
    $this->setWidget('updated_at', new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'to_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'with_empty' => false)));

    $this->widgetSchema['name']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['description']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['permissions_list']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['users_list']->setAttributes(array('class' => 'form-control'));
  }
}
