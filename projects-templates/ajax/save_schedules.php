<?php 
require_once("../../../../../wp-load.php");
//var_dump($_POST);
if($_POST && $_POST['quote_id']) {
        $schedules_count = count($_POST['title']); $schedules_count = $schedules_count - 1;
        $quote_id = $_POST['quote_id'];
        $schedules_repeater = array();
        $i=0;
        while($i <= $schedules_count) {
                $title = $_POST['title'][$i];
                $description = $_POST['description'][$i];
                $date_from = $_POST['date_from'][$i];
                $date_to = $_POST['date_to'][$i];
                $done = $_POST['done'][$i];
                if($done == 'true') {
                        $done_value = true;
                }
                else {
                        $done_value = false;
                }
                $schedules_repeater[] = array('title' => $title, 'description' => $description, 'date_from' => $date_from, 'date_to' => $date_to, 'done' => $done_value);
                $i++;
        }
        // var_dump($payments_repeater);
        update_field('field_56977d9435582',$schedules_repeater,$quote_id);
        echo "<div class='text-center schedule_add_success margin-vertical-20 green-600'>Schedule updated successfully!</div>";
        die;
}
else {
        echo "<div class='text-center margin-vertical-20 red-800'>Something goes wrong!</div>";
        die;
}
?>