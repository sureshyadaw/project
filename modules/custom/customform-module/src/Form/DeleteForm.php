<?php

namespace Drupal\customform;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

class DeleteForm extends ConfirmFormBase {
  protected $id;

  function getFormId() {
    return 'customform_delete';
  }

  function getQuestion() {
    return t('Are you sure you want to delete submission %id?', array('%id' => $this->id));
  }

  function getConfirmText() {
    return t('Delete');
  }

  function getCancelUrl() {
    return new Url('custom_form_lists');
  }

  function buildForm(array $form, FormStateInterface $form_state) {
    $this->id = \Drupal::request()->get('id');
    return parent::buildForm($form, $form_state);
  }

  function submitForm(array &$form, FormStateInterface $form_state) {
    customformStorage::delete($this->id);
    //watchdog('bd_contact', 'Deleted BD Contact Submission with id %id.', array('%id' => $this->id));
    \Drupal::logger('customform')->notice('@type: deleted %title.',
        array(
            '@type' => $this->id,
            '%title' => $this->id,
        ));
    drupal_set_message(t('custom form submission %id has been deleted.', array('%id' => $this->id)));
    $form_state->setRedirect('custom_form_lists');
  }
}
