<?php 
/*
This is AJAX function to delete Adjustment fields
*/
require_once("../../../../../wp-load.php");
$quote_id = $_POST['quote_id'];
$milestone_id = $_POST['row'];
$adj_id = $_POST['adj_row'];

$payments = get_field('payments',$quote_id);
$payments_temp = array();
$i=0;
foreach($payments as $p) {
        $i++;
        if($i == $milestone_id) {
                $payment_adjustment = array();
                if(is_array($p['adjustments'])) {
                        $j=0;
                        foreach($p['adjustments'] as $a) { $j++;
                                if($j == $adj_id) {
                                }
                                else {
                                        $payment_adjustment[] = array('title' => $a['title'], 'description' => $a['description'], 'price' => $a['price']);
                                }
                        }   
                }
                
                $payments_temp[] = array('title' => $p['title'], 'description' => $p['description'], 'percent' => $p['percent'], 'due_date' => $p['due_date'], 'done' => $p['done'], 'paid' => $p['paid'], 'status' => $p['status'], 'invoice_id' => $p['invoice_id'], 'adjustments' => $payment_adjustment);
        }
        else {
                $payment_adjustment = array();
                if(is_array($p['adjustments'])) {
                        foreach($p['adjustments'] as $a) {
                                $payment_adjustment[] = array('title' => $a['title'], 'description' => $a['description'], 'price' => $a['price']);
                        }
                }
                $payments_temp[] = array('title' => $p['title'], 'description' => $p['description'], 'percent' => $p['percent'], 'due_date' => $p['due_date'], 'done' => $p['done'], 'paid' => $p['paid'], 'status' => $p['status'], 'invoice_id' => $p['invoice_id'], 'adjustments' => $payment_adjustment);
        } 
}

//var_dump($payments_temp);
update_field('field_567eedc8a0297',$payments_temp,$quote_id);
 
echo "<div class='green-600'>Milestone successfully deleted! Page will refresh now...</div>";
echo "<script>setTimeout(function(){location.reload();},2000);</script>";
die;
?>