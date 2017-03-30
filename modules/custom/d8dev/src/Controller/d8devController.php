<?php 
/** * @file * @author My Name * Contains \Drupal\ d8dev\ Controller\ d8devController. 
* Please include this file under your * d8dev( module_root_folder)/ src/ Controller/ 
*/ 
namespace Drupal\d8dev\Controller; 
/** * Provides route responses for the d8dev module. */ 

use Drupal\Core\Controller\ControllerBase;

class d8devController extends ControllerBase { 
/** * Returns a simple page. * * @return array * A simple renderable array. */ 
public function myPage() {
    $element = array(
        '#type' => 'markup',
        '#markup' => 'Hello world!');
return $element; 

}
}
  