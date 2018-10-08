jQuery(document).ready(function($) {

     $('body').on('click','#cart_management', function(e) {
        e.preventDefault();
        console.log("click cart");
        $(".widget_shopping_cart").animate({opacity:'toggle'},100);
        $(".widget_shopping_cart").addClass("ns-area-show");
    });

    $("body").on("click",".widget_shopping_cart_content", function(e) {e.stopPropagation();})

    $('body').on('click','.widget_shopping_cart',function(e) {
        console.log("I was clicked");
        $(".widget_shopping_cart").removeClass("ns-area-show");
        $(".widget_shopping_cart").animate({opacity:'toggle'},300);
    });
});