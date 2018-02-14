<?php
/*
This is AJAX function to Mark Milestone as Paid.
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

        $payments = get_field('payments',$quote_id);
        $payments_temp = array();
        $i=0;
        foreach($payments as $payment) { $i++;
                if($i == $quote_milestone) {
                        $payment_adjustment = array();
                        if(is_array($payment['adjustments'])) {
                                foreach($payment['adjustments'] as $a) {
                                        $payment_adjustment[] = array('title' => $a['title'], 'description' => $a['description'], 'price' => $a['price']);
                                }
                        }
                      $payments_temp[] = array('title' => $payment['title'], 'description' => $payment['description'], 'percent' => $payment['percent'], 'due_date' => $payment['due_date'], 'done' => $payment['done'], 'paid' => true, 'status' => 'paid', 'invoice_id' => $payment['invoice_id'],'adjustments' => $payment_adjustment);
                      $j = $i+1;
                      $milestone_title = $payment['title'];
                      $paid_percent = $payment['percent'];
                }
                else {
                        $payment_adjustment = array();
                        if(is_array($payment['adjustments'])) {
                                foreach($payment['adjustments'] as $a) {
                                        $payment_adjustment[] = array('title' => $a['title'], 'description' => $a['description'], 'price' => $a['price']);
                                }
                        }
                       $payments_temp[] = array('title' => $payment['title'], 'description' => $payment['description'], 'percent' => $payment['percent'], 'due_date' => $payment['due_date'], 'done' => $payment['done'], 'paid' => $payment['paid'], 'status' => $payment['status'], 'invoice_id' => $payment['invoice_id'],'adjustments' => $payment_adjustment);
                }
        }
        update_field('field_567eedc8a0297',$payments_temp,$quote_id);

        // updating Prices stats
        $total = get_field('total',$quote_id);

        $paid = get_field('paid',$quote_id);
        $topay = get_field('topay',$quote_id);

        $paid_summ = ($paid_percent * $total) / 100;
        $paid_summ = round($paid_summ,2);

        $paid = $paid + $paid_summ;
        $topay = $total - $paid_summ;
        update_field('topay',$topay,$quote_id);
        update_field('paid',$paid,$quote_id);


        // make Activity row
        $activity_text = $who . ' marked Payment "' . $milestone_title . '" as Paid.';
        go_activity($activity_text,'paid',$date,$user_id,$quote_id);

        // make Notification and sent it to Client
        $notification_text = $who . ' marked Payment "' . $milestone_title . '" as Paid.';
        go_notification($notification_text,'paid',$date,$contractor_id,$quote_id);

        /*
        *
        * SENDING EMAIL
        *
        */

        
        $subject = 'Thank you for payment!';
        $title = 'Thank you for payment';
        $text = '<p>' . $who . ' marked milestone ' . $milestone_title . ' as Paid.</p><p>Project details: ' . get_bloginfo('url') . '/?p=' . $quote_id . '</p>';
        go_email($subject,$title,$text,$client_id);

        /*
        *
        * END SENDING EMAIL
        *
        */


        // showing response message
        echo "<div class='green-600 text-center margin-bottom-20'>Payment updated! Page will be reloaded...</div>";
        echo "<script>$('.mark_as_paid_confirm').attr('data-quote','').attr('data-milestone',''); $('.mark_as_paid_close').html('Close'); $('.mark_as_paid_close').show(); </script>";
        echo "<script>$('#payment_" . $quote_milestone . " .label').removeClass('label-primary').addClass('label-success').html('Paid');</script>";
        echo "<script>$('#payment_" . $quote_milestone . " .mark_as_paid').remove();</script>";
        echo "<script>$('#payment_" . $quote_milestone . " .actions .table-content').append('<i class=\'icon wb-order green-600\' style=\'cursor:default;\' data-toggle=\'tooltip\' data-placement=\'left\' data-trigger=\'hover\' data-original-title=\'Marked as Paid\' title=\'\'></i>');</script>";
        echo "<script>setTimeout(function(){location.reload();},2000);</script>";
}
?>
