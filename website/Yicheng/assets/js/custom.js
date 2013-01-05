$(document).ready(function() {

	var path = eva.s() + '/assets/index.php/module/yicheng/';

	// initial fade effect for the entire screen
	var $content = $('#wrapper');
	$content.css('opacity',0);
	$('#progress').fadeOut(500, function() {
		$content.animate({'opacity':1}, 500);
	});



	// toggle function
	$('a.trigger').click(function(){
		if( ! $(this).hasClass('active')){
			$("#totoggle").slideToggle("slow");
			$(this).addClass('active');
			$('#container').append('<div class="text">七彩梦圆澜沧江畔——告庄西双景景真寨之亿成阳光国际公寓</div>').show('slow');
		} else {
			$("#totoggle").slideToggle("slow");
			$(this).removeClass('active');
			$('.text').remove();
		}
	});	


	// hover effects for the functionality buttons inside the box 			
	$("ul.buttons li, ul.top-buttons li").hover(function() {
		$(this).children('a').animate({opacity:"1"},{queue:false,duration:300}) },
		function() {
			$(this).children('a').animate({opacity:"0.5"},{queue:false,duration:300})
		});			


		// draggable function
		$( "#container" ).draggable({ handle: ".drag", containment: "#supersized", scroll: false });			


		//functions for the info, contact and back home buttons

		// from home to info
		function infopage() {
			if  ($("#infopage").is(":hidden")) {

				$("a.info").css({"background":"url(" + path + "images/home.png) no-repeat scroll 0 0"});
				$("a.contact").css({"background":"url(" + path + "images/home.png) no-repeat scroll 0 0"});
				$("#homepage").animate({height: "toggle", opacity: "toggle"}, "slow" );
				$("#infopage").animate({height: "toggle", opacity: "toggle"}, "slow" );
			}
			else {
				$("a.info").css({"background":"url(" + path + "images/info.png) no-repeat scroll 0 0"});
				$("a.contact").css({"background":"url(" + path + "images/contact.png) no-repeat scroll 0 0"});
				$("#infopage").animate({height: "toggle", opacity: "toggle"}, "slow" );
				$("#homepage").animate({height: "toggle", opacity: "toggle"}, "slow" );
			}
		}

		//run from home to info
		$(".info").click(function(){infopage()});	


		// from home to contact
		function contactpage() {
			if ($("#contactpage").is(":hidden"))
				{
					$("a.contact").css({"background":"url(" + path + "images/home.png) no-repeat scroll 0 0"});
					$("a.info").css({"background":"url(" + path + "images/home.png) no-repeat scroll 0 0"});
					$("#homepage").animate({height: "toggle", opacity: "toggle"}, "slow" );
					$("#contactpage").animate({height: "toggle", opacity: "toggle"}, "slow" );
				}
				else{
					$("a.contact").css({"background":"url(" + path + "images/contact.png) no-repeat scroll 0 0"});
					$("a.info").css({"background":"url(" + path + "images/info.png) no-repeat scroll 0 0"});
					$("#contactpage").animate({height: "toggle", opacity: "toggle"}, "slow" );
					$("#homepage").animate({height: "toggle", opacity: "toggle"}, "slow" );
				}
		}

		//run from home to contact
		$(".contact").click(function(){contactpage()});	


		//from info to contact
		function infocontact() {
			if ($("#contactpage").is(":hidden"))
				{
					$("a.contact").css({"background":"url(" + path + "images/home.png) no-repeat scroll 0 0"});
					$("#infopage").animate({height: "toggle", opacity: "toggle"}, "slow" );
					$("#contactpage").animate({height: "toggle", opacity: "toggle"}, "slow" );
				}
				else{
					$("a.contact").css({"background":"url(" + path + "images/contact.png) no-repeat scroll 0 0"});
					$("#contactpage").animate({height: "toggle", opacity: "toggle"}, "slow" );
					$("#infopage").animate({height: "toggle", opacity: "toggle"}, "slow" );
				}
		}

		// run from info to contact
		$(".infocontact").click(function(){infocontact()});	


		// from contact to info
		function contactinfo() {
			if ($("#infopage").is(":hidden"))
				{
					$("#contactpage").animate({height: "toggle", opacity: "toggle"}, "slow" );
					$("#infopage").animate({height: "toggle", opacity: "toggle"}, "slow" );
				}
				else{
					$("#infopage").animate({height: "toggle", opacity: "toggle"}, "slow" );
					$("#contactpage").animate({height: "toggle", opacity: "toggle"}, "slow" );
				}
		}

		// run from contact to info
		$(".contactinfo").click(function(){contactinfo()});	

});	


// full screen slider	
$(document).ready( function(){

	var path = eva.s() + '/assets/index.php/module/yicheng/';
	$.supersized({
		// Functionality
		slide_interval          :   8000,		// Length between transitions
		transition              :   1, 			// 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
		transition_speed		:	1000,		// Speed of transition

		// Components							
		slide_links				:	'false',	// Individual links for each slide (Options: false, 'num', 'name', 'blank')
		slides 					:  	[			// Slideshow Images
			{image : path + 'images/gallery/slide1.jpg', thumb : path + 'images/gallery/thumb1.jpg', url : ''},
			{image : path + 'images/gallery/slide2.jpg', thumb : path + 'images/gallery/thumb2.jpg', url : ''},
			{image : path + 'images/gallery/slide3.jpg', thumb : path + 'images/gallery/thumb3.jpg', url : ''},
			{image : path + 'images/gallery/slide4.jpg', thumb : path + 'images/gallery/thumb4.jpg', url : ''},
			{image : path + 'images/gallery/slide5.jpg', thumb : path + 'images/gallery/thumb5.jpg', url : ''}	
		]
	});
});
