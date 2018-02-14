<?php
require_once("../../../../../../../wp-load.php");
if($_POST && $_POST['projectId']) {

        $projectId = $_POST['projectId'];
        $review = $_POST['review'];

        if($review == '' || $review == null) {
            $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>You need to enter Review!</div>";
            echo json_encode( array("message" => $message, "status" => 'fail') );
            die;
        }

        // updating project client's review
        update_field('field_5759bb8515ba5',$review,$projectId);

        // get all PLs
        $agents = get_field('agent_id',$projectId);
        foreach($agents as $agent) {
            if($agent['ID']) {
                $agentId = $agent['ID'];
            }
            else {
                $agentId = $agent[0];
            }
            $agentsReviews = get_field('reviews','user_' . $agentId);
            $agentReviewsArray = array();
            foreach($agentsReviews as $agentReview) {
                $agentReviewsArray[] = array('review' => $agentReview['review'], 'projectId' => $agentReview['projectId']);
            }
            $agentReviewsArray[] = array('review' => $review, 'projectId' => $projectId);
            update_field('field_57713b055a0ee',$agentReviewsArray,'user_' . $agentId);
        }

        // get all PMs
        $contractors = get_field('contractor_id',$projectId);
        foreach($contractors as $contractor) {
            if($contractor['ID']) {
                $contractorId = $contractor['ID'];
            }
            else {
                $contractorId = $contractor[0];
            }
            $contractorsReviews = get_field('reviews','user_' . $contractorId);
            $contractorsReviewsArray = array();
            foreach($contractorsReviews as $contractorReview) {
                $contractorsReviewsArray[] = array('review' => $contractorReview['review'], 'projectId' => $contractorReview['projectId']);
            }
            $contractorsReviewsArray[] = array('review' => $review, 'projectId' => $projectId);
            update_field('field_57713b055a0ee',$contractorsReviewsArray,'user_' . $contractorId);
        }

        $message = '<div class="font-size-18 margin-bottom-20">Review from client:</div>';
        $message = '<div class="chat">
                        <div class="chat-avatar">
                                <a class="avatar">
                                        <img src="' . $clientData->avatar . '">
                                </a>
                        </div>
                        <div class="chat-body">
                                <div class="chat-content text-left">
                                        <div class="margin-bottom-5"><strong style="font-weight:normal;">' . $clientData->first_name . ' ' . $clientData->last_name . '</strong></div>
                                        <p>' . $review . '</p>

                                </div>
                        </div>
                </div>';
        echo json_encode( array("message" => $message, "status" => 'success') );
        die;
}
else {
        $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>";
        echo json_encode( array("message" => $message, "status" => 'fail') );
        die;
}
?>
