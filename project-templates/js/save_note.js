$(document).ready(function() {
        $("#notes").on("click",".add_note.btn-success", function(){
                $(this).removeClass('btn-success').addClass('btn-danger');
                $(this).find('i').removeClass('wb-plus').addClass('wb-close');
                $('.notes_form').fadeIn();
        });
        $("#notes").on("click",".add_note.btn-danger", function(){
                $(this).removeClass('btn-danger').addClass('btn-success');
                $(this).find('i').removeClass('wb-close').addClass('wb-plus');
                $('.notes_form').fadeOut();
        });
        
        
	$(".save_note").click(function(){
                $(this).html('<i class="fa fa-refresh fa-spin"</i>');
                var newNote = $('textarea[name="note"]').val();
                
                $(".notes_response").html("");
                if(newNote.length<1) {
                        $(this).html('Save');
                        $(".notes_response").html("<div class='red-800'>You need to enter Note text!</div>");
                        return false;
                }
                
		var newNote = '/wp-content/themes/go/project-templates/ajax/save_note.php';
   	 	jQuery.ajax({
      	  	url: newNote,
       	 	type: "POST",
                        //dataType: "html",
			dataType: "json",
                        cache: false,
			data: $("#add_note").serialize(),
       	 	success: function(response) {
                                $('.save_note').html('Save');
                                $("textarea[name='note']").val("");
                                $(".notes_response").html(response.message);
                                $(".project_notes").append(response.note);
   		 	},
    		error: function(response) {
                                $('.save_note').html('Save');
	 	                $(".notes_response").html("<div class='red-800'>Something went wrong! Try again.</div>");
    		        }
  	  	});
	});
});