$(document).ready(function() {
        $('.adjust').click(function(){
                var row = $(this).attr('data-milestone');
                var quote_id = $(this).attr('data-quote');
                var adjustment_template = "/wp-content/themes/go/project-templates/ajax/adjustment_template.php";
         	jQuery.ajax({
          	url: adjustment_template,
         	type: "POST",
        		dataType: "html",
        		data: { 
        			'row' : row,
                                'quote_id' : quote_id,
        		},
         	success: function(response) {
                                $('#adjust_response').html(response);
        	 	},
        	error: function(response) {
        		     $('#adjust_response').html('Somethis went wrong!');
        	        }
          	});
        });
        
        $('.delete_adjustment').click(function(){
                var row = $(this).attr('data-milestone');
                var adj_row = $(this).attr('data-adj');
                var quote_id = $(this).attr('data-quote');
                var adjustment_delete = "/wp-content/themes/go/project-templates/ajax/adjustment_delete.php";
         	jQuery.ajax({
          	url: adjustment_delete,
         	type: "POST",
        		dataType: "html",
        		data: { 
        			'row' : row,
                                'adj_row' : adj_row,
                                'quote_id' : quote_id,
        		},
         	success: function(response) {
                                $('#adjust_response').html(response);
        	 	},
        	error: function(response) {
        		     $('#adjust_response').html('Somethis went wrong!');
        	        }
          	});
        });
        
        $("#adjust_response").on("click",".cancel_adjustment", function(){
                $('#adjust_response').html('');
        });
        
        $("#adjust_response").on("click",".save_adjustment", function(){
                var adjustment_save = "/wp-content/themes/go/project-templates/ajax/adjustment_save.php";
         	jQuery.ajax({
          	url: adjustment_save,
         	type: "POST",
        		dataType: "html",
        		data: $("#adjustment").serialize(),
         	success: function(response) {
                                $('#adjustment_save_response').html(response);
        	 	},
        	error: function(response) {
        		     $('#adjustment_save_response').html('Somethis went wrong!');
        	        }
          	});
        });
        
});