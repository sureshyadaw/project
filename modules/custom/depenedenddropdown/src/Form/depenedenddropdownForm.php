<?php

/**
 * @file
 * Contains Drupal\ajax_example\AjaxExampleForm
 */

namespace Drupal\depenedenddropdown\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\Core\Link;
 

class depenedenddropdownForm extends FormBase {

    /**
     * {@inheritdoc}
     */
    public function getFormID() {
        return 'a_country_state_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
         
        $countrylist = array();         
            $query = \Drupal::database()->select('a_country', 'c');
            $query->fields('c', ['country_id', 'country_name']);
           $query->orderBy('country_name', 'ASC');
            //$query->condition('country_id', array($form_state->getValue('countries')));
            $results = $query->execute()->fetchALL();
            $countrylist['0'] = 'Countries';

            foreach ($results as $res) {
                $countrylist[$res->country_id] = $res->country_name;
            }
    
        $form['name'] = [
            '#type' => 'textfield',
            '#title' => t('Name'),
            '#size' => 20
        ];
        $form['countries'] = [
            '#type' => 'select',
            '#title' => t('Select Country'),
            '#options' =>$countrylist,
            '#default_value' => 'defaultSelect',
            '#ajax' => [
                'callback' => [$this, 'changeOptionsAjax'],
                // 'callback' => '\Drupal\helloworld\Form\helloworldForm::changeOptionsAjax',
                // 'callback' => '::changeOptionsAjax',
                'wrapper' => 'second_field_wrapper',
            ],
        ];
        $form['states'] = [
            '#type' => 'select',
            '#title' => t('Select State'),
            '#options' => $this->getOptions($form_state),
            '#width' => 200,
            '#default_value' => 'defaultSelect',
            '#prefix' => '<div id="second_field_wrapper">',
            '#suffix' => '</div>',
            '#event' =>'click',
            '#ajax' => [
                'callback' => [$this, 'changeOptionsAjax1'],
                // 'callback' => '\Drupal\helloworld\Form\helloworldForm::changeOptionsAjax',
                // 'callback' => '::changeOptionsAjax',
                'wrapper' => 'third_field_wrapper',
            ],
        ];
        $form['cities'] = [
            '#type' => 'select',
            '#title' => t('Select City '),
            '#options' => $this->getOptions1($form_state),
            '#default_value' => 'defaultSelect',
            '#prefix' => '<div id="third_field_wrapper" style="width:200px">',
            '#suffix' => '</div>',
        ];
        $form['gender'] = array(
            '#type' => 'radios',
            '#title' => $this->t('Gender'),
            //'#default_value' => 0,
            '#options' => array(
                'male' => 'Male',
                'female' => 'Female',
            )
        );

        $form['submit'] = [
            '#type' => 'submit',
            '#value' => 'Submit',
//             '#ajax' =>[
//              'callback' =>'submitForm', // define ajax callback to show the message
//              'wrapper' => 'my-submit-button', // define what div should be replaced
//               ],
            '#prefix' => '<div id ="my-submit-button">', // wrap this button in the div that is replaced
            '#suffix' => '</div>',
        ];
 
        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state) {
        
         
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        $subname = $form_state->getValue('name');
        $subcountry = $form_state->getValue('countries');
        $substate = $form_state->getValue('states');
        $subcity = $form_state->getValue('cities');
        $subgender = $form_state->getValue('gender');
        $field = array(

            'name' =>  $subname,
            'country_id' => $subcountry,
            'state_id' =>  $substate ,
            'city_id' => $subcity,
            'gender' =>  $subgender,             
        );
         
        $query = \Drupal::database()->select('a_counry_state_tbl', 'nfd');
        $query->fields('nfd', ['name']);
        $query->condition('name', $form_state->getValue('name'));
        $chkName = $query->execute()->fetchField();
        if($chkName==null){
                    db_insert('a_counry_state_tbl')
            ->fields($field)
            ->execute();
             drupal_set_message(" Succesfully saved");
        }
        else
        {
            drupal_set_message("Record with same name already exists");
        }
 

    }

    /**
     * Ajax callback to change options for state field.
     */
    public function changeOptionsAjax(array &$form, FormStateInterface $form_state) {

        return $form['states'];
    }

    /**
     * Ajax callback to change options for City field.
     */
    public function changeOptionsAjax1(array &$form, FormStateInterface $form_state) {

        return $form['cities'];
    }
public function getCountryOptions() {
        $countrylist = array();
         
            $query = \Drupal::database()->select('a_country', 'c');
            $query->fields('c', ['country_id', 'country_name']);
           $query->orderBy('country_name', 'ASC');
            //$query->condition('country_id', array($form_state->getValue('countries')));
            $results = $query->execute()->fetchALL();
            $countrylist['0'] = 'States';

            foreach ($results as $res) {
                $countrylist[$res->country_id] = $res->country_name;
            }
            return $countrylist;
         
    }
    /**
     * Get options for state field.
     */
    public function getOptions(FormStateInterface $form_state) {
        $statelist = array();
        if ($form_state->getValue('countries')!='0') {
            $query = \Drupal::database()->select('a_state', 'c');
            $query->fields('c', ['state_id', 'state_name', 'country_id']);
           $query->orderBy('state_name', 'ASC');
            $query->condition('country_id', array($form_state->getValue('countries')));
            $results = $query->execute()->fetchALL();
            if($results!=null){
                $statelist['0'] = 'States';

            foreach ($results as $res) {
                $statelist[$res->state_id] = $res->state_name;
            } 
            
            }
            else{$statelist['0'] = 'No State found';}
        }
        else{$statelist['0'] = 'not found';}
        return $statelist;
    }

    /**
     * Get options for city field.
     */
    public function getOptions1(FormStateInterface $form_state) {
       $citylist = array();
        if($form_state->getValue('states')!='0'){
        $query = \Drupal::database()->select('a_city', 'c');
        $query->fields('c', ['city_id', 'city_name', 'state_id']);
        $query->orderBy('city_name', 'ASC');
        $query->condition('state_id', array($form_state->getValue('states')));
        $results = $query->execute()->fetchALL();
        
        if($results!=null)
        {$citylist['0'] = 'Cities';
        foreach ($results as $res) {
            $citylist[$res->city_id] = $res->city_name;
        }
        }
        
        else{$citylist['0'] = 'No city found';}
        
        }
        else{$citylist['0'] = 'not found';}
        return $citylist;
    }

}
