<?php

/**
 * @file
 * Contains manual_kpi.page.inc.
 *
 * Page callback for Manual kpi entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Manual kpi templates.
 *
 * Default template: manual_kpi.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_manual_kpi(array &$variables) {
  // Fetch ManualKPI Entity Object.
  $manual_kpi = $variables['elements']['#manual_kpi'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
