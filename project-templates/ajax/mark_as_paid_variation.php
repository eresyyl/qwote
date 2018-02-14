<?php 
/*
This is AJAX function to Mark Milestone Variation as Paid.
*/
require_once("../../../../../wp-load.php");
$date = date('d/m/Y H:i');
$user_id = current_user_id();
$user_data = go_userdata($user_id);
$who = $user_data->first_name . " " . $user_data->last_name;

if($_POST && $_POST['quote_id'] && $_POST['quote_milestone']) {
        $quote_id = $_POST['quote_id'];
        $quote_milestone = $_POST['quote_milestone'];
        
        $contractor_id = get_field('contractor_id',$quote_id);
        if($contractor_id[0] == NULL) {
                $contractor_id = $contractor_id['ID'];
        }
        else {
                $contractor_id = $contractor_id[0];
        }
        
        $payments = get_field('add_payments',$quote_id);
        $payments_temp = array();
        $i=0;
        foreach($payments as $payment) { $i++;
                if($i == $quote_milestone) {
                      $payments_temp[] = array('title' => $payment['title'], 'description' => $payment['description'], 'percent' => $payment['percent'], 'due_date' => $payment['due_date'], 'done' => $payment['done'], 'paid' => true, 'status' => 'paid', 'invoice_id' => $payment['invoice_id']);
                      $milestone_title = $payment['title'];
                }
                else {
                       $payments_temp[] = array('title' => $payment['title'], 'description' => $payment['description'], 'percent' => $payment['percent'], 'due_date' => $payment['due_date'], 'done' => $payment['done'], 'paid' => $payment['paid'], 'status' => $payment['status'], 'invoice_id' => $payment['invoice_id']);   
                }
        }
        update_field('field_568c718b0c78a',$payments_temp,$quote_id);
        
        
        // make Activity row
        $activity_text = $who . ' marked Payment Variation "' . $milestone_title . '" as Paid.';
        go_activity($activity_text,'paid',$date,$user_id,$quote_id);
        
        // make Notification and sent it to Client
        $notification_text = $who . ' marked Payment Variation "' . $milestone_title . '" as Paid.';
        go_notification($notification_text,'paid',$date,$contractor_id,$quote_id);
        
        /*
        *
        * SENDING EMAIL
        *
        */
        
       
        $subject = $who . ' marked a variation as Paid!';
        $title = $who . ' marked a variation ' . $milestone_title . ' as Paid';
        $text = '<p>' . $who . ' marked variation ' . $milestone_title . ' as Paid.</p><p>Project details: ' . get_bloginfo('url') . '/?p=' . $quote_id . '</p>';
        go_email($subject,$title,$text,$contractor_id);
        
        $subject = 'Thank you for payment!';
        $title = 'Thank you for payment';
        $text = '<p>' . $who . ' marked a variation ' . $milestone_title . ' as Paid.</p><p>Project details: ' . get_bloginfo('url') . '/?p=' . $quote_id . '</p>';
        go_email($subject,$title,$text,$client_id);
        
        /*
        *
        * END SENDING EMAIL
        *
        */
        
        // showing response message
        echo "<div class='green-600 text-center margin-bottom-20'>Payment variation updated! Page will be reloaded...</div>";
        echo "<script>$('.mark_as_paid_variation_confirm').attr('data-quote','').attr('data-milestone',''); $('.mark_as_paid_variation_close').html('Close'); $('.mark_as_paid_variation_close').show(); </script>";
        echo "<script>$('#var_" . $quote_milestone . " .label').removeClass('label-primary').addClass('label-success').html('Paid');</script>";
        echo "<script>$('#var_" . $quote_milestone . " .mark_as_paid_variation').remove();</script>";
        echo "<script>$('#var_" . $quote_milestone . " .actions .table-content').append('<i class=\'icon wb-order green-600\' style=\'cursor:default;\' data-toggle=\'tooltip\' data-placement=\'left\' data-trigger=\'hover\' data-original-title=\'Marked as Paid\' title=\'\'></i>');</script>";
        echo "<script>setTimeout(function(){location.reload();},2000);</script>";
}
?>