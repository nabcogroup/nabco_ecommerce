<?php


$archiveProduct = new WoocommerceProductLoop();
$singleProduct = new WoocommerceSingleProduct();

$archiveProduct->hook();

$singleProduct->hook();



//woocommerce cart message
add_filter( 'wc_add_to_cart_message_html','nabco_furniture_cart_message', 10);

function nabco_furniture_cart_message() {
    
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

//modify price display on variation
add_filter('woocommerce_available_variation','nabco_furniture_set_variation_price',10,3);

function nabco_furniture_set_variation_price($args,$object,$variation) {

    $htmlSaleFlash = "";
    
    if(isset($args['price_html'])) {

        if($variation->is_on_sale())  {
            
            $discountHtml = nabco_furniture_sale_percentage($variation);

            $htmlSaleFlash = sprintf("<span class='onsale ml-3'>%s %s</span>",$discountHtml,esc_html__( ' Sale! ', 'woocommerce' ));

        }

        $priceHtml = sprintf("<span>%s</span>",__('Price'));

        $args["price_html"] = "<p class='price'>{$priceHtml}: {$variation->get_price_html()} {$htmlSaleFlash}</p>";

    }

    return $args;
}


function nabco_furniture_sale_percentage($variation) {

    if(is_product()) {

        $showPercentage = get_theme_mod('show_percentage',true);
        
        $html = "";
        if($showPercentage) {

            $regularPrice = $variation->get_regular_price(); 
            $salePrice = $variation->get_sale_price(); 
            $percentage = ($regularPrice - $salePrice) / $regularPrice * 100; 
            $html = round($percentage) . '% off';
        }

        return $html;
    }


}