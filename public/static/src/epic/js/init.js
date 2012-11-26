eva.highlightmenu = function(){
	var url = eva.parseUri();
	var menuItems = $("li[data-highlight-url]");
	var path = url.path;

	menuItems.each(function(){
		var item = $(this);
		var pattern = item.attr("data-highlight-url");
		pattern = pattern.replace(/\//g,"\\/");
		var reg = new RegExp(pattern);
		var res = reg.exec(path);
		if(res) {
			item.addClass("active");
			item.parent().removeClass('collapse');
			item.parent().parent().addClass("active");
			return true;
		}
	})
};

eva.miniCalendar = function(){
	if(!$('.calendar-wrap')[0]){
		return false;
	}
    var calendarUrl = eva.d('/event/calendar/');
    $('.calendar-wrap').load(calendarUrl);
    $('.calendar-wrap thead a').live("click", function(){
            $('.calendar-wrap').load($(this).attr('href'));
            return false;
    });
}

eva.notice = function(){
	if(!$(".message-notice-count")[0]) {
		return false;
	}

	var checkNewUnread = function(){
		$.ajax({
			'url' : eva.d('/message/messages/unreadcount'),
			'type' : 'get',
			'dataType' : 'json',
			'success' : function(response){
				if(response.count > 0) {
					$(".message-notice-count .count-number").html(response.count).show();
					var title = $('title').text();
					if(title.match(/^\(\d+\)/)){
						title = title.replace(/^\(\d+\)/, '(' + response.count + ') ');
						$('title').html(title);
					} else {
						$('title').prepend('(' + response.count + ') ');
					}				
				} else {
					$(".message-notice-count .count-number").hide();
					var title = $('title').text();
					if(title.match(/^\(\d+\)/)){
						title = title.replace(/^\(\d+\)/, '');
						$('title').html(title);
					}		
				}
			}
		});
	}

	checkNewUnread();
	setInterval(function(){ checkNewUnread() }, 50000);
}

eva.templates = function(){
	$('script[data-url]').each(function(){
		var template = $(this);
		var url = template.attr('data-url');
		$.ajax({
			url : url,
			dataType : 'json',
			success : function(response){
				var t = tmpl(template.html(), response);
				template.after(t);
			}
		})
	});
}

eva.select2 = function(){
	if(!$('.select2')[0]){
		return false;
	}

	eva.loadcss(eva.s('/lib/js/jquery/jquery.select2/select2.css'));
	eva.loader(eva.s('/lib/js/jquery/jquery.select2/select2.js'), function(){
		$('.select2').select2();
	});
}

eva.checkFollow = function(){
	if(!$(".follow-check")[0]){
		return false;
	}

	var followCheck = $(".follow-check");
	var userid = followCheck.find('input[name=user_id]').val();
	var url = followCheck.attr('data-url');

	$.ajax({
		url : url,
		dataType : 'json',
		type : 'get',
		data : {"user_id" : userid},
		success : function(response){
			if(!response.item || response.item.length < 1) {
				return false;
			}
			$(".follow-form").toggleClass('hide');
			$(".unfollow-form").toggleClass('hide');
		}
	});
}

eva.preview = function(){
	$(document).on('click', '.item-preview', function(){
		var btn = $(this);
		var replace = {
			url : btn.attr('data-url'),
			width : btn.attr('data-width'),
			height : btn.attr('data-height')
		};
		if(btn.hasClass('video')){
			btn.html(eva.template('<embed src="{url}" quality="high" width="{width}" height="{height}" align="middle" allowScriptAccess="always" allowFullScreen="true" mode="transparent" type="application/x-shockwave-flash"></embed>', replace));
		} else {
			btn.html(eva.template('<img class="img-polaroid" alt="" src="{url}" width="{width}" />', replace));
		}
		btn.off('click', '*');
		return false;
	});
}

eva.story = function(){

	if(!$("#feed-wall")[0]){
		return false;
	}

	var startStory = function(){
		var maxLoaded = 10;
		var loadTimes = 1;
		var container = $("#feed-wall");
		var loader = $(".load-more");
		$("body").append('<div id="load-area"></div>');
		var loadArea = $("#load-area");
		var loaded = [];

		var initStory = function(items){

			items.each(function(){
				var item = $(this);
				item.addClass("inited");
				return true;
			});

		};

		$(window).resize(function(){
			container.masonry({
				itemSelector : '.box',
				//columnWidth : $(window).width() > 800 ? 320 : 260,
				isAnimated: true
			}).masonry( 'reload' );
		});

		container.imagesLoaded( function(){
			container.masonry({
				itemSelector : '.box',
				//columnWidth : $(window).width() > 800 ? 320 : 260,
				isAnimated: true
			});

			var items = container.find(".box:not(.inited)");
			//eva.p(items.length);
			initStory(items);
		});

		loadArea.hide();
		function inArray(stringToSearch, arrayToSearch) {
			if(arrayToSearch.length < 1) {
				return false;
			}
			for (var s = 0; s < arrayToSearch.length; s++) {
				var thisEntry = arrayToSearch[s];
				if (thisEntry == stringToSearch) {
					return true;
				}
			}
			return false;
		}
		
		var loadNewStory = function(loader){

			if(loadTimes > maxLoaded) {
				return false;
			}

			var url = loader.attr("href");
			if(inArray(url, loaded)){
				return false;
			}

			//loader.addClass("disabled").html(" （；^ω^） 正在努力载入...");
			loaded.push(url);

			loadArea.load(url + ' #feed-wall', function() {
				var newUrl = loadArea.find(".load-more").attr("href");
				loader.attr("href", newUrl); 
				var content = loadArea.find(".box");
				loadArea.imagesLoaded( function(){
					container.append(content).masonry( 'appended', content, true);
					initStory(container.find(".box:not(.inited)"));
					loadArea.html('');
					loader.removeClass("disabled").html("More");
				});
				loadTimes++;
			});

			return false;
		};

		$(window).scroll(function () { 
			var pageH = $(document).height(); //页面总高度 
			var scrollT = $(window).scrollTop(); //滚动条top 
			var winH = $(window).height(); 
			var offset = pageH - scrollT - winH;
			if(offset < 300){
				loadNewStory(loader);
			}
		}); 
	}

	eva.loader(eva.s([
		'/lib/js/jquery/jquery.masonry.js',
		'/lib/js/jquery/jquery.mousewheel.js',
		'/lib/js/jquery/jquery.jscrollpane.js'
	]), startStory);
};


eva.refreshOnline = function(){
	var refreshOnline = function(){
		$.ajax({
			'url' : eva.d('/user/refresh/online/'),
			'type' : 'get',
			'dataType' : 'json',
			'success' : function(response){
			}
		});
	}

	refreshOnline();
	setInterval(function(){ refreshOnline() }, 50000);
	
};

eva.construct = function(){
	$("#lang").on("change", function(){
		window.location.href = $(this).val();
	});


	eva.highlightmenu();
	eva.miniCalendar();
	eva.notice();
	eva.select2();
	eva.checkFollow();
	eva.preview();

	eva.refreshOnline();

	eva.story();

	var lang = eva.config.lang;
	var langMap = {
		'en' : 'en',
		'fr' : 'fr',
		'zh' : 'zh_CN',
		'zh_TW' : 'zh_TW',
		'ja' : 'ja'
	}
	var jsLang = langMap[lang];
	eva.loader(eva.s('/lib/js/jquery/jquery.validationEngine/jquery.validationEngine-' + jsLang + '.js'), function(){
		$("form").validationEngine();
	});

	eva.loader(eva.s('/lib/js/jstemplates/tmpl.js'), function(){
		eva.templates();
	});	

	return false;
};

eva.destruct = function(){
};
