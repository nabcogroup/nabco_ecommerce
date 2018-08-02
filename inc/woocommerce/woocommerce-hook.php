<?php



$archiveProduct = new NabcoWoocommerceTemplate();
$singleProduct = new WoocommerceSingleProduct();

$archiveProduct->hook();
$singleProduct->hook();


class NabcoWoocommerceTemplate {


    public function __construct() {

        /**
        * Add 'woocommerce-active' class to the body tag.
        *
        * @param  array $classes CSS classes applied to the body tag.
        * @return array $classes modified to include 'woocommerce-active' class.
        */
        add_filter( 'body_class', [$this,'wooCommerceActiveBodyClass'] );

    }

    public function hook() {

        /**************************************************************
        * Hook: woocommerce_before_main_content.
        * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
        *********************************************************************/
        remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
        add_action('woocommerce_before_main_content',[$this,'beforeMainContent']);

        /****************************************************************
        * Hook: woocommerce_after_main_content.
        * Location: woocommerce/archive-product.php
        * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
        */
        remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
        add_action('woocommerce_after_main_content',[$this,'afterMainContent']);
        
        //change data filter
        add_filter( 'woocommerce_breadcrumb_defaults', [$this,'defaultBreadcrumb'] );


        /*********************************************
        * Woocommerce catalog ordering form
        * Action: woocommerce_before_shop_loop
        * Location: woocommerce/archive-product.php
        * woocommerce default hook
        * @hooked wc_print_notices - 10
        * @hooked woocommerce_result_count - 20
        * @hooked woocommerce_catalog_ordering - 30
        *****************************************************/
        remove_action( 'woocommerce_before_shop_loop', 'wc_print_notices', 10 ); //theme dont need 
        
        //change catalog sort
        add_filter('woocommerce_catalog_orderby',[$this,'catalogOrderBy'],10);


        /******************************************************
        * Hook: woocommerce_archive_description.
        *
        * @hooked woocommerce_taxonomy_archive_description - 10
        * @hooked woocommerce_product_archive_description - 10
        ********************************************************/
        remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
        remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10 );
        
        /****************************************************************
         * Replace woocommerce product thumbnail display remove sale flash
         * Hook: woocommerce_before_shop_loop_item_title.
         * Location: woocommerce/product-content.php
         *
         * @hooked woocommerce_show_product_loop_sale_flash - 10
         * @hooked woocommerce_template_loop_product_thumbnail - 10
         ******************************************************************/

        remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
        remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );

        add_action('woocommerce_before_shop_loop_item_title',[$this,'loopProductThumbnail'],10);


        /*************************************************
        * Replace title
        * Hook: woocommerce_shop_loop_item_title.
        * Location: woocommerce/product-content.php
        *
        * @hooked woocommerce_template_loop_product_title - 10
        *******************************************************/
        remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
        
        add_action('woocommerce_shop_loop_item_title',[$this,'loopProductTitle'],10);

        /***********************************************
        * Remove Price
        * Hook: woocommerce_after_shop_loop_item_title.
        * Location: woocommerce/product-content.php
        * @hooked woocommerce_template_loop_rating - 5
        * @hooked woocommerce_template_loop_price - 10
        */

        remove_action( 'woocommerce_after_shop_loop_item_title','woocommerce_template_loop_price');

        /*********************************************************
        * Hook: woocommerce_after_shop_loop_item.
        * Location: woocommerce/product-content.php
        * @hooked woocommerce_template_loop_product_link_close - 5
        * @hooked woocommerce_template_loop_add_to_cart - 10
        */
        remove_action( 'woocommerce_after_shop_loop_item','woocommerce_template_loop_add_to_cart');
    }

    public function wooCommerceActiveBodyClass($classes) {

        $classes[] = 'woocommerce-active';
    
        return $classes;
    }


    public function beforeMainContent() {
        echo '<!-- primary --><div id="primary" class="content-area container woocommerce-page-wrapper">';
    }

    public function afterMainContent() {
        echo '</div><!-- #primary -->';
    }

    public function defaultBreadcrumb() {

        return array(
            'delimiter'   => ' » ',
            'wrap_before' => '<nav class="woocommerce-breadcrumb" itemprop="breadcrumb">',
            'wrap_after'  => '</nav>',
            'before'      => '',
            'after'       => '',
            'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' ),
        );  

    }

    public function catalogOrderBy() {

        return array(
            'price'         =>  __('Sort by price: low to high','woocommerce'),
            'price-desc'    =>  __('Sort by price: high to low','woocommerce'),
            'date'          =>  __('Sort by new arrival','woocommerce'),
        );
    }

    public function loopProductThumbnail($size = 'shop_catalog') {
        
        global $post, $woocommerce;
        
        $output = "";
        if ( has_post_thumbnail() ) {               
            $output .= get_the_post_thumbnail( $post->ID, $size,["class" => "card-img-top"] );
        } 
        else {

             //$output .= wc_placeholder_img( $size );
             // Or alternatively setting yours width and height shop_catalog dimensions.
             $output .= '<img src="' . woocommerce_placeholder_img_src() . '" alt="Placeholder" class="card-img-top" />';
        }                       
        
        echo $output;
    }

    public function loopProductTitle() {
        echo "<p class='product-title'>" . get_the_title() . "</p>";
    }
}

class WoocommerceSingleProduct {


    public function hook() {
        
        // /**
        // * Hook: woocommerce_before_single_product.
        // *
        // * @hooked wc_print_notices - 10
        // */
        
        remove_action( 'woocommerce_before_single_product','wc_print_notices',10 );
        
        add_action('woocommerce_before_single_product',[$this,'beforeSingleProduct'],10);
        add_action('woocommerce_before_single_product','wc_print_notices',20);
        add_action( 'woocommerce_after_single_product',[$this,'afterSingleProduct'],10 );

        add_filter( 'post_class', [$this,'addBootstrapRow'] );


        add_action('woocommerce_before_add_to_cart_form',[$this,'beforeCartForm'],10);
        add_action( 'woocommerce_after_add_to_cart_form', [$this,'afterCartForm'],10 );


        //change meta position
        remove_action('woocommerce_single_product_summary','woocommerce_template_single_meta',40);
        
        add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 7);
    }

    public function addBootstrapRow($classes) {
        $classes[] = "row";
        return $classes;
    }

    public function beforeCartForm() {
        echo "<div class='my-3 cart-form-wrapper'>";
    }

    public function afterCartForm() {
        echo "</div>";
    }


    public function beforeSingleProduct() {

        echo "<!-- product wrapper --><div class='woocommerce-content-single-product-wrapper'>";

    }

    public function afterSingleProduct() {

        echo "</div><!-- end product wrapper -->";

    }
}


