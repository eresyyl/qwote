<?php
session_start();
require_once("../../../../../../../wp-load.php");
if($_POST) {

    $projectId = $_POST['projectId'];
    $row = $_POST['row'];
    $sessionName = 'scheduleUploads_' . $row;
    $scheduleUploads = $_SESSION[$sessionName];

    if($scheduleUploads) {
        $schedulesArray = array();
        $schedules = get_field('schedule',$projectId);
        $i=0;
        foreach($schedules as $schedule) {
            $i++;
            if($i == $row) {
                $currentRowPhotos = $schedule['photos'];
                $newRowPhotos = array_merge($currentRowPhotos,$scheduleUploads);
                $schedulesArray[] = array('title' => $schedule['title'], 'description' => $schedule['description'], 'tasks'=>$schedule['tasks'], 'date_from' => $schedule['date_from'], 'date_to' => $schedule['date_to'], 'done' => $schedule['done'], 'photos' => $newRowPhotos);
            }
            else {
                $schedulesArray[] = array('title' => $schedule['title'], 'description' => $schedule['description'], 'tasks'=>$schedule['tasks'], 'date_from' => $schedule['date_from'], 'date_to' => $schedule['date_to'], 'done' => $schedule['done'], 'photos' => $schedule['photos']);
            }
        }

        update_field('field_56977d9435582',$schedulesArray,$projectId);

        $message = "<div class='alert alert-danger alert-dismissible margin-horizontal-15' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>" . $u . "</div>";
        echo json_encode( array("message" => $message, "status" => 'success', "log" => $log) );
        session_unset();
        die;
    }
    else {
        $message = "<div class='alert alert-danger alert-dismissible margin-horizontal-15' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>";
        echo json_encode( array("message" => $message, "status" => 'fail') );
        die;
    }

}
else {
        $message = "<div class='alert alert-danger alert-dismissible margin-horizontal-15' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>";
        echo json_encode( array("message" => $message, "status" => 'fail') );
        die;
}
?>
