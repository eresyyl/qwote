<?php 
/*
This is AJAX function make invoice Paid
*/
require_once("../../../../../wp-load.php");
$date = date('d/m/Y H:i');
$user_id = current_user_id();
if($_POST && $_POST['invoice_id']) {
        $invoice_id = $_POST['invoice_id'];
        $inv_title = get_the_title($invoice_id);
        $client_id = get_field('client_id',$invoice_id);
        
        /*
        *
        * SENDING EMAIL
        *
        */
        
        $subject = 'Thank you for payment!';
        $title =  $inv_title;
        $text = '<p>We have just recievd payment for ' . $inv_title . '</p><b>Kind Regards, All at Paynt</b>';
        go_email($subject,$title,$text,$client_id);
        
        /*
        *
        * END SENDING EMAIL
        *
        */
        // updating invoice status
        update_field('status','Paid',$invoice_id);
        update_field('field_567eedc8a0297',$payments_temp,$quote_id);

        // showing response message
        echo "<div class='text-center margin-vertical-20 green-600'>Invoice marked as Paid! Page will be reloaded...</div>";
        echo "<script>$('.cancel_invoice').html('Close').show(); setTimeout(function(){location.reload();},2000);</script>";
        die;
}
else {
        echo "<div class='text-center margin-bottom-20 red-800'>Something went wrong!</div>";
        echo "<script>$('.paid_invoice').show(); $('.cancel_invoice').show();</script>";
        die;
}
?>