<?php



//slider 
add_action('wp_footer','nabcofurnitures_slider_scripts');

//preloading theme
add_action('wp_footer','nabcofurnitures_pre_loading_scripts');
add_action('nabco_furnitures_style','nabcofurnitures_pre_loading_style');
add_action('nabco_furniture_before_content','nabcofurnitures_pre_loading',10);
add_action('nabco_furniture_before_page_loop','woocommerce_breadcrumb');
 /**
* 
* Hooked in menu-main filter
* Get all the products attached to that category
*/
add_filter('nb_menu_subnavigation_loop_args','nabcofurnitures_product_navigations',10);

/** 
 * 
 * Product collection hook 
*/
add_action('product-collection-loop','nabcofurnitures_collection_navigation');

/** 
 * Annoucement
*/
