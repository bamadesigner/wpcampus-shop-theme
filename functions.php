<?php

/**
 * Only certain people can see the site
 * while we set things up.
 *
 * @TODO:
 * - Remove before launch.
 */
add_action( 'init', function() {

	// Ignore on the login page.
	if ( 'wp-login.php' == $GLOBALS['pagenow'] ) {
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
});
