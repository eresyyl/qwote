function validateEmail($email) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        return emailReg.test( $email );
}
$(document).ready(function() {

        $("#add_contact").on("click",".contact_search",function(){
                var contact_email = $('input[name=contact_email]').val();
                $(".contact_search_respopnse").html('<div class="text-center margin-bottom-20"><i class="fa fa-refresh fa-spin"</i></div>');

                if(contact_email.length<1) {
                        $(".contact_search_respopnse").html("<div class='red-800 margin-bottom-20'>You need to enter Email!</div>");
                        return false;
                }
        /*
        else if( !validateEmail(contact_email)) {
                        $(".contact_search_respopnse").html("<div class='red-800 margin-bottom-20'>You need to enter valid Email!</div>");
                        return false;
		}
        */

		var findContact = '/wp-content/themes/go/contacts-templates/ajax/find_contact.php';
   	 	jQuery.ajax({
      	  	url: findContact,
       	 	type: "POST",
                        dataType: "html",
			//dataType: "json",
                        //cache: false,
			data: {
			        'contact_email' : contact_email
			},
       	 	success: function(response) {
                                $(".contact_search_respopnse").html(response);
   		 	},
    		error: function(response) {
	 	                $(".contact_search_respopnse").html("<div class='red-800 margin-bottom-20'>Something went wrong! Try again later.</div>");
    		        }
  	  	});
	});

        $(".contact_search_respopnse").on("click",".add_this_contact",function(){
                var contact_id = $(this).data("contact");
                $(this).html('<i class="fa fa-refresh fa-spin"</i>');

		var addContact = '/wp-content/themes/go/contacts-templates/ajax/add_contact.php';
   	 	jQuery.ajax({
      	  	url: addContact,
       	 	type: "POST",
                        dataType: "html",
			//dataType: "json",
                        //cache: false,
			data: {
			        'contact_id' : contact_id
			},
       	 	success: function(response) {
                                //$(".contact_search_respopnse").html(response);
                                $(".contact_search_respopnse").html("<div class='green-600 margin-bottom-20'>Contact added! Page will be reloaded...</div>");
                                setTimeout("location.reload()", 3000);
   		 	},
    		error: function(response) {
	 	                $(".contact_search_respopnse").html("<div class='red-800 margin-bottom-20'>Something went wrong! Try again later.</div>");
    		        }
  	  	});
	});

        $(".contact_search_respopnse").on("click",".new_user",function(){
                var User_Type = $('select[name=user_type]').val();
                var E_mail = $('input[name=e_mail]').val();
                var FirstName = $('input[name=first_name]').val();
                var LastName = $('input[name=last_name]').val();
                var Phone = $('input[name=phone]').val();
                var Address = $('input[name=address]').val();

                if(FirstName.length<1) {
                        $(".new_user_response").html("<div class='red-800 margin-bottom-20'>You need to enter First name!</div>");
                        return false;
                }
                if(LastName.length<1) {
                        $(".new_user_response").html("<div class='red-800 margin-bottom-20'>You need to enter Last name!</div>");
                        return false;
                }
                if(Phone.length<1) {
                        $(".new_user_response").html("<div class='red-800 margin-bottom-20'>You need to enter Phone!</div>");
                        return false;
                }
                if(Address.length<1) {
                        $(".new_user_response").html("<div class='red-800 margin-bottom-20'>You need to enter Address!</div>");
                        return false;
                }

		var userCreate = '/wp-content/themes/go/contacts-templates/ajax/new_user.php';
   	 	jQuery.ajax({
      	  	url: userCreate,
       	 	type: "POST",
                        dataType: "html",
			//dataType: "json",
                        //cache: false,
			data: {
                                'user_type' : User_Type,
			                          'e_mail' : E_mail,
                                'first_name' : FirstName,
                                'last_name' : LastName,
                                'phone' : Phone,
                                'address' : Address
			},
       	 	success: function(response) {
                                //$(".new_user_response").html(response);
                                $(".new_user_response").html("<div class='green-600 margin-bottom-20'>Contact created! Page will be reloaded...</div>");
                                setTimeout("location.reload()", 3000);
   		 	},
    		error: function(response) {
	 	                $(".new_user_response").html("<div class='red-800 margin-bottom-20'>Something went wrong! Try again later.</div>");
    		        }
  	  	});

        });
});
