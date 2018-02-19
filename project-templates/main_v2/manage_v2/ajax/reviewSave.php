<?php
require_once("../../../../../../../wp-load.php");
if($_POST && $_POST['projectId']) {

        $projectId = $_POST['projectId'];
        $reviewData = $_POST['reviewData'];
		$reviewFields = array(
			'review' => 'field_5759bb8515ba5',
			'rating' => 'field_5a856424e4351'
		);
		$clientId = get_field('client_id',$projectId); $clientId = $clientId['ID'];
		$clientData = go_userdata($clientId);

        if( empty($reviewData['review']) ) 
            $error = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>You need to enter Review!</div>";
		elseif( empty($reviewData['rating']) ) 
            $error = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>You need to set Rating!</div>";
        
		if( !empty($error) ){
			echo json_encode( array("message" => $error, "status" => 'fail') );
            die;
		}

        // updating project client's review
		foreach($reviewFields as $name => $system_name)
			update_field($system_name,$reviewData[$name],$projectId);

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
            $agentReviewsArray = $agentsReviews;
            /*foreach($agentsReviews as $agentReview) {
                $agentReviewsArray[] =  $agentReview;//array('review' => $agentReview['review'], 'rating' => $agentReview['rating'], 'projectId' => $agentReview['projectId']);
            }*/
            $agentReviewsArray[] = array('review' => $reviewData['review'], 'rating' => $reviewData['rating'], 'projectId' => $projectId);
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
            $contractorsReviewsArray = $contractorsReviews;
            /*foreach($contractorsReviews as $contractorReview) {
                $contractorsReviewsArray[] = array('review' => $contractorReview['review'], 'rating' => $contractorReview['rating'], 'projectId' => $contractorReview['projectId']);
            }*/
            $contractorsReviewsArray[] = array('review' => $reviewData['review'], 'rating' => $reviewData['rating'], 'projectId' => $projectId);
            update_field('field_57713b055a0ee',$contractorsReviewsArray,'user_' . $contractorId);
        }

        //$message = '<div class="font-size-18 margin-bottom-20">Review from client:</div>';
		ob_start();
		include('../../views_v2/projectReviewMessage.php');
		$message = ob_get_clean();
        echo json_encode( array("message" => $message, "status" => 'success') );
        die;
}
else {
        $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>";
        echo json_encode( array("message" => $message, "status" => 'fail') );
        die;
}
?>
