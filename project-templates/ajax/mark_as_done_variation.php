<?php 
/*
This is AJAX function to Mark Milestone Variation as Done.
*/
require_once("../../../../../wp-load.php");
$date = date('d/m/Y H:i');
$user_id = current_user_id();
$user_data = go_userdata($user_id);
$who = $user_data->first_name . " " . $user_data->last_name;

if($_POST && $_POST['quote_id'] && $_POST['quote_milestone']) {
        $quote_id = $_POST['quote_id'];
        $total = get_field('total',$quote_id);
        $quote_milestone = $_POST['quote_milestone'];
        $client_id = get_field('client_id',$quote_id);
        if($client_id[0] == NULL) {
                $client_id = $client_id['ID'];
        }
        else {
                $client_id = $client_id[0];
        }
        
        $payments = get_field('add_payments',$quote_id);

        $payments_temp = array();
        $i=0;
        foreach($payments as $payment) { $i++;
                if($i == $quote_milestone) {
                        
                        // starting generating Invoice
                        $rand = rand(1111,9999); 
                        $number = $rand . "_" . $quote_id . "_" . $quote_milestone;
                        $invoice_title = "Invoice to " . $client_data->first_name . " " . $client_data->last_name . " #" . $number;
                        $milestone_title = $payment['title'];
                        $invoice_status = 'Pending';
                        $milestone_percent = '100';
                        $milestone_price = $payment['percent'];
                        $milestone_price = number_format($milestone_price, 2, '.', '');
                        $post_information = array(
                        	'post_title' => $invoice_title,
                                'post_name' => $number,
                        	'post_content' => '',
                        	'post_type' => 'invoice',
                        	'post_status' => 'publish'
                        );
                        $new_object_id = wp_insert_post( $post_information );
                        update_field('field_569d3c6969a82',$number,$new_object_id);
                        update_field('field_569d0dfa85a14',$invoice_status,$new_object_id);
                        update_field('field_569d0d18475dc',$milestone_title,$new_object_id);
                        update_field('field_569d0d8c475de',$milestone_percent,$new_object_id);
                        update_field('field_569d0d23475dd',$milestone_price,$new_object_id);
                        update_field('field_569d0ce7475da',$client_id,$new_object_id);
                        update_field('field_569d0cfe475db',$quote_id,$new_object_id);
                        
                        // make Notification and sent it to Client
                        $notification_text = 'New invoice generated for Variation "' . $milestone_title . '"';
                        go_notification($notification_text,'invoice',$date,$client_id,$new_object_id);
                        
                        
                      $payments_temp[] = array('title' => $payment['title'], 'description' => $payment['description'], 'percent' => $payment['percent'], 'due_date' => $payment['due_date'], 'done' => true, 'paid' => $payment['paid'], 'status' => 'done', 'invoice_id' => $new_object_id);
                      $j = $i+1;
                      $milestone_title = $payment['title'];
                }
                else {
                       $payments_temp[] = array('title' => $payment['title'], 'description' => $payment['description'], 'percent' => $payment['percent'], 'due_date' => $payment['due_date'], 'done' => $payment['done'], 'paid' => $payment['paid'], 'status' => $payment['status'], 'invoice_id' => $payment['invoice_id']);   
                }
        }

        update_field('field_568c718b0c78a',$payments_temp,$quote_id);

        
        // make Activity row
        $activity_text = $who . ' marked a Variation "' . $milestone_title . '" as Done.';
        go_activity($activity_text,'done',$date,$user_id,$quote_id);
        
        // make Notification and sent it to Client
        $notification_text = $who . ' marked a Variation "' . $milestone_title . '" as Done.';
        go_notification($notification_text,'done',$date,$client_id,$quote_id);
        
        /*
        *
        * SENDING EMAIL
        *
        */
        
        $subject = $who . ' Sent you an variation';
        $title = $who . ' Sent you an variation ' . $milestone_title;
        $text = '<p>' . $who . ' Sent you an variation ' . $milestone_title . '.</p><p>Project details: ' . get_bloginfo('url') . '/?p=' . $quote_id . '</p><p>New invoice was generated, you can see details: ' . get_bloginfo('url') . '/?p=' . $new_object_id . '</p>';
        go_email($subject,$title,$text,$client_id);
        
        /*
        *
        * END SENDING EMAIL
        *
        */
        
        // show response message
        echo "<div class='green-600 text-center margin-bottom-20'>Payment variation updated! Page will be reloaded...</div>";
        echo "<script>$('.mark_as_done_variation_confirm').attr('data-quote','').attr('data-milestone',''); $('.mark_as_done_variation_close').html('Close'); $('.mark_as_done_variation_close').show(); </script>";
        echo "<script>$('#var_" . $quote_milestone . " .label').removeClass('label-info').addClass('label-primary').html('Done');</script>";
        echo "<script>$('#var_" . $quote_milestone . " .mark_as_done_variation').remove();</script>";
        echo "<script>$('#var_" . $quote_milestone . " .actions .table-content').append('<i class=\'icon wb-check-circle green-600\' style=\'cursor:default;\' data-toggle=\'tooltip\' data-placement=\'left\' data-trigger=\'hover\' data-original-title=\'Marked as Done\' title=\'\'></i>');</script>";
        echo "<script>setTimeout(function(){location.reload();},2000);</script>";
}
?>