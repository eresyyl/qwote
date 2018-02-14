<?php
require_once("../../../../../../../wp-load.php");
if($_POST && $_POST['projectId']) {

        $projectId = $_POST['projectId'];
        $userId = $_POST['userId'];

        $changeDate = date('d/m/Y H:i');
        $changeUserId = $userId;
        $changeUserData = go_userdata($changeUserId);
        $changeWho = $changeUserData->first_name . " " . $changeUserData->last_name;

        // make first Payment pending->active
        $projectPayments = get_field('payments',$projectId);
        $projectPaymentsTemp = array();
        $i=0;
        foreach($projectPayments as $p) {
            $title = $p['title'];
            $description = $p['description'];
            $percent = $p['percent'];
            $date = $p['date'];
            if($i == 0) {
                    $status = 'active';
            }
            else {
                $status = $p['status'];
            }
            $done = $p['done'];
            $paid = $p['paid'];
            $invoice = $p['invoice_id'];
            $adjustments = $p['adjustments'];
            $projectPaymentsTemp[] = array('title' => $title, 'description' => $description, 'percent' => $percent, 'due_date' => $date, 'status' => $status, 'done' => $done, 'paid' => $paid, 'invoice_id' => $invoice, 'adjustments' => $adjustment);
            $i++;
        }
        update_field('field_567eedc8a0297',$projectPaymentsTemp,$projectId);

        // updating project status
        update_field('field_567db3a488cb0','live',$projectId);

        // make Activity row
        $activityText = $changeWho . ' approved job. Status changed to Live';
        go_activity($activityText,'waiting',$changeDate,$changeUserId,$projectId);

        
        $subject = 'Great work! Your project is now live!';
        $title = 'Your job is now live!';
        $text = '<p>Congratulations! Your project is now live. This means we have finalised the details and scheduled a painter to start on the dates listing on the job. You will now recieve a deposit invoice from our system, please make all payments on the due dates and let us know if you have recieved anything.  </p><p>See your live job here here: ' . get_bloginfo('url') . '/?p=' . $projectId . '</p>';
        go_email($subject,$title,$text,$clientId);
        

        $message = '';
        echo json_encode( array("message" => $message, "status" => 'success') );
        die;
}
else {
        $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>";
        echo json_encode( array("message" => $message, "status" => 'fail') );
        die;
}
?>
