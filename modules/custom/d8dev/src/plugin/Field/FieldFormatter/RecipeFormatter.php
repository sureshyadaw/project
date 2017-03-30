<?php 
 /** * @file  
  * * Contains \Drupal\ d8dev\ Plugin\ field\ formatter\ RecipeFormatter. 
  */ 
namespace Drupal\ d8dev\ Plugin\ Field\ FieldFormatter; 

use Drupal\Core\Field\FormatterBase; 
use Drupal\Core\Field\FieldItemListInterface;

/** 
 *  Plugin implementation of the 'recipe_time' formatter. 
 *  @FieldFormatter(
 *  id = "recipe_time",
 *  label=@Translation("Duration"),
 * field_types={
 * "integer",
 * "decimal",
 * "float"
 * }
 * ) 
 */
 
 class RecipeFormatter extends FormatterBase
 {
     public function viewElements(FieldItemListInterface $items,$language) {
         $elements = array();
         foreach($items as $delta =>$item)
         {
             //$hours = $items->value;
             $hours = floor($item->value/60);
             $minutes = $item->value % 60;

             $minutes_gcd = gcd($minutes,60);

             // '#theme' => 'recipe_time_display', 
             // &frasl; is the html entity for the fraction separator, we use the sup and sub html
             '< sup >' . $minutes/ $minutes_gcd .' </ sup >& frasl;'
                     . ' < sub >' . 60/$minutes_gcd . '</ sub >';
             $minutes_fraction = $minutes/ $minutes_gcd ."/" . 60/$minutes_gcd ;
             $markup = $hours > 0?$hours . ' and ' . $minutes_fraction . ' hours' : $minutes_fraction . ' hours';
             $elements[$delta] = array('#theme' => 'd8dev_time_display','#value' => $markup);
 
             
         }
         return $elements;
     
     }
 }
 function gcd($num1,$num2) {
               
               
              while ($num2 != 0){
     $t = $num1 % $num2;
     $num1 = $num2;
     $num2 = $t;
   }
   return $num1;
             }

 