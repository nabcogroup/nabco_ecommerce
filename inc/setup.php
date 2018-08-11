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
	
	if(is_customize_preview()) { return false; }
?>
	<style>

		@-webkit-keyframes spin {
			0%   { 
				-webkit-transform: rotate(0deg);  /* Chrome, Opera 15+, Safari 3.1+ */
				-ms-transform: rotate(0deg);  /* IE 9 */
				transform: rotate(0deg);  /* Firefox 16+, IE 10+, Opera */
			}
			100% {
				-webkit-transform: rotate(360deg);  /* Chrome, Opera 15+, Safari 3.1+ */
				-ms-transform: rotate(360deg);  /* IE 9 */
				transform: rotate(360deg);  /* Firefox 16+, IE 10+, Opera */
			}
		}
		@keyframes spin {
			0%   { 
				-webkit-transform: rotate(0deg);  /* Chrome, Opera 15+, Safari 3.1+ */
				-ms-transform: rotate(0deg);  /* IE 9 */
				transform: rotate(0deg);  /* Firefox 16+, IE 10+, Opera */
			}
			100% {
				-webkit-transform: rotate(360deg);  /* Chrome, Opera 15+, Safari 3.1+ */
				-ms-transform: rotate(360deg);  /* IE 9 */
				transform: rotate(360deg);  /* Firefox 16+, IE 10+, Opera */
			}
		}
		
		#nb-loader-wrapper {
			position: fixed;
    		top: 0;
    		left: 0;
    		width: 100%;
    		height: 100%;
    		z-index: 1000;
		}

		#nb-loader {
    		display: block;
    		position: relative;
    		left: 50%;
    		top: 50%;
    		width: 150px;
    		height: 150px;
    		margin: -75px 0 0 -75px;
    		border-radius: 50%;
    		border: 3px solid transparent;
    		border-top-color: #3498db;

    		-webkit-animation: spin 2s linear infinite; /* Chrome, Opera 15+, Safari 5+ */
    		animation: spin 2s linear infinite; /* Chrome, Firefox 16+, IE 10+, Opera */
		}
		#nb-loader:before {
        	content: "";
        	position: absolute;
        	top: 5px;
        	left: 5px;
        	right: 5px;
        	bottom: 5px;
        	border-radius: 50%;
        	border: 3px solid transparent;
        	border-top-color: #e74c3c;

        	-webkit-animation: spin 3s linear infinite; /* Chrome, Opera 15+, Safari 5+ */
        	animation: spin 3s linear infinite; /* Chrome, Firefox 16+, IE 10+, Opera */
    }

    #nb-loader:after {
        content: "";
        position: absolute;
        top: 15px;
        left: 15px;
        right: 15px;
        bottom: 15px;
        border-radius: 50%;
        border: 3px solid transparent;
        border-top-color: #f9c922;

        -webkit-animation: spin 1.5s linear infinite; /* Chrome, Opera 15+, Safari 5+ */
          animation: spin 1.5s linear infinite; /* Chrome, Firefox 16+, IE 10+, Opera */
    }


		
		#nb-loader-wrapper .nb-loader-section {
			position: fixed;
			display: flex;
			flex-direction: column;
            justify-content: center;
            align-items: center;
    		top: 0;
    		width: 51%;
    		height: 100%;
    		background: #f5f5f5;
    		z-index: 1000;
		}
 
		#nb-loader-wrapper .nb-loader-section.section-left {
    		left: 0;
		}
 
		#nb-loader-wrapper .nb-loader-section.section-right {
    		right: 0;
		}
		
		#nb-loader {
    		z-index: 1001; /* anything higher than z-index: 1000 of .loader-section */
		}

		

		/* Loaded */
		.nb-loaded #nb-loader-wrapper .nb-loader-section.section-left {
    		-webkit-transform: translateX(-100%);  /* Chrome, Opera 15+, Safari 3.1+ */
    		-ms-transform: translateX(-100%);  /* IE 9 */
    		transform: translateX(-100%);  /* Firefox 16+, IE 10+, Opera */
		}
 
		.nb-loaded #nb-loader-wrapper .nb-loader-section.section-right {
    		-webkit-transform: translateX(100%);  /* Chrome, Opera 15+, Safari 3.1+ */
    		-ms-transform: translateX(100%);  /* IE 9 */
    		transform: translateX(100%);  /* Firefox 16+, IE 10+, Opera */
		}

		.nb-loaded #nb-loader {
			opacity: 0;
			-webkit-transition: all 0.3s ease-out; 
            transition: all 0.3s ease-out;
		}

		.nb-loaded #nb-loader-wrapper .nb-loader-section.section-right,
		.nb-loaded #nb-loader-wrapper .nb-loader-section.section-left {
    		-webkit-transition: all 0.3s 0.3s ease-out; 
            transition: all 0.3s 0.3s ease-out;
		}

		.nb-loaded #nb-loader-wrapper {
    		visibility: hidden;
		}

		.#nb-loader-wrapper .nb-loader-section.section-right,
		.#nb-loader-wrapper .nb-loader-section.section-left {
			-webkit-transition: all 0.7s 0.3s cubic-bezier(0.645, 0.045, 0.355, 1.000); 
			transition: all 0.7s 0.3s cubic-bezier(0.645, 0.045, 0.355, 1.000);
		}

		.nb-loaded #nb-loader-wrapper {
        	-webkit-transform: translateY(-100%);
            -ms-transform: translateY(-100%);
			transform: translateY(-100%);
 
			-webkit-transition: all 0.3s 1s ease-out; 
			transition: all 0.3s 1s ease-out;
		}

	</style>
<?php
}

add_action('nabco_furnitures_style','nabco_furnitures_css');

function nabco_furnitures_pre_loading() {
	if(is_customize_preview()) { return false; }
?>

	<div id="nb-loader-wrapper">
		<div id="nb-loader"></div>
    	<div class="nb-loader-section section-left"></div>
    	<div class="nb-loader-section section-right"></div>
	</div>
<?php
}

add_action('nabco_furniture_before_content','nabco_furnitures_pre_loading',10);

function nabco_furnitures_pre_loading_script() {

	if(is_customize_preview()) { return false; }
?>

<script>
	jQuery(document).ready(function() {
		setTimeout(function(){
        	jQuery('body').addClass('nb-loaded');
    	}, 1500);
	})
	
</script>

<?php 	
}

add_action('nabco_furniture_after_content','nabco_furnitures_pre_loading_script',10);

function nabco_furniture_youtube_script() {

	if(!is_front_page()) return false;
	
	?>

<script>
	jQuery(document).ready(function() {

		if(window.matchMedia("(min-width: 640px)").matches) { 
			//carry on video
		}
		else {
			jQuery("#vidFront").empty();
			var img = document.createElement("img");
			img.setAttribute('src','<?php echo get_theme_mod('nb_video_src', get_template_directory_uri() . '/dist/imgs/front.jpeg'); ?>');
			img.setAttribute('class','videoContainer__video');
			
			 
			jQuery("#vidFront").append(img);
		}
	});

	

</script>

	<?php

}

add_action('nabco_furniture_after_content','nabco_furniture_youtube_script',20);
