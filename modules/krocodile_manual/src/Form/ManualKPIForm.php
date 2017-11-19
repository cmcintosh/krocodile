<?php

namespace Drupal\krocodile_manual\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for Manual kpi edit forms.
 *
 * @ingroup krocodile_manual
 */
class ManualKPIForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\krocodile_manual\Entity\ManualKPI */
    $form = parent::buildForm($form, $form_state);

    $entity = $this->entity;

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = &$this->entity;

    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Manual kpi.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Manual kpi.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.manual_kpi.canonical', ['manual_kpi' => $entity->id()]);
  }

}
