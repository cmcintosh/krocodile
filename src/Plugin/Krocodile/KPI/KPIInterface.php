<?php

/**
* @file contains the interface used to create the plugins.
*/
namespace Drupal\krocodile\Plugin\Krocodile\KPI;

use Drupal\user\UserInterface;

interface KPIInterface {

  /**
  * Execute the KPI, this is used to connect to Third-Party APIs
  */
  public function execute(UserInterface $account);

  /**
  * Return the KPI for the given user.
  * @return array for KPIs provided by this plugin
  */
  public function get(UserInterface $account, $options = []);

  /**
  * Returns the info for this KPI plugin,
  * used mostly on the Overview page, and user page for info.
  */
  public function info();

  /**
  * Render Report. Used to return a renderable array for this KPI
  * @return array of renderable items.
  */
  public function render(UserInterface $account, $options = []);

  /**
  * Render Report. Used to return a renderable array for this KPI
  * @return array of renderable items.
  */
  public function total(UserInterface $account, $type = FALSE, $options = []);
}
