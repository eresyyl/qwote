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
        
        // if current project status is Quote, so that's cancellation from Client or Head Contractor. Project will change status: Quote -> Cancelled.
        if($status == 'quote') {
                update_field('status','cancelled',$quote_id);
                
                // make Activity row
                $activity_text = $who . ' cancelled your job. Status changed to Cancelled.';
                go_activity($activity_text,'cancelled',$date,$user_id,$quote_id);
                
                /*
                *
                * SENDING EMAIL
                *
                */
                
                $head_contractor = get_field('head','options');
                $subject = $who . ' cancelled your Job!';
                $title = $who . ' cancelled your Job!';
                $text = '<p>' . $who . ' cancelled your job.</p><p>Job details: ' . get_bloginfo('url') . '/?p=' . $quote_id . '</p>';
                go_email($subject,$title,$text,$head_contractor['ID']);
                if($agent_id != NULL && $agent_id != '' && !empty($agent_id)) {
                        go_email($subject,$title,$text,$agent_id);
                }
                if(is_headcontractor() || is_agent()) {
                        go_email($subject,$title,$text,$client_id);
                }
                
                // showing response message
                echo "<div class='text-center margin-bottom-20 red-800'>
                                Successfully cancelled!
                        </div>
                        <script>
                                $('.cancel_quote_close').show().html('Close');
                                $('#project_" . $quote_id . " .label').html('Cancelled').removeClass('label-default').addClass('label-dark');
                                $('#project_" . $quote_id . " .cancel').remove();
                                $('#project_" . $quote_id . " .edit').remove();
                                $('#project_" . $quote_id . " .permalink').remove();
                                $('#project_" . $quote_id . " .preview').remove();
                                $('#project_" . $quote_id . " .add_details').remove();
                        </script>";
        	die;
                
        }
        // if current project status is Active, so that's cancellation from Client or Head Contractor. Project will change status: Quote -> Cancelled.
        elseif($status == 'pending' || 'active') {
                update_field('status','cancelled',$quote_id);
                
                // make Activity row
                $activity_text = $who . ' cancelled your job. Status changed to Cancelled.';
                go_activity($activity_text,'cancelled',$date,$user_id,$quote_id);
                
                /*
                *
                * SENDING EMAIL
                *
                */
                
                $head_contractor = get_field('head','options');
                $subject = $who . ' cancelled your quote!';
                $title = $who . ' cancelled your quote!';
                $text = '<p>' . $who . ' cancelled your quote.</p><p>Project details: ' . get_bloginfo('url') . '/?p=' . $quote_id . '</p>';
                go_email($subject,$title,$text,$head_contractor['ID']);
                if($agent_id != NULL && $agent_id != '' && !empty($agent_id)) {
                        go_email($subject,$title,$text,$agent_id);
                }
                if(is_headcontractor() || is_agent()) {
                        go_email($subject,$title,$text,$client_id);
                }
                
                // showing response message
                echo "<div class='text-center margin-bottom-20 red-800'>
                                Successfully cancelled!
                        </div>
                        <script>
                                $('.cancel_quote_close').show().html('Close');
                                $('#project_" . $quote_id . " .label').html('Cancelled').removeClass('label-primary').addClass('label-dark');
                                $('#project_" . $quote_id . " .cancel').remove();
                                $('#project_" . $quote_id . " .approve').remove();
                                $('#project_" . $quote_id . " .permalink').remove();
                                $('#project_" . $quote_id . " .preview').remove();
                                $('#project_" . $quote_id . " .add_details').remove();
                        </script>";
        	die;
                
        }
        
die;        
}
else {
	echo "<script>
                $('.cancel_quote').show();
                $('.cancel_quote_close').show();
                $('#cancel_quote_respopnse').html('<div class=\'text-center margin-bottom-20\'>Something went wrong!</div>');</script>";
	die;
}
?>