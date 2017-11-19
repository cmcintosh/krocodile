<?php

namespace Drupal\krocodile_manual;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Manual kpi entities.
 *
 * @ingroup krocodile_manual
 */
class ManualKPIListBuilder extends EntityListBuilder {


  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Manual kpi ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\krocodile_manual\Entity\ManualKPI */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.manual_kpi.edit_form',
      ['manual_kpi' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
