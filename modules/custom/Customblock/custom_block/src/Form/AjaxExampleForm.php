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
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;



            

            

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
            '#prefix' => '<div id=state style="color:green">',
	    '#suffix' => '</div>',
             '#title' => $this->t('Select State'),
             '#options' =>$statelist,
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
         '#title' =>'testing' 
          
      );
      
    
    /*$form['random_user'] = array(
      '#type' => 'button',
      '#value' => 'Random Username',
      '#ajax' => array(
        'callback' => 'Drupal\ajax_example\Form\AjaxExampleForm::randomUsernameCallback',
        'event' => 'click',
        'progress' => array(
          'type' => 'throbber',
          'message' => 'Getting Random Username',
        ),
        
      ),
    );*/


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

            $dropdownstate = "<br><select class='statelistclass' id=stateid> <option value='select' slelect='slected'>-Select State-</option>";
            // $dropdowncity="<br><select class='citylistclass' id=cityid> <option value='select' slected>-Select City-</option>";

            foreach ($results as $res) {
                $dropdownstate.="<option value='" . $res->state_id . "'>" . $res->state_name . "</option>";
            }
            $dropdownstate.="</select>";
        }
///
        $globals[statelist] = $dropdownstate;


        // Add a command to execute on form, jQuery .html() replaces content between tags.
        // In this case, we replace the desription with wheter the username was found or not.
        $ajax_response->addCommand(new HtmlCommand('#edit-user-name--description', $text . ' -- welcome-- ' . $selectedCountry . '--' . $dropdownstate));
        $ajax_response->addCommand(new ReplaceCommand('#slected_state_id_wrapper', $text . ' -- welcome ' . $selectedCountry . '--' . $dropdownstate));
        //$ajax_response->addCommand(new ajax_command_alert('hellos'));
        // CssCommand did not work.
        //$ajax_response->addCommand(new CssCommand('#edit-user-name--description', array('color', $color)));
        // Add a command, InvokeCommand, which allows for custom jQuery commands.
        // In this case, we alter the color of the description.
        $ajax_response->addCommand(new InvokeCommand('#edit-user-name--description', 'css', array('color', $color)));

        // Return the AjaxResponse Object.
        return $ajax_response;
    }

    public function randomUsernameCallback(array &$form, FormStateInterface $form_state) {
        // Get all User Entities.
        $all_users = entity_load_multiple('user');

        // Remove Anonymous User.
        array_shift($all_users);

        // Pick Random User.
        $random_user = $all_users[array_rand($all_users)];

        // Instantiate an AjaxResponse Object to return.
        $ajax_response = new AjaxResponse();

        // ValCommand does not exist, so we can use InvokeCommand.
        $ajax_response->addCommand(new InvokeCommand('#edit-user-name', 'val', array($random_user->get('name')->getString())));

        // ChangedCommand did not work.
        //$ajax_response->addCommand(new ChangedCommand('#edit-user-name', '#edit-user-name'));
        // We can still invoke the change command on #edit-user-name so it triggers Ajax on that element to validate username.
        $ajax_response->addCommand(new InvokeCommand('#edit-user-name', 'change'));

        // Return the AjaxResponse Object.
        return $ajax_response;
    }

    public function addCountry(array &$form, FormStateInterface $form_state) {


        $countrylist = array(
            '1' => 'https://www.youtube.com/watch?v=IkyvYdTCZDs',
            '2' => 'http://drupal.stackexchange.com/questions/193540/drupal-8-custom-block-with-html-and-javascript',
            '3' => 'https://www.sitepoint.com/building-drupal-8-module-blocks-forms/');

        if (!$form_state->getValue['countries'] && empty($form_state->getValue['countries'])) {
            $country = $form_state['countries'];
            $url = $countrylist[$country];
            $html = "<img src='$url' width='200'/>";
        }





//        
//        $query = \Drupal::database()->select('node_field_data', 'u');
//            $query->fields('u', ['nid','type', 'title']);
//            $query->condition('u.type', 'image_gallery'); 
//            $result= ($query->execute()->fetchAll());
//            print('add country');
//        
//        echo '<script language="javascript">';
//echo 'alert("message successfully sent")';
//echo '</script>';
//    // Instantiate an AjaxResponse Object to return.
        $ajax_response = new AjaxResponse();

//    $query = db_select('a_city', 'c')
//      ->fields('c', array('city_id','city_name'))       
//      ->orderBy('title', 'ASC');
//      $results = $query->execute()->fetchALL();
//    
//      //define rows
//      $citylist = array();
//      foreach ($results as $result) {
//          $citylist[$result->city_id] = $result->city_name;
//      }
//      print_r($citylist);
//      exit;
        // Check if Username exists and is not Anonymous User (''). 
        //user_load_by_name($form_state->getValue('user_name')) && $form_state->getValue('user_name') != false
        if (1) {
            $text = 'User Found';
            $color = 'green';
            $css = ['border' => '1px solid red'];
        } else {
            $text = 'No User Found';
            $color = 'red';
        }
        $ajax_response->ajax_command_alert('hellos');
        // Add a command to execute on form, jQuery .html() replaces content between tags.
        // In this case, we replace the desription with wheter the username was found or not.
        $ajax_response->addCommand(new HtmlCommand('#edit-user-name--description', $text . ' -- ' . $html));
//    
//    // CssCommand did not work.
//    //$ajax_response->addCommand(new CssCommand('#edit-user-name--description', array('color', $color)));
//    
//    // Add a command, InvokeCommand, which allows for custom jQuery commands.
//    // In this case, we alter the color of the description.
//    $ajax_response->addCommand(new InvokeCommand('#edit-user-name--description', 'css', array('color', $color)));
// 
// // the ReplaceCommand will replace the contents of the provided element, with the string you send.
// 
//    $ajax_response->addCommand(new ReplaceCommand('#target-element', '<div>HELLO WORLD</div>'));
//    
//      /**
//  * AddCssCommand
//  * - This command will add inline css to the page.
//  * # Note you will want to make sure that your css is inside of a <style> tag.
//  */
// 
//    $ajax_response->addCommand(new CssCommand($css));
//    
//     /**
//  * AfterCommand, is useful for calling the jquery After method.
//  * This will insert the provided content after the provided id.
//  */
//  $ajax_response->addCommand(new AfterCommand('#targetElement', '<div> Hello After-world</div>'));
//  
//  //  It goes on like this pretty much for all fo the various commands.
//  //  Take a look inside of core/lib/Drupal/Core/Ajax for all of the available commands that is provided out of the box.
        // Return the AjaxResponse Object.
        return $ajax_response;
    }

}
            