<?php


$archiveProduct = new WoocommerceProductLoop();
$singleProduct = new WoocommerceSingleProduct();

$archiveProduct->hook();

$singleProduct->hook();



class WoocommerceSingleProduct {


    public function hook() {
        
        /******************************************
        * Hook: woocommerce_before_single_product.
        * @hooked wc_print_notices - 10 
        ******************************************/
        
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

        /**************************************************
		* Hook: woocommerce_before_single_product_summary.
		*
		* @hooked woocommerce_show_product_sale_flash - 10
		**************************************************/

         remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash',10);
         
         add_action('woocommerce_single_product_summary','woocommerce_show_product_sale_flash',6);
        
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


