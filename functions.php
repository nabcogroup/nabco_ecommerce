<?php
/**
 * nabcofurn_us functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package nabcofurn_us
 */


//include
require get_template_directory() . '/inc/class/team_dev_customizer.php';	//customize control helper

require get_template_directory() . '/inc/components/navigation/class-nb-mainmenu.php';				//main navigation
require get_template_directory() . '/inc/components/navigation/class-wp-bootstrap-navwalker.php';	//main navigation
require get_template_directory() . '/inc/components/widgets/class-widget-setup.php'; 				//register sidebar widget
require get_template_directory() . '/inc/components/widgets/search-widget.php';	    				//search in the header		

require get_template_directory() . '/inc/customizer/class-nab-frontpage-customizer.php'; //Customizer additions.

/**
 * Theme Setup
 */
require get_template_directory() . '/inc/theme/theme-helper.php';
require get_template_directory() . '/inc/theme/class-theme-setup.php';
require get_template_directory() . '/inc/theme/template-tags.php';
require get_template_directory() . '/inc/theme/theme-function.php';
//require get_template_directory() . '/inc/theme/short-code.php'; 	//shortcode;
require get_template_directory() . '/inc/theme/theme-hook.php'; 	//theme hook 	


/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce/class-nb-wc-setup.php';
}

