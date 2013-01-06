$(document).ready(function(){

	// Blur images on mouse over
	$(".myworks a").hover( function(){ 
		$(this).children("img").animate({ opacity: 0.75 }, "fast"); 
	}, function(){ 
		$(this).children("img").animate({ opacity: 1.0 }, "slow"); 
	}); 

	// Initialize prettyPhoto plugin
	$(".fancybox-effects-d").fancybox({
		padding: 0,
		openEffect : 'elastic',
		openSpeed  : 150,
		closeEffect : 'elastic',
		closeSpeed  : 150,
		closeClick : true,
		helpers : {
			overlay : null
		}
	});
	$('.fancybox-media')
	.attr('rel', 'media-gallery')
	.fancybox({
		openEffect : 'none',
		closeEffect : 'none',
		prevEffect : 'none',
		nextEffect : 'none',

		arrows : false,
		helpers : {
			media : {},
			buttons : {}
		}
	});

	$('.item').mouseenter(function(e) {
		$(this).css('z-index','999999').stop().transition({ scale: 1.2 });
	});
	$('.item').mouseleave(function(e) {
		$('.item').css('z-index','100').stop().transition({ scale: 1.0 });
	});

	//Gallery Mouse Effects
	$('.item').mouseenter(function(e) {
		$(this).find('.overlay-block').fadeIn(1000,'swing');

	});

	$('.item').mouseleave(function(e) {
		$('.item').find('.overlay-block').fadeOut(100);
	});

	// Clone myworks items to get a second collection for Quicksand plugin
	var $portfolioClone = $(".myworks ").clone();

	// Attempt to call Quicksand on every click event handler
	$(".filter a").click(function(e){

		$(".filter li").removeClass("current");	

		// Get the class attribute value of the clicked link
		var $filterClass = $(this).parent().attr("class");

		if ( $filterClass == "all" ) {
			var $filteredmyworks = $portfolioClone.find("li");
		} else {
			var $filteredmyworks = $portfolioClone.find("li[data-type~=" + $filterClass + "]");
		}

		// Call quicksand
		$(".myworks ").quicksand( $filteredmyworks , { 
			duration: 800, 
			easing: 'easeInOutQuad' 
		}, function(){

			// Blur newly cloned myworks items on mouse over and apply prettyPhoto
			$(".myworks a").hover( function(){ 
				$(this).children("img").animate({ opacity: 0.75 }, "fast"); 
			}, function(){ 
				$(this).children("img").animate({ opacity: 1.0 }, "slow"); 
			}); 

			$(".fancybox-effects-d").fancybox({
				padding: 0,

				openEffect : 'elastic',
				openSpeed  : 150,

				closeEffect : 'elastic',
				closeSpeed  : 150,

				closeClick : true,

				helpers : {
					overlay : null
				}
			});
			$('.fancybox-media')
			.attr('rel', 'media-gallery')
			.fancybox({
				openEffect : 'none',
				closeEffect : 'none',
				prevEffect : 'none',
				nextEffect : 'none',

				arrows : false,
				helpers : {
					media : {},
					buttons : {}
				}
			});

			//Gallery Mouse Effects
			$('.item').mouseenter(function(e) {
				$(this).find('.overlay-block').fadeIn(1000,'swing');

			});

			$('.item').mouseleave(function(e) {
				$('.item').find('.overlay-block').fadeOut(100);
			});

			$('.item').mouseenter(function(e) {
				$(this).css('z-index','999999').stop().transition({ scale: 1.2 });
			});
			$('.item').mouseleave(function(e) {
				$('.item').css('z-index','100').stop().transition({ scale: 1.0 });
			});
		});


		$(this).parent().addClass("current");

		// Prevent the browser jump to the link anchor
		e.preventDefault();
	});

	var url = eva.parseUri();
	$(".filter a").each(function(){
		if($(this).attr('href') == url.path){
			$(this).click();
		}
	});
});
