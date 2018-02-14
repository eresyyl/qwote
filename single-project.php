<?php
session_start();
session_unset();
// get defaults
$currentUserId = current_user_id();
$projectId = get_the_ID();
$projectVersion = get_field('v2',$projectId);

// get project participants
$clientId = get_field('client_id',$projectId); $clientId = $clientId['ID'];
$agenstId = get_field('agent_id',$projectId); $agentsIdArray = array();
foreach($agenstId as $agent) {
    $agentsIdArray[] = $agent['ID'];
}
$contractorstId = get_field('contractor_id',$projectId); $contractorstIdArray = array();
foreach($contractorstId as $contractor) {
    $contractorstIdArray[] = $contractor['ID'];
}

// load templates for v2
if($projectVersion == true) {
        // show template for Client
        if (is_client()) {
                if($currentUserId == $clientId) {
                        get_template_part('project-templates/main_v2/project','client');
                        die;
                }
                else {
                        wp_redirect(home_url() . "/all_projects");
                        die;
                }
        }

        // show template for Contractor/s
        elseif (is_contractor()) {
                if(in_array($currentUserId,$contractorstIdArray)) {
                        get_template_part('project-templates/main_v2/project','contractor');
                        die;
                }
                else {
                        wp_redirect(home_url() . "/all_projects");
                        die;
                }
        }

        // show template for Agent
        elseif (is_agent()) {
            if(in_array($currentUserId,$agentsIdArray)) {
                    get_template_part('project-templates/main_v2/project','agent');
                    die;
            }
            else {
                    wp_redirect(home_url() . "/all_projects");
                    die;
            }
        }

        // show template for Agent
        elseif (is_headcontractor()) {
                get_template_part('project-templates/main_v2/project','head');
                die;
        }

        //  if not logged
        else {
                wp_redirect(home_url() . "/sign-in?redirect=" . $projectId);
                die;
        }
}
else {
        echo "This project created in old version of Renovar. Soon it will be converted into new version and you'll have an ability to see it!";
        die;
}

?>
