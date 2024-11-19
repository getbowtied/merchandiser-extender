<?php

// Admin Notices
function merchandiser_extender_admin_notices_enqueue_scripts() {
   wp_enqueue_script( 'merchandiser-extender-admin-notices-js', plugins_url( 'js/admin_notices.js', __FILE__ ), array('jquery') );
   wp_enqueue_style( 'merchandiser-extender-admin-notices-css', plugins_url( 'css/admin_notices.css', __FILE__ ) );
}

function merchandiser_extender_admin_notices() {
   ?>

      <?php if ( !get_option('dismissed-merchandiser-3-3-notice', FALSE ) ) { ?>

      <div class="notice-error settings-error notice is-not-dismissible merchandiser_ext_notice merchandiser_3_3_notice">

         <div class="merchandiser_ext_notice__aside">
            <div class="merchandiser_icon" aria-hidden="true"><br></div>
         </div>
         
         <div class="merchandiser_ext_notice__content">

            <h3 class="title">⚠️ ACTION REQUIRED: Your Theme License Cannot Be Detected!</h3>

            <h4>Your active theme (Merchandiser) requires a valid license to function properly.</h4>

            <p>
                We've detected that your Merchandiser theme <em class="u_dotted">does not have a valid license</em>.
                <br />
                A valid license is required to receive theme updates, access support, and unlock all features.
            </p>

            <br />

            <p>
                <a href="https://getbowtied.net/spk-ext-wp-notice-check-license-status" target="_blank" class="button button-primary button-large">Activate License</a>
                &nbsp;
                <a href="https://getbowtied.net/spk-ext-wp-notice-get-another-license" target="_blank" class="button button-large">Purchase License</a>
            </p>

         </div>

      </div>

      <?php } ?>

   <?php
   }

   function merchandiser_extender_dismiss_dashboard_notice() {
      if ( $_POST['notice'] == 'merchandiser_3_3' ) {
         update_option('dismissed-merchandiser-3-3-notice', TRUE );
      }
   }

   if ( class_exists('Merchandiser') ) {
   
      // Admin Notices
      add_action( 'admin_enqueue_scripts', 'merchandiser_extender_admin_notices_enqueue_scripts' );
      add_action( 'admin_notices', 'merchandiser_extender_admin_notices' );
      add_action( 'wp_ajax_merchandiser_extender_dismiss_dashboard_notice', 'merchandiser_extender_dismiss_dashboard_notice' );
   
   }
