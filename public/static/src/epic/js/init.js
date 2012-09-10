eva.construct = function(){
	$("#lang").on("change", function(){
		window.location.href = $(this).val();
	});
	return false;
};

eva.destruct = function(){
};
