<?php

namespace Drupal\krocodile_manual\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Manual kpi type entity.
 *
 * @ConfigEntityType(
 *   id = "manual_kpi_type",
 *   label = @Translation("Manual kpi type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\krocodile_manual\ManualKPITypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\krocodile_manual\Form\ManualKPITypeForm",
 *       "edit" = "Drupal\krocodile_manual\Form\ManualKPITypeForm",
 *       "delete" = "Drupal\krocodile_manual\Form\ManualKPITypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\krocodile_manual\ManualKPITypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "manual_kpi_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "manual_kpi",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/krocodile/manual/types/manual_kpi_type/{manual_kpi_type}",
 *     "add-form" = "/admin/krocodile/manual/types/manual_kpi_type/add",
 *     "edit-form" = "/admin/krocodile/manual/types/manual_kpi_type/{manual_kpi_type}/edit",
 *     "delete-form" = "/admin/krocodile/manual/types/manual_kpi_type/{manual_kpi_type}/delete",
 *     "collection" = "/admin/krocodile/manual/types/manual_kpi_type"
 *   }
 * )
 */
class ManualKPIType extends ConfigEntityBundleBase implements ManualKPITypeInterface {

  /**
   * The Manual kpi type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Manual kpi type label.
   *
   * @var string
   */
  protected $label;

}
