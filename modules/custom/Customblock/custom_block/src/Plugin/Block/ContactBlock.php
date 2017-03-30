<?php
/**
 * @file
 * Contains \Drupal\article\Plugin\Block\ContactBlock.
 */
namespace Drupal\custom_block\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a 'contact' block.
 *
 * @Block(
 *   id = "contact_block",
 *   admin_label = @Translation("Contact Us"),
 *   category = @Translation("Custom contact us block")
 * )
 */
class ContactBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);
    // Retrieve existing configuration for this block.
    $config = $this->getConfiguration();
    // Add a form field to the existing block configuration form.
    $form['org_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Organization:'),
      '#default_value' => isset($config['org_name'])? $config['org_name'] : '',
    );
    $form['org_loca'] = array(
      '#type' => 'textfield',
      '#title' => t('Location:'),
      '#default_value' => isset($config['org_loca'])? $config['org_loca'] : '',
    );
    $form['org_mail'] = array(
      '#type' => 'email',
      '#title'=> t('Email ID:'),
      '#default_value' => isset($config['org_mail'])? $config['org_mail'] : '',
    );
    $form['org_phn'] = array(
      '#type' => 'number',
      '#title'=> t('Contact:'),
      '#default_value' => isset($config['org_phn'])? $config['org_phn'] : '',
    );
    $form['org_add'] = array(
      '#type' => 'textfield',
      '#title'=> t('Address:'),
      '#default_value' => isset($config['org_add'])? $config['org_add'] : '',
    );
    return $form;
  }
  
  // to initialise default value from congig/install/*.settings.yml file
//  public function defaultConfiguration() {
//    $default_config = \Drupal::config('custom_block.settings');
//    return array(
//      'org_name' => $default_config->get('orgnization.name'),
////      'org_mail' => $default_config->get('orgnization.mail'),
////      'org_phn' => $default_config->get('orgnization.phone'),
////      'org_add' => $default_config->get('orgnization.adderess')
//    );
//     //to set default value see https://www.drupal.org/docs/8/creating-custom-modules/add-a-default-configuration
//  }
  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    // Save our custom settings when the form is submitted.
    $this->setConfigurationValue('org_name', $form_state->getValue('org_name'));
    $this->setConfigurationValue('org_loca', $form_state->getValue('org_loca'));
    $this->setConfigurationValue('org_mail', $form_state->getValue('org_mail'));
    $this->setConfigurationValue('org_phn', $form_state->getValue('org_phn'));
    $this->setConfigurationValue('org_add', $form_state->getValue('org_add'));
    
    //If you have a fieldset wrapper around your form elements then you should pass an array to the getValue() function,
    // instead of passing the field name alone. Here myfieldset is the fieldset which is wrapping the hello_block_name field.
    //$this->setConfigurationValue('name', $form_state->getValue(array('myfieldset', 'hello_block_name')));
    
    //to set default value see https://www.drupal.org/docs/8/creating-custom-modules/add-a-default-configuration
  }
  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->getConfiguration();
    $org_name = isset($config['org_name']) ? $config['org_name'] : '';
    $org_loca = isset($config['org_loca']) ? $config['org_loca'] : '';
    $org_mail = isset($config['org_mail']) ? $config['org_mail'] : '';
    $org_phn = isset($config['org_phn']) ? $config['org_phn'] : '';
    $org_add = isset($config['org_add']) ? $config['org_add'] : '';
    return array(
      '#markup' => $this->t('@org,<br> @loc.<br> Email id : @mail <br>Phn: @phn.<br> Address: @add <a href="https://www.drupal.org">Visit</a>', array('@add'=> $org_add,'@phn'=> $org_phn,'@mail'=> $org_mail,'@org'=> $org_name,'@loc' => $org_loca)),
    );
    
    
    //Use Config in Block Display  see : https://www.drupal.org/docs/8/creating-custom-modules/use-config-in-block-display
    
    
  }
  /**
   * {@inheritdoc}
   */
  public function blockValidate($form, FormStateInterface $form_state) {
    $org_name = $form_state->getValue('org_name');
    if (is_numeric($org_name)) {
      drupal_set_message('needs to be an integer', 'error');
      $form_state->setErrorByName('org_name', t('Organization name should not be numeric'));
    }
  }
//    /**
//   * {@inheritdoc}
//   */
//  public function access(AccountInterface $account) {
//    return $account->hasPermission('access content');
//  } 
}