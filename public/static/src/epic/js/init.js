eva.construct = function(){
	$("#lang").on("change", function(){
		window.location.href = $(this).val();
	});


	var lang = eva.config.lang;
	var langMap = {
		'en' : 'en',
		'zh' : 'zh_CN'
	}
	var jsLang = langMap[lang];
	eva.loader(eva.s('/lib/js/jquery/jquery.validationEngine/jquery.validationEngine-' + jsLang + '.js'), function(){
		$("#signupform").validationEngine();
	});
	return false;
};

eva.destruct = function(){
};
