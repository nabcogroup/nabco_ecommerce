<?php
/**
 * nabcofurn_us functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package nabcofurn_us
 */



require_once get_template_directory() . '/inc/class/team_dev_customizer.php';

require_once get_template_directory() . '/inc/class/class-wp-bootstrap-navwalker.php';

require_once get_template_directory() . '/inc/class/search_widget.php';

require get_template_directory() . '/inc/setup.php';

require get_template_directory() . '/inc/widgets.php';

require get_template_directory() . '/inc/enqueue.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Additional shortcode function
 */
require get_template_directory() . '/inc/short-code.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	
	require get_template_directory() . '/inc/nab-wc-setup.php';

	require_once get_template_directory() . '/inc/woocommerce/woocommerce-hook.php';

	require get_template_directory() . '/inc/woocommerce/wc-meta-product.php';
}
