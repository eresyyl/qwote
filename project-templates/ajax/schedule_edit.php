<?php 
/*
This is AJAX function to edit row from Schedule
*/
require_once("../../../../../wp-load.php");
$date = date('d/m/Y H:i');
$user_id = current_user_id();
$user_data = go_userdata($user_id);

if($_POST) {
        $quote_id = $_POST['quote_id'];
        $row = $_POST['row'];
        
        $title = $_POST['title'];
        $description = $_POST['description'];
        $date_from = $_POST['date_from'];
        $date_to = $_POST['date_to'];
        
        $sch = get_field('schedule',$quote_id);
        $sch_array = array();
        $i=0;
        foreach($sch as $s) { $i++;
                if($i != $row) {
                     $sch_array[] = array('title' => $s['title'], 'description' => $s['description'], 'date_from' => $s['date_from'], 'date_to' => $s['date_to'], 'done' => $s['done']);   
                }
                else {
                    $sch_array[] = array('title' => $title, 'description' => $description, 'date_from' => $date_from, 'date_to' => $date_to, 'done' => false);      
                }
        }
        update_field('field_56977d9435582',$sch_array,$quote_id);
        
        // make Activity row
        $activity_text = $user_data->first_name . ' ' . $user_data->last_name . ' updated Schedule.';
        go_activity($activity_text,'schedule',$date,$user_id,$quote_id);
        
        echo "<script>
                $('.schedule_actions .save_schedule i').removeClass('fa fa-refresh fa-spin').addClass('icon wb-check');
                $('.schedule_" . $row . " .widget-title').html('" . $title . "');
                $('.schedule_" . $row . " .widget-description').html('" . $description . "');
                $('.schedule_" . $row . " .widget-time').html('" . $date_from . " - " . $date_to . "');
                $('.schedule_" . $row . " .cancel_schedule').trigger('click');
                </script>";
        die;
}
?>