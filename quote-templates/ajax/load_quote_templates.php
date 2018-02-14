<?php 
require_once("../../../../../wp-load.php");
// getting quote template id's to show user
echo "<script src='https://rawgit.com/enyo/dropzone/master/dist/dropzone.js'></script>
          <link rel='stylesheet' href='https://rawgit.com/enyo/dropzone/master/dist/dropzone.css'>";

$template_id = $_POST['quote_template'];
$template_count = count($template_id);
//var_dump($_POST);
// checking if user forget to select any template
if(!is_array($template_id) || empty($template_id)) {
	echo "<div class='text-center'>You need to select at least 1 quote template!</div>";
	echo "<script>$('.goto_2_step').html('Next Step');</script>";
	die;
}

// getting user's city from very first step
$city = $_POST['city'];
$urgent = $_POST['timeframe'];
$job_type = $_POST['type_install'];
$own_type = $_POST['type_status'];
// let's get all repeater fields from all templates one by one
$quote_cnt = 0;

// creating form to POST all data from all steps
echo "<form id='quote_form' enctype='multipart/form-data'>";

foreach($template_id as $t) {
	
	if(get_field('quantity',$t)) {
		$rooms_qnt = $_POST[$t];
	}
	else {
		$rooms_qnt = 1;
	}
	
	$total_slug = get_field('total_slug',$t);

        
	$quote_cnt++;
	if($quote_cnt == 1) {
		$quote_class = 'first_quote';
	}
	else {
		$quote_class = '';
	}
	
	
	// making main Panel html layout
	echo "<div class='panel step_quote " . $quote_class . "' style='display:none;'><div class='panel-body'>";
	echo "<div class='pearls row'><div class='pearl current col-xs-4' aria-expanded='true'><div class='pearl-icon'><i class='con wb-user' aria-hidden='true'></i></div><span class='pearl-title'>Choose Project(s)</span></div>";
  echo "<div class='pearl current col-xs-4' aria-expanded='true'><div class='pearl-icon'><i class='icon wb-payment' aria-hidden='true'></i></div><span class='pearl-title'>Fill Out Details</span></div>";
  echo "<div class='pearl current col-xs-4' aria-expanded='true'><div class='pearl-icon'><i class='icon wb-check' aria-hidden='true'></i></div><span class='pearl-title'>Get Your Price</span></div></div>";
	
	echo "<input type='hidden' name='templates[]' value='" . $t . "'>";
        echo "<input type='hidden' name='" . $total_slug . "_rooms' value='" . $rooms_qnt . "'>";
	
	echo "<h1 class='text-center margin-bottom-40'>" . get_the_title($t) . "</h1>";
	
	$rooms = 1;
	while($rooms <= $rooms_qnt) :
	$label = get_field('name_single',$t);
	if($rooms_qnt > 1) { echo "<h3 class='text-center margin-bottom-40'>". $label . " : " . $rooms . "</h3>"; }
	
	if( have_rows('quote_fields',$t) ) {
		
		while ( have_rows('quote_fields',$t) ) : the_row();
			
			
			// checking if this template has Width and Height rows
			if( get_row_layout() == 'width_and_height' ) {
				echo "<div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>" . get_sub_field('title') . "</h4><div class='text-center'>" . get_sub_field('description') . "</div>";
				echo "<div class='row'><div class='col-md-6 col-md-offset-3'><div class='row'>";
				echo "<div class='col-md-6 text-center'><div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>Width (approx in metres)</h4><div class='form-group text-center'>";
				echo "<input type='number' class='form-control' name='" . $total_slug . "_" . get_sub_field('slug') . "_width_" . $rooms . "' min='1' value='1'>";
				echo "</div></div>";
				echo "<div class='col-md-6 text-center'><div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>Length (approx in metres)</h4><div class='form-group text-center'>";
				echo "<input type='number' class='form-control' name='" . $total_slug . "_" . get_sub_field('slug') . "_length_" . $rooms . "' min='1' value='1'>";
				echo "</div></div>";
				echo "</div></div></div>";
			}
		
	    if( get_row_layout() == 'panel_title' ) {
				echo "<h3 class='text-center'>" . get_sub_field('title') . "</h3><div class='text-center'><p class='text-center'>" . get_sub_field('description') . "</p></div>";
			}
			
		        // checking if this template has Width and Height rows
			if( get_row_layout() == 'length' ) {
				echo "<div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>" . get_sub_field('title') . "</h4><div class='text-center'>" . get_sub_field('description') . "</div>";
				echo "<div class='row'><div class='col-md-12'><div class='row'>";
				echo "<div class='col-md-6 col-md-offset-3 text-center'><div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>Length (approx in metres)</h4><div class='form-group text-center'>";
				echo "<input type='number' class='form-control' name='" . $total_slug . "_" . get_sub_field('slug') . "_width_" . $rooms . "' min='1' value='1'>";
				echo "</div></div>";
				echo "</div></div></div>";
			}
		
			// checking if this template has Image radio or checkbox rows
			if( get_row_layout() == 'fields' ) {
				$slug = get_sub_field('slug');
				$type = get_sub_field('type_of_fields');
				if($type == "Checkbox") { $type = 'checkbox'; $type_array = '[]'; }
				elseif($type == "Radio") { $type = 'radio'; $type_array = ''; }
				echo "<div id=". $slug . " class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>" . get_sub_field('title') . "</h4><div class='text-center'>" . get_sub_field('description') . "</div><div class='form-group text-center'>";
				
				$i=0;	
				while(has_sub_field('fields')) :
					$qnt = get_sub_field('quantity');
					$value = get_sub_field('title');
          $value_string = get_sub_field('title');
					$value = preg_replace("/[^a-zA-Z]/", "", $value);
                                        $tooltip = get_sub_field('tooltip');
                                        if($tooltip != '') {
                                                $tooltit_text = 'data-toggle="tooltip" data-placement="top" data-trigger="hover" data-original-title="' . $tooltip . '" title=""';
                                        }
                                        else {
                                             $tooltit_text = '';   
                                        }
                                        
					$value = strtolower($value);
					echo "<label class='styled_in_ajax' " . $tooltit_text . ">";
					echo "<input class='chr' type='" . $type . "' title name='" . $total_slug . "_" . $slug . "_" . $rooms . $type_array . "' value=\"" . $value_string . "\">";
					echo "<img src=" . get_sub_field('image') . ">";
					echo "<span>" . get_sub_field('title') . "</span>";
					if($qnt == true) {
						echo "<input class='qnt' type='number' name='" . $total_slug . "_" . $value . "_" . $rooms . "' id='" . $total_slug . "_" . $value . "_" . $rooms . "' min='1' step='1' value='1'>";
					}
					echo "</label>";
				$i++;	
				endwhile;
				
				echo "</div>";
			}
			
		if( get_row_layout() == 'additional_notes' ) {
				echo "<style>{display: none; visibility: hidden}</style>";
			}
			
			// checking if this template has Note
			if( get_row_layout() == 'additional_notes' ) {
				echo "<div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>" . get_sub_field('title') . "</h4><div class='text-center'>" . get_sub_field('description') . "</div>";
				echo "<div class='row'><div class='col-md-6 col-md-offset-3'><div class='row'>";
				echo "<div class='form-group text-center margin-top-10'>";
				echo "<textarea class='quote_textarea' name='" . $total_slug . "_" . get_sub_field('slug') . "_" . $rooms . "'></textarea>";
				echo "</div>";
				echo "</div></div></div>";
			}
			
			// checking if this template has Note
			if( get_row_layout() == 'additional_photos' ) {
				echo "<div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>" . get_sub_field('title') . "</h4><div class='text-center'>" . get_sub_field('description') . "</div>";
				echo "<div class='row'><div class='col-md-10 col-md-offset-1 margin-top-20'><div class='row'>";
                                
				echo "<div class='col-md-12'>";
				echo "<div class='form-group text-center'>
                                        <div class='photos_upload_" . $total_slug . "_" . get_sub_field('slug') . "_" . $rooms . "'>
                                                <div style='display:none;' class='uploading'><i class='fa fa-spin fa-refresh'></i></div>
                                                <input style='margin: 0 auto;' type='file' name='" . $total_slug . "_" . get_sub_field('slug') . "_" . $rooms . "' id='" . $total_slug . "_" . get_sub_field('slug') . "_" . $rooms . "' class='file_upload'>
                                                <div style='margin-top:20px;' class='" . $total_slug . "_" . get_sub_field('slug') . "_" . $rooms . "'></div>
                                        </div>
                                </div>";
				echo "<script>$('#" . $total_slug . "_" . get_sub_field('slug') . "_" . $rooms . "').change(function(){ UploadImage('" . $total_slug . "_" . get_sub_field('slug') . "_" . $rooms . "'); $('.photos_upload_" . $total_slug . "_" . get_sub_field('slug') . "_" . $rooms . " input').hide(); $('.photos_upload_" . $total_slug . "_" . get_sub_field('slug') . "_" . $rooms . " .uploading').show(); });
                                $('." . $total_slug . "_" . get_sub_field('slug') . "_" . $rooms . "').on('click','.uploaded_image_section i',function(){ $(this).parent().parent().remove(); });
                                </script>";
				echo "</div>";
				
				echo "</div></div></div>";
			}
			
			
		
		endwhile;
		
	}
	
	echo "<hr />";
	
	$rooms++;
	endwhile;

	echo "<div class='row text-center'>";

	//making previous button if it's not 1 quote
	if($quote_cnt != 1) {
		echo "<a class='btn btn-default btn-round btn-sm margin-top-40 margin-horizontal-10 goto_prev_step'>back</a>";
	}
        elseif($quote_cnt == 1) {
                echo "<a class='btn btn-default btn-round btn-sm margin-top-40 margin-horizontal-10' href='" . get_bloginfo('url') . "/new_quote'>restart</a>";
        }

	echo "<a class='btn btn-info btn-round btn-lg margin-top-40 margin-horizontal-10 goto_next_step'>Next Step</a>";

	echo "</div>";

	// closing main Panel html layout
	echo "</div></div>";		
	
}


// making last final step to make a quote

// making main Panel html layout
if(is_user_logged_in()) {
	$current_user_id = current_user_id(); $current_user_data = get_userdata($current_user_id);
	$first_name = $current_user_data->first_name;
	$last_name = $current_user_data->last_name;
	$email = $current_user_data->user_email;
	$phone = get_field('phone','user_' . $current_user_id);
	$address = get_field('address','user_' . $current_user_id);
}
else {
	$first_name = NULL;
	$last_name = NULL;
	$email = NULL;
	$phone = NULL;
	$address = NULL;
}
echo "<div class='panel step_quote' style='display:none;'><div class='panel-body'>";
echo "<h1 class='text-center margin-bottom-40'>Personal Information</h1><div class='example-wrap margin-sm-0'></div>";

if(!is_user_logged_in()) {
        echo "<div class='row hidden_on_success'>
                        <div class='col-md-12 text-center'>
                                <div class='text-center'><h2>You are guest! Want to sign in or create new account?</h2></div>
                                <div style='display:inline-block;' class='margin-horizontal-10 text-center radio-custom radio-danger'><input type='radio' value='sign_in' id='sign_in' class='quote_guest' name='quote_guest'><label for='sign_in'>Sign In</label></div>
                                <div style='display:inline-block;' class='margin-horizontal-10 text-center radio-custom radio-success'><input type='radio' value='register' id='register' class='quote_guest' name='quote_guest' checked><label for='register'>Create New</label></div>
                        </div>
                </div>
                <div class='row register_me margin-vertical-20'>
                        <div class='col-md-12 text-center '>
                                <p>Fill the form below and your account will be created. We'll send you the full quote on email.</p>
                        </div>
                </div>
                <div class='row login_me margin-vertical-20'>
                        <div class='col-md-4 col-md-offset-4 text-center'>
                                <div class='row hidden_on_success'>
                                        <h4 class='example-title text-center'>E-mail</h4>
                                        <div class='form-group text-center'>
                                                <input type='email' class='form-control guest_login_email' name='login_email'>
                                        </div>
                                </div>
                                <div class='row hidden_on_success'>
                                        <h4 class='example-title text-center'>Password</h4>
                                        <div class='form-group text-center'>
                                                <input type='password' class='form-control guest_login_password' name='login_password'>
                                        </div>
                                </div>
                                <div class='row hidden_on_success'>
                                        <a class='btn btn-info btn-round btn-lg margin-horizontal-10' id='guest_login'>Sign In</a>
                                </div>
                        </div>
                </div>";
                echo "<div class='row' id='guest_login_response'></div>";
}

if(is_agent()) {
        echo "<style>.quote_client_info {display:none;}</style>";
        $current_user_id = current_user_id();
        $agents_clients = get_field('contacts','user_' . $current_user_id);
        $agents_clients_only = array();
        foreach($agents_clients as $contact) {
                $user_type = get_field('user_type','user_' . $contact['ID']);
                if($user_type == 'Client') {
                        $agents_clients_only[] = $contact['ID'];
                }
        }
	$first_name = NULL;
	$last_name = NULL;
	$email = NULL;
	$phone = NULL;
	$address = NULL;
        echo "<div class='row agent_section'>
                        <div class='col-md-4 col-md-offset-4 text-center'>
                                <div class='text-center'><h2>Select client for this quote</h2></div>
                                <div class='what_is_selected_agent' style='display:none'>0</div>
                                <div style='display:inline-block;' class='margin-horizontal-10 text-center radio-custom radio-primary'><input type='radio' value='select_from_list' id='select_from_list' class='quote_agent' name='quote_agent' checked><label for='select_from_list'>Select from list</label></div>
                                <div style='display:inline-block;' class='margin-horizontal-10 text-center radio-custom radio-success'><input type='radio' value='create_new' id='create_new' class='quote_agent' name='quote_agent' ><label for='create_new'>Create New</label></div>
                        </div>
                </div>
                <div class='row select_from_list margin-vertical-20'>
                        <div class='col-md-12 text-center '>
                                <p>Select your client from list below</p>
                        </div>
                        
                        <div class='row'>
                                <div class='col-md-4 col-md-offset-4'>
                                <div class='form-group text-center'>
                                        <select name='agents_client' class='form-control select_agent_client'>";
                                        if(!empty($agents_clients_only) && is_array($agents_clients_only)) {
                                                echo "<option value='0'>Select your client</option>";
                                                foreach ($agents_clients_only as $client) {
                                                        $client_data = get_userdata($client);
                                                        $first_client_name = $client_data->first_name;
                                                        $last_client_name = $client_data->last_name;
                                                        echo "<option value='" . $client . "'>" . $first_client_name . " " . $last_client_name . "</option>";
                                                }
                                        }
                                        else {
                                               echo "<option value='0'>You have no client yet!</option>"; 
                                        }
                                        echo "</select>";
                                echo "</div>
                                </div>
                        </div>
                </div>
                <div class='row create_new_agent margin-vertical-20' style='display:none;'>
                        <div class='col-md-4 col-md-offset-4 text-center'>
                                <div class='col-md-12 text-center '>
                                        <p>Fill form below with client's data. They will recieve email with all details.</p>
                                </div>
                        </div>
                </div>";
}

if(is_headcontractor()) {
        echo "<style>.quote_client_info {display:none;}</style>";
        $current_user_id = current_user_id();
        $agents_clients = get_users( array( 'meta_key' => 'user_type', 'meta_value' => 'Client', 'number' => 9999 ) );
	$first_name = NULL;
	$last_name = NULL;
	$email = NULL;
	$phone = NULL;
	$address = NULL;
        echo "<div class='row agent_section'>
                        <div class='col-md-4 col-md-offset-4 text-center'>
                                <div class='text-center'><h2>Select client for this quote</h2></div>
                                <div class='what_is_selected_agent' style='display:none'>0</div>
                                <div style='display:inline-block;' class='margin-horizontal-10 text-center radio-custom radio-primary'><input type='radio' value='select_from_list' id='select_from_list' class='quote_agent' name='quote_agent' checked><label for='select_from_list'>Select from list</label></div>
                                <div style='display:inline-block;' class='margin-horizontal-10 text-center radio-custom radio-success'><input type='radio' value='create_new' id='create_new' class='quote_agent' name='quote_agent' ><label for='create_new'>Create New</label></div>
                        </div>
                </div>
                <div class='row select_from_list margin-vertical-20'>
                        <div class='col-md-12 text-center '>
                                <p>Select your client from list below</p>
                        </div>
                        
                        <div class='row'>
                                <div class='col-md-4 col-md-offset-4'>
                                <div class='form-group text-center'>
                                        <select name='agents_client' class='form-control select_agent_client'>";
                                        if(!empty($agents_clients) && is_array($agents_clients)) {
                                                echo "<option value='0'>Select your client</option>";
                                                foreach ($agents_clients as $client) {
                                                        //var_dump($client);
                                                        $client_data = get_userdata($client->data->ID);
                                                        $first_client_name = $client_data->first_name;
                                                        $last_client_name = $client_data->last_name;
                                                        echo "<option value='" . $client->data->ID . "'>" . $first_client_name . " " . $last_client_name . "</option>";
                                                }
                                        }
                                        echo "</select>";
                                echo "</div>
                                </div>
                        </div>
                </div>
                <div class='row create_new_agent margin-vertical-20' style='display:none;'>
                        <div class='col-md-4 col-md-offset-4 text-center'>
                                <div class='col-md-12 text-center '>
                                        <p>Fill form below with client's data. They will recieve email with all details.</p>
                                </div>
                        </div>
                </div>";
}


echo "<div class='row user_details_fields'><div class='col-md-4 col-md-offset-4'><div class='row' margin-top-40>";
echo "<div class='quote_client_info'>";
echo "<div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>First Name</h4><div class='form-group text-center'>";
echo "<input type='text' class='form-control' name='first_name' value='" . $first_name . "'>";
echo "</div>";
	
echo "<div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>Last Name</h4><div class='form-group text-center'>";
echo "<input type='text' class='form-control last_name_input' name='last_name' value='" . $last_name . "'>";
echo "</div>";

if($email != NULL) { $disabled = 'disabled'; $note = '<p>You can change email in your Account.</p>'; } else { $disabled = NULL; $note = NULL; }
echo "<div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center user_email'>Email</h4><div class='form-group text-center'>";
echo $note . "<input type='email' class='form-control' name='email' value='" . $email . "' $disabled>";
echo "</div>";

if(!is_user_logged_in()) {
echo "<div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>Password</h4><div class='form-group text-center'>";
echo "<input type='text' class='form-control' name='new_user_password'>";
echo "</div>";
}

echo "<div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>Phone</h4><div class='form-group text-center'>";
echo "<input type='text' class='form-control' name='phone' value='" . $phone . "'>";
echo "</div>";

echo "<div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>Address</h4><div class='form-group text-center'>";
echo "<input type='text' class='form-control' name='address' value='" . $address . "'>";
echo "</div>";

echo "<input type='hidden' name='city' value='" . $city . "'>";
echo "<input type='hidden' name='job_type' value='" . $job_type . "'>";
echo "<input type='hidden' name='status' value='" . $job_status . "'>";

echo "</div>";

echo "<div class='row text-center'>";
echo "<a class='btn btn-default btn-round btn-sm margin-top-40 margin-horizontal-10 goto_prev_step last_prev'>back</a>";
echo "<a class='btn btn-info btn-round btn-lg margin-top-40 margin-horizontal-10' id='goto_quotesave_step'>Finish Quote</a>";
echo "</div>";

echo "</div></div></div>";
// closing main Panel html layout
echo "</div></div>";

echo "</form>";

echo "<div id='quote_proceed_response'></div>";

// making scripts to hide first step
echo "<script>$(function() { $('.chr').tooltip(); });</script>";
echo "<script>
        $('.quote_guest').change(function(){
                var guest = $(this).val();
                if(guest == 'sign_in') {
                        $('.register_me').hide();
                        $('.login_me').show();
                }
                else {
                        $('.login_me').hide();
                        $('.register_me').show();
                }
        });
        $('#guest_login').click(function(){
                $(this).html('<i class=\'fa fa-refresh fa-spin\'></i>');
	        var guest_login = '/wp-content/themes/go/quote-templates/ajax/guest_login.php';
                var login = $('.guest_login_email').val();
                var password = $('.guest_login_password').val();
  	 	jQuery.ajax({
     	  	url: guest_login,
      	 	type: 'POST',
     	  	dataType: 'html',
		data: {
                        'login' : login,
                        'password' : password
                },
      	 	success: function(response) {
			$('#guest_login_response').html('');
      		 	$('#guest_login_response').html(response);
 		        $('#guest_login_response').find('script').each(function(i) {
				eval($(this).text());
			});
  		 	},
   		error: function(response) {
			$('#guest_login').html('Sign In');
   			$('#guest_login_response').html('<div class=\'text-center\'>Something went wrong, Try again</div>');
   		}
 	  	});
        });
        
        $('.agent_section').on('change','.quote_agent', function(){
                var agent_client = $(this).val();
                if(agent_client == 'select_from_list') {
                        $('.what_is_selected_agent').html('0');
                        $('.row.select_from_list').show();
                        $('.row.create_new_agent').hide();
                        $('.quote_client_info').hide();
                        
                }
                else {
                        $('.what_is_selected_agent').html('1');
                        $('#create_new').prop('checked', true);
                        $('.row.select_from_list').hide();
                        $('.row.create_new_agent').show();
                        $('.quote_client_info').show();
                }
        });
        
        </script>";
echo "<script>
        $('#step1').hide();
        $('.first_quote').fadeIn('slow');
        $('.goto_next_step').click(function(){
                window.scrollTo(0, 0);
                $(this).parent().parent().parent('.step_quote').hide();
                $(this).closest('.step_quote').next('.step_quote').fadeIn('slow');
        });
        $('.goto_prev_step').click(function(){
                $(this).closest('.step_quote').hide();
                $(this).closest('.step_quote').prev('.step_quote').fadeIn('slow');
        });
        </script>";
if(is_agent() || is_headcontractor()) {
        echo "<script>$('#goto_quotesave_step').click(function(){ 
                var agent_client = $('.what_is_selected_agent').html();
                if(agent_client == '0') {
                        var check_client = $('.select_agent_client').val(); 
                        if(check_client == '0') { 
                                alert('You need to select client or create new one!'); return false; 
                        }
                        else {
                                MakeQuote(0); return false; 
                        }
                }
         });</script>";
}
echo "<script>$('#goto_quotesave_step').click(function(){ MakeQuote(1); }); $('body').tooltip({ selector: '[data-toggle=\"tooltip\"]' });</script>";
?>