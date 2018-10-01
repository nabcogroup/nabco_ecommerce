<?php


function nabco_furnitures_list_child_pages() { 
 
    global $post; 
    $parent = "";
    if ( is_page() && $post->post_parent ) {
        $childpages = wp_list_pages( 'sort_column=menu_order&title_li=&child_of=' . $post->post_parent . '&echo=0' );
        
        $parent = "<li><a href='". get_the_permalink($post->post_parent)."'>".get_the_title($post->post_parent)."</a></li>";
    }
    else {
        $childpages = wp_list_pages( 'sort_column=menu_order&title_li=&child_of=' . $post->ID . '&echo=0' );

        $parent = "<li><a class='parent' href='". get_the_permalink($post->ID)."'>". get_the_title($post->ID) ."</a></li>";
        

    }
    
    
    //include parent

    $string =  "";
    if ( $childpages ) {
        $string = '<ul class="float-right">'.$parent.$childpages.'</ul>';
    }
     
    return $string;
     
}
     
add_shortcode('nb_childpages', 'nabco_furnitures_list_child_pages');


/** 
 * Short code modifier
*/
add_shortcode( 'nb_card', 'nabco_furnitures_card_wrapper' );

if(!function_exists('nabco_furnitures_card_wrapper')) {
	function nabco_furnitures_card_wrapper($atts,$content) {
		$a = shortcode_atts( array(
			'col'	=> '',
			'title' => 'title',
			'content' => 'content',
		), $atts );

		if($a['col'] != '') 
			$output = '<!-- column start --><div class="col-md-'. esc_attr($a['col'])  .'">';
		else
			$output = '';
        
        $output .= "<blockquote class='wp-block-quote'>";
        $output .= "<h2>". $a['title'] ."</h2>";
        $output .= "<cite>" . $content ."</cite>";

		if($a['col'] != '') $output = $output . '</div><!-- end of column -->';
		return $output;

	}
}

add_shortcode( 'nb_form_search', 'nabco_furnitures_product_form_search' );

if(!function_exists('nabco_furnitures_product_form_search')) {
    
    function nabco_furnitures_product_form_search() {
        
        $output =   '<form class="form-horizontal nb-form" style="display:block;" method="get" action="'.esc_url( home_url( '/' ) ).'">';
        $output .=  '<div class="col-md-12">';
        $output .=  '<div class="input-group">';
        $output .=  '<input type="text" id="woocommerce-product-search-field-0" 
                    class="form-control" placeholder="'. __( 'Search products&hellip;', 'woocommerce' ) .'" 
                    aria-label="Search" name="s" 
                    value="'. get_search_query() .'">';
        $output .=  '<input type="hidden"   name="post_type" value="product" />';
        $output .=  '<div class="input-group-append">';
        $output .=  '<button class="input-group-text btn btn-primary" id="basic-addon1" type="submit"><i class="fa fa-search"></i></button>';
        $output .=  '</div>';
        $output .=  '</div>';
        $output .=  '</div>';
        $output .=  '</form>';

        return $output;

    }
}