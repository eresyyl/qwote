<?php
require_once("../../../../../../../wp-load.php");
if($_POST && $_POST['projectId']) {

    $projectId = $_POST['projectId'];
    $scheduleRow = $_POST['scheduleRow'];
    $taskRow = $_POST['taskRow'];
    $schedules = get_field('schedule',$projectId);

    $j=0;
    $schedulesArray = array();
    foreach($schedules as $s) {
        $tasksArray = array();
        if($j == $scheduleRow) {
            if(is_array($s['tasks'])) {
                $i=0;
                foreach($s['tasks'] as $task) {
                    if($i == $taskRow) {
                        $tasksArray[] = array('title'=>$task['title'],'done'=>true);
                    }
                    else {
                        $tasksArray[] = array('title'=>$task['title'],'done'=>$task['done']);
                    }
                $i++;
                }
            }
        }
        else {
            $tasksArray = $s['tasks'];
        }

        $schedulesArray[] = array(
            'title' => $s['title'],
            'description' => $s['description'],
            'tasks' => $tasksArray,
            'date_from' => $s['date_from'],
            'date_to' => $s['date_to'],
            'done' => $s['done'],
            'photos' => $s['photos']
        );

        $j++;
    }
    update_field('field_56977d9435582',$schedulesArray,$projectId);

        $message = '';
        echo json_encode( array("message" => $message, "status" => 'success') );
        die;
}
else {
        $message = "";
        echo json_encode( array("message" => $message, "status" => 'fail') );
        die;
}
?>
