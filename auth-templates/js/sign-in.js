$(document).ready(function() {
	
	$("#go-sign-in").click(function(){
                $("#go-sign-in").html("<i class='fa fa-refresh fa-spin'></i>");
		var sign_in = "/wp-content/themes/go/auth-templates/ajax/do_login.php";
   	 	jQuery.ajax({
      	  	url: sign_in,
       	 	type: "POST",
		dataType: "html",
		data: jQuery("#sign-in").serialize(),
       	 	success: function(response) {
			        $("#sign-in-response").html("");
       		 	        $("#sign-in-response").html(response);
   		 	},
    		error: function(response) {
			        $("#go-sign-in").html("Sign in");
    			        $("#sign-in-response").html("<div class='margin-top-40'><div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Invalid Login or Password!</div></div>");
    		        }
  	  	});
	});
	
});