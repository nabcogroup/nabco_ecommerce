<?php


function nabco_furniture_list_child_pages() { 
 
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
        $string = '<ul>'.$parent.$childpages.'</ul>';
    }
     
    return $string;
     
}
     
add_shortcode('nb_childpages', 'nabco_furniture_list_child_pages');


/** 
 * Short code modifier
*/
add_shortcode( 'nb_card', 'nb_explicit_card_wrapper' );

if(!function_exists('nb_explicit_card_wrapper')) {
	function nb_explicit_card_wrapper($atts,$content) {
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