<?php

namespace Drupal\krocodile_manual\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Manual kpi entities.
 *
 * @ingroup krocodile_manual
 */
interface ManualKPIInterface extends  ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Manual kpi name.
   *
   * @return string
   *   Name of the Manual kpi.
   */
  public function getName();

  /**
   * Sets the Manual kpi name.
   *
   * @param string $name
   *   The Manual kpi name.
   *
   * @return \Drupal\krocodile_manual\Entity\ManualKPIInterface
   *   The called Manual kpi entity.
   */
  public function setName($name);

  /**
   * Gets the Manual kpi creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Manual kpi.
   */
  public function getCreatedTime();

  /**
   * Sets the Manual kpi creation timestamp.
   *
   * @param int $timestamp
   *   The Manual kpi creation timestamp.
   *
   * @return \Drupal\krocodile_manual\Entity\ManualKPIInterface
   *   The called Manual kpi entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Manual kpi published status indicator.
   *
   * Unpublished Manual kpi are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Manual kpi is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Manual kpi.
   *
   * @param bool $published
   *   TRUE to set this Manual kpi to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\krocodile_manual\Entity\ManualKPIInterface
   *   The called Manual kpi entity.
   */
  public function setPublished($published);

}
