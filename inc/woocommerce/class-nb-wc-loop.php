<?php




class Nb_WoocommerceProductLoop {


    public function __construct() {
        
         /*********************************************************
        * Location: template/archive-product.php
        ********************************************/
        add_action('woocommerce_before_shop_loop',[$this,'order_wrapper_opening'],5);
        add_action('woocommerce_before_shop_loop',[$this,'order_wrapper_closing'],35);
        add_action('woocommerce_before_shop_loop_item',[$this,'product_content_wrapper_opening']);
        add_action('woocommerce_after_shop_loop_item',[$this,'product_content_wrapper_closing']);
        
        /** 
         * includes/wc-template-functions.php
        */
        add_filter('woocommerce_catalog_orderby',[$this,'orderby_catalog'],10);


        /*********************************************************
        * Location: woocommerce/product-content.php
        * remove add to cart since it is not included in the theme requirements
        */
        remove_action( 'woocommerce_after_shop_loop_item','woocommerce_template_loop_add_to_cart'); //remove add to cart since it is not included in the theme requirements
        add_filter('woocommerce_sale_flash',[$this,'woocommerce_sale_flash_wrapper']);
        remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail',10); //make a wrapper on the image by reposition
        add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail',20);  //place in new location
        add_action('woocommerce_before_shop_loop_item_title',array($this,'thumbnail_wrapper_opening'),15);
        add_action('woocommerce_before_shop_loop_item_title',array($this,'thumbnail_wrapper_closing'),25);
        
    }

    /** 
     * hooked: woocommerce_before_shop_loop_item_title
     * - add wrapper in thumbnail to match theme bootstrap
    */
    public function thumbnail_wrapper_opening() {
        echo "<!-- opening wrapper--><div class='card-image-wrapper'>";
    }

    /** 
     * hooked: woocommerce_before_shop_loop_item_title
     * - closing of wrapper
    */
    public function thumbnail_wrapper_closing() {
        echo "</div>";
    }

    /**
     * hooked: woocommerce_before_shop_loop
     * - add wrapper in ordering and result count
     ********************************/
    public function order_wrapper_opening() {
        echo '<!-- opening wrapper --><div class="wc-order-wrapper">';
    }

    /**
     * hooked: woocommerce_before_shop_loop
     *  - closing of wrapper
     ********************************/
    public function order_wrapper_closing() {
        echo '</div><!-- wrapper end -->';
    }

    /** 
     * hooked: woocommerce_sale_flash
     *  - add wrapper in sale flash to achieve theme style
    */
    public function woocommerce_sale_flash_wrapper($content) {

        $output = '<div class="sale-wrapper">';
        $output .= $content;
        $output .= '</div>';

        return $output;
    }

    /** 
     * hooked: woocommerce_before_shop_loop_item
     *  - add wrapper to the content of the product to match bootstrap theme
    */
    public function product_content_wrapper_opening() {
        echo '<!-- product content wrapper --><div class="wc-card-product-content">';
    }

    /** 
     * hooked: woocommerce_before_shop_loop_item
     *  - closing of wrapper
    */
    public function product_content_wrapper_closing() {
        echo '</div><!-- product content wrapper -->';
    }
   
   
    /**
     * hooked: woocommerce_catalog_orderby
     * - change the selection of catalog order by
     */
    public function orderby_catalog() {

        return array(
            'price'         =>  __('Sort by price: low to high','woocommerce'),
            'price-desc'    =>  __('Sort by price: high to low','woocommerce'),
            'date'          =>  __('Sort by new arrival','woocommerce'),
        );
    }

   
}

return new Nb_WoocommerceProductLoop();