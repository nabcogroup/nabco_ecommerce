<?php 

class Nb_WoocommerceMyAccount {

    public function __construct() {

        //add wrapper to auth header
        add_action( 'woocommerce_auth_page_header', [$this,'authPageHeader'], 10);

        add_action('woocommerce_auth_page_footer',[$this,'authPageFooter'],10);

        add_filter( 'woocommerce_account_menu_items', [$this,'accountMenuItemsArgs']);

        add_filter('nb_wc_order_status_class',[$this,'setClassStatus']);

         // Hook in to modify checkout fields into bootstrap 
         add_filter( 'woocommerce_form_field_args' , [$this,'customOverrideAddressFields'] );

        add_filter( 'woocommerce_my_account_my_address_formatted_address', [$this,'addressFormated']);

        add_filter( 'woocommerce_default_address_fields', [$this,'customOverrideDefaultAddress']);

    }


    public function customOverrideDefaultAddress($address_fields) {
        
        
        ## ---- 1.  Remove 'state' field ---- ##
        unset($address_fields['state']);

        //add label to address 2
        $address_fields['address_2']['label'] = 'Address 2';

        return $address_fields;
    }   




    public function customOverrideAddressFields($args) {

        array_push($args['class'],"form-group");
        $args["input_class"] = array("form-control");
        $args["label_class"] = array("register-label");

        return $args;
    
    }

    public function setClassStatus($status) {
        if($status == 'processing') {
            return 'badge-secondary';
        }
        else if($status == 'success') {
            return 'badge-success';
        }
        else {
            return 'badge-danger';
        }
    }

    public function addressFormated($address) {

        return $address;

    }



    public function accountMenuItemsArgs() {

        $menuOrder = array(
            'dashboard'          => __( 'Dashboard', 'woocommerce' ),
            'orders'             => __( 'Orders', 'woocommerce' ),
            'downloads'          => __( 'Download', 'woocommerce' ),
            'edit-address'       => __( 'Addresses', 'woocommerce' ),
            'edit-account'    	=> __( 'Account Details', 'woocommerce' ),
            'customer-logout'    => __( 'Logout', 'woocommerce' ),
        );
        return $menuOrder;
    }



    public function authPageHeader() {

        echo "<div class='row justify-content-center align-self-center'>";
    }

    public function authPageFooter() {
        echo "</div>";
    }



}

$authPage = new Nb_WoocommerceMyAccount(); 