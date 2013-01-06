(function($){  
	$(function(){
		$(document).foundationMediaQueryViewer();
		$(document).foundationAlerts();
		$(document).foundationAccordion();
		$('input, textarea').placeholder();
		$(document).foundationButtons();
		$(document).foundationNavigation();
		$(document).foundationCustomForms();
		$(document).foundationTabs({callback:$.foundation.customForms.appendCustomMarkup});
		$("#featured").orbit({
			fluid: true
		});


		// UNCOMMENT THE LINE YOU WANT BELOW IF YOU WANT IE8 SUPPORT AND ARE USING .block-grids
		// $('.block-grid.two-up>li:nth-child(2n+1)').css({clear: 'left'});
		// $('.block-grid.three-up>li:nth-child(3n+1)').css({clear: 'left'});
		// $('.block-grid.four-up>li:nth-child(4n+1)').css({clear: 'left'});
		// $('.block-grid.five-up>li:nth-child(5n+1)').css({clear: 'left'});
	});

})(jQuery);



$(document).ready(function(){
	$('#nav, #mobile-nav').localScroll(800);

	//.parallax(xPosition, speedFactor, outerHeight) options:
	//xPosition - Horizontal position of the element
	//inertia - speed to move relative to vertical scroll. Example: 0.1 is one tenth the speed of scrolling, 2 is twice the speed of scrolling
	//outerHeight (true/false) - Whether or not jQuery should use it's outerHeight option to determine when a section is in the viewport
	$('#intro').parallax("50%", 0.1);
	$('#second').parallax("50%", 0.1);
	$('.bg').parallax("50%", 0.4);
	$('#third').parallax("50%", 0.1);
	$('#fourth').parallax("50%", 0.2);
	$('#fifth').parallax("50%", 0.2);
	$('#article, #overview, #album').parallax("50%", 0.2);



	$('.layout').mouseenter(function(e) {
		var pageIndex = $(this).find('.outer-wrap').attr('id');

		$('#nav li a').css('border-bottom','solid 4px #000000');
		$('#nav li a').stop().animate({fontSize:'18px'},'slow');
		$('#trigger-'+pageIndex).css('border-bottom','solid 4px #00D3D3');
		$('#trigger-'+pageIndex).stop().animate({fontSize:'32px'},'slow',function(){
			$('#nav').stop().animate({right:'-150px'},2000,function(){
				$('#nav li a').stop().animate({opacity:'0'},function(){
					$('#nav-arrow').fadeIn();
				});
			});
		});
	});



	$('#nav li a').click(function(e) {
		$('#nav li a').css('border-bottom','solid 4px #000000');
		$('#nav li a').stop().animate({fontSize:'18px'},'slow');
		$(this).css('border-bottom','solid 4px #00D3D3');
		$(this).stop().animate({fontSize:'32px'},'slow',function(){
			$('#nav').stop().animate({right:'-150px'},2000,function(){
				$('#nav li a').stop().animate({opacity:'0'},function(){
					$('#nav-arrow').fadeIn();
				});
			});
		});
	});

	$('#nav-arrow, #nav').mouseenter(function(e) {
		$('#nav-arrow').fadeOut();
		$('#nav li a').stop().animate({opacity:'1'},function(){
			$('#nav').stop().animate({right:'0px'},500,'easeInOutExpo');
		});
	});

	$('.mob-nav-link').click(function(e) {
		$('.mob-nav-link').css('color','#000000');
		$(this).css('color','#00D3D3');
	});


	//Gallery Mouse Effects
	$('.item').mouseenter(function(e) {
		$(this).find('.overlay-block').fadeIn(1000,'swing');

	});

	$('.item').mouseleave(function(e) {
		$('.item').find('.overlay-block').fadeOut(100);
	});


	//JQUERY TRANSIT INTEGRATION
	//note: portfolio filter needs these functions to be called on filter.js also
	$('.item').mouseenter(function(e) {
		$(this).css('z-index','999999').stop().transition({ scale: 1.2 });
	});
	$('.item').mouseleave(function(e) {
		$('.item').css('z-index','100').stop().transition({ scale: 1.0 });
	});

	$('.icon-thumb-big').mouseenter(function(e) {
		$(this).stop().transition({ scale: 1.2 }).transition({
			rotateY: '360deg'
		},2000);
	});

	$('.icon-thumb-big').mouseleave(function(e) {
		$(this).stop().transition({ scale: 1.0 }).transition({
			rotateY: '0deg'
		},2000);
	});

})
