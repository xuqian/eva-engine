eva.construct = function(){
	$('.nav-tabs a').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
    })
	
	$('#carousel-index').evaSlider({
		initNumbers : true,
		showPrevNext : false
	});
	return false;
};

eva.destruct = function(){
};

eva.init();
