  
//var delicious = (function ()
//{ /** * Pubic object. * @type {{}} */
//var self = {};
//
///** * The delicious recipe content. * * @type {jQuery} */
//var $deliciousContent = jQuery('.delicious-content');
//        /** * Bind the recipe content click event. */ 
//        var bindRecipeContentEvent = function () {
//            $deliciousContent.on(' click', function () { deliciousAlert(); }); 
//        }; 
// var deliciousAlert = function () 
// { window.alert( Drupal.t(" This is delicious!"));
// };
// /** * Page load event. */ 
// self.onPageLoad = function () {
//     bindRecipeContentEvent(); };
// return self;}(jQuery( delicious.onPageLoad))
//
//
//jQuery(document).ready(function($) {
//  
//});
//$( "#target" ).click(function() {
//  alert( "Handler for .click() called." );
//});

 
   
//(function ($, Drupal) {
//  Drupal.behaviors.myModuleBehavior = {
//    attach: function (context, settings) {
//     // Using once() to apply the myCustomBehaviour effect when you want to do just run one function.
//    $(context).find('input.myCustomBehavior').once('myCustomBehavior').addClass('processed');
//
//    // Using once() with more complexity.
//    $(context).find('input.myCustom').once('mySecondBehavior').each(function () {
//      if ($(this).visible()) {
//          $(this).css('background', 'green');
//      }
//      else {
//        $(this).css('background', 'yellow').show();
//      }
//    });
//    }
//  };
//})(jQuery, Drupal);


//(function ($) {
//  "use strict";
//
//  // Delegates links that are really "actions" (buttons) in the dropdown menu
//  // to the actual button so it can actually submit the form.
//  $(document).on('click', 'a[data-target="dropdown-button"]', function (e) {
//    e.preventDefault();
//    e.stopPropagation();
//    $(this).parent().find('button').trigger('click');
//  });
//
//  // Handle buttons that used to be dropbutton links.
//  // @see \Drupal\bootstrap\Plugin\Preprocess\BootstrapDropdown::preprocessLinks
//  $(document).on('click',function () { 
//    }
//  });
//
//})(jQuery);
//
//jQuery(document).on('click', '#myid', function(e){alert();});

(function ($) {
    "use strict";
    $(document).on('click', '#myid', function (e) {
        alert('onclick with id=myid btn triggred');
    });

})(jQuery);