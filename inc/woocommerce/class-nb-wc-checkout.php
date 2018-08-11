<?php 


class Nb_WoocommerceCheckout {

    public function __construct() {
        add_action('woocommerce_before_checkout_form',[$this,'beforeCheckoutFormBootstrapWrapper'],10);

        add_action('woocommerce_after_checkout_form',[$this,'endCheckoutFormBootstrapWrapper'],10);


        // Hook in to modify checkout fields into bootstrap 
        add_filter( 'woocommerce_billing_fields' , [$this,'customOverrideAddressFields'] );

        // Hook in to modify checkout fields into bootstrap 
        add_filter( 'woocommerce_checkout_fields' , [$this,'customOverrideFields'] );


        add_filter( 'woocommerce_cart_item_name', [$this,'cartItemName'], 10,2);
        
        add_filter('woocommerce_order_button_html',[$this,'changeOrderButtonHtmlToBootstrap']);


       add_filter('woocommerce_checkout_login_message',[$this,'changeCheckoutLoginMessage']);
    }

    public function changeCheckoutLoginMessage() {
        $message = __(get_theme_mod('login_message','Please Login if you have an account'),'woocommerce');
        return '';
    }

    public function changeOrderButtonHtmlToBootstrap($args) {

        $order_button_text = "Place Order";
        
        echo '<button type="submit" class="button alt btn btn-primary btn-block" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '">' . esc_html( $order_button_text ) . '</button>';
    }

    public function cartItemName($product_name,$cart_item) {
        
        return  $product_name;
    }

    public function afterCustomerDetailsWrapper() {
        echo "<!-- column wrapper --><div class='col-md-8'>";
    }

    public function beforeCustomerDetailsWrapper() {
        echo "<!-- end column wrapper --></div>";
    }

    public function beforeCheckoutFormBootstrapWrapper() {
        echo "<!-- row wrapper --><div class='row'>";
    }

    public function customOverrideAddressFields($address_fields) {
        
        foreach($address_fields as &$field) {
            array_push($field['class'],"form-group");
            
            if(!isset($field['input_class'])) {
                $field["input_class"] = array("form-control");
            }
        }
        
        
        return $address_fields;
    
    }

    public function customOverrideFields($checkout_fields) {
        
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

    public function endCheckoutFormBootstrapWrapper() {
        echo "<!-- end row wrapper --></div>";
    }

}

class Nb_WoocommerceThankyouPage {

    public function __construct() {
        apply_filter('woocommerce_thankyou_order_received_text',[$this,'modTyOrderRecievedText']);
    }


}

$nbCheckout = new Nb_WoocommerceCheckout();