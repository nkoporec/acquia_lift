<?php

namespace Drupal\acquia_perz_push\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines the form to configure the Content Index Service connection settings.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'acquia_perz_push_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['acquia_perz_push.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $settings = $this
      ->config('acquia_perz_push.settings');
    $cis_settings = $settings->get('cis');

    $form['cis'] = [
      '#tree' => TRUE,
    ];
    $form['cis']['endpoint'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Endpoint'),
      '#default_value' => $cis_settings['endpoint'],
      '#required' => TRUE,
    ];
    $form['cis']['account_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Account ID'),
      '#default_value' => $cis_settings['account_id'],
      '#required' => TRUE,
    ];
    $form['cis']['environment'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Environment'),
      '#default_value' => $cis_settings['environment'],
      '#required' => TRUE,
    ];
    $form['cis']['origin'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Origin'),
      '#default_value' => $cis_settings['origin'],
      '#required' => TRUE,
    ];
    $form['cis']['api_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('API Key'),
      '#default_value' => $cis_settings['api_key'],
      '#required' => TRUE,
    ];
    $form['cis']['endpoint_timeout'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Endpoint timeout (seconds)'),
      '#default_value' => $cis_settings['endpoint_timeout'],
      '#required' => TRUE,
    ];
    $form['cis']['queue_bulk_max_size'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Queue bulk max size'),
      '#default_value' => $cis_settings['queue_bulk_max_size'],
      '#required' => TRUE,
    ];
    $form['cis']['ins_upd_slow_endpoint'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Insert/Update entity: slow endpoint'),
      '#default_value' => isset($cis_settings['ins_upd_slow_endpoint']) ? $cis_settings['ins_upd_slow_endpoint'] : FALSE,
    ];
    $form['cis']['delete_entity_slow_endpoint'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Delete entity: slow endpoint'),
      '#default_value' => isset($cis_settings['delete_entity_slow_endpoint']) ? $cis_settings['delete_entity_slow_endpoint'] : FALSE,
    ];
    $form['cis']['delete_translation_slow_endpoint'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Delete translation: slow endpoint'),
      '#default_value' => isset($cis_settings['delete_translation_slow_endpoint']) ? $cis_settings['delete_translation_slow_endpoint'] : FALSE,
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $settings = $this->config('acquia_perz_push.settings');
    $values = $form_state->getValues()['cis'];
    $settings->set('cis.endpoint', trim($values['endpoint']));
    $settings->set('cis.account_id', trim($values['account_id']));
    $settings->set('cis.environment', trim($values['environment']));
    $settings->set('cis.api_key', trim($values['api_key']));
    $settings->set('cis.ins_upd_slow_endpoint', $values['ins_upd_slow_endpoint']);
    $settings->set('cis.delete_entity_slow_endpoint', $values['delete_entity_slow_endpoint']);
    $settings->set('cis.delete_translation_slow_endpoint', $values['delete_translation_slow_endpoint']);
    $settings->save();
    parent::submitForm($form, $form_state);
  }

}
