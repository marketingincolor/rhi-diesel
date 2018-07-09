
jQuery(document).ready(function($){

    //$(".mainNav a:not(.navIcon):not(.logoLink):not(.burgerLink)").parent().clone().appendTo(".subMenu");
    //mobile navigation
    $(".current-menu-item > a").click(function(){return false;});

    $(".burgerLink").click(function(){
        if(!$(".menu-mobile-menu-container").hasClass('subOpen')){
            $(".siteWrap").stop(true,true).animate({left: "-=230"}, 600, 'easeInOutQuad');
            $(".menu-mobile-menu-container").addClass('subOpen');
            window.scrollTo(500,0);
        }else if($(".menu-mobile-menu-container").hasClass('subOpen')){
            $(".siteWrap").stop(true,true).animate({left: "+=230"}, 600, 'easeInOutQuad');
            $(".menu-mobile-menu-container").removeClass('subOpen');
        }else{
            return false;
        }
    });

//    $(window).resize(function(){
//        if($(".menu-mobile-menu-container").hasClass('subOpen')){
//            $(".siteWrap").stop(true,true).animate({left: "+=230"}, 600, 'easeInOutQuad');
//            $(".menu-mobile-menu-container").removeClass('subOpen');
//        }
//    });

    /* SUB NAV */
    $(".mainNav .menu > li").mouseenter(function(){
        $(".sub-menu", this).stop().slideDown(500);
    });

    $(".mainNav .menu > li").mouseleave(function(){
        $(".sub-menu", this).stop().slideUp(200);
    });

    /* IN PAGE NAV */
    $(".inPageNav").mouseenter(function(){
        $(".menu", this).stop().slideDown(500);
    });

    $(".inPageNav").mouseleave(function(){
        $(".menu", this).stop().slideUp(200);
    });

    /* MOBILE NAV */
    $("#menu-mobile-menu > li").mouseenter(function(){
        $(".sub-menu", this).stop().slideDown(500);
    });

    $("#menu-mobile-menu > li").mouseleave(function(){
        $(".sub-menu", this).stop().slideUp(200);
    });

    //carousel height
    function imageSize(){
        var winH = $(window).height();
        var winWidth = $(window).width();
        if(winH < 820){
            $(".homeCarousel").height(winH);
        }

        if(winWidth >= 600){
            var newH = winH - 80;
            $(".photoCarousel").height(newH);
        }else{
            var newH = winH - 45;
            $(".photoCarousel").height(newH);
        }
    }
    imageSize();

    $(window).resize(function(){
        imageSize();
    });

    //gallery thumbs
    $(".galleryList li").click(function(){
        imageSize();
    });

    //close gallery
    $(".closeCarousel").click(function(){
        $(".photoCarousel").fadeOut(500);
    });

    //map
    function mapSize(){
        var mapWidth = $('.acf-map').width();
        $(".acf-map").height(mapWidth);
    }
    mapSize();





//    function mapSize(){
//        var winWidth = $(window).width();
//        var parentHeight = $(".mapPageList").height();
//        var headingHeight = $(".mapText").outerHeight();
//        var listHeight = parentHeight;
//
//        var mapParentHeight = $(".mapPageList > li:first-child");
//        var mapHeight = mapParentHeight - headingHeight;
//        $(".acf-map").outerHeight(mapHeight);
//
//
//        if(winWidth <= 800){
//            $(".mapPageList > li:first-child").outerHeight(400);
//        }else{
//            $(".mapPageList > li:first-child").outerHeight(listHeight);
//        }
//    }
    mapSize();





    $(window).resize(function(){
        mapSize();
    });

    // SIGNUP FORMS ****************************************************************************************************
    //create placeholder text on mailchimp forms
//    $(".footer label, .wpcf7 label, .checkout label").each(function() {
//    var label = $(this);
//    var placeholder = label.text();
//    label.next().attr("placeholder", placeholder);
//});

    //create placeholder text on mailchimp forms
    $(".footer label").each(function() {
        var label = $(this);
        var placeholder = label.text();
        label.next().attr("placeholder", placeholder);
    });

    $(".wpcf7 label").next('br').css({"display": "none"});

    //create placeholder text on contact form 7 forms
//    $(".wpcf7 li.formText").each(function() {
//        var label = $(".placeholder", this);
//        var placeholder = label.text();
//        $(this).find('input, textarea').attr("placeholder", placeholder);
//    });


    $("#mc-embedded-subscribe-form input[type='submit']").attr("value", "Join");

});
