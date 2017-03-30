 jQuery(document).ready(function () {

    jQuery('a.like-link').click(function () {
        jQuery.ajax({
            type: 'POST', 
            url: this.href,
            dataType: 'json',
            success: function (data) {
                if(data.like_status == 0) {
                    jQuery('a.like-link').html('Like');
                }
                else {
                    jQuery('a.like-link').html('Delete Like');
                }

                jQuery('.total_count').html(data.total_count);
            },
            data: 'js=1' 
        });

        return false;
    });
});