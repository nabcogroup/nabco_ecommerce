<?php





/** 
 * PreLoading
 * @see nabcofurniture_pre_loading_scripts()
 * @see nabcofurniture_pre_loading_style()
 * @see nabcofurniture_pre_loading()
 * @see nabcofurniture_slider_scripts()
 * 
 */
add_action('wp_footer','nabcofurniture_pre_loading_scripts',10);
//add_action('nabco_furnitures_style','nabcofurniture_ganalytics',5);
add_action('nabco_furnitures_style','nabcofurniture_pre_loading_style',10);
add_action('nabco_furnitures_style','nabcofurniture_adjust_header',20);
add_action('nabco_furniture_before_content','nabcofurniture_pre_loading',10);
add_action('wp_footer','nabcofurniture_slider_scripts');

/** 
 * @see nabcofurniture_get_product_search()
*/
add_action('nabcofurniture_on_header_loop','nabcofurniture_get_product_search',10);

/** 
 * Theme Breadcrumb
 * @see woocommerce_breadcrumb() - woocommerce breadcrumb - woocommerce file
*/
add_action('nabco_furniture_before_page_loop','woocommerce_breadcrumb');

/** 
 *  Product collection hook 
 * @see nabcofurniture_collection_navigation()
*/
add_action('product-collection-loop','nabcofurniture_collection_navigation');

/** FILTERS */
add_filter('nabcofurniture_the_logo','nabcofurniture_get_logo',10);


/** 
 * SHORT CODES 
 * @see nabcofurniture_list_child_pages()
 * @see nabcofurniture_card_wrapper()
 */
add_shortcode('nb_childpages', 'nabcofurniture_list_child_pages');
add_shortcode( 'nb_card', 'nabcofurniture_card_wrapper' );
add_shortcode( 'nb_form_search', 'nabcofurniture_get_product_search' );