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
        
        //change data filter
        add_filter( 'woocommerce_breadcrumb_defaults', [$this,'defaultBreadcrumb'] );
        
        add_action('woocommerce_before_shop_loop',[$this,'navigationWrapperOpening'],5);
        add_action('woocommerce_before_shop_loop',[$this,'navigationWrapperClosing'],35);


        //change catalog sort
        add_filter('woocommerce_catalog_orderby',[$this,'catalogOrderBy'],10);

        /*********************************************************
        * remove product link opening and closing
        * remove add to card button
        * add view more button
        * Location: woocommerce/product-content.php
        */
        remove_action( 'woocommerce_after_shop_loop_item','woocommerce_template_loop_add_to_cart');
        
        add_filter('woocommerce_sale_flash',[$this,'saleFlash']);
        
        
        add_action('woocommerce_before_shop_loop_item',[$this,'contentProductWrapperOpening']);
        add_action('woocommerce_after_shop_loop_item',[$this,'contentProductWrapperClosing']);
        

    }

    public function navigationWrapperOpening() {
        echo '<!-- opening wrapper --><div class="wc-order-wrapper">';
    }

    public function navigationWrapperClosing() {
        echo '</div><!-- wrapper end -->';
    }

    public function saleFlash($content) {

        $output = '<div class="sale-wrapper">';
        $output .= $content;
        $output .= '</div>';

        return $output;
    }

    public function contentProductWrapperOpening() {
        echo '<!-- product content wrapper --><div class="wc-card-product-content">';
    }

    public function contentProductWrapperClosing() {
        echo '</div><!-- product content wrapper -->';
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

    public function loopProductThumbnail($size = 'thumbnail') {
        
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