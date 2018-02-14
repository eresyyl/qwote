<?php
/*
This is AJAX function to save_task
*/
require_once("../../../../../wp-load.php");
$task_row = $_POST['row'];
$quote_id = $_POST['quote_id'];

$new_tasks = array();
$tasks = get_field('tasks',$quote_id);
if(is_array($tasks)) {
        $i=0;
        foreach($tasks as $task) {
            $task_date = $task['task_date'];
            $timestamp = strtotime($task_date);
                $i++;
                if($task_row == $timestamp) {
                        $new_tasks[] = array('task_date' => $task['task_date'], 'task_title' => $task['task_title'], 'task_done' => true);
                }
                else {
                        $new_tasks[] = array('task_date' => $task['task_date'], 'task_title' => $task['task_title'], 'task_done' => $task['task_done']);
                }
        }
}

$log = update_field('field_56f1ce4554d41',$new_tasks,$quote_id);

$text = 'OK';
echo json_encode( array("message" => $text, "log" => $log) );
die;
?>
