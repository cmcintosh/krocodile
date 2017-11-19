<?php

namespace Drupal\krocodile_manual\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ManualKPITypeForm.
 */
class ManualKPITypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $manual_kpi_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $manual_kpi_type->label(),
      '#description' => $this->t("Label for the Manual kpi type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $manual_kpi_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\krocodile_manual\Entity\ManualKPIType::load',
      ],
      '#disabled' => !$manual_kpi_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $manual_kpi_type = $this->entity;
    $status = $manual_kpi_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Manual kpi type.', [
          '%label' => $manual_kpi_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Manual kpi type.', [
          '%label' => $manual_kpi_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($manual_kpi_type->toUrl('collection'));
  }

}
