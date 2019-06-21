<?php

/**
 * Setup the theme:
 *
 * - Load the textdomain.
 * - Enable network elements.
 */
function wpcampus_shop_setup_theme() {
	global $storefront;

	// Load the textdomain.
	load_theme_textdomain( 'wpcampus-shop', get_stylesheet_directory() . '/languages' );

	// Enable network banner.
	if ( function_exists( 'wpcampus_enable_network_banner' ) ) {
		wpcampus_enable_network_banner();
	}

	// Enable network notifications.
	if ( function_exists( 'wpcampus_enable_network_notifications' ) ) {
		wpcampus_enable_network_notifications();
	}

	// Enable network footer.
	if ( function_exists( 'wpcampus_enable_network_footer' ) ) {
		wpcampus_enable_network_footer();
	}

	// Remove default footer actions so we can replace with our footer.
	remove_all_actions( 'storefront_footer' );

}
add_action( 'after_setup_theme', 'wpcampus_shop_setup_theme', 1 );

/**
 * Make sure the Open Sans
 * font weights we need are added.
 */
function wpcampus_shop_load_open_sans_weights( $weights ) {
	return array_merge( $weights, array( 400, 600, 700 ) );
}
add_filter( 'wpcampus_open_sans_font_weights', 'wpcampus_shop_load_open_sans_weights' );

/**
 * Setup styles and scripts.
 */
function wpcampus_shop_enqueue_styles_scripts() {

	// Get the directory.
	$wpcampus_assets_dir = trailingslashit( get_stylesheet_directory_uri() ) . 'assets/';

	// Remove the child styles added by Storefront.
	wp_dequeue_style( 'storefront-child-style' );

	// Enqueue the base styles.
	wp_enqueue_style( 'wpcampus-shop', $wpcampus_assets_dir . 'css/wpcampus-shop.min.css', array( 'storefront-style' ) ); //null, 'all' );

}
add_action( 'wp_enqueue_scripts', 'wpcampus_shop_enqueue_styles_scripts', 1000 );

/**
 * Overite Storefront's site logo markup.
 */
function storefront_site_branding() {

	// Get the images directory.
	$wpcampus_images_dir = trailingslashit( get_stylesheet_directory_uri() ) . 'assets/images/';

	?>
	<div class="site-branding">
		<?php

		// Setup the image.
		//$logo = '<img width="960" height="110" src="https://shop.wpcampus.org/wp-content/uploads/sites/9/2018/06/cropped-wpcampus-shop-header-1.png" class="custom-logo" alt="WPCampus Shop" itemprop="logo" srcset="https://shop.wpcampus.org/wp-content/uploads/sites/9/2018/06/cropped-wpcampus-shop-header-1.png 960w, https://shop.wpcampus.org/wp-content/uploads/sites/9/2018/06/cropped-wpcampus-shop-header-1-300x34.png 300w, https://shop.wpcampus.org/wp-content/uploads/sites/9/2018/06/cropped-wpcampus-shop-header-1-768x88.png 768w, https://shop.wpcampus.org/wp-content/uploads/sites/9/2018/06/cropped-wpcampus-shop-header-1-416x48.png 416w" sizes="(max-width: 960px) 100vw, 960px">';
		$logo = '<img alt="Shop WPCampus: Where WordPress meets higher education" src="' . $wpcampus_images_dir . 'wpcampus-shop-header.png">';

		// Wrap in a link.
		$logo = '<a href="/" class="custom-logo-link" rel="home" itemprop="url">' . $logo . '</a>';

		if ( is_home() || is_front_page() ) :
			?>
			<h1 class="logo"><?php echo $logo; ?></h1>
			<?php
		else :
			echo $logo;
		endif;

		?>
	</div>
	<?php
}

/**
 * Don't show thumbnails on page headers.
 */
function storefront_page_header() {
	?>
	<header class="entry-header">
		<?php
		//storefront_post_thumbnail( 'full' );
		the_title( '<h1 class="entry-title">', '</h1>' );
		?>
	</header><!-- .entry-header -->
	<?php
}

/**
 * Hide the page title on the home page.
 */
function wpcampus_shop_show_page_title( $show ) {
	if ( is_home() || is_front_page() ) {
		return false;
	}
	return $show;
}
add_filter( 'woocommerce_show_page_title', 'wpcampus_shop_show_page_title' );

/**
 * Remove the Storefront/WooCommerce footer credit.
 */
function wpcampus_shop_remove_storefront_credit() {
	return false;
}
add_filter( 'storefront_credit_link', 'wpcampus_shop_remove_storefront_credit' );

/**
 * Print network banner.
 */
function wpcampus_shop_print_network_banner() {
	if ( function_exists( 'wpcampus_print_network_banner' ) ) {
		wpcampus_print_network_banner( array(
			'skip_nav_id' => 'main',
		));
	}
}
add_action( 'storefront_before_site', 'wpcampus_shop_print_network_banner' );

/**
 * Print our stickers panel.
 */
function wpcampus_shop_print_sticker_panel() {
	?>
	<div class="panel royal-blue center wpc-stickers">
		<?php printf( __( '%1$sVisit our %2$s marketplace%3$s to order %4$s stickers.', '' ), '<a href="https://www.stickermule.com/user/1070667397/stickers">', 'stickermule', '</a>', 'WPCampus' ); ?>
	</div>
	<?php
}

/**
 * Add our sticker message to the top of the shop page.
 */
function wpcampus_shop_add_sticker_panel() {

	if ( is_post_type_archive( 'product' ) ) {
		wpcampus_shop_print_sticker_panel();
	}
}
add_action( 'storefront_content_top', 'wpcampus_shop_add_sticker_panel' );

/**
 * Add the Mailchimp signup form to bottom of all content.
 */
function wpcampus_shop_add_mailchimp_to_content() {
	if ( function_exists( 'wpcampus_print_mailchimp_signup' ) ) {
		wpcampus_print_mailchimp_signup();
	}
}
add_action( 'storefront_content_bottom', 'wpcampus_shop_add_mailchimp_to_content' );

/**
 * Print network notifications.
 */
function wpcampus_shop_print_network_notifications() {
	if ( function_exists( 'wpcampus_print_network_notifications' ) ) {
		wpcampus_print_network_notifications();
	}
}
add_action( 'storefront_before_content', 'wpcampus_shop_print_network_notifications' );

function wpcampus_thankyou( $thankyoutext, $order ) {
	$added_text = $thankyoutext . '<p>You should receive an email confirmation. Make sure you check your Spam or Junk Mail folders if you don't see it.</p>';
	return $added_text ;
}
add_filter( 'woocommerce_thankyou_order_received_text', 'wpcampus_thankyou', 10, 2 );
