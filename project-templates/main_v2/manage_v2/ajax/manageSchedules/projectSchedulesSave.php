<?php
require_once("../../../../../../../../wp-load.php");
if($_POST && $_POST['projectId']) {

    $schedules_count = count($_POST['title']); $schedules_count = $schedules_count - 1;
    $schedules_repeater = array();
    $quote_id = $_POST['projectId'];

    $i=0;
    while($i <= $schedules_count) {
            $allTasksArray = array();
            $title = $_POST['title'][$i];
            $description = $_POST['description'][$i];
            $dateFrom = $_POST['dateFrom'][$i];
            $dateTo = $_POST['dateTo'][$i];
            $done = $_POST['done'][$i];
            $photosContainer = $_POST['photosContainer'][$i];
            $photosSchedule = $_POST['schedulePhoto_' . $photosContainer];
            if(!$photosSchedule || !is_array($photosSchedule) || $photosSchedule == '') {
                $photosSchedule = array();
            }
            if($done == 'on') { $done = true; } else { $done = false; }

            $rowId = $_POST['rowId'][$i];
            $tasksArrayTitles = $_POST['taskTitle_' . $rowId];
            $tasksArrayDones = $_POST['taskDone_' . $rowId];

            $t=0;
            foreach($tasksArrayTitles as $task) {
                if($tasksArrayDones[$t] == 'on') {
                    $tdone = true;
                }
                else {
                    $tdone = false;
                }
                $allTasksArray[] = array(
                    'title' => $task,
                    'done' => $tdone
                );
            $t++;
            }

            $schedules_repeater[] = array('title' => $title, 'description' => $description, 'tasks'=>$allTasksArray, 'date_from' => $dateFrom, 'date_to' => $dateTo, 'done' => $done, 'photos' => $photosSchedule);
            $i++;
    }

    update_field('field_56977d9435582',$schedules_repeater,$quote_id);

        echo json_encode( array("message" => $message, "status" => 'success', "log" => $allTasksArray) );
        die;
}
else {
        $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong! No POST data!</div>";
        echo json_encode( array("message" => $message, "status" => 'fail') );
        die;
}
?>
