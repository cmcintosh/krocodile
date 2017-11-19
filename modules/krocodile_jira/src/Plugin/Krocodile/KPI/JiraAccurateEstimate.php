<?php

namespace Drupal\krocodile_jira\Plugin\Krocodile\KPI;

use Drupal\krocodile\Plugin\Krocodile\KPI\KPIInterface;
use Drupal\user\UserInterface;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
* @KPI(
*   id = "jira_estimate",
*   label = "Jira Estimates",
*   form = { }
* )
*/
class JiraAccurateEstimate implements KPIInterface {

  private $jira;

  public function __construct() {
    // Store our Jira Service Wrapper
    $this->jira = \Drupal::service('jira_rest_wrapper_service');
  }

  /**
  * {@inheritdoc}
  */
  public function info() {
    return [
      [
        'label' => t('Task Estimate Accuracy'),
        Link::fromTextAndUrl(t('View Leaderboard'), Url::fromRoute('krocodile.leaderboard', ['plugin_id' => 'jira_estimate', 'type' => 'all']))->toString(),
        '',
        ''
      ]
    ];
  }

  /**
  * {@inheritdoc}
  */
  public function get(UserInterface $account, $options =[]) { }

  /**
  * {@inheritdoc}
  */
  public function execute(UserInterface $account, $options =[]) { }

  /**
  * {@inheritdoc}
  */
  public function render(UserInterface $account, $options =[]) { }

  /**
  * {@inheritdoc}
  */
  public function total(UserInterface $account, $type = FALSE, $options = []) {

    $service = $this->jira->getIssueService();
    $search = $service->createSearch();
    $search->setStartAt(0);
    $search->setMaxResults(-1);
    $search->search(); // @TODO limit this
    $issues = $search->getIssues();

    // For now we are just doing a simple point check.
    $points = 0;
    $mail = $account->get('mail')->getValue()[0]['value'];

    foreach($issues as $i => $issue) {

      if ($issue->fields->assignee->emailAddress == $mail) {
        $timeEstimate = isset($issue->fields->timeoriginalestimate) ? ( ( $issue->fields->timeoriginalestimate / 60) / 60) : 0;
        $timeSpent = isset($issue->fields->timespent) ? ($issue->fields->timespent / 60) / 60 : 0;
        if ($timeSpent == 0) {
          continue;
        }
        $timeDiff = (((int) $timeSpent - (int) $timeEstmate) / $timeEstimate) * 100;
          if ($timeDiff < 10) {
            $points -= 6;
          }
          elseif ($timeDiff < 25 && $timeDiff > 10) {
            $points -= 4;
          }
          elseif ($timeDiff < 75 && $timeDiff > 25) {
            $points -= 2;
          }
          elseif ($timeDiff > 75 && $timeDiff < 125) {
            $points += 4;
          }
          elseif ($timeDiff > 125 && $timeDiff < 175) {
            $points -= 2;
          }
          elseif ($timeDiff > 175 && $timeDiff < 200) {
            $points -= 4;
          }
          elseif ($timeDiff > 200) {
            $points -= 6;
          }
        }
      }
    return $points;
  }

}
