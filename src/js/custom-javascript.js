//scroll effect
jQuery(document).ready(function() {
    var $ = jQuery;

    $(document).on( 'scroll', function(){
        
        if ($(window).scrollTop() > 100) {
            $('.scroll-top-wrapper').addClass('show');
            $('#nab-nav').addClass('fixed-top');
		} else {
            $('.scroll-top-wrapper').removeClass('show');
            $('#nab-nav').removeClass('fixed-top');
        }
        
    });
    
    
    $('.scroll-top-wrapper').on('click', scrollToTop);

    function scrollToTop() {

        verticalOffset = typeof(verticalOffset) != 'undefined' ? verticalOffset : 0;
        element = $('body');
        offset = element.offset();
        offsetTop = offset.top;
        $('html, body').animate({scrollTop: offsetTop}, 500, 'linear');

    }

});

(function() {
    var $ = jQuery;

    $(".close-icon").on("click",function() {
        $target = $(this).data("target");
        $($target).removeClass("show");
    });

})();

(function() {

    var $ = jQuery;
    
    
    var headerTarget = jQuery("#social-header");
    var icon = $(".js-icon");
    
    var current = "";
    var previous = "";
    var target = $("#social-container");
    

    $(document).on("click",function(e) {
        //look for social container then hide
        if(!target.hasClass("container-hide")) {
            target.removeClass("container-show");
            target.addClass("container-hide");
        }
    })


    $("#social-nav").on("click",function(e) {
        e.stopPropagation();
        if(target.hasClass("container-hide")) {
            target.removeClass("container-hide");
            target.addClass("container-show");
        }
    })
    
    icon.on("click", function(e) { 
        e.preventDefault();
        
        var socialTitle = $("#social-title");
        var title = $(this).data('title');
        
        
        if(current != "") {
            previous = current;
            current = $(this).data('container');
        }
        else  {
            current = $(this).data('container');
            console.log(current);
            previous = current; 
        }

        socialTitle.html("<span>"  + title +  "</span>");
        
        $("#" + previous).hide();
        $("#" + current).show();
        

    });
})();

