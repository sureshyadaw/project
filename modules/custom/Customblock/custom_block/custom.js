 (function ($) {
    Drupal.behaviors.myid.form = {
        attach: function (context, settings) {
            $('#myid_button').on('click', function(e) {
                e.preventDefault(); 
                alert("Eww");             
            }); 
        }
    };
})(jQuery);