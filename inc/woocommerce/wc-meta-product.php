<?php

add_filter( 'add_meta_boxes', 'nabco_furnitures_add_reservation_meta' );

function nabco_furnitures_add_reservation_meta() {
    
    $prefix = "__nabco__";

    add_meta_box( 'id', __( 'Reservation Period', 'nabco-furnitures' ), 'nabco_furnitures_add_custom_content_meta_box', 'product', 'normal', 'default');
    
}

//  Custom metabox content in admin product pages
if ( ! function_exists( 'nabco_furnitures_add_custom_content_meta_box' ) ){
    
    function nabco_furnitures_add_custom_content_meta_box( $post ){
        $prefix = '__nabco__'; // global $prefix;

        $ingredients = get_post_meta($post->ID, $prefix.'ingredients_wysiwyg', true) ? get_post_meta($post->ID, $prefix.'ingredients_wysiwyg', true) : '';
        $benefits = get_post_meta($post->ID, $prefix.'benefits_wysiwyg', true) ? get_post_meta($post->ID, $prefix.'benefits_wysiwyg', true) : '';
        
        $args['textarea_rows'] = 6;

        echo '<p>'.__( 'Ingredients', 'cmb' ).'</p>';
        
        echo '<input type="hidden" name="custom_product_field_nonce" value="' . wp_create_nonce() . '">';
    }
}