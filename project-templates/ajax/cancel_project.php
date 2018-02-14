<?php 
/*
This is AJAX function to Cancel quote by Client, Contractor or Head Contractor.
Depending of current project status, this function can be used by Head Contractor, Client or Contractor.
*/
require_once("../../../../../wp-load.php");
$date = date('d/m/Y H:i');
$user_id = current_user_id();
$user_data = go_userdata($user_id);
$who = $user_data->first_name . " " . $user_data->last_name;

if($_POST && $_POST['quote_id'] != '') {
	$quote_id = $_POST['quote_id'];
	$status = get_field('status',$quote_id);
        
        $client_id = get_field('client_id',$quote_id);
        $client_id = $client_id['ID'];
        $contractor_id = get_field('contractor_id',$quote_id);
        $contractor_id = $contractor_id['ID'];
        $agent_id = get_field('agent_id',$quote_id);
        $agent_id = $agent_id['ID'];
        
        // if current project status is Active, so that's cancellation from Client
        if($status == 'pending') {
                update_field('status','cancelled',$quote_id);
                update_field('client_approve',false,$quote_id);
                
                // make Activity row
                $activity_text = $who . ' cancelled project. Status changed to Cancelled.';
                go_activity($activity_text,'cancelled',$date,$user_id,$quote_id);
                
                /*
                *
                * SENDING EMAIL
                *
                */
                
                $head_contractor = get_field('head','options');
                $subject = $who . ' cancelled quote!';
                $title = 'Quote was cancelled by ' . $who . '!';
                $text = '<p>' . $who . ' cancelled quote and now it is Cancelled.</p><p>Quote details: ' . get_bloginfo('url') . '/?p=' . $quote_id . '</p>';
                go_email($subject,$title,$text,$head_contractor['ID']);
                if($agent_id != NULL && $agent_id != '' && !empty($agent_id)) {
                        go_email($subject,$title,$text,$agent_id);
                }
                if(is_headcontractor() || is_agent()) {
                        go_email($subject,$title,$text,$client_id);
                }
                
                // showing response message
                echo "<div class='text-center margin-bottom-20 red-800'>
                                Successfully cancelled! Page will be reloaded...
                        </div>
                        <script>
                                $('.cancel_cancel').show().html('Close');
                                setTimeout(function(){location.reload();},2000);
                        </script>";
        	die;
                
        }

die;        
}
else {
	echo "<script>
                $('.cancel_confirm').show();
                $('.cancel_cancel').show();
                $('#cancel_respopnse').html('<div class=\'text-center margin-bottom-20\'>Something goes wrong!</div>');</script>";
	die;
}
?>