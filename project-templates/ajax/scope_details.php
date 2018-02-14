<?php 
/*
This is AJAX function to load scope details
*/
require_once("../../../../../wp-load.php");
$current_user_id = current_user_id();
if($_POST) {
        $quote_id = $_POST['quote_id'];
        $template_id = $_POST['template_id'];
        $quote_fields = get_field('quote_fields',$template_id);
        //var_dump($quote_fields);
        
        $scope_details = go_scope_details($template_id,$quote_id);
        //var_dump($scope_details);
        
        $count = count($scope_details);
        foreach($scope_details as $s) {
                $room = $s['room'];
                $details = $s['details'];
                if($count > 1) {
                        echo "<div><h4>" . $room . "</h4></div>";
                }
                
                echo "<dl class='dl-horizontal scope_detailes_list margin-bottom-20'>";
                foreach($details as $d) {
                        $section_title = $d['section_title'];
                        $section_details = $d['section_values'];
                        $section_type = $d['section_type'];
                        echo "<dt class='text-left'>" . $section_title . "</dt>";
                        if($section_type == 'notes') {
                            echo "<dd><div class='notes_value'>";
                            if($section_details[0] != '') {
                                    echo $section_details[0];
                            }
                            else {
                                    echo "No details";
                            }
                            echo "</div></dd>";    
                        }
                        elseif($section_type == 'photos') {
                                echo "<dd>";
                                foreach($section_details as $v) {
                                        if($v != '') {
                                                $url = wp_get_attachment_url($v);
                                                echo "<span class='label label-default margin-right-5'><a href='" . $url . "' target='_blank'>View</a></span>";
                                        }
                                        else {
                                               echo "<span class='label label-dark margin-right-5'>Not set</span>"; 
                                        }
                                }   
                                echo "</dd>";
                        }
                        elseif($section_type == 'flds') {
                                echo "<dd>";
                                if(is_array($section_details)) {
                                        foreach($section_details as $v) {
                                                if($v != null) {
                                                        $v_link = preg_replace("/[^a-zA-Z]/", "", $v);
                        				$v_link = strtolower($v_link);
                                                        echo "<span class='label label-default margin-right-5'>" . $v . "</span>";
                                                }
                                                else {
                                                        echo "<span class='label label-dark margin-right-5'>Not set</span>";
                                                }
                                        }
                                }
                                else {
                                        echo "<span class='label label-default margin-right-5'><span class='label label-default margin-right-5'>" . $section_details . "</span>";
                                }
                                echo "</dd>"; 
                                
                                
                        }
                        else {
                                echo "<dd>";
                                if(is_array($section_details)) {
                                        foreach($section_details as $v) {
                                                if($v != null) {
                                                        echo "<span class='label label-default margin-right-5'>" . $v . "</span>";
                                                }
                                                else {
                                                        echo "<span class='label label-dark margin-right-5'>Not set</span>";
                                                }
                                        }
                                }
                                else {
                                        echo "<span class='label label-default margin-right-5'><span class='label label-default margin-right-5'>" . $section_details . "</span>";
                                }
                                echo "</dd>"; 
                                
                        }
                }
                echo "</dl>";
                
        }
}
?>