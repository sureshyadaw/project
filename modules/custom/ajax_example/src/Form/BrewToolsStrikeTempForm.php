<?php
/**
 * @file
 * Contains \Drupal\brew_tools\Form\BrewToolsStrikeTempForm.
 */

namespace Drupal\ajax_example\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ChangedCommand;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\InvokeCommand;

class BrewToolsStrikeTempForm extends FormBase {
       /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return "strike_temp_form";
    }


    /**
     * {@inheritdoc}.
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
        $form = array(
          '#prefix' => '',
          '#suffix' => '',
        );
        $form['description'] = array(
          '#type' => 'item',
          '#title' => t('Calculate mash strike temperature.'),
        );

        $form['mash_temp'] = array(
          '#type' => 'textfield',
          '#title' => t('Desired mash temp'),
          '#required' => TRUE,
            // '#element_validate' => array('element_validate_integer_positive'),
        );
        $form['water_volume'] = array(
          '#type' => 'textfield',
          '#title' => t('Water volume in liters'),
          '#required' => TRUE,
        );
        $form['malt_weight'] = array(
          '#type' => 'textfield',
          '#title' => t('Weight of malt in kg'),
          '#required' => TRUE,
            // '#element_validate' => array('element_validate_number'),
        );
        $form['malt_temp'] = array(
          '#type' => 'textfield',
          '#title' => t('Temperature of malt'),
          '#required' => TRUE,
            //  '#element_validate' => array('element_validate_integer_positive'),
        );
        $form['strike_temp'] = array(
          '#title' => t('Strike water temperature should be'),
          '#type' => 'textfield',
          '#attributes' => array('readonly' => 'readonly'),
          '#value' => 0,
          '#prefix' => '',
          '#suffix' => '',
        );

// Adds a simple submit button that refreshes the form and clears its
// contents. This is the default behavior for forms.
        $form['submit'] = array(
          '#type' => 'submit',
          '#value' => 'Calculate',
          '#ajax' => array(
            'callback' => 'Drupal\brew_tools\Form\BrewToolsStrikeTempForm::addMoreCallback',
            'event' => 'click',
            'progress' => array(
              'type' => 'throbber',
              'message' => 'Getting Result',
            ),
          ),
        );
        $form['random_user']=array(
            '#type' => 'select',
            '#prefix' => '<div id=country style="color:red">',
	    '#suffix' => '</div>',
                    '#title' => $this->t('Select Country'),
                    '#options' => [
                                    '1' => $this->t('India'),  
                                    '2' => $this->t('sa'),
                                    '3' =>$this->t('aus')
                                  ],
//                    '#attributes' => array(
//                                'id' => 'targetElement',
//                              ),
                    '#ajax' =>array(
                        'callback' =>'addCountry',
                        'event' => 'change',
                        'progress' => array(
                        'type' => 'throbber',
                        'message' => 'Getting Result',
                        'wrapper' => 'display-dropdown',    
                         ),
                        ), );
                $form['country_dropdown']=array(
                    '#type' => 'select',
                    '#title' => $this->t('Country1'),                     
                    '#prefix' => '<div id="display-dropdown">',
                    '#suffix' => '</div>',
                     
                    );
                
        
        return $form;
    }

    public function addMoreCallback(array &$form, FormStateInterface $form_state) {
        $c = new \Drupal\brew_tools\Util\BrewToolsCalc();
        // Instantiate an AjaxResponse Object to return.
        $ajax_response = new AjaxResponse();
        $ajax_response->addCommand(new InvokeCommand('#edit-strike-temp', 'val', array($c->strikeTemp($form_state))));
        return $ajax_response;
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        $form_state->setRebuild(FALSE);
    }
    
    
    
    public function addCountry(array &$form, FormStateInterface $form_state) {
        
        echo '<script language="javascript">';
echo 'alert("message successfully sent")';
echo '</script>';
    // Instantiate an AjaxResponse Object to return.
    $ajax_response = new AjaxResponse();
    
    $query = db_select('a_city', 'c')
      ->fields('c', array('city_id','city_name'))       
      ->orderBy('title', 'ASC');
      $results = $query->execute()->fetchALL();
    
      //define rows
      $citylist = array();
      foreach ($results as $result) {
          $citylist[$result->city_id] = $result->city_name;
      }
      print_r($citylist);
      exit;
    
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
    $ajax_response->addCommand(new HtmlCommand('#edit-user-name--description', $text));
    
    // CssCommand did not work.
    //$ajax_response->addCommand(new CssCommand('#edit-user-name--description', array('color', $color)));
    
    // Add a command, InvokeCommand, which allows for custom jQuery commands.
    // In this case, we alter the color of the description.
    $ajax_response->addCommand(new InvokeCommand('#edit-user-name--description', 'css', array('color', $color)));
 
 // the ReplaceCommand will replace the contents of the provided element, with the string you send.
 
    $ajax_response->addCommand(new ReplaceCommand('#target-element', '<div>HELLO WORLD</div>'));
    
      /**
  * AddCssCommand
  * - This command will add inline css to the page.
  * # Note you will want to make sure that your css is inside of a <style> tag.
  */
 
    $ajax_response->addCommand(new CssCommand($css));
    
     /**
  * AfterCommand, is useful for calling the jquery After method.
  * This will insert the provided content after the provided id.
  */
  $ajax_response->addCommand(new AfterCommand('#targetElement', '<div> Hello After-world</div>'));
  
  //  It goes on like this pretty much for all fo the various commands.
  //  Take a look inside of core/lib/Drupal/Core/Ajax for all of the available commands that is provided out of the box.
  
    
    // Return the AjaxResponse Object.
    return $ajax_response;
  }
  function myModule_ajax_callback($node) {
   // Only render content and validates return
//  $content = is_string($page_callback_result) ? $page_callback_result :   drupal_render($page_callback_result);
//  $html = '' . drupal_get_css() . drupal_get_js() . '' . $content . '';
//  print $html;
//  drupal_page_footer();
    print 'hello';
  
//  $build = node_view($node);
//  $html = drpal_render($build);
//  $html ="<div class='hider' style='display:none;'>".html."</div>";
//commands = array();
//$commands[] = ajax_command_alert($node->title);
//$commands[] = ajax_command_html(#'ajax-content-wrapper',$html);
//$commands[] = ajax_command_replace(#'page-title',"<h1 id=''page-title'>".$node->title);
//$commands[] = ajax_command_invoke('.hider','fadeIn',array(500));


//paint ajax_render($commands)  

}

  
 
 
 
 
}

 
 