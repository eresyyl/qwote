<?php 
/*
This is AJAX function to save_task
*/
require_once("../../../../../wp-load.php");
$task_title = $_POST['task'];
$task_date = date('d/m/Y H:i');
$quote_id = $_POST['quote_id'];

$new_tasks = array();
$tasks = get_field('tasks',$quote_id);
if(is_array($tasks)) {
        $task_count = count($tasks);
        $task_count = $task_count+1;
        foreach($tasks as $task) {
               $new_tasks[] = array('task_date' => $task['task_date'], 'task_title' => $task['task_title'], 'task_done' => $task['task_done']); 
        }
}
$new_tasks[] = array('task_date' => $task_date, 'task_title' => $task_title, 'task_done' => false); 

$log = update_field('field_56f1ce4554d41',$new_tasks,$quote_id);

$rand = rand(111111,999999);
$text = "<div class='green-600'>Your task successfully added!</div>";
$task = '<li class="list-group-item margin-vertical-0 padding-vertical-0">
                                <div class="checkbox-custom checkbox-primary task_item_' . $task_count . '">
                                        <input class="task_done_action task_row_' . $task_count . '" data-row="' . $task_count . '" data-quote="' . $quote_id . '" type="checkbox" id="task_check_' . $rand . '" name="task_' . $task_count . '" />
                                        <label for="task_check_' . $rand . '">
                                                <span><small>' . $task_date . '</small> ' . $task_title . '</span>
                                        </label>
                                </div>
                        </li>';

echo json_encode( array("message" => $text, "task" => $task, "log" => $log) );
die;
?>