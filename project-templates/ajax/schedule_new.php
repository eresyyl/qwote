<?php 
/*
This is AJAX function to add new row from Schedule
*/
require_once("../../../../../wp-load.php");
$date = date('d/m/Y H:i');
$user_id = current_user_id();
$user_data = go_userdata($user_id);

if($_POST) {
        $quote_id = $_POST['quote_id'];
        
        $title = $_POST['title'];
        $description = $_POST['description'];
        $date_from = $_POST['date_from'];
        $date_to = $_POST['date_to'];
        
        $sch = get_field('schedule',$quote_id);
        $sch_array = array();
       
        foreach($sch as $s) {
                $sch_array[] = array('title' => $s['title'], 'description' => $s['description'], 'date_from' => $s['date_from'], 'date_to' => $s['date_to'], 'done' => $s['done']);  
        }
        $sch_array[] = array('title' => $title, 'description' => $description, 'date_from' => $date_from, 'date_to' => $date_to, 'done' => false);     
        update_field('field_56977d9435582',$sch_array,$quote_id);
        
        // make Activity row
        $activity_text = $user_data->first_name . ' ' . $user_data->last_name . ' updated Schedule.';
        go_activity($activity_text,'schedule',$date,$user_id,$quote_id);
        
        
        echo "<div class='text-center margin-vertical-20 green-600'>Schedule updated successfully. Page will be reloaded...</div>";
        
        echo "<script>
                $('#schedule_template').html('');
                setTimeout(function(){location.reload();},2000);
                </script>";
        die;
}
?>