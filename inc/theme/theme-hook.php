<?php



//slider 
add_action('wp_footer','nabcofurnitures_slider_scripts');

//preloading theme
add_action('wp_footer','nabcofurnitures_pre_loading_scripts');
add_action('wc_print_styles','nabcofurnitures_pre_loading_style');
add_action('nabcofurniture_before_content','nabcofurnitures_pre_loading',10);

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