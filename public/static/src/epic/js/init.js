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

eva.construct = function(){
	$("#lang").on("change", function(){
		window.location.href = $(this).val();
	});


	eva.highlightmenu();
	eva.miniCalendar();

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

	return false;
};

eva.destruct = function(){
};
