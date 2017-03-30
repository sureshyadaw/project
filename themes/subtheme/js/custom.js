(function ($) {
    "use strict";
    $(document).on('click', '#myid', function ()
    {

        $('<h1 style="color:green;">Textappended  on onclick event at id=frontpageid</h1>').appendTo('#frontpageId');
    });
})(jQuery);