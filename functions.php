<?php

/**
 * Only certain people can see the site
 * while we set things up.
 *
 * Using a lower priority 'parse_request'
 * because that's where 'REST_REQUEST' is defined.
 *
 * @TODO:
 * - Remove before launch.
 */
add_action( 'parse_request', function() {

	// Ignore on the login page.
	if ( 'wp-login.php' == $GLOBALS['pagenow'] ) {
		return;
	}

	// Ignore on the REST API. We need for Printful.
	if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
		return;
	}

	// For login.
	if ( ! is_user_logged_in() ) {
		auth_redirect();
	}

	// Only certain users can view.
	if ( ! current_user_can( 'manage_wpcampus_shop' ) ) {
		wp_safe_redirect( 'https://wpcampus.org' );
		exit;
	}
}, 100 );
