<?php

namespace Drupal\krocodile_manual\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Manual kpi entities.
 */
class ManualKPIViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.

    return $data;
  }

}
