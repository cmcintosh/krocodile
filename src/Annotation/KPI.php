<?php

namespace Drupal\krocodile\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
* Defines the KPI type Plugin annotation object.
*
* Plugin namespace: Plugin\Krocodile\KPI
* @see plugin_api
*
* @Annotation
*/
class KPI extends Plugin {

  /**
  * Id for the plugin
  */
  public $id;

  /**
  * Label for the KPI
  */
  public $label;

  /**
  * Form controllers
  */
  public $form;
  
}
