<?php
require_once("../../../../../wp-load.php");
// getting default values
$currentUserId = current_user_id();
$v2 = true;
if( $_POST ) {

        // getting encoded projectData
        $projectDataEncoded = $_POST['projectData'];
        $projectData = base64_decode($_POST['projectData']);
        $projectDataDecoded = json_decode($projectData,true);
        // getting other projectInfo
        $projectTemplate = $projectDataDecoded['templateId'];
        $projectLevel = $projectDataDecoded['projectLevel'];
        $projectName = $projectDataDecoded['projectName'];
        $projectCity = $_POST['projectCity'];
        $projectTimeframe = $_POST['projectTimeframe'];

        $projectAgentToken = $projectDataDecoded['agentToken'];

        // getting projectClient and its data
        $projectClient = $_POST['projectClient'];
        $projectClientData = go_userdata($projectClient);

        $scopeMargin = $projectDataDecoded['scopeMargin'];

        // check if it's newProject or existingProject
        $projectId = $projectDataDecoded['projectId'];
        $projectId = intval($projectId);
        if($projectId == '0') {
                $newProject = true;
        }
        else {
                $newProject = false;
                $clientId = $_POST['clientId'];
                // get all Scope prices and store them in Project custom field
                go_recalculate_project($projectId);
        }

        $scopeTitle =  $projectName . ' - ' . $projectClientData->address;
        // function for newScope
        $rand = rand(111111111,999999999);
        $slug = "scope_" . $rand;
        $scopeInformation = array(
                'post_title' => $scopeTitle,
                'post_name' => $slug,
                'post_content' => '',
                'post_author' => $projectClient,
                'post_type' => 'scope',
                'post_status' => 'publish'
        );
        $scopetId = wp_insert_post( $scopeInformation );

        // updating scopeData
        // --- scopeTemplate
        update_field( 'field_57407bbe9c147', $projectTemplate, $scopetId );
        // --- scopeData
        update_field( 'field_57407a835b42f', $projectDataEncoded, $scopetId );
        // --- scopeLevel
        update_field( 'field_57407ac05b431', $projectLevel, $scopetId );
        // --- scopeMargin
        update_field('field_577451ccb7d46',$scopeMargin,$scopetId);

        // set dafault selections
        $scopeSelections = go_set_default_selections($scopetId);

         // --- scopePrice
        $scopeCalculations = go_calculate_v2($projectData,$scopetId);
        $scopeCalculationsPrice = $scopeCalculations->total;
        update_field( 'field_57407a995b430', $scopeCalculationsPrice, $scopetId );

        // functional for newProject
        if($newProject == true) {

                // projectTitle generation
                $projectLevelName = get_term( $projectLevel, 'selection_level' );
                $projectTitle = $projectName . ' - '. $projectClientData->address;
                // projectCreation
                $rand = rand(111111111,999999999);
                $slug = "project_" . $rand;
                $postInformation = array(
                        'post_title' => $projectTitle,
                        'post_name' => $slug,
                        'post_content' => '',
                        'post_author' => $projectClient,
                        'post_type' => 'project',
                        'post_status' => 'publish'
                );
                $projectId = wp_insert_post( $postInformation );

                // saving additional data
                // --- saving projectCity
                update_field( 'field_57407984f7f91', $projectCity, $projectId );
                // --- saving projectTimeframe
                update_field( 'field_57407979f7f90', $projectTimeframe, $projectId );
                // --- saving projectScopes
                update_field( 'field_57407991f7f92', $scopetId, $projectId );

                // saving v2 mark to new project
                update_field( 'field_57409f20f4ae6', $v2, $projectId );

                // adding ClientId
                $projectClient = intval($projectClient);
                update_field( 'field_567eb805b96b3', $projectClient, $projectId );

                // adding AgentId if AgentToken exist and != 0
                if($projectAgentToken) {
                  $projectAgentToken = base64_decode($projectAgentToken);
                  $projectAgentToken = intval($projectAgentToken);

                  update_field( 'field_56afffa9221d1', $projectAgentToken, $projectId );
                }

                // updating project Status
                update_field( 'field_567db3a488cb0', 'quote', $projectId );

                // update AgentId if current user is Agent
                if(is_agent()) {
                        $currentUserId = intval($currentUserId);
                        update_field( 'field_56afffa9221d1', $currentUserId, $projectId );
                        update_field( 'field_57740b30f6908', $currentUserId, $projectId );
                }
				// update AgentId if current user is not Client
				elseif( is_client() || current_user_can('administrator') ){
					$agentId = get_post_field( 'post_author', $projectTemplate );
					update_field( 'field_56afffa9221d1', $agentId, $projectId);
				}

        }
        else {

                // there is existingProject so we need only add newScope in current scopes of Project
                $currentScopes = get_field('projectScopes',$projectId);
                $newScopes = array();
                if(is_array($currentScopes)) {
                        foreach($currentScopes as $scope) {
                                $newScopes[] = $scope;
                        }
                        $newScopes[] = $scopetId;
                }
                // --- saving projectScopes
                update_field( 'field_57407991f7f92', $newScopes, $projectId );

                // updating project Status
                $currentStatus = get_field('status',$projectId);
                if($currentStatus != '') {
                    $currentStatus = $currentStatus;
                }
                else {
                    $currentStatus = 'quote';
                }
                update_field( 'field_567db3a488cb0', $currentStatus, $projectId );

                $clientIdEmail = get_field('client_id',$projectId);

        }

        // saving ProjectId in created newScope
        update_field( 'field_57407fa8d1aaa', $projectId, $scopetId );

        if($newProject == true) {
            $projectMessage = 'Project successfully created...';
            $clientIdEmail = $projectClient;
        }
        else {
            $projectMessage = 'Project successfully updated...';
            $clientIdEmail = $clientIdEmail['ID'];
        }


        // SEND EMAILs with all details about project
        $scopeDetails = go_scope_details_v2($projectTemplate,$scopetId);
        if($newProject == true) {
            $emalSubject = 'New Quote from ';
            $emailTitle = 'Here is your instant quotation';
        }
        else {
            $emalSubject = 'Quote updated with new scope!';
            $emailTitle = 'New scope added to your project.<br />Here are all the details:';
        }
        $subject = $emalSubject;
        $title = $emailTitle;
        $text = '<div style="text-align:center; font-size:18px; font-weight:bold;">Total: $' . $scopeCalculationsPrice . '</div>';
        $text .= '<div style="text-align:center; padding:25px 0;">';

        $text .= '<div style="padding:0 0 20px 0;"><div style="display:block; background:#f1f4f5; border-radius: 4px; padding:20px; text-align:center;">
                        <img src="' . get_field('template_image',$projectTemplate) . '" alt="" width="100px" height="100px">
                        <div style="font-size:18px; font-weight:bold; padding:20px 0 5px 0; ">' . get_the_title($projectTemplate) . '</div>';

        $text .= '<div>';
        foreach($scopeDetails as $sD) {
          $text .= '<div style="padding:5px 0">';
          $text .= '<strong>';
          $text .= $sD['section_title'];
          $text .= ': </strong>';
          $text .= '<em>';
          $lastElement = end($sD['section_values']);
          foreach($sD['section_values'] as $value) {
            if($value == NULL) {
                $text .= 'Not Included';
            }
            else {
                if($lastElement == $value) {
                    $text .= '' . $value . '';
                }
                else {
                    $text .= '' . $value . ' | ';
                }
            }
          }
          $text .= '</em>';
          $text .= '</div>';
        }
        $text .= '</div>';

        $text .= '</div><div style="padding-top:20px">
                <div style="text-align:center; padding:10px 0;">
                        <a href="' . get_bloginfo('url') . '/?p=' . $projectId . '" style="background:#f96868; color:#fff; padding:12px 25px; text-decoration:none; font-size:16px; ">View Live Job</a>
                        <a href="' . get_bloginfo('url') . '/tcpdf/scope/scope.php?project_id=' . $projectId . '" style="background:#f96868; color:#fff; padding:12px 25px; text-decoration:none; font-size:16px; ">See Quote</a>
                </div></div><br/><p>Please note that we dont monitor this email address so please reply online through the project message panel.</p>';

        // sending to user
        go_email($subject,$title,$text,$clientIdEmail);
        //sending to head
        $head_contractor = get_field('head','options');
        $clientIdEmailData = go_userdata($clientIdEmail);
        if($currentUserId != $head_contractor['ID']) {
            if($newProject == true) {
                $emalSubjectHead = 'Quote for ' . $clientIdEmailData->first_name . ' ' . $clientIdEmailData->last_name . ' ';
                $emailTitleHead = 'Here is your instant quotation:';
            }
            else {
                $emalSubjectHead = 'Quote updated for ' . $clientIdEmailData->first_name . ' ' . $clientIdEmailData->last_name . ' ';
                $emailTitleHead = 'New scope added to project.<br />Here are all the details:';
            }
        }
        else {
            if($newProject == true) {
                $emalSubjectHead = 'Quote for ' . $clientIdEmailData->first_name . ' ' . $clientIdEmailData->last_name . ' ' ;
                $emailTitleHead = 'Here is your instant quotation:';
            }
            else {
                $emalSubjectHead = 'Quote updated by You for ' . $clientIdEmailData->first_name . ' ' . $clientIdEmailData->last_name . ' ';
                $emailTitleHead = 'Quote updated with new scope.<br />Here are all the details:';
            }
        }
        $m = go_email($emalSubjectHead,$emailTitleHead,$text,$head_contractor['ID']);

        if($newProject == true && $projectAgentToken) {
          go_email($emalSubjectHead,$emailTitleHead,$text,$projectAgentToken);
        }


        $message = "<div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>" . $projectMessage . "</div>";
        echo json_encode( array("message" => $message, "log" => $scopeSelections, "status" => 'success', 'projectId' => $projectId, 'projectPrice' => $scopeCalculationsPrice) );
        die;

}
else {
        $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong! No project data!</div>";
        echo json_encode( array("message" => $message, "status" => 'fail') );
        die;
}
?>
