<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package storefront
 */

// WPCAMPUS HACK
do_action( 'storefront_content_bottom' );

?>

		</div><!-- .col-full -->
	</div><!-- #content -->

	<?php

	do_action( 'storefront_before_footer' );

	if ( function_exists( 'wpcampus_print_network_footer' ) ) {
		wpcampus_print_network_footer();
	}

	do_action( 'storefront_after_footer' );

	?>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
