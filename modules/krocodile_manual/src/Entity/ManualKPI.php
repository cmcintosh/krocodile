<?php

namespace Drupal\krocodile_manual\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Manual kpi entity.
 *
 * @ingroup krocodile_manual
 *
 * @ContentEntityType(
 *   id = "manual_kpi",
 *   label = @Translation("Manual kpi"),
 *   bundle_label = @Translation("Manual kpi type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\krocodile_manual\ManualKPIListBuilder",
 *     "views_data" = "Drupal\krocodile_manual\Entity\ManualKPIViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\krocodile_manual\Form\ManualKPIForm",
 *       "add" = "Drupal\krocodile_manual\Form\ManualKPIForm",
 *       "edit" = "Drupal\krocodile_manual\Form\ManualKPIForm",
 *       "delete" = "Drupal\krocodile_manual\Form\ManualKPIDeleteForm",
 *     },
 *     "access" = "Drupal\krocodile_manual\ManualKPIAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\krocodile_manual\ManualKPIHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "manual_kpi",
 *   admin_permission = "administer manual kpi entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "bundle" = "type",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/krocodile/manual/manual_kpi/{manual_kpi}",
 *     "add-page" = "/admin/krocodile/manual/manual_kpi/add",
 *     "add-form" = "/admin/krocodile/manual/manual_kpi/add/{manual_kpi_type}",
 *     "edit-form" = "/admin/krocodile/manual/manual_kpi/{manual_kpi}/edit",
 *     "delete-form" = "/admin/krocodile/manual/manual_kpi/{manual_kpi}/delete",
 *     "collection" = "/admin/krocodile/manual/manual_kpi",
 *   },
 *   bundle_entity_type = "manual_kpi_type",
 *   field_ui_base_route = "entity.manual_kpi_type.edit_form"
 * )
 */
class ManualKPI extends ContentEntityBase implements ManualKPIInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += [
      'user_id' => \Drupal::currentUser()->id(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function isPublished() {
    return (bool) $this->getEntityKey('status');
  }

  /**
   * {@inheritdoc}
   */
  public function setPublished($published) {
    $this->set('status', $published ? TRUE : FALSE);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Account'))
      ->setDescription(t('The user ID of the account for this Manual kpi entity.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the Manual kpi entity.'))
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['point'] = BaseFieldDefinition::create('decimal')
      ->setLabel(t('Points'))
      ->setDescription(t('Enter the point value for this entry, can be positive or negative.'))
      ->setDefaultValue(0)
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Publishing status'))
      ->setDescription(t('A boolean indicating whether the Manual kpi is published.'))
      ->setDefaultValue(TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
