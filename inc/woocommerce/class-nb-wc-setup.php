
<?php



require_once get_template_directory() . '/inc/woocommerce/class-nb-wc-cart.php';
require_once get_template_directory() . '/inc/woocommerce/class-nb-wc-acct.php';
require_once get_template_directory() . '/inc/woocommerce/class-nb-wc-checkout.php';
require_once get_template_directory() . '/inc/woocommerce/class-nb-wc-loop.php';
require_once get_template_directory() . '/inc/woocommerce/class-nb-wc-single.php';

class Nb_Woocommerce_Setup {

    public function __construct() {

        add_action( 'after_setup_theme', array($this,'woocommerce_setup') );
        add_action( 'wp_enqueue_scripts', array($this,'woocommerce_scripts') );

        /**
        * Disable the default WooCommerce stylesheet.
        *
        * Removing the default WooCommerce stylesheet and enqueing your own will
        * protect you during WooCommerce core updates.
        *
        * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
        */
        add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
    
        
        /**
        * Add 'woocommerce-active' class to the body tag.
        *
        * @param  array $classes CSS classes applied to the body tag.
        * @return array $classes modified to include 'woocommerce-active' class.
        */
        add_filter( 'body_class', [$this,'woocommerce_active_body_class'] );

        //change data filter
        add_filter( 'woocommerce_breadcrumb_defaults', [$this,'woocommerce_breadcrumb'] );
        
    }


    public function woocommerce_active_body_class($classes) {

        $classes[] = 'woocommerce-active';
    
        return $classes;
    }

     /**
     * 
     * hooked: woocommerce_breadcrumb
     *  - change woocommerce breadcrumb
     */
    public function woocommerce_breadcrumb() {
        return array(
            'delimiter'   => ' » ',
            'wrap_before' => '<nav class="woocommerce-breadcrumb" itemprop="breadcrumb">',
            'wrap_after'  => '</nav>',
            'before'      => '',
            'after'       => '',
            'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' ),
        );  

    }

    public function woocommerce_setup() {

        add_theme_support( 'woocommerce' );
	    add_theme_support( 'wc-product-gallery-zoom' );
	    add_theme_support( 'wc-product-gallery-lightbox' );
        add_theme_support( 'wc-product-gallery-slider' );
    }

    /**
    * WooCommerce specific scripts & stylesheets.
    *
    * @return void
    */
    public function woocommerce_scripts() {
	
        //wp_enqueue_style( 'nabco-furnitures-woocommerce-style', get_template_directory_uri() . '/dist/css/woocommerce.css' );
        $font_path   = WC()->plugin_url() . '/assets/fonts/';
        $inline_font = '@font-face {
                font-family: "star";
                src: url("' . $font_path . 'star.eot");
                src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
                    url("' . $font_path . 'star.woff") format("woff"),
                    url("' . $font_path . 'star.ttf") format("truetype"),
                    url("' . $font_path . 'star.svg#star") format("svg");
                font-weight: normal;
                font-style: normal;
            }';

        wp_add_inline_style( 'nabco-furnitures-woocommerce-style', $inline_font );
    }

}

return new Nb_Woocommerce_Setup();