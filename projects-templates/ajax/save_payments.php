<?php 
require_once("../../../../../wp-load.php");
if($_POST && $_POST['quote_id']) {
        $payments_count = count($_POST['title']); $payments_count = $payments_count - 1;
        $quote_id = $_POST['quote_id'];
        $payments_for_adjustments = get_field('payments',$quote_id);
        $payments_repeater = array();
        $i=0;
        while($i <= $payments_count) {
                $title = $_POST['title'][$i];
                $description = $_POST['description'][$i];
                $percent = $_POST['percent'][$i];
                $date = $_POST['date'][$i];
                $status = $_POST['status'][$i];
                $done = $_POST['done'][$i];
                if($done == 'true') { $done = true; } else { $done = false; } 
                $paid = $_POST['paid'][$i];
                if($paid == 'true') { $paid = true; } else { $paid = false; } 
                $invoice = $_POST['invoice_id'][$i];
                if(is_array($payments_for_adjustments[$i]['adjustments'])) {
                        $adjustment = array();
                        foreach($payments_for_adjustments[$i]['adjustments'] as $adj) {
                                $adjustment[] = array('title' => $adj['title'], 'description' => $adj['description'], 'price' => $adj['price']);
                        }
                        
                }
                else {
                        $adjustment = array();
                }
                
                
                $payments_repeater[] = array('title' => $title, 'description' => $description, 'percent' => $percent, 'due_date' => $date, 'status' => $status, 'done' => $done, 'paid' => $paid, 'invoice_id' => $invoice, 'adjustments' => $adjustment);
                $i++;
        }
        // var_dump($payments_repeater);
        update_field('field_567eedc8a0297',$payments_repeater,$quote_id);
        echo "<div class='text-center selection_add_success margin-vertical-20 green-600'>Payments updated successfully!</div>";
        die;
}
else {
        echo "<div class='text-center margin-vertical-20 red-800'>Something went wrong!</div>";
        die;
}
?>