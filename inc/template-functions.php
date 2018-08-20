<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package nabcofurn_us
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function nabco_furnitures_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'nabco_furnitures_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function nabco_furnitures_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}

add_action( 'wp_head', 'nabco_furnitures_pingback_header' );




/**
 * 
 * Hooked in menu-main filter
 * Get all the products attached to that category
*/
add_filter('nb_menu_subnavigation_loop_args','nabco_furnitures_product_navigation',10);

function nabco_furnitures_product_navigation($args) {
		
	$theProducts = new WP_Query($args);
	$productArgs = [];

	if($theProducts->have_posts()) {

		while($theProducts->have_posts()) {

			$theProducts->the_post();

			$productArg = array(
				'permalink' =>  get_the_permalink(),
				'title'     =>  get_the_title()
			);

			//get the product information
			array_push($productArgs,$productArg);
			
		}
	}
	
	wp_reset_postdata();

	return $productArgs;
}


//menu filter
add_filter( 'products_list_args', 'nabco_furnitures_product_menu', 10,2);

function nabco_furnitures_product_menu($categories,$imageArgs) {

	$html = "<!-- product wrapper --> <div class='nb-wc-product-menu-wrapper'>";
	
	foreach($categories as $key => $category) {
		$html .= "<nav id='product_catkey_{$key}' class='nb-wc-menu-product category-{$key}'>"; 
		$html .= "<div class='row'>";

		$html .= "<!-- products column --><div class='col-md-4'>";
		$html .= "<ul>";
		
		foreach($category as $item) {
			$html .= "<li><a href='" . $item['permalink']. "' class='nb-product-navlink'>" .  $item['title'] . "</a></li>";
		}
		$html .= "</ul>"; 
		$html .= "</div><!--end -->";

		$html .= "<!-- image column --><div class='col-md-8'>";
		$html .= $imageArgs[$key];
		$html .= "</div><!--end image column -->";
		$html .= "</div>";
		$html .= "</nav>";
	}

	$html .= "</div><!--end -->";

	return $html;
}
