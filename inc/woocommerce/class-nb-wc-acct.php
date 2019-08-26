<?php 

class Nb_WoocommerceMyAccount extends Theme_Hook {

    public function __construct() {

        $this->actions = array(
            'woocommerce_auth_page_header'      =>  'auth_page_header',
            'woocommerce_auth_page_footer'      =>  'auth_page_footer',
            'wp_footer'                         =>  'dashboard_button_script',
        );

        $this->filters = array(
            'woocommerce_account_menu_items'    =>  'account_menu_item_args',
            'nb_wc_order_status_class'          =>  'set_class_status',
            'woocommerce_form_field_args'       =>  'custom_override_address_fields',
            'woocommerce_my_account_my_address_formatted_address'   =>  'address_formated',
            'woocommerce_default_address_fields' => 'custom_override_address_fields'
        );

        if( get_option('wc_disabled_shop_cart','yes') == 'no') {
            add_action('nabcofurniture_header_display_fragment',array($this,'customer_account'),20);
        }

        //add wrapper to auth header
        //add_action( 'woocommerce_auth_page_header', [$this,'authPageHeader'], 10);
        //add_action('woocommerce_auth_page_footer',[$this,'authPageFooter'],10);
        //add_filter( 'woocommerce_account_menu_items', [$this,'accountMenuItemsArgs']);
        //add_filter('nb_wc_order_status_class',[$this,'setClassStatus']);
         
        // Hook in to modify checkout fields into bootstrap 
        //add_filter( 'woocommerce_form_field_args' , [$this,'customOverrideAddressFields'],10 );
        //add_filter( 'woocommerce_my_account_my_address_formatted_address', [$this,'addressFormated'],10);
        //add_filter( 'woocommerce_default_address_fields', [$this,'customOverrideDefaultAddress'],10);

        //add_action('wp_footer',array($this,'dashboard_button_script'),10);

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

    
    public function customer_account() {
        
        if(!is_user_logged_in()) {
            $description = __('Sign-in');
        }
        else {
            $current_user = wp_get_current_user();

            $description = $current_user->user_login;
        }

	    echo '<div class="myaccount-mini-icon">' . sprintf('<a href="%s" class="user-content"><i class="fa fa-user"></i> <small class="d-none d-sm-inline">%s</small></a>',get_permalink(get_option('woocommerce_myaccount_page_id')),$description) . '</div>' ;
    }

    
    /*
        Script to add in my account for mobile responsive to control navigation
        Trigger only when my account page render
    */
    public function dashboard_button_script() {

        if(!is_page('my-account')) {
            return false;
        }

        ?>
        
        <script>
            jQuery(document).ready(function($) {
                console.log("navigation mobile");
                $(".nb-wc-mob-nav-button").on("click",function() {
                    if(!$(".woocommerce-MyAccount-navigation").hasClass('mobile-button-active')) {
                        $(".woocommerce-MyAccount-navigation").addClass('mobile-button-active');
                    }
                    else {
                        $(".woocommerce-MyAccount-navigation").removeClass('mobile-button-active');
                    }
                });
            })
        </script>

        <?php
    }
}

return new Nb_WoocommerceMyAccount(); 