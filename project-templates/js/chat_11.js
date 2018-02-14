$(document).ready(function() {
        $('.refresh_chat').click(function(){
                var quote_id = $(this).attr('data-project');
                LoadChat(quote_id);
        });
        $('.add_attachment').click(function(){
                //$( "#attach" ).val('');
                $( "#attach" ).trigger( "click" );
        });
        $('.attach').on('click','.uploaded_image_section i',function(){
                //$('.add_attachment').show();
                $(this).closest('.uploaded_image_section').remove();
        });
        $('#attach').change(function(){
                $('.add_attachment i').removeClass('icon').removeClass('wb-attach-file').addClass('fa').addClass('fa-spin').addClass('fa-refresh');
                //$('.attach').html('<i style="margin-top:20px" class="fa fa-spin fa-refresh"></i>&nbsp;&nbsp;uploading...');
                var $input = $("#attach");
                var fd = new FormData;

                fd.append('img', $input.prop('files')[0]);
            	fd.append('location', location);

                $.ajax({
                    url: '/wp-content/themes/go/project-templates/ajax/chat_attachment.php',
                    data: fd,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    success: function (data) {
            		   $('.add_attachment i').removeClass('fa').removeClass('fa-spin').removeClass('fa-refresh').addClass('icon').addClass('wb-attach-file');
                           $('#attach').val('');
                           $('.attach').append(data);
                    }
                });     
        });
        $('.message_sent').click(function(){
                $(this).html("<i class='fa fa-refresh fa-spin'></i>");
                var quote_id = $(this).attr('data-project');
                var message = $('.message_text').val();
                //var attachment = $('.attachment').val();
                var attachments_arr = [];
                var attachment = $('.attachment').each(function() {
                    attachments_arr.push($(this).val());
                });
                var sent_message = "/wp-content/themes/go/project-templates/ajax/sent_message.php";
         	jQuery.ajax({
          	url: sent_message,
         	type: "POST",
        		dataType: "html",
        		data: { 
        			'quote_id' : quote_id,
                                'message' : message,
                                'attachment' : attachments_arr
        		},
         	success: function(response) {
                        
        		    $('.message_text').val('');    
                            LoadChat(quote_id);
                            $('.message_sent').html("SEND");
                            $('.attach').html(response);
        	 	},
        	error: function(response) {
        		     $('.message_sent').html("SEND");  
        	        }
          	});
                
        });
        
});

function LoadChat(quote_id) {
        $('.app-message-chats').scrollTop($('.app-message-chats')[0].scrollHeight);
        $("#chat_messages").html("<div class='text-center margin-bottom-20'><i class='fa fa-refresh fa-spin'></i></div>");
        var load_chat = "/wp-content/themes/go/project-templates/ajax/load_chat.php";
        var quote_id = quote_id;
        var user_id = user_id;
 	jQuery.ajax({
  	url: load_chat,
 	type: "POST",
		dataType: "html",
		data: { 
			'quote_id' : quote_id,
                        'user_id' : user_id
		},
 	success: function(response) {
		        $("#chat_messages").html("");
	 	        $("#chat_messages").html(response);
                        $('.app-message-chats').scrollTop($('.app-message-chats')[0].scrollHeight);
	 	},
	error: function(response) {
		        $("#chat_messages").html("<div class='text-center margin-bottom-20'>Can't load updates! Please, try to refresh page.</div>");
	        }
  	});
}