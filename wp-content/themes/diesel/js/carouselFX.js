jQuery(document).ready(function($){

	var cycleLength = 10000;
    var slideLength = 800;

	(function($) {
		$.fn.carouselPlug = function() {	
			return this.each(function() {				
				
				var target = $(this).parent();
				
				//fade in first image
                $(".imgCarousel").fadeTo(600, 1);
				$(".imgCarousel li:first-child", this).addClass('imgOn').fadeIn("fast");
                var winW = $(window).width();
                $(".imgCarousel li:not(.imgOn)").css({"left": -winW})


                //enables swipe gestures on touchscreens
                var maxTime = 1000, // allow movement if < 1000 ms (1 sec)
                    maxDistance = 50,  // swipe movement of 50 pixels triggers the swipe

                    targetSwipe = $(".imgCarousel", this),
                    startX = 0,
                    startTime = 0,
                    touch = "ontouchend" in document,
                    startEvent = (touch) ? 'touchstart' : 'mousedown',
                    moveEvent = (touch) ? 'touchmove' : 'mousemove',
                    endEvent = (touch) ? 'touchend' : 'mouseup';

                targetSwipe
                    .bind(startEvent, function(e){
                        // prevent image drag (Firefox)
//                        e.preventDefault();
                        startTime = e.timeStamp;
                        startX = e.originalEvent.touches ? e.originalEvent.touches[0].pageX : e.pageX;
                    })
                    .bind(endEvent, function(e){
                        startTime = 0;
                        startX = 0;
                    })
                    .bind(moveEvent, function(e){
//                        e.preventDefault();
                        var currentX = e.originalEvent.touches ? e.originalEvent.touches[0].pageX : e.pageX,
                            currentDistance = (startX === 0) ? 0 : Math.abs(currentX - startX),
                        // allow if movement < 1 sec
                            currentTime = e.timeStamp;
                        if (startTime !== 0 && currentTime - startTime < maxTime && currentDistance > maxDistance) {
                            if (currentX < startX) {
                                // swipe left code here
                                clearInterval(imgTimer);

                                var winW = $(window).width();
                                $(".imgCarousel li:not(.imgOn)").css({"left": winW})

                                if(!target.find(".imgCarousel > li:last-child").hasClass('imgOn'))
                                {

                                    var winW = $(window).width();
                                    imgMotion();
                                }else{
                                    lastImgMotion();
                                }
                                imgCycle();
                            }
                            if (currentX > startX) {
                                // swipe right code here
                                clearInterval(imgTimer);

                                var winW = $(window).width();
                                $(".imgCarousel li:not(.imgOn)").css({"left": -winW})

                                if(!target.find(".imgCarousel > li:first-child").hasClass('imgOn'))
                                {
                                    leftImgMotion();
                                }else{
                                    leftFirstImgMotion();
                                }
                                imgCycle();
                            }
                            startTime = 0;
                            startX = 0;
                        }
                    });


				//right arrow
				$(".rightArrow", this).click(function(){		
					clearInterval(imgTimer);

                    var winW = $(window).width();
                    $(".imgCarousel li:not(.imgOn)").css({"left": winW})

                    if(!target.find(".imgCarousel > li:last-child").hasClass('imgOn'))
					{

                        var winW = $(window).width();
                        imgMotion();
					}else{
                        lastImgMotion();
					}
					imgCycle();
				});
				
				//left arrow
				$(".leftArrow", this).click(function(){		
					clearInterval(imgTimer);

                    var winW = $(window).width();
                    $(".imgCarousel li:not(.imgOn)").css({"left": -winW})

					if(!target.find(".imgCarousel > li:first-child").hasClass('imgOn'))
					{
                        leftImgMotion();
					}else{
                        leftFirstImgMotion();
					}
					imgCycle();
				});

                $(".galleryList li").click(function(){
                    clearInterval(imgTimer);

                    var imgPos = $(this).index();
                    var winW = $(window).width();

                    $(".contentWrap .carouselCont").fadeIn(500);

                    $(".imgCarousel li:not(.imgOn)").css({"left": winW})
                    if(!target.find(".imgCarousel li").eq(imgPos).hasClass('imgOn'))
                    {
                        target.find(".imgCarousel .imgOn").stop(true, true).animate({left: "-="+winW}, 1000, 'easeInOutCubic');
                        $(".imgCarousel li").eq(imgPos).stop(true, true).animate({left: "-="+winW}, 1000, 'easeInOutCubic');
                        target.find(".imgCarousel .imgOn").removeClass('imgOn');
                        $(".imgCarousel li").eq(imgPos).addClass('imgOn');
                    }
                    imgCycle();
                });
				
				//auto cycle 			
				var imgTimer;		
				function imgCycle(){
					imgTimer = setInterval(function(){
                        var winW = $(window).width();
                        $(".imgCarousel li:not(.imgOn)").css({"left": winW})

						if(!target.find(".imgCarousel > li:last-child").hasClass('imgOn'))
						{
                            imgMotion();
						}else{
                            lastImgMotion();
						}
						
					}, cycleLength);	
				};

                function imgMotion(){
                    target.find(".imgCarousel .imgOn").animate({left: "-="+winW}, 1000, 'easeInOutCubic');
                    target.find(".imgCarousel .imgOn").next().animate({left: "-="+winW}, 1000, 'easeInOutCubic');
                    target.find(".imgCarousel .imgOn").removeClass('imgOn').next().addClass('imgOn');
                }

                function lastImgMotion(){
                    target.find(".imgCarousel .imgOn").stop(true, true).animate({left: "-="+winW}, 1000, 'easeInOutCubic');
                    target.find(".imgCarousel > li:first-child").animate({left: "-="+winW}, 1000, 'easeInOutCubic');
                    target.find(".imgCarousel .imgOn").removeClass('imgOn');
                    target.find(".imgCarousel > li:first-child").addClass('imgOn');
                }

                function leftImgMotion(){
                    target.find(".imgCarousel .imgOn").stop(true, true).animate({left: "+="+winW}, 600, 'easeInOutCubic');
                    target.find(".imgCarousel .imgOn").prev().animate({left: "+="+winW}, 600, 'easeInOutCubic');
                    target.find(".imgCarousel .imgOn").removeClass('imgOn').prev().addClass('imgOn');
                }

                function leftFirstImgMotion(){
                    target.find(".imgCarousel .imgOn").stop(true, true).animate({left: "+="+winW}, 600, 'easeInOutCubic');
                    target.find(".imgCarousel > li:last-child").animate({left: "+="+winW}, 600, 'easeInOutCubic');
                    target.find(".imgCarousel .imgOn").removeClass('imgOn');
                    target.find(".imgCarousel > li:last-child").addClass('imgOn');
                }
				
				imgCycle();	
				
			});	
		}	
	}(jQuery));
	
	$(".carouselCont").carouselPlug();

    $(window).resize(function(){
        var winW = $(window).width();
        $(".imgCarousel li:not(.imgOn)").css({"left": winW})
        $(".imgCarousel .imgOn").css({"left": "0px"});
    });

});