$(document).ready(function() {
        $("#tasks").on("click",".add_task.btn-success", function(){
                $(this).removeClass('btn-success').addClass('btn-danger').html('Cancel');
                $('.tasks_form').fadeIn();
        });
        $("#tasks").on("click",".add_task.btn-danger", function(){
                $(this).removeClass('btn-danger').addClass('btn-success').html('Add Task');
                $('.tasks_form').fadeOut();
        });
        
        
	$(".save_task").click(function(){
                $(this).html('<i class="fa fa-refresh fa-spin"</i>');
                var newTask = $('input[name="task"]').val();
                
                $(".tasks_response").html("");
                if(newTask.length<1) {
                        $(this).html('Add');
                        $(".tasks_response").html("<div class='red-800'>You need to enter task!</div>");
                        return false;
                }
                
		var newTask = '/wp-content/themes/go/project-templates/ajax/save_task.php';
   	 	jQuery.ajax({
      	  	url: newTask,
       	 	type: "POST",
                        //dataType: "html",
			dataType: "json",
                        cache: false,
			data: $("#add_task").serialize(),
       	 	success: function(response) {
                                $('.save_task').html('Add');
                                $("input[name='task']").val("");
                                $(".tasks_response").html(response.message);
                                $(".tasks .list-task").append(response.task);
                                $(".no-tasks").hide();
   		 	},
    		error: function(response) {
                                $('.save_task').html('Add');
	 	                $(".tasks_response").html("<div class='red-800'>Something went wrong! Try again later.</div>");
    		        }
  	  	});
	});
        
        $("#tasks").on("change",".task_done_action", function(){
                $(this).removeClass('task_done_action');
                var row = $(this).attr('data-row');
                var quote_id = $(this).attr('data-quote');
                
		var doneTask = '/wp-content/themes/go/project-templates/ajax/done_task.php';
   	 	jQuery.ajax({
      	  	url: doneTask,
       	 	type: "POST",
                        //dataType: "html",
			dataType: "json",
                        cache: false,
			data: {
			        'quote_id' : quote_id,
                                'row' : row
			},
       	 	success: function(response) {
                                $('.task_row_' + row).prop('checked', true).prop('disabled', true);
                                $('.task_item_' + row).addClass('task_done');
   		 	},
    		error: function(response) {
                                $('.task_row_' + row).addClass('task_done_action').prop('checked', false);
    		        }
  	  	});
                
        });
        
});