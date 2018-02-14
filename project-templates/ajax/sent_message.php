<?php
/*
This is AJAX function to save messages from project chat
*/
require_once("../../../../../wp-load.php");
$date = date('d/m/Y H:i');
$current_user_id = current_user_id();
$user_data = go_userdata($current_user_id);
$who = $user_data->first_name . " " . $user_data->last_name;

if($_POST) {
        $quote_id = $_POST['quote_id'];

        $client_id = get_field('client_id',$quote_id);
        $agent_id = get_field('agent_id',$quote_id);
        $contractor_id = get_field('contractor_id',$quote_id);
        $head_id = get_field('head','options');


        $message = $_POST['message'];
        if($message) {
                $message = $message;
        }
        else {
                $message = null;
        }

        $attachment = $_POST['attachment'];
        if($attachment) {
                $attachment_arr = array();
                foreach($attachment as $a) {
                        $attachment_arr[] = intval($a);
                }
                $attachment = $attachment_arr;
        }
        else {
                $attachment = null;
        }

        if($message != null || $attachment != null) {

                $messages = get_field('messages',$quote_id);
                $messages_temp = array();
                foreach($messages as $m) {
                     $messages_temp[] = array('message' => $m['message'], 'user_from' => $m['user_from'], 'date' => $m['date'],'attachment' => $m['attachment'], 'attachments' => $m['attachments']);
                }
                $messages_temp[] = array('message' => $message, 'user_from' => $current_user_id, 'date' => $date,'attachment' => null, 'attachments' => $attachment);
                update_field('field_56962dd283ab7',$messages_temp,$quote_id);


                if($attachment) {
                        if(count($attachment > 1)) { $atahcment_notify = 'attachments'; } else { $atahcment_notify = 'attachment'; }
                        $att_link = wp_get_attachment_url($attachment);
                        // make Activity row
                        $activity_text = $user_data->first_name . ' ' . $user_data->last_name . ' uploaded ' . $atahcment_notify . '.';
                        go_activity($activity_text,'attachment',$date,$current_user_id,$quote_id);
                }

                // HERE GOES A MESSAGE TEXT AND TITLES. ALL SAME FOR ALL TYPES OF USERS
                    $subject = 'You have new message from ' . $who;
                    $title = 'You have new message:';
                    $text = '<div style="text-align:center; padding:25px 0;">
                                    <div style="display:inline-block; background:#f1f4f5; border-radius: 4px; padding:20px; text-align:center;">
                                            <img src="' . $user_data->avatar . '" alt="">
                                            <div style="font-size:16px; padding:20px 0 5px 0; ">' . $user_data->first_name . ' ' . $user_data->last_name . '<br /><span style="font-size:12px">wrote:</span></div>
                                    </div>
                            </div>
                            <div style="padding:0 0 25px 0; text-align:center;">
                                    <div style="display:inline-block; width:80%; background:#f1f4f5; border-radius: 4px; padding:20px; text-align:left;">
                                            <div style="font-size:14px; padding:20px 0 5px 0; "><p>' . $message . '</p>';
                                            if($attachment) {
                                                    $attachment_count = count($attachment);
                                                    if($attachment_count > 1) { $attahcment_notify = 'attachments'; } else { $attahcment_notify = 'attachment'; }
                                            $text .= '<p>Added ' . $attachment_count . ' ' . $attahcment_notify . '</p>';
                                            }
                                            $text .= '<p style="font-size:12px; text-align:right;">' . $date . '</p></div>
                                    </div>
                            </div>
                            <div style="text-align:center; padding:10px 0;">
                                    <a href="' . get_bloginfo('url') . '/?p=' . $quote_id . '" style="background:#f96868; color:#fff; padding:12px 25px; text-decoration:none; font-size:16px; border-radius:10px; ">Sign in and reply</a>
                            </div><br/><p>Please note that we dont monitor this email address so please reply online through the project message panel.</p>';
                // *** END


                // checing reciever of message

                // ID SENDER IS CLIENT: WE NEED TO SENT MESSAGES TO ALL PMs and PLs
                if($user_data->type == 'Client') {

                        if($agent_id != null) {
                            foreach($agent_id as $user) {
                                if($user['ID']) { $userId = $user['ID']; }
                                else { $userId = $user[0]; }
                                go_message($message,$date,$current_user_id,$userId,$quote_id);
                                go_email($subject,$title,$text,$userId);
                            }
                        }
                }
 
                elseif($user_data->type == 'Agent') {
                    if($client_id) {
                        if($client_id['ID']) { $userId = $client_id['ID']; }
                        else { $userId = $client_id[0]; }
                            go_message($message,$date,$current_user_id,$userId,$quote_id);
                            go_email($subject,$title,$text,$userId);
                    }
                    if($agent_id != null) {
                        foreach($agent_id as $user) {
                            if($user['ID']) { $userId = $user['ID']; }
                            else { $userId = $user[0]; }
                            if($userId != $current_user_id) {
                                go_message($message,$date,$current_user_id,$userId,$quote_id);
                                go_email($subject,$title,$text,$userId);
                            }
                        }
                    }
                }
          
                elseif($user_data->type == 'Head') {
                    if($client_id) {
                        if($client_id['ID']) { $userId = $client_id['ID']; }
                        else { $userId = $client_id[0]; }
                            go_message($message,$date,$current_user_id,$userId,$quote_id);
                            go_email($subject,$title,$text,$userId);
                    }
                    if($agent_id != null) {
                        foreach($agent_id as $user) {
                            if($user['ID']) { $userId = $user['ID']; }
                            else { $userId = $user[0]; }
                            go_message($message,$date,$current_user_id,$userId,$quote_id);
                            go_email($subject,$title,$text,$userId);
                        }
                    }
                }

        }

}
?>
