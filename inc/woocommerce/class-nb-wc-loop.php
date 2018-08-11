<?php




class Nb_WoocommerceProductLoop {


    public function __construct() {

        /**
        * Add 'woocommerce-active' class to the body tag.
        *
        * @param  array $classes CSS classes applied to the body tag.
        * @return array $classes modified to include 'woocommerce-active' class.
        */
        add_filter( 'body_class', [$this,'wooCommerceActiveBodyClass'] );

         /*******************************************************************
        * Hook: woocommerce_before_main_content.
        * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
        *********************************************************************/
        remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
        add_action('woocommerce_before_main_content',[$this,'beforeMainContent']);

        /****************************************************************
        * Hook: woocommerce_after_main_content.
        * Location: woocommerce/archive-product.php
        *****************************************************************/
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
         ******************************************************************/
        remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
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
        * Remove rating and place it on the top
        * Add view more button
        * Location: woocommerce/product-content.php
        */
        remove_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_rating',5);
        
        add_action('woocommerce_before_shop_loop_item_title','woocommerce_template_loop_rating',11);
        
        


        /*********************************************************
        * remove product link opening and closing
        * remove add to card button
        * add view more button
        * Location: woocommerce/product-content.php
        */
        remove_action( 'woocommerce_after_shop_loop_item','woocommerce_template_loop_add_to_cart');
        remove_action( 'woocommerce_after_shop_loop_item','woocommerce_template_loop_product_link_close');
        remove_action('woocommerce_before_shop_loop_item','woocommerce_template_loop_product_link_open',10);
        
        add_action('woocommerce_before_shop_loop_item_title',[$this,'wooCommerceViewMoreButton'],10);

    }


    public function wooCommerceViewMoreButton() {
        
        global $product;
        
        $link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(),$product);
        
        $wc_class = "woocommerce-LoopProduct-link woocommerce-loop-product__link";
        
        echo '<a href="' . esc_url($link) . '" class="'. $wc_class .' ">View More</a>';
    }

    public function woocommerceSeperator() {
        echo '<span class="product-loop-thumbnail-seperator"></span>';
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

$archiveProduct = new Nb_WoocommerceProductLoop();