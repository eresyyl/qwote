<?php
require_once("../../../../../../../../wp-load.php");
if($_POST && $_POST['projectId']) {

    $payments_count = count($_POST['title']); $payments_count = $payments_count - 1;
    $quote_id = $_POST['projectId'];
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

            $payments_repeater[] = array('title' => $title, 'description' => $description, 'percent' => $percent, 'due_date' => $date, 'status' => $status, 'done' => $done, 'paid' => $paid, 'invoice_id' => $invoice);
            $i++;
    }

    update_field('field_568c718b0c78a',$payments_repeater,$quote_id);

        echo json_encode( array("message" => $message, "status" => 'success', "log" => $_POST) );
        die;
}
else {
        $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong! No POST data!</div>";
        echo json_encode( array("message" => $message, "status" => 'fail') );
        die;
}
?>
