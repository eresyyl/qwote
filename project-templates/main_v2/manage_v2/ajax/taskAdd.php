<?php
require_once("../../../../../../../wp-load.php");
if($_POST && $_POST['projectId']) {

    $currentUserId = current_user_id();
    $currentUserData = go_userdata($currentUserId);
    $projectId = $_POST['projectId'];
    $taskText = $_POST['taskText'];
    $taskDate = date('d/m/Y H:i:s');
    $timestamp = strtotime($taskDate);

    $allTasks = get_field('tasks',$projectId);
    $allTasksTemp = array();
    foreach($allTasks as $task) {
        $allTasksTemp[] = array('task_date' => $task['task_date'], 'task_title' => $task['task_title'], 'task_done' => $task['task_done']);
    }
    $allTasksTemp[] = array('task_date' => $taskDate, 'task_title' => $taskText, 'task_done' => false);

    update_field('field_56f1ce4554d41',$allTasksTemp,$projectId);
    $message = '<li class="list-group-item margin-vertical-0 padding-vertical-0">
                        <div class="checkbox-custom checkbox-primary task_item_' . $timestamp . '">
                                <input class="task_done_action task_row_' . $timestamp . '" data-row="' . $timestamp . '" data-quote="' . $projectId . '" type="checkbox" id="task_check_' . $timestamp . '" name="task_' . $timestamp . '" >
                                <label for="task_check_' . $timestamp . '">
                                        <span><small>' . $taskDate . '</small> ' . $taskText . '</span>
                                </label>
                        </div>
                </li>';
    echo json_encode( array("message" => $message, "status" => 'success') );
    die;

}
else {
        $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>";
        echo json_encode( array("message" => $message, "status" => 'fail') );
        die;
}
?>
