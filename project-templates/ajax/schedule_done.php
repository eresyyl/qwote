<?php 
/*
This is AJAX function to mark Schedule block as Done
*/
require_once("../../../../../wp-load.php");
$date = date('d/m/Y H:i');
$user_id = current_user_id();
$user_data = go_userdata($user_id);
if($_POST) {
        $quote_id = $_POST['quote_id'];
        $row = $_POST['row'];
        
        update_sub_field(array('schedule', $row, 'done'),true,$quote_id);
        
        // make Activity row
        $activity_text = $user_data->first_name . ' ' . $user_data->last_name . ' updated Schedule.';
        go_activity($activity_text,'schedule',$date,$user_id,$quote_id);
        
        echo "<script>
                $('.schedule_" . $row . " .widget').removeClass('bg-grey-100').addClass('bg-green-100');
                $('.schedule_" . $row . " .widget-title').prepend('<i class=\'icon wb-check-circle green-600\'></i> ');
                $('.schedule_" . $row . " .s_done').removeClass('fa fa-refresh fa-spin').addClass('icon wb-check');
                $('.schedule_" . $row . " .sch_done').removeClass('btn-default').addClass('btn-success').fadeOut();
                $('.schedule_" . $row . " .sch_edit').fadeOut();
                </script>";
        die;
}
?>