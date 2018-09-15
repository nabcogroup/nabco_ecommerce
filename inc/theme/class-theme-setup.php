<?php



if ( ! function_exists( 'nabco_furnitures_header_style' ) ) {
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see nabco_furnitures_custom_header_setup().
	 */
	function nabco_furnitures_header_style() {
        
        $header_text_color = get_header_textcolor();
        
		/*
		 * If no custom options for text are set, let's bail.
		 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
		 */
		if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
			return;
        }
        
        echo "<style type='text/css'>";
        if(!display_header_text()) {
            echo ".site-title,";
			echo ".site-description {position: absolute; clip: rect(1px, 1px, 1px, 1px);}";
        }
        else {
            echo ".site-title a,.site-description { color: ".  esc_attr( $header_text_color ) ."}";
        }
        echo "</style>";

    }
}

class Nab_ThemeSetup {


    public function __construct() {

        add_action( 'wp_enqueue_scripts', array($this,'enqueue') );
        add_action( 'after_setup_theme', array($this,'contentWidth'), 0 );
        add_action( 'after_setup_theme', array($this,'setup') );

    }


    public function setup() {

        /*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on nabcofurn_us, use a find and replace
		 * to change 'nabco-furnitures' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'nabco-furnitures', get_template_directory() . '/languages' );

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus( array(
            'primary' 		=> 	esc_html__( 'Primary', 'nabco-furnitures' ),
            'footer'		=>	esc_html__('Footer','nabco-furnitures'),
            'collection'	=>	esc_html__('Collection','nabco-furnitures')
        ) );
        
		/*
        * Let WordPress manage the document title.
        * By adding theme support, we declare that this theme does not use a
        * hard-coded <title> tag in the document head, and expect WordPress to
        * provide it for us.
        */
		add_theme_support( 'title-tag' );
        
		// Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );
        
		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'nabco_furnitures_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );

		
		//add image size
		add_image_size('front-page-thumb', 420, 315);	
    }

    public function enqueue() {
         
	    wp_enqueue_style( 'nabco-furnitures-style', get_template_directory_uri() . '/dist/css/theme.css' );
	    wp_enqueue_script( 'nabco-furnitures-theme', get_template_directory_uri() . '/dist/js/theme.min.js',array(), '20151215' ,true );
	
	
	    //wp_enqueue_script( 'nabco-furnitures-navigation', get_template_directory_uri() . '/dist/js/navigation.js', array(), '20151215', true );

        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }
    }

    public function customHeader() {

        add_theme_support( 'custom-header', apply_filters( 'nabco_furnitures_custom_header_args', array(
            'default-image'          => '',
            'default-text-color'     => '000000',
            'width'                  => 1000,
            'height'                 => 250,
            'flex-height'            => true,
            'wp-head-callback'       => 'nabco_furnitures_header_style',
        ) ) );
    }

    public function contentWidth() {
        // This variable is intended to be overruled from themes.
	    // Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	    // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	    $GLOBALS['content_width'] = apply_filters( 'nabco_furnitures_content_width', 640 );
    }
}

return new Nab_ThemeSetup();