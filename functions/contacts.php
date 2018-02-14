<?php
require_once(ABSPATH . "wp-load.php");

function go_addcontact($to,$user_to_add) {
        $current_contacts = get_field('contacts','user_' . $to);
        $current_contacts_temp = array();
        foreach($current_contacts as $cc) {
                if($cc['ID'] != $user_to_add) {
                        $current_contacts_temp[] = $cc['ID'];
                }
        }
        $current_contacts_temp[] = $user_to_add;
        $log = update_field('field_56ffe302d624e', $current_contacts_temp, 'user_' . $to);
        return $current_contacts_temp;
}

function go_updatecontacts($projectId) {
        $clientId = get_field('client_id',$projectId);$clientId = $clientId['ID'];
        $contractors = get_field('contractor_id',$projectId);
        $contractorsAll = get_field('contractor_id',$projectId);
        $agents = get_field('agent_id',$projectId);

        $log = array();
        if(is_array($contractors)) {
            foreach($contractors as $c) {
                // adding client
                $log[] = go_addcontact($clientId,$c['ID']);
                $log[] = go_addcontact($c['ID'],$clientId);
                // adding contractors to each contractor
                foreach($contractorsAll as $newC) {
                    if($c['ID'] != $newC['ID']) {
                        $log[] = go_addcontact($c['ID'],$newC['ID']);
                    }
                }
                // adding agents to each contractor
                /*
                foreach($agents as $newA) {
                    $l .= go_addcontact($c['ID'],$newA['ID']);
                }
                */
            }
        }
/*
        if(is_array($agents)) {
            foreach($agents as $a) {
                // adding client
                $l .= go_addcontact($clientId,$a['ID']);
                $l .= go_addcontact($a['ID'],$clientId);
                // adding agents to each agent
                foreach($agents as $newA) {
                    if($a['ID'] != $newA['ID']) {
                        $l .= go_addcontact($a['ID'],$newA['ID']);
                    }
                }
                // adding contractors to each agent
                foreach($contractors as $newC) {
                    $l .= go_addcontact($a['ID'],$newC['ID']);
                }
            }
        }
*/
        return $log;
}

?>
