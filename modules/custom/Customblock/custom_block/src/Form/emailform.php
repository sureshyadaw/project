<?php
/**
 * @file
 * Contains \Drupal\brew_tools\Form\BrewToolsStrikeTempForm.
 */

namespace Drupal\custom_block\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Ajax\HtmlCommand;

abstract class emailform extends FormBase {
       /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return "strike_temp_form";
    }
 public function buildForm(array $form, FormStateInterface $form_state) {
$form['email'] = array(
  '#type' => 'email',
  '#title' => $this->t('Your .com email address.'),   
  '#ajax' => [
    'callback' => array($this, 'validateEmailAjax'),
    'event' => 'change',
    'progress' => array(
      'type' => 'throbber',
      'message' => t('Verifying email...'),
    ),
  ],
  '#suffix' => '<span class="email-valid-message"></span>'
  );}

 /**
 * Validates that the email field is correct.
 */
protected function validateEmail(array &$form, FormStateInterface $form_state) {
  if (substr($form_state->getValue('email'), -4) !== '.com') {
    return FALSE;
  }
  return TRUE;
}
/**
 * {@inheritdoc}
 */
public function validateForm(array &$form, FormStateInterface $form_state) {
  // Validate email.
  if (!$this->validateEmail($form, $form_state)) {
    $form_state->setErrorByName('email', $this->t('This is not a .com email address.'));
  }
}
  
/**
 * Ajax callback to validate the email field.
 */
public function validateEmailAjax(array &$form, FormStateInterface $form_state) {
  $valid = $this->validateEmail($form, $form_state);
  $response = new AjaxResponse();
  if ($valid) {
    $css = ['border' => '1px solid green'];
    $message = $this->t('Email ok.');
  }
  else {
    $css = ['border' => '1px solid red'];
    $message = $this->t('Email not valid.');
  }
  $response->addCommand(new CssCommand('#edit-email', $css));
  $response->addCommand(new HtmlCommand('.email-valid-message', $message));
  return $response;
}
 
 
}
 