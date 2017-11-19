<?php

namespace Drupal\krocodile_jira\Controller;

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
class Jira extends ControllerBase {

  private $jira;
  private $search;

  public function __construct() {
    $this->jira = \Drupal::service('jira_rest_wrapper_service');

  }

  public function testing() {
    $issue_list = [
      '#type' => 'table',
      '#header' => [
        [
          'data' => t('Developer')
        ],
        [
          'data' => t('Issue #')
        ],
        [
          'data' => t('Estimate')
        ],
        [
          'data' => t('Actual')
        ],
        [
          'data' => t('Difference')
        ]
      ],
      '#rows' => [],
    ];

    $service = $this->jira->getIssueService();
    $search = $service->createSearch();
    $search->setStartAt(0);

    $search->setMaxResults(250);
    $search->search("project=LEED");
    $issues = $search->getIssues();
    $rows = [];

    foreach($issues as $i => $issue) {
      $timeEstimate = isset($issue->fields->timeoriginalestimate) ? ( ( $issue->fields->timeoriginalestimate / 60) / 60) : 0;
      $timeSpent = isset($issue->fields->timespent) ? ($issue->fields->timespent / 60) / 60 : 0;
      $timeDiff = ((int) $timeSpent - (int) $timeEstmate) / $timeEstimate;
      $row = [
        $issue->fields->assignee->emailAddress,
        $issue->key . " " . $issue->fields->summary,
        $timeEstimate . ' hours',
        $timeSpent . ' hours',
        ($timeDiff * 100) . '%'
      ];
      $rows[] = $row;
    }

    $issue_list['#rows'] = $rows;

    return [
      'issue_list' => $issue_list
    ];
  }

}
