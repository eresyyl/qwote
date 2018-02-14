<?php 
/*
This is AJAX function to save_note
*/
require_once("../../../../../wp-load.php");
$current_user_id = current_user_id();
$current_user_data = go_userdata($current_user_id);
$contact_email = $_POST['contact_email'];

$contact_finded = get_user_by('email',$contact_email);
$contact_list = get_field('contacts','user_' . $current_user_id);
foreach($contact_list as $c) {
        if(is_array($c)) { $c_id = $c['ID']; }
        else { $c_id = $c; }
        $contact_list_temp[] = $c_id;
}

if($contact_finded == false) {
        $message = "<div class='text-center red-800 margin-bottom-20'>There is no user with such email!</div>";
        $message .= "<div class='text-center green-600 margin-bottom-20'>But you can create it using form below:</div>";
        $message .= "<div class='row'><div class='col-md-8 col-md-offset-2'>
                        <input type='hidden' value='" . $contact_email . "' name='e_mail'>
                        <div class='form-group form-control-default required'>
                                <select name='user_type' class='form-control'>
                                        <option value='contractor' selected>Contractor</option>
                                        <option value='client'>Client</option>
                                </select>
                        </div>
                        <div class='form-group form-control-default required'>
                                <input name='first_name' type='text' class='form-control' id='InputFirstName' placeholder='User first name'>
                        </div>
                        <div class='form-group form-control-default required'>
                                <input name='last_name' type='text' class='form-control' id='InputLastName' placeholder='User last name'>
                        </div>
                        <div class='form-group form-control-default required'>
                                <input name='phone' type='text' class='form-control' id='InputPhone' placeholder='User phone'>
                        </div>
                        <div class='form-group form-control-default required'>
                                <input name='address' type='text' class='form-control' id='InputAddress' placeholder='User address'>
                        </div>
                        <div class='new_user_response'></div>
                        <div class='text-center margin-bottom-20'><a class='btn btn-primary new_user'>Create User</a></div>
        </div></div>";
}
elseif($current_user_data->email == $contact_email) {
        $message = "<div class='text-center red-800 margin-bottom-20'>You entered your email!</div>";
}
elseif(in_array($contact_finded->data->ID,$contact_list_temp)) {
        $message = "<div class='text-center red-800 margin-bottom-20'>This user is already in your contact list!</div>";
}
else {
        $contact_finded_data = go_userdata($contact_finded->data->ID);
        $message = "<div class='row margin-bottom-40 margin-top-20' style='line-height: 30px;'><div class='col-md-8 col-md-offset-2'>
                <div class='avatar avatar-sm margin-right-10'><img src='" . $contact_finded_data->avatar . "' alt=''></div>
                <div class='label label-default margin-right-10'>" . $contact_finded_data->type . "</div>" . $contact_finded_data->first_name . " " . $contact_finded_data->last_name . "<a class='btn btn-inline btn-primary btn-xs margin-left-20 add_this_contact' data-contact='" . $contact_finded->data->ID . "'>Add to Contacts</a></div></div>";
}
echo $message;
//echo json_encode( array("message" => $message) );
die;
?>