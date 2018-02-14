<?php 
/*
This is AJAX function make invoice Paid
*/
require_once("../../../../../wp-load.php");
if($_POST) {
        $login = $_POST['login'];
        $password = $_POST['password'];
        
        if($login == '' || $password == '') {
                echo "<div class='margin-top-10 red-800'>You need to enter your Login and Password</div>";
                echo "<script>$('#guest_login').html('Sign In');</script>";
                die;
        }
        
	$creds = array();
	$creds['user_login'] = $login;
	$creds['user_password'] = $password;
	$creds['remember'] = true;
        $user = wp_signon( $creds, false );
        
        if ( is_wp_error($user) ) {
                echo "<div class='margin-top-10 red-800'>Invalid Login or Password!</div>";
                echo "<script>$('#guest_login').html('Sign In');</script>";
                die;  
        }
        else {
                
                $user_data = go_userdata($user->ID);
                if($user_data->type == 'Client') {
                        echo "<div class='margin-top-10 green-600'>Successfully signed in!</div>";
                        echo "<script>
                                $('#guest_login').html('Sign In');
                                $('.hidden_on_success').hide();
                                $('input[name=first_name]').val('" . $user_data->first_name . "');
                                $('input[name=last_name]').val('" . $user_data->last_name . "');
                                $('input[name=email]').val('" . $user_data->email . "').attr('disabled', true);
                                $('input[name=phone]').val('" . $user_data->phone . "');
                                </script>";
                        die;
                }
                elseif($user_data->type == 'Agent') {
                        $agents_clients = get_field('contacts','user_' . $user->ID);
                        $agents_clients_only = array();
                        foreach($agents_clients as $contact) {
                                $user_type = get_field('user_type','user_' . $contact['ID']);
                                if($user_type == 'Client') {
                                        $agents_clients_only[] = $contact['ID'];
                                }
                        }
                        echo "<div class='margin-bottom-20 green-600 text-center'>Successfully signed in!</div>";
                        
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
                                                        <p>Fill form below with client's data. they will recieve an email with all details.</p>
                                                </div>
                                        </div>
                                </div>";
                                
                        
                        echo "<script>
                                $('.quote_client_info').hide();
                                $('#guest_login').html('Sign In');
                                $('.hidden_on_success').hide();
                                $('input[name=first_name]').val('');
                                $('input[name=last_name]').val('');
                                $('input[name=email]').val('');
                                $('input[name=phone]').val('');
                                
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
                        
                        die; 
                }
                elseif($user_data->type == 'Head') {
                        $agents_clients = get_users( array( 'meta_key' => 'user_type', 'meta_value' => 'Client', 'number' => 9999 ) );
                        echo "<div class='margin-bottom-20 green-600 text-center'>Successfully signed in!</div>";
                        
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
                                                        <p>Fill form below with client's data. They will recieve an email with all the details.</p>
                                                </div>
                                        </div>
                                </div>";
                                
                        
                        echo "<script>
                                $('.quote_client_info').hide();
                                $('#guest_login').html('Sign In');
                                $('.hidden_on_success').hide();
                                $('input[name=first_name]').val('');
                                $('input[name=last_name]').val('');
                                $('input[name=email]').val('');
                                $('input[name=phone]').val('');
                                
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
                        
                        die; 
                }
                if($user_data->type == 'Contractor') {
                        echo "<div class='margin-top-10 green-600'>You are signed in as Contractor! You will be redirected to Dashboard!</div>";
                        echo "<script>
                                $('#guest_login').html('Sign In');
                                $('.hidden_on_success').hide();
                                $('input[name=first_name]').val('');
                                $('input[name=last_name]').val('');
                                $('input[name=email]').val('');
                                $('input[name=phone]').val('');
                                </script>";
                        wp_redirect(home_url() . "/dash");
                        die;
                }
                
        }
        
        
}
else {
        echo "<div class='margin-top-10 red-800'>Something went wrong, Try Again!</div>";
        echo "<script>$('#guest_login').html('Sign In');</script>";
        die; 
}
?>