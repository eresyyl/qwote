$(document).ready(function() {
	
	$("#go-sign-up").click(function(){
                $("#go-sign-up").html("<i class='fa fa-refresh fa-spin'></i>");
		var sign_up = "/wp-content/themes/go/auth-templates/ajax/do_register.php";
   	 	jQuery.ajax({
      	  	url: sign_up,
       	 	type: "POST",
		dataType: "html",
		data: jQuery("#sign-up").serialize(),
       	 	success: function(response) {
			        $("#sign-up-response").html("");
       		 	        $("#sign-up-response").html(response);
   		 	},
    		error: function(response) {
			        $("#go-sign-up").html("Sign Up");
    			        $("#sign-up-response").html("<div class='margin-top-40'><div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something goes wrong!</div></div>");
    		        }
  	  	});
	});
	
});