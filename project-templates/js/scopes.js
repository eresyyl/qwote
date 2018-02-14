$(document).ready(function() {
        $('.scope_load_details').click(function(){
                $('.scope_load_details').removeClass('scope_active');
                $('#scope_details').html("<div class='text-center margin-top-20'><i class='fa fa-refresh fa-spin'></i></div>");
                $(this).addClass('scope_active');
                var quote_id = $(this).attr('data-quote');
                var template_id = $(this).attr('data-template');
                var load_scope = "/wp-content/themes/go/project-templates/ajax/scope_details.php";
         	jQuery.ajax({
          	url: load_scope,
         	type: "POST",
        		dataType: "html",
        		data: { 
        			'quote_id' : quote_id,
                                'template_id' : template_id,
        		},
         	success: function(response) {
                        $('#scope_details').html(response);
        	 	},
        	error: function(response) {
        		     $('#scope_details').html("<div class='text-center margin-top-20'>Something went wrong!</div>");
        	        }
          	});
                
        });
});