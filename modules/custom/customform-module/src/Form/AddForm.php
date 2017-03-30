<?php
/**
 * @file
 * Contains \Drupal\bd_contact\AddForm.
 */

namespace Drupal\customform;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\SafeMarkup;

class AddForm extends FormBase {
  protected $id;

  function getFormId() {
    return 'customform_add';
  }

  function buildForm(array $form, FormStateInterface $form_state) {
    $this->id = \Drupal::request()->get('id');
    $customform = customformStorage::get($this->id);

    $form['name'] = array(
      '#type' => 'textfield',
      '#title' => t('Name'),
      '#default_value' => ($customform) ? $customform->name : '',
    );
    $form['message'] = array(
      '#type' => 'textarea',
      '#title' => t('Message'),
      '#default_value' => ($customform) ? $customform->message : '',
    );
    $form['actions'] = array('#type' => 'actions');
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => ($customform) ? t('Edit') : t('Add'),
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {

  }


  function submitForm(array &$form, FormStateInterface $form_state) {
    $name = $form_state->getValue('name');
    $message = $form_state->getValue('message');
    if (!empty($this->id)) {
      BdContactStorage::edit($this->id, SafeMarkup::checkPlain($name), SafeMarkup::checkPlain($message));
      \Drupal::logger('$customform')->notice('@type: deleted %title.',
          array(
              '@type' => $this->id,
              '%title' => $this->id,
          ));

      drupal_set_message(t('Your custom_form has been edited'));
    }
    else {
      BdContactStorage::add(SafeMarkup::checkPlain($name), SafeMarkup::checkPlain($message));
      \Drupal::logger('customform')->notice('@type: deleted %title.',
          array(
              '@type' => $this->id,
              '%title' => $this->id,
          ));

      drupal_set_message(t('Your custom_form has been submitted'));
    }
    $form_state->setRedirect('custom_form_lists');
    return;
  }
}
