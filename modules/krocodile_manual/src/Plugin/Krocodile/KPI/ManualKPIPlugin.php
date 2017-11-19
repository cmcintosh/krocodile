<?php

namespace Drupal\krocodile_manual\Plugin\Krocodile\KPI;

use Drupal\krocodile_manual\Entity\ManualKPI;
use Drupal\krocodile_manual\Entity\ManualKPIType;
use Drupal\krocodile\Plugin\Krocodile\KPI\KPIInterface;
use Drupal\user\UserInterface;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
* @KPI(
*   id = "manual",
*   label = "Manual KPIs",
*   form = { }
* )
*/
class ManualKPIPlugin implements KPIInterface {

  /**
  * {@inheritdoc}
  */
  public function info() {
    $bundles = entity_get_bundles('manual_kpi');
    $info = [];

    foreach($bundles as $id => $bundle) {
      $info[] = [
        'label' => $bundle['label'],
        Link::fromTextAndUrl(t('View Leaderboard'), Url::fromRoute('krocodile.leaderboard', ['plugin_id' => 'manual', 'type' => $id]))->toString(),
        Link::fromTextAndUrl(t('Configure'), Url::fromRoute('entity.manual_kpi_type.edit_form', ['manual_kpi_type' => $id]))->toString(),
        Link::fromTextAndUrl(t('Enter KPI'), Url::fromRoute('entity.manual_kpi.add_form', ['manual_kpi_type' => $id]))->toString(),
      ];
    }
    return $info;
  }

  /**
  * {@inheritdoc}
  */
  public function get(UserInterface $account, $options = []) { }

  /**
  * {@inheritdoc}
  */
  public function execute(UserInterface $account, $options = []) { }

  /**
  * {@inheritdoc}
  */
  public function render(UserInterface $account, $options = []) { }

  /**
  * {@inheritdoc}
  */
  public function total(UserInterface $account, $type = FALSE, $options = []) {
    $query = \Drupal::database()->select('manual_kpi', 'm');
    $query->condition('m.type', $type)
      ->condition('user_id', $account->id())
      ->addExpression('SUM(m.point)', 'point');
    return (int) $query->execute()->fetchField();
  }
}
