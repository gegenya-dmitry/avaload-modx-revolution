$(document).ready(function() {
	$("#avaloadImage").ajaxUpload({
		url : "assets/components/avaload/avaload.php",
		name: "avaloadImage",
		onSubmit: function() {
			$('#avaloadInfoBox').html('Загрузка ... ');
		},
		onComplete: function(result) {
			param = $.parseJSON(result);
			if (param[0]) 
				$('#avaloadUserAvatar').attr('src',param[2]);
			$('#avaloadInfoBox').html(param[1]);
		}
	});
});	