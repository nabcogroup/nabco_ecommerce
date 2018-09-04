<?php

class Nb_WoocommerceCart {
    

    public function __construct() {
        
        add_action('woocommerce_before_cart',[$this,'addCartBootstrapWrapper'],10);
        add_action('woocommerce_after_cart',[$this,'addCartBootstrapClosing'],10);
        
        //remove default empty cart display and replace with bootstrap style
        remove_action('woocommerce_cart_is_empty','wc_empty_cart_message',10);

        add_action('woocommerce_cart_is_empty',[$this,'addCartEmptyMessage'],10);

        //woocommerce cart message
        add_filter( 'wc_add_to_cart_message_html',[$this,'addCartMessageHtml'], 10);


        //mini cart header
        add_filter('woocommerce_widget_cart_item_quantity',[$this,'modWidgetCartItemQuantity'],10,3);

        //remove action and replace 
        remove_action('woocommerce_widget_shopping_cart_buttons','woocommerce_widget_shopping_cart_button_view_cart',10);
        remove_action('woocommerce_widget_shopping_cart_buttons','woocommerce_widget_shopping_cart_proceed_to_checkout',20);
        //add_action('woocommerce_widget_shopping_cart_buttons',[$this,'modWidgetShoppingCartButtonViewCart'],10);
        add_action('woocommerce_widget_shopping_cart_buttons',[$this,'modWidgetShoppingCartProceedToCheckout'],10);

    }

    public function modWidgetShoppingCartButtonViewCart() {
        echo '<div class="col-md-6">';
        echo '<!-- open col --><a href="' . esc_url( wc_get_cart_url() ) . '" class="button wc-forward btn btn-block btn-secondary">' . esc_html__( 'View Cart', 'woocommerce' ) . '</a><!-- end-->';
        echo '</div>';
    }

    public function modWidgetShoppingCartProceedToCheckout() {
        echo '<a href="' . esc_url( wc_get_checkout_url() ) . '" class="button checkout wc-forward btn btn-block  btn-secondary">' . esc_html__( 'Checkout', 'woocommerce' ) . '</a>';
    }



    public function modWidgetCartItemQuantity($content,$item,$key) {
        
        $content = "<span class='quantity'><strong>Quantity:&nbsp;</strong>{$item['quantity']}</span>";
        
        return $content;
    }

    public function addCartEmptyMessage() {
        echo '<div class="col-md-12 text-center">';
        echo '<h1 class="cart-empty">' . wp_kses_post( apply_filters( 'wc_empty_cart_message', __( 'Your cart is currently empty.', 'woocommerce' ) ) ) . '</h1>';
        echo '</div>';
    }

    public function addCartBootstrapWrapper() {
        
        echo  "<!-- cart wrapper --><div class='row'>";
    }

    public function addCartBootstrapClosing() {
        echo "</div>";
    }

    function addCartMessageHtml() {
    
        global $woocommerce;
        
        // Output success messages
        if (get_option('woocommerce_cart_redirect_after_add')=='yes') :
            $return_to  = get_permalink(woocommerce_get_page_id('shop'));
            $message    = sprintf('%s <a href="%s" class="button btn btn-sm btn-success">%s</a> ',__('Product successfully added to your cart.', 'woocommerce'), $return_to, __('Continue Shopping &rarr;', 'woocommerce') );
        else :
            $message    = sprintf('%s <a href="%s" class="button btn btn-sm btn-success">%s</a> ',__('Product successfully added to your cart.', 'woocommerce') ,get_permalink(wc_get_page_id ('cart')), __('View Cart &rarr;', 'woocommerce'));
        endif;
            return $message;
    }
}

$nbCart = new Nb_WoocommerceCart();