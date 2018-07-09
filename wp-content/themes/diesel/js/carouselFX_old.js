jQuery(document).ready(function($){

	var cycleLength = 3000;

	(function($) {
		$.fn.carouselPlug = function() {	
			return this.each(function() {				
				
				var target = $(this).parent();
				
				//fade in first image		
				$(".imgCarousel li:first-child", this).addClass('imgOn').fadeIn("fast");

				//right arrow
				$(".rightArrow", this).click(function(){		
					clearInterval(imgTimer);

                    if(!target.find(".imgCarousel > li:last-child").hasClass('imgOn'))
					{
						target.find(".imgCarousel .imgOn").stop(true, true).fadeTo(600, 0);
						target.find(".imgCarousel .imgOn").next().fadeTo(600, 1);
						target.find(".imgCarousel .imgOn").removeClass('imgOn').next().addClass('imgOn');
					}else{
						target.find(".imgCarousel .imgOn").stop(true, true).fadeTo(600, 0);
						target.find(".imgCarousel > li:first-child").fadeTo(600, 1);
						target.find(".imgCarousel .imgOn").removeClass('imgOn');
						target.find(".imgCarousel > li:first-child").addClass('imgOn');
					}
					imgCycle();
				});
				
				//left arrow
				$(".leftArrow", this).click(function(){		
					clearInterval(imgTimer);

					if(!target.find(".imgCarousel > li:first-child").hasClass('imgOn'))
					{
						target.find(".imgCarousel .imgOn").stop(true, true).fadeTo(600, 0);
						target.find(".imgCarousel .imgOn").prev().fadeTo(600, 1);
						target.find(".imgCarousel .imgOn").removeClass('imgOn').prev().addClass('imgOn');
					}else{
						target.find(".imgCarousel .imgOn").stop(true, true).fadeTo(600, 0);
						target.find(".imgCarousel > li:last-child").fadeTo(600, 1);
						target.find(".imgCarousel .imgOn").removeClass('imgOn');
						target.find(".imgCarousel > li:last-child").addClass('imgOn');
					}
					imgCycle();
				});
				
				//auto cycle 			
				var imgTimer;		
				function imgCycle(){
					imgTimer = setInterval(function(){	
					
						if(!target.find(".imgCarousel > li:last-child").hasClass('imgOn'))
						{
							target.find(".imgCarousel .imgOn").stop(true, true).fadeTo(600, 0);
							target.find(".imgCarousel .imgOn").next().fadeTo(600, 1);
							target.find(".imgCarousel .imgOn").removeClass('imgOn').next().addClass('imgOn');
						}else{
							target.find(".imgCarousel .imgOn").stop(true, true).fadeTo(600, 0);
							target.find(".imgCarousel > li:first-child").fadeTo(600, 1);
							target.find(".imgCarousel .imgOn").removeClass('imgOn');
							target.find(".imgCarousel > li:first-child").addClass('imgOn');
						}
						
					}, cycleLength);	
				};
				
				imgCycle();	
				
			});	
		}	
	}(jQuery));
	
	$(".carouselCont").carouselPlug();
	
});