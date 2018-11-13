<?php 


class Nb_WoocommerceCheckout {

    public function __construct() {

        // Hook in to modify checkout fields into bootstrap 
        add_filter( 'woocommerce_checkout_fields' , [$this,'override_fields'],10 );
        //add_filter('woocommerce_order_button_html',[$this,'order_button_html']); //templates/checkout/payment.php
        add_filter('woocommerce_thankyou_order_received_text',[$this,'thankyou_message_text'],20);
        
    }
    

    /**
     * hooked: woocommerce_thankyou_order_received_text
     * @used: filter
     * - theme can make its own thank you message
     */
    public function thankyou_message_text() {

        $message = __(get_theme_mod('thankyou_message', 'Thank you. Your reservation has been received'),'woocommerce');
        
        return  $message;
    }

    /**
     * hooked: woocommerce_order_button_html
     * @used: filter
     * - add button style to match theme
     */
    public function order_button_html($args) {

        $order_button_text = __("Place Order");
        echo '<button type="submit" class="button alt btn btn-primary btn-block" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '">' . esc_html( $order_button_text ) . '</button>';
    }
    
    /** 
     * hooked: woocommerce_checkout_fields
     *  - override the form fields 
    */
    public function override_fields($checkout_fields) {
        
        //accounts
        if(isset($checkout_fields["account"])) {
            foreach ($checkout_fields["account"] as &$field) {
                if(!isset($field['input_class'])) {
                    $field["input_class"] = array("form-control");
                }
            }
        }


        //order
        if(isset($checkout_fields["order"])) {
            foreach ($checkout_fields["order"] as &$field) {
                if(!isset($field['input_class'])) {
                    $field["input_class"] = array("form-control");
                }
            }
        }
        

        return $checkout_fields;

    }

}


return new Nb_WoocommerceCheckout();