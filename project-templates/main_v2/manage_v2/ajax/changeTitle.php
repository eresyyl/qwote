<?php 
require_once("../../../../../../../wp-load.php");
if($_POST && $_POST['projectId']) {
    
        $projectId = $_POST['projectId'];
        $projectTitle = $_POST['projectTitle'];
        
        $changeTitle = array(
              'ID'  => $projectId,
              'post_title'   => $projectTitle
        );
        wp_update_post( $changeTitle );
        $message = '';
        $newTitle = $projectTitle;
        echo json_encode( array("message" => $message, "status" => 'success', "newTitle" => $newTitle) );
        die;
}
else {
        $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>";
        echo json_encode( array("message" => $message, "status" => 'fail') );
        die;
}
?>