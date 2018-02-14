<?php 
/*
This is AJAX function to Approve project by Client, Contractor or Head Contractor.
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
        
        // if current project status is Active so that's approval from Client or Head
        if($status == 'pending') {
                update_field('status','live',$quote_id);
                update_field('client_approve',true,$quote_id);
                
                // make Activity row
                $activity_text = $who . ' approved project. Status changed to Live.';
                go_activity($activity_text,'approved',$date,$user_id,$quote_id);
                
                /*
                *
                * SENDING EMAIL
                *
                */
               
                $head_contractor = get_field('head','options');
                $subject = $who . ' approved quote!';
                $title = 'Quote was approved by ' . $who . '!';
                $text = '<p>' . $who . ' approved quote and now it is Live.</p><p>You can check it here: ' . get_bloginfo('url') . '/?p=' . $quote_id . '</p>';
                go_email($subject,$title,$text,$head_contractor['ID']);
                if($agent_id != NULL && $agent_id != '' && !empty($agent_id)) {
                        go_email($subject,$title,$text,$agent_id);
                }
                
                if(is_headcontractor() || is_agent()) {
                        $subject = $who . ' approved project!';
                        $title = 'Project was approved by ' . $who . '!';
                        $text = '<p>' . $who . ' approved the project and now it is Live.</p><p>Project details: ' . get_bloginfo('url') . '/?p=' . $quote_id . '</p>';
                        go_email($subject,$title,$text,$client_id);
                }

                $payments = get_field('payments',$quote_id);
                $payments_with_status = array();
                $i=0;
                foreach($payments as $payment) { $i++;
                        if($i == 1) {
                                $payments_with_status[] = array('title' => $payment['title'], 'description' => $payment['description'], 'percent' => $payment['percent'], 'due_date' => $payment['due_date'], 'done' => $payment['done'], 'paid' => $payment['paid'], 'status' => 'active');
                        }
                        else {
                                $payments_with_status[] = array('title' => $payment['title'], 'description' => $payment['description'], 'percent' => $payment['percent'], 'due_date' => $payment['due_date'], 'done' => $payment['done'], 'paid' => $payment['paid'], 'status' => $project['status']);
                        }
                }
                update_field('field_567eedc8a0297',$payments_with_status,$quote_id);
                
                
                
                // show response message
                echo "<div class='text-center margin-bottom-20 green-600'>
                                Successfully approved! Page will be reloaded...
                        </div>
                        <script>
                                $('.approve_cancel').show().html('Close');
                                setTimeout(function(){location.reload();},2000);
                        </script>";
        	die;
        }
die;        
}
else {
	echo "<script>
                $('.approve_confirm').show();
                $('.approve_cancel').show();
                $('#approve_respopnse').html('<div class=\'text-center margin-bottom-20\'>Something went wrong!</div>');</script>";
	die;
}
?>