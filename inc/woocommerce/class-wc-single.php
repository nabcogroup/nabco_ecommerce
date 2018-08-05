<?php

class WoocommerceSingleProduct {


    public function hook() {
        
      
        /******************************************
        * add wrapper to wc print notice
        * Hook: woocommerce_before_single_product.
        * @hooked wc_print_notices - 10 
        ******************************************/
        add_action('woocommerce_before_single_product',[$this,'beforeSingleProduct'],5);
        add_action( 'woocommerce_after_single_product',[$this,'afterSingleProduct'],15);


        add_action('woocommerce_before_add_to_cart_form',[$this,'beforeCartForm'],10);
        add_action( 'woocommerce_after_add_to_cart_form', [$this,'afterCartForm'],10 );

        //change meta position
        remove_action('woocommerce_single_product_summary','woocommerce_template_single_meta',40);
        
        add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 7);
        

        //
        //insert dynamic price display
        add_action('woocommerce_single_product_summary',[$this,'productVariationPrice'],1);

        /**************************************************
		* Hook: woocommerce_before_single_product_summary.
		*
		* @hooked woocommerce_show_product_sale_flash - 10
		**************************************************/
        remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash',10);
        add_action('nb_woocommerce_after_sales_price','woocommerce_show_product_sale_flash',10);
        

         /****************** 
          * Hook: woocommerce_before_add_to_cart_quantity & woocommerce_after_add_to_cart_quantity
         */
         add_action( 'woocommerce_before_add_to_cart_quantity', array($this,'beforeAddToCartQuantityWrapper'),10 );
         add_action( 'woocommerce_after_add_to_cart_quantity', array($this,'afterAddToCartQuantityWrapper'), 10 );

        
        //insert class in product variation selection
        add_filter('woocommerce_dropdown_variation_attribute_options_args',[$this,'dropdownVariationOptionsAddBootstrapForm']);

        


    }

    public function addVariationBootstrapWrapper() {
        echo "<div class='row'>";
    }

    public function addVariationBootstrapClosing() {
        echo "</div>";
    }




  
    public function dropdownVariationOptionsAddBootstrapForm($args) {
        
        $args['class'] = 'form-control';
        
        return $args;
    }

    public function productVariationPrice() {
        if(is_product()) {
            global $product;
            if($product->is_type('variable')) {
               remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
            }
            
        }

        
    }

    public function beforeAddToCartQuantityWrapper() {
        echo '<!-- wrapper quantity --><div class="col-md-6">';
    }

    public function afterAddToCartQuantityWrapper() {
        echo '</div><!-- end wrapper -->';
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