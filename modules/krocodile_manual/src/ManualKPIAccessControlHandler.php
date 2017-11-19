<?php

namespace Drupal\krocodile_manual;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Manual kpi entity.
 *
 * @see \Drupal\krocodile_manual\Entity\ManualKPI.
 */
class ManualKPIAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\krocodile_manual\Entity\ManualKPIInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished manual kpi entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published manual kpi entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit manual kpi entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete manual kpi entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add manual kpi entities');
  }

}
