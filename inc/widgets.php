<?php


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */


 /**
 * Count number of widgets in a sidebar
 * Used to add classes to widget areas so widgets can be displayed one, two, three or four per row
 */
if ( ! function_exists( 'nabco_furnitures_slbd_count_widgets' ) ) {
	function nabco_furnitures_slbd_count_widgets( $sidebar_id ) {
		// If loading from front page, consult $_wp_sidebars_widgets rather than options
		// to see if wp_convert_widget_settings() has made manipulations in memory.
		global $_wp_sidebars_widgets;
		if ( empty( $_wp_sidebars_widgets ) ) :
			$_wp_sidebars_widgets = get_option( 'sidebars_widgets', array() );
		endif;

		$sidebars_widgets_count = $_wp_sidebars_widgets;

		if ( isset( $sidebars_widgets_count[ $sidebar_id ] ) ) :
			$widget_count = count( $sidebars_widgets_count[ $sidebar_id ] );
			$widget_classes = 'widget-count-' . count( $sidebars_widgets_count[ $sidebar_id ] );
			if ( $widget_count % 4 == 0 || $widget_count > 6 ) :
				// Four widgets per row if there are exactly four or more than six
				$widget_classes .= ' col-md-3';
			elseif ( 6 == $widget_count ) :
				// If two widgets are published
				$widget_classes .= ' col-md-2';
			elseif ( $widget_count >= 3 ) :
				// Three widgets per row if there's three or more widgets 
				$widget_classes .= ' col-md-4';
			elseif ( 2 == $widget_count ) :
				// If two widgets are published
				$widget_classes .= ' col-md-6';
			elseif ( 1 == $widget_count ) :
				// If just on widget is active
				$widget_classes .= ' col-md-12';
			endif; 
			return $widget_classes;
		endif;
	}
}


function nabco_furnitures_widgets_init() {
    
    
    register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'nabco-furnitures' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'nabco-furnitures' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Footer Full', 'nabco-furnitures' ),
		'id'            => 'footerfull',
		'description'   => 'Full sized footer widget with dynamic grid',
		'before_widget'  => '<div id="%1$s" class=" %2$s '. nabco_furnitures_slbd_count_widgets( 'footerfull' ) .' mb-3"  ><div class="card card-footer-wrapper">', 
		'after_widget'   => '</div></div><!-- .footer-widget -->', 
		'before_title'   => '<div class="card-header widget-title">', 
		'after_title'    => '</div>', 
	) );


	register_sidebar( array(
		'name'	=>	__('Item List','nabco-furnitures'),
		'id'	=>	'items',
		'description'   => 'Item List used in side bar on products',
		'before_widget'  => '<div id="%1$s" class="nab-group-items %2s ">', 
		'after_widget'   => '</div>', 
	));

	register_sidebar( array(
		'name'			=>	__('Sales Promotion Sidebar','nabco-furnitures'),
		'id'			=>	'sales-sidebar',
		'description'	=>	'Promotion side area',	
		'before_widget'	=>	'<div id="%1s" class="%2s">',
		'after_widget'	=>	'</div>'
	) );

	register_sidebar( array(
		'name'			=>	__('Social Sidebar ','nabco-furnitures'),
		'id'			=>	'social-sidebar',
		'description'	=>	'Social side area',	
		'before_widget'	=>	'<div id="%1s" class=social-handle-container %2s">',
		'after_widget'	=>	'</div>'
	) );
	
}


add_action( 'widgets_init', 'nabco_furnitures_widgets_init' );