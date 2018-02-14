$(document).ready(function() {

	$('.saveScope').click(function(){
		$('#saveScopeResponse').html('');
		var url = "/wp-content/themes/go/quote-edit-templates/ajax/editScope.php";
		showLoader();
		jQuery.ajax({
		  	url: url,
		 	type: "POST",
			dataType: 'json',
			cache: false,
			data: $('#editedScope').serialize(),
		 	success: function(response) {
		        if(response.status == 'fail') {
		        	removeLoader();
		        	$('#saveScopeResponse').html(response.message);
		        }
		        else if(response.status == 'success') {
		        	var url = response.redirect;
		        	window.location.href = url;
					//console.log(response.log);
		        }

		 	},
		error: function(response) {
		        removeLoader();
		        $('#saveScopeResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong! Unknown error!</div>");
	  		}
	  	});

	});

});
