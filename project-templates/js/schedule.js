$(document).ready(function() {
        $('.timeline-dot .iconchage').click(function(){
                var icon = $(this).attr('class');
                $(this).next('.schedule_buttons').fadeToggle();
                if(icon == 'icon iconchage wb-settings') {
                        $(this).closest('.timeline-dot').addClass('bg-red-600');
                        $(this).removeClass('wb-settings').addClass('wb-close');
                }
                else {
                         $(this).closest('.timeline-dot').removeClass('bg-red-600');
                       $(this).removeClass('wb-close').addClass('wb-settings'); 
                } 
        });
        
        $('.sch_done').click(function(){
                $(this).find('.s_done').removeClass('icon wb-check').addClass('fa fa-refresh fa-spin');
                var row = $(this).attr('data-row');
                var quote_id = $(this).attr('data-quote');
                var schedule_done = "/wp-content/themes/go/project-templates/ajax/schedule_done.php";
         	jQuery.ajax({
          	url: schedule_done,
         	type: "POST",
        		dataType: "html",
        		data: { 
        			'row' : row,
                                'quote_id' : quote_id,
        		},
         	success: function(response) {
                                $('#schedule_response').html(response);
        	 	},
        	error: function(response) {
        		     $('.sch_done').find('.s_done').removeClass('fa fa-refresh fa-spin').addClass('icon wb-check');
        	        }
          	});
        });
        
        $('.sch_delete').click(function(){
                $(this).find('.s_delete').removeClass('icon wb-trash').addClass('fa fa-refresh fa-spin');
                var row = $(this).attr('data-row');
                var quote_id = $(this).attr('data-quote');
                var schedule_delete = "/wp-content/themes/go/project-templates/ajax/schedule_delete.php";
         	jQuery.ajax({
          	url: schedule_delete,
         	type: "POST",
        		dataType: "html",
        		data: { 
        			'row' : row,
                                'quote_id' : quote_id,
        		},
         	success: function(response) {
                                $('#schedule_response').html(response);
        	 	},
        	error: function(response) {
        		     $('.sch_delete').find('.s_delete').removeClass('fa fa-refresh fa-spin').addClass('icon wb-trash');
        	        }
          	});
        });
        
        
        $('.sch_edit').click(function(){
                var row = $(this).attr('data-row');
                
                $('.schedule_' + row + ' .timeline-dot .iconchage').trigger('click'); 
                
                $('.from_date_' + row).datepicker({
                        format: 'dd/mm/yyyy',
                        startDate: '-0d',
                        autoclose: true
                });
                $('.to_date_' + row).datepicker({
                        format: 'dd/mm/yyyy',
                        startDate: '-0d',
                        autoclose: true
                });
                $('.schedule_' + row + ' .sview').hide();
                $('.schedule_' + row + ' .sedit').show();
        });
        
        $('.cancel_schedule').click(function(){
                var row = $(this).attr('data-row');
                $('.schedule_' + row + ' .sview').show();
                $('.schedule_' + row + ' .sedit').hide();
        });
        
        $('.save_schedule').click(function(){
                var row = $(this).attr('data-row');
                var quote_id = $(this).attr('data-quote');
                var title = $('.schedule_' + row + ' .schedule_title').val();
                var description = $('.schedule_' + row + ' .schedule_description').val();
                var date_from = $('.schedule_' + row + ' .from_date_' + row).val();
                var date_to = $('.schedule_' + row + ' .to_date_' + row).val();
                
                $('.schedule_' + row + ' .save_schedule i').removeClass('icon wb-check').addClass('fa fa-refresh fa-spin');
                
                var schedule_edit = "/wp-content/themes/go/project-templates/ajax/schedule_edit.php";
         	jQuery.ajax({
          	url: schedule_edit,
         	type: "POST",
        		dataType: "html",
        		data: { 
        			'row' : row,
                                'quote_id' : quote_id,
        			'title' : title,
                                'description' : description,
        			'date_from' : date_from,
                                'date_to' : date_to
        		},
         	success: function(response) {
                                $('#schedule_response').html(response);
        	 	},
        	error: function(response) {
        		     $('.schedule_actions .save_schedule i').removeClass('fa fa-refresh fa-spin').addClass('icon wb-check');
        	        }
          	});
        });
        
        $('.add_schedule').click(function(){
        	var schedule_add = '/wp-content/themes/go/project-templates/ajax/schedule_template.php';
         	jQuery.ajax({
          	url: schedule_add,
         	type: 'POST',
          	dataType: 'html',
        	data: { 
        		'load_schedule' : true
        	},
         	success: function(response) {
                        $('.schedule_add_error').remove();
                        $('#schedule_template').html(response);
        	 	},
        	error: function(response) {
                        $('.schedule_add_error').remove();
        		$('#schedule_template').html('<div class=\'text-center schedule_add_error margin-vertical-20 red-800\'>Something went wrong! Try Again.</div>');
        	}
          	});
        });
        
        $("#schedule_template").on("click",".cancel_schedule_add", function(){
                $('#schedule_template').html('');
        });

        $("#schedule_template").on("click",".save_schedule_add", function(){
        	var schedule_new = '/wp-content/themes/go/project-templates/ajax/schedule_new.php';
                var titles_valid = true;
                var titles = $('#schedule_template .titles').val();
                if(titles == '') {
                        titles_valid = false; 
                        alert('Schedule Title field can\'t be empty!');
                        return false;
                }
                var description = $('#schedule_template .description').val();
                var dates_valid = true;
                $('#schedule_template .dates').each(function() {
                        if(!$(this).val()){
                           alert('Schedule Date fields can\'t be empty!');
                           dates_valid = false;
                           return false;
                        }
                });
                if(dates_valid == false) {
                        return false;
                }
                if(titles_valid == true && dates_valid == true) {
                 	jQuery.ajax({
                  	url: schedule_new,
                 	type: 'POST',
                  	dataType: 'html',
                	data: jQuery('#add_schedule_row').serialize(),
                 	success: function(response) {
                                $('#schedule_new_response').html(response);
                	 	},
                	error: function(response) {
                		$('#schedule_new_response').html('<div class=\'text-center schedule_add_error margin-vertical-20 red-800\'>Something went wrong! Try again.</div>');
                	}
                  	});
                }
        
        });
        
});