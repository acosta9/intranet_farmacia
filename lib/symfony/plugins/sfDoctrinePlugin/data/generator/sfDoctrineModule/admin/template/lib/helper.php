[?php

/**
 * <?php echo $this->getModuleName() ?> module configuration.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage <?php echo $this->getModuleName()."\n" ?>
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: helper.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class Base<?php echo ucfirst($this->getModuleName()) ?>GeneratorHelper extends sfModelGeneratorHelper
{
  public function getUrlForAction($action)
  {
    return 'list' == $action ? '<?php echo $this->params['route_prefix'] ?>' : '<?php echo $this->params['route_prefix'] ?>_'.$action;
  }
  public function linkToSaveAndAdd($object, $params)
  {
    if (!$object->isNew())
    {
      return '';
    }

    return '<input type="submit" id="graybutton" class="btn btn-primary btn-block text-uppercase btn-align" value="'.__($params['label'], array(), 'sf_admin').'" name="_save_and_add" />';
  }
  public function linkToHomepage($object, $params)
  {
  return '<li>'.link_to('<i class="fa fa-dashboard"></i>'.__($params['label'], array(), 'sf_admin'), url_for('homepage'), $object).'</li>';
  }
  public function linkToDeleteList($object, $params)
  {
    if ($object->isNew())
    {
      return '';
    }
	$params['confirm']="¿estas seguro 3?";
	return '<li class="sf_admin_action_delete">'.link_to(__($params['label'], array(), 'sf_admin'), $this->getUrlForAction('delete'), $object, array('method' => 'delete', 'confirm' => !empty($params['confirm']) ? __($params['confirm'], array(), 'sf_admin') : $params['confirm'])).'</li>';
  }
public function linkToDelete($object, $params)
  {
    if ($object->isNew())
    {
      return '';
    }
    $params['confirm']="¿estas seguro?";

    return link_to(__('<i class="fas fa-trash-alt mr-2"></i>'.$params['label'], array(), 'sf_admin'), $this->getUrlForAction('delete'), $object, array('method' => 'delete', 'confirm' => !empty($params['confirm']) ? __($params['confirm'], array(), 'sf_admin') : $params['confirm'], 'class' => 'btn btn-danger text-uppercase btn-align'));
  }
  public function linkToShow($object, $params)
  {

    return link_to(__('<i class="fas fa-eye mr-2"></i>'.$params['label'], array(), 'sf_admin'), $this->getUrlForAction('show'), $object, array('class' => 'btn btn-default text-uppercase btn-align'));
  }
  public function linkToNew($params)
  {
    return link_to(__('<i class="fas fa-folder-plus mr-2"></i>'.$params['label'], array(), 'sf_admin'), '@'.$this->getUrlForAction('new'), array('class' => 'btn btn-default text-uppercase btn-align'));
  }
  public function linkToList($params)
  {
    return link_to(__('<i class="fa fa-bars mr-2"></i>'.$params['label'], array(), 'sf_admin'), '@'.$this->getUrlForAction('list'), array('class' => 'btn btn-default btn-block text-uppercase btn-align'));
  }

  public function linkToEdit($object, $params)
  {
    
    return link_to(__('<i class="fa fa-edit"></i>'.$params['label'], array(), 'sf_admin'), $this->getUrlForAction('edit'), $object, array('class' => 'btn btn-default text-uppercase btn-align'));
  }

   public function linkToSave($object, $params)
  {
    return '<button type="submit" class="btn-guardar btn btn-primary btn-block text-uppercase btn-align"><i class="fa fa-save mr-2"></i>'.__($params['label'], array(), 'sf_admin').'</button>';
  }
}
