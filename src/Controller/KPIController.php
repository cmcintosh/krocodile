<?php

namespace Drupal\krocodile\Controller;

use Drupal\user\UserInterface;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Url;

/**
* Controller used to render various pages.
*/
class KPIController extends ControllerBase {

  private $manager;
  private $definitions;

  public function __construct() {
    $this->manager = \Drupal::service('plugin.manager.kpi');
    $this->definitions = $this->manager->getDefinitions();
  }

  /**
  * Displays a list of discovered Plugins and links to the settings, report, and record (Optional) forms.
  */
  public function overview() {
    $plugin_table = [
      '#header' => [
        [
          'data' => t('KPI Name')
        ],
        [
          'data' => t('Actions'),
          'colspan' => 4
        ]
      ],
      '#rows' => [],
      '#empty' => t('No KPI Plugins detected.'),
      '#theme' => 'table'
    ];

    $rows = [];

    if (count($this->definitions) > 0 ) {
      foreach($this->definitions as $id => $definition) {
        $plugin = $this->manager->createInstance($id, [ ]);
        // Get the info array from this plugin.
        $info = $plugin->info();
        foreach($info as $record) {
          $rows[] = $record;
        }
      }
    }

    $plugin_table['#rows'] = $rows;

    return [
      'plugin_list' => $plugin_table
    ];
  }

  /**
  * Creates a leaderboard for each KPI.
  */
  public function leaderboard($plugin_id, $type = '') {
    $leaderboard = [
      '#header' => [
        'name' => [
          'data' => t('Name')
        ],
        'points' => [
          'data' => t('Points')
        ]
      ],
      '#rows' => [],
      '#empty' => t('There is not enough data to generate the Leaderboard.'),
      '#theme' => 'table'
    ];

    // Load all users.
    $query = \Drupal::entityQuery('user');
    $query->condition('uid', 0, '>');
    $ids = $query->execute();

    // Get Plugin
    $plugin = $this->manager->createInstance($plugin_id, [ ]);

    // Loop through and build the table.
    // @TODO maybe optimize how we are building this. If we have a lot of users...
    $rows = [];
    $accounts = entity_load_multiple('user', $ids);
    $limit = 10;
    foreach($accounts as $account) {
      $rows[] = [
        'name'   => $account->label(),
        'points' => $plugin->total($account, $type)
      ];
      $limit--;
      if ($limit == 0) {
        break;
      }
    }
    // Sort the results.
    usort($rows, function($a, $b) {
      return $a['points'] < $b['points'];
    });

    $leaderboard['#rows'] = $rows;

    return [
      'leaderboard' => $leaderboard,
    ];
  }

  /**
  * Returns the report page for the selected user.
  */
  public function user(UserInterface $user) {
    $report_table = [
      '#type' => 'table',
      '#header' => [
        'info' => [
          'data' => t('KPI')
        ],
        'points' => [
          'data' => t('Points')
        ]
      ],
      '#rows' => []
    ];

    foreach($this->definitions as $id => $definition) {
      $plugin = $this->manager->createInstance($id, [ ]);
      // Get the info array from this plugin.
      $info = $plugin->info();
      
      foreach($info as $record) {
        $rows[] = [
          'label' => $record['label'],
          'points' => $plugin->total($user)
        ];
      }
    }

    $report_table['#rows'] = $rows;

    return [
      'kpi_list' => $report_table
    ];
  }

}
