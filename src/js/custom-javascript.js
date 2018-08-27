//scroll effect
(function() {
    
    var $ = jQuery;
    
    $(document).on( 'scroll', function(){
        if ($(window).scrollTop() > 100) {
            $('.scroll-top-wrapper').addClass('show');
            $('#nab-nav').addClass('fixed-top');
        } 
        else {
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



//common
jQuery(document).ready(function($) {
    //closing icon mobile
    $(".mobile-close-icon").on("click",function() {
        $target = $(this).data("target");
        $($target).removeClass("show");
    });

});


//navigation
jQuery(document).ready(function($) {
    
    //check if subnav set to active
    var groupSubnavs = $(".nb-dropdown-subnav");
    
    groupSubnavs.each(function(key,item) {

        var groupItem = $(this).data("group");

        initNavMenu(groupItem);

    });

    function initNavMenu(groupName) {

        var subnavs = $("." + groupName);

        subnavs.each(function() {
            if($(this).hasClass("active")) {
                
                var subnav = $(this).data("container");
                $("#" + subnav).show();
            }
        });

        subnavs.on("mouseover",function() {
            
            subnavs.each(function(key,item) {

                if($(item).hasClass("active")) {
                    $(item).removeClass("active");
                    var subnav = $(item).data("container");
                    $("#" + subnav).hide();    
                }
            });

            //change
            if(!$(this).hasClass("active")) {

                $(this).addClass("active");
                var subnav = $(this).data("container");
                $("#" + subnav).show();
            }


        })
    }
});

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
            
            previous = current; 
        }

        socialTitle.html("<span>"  + title +  "</span>");
        
        $("#" + previous).hide();
        $("#" + current).show();
        

    });
})();

//video
