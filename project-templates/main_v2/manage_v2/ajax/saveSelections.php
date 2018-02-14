<?php
require_once("../../../../../../../wp-load.php");
if($_POST && $_POST['projectId']) {

        $projectId = $_POST['projectId'];
        $scopeId = $_POST['scopeId'];

        $projectDataEncoded = get_field('scopeData',$scopeId);
        $projectData = base64_decode($projectDataEncoded);
        $projectDataDecoded = json_decode($projectData,true);

        $fullPOSTarray = $_POST;
        $selectionsArray = json_encode($fullPOSTarray);
        $selectionsArrayEncoded = base64_encode($selectionsArray);

        // saving selections data to custom field
        update_field('field_574ffd4ff8125',$selectionsArrayEncoded,$scopeId);

        // let's recalculate scope total
        $scopeCalculations = go_calculate_v2($projectData,$scopeId);
        $scopeCalculationsPrice = $scopeCalculations->total;
        update_field( 'field_57407a995b430', $scopeCalculationsPrice, $scopeId );

        echo json_encode( array("message" => $message, "temp" => $scopeCalculations->total, "status" => 'success', "log" => $_POST) );
        die;
}
else {
        $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong! No POST data!</div>";
        echo json_encode( array("message" => $message, "status" => 'fail') );
        die;
}
?>
