<?php 
/*
This is AJAX function to delete row from Schedule
*/
require_once("../../../../../wp-load.php");
$date = date('d/m/Y H:i');
$user_id = current_user_id();
$user_data = go_userdata($user_id);
if($_POST) {
        $quote_id = $_POST['quote_id'];
        $row = $_POST['row'];
        $sch = get_field('schedule',$quote_id);
        $sch_array = array();
        $i=0;
        foreach($sch as $s) { $i++;
                if($i != $row) {
                     $sch_array[] = array('title' => $s['title'], 'description' => $s['description'], 'date_from' => $s['date_from'], 'date_to' => $s['date_to'], 'done' => $s['done']);   
                }
        }
        $t = update_field('field_56977d9435582',$sch_array,$quote_id);
        // make Activity row
        $activity_text = $user_data->first_name . ' ' . $user_data->last_name . ' updated Schedule.';
        go_activity($activity_text,'schedule',$date,$user_id,$quote_id);
        
        echo "<script>
                $('.schedule_" . $row . " .widget').removeClass('bg-grey-100').addClass('bg-red-100');
                $('.schedule_" . $row . " .widget').css('text-decoration', 'line-through');
                $('.schedule_" . $row . " .s_delete').removeClass('fa fa-refresh fa-spin').addClass('icon wb-trash');
                $('.schedule_" . $row . " .sch_delete').removeClass('btn-default').addClass('btn-danger').fadeOut();
                $('.schedule_" . $row . " .sch_edit').fadeOut();
                $('.schedule_" . $row . " .sch_done').fadeOut();
                location.reload();
                </script>";
        die;
}
?>