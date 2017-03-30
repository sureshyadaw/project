<?php

/**
 * @file
 * Contains Drupal\ajax_example\AjaxExampleForm
 */

namespace Drupal\ajax_example\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ChangedCommand;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Ajax\AddCssCommand;
use Drupal\Core\Ajax\AlertCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\Element\EntityAutocomplete;


            

            

class AjaxExampleForm extends FormBase {

  public function getFormId() {
    return 'ajax_example_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
            $form['countries']=array(
            '#type' => 'select',
            //'#description' => 'Please select country',
            '#prefix' => '<div id=country style="color:red">',
	    '#suffix' => '</div>',
             '#title' => $this->t('Select Country'),
                   '#options' => [
                                    '0' => $this->t('Select Country'),  
                                    '1' => $this->t('India'),
                                    '2' =>$this->t('aus'),
                                    '3'=>$this->t('pakistan')
                                  ],
//                    '#attributes' => array(
//                                'id' => 'targetElement',
//                              ),
                    '#ajax' =>array(
                        'callback' =>'Drupal\ajax_example\Form\AjaxExampleForm::usernameValidateCallback',
                        'event' => 'change',
                        'progress' => array(
                        'type' => 'throbber',
                        'message' => 'Getting Result',
                         'wrapper' =>'slected_country_id_wrapper'   
                         ),
                        ),
            
                );
                 $statelist=[
                                    '0' => t('Select State'), 
                             ];
            $form['states']=array(
                
            '#type' => 'select',
            //'#description' => 'Please select country',
            '#prefix' => '<div id=slected_country_id_wrapper style="color:green">',
	    '#suffix' => '</div>',
             '#title' => $this->t('Select State'),
             '#options' =>['0' =>'Select State'],
              '#ajax' =>array(
                        'callback' =>'Drupal\ajax_example\Form\AjaxExampleForm::addCityCallback',
                        'event' => 'change',
                        'progress' => array(
                        'type' => 'throbber',
                        'message' => 'Getting Result',
                         'wrapper' =>'slected_state_id_wrapper'   
                         ),
                        ), 
            );
            $form['cities']=array(
                
            '#type' => 'select',
            //'#description' => 'Please select country',
            '#prefix' => '<div id=state style="color:green">',
	    '#suffix' => '</div>',
             '#title' => $this->t('Select City'),
             '#options' =>['0' =>'Select City'],
                '#ajax' =>array(
                        'callback' =>'Drupal\ajax_example\Form\AjaxExampleForm::addCityCallback',
                        'event' => 'change',
                        'progress' => array(
                        'type' => 'throbber',
                        'message' => 'Getting Result',
                         'wrapper' =>'slected_city_id_wrapper'   
                         ),
                        ), 
            );
            
            
      $form['user_name'] = array(
      '#type' => 'textfield',
      '#title' => 'Username',
      '#description' => 'Please enter in a username',
       
      '#ajax' => array(
        // Function to call when event on form element triggered.
        'callback' => 'Drupal\ajax_example\Form\AjaxExampleForm::usernameValidateCallback',
        // Effect when replacing content. Options: 'none' (default), 'slide', 'fade'.
        'effect' => 'fade',
        // Javascript event to trigger Ajax. Currently for: 'onchange'.
        'event' => 'change',
        'progress' => array(
          // Graphic shown to indicate ajax. Options: 'throbber' (default), 'bar'.
          'type' => 'throbber',
          // Message to show along progress graphic. Default: 'Please wait...'.
          'message' => NULL,
        ),
      ),
    );
      $form['testing']=array(
        '#prefix' => '<div id=myid style="color:red">',
	'#suffix' => '</div>',
        '#type' => 'textfield',
         '#title' =>'testing',
//         '#target_type' =>'user',
//         '#selection_settings' => ['target_bundles' => ["article"]],
          
      ); 
    return $form;
  }
  
  public function submitForm(array &$form, FormStateInterface $form_state) {
        drupal_set_message('Nothing Submitted. Just an Example.');
    }

    public function addCityCallback() {
        $ajax_response = new AjaxResponse();
        $statelist='';
        
        
        return $ajax_response;
    }

    public function addStateCallback(array &$form, FormStateInterface $form_state) {
        $ajax_response = new AjaxResponse();

        $var;
        if ($form_state->getValue('states')) {

            $var = $form_state->getValue('states');
            $query = \Drupal::database()->select('a_city', 'c');
            $query->fields('c', ['city_id', 'city_name', 'state_id']);
            //$query->orderBy('title', 'ASC');
            $query->condition('state_id', array($var));
            $results = $query->execute()->fetchALL();
            switch ($var) {
                case 1:
                    $html = "Indea selected";

                    break;
                case 2:
                    $html = "aus sleceted";
                    break;
                case 3:
                    $html = "pakistan selected";
                    break;
                default:
                    $html = "nothing slected";
            }
            $dropdowncity = "<br><select class='citylistclass' id=cityid> <option value='select' slected>-Select City-</option>";

            foreach ($results as $res) {
                // $list[]=$res->state_name;            

                $dropdowncity.="<option value='" . $res->state_id . "'>" . $res->state_name . "<option>";
            }


            $dropdowncity.="</select>";
            $ajax_response->addCommand(new HtmlCommand('#edit-user-name--description', $text . ' -- welcome  -- ' . $html . $dropdowncity));
            return $ajax_response;
        }
    }

    public function usernameValidateCallback(array &$form, FormStateInterface $form_state) {
        // Instantiate an AjaxResponse Object to return.
        $ajax_response = new AjaxResponse();

        // Check if Username exists and is not Anonymous User (''). 
        if (user_load_by_name($form_state->getValue('user_name')) && $form_state->getValue('user_name') != false) {
            $text = 'User Found';
            $color = 'green';
        } else {
            $text = 'No User Found';
            $color = 'red';
        }
        ////

        if ($form_state->getValue('countries')) {
            $query = \Drupal::database()->select('a_state', 'c');
            $query->fields('c', ['state_id', 'state_name', 'country_id']);
            //$query->orderBy('title', 'ASC');
            $query->condition('country_id', array($form_state->getValue('countries')));
            $results = $query->execute()->fetchALL();
            $selectedCountry = $form_state->getValue('countries');

            $dropdownstate = "<select class='statelistclass' id=stateid> <option value='select' slelect='slected'>-Select State-</option>";
            // $dropdowncity="<br><select class='citylistclass' id=cityid> <option value='select' slected>-Select City-</option>";

            foreach ($results as $res) {
                $dropdownstate.="<option value='" . $res->state_id . "'>" . $res->state_name . "</option>";
            }
            $dropdownstate.="</select>";
        }
///
                


        // Add a command to execute on form, jQuery .html() replaces content between tags.
        // In this case, we replace the desription with wheter the username was found or not.
        $ajax_response->addCommand(new HtmlCommand('#edit-user-name--description', $text . ' -- welcome-- stae'. $form_state->getValue('states'). $selectedCountry . '--' . $dropdownstate));
        
        $ajax_response->addCommand(new ReplaceCommand('#edit-states',$dropdownstate));
        $ajax_response->addCommand(new AlertCommand($form_state->getValue('countries')));
        
                
        // CssCommand did not work.
        //$ajax_response->addCommand(new CssCommand('#edit-user-name--description', array('color', $color)));
        // Add a command, InvokeCommand, which allows for custom jQuery commands.
        // In this case, we alter the color of the description.
        $ajax_response->addCommand(new InvokeCommand('#edit-user-name--description', 'css', array('color', $color)));

        // Return the AjaxResponse Object.
        return $ajax_response;
    } 
}
            