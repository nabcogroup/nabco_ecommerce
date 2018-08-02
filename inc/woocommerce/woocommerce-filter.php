<?php


/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */

function nabco_furnitures_woocommerce_active_body_class( $classes ) {
    
    $classes[] = 'woocommerce-active';
    
    return $classes;
}

add_filter( 'body_class', 'nabco_furnitures_woocommerce_active_body_class' );


/**
 * Products per page.
 *
 * @return integer number of products.
 */
function nabco_furnitures_woocommerce_products_per_page() {

	return 12;

}

add_filter( 'loop_shop_per_page', 'nabco_furnitures_woocommerce_products_per_page' );


/******************************************************************************
 * Remove default WooCommerce wrapper.
 ********************************************************************************/
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'nabco_furnitures_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function nabco_furnitures_woocommerce_wrapper_before() {
?>
        <!-- primary -->
        <div id="primary" class="content-area container woocommerce-page-wrapper">
<?php
	}
}

add_action( 'woocommerce_before_main_content', 'nabco_furnitures_woocommerce_wrapper_before' );


if ( ! function_exists( 'nabco_furnitures_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function nabco_furnitures_woocommerce_wrapper_after() {
			?>
		</div><!-- #primary -->
		<?php
	}
}

add_action( 'woocommerce_after_main_content', 'nabco_furnitures_woocommerce_wrapper_after' );


/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function nabco_furnitures_woocommerce_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => 3,
		'columns'        => 3,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}

add_filter( 'woocommerce_output_related_products_args', 'nabco_furnitures_woocommerce_related_products_args' );



if(! function_exists('nabco_catalog_orderby')) {
    
    function nabco_catalog_orderby($args) {
        return array(
            'price'         =>  __('Sort by price: low to high','woocommerce'),
            'price-desc'    =>  __('Sort by price: high to low','woocommerce'),
            'date'          =>  __('Sort by new arrival','woocommerce'),
        );
    }
}




if ( ! function_exists( 'nabco_template_loop_product_thumbnail' ) ) {
     function nabco_template_loop_product_thumbnail() {
         echo nabco_get_product_thumbnail();
     } 
}


if ( ! function_exists( 'nabco_get_product_thumbnail' ) ) {   
    function nabco_get_product_thumbnail( $size = 'shop_catalog' ) {

        global $post, $woocommerce;
        $size = 'medium';
        $output = "";
        if ( has_post_thumbnail() ) {               
            $output .= get_the_post_thumbnail( $post->ID, $size,["class" => "card-img-top"] );
        } 
        else {

             //$output .= wc_placeholder_img( $size );
             // Or alternatively setting yours width and height shop_catalog dimensions.
             $output .= '<img src="' . woocommerce_placeholder_img_src() . '" alt="Placeholder" class="card-img-top" />';
        }                       
        
        return $output;
    }
}



function nabco_template_loop_product_title() {
    echo "<p class='product-title'>" . get_the_title() . "</p>";
}


function nabco_breadcrums() {
    
    return array(
            'delimiter'   => ' » ',
            'wrap_before' => '<nav class="woocommerce-breadcrumb" itemprop="breadcrumb">',
            'wrap_after'  => '</nav>',
            'before'      => '',
            'after'       => '',
            'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' ),
    );

}





