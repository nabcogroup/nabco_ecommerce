<?php
/**
 * nabcofurn_us functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package nabcofurn_us
 */


add_action( 'after_setup_theme', 'nabco_furnitures_setup' );

if ( ! function_exists( 'nabco_furnitures_setup' ) ) {
    /**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function nabco_furnitures_setup() {
		
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on nabcofurn_us, use a find and replace
		 * to change 'nabco-furnitures' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'nabco-furnitures', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		
		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' 	=> esc_html__( 'Primary', 'nabco-furnitures' ),
			'footer'	=>	esc_html__('Footer','nabco-furnitures'),
		) );



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

	
		
	}
}


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function nabco_furnitures_content_width() {

	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'nabco_furnitures_content_width', 640 );
}


add_action( 'after_setup_theme', 'nabco_furnitures_content_width', 0 );




/*
	Preloading 
*/


function nabco_furnitures_css() {
	
?>
	<style>
		body {
			display:none;
		}

		
		#preloader {
    		position:fixed;
    		top:0;
    		left:0;
    		right:0;
    		bottom:0;
    		background-color:#fff; /* change if the mask should have another color then white */
    		z-index:9999999; /* makes sure it stays on top */
		}

		#status {
    		width:200px;
    		height:200px;
    		position:absolute;
    		left:50%;  
    		top:50%;  
    		background-image: url(<?php echo get_template_directory_uri() ?>/dist/imgs/preload.png);
    		background-repeat:no-repeat;
    		background-position:center;
    		margin:-100px 0 0 -100px; 
		}

	</style>
<?php
}

add_action('nabco_furnitures_style','nabco_furnitures_css');

function nabco_furnitures_pre_loading() {
?>
	<div id="preloader">
		<div id="status">&nbsp;</div>
	</div>
<?php
}

add_action('nabco_furniture_before_content','nabco_furnitures_pre_loading',10);

function nabco_furnitures_pre_loading_script() {
?>

<script>
	(function($) {
		$('#status').delay(1500).fadeOut('slow'); // will first fade out the loading animation
		$('#preloader').delay(600).fadeOut('slow'); // will fade out the white DIV that covers the website.
		$('body').fadeIn();
	})(jQuery)
</script>

<?php 	
}

add_action('nabco_furniture_after_content','nabco_furnitures_pre_loading_script',10);
