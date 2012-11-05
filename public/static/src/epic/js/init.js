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

eva.construct = function(){
	$("#lang").on("change", function(){
		window.location.href = $(this).val();
	});


	eva.highlightmenu();
	eva.miniCalendar();
	eva.notice();
	eva.select2();
	eva.checkFollow();

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
