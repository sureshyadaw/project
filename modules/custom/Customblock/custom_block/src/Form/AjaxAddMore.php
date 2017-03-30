<?php
    
    namespace Drupal\custom_block\Form;
    
    use Drupal\Core\Form\FormStateInterface;
    
    class AjaxAddMore extends \Drupal\Core\Form\FormBase {
    
      public function buildForm(array $form, FormStateInterface $form_state) {
            $form['description'] = array(
        '#markup' => ''. t('This example shows an add-more and a remove-last button.').'',
      );
        $i = 0;
        $name_field = $form_state->get('num_names');
        $form['#tree'] = TRUE;
        $form['names_fieldset'] = [
          '#type' => 'fieldset',
          '#title' => $this->t('People coming to picnic'),
          '#prefix' => '',
          '#suffix' => '',
        ];
        if (empty($name_field)) {
          $name_field = $form_state->set('num_names', 1);
        }
        for ($i = 0; $i < $name_field; $i++) {
          $form['names_fieldset']['name'][$i] = [
            '#type' => 'textfield',
            '#title' => t('Name'),
          ];
        }
        $form['actions'] = [
          '#type' => 'actions',
        ];
        $form['names_fieldset']['actions']['add_name'] = [
          '#type' => 'submit',
          '#value' => t('Add one more'),
          '#submit' => array('::addOne'),
          '#ajax' => [
            'callback' => '::addmoreCallback',
            'wrapper' => 'names-fieldset-wrapper',
          ],
        ];
        if ($name_field > 1) {
          $form['names_fieldset']['actions']['remove_name'] = [
            '#type' => 'submit',
            '#value' => t('Remove one'),
            '#submit' => array('::removeCallback'),
           '#ajax' => [
              'callback' => '::addmoreCallback',
              'wrapper' => 'names-fieldset-wrapper',
            ]
          ];
        }
        $form_state->setCached(FALSE);
        $form['actions']['submit'] = [
          '#type' => 'submit',
          '#value' => $this->t('Submit'),
        ];
    
        return $form;
      }
    
      public function getFormId() {
        return 'fapi_example_ajax_addmore';
      }
    
      public function addOne(array &$form, FormStateInterface $form_state) {
        $name_field = $form_state->get('num_names');
        $add_button = $name_field + 1;
        $form_state->set('num_names', $add_button);
        $form_state->setRebuild();
      }
    
      public function addmoreCallback(array &$form, FormStateInterface $form_state) {
        $name_field = $form_state->get('num_names');
        return $form['names_fieldset'];
      }
    
      public function removeCallback(array &$form, FormStateInterface $form_state) {
        $name_field = $form_state->get('num_names');
        if ($name_field > 1) {
          $remove_button = $name_field - 1;
          $form_state->set('num_names', $remove_button);
        }
       $form_state->setRebuild();
      }
    
      public function submitForm(array &$form, FormStateInterface $form_state) {
        $values = $form_state->getValue(array('names_fieldset', 'name'));
    
        $output = t('These people are coming to the picnic: @names', array(
          '@names' => implode(', ', $values),
            )
        );
        drupal_set_message($output);
      }
    
    }