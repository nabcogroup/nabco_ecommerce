<?php

/**
 * Enqueue scripts and styles.
 */
function nabco_furnitures_scripts() {
    
    
	wp_enqueue_style( 'nabco-furnitures-style', get_template_directory_uri() . '/dist/css/theme.css' );

	wp_enqueue_script( 'nabco-furnitures-theme', get_template_directory_uri() . '/dist/js/theme.min.js',array(), '20151215' ,true );
	wp_enqueue_script( 'nabco-furnitures-navigation', get_template_directory_uri() . '/dist/js/navigation.js', array(), '20151215', true );
	wp_enqueue_script('nabco-furnitures-ui',get_template_directory_uri() . '/js/jquery-ui/jquery-ui.min.js', array(), '20151215', true );
	wp_enqueue_script('nabco-furnitures-flash',get_template_directory_uri() . '/js/AC_RunActiveContent.js', array(), '20151215', false );
	

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'nabco_furnitures_scripts' );