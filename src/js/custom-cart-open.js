jQuery(document).ready(function($) {

     $('body').on('click','#cart_management', function(e) {
        e.preventDefault();
        console.log("click cart");
        $(".widget_shopping_cart").animate({opacity:'toggle'},100);
        $(".widget_shopping_cart").addClass("ns-area-show");
    });

    $(".woocommerce-mini-cart").on("click",function(e) {e.stopPropagation();})

    $('.widget_shopping_cart').on('click',function(e) {
        $(".widget_shopping_cart").removeClass("ns-area-show");
        $(".widget_shopping_cart").animate({opacity:'toggle'},300);
    });
});