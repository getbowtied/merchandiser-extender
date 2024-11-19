jQuery(function($) {

	"use strict";

	// dismiss dashboard notices
	$( document ).on( 'click', '.merchandiser_3_3_notice .notice-dismiss', function () {
		var data = {
            'action' : 'merchandiser_extender_dismiss_dashboard_notice',
            'notice' : 'merchandiser_3_3'
        };

        jQuery.post( 'admin-ajax.php', data );
	});
});
