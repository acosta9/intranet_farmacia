<?php

/**
 * @author     Artur Rozek
 * @version    1.0.0
 */
class sfWidgetFormDateJQueryUI2 extends sfWidgetForm
{
  /**
   * Configures the current widget.
   *
   * Available options:
   *
   * @param string   culture           Sets culture for the widget
   * @param boolean  change_month      If date chooser attached to widget has month select dropdown, defaults to false
   * @param boolean  change_year       If date chooser attached to widget has year select dropdown, defaults to false
   * @param integer  number_of_months  Number of months visible in date chooser, defaults to 1
   * @param boolean  show_button_panel If date chooser shows panel with 'today' and 'done' buttons, defaults to false
   * @param string   theme             css theme for jquery ui interface, defaults to '/sfJQueryUIPlugin/css/ui-lightness/jquery-ui.css'
   *
   * @see sfWidgetForm
   */
  protected function configure($options = array(), $attributes = array())
  {

    if(sfContext::hasInstance())
     $this->addOption('culture', sfContext::getInstance()->getUser()->getCulture());
    else
     $this->addOption('culture', "en");
    $this->addOption('change_month',  false);
    $this->addOption('change_year',  false);
    $this->addOption('number_of_months', 1);
    $this->addOption('yearRange', "1930:2020");
    $this->addOption('show_button_panel',  false);


    parent::configure($options, $attributes);
  }

  /**
   * @param  string $name        The element name
   * @param  string $value       The date displayed in this widget
   * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
   * @param  array  $errors      An array of errors for the field
   *
   * @return string An HTML tag string
   *
   * @see sfWidgetForm
   */
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $attributes = $this->getAttributes();

    $input = new sfWidgetFormInput(array(), array('class' => 'form-control datetime', 'readonly' => 'readonly'));

    $html = $input->render($name, $value);

    $id = $input->generateId($name);
    $culture = $this->getOption('culture');
    $cm = $this->getOption("change_month") ? "true" : "false";
    $cy = $this->getOption("change_year") ? "true" : "false";
    $nom = $this->getOption("number_of_months");
    $sbp = $this->getOption("show_button_panel") ? "true" : "false";
    $fecha = "'".$this->getOption("yearRange")."'";
    if ($culture!='en')
    {

    }
    else
    {
    
    }

    return $html;
  }

  /*
   *
   * Gets the stylesheet paths associated with the widget.
   *
   * @return array An array of stylesheet paths
   */
  public function getStylesheets()
  {
    $theme = $this->getOption('theme');
    return array($theme => 'screen');
  }

  /**
   * Gets the JavaScript paths associated with the widget.
   *
   * @return array An array of JavaScript paths
   */
  public function getJavaScripts()
  {
    //check if jquery is loaded
    $js = array();
    return $js;
  }

}
