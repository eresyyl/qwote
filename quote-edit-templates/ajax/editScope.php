<?php
require_once("../../../../../wp-load.php");
// getting default values
$currentUserId = current_user_id();
$v2 = true;
if( $_POST ) {

        // getting encoded projectData
        $projectDataDecoded = $_POST;
        $projectDataDecoded;
        $projectDataJSON = json_encode($projectDataDecoded);
        $projectDataEncoded = base64_encode($projectDataJSON);
        $scopeId = $_POST['scopeId'];
        $scopeId;
        $projectId = $_POST['projectId'];

        $scopeMargin = $_POST['scopeMargin'];

        // --- scopeData
        $log = update_field( 'field_57407a835b42f', $projectDataEncoded, $scopeId );
        // --- scopeMargin
        update_field('field_577451ccb7d46',$scopeMargin,$scopeId);

        // set dafault selections
        $scopeSelections = go_set_default_selections($scopeId);

         // --- scopePrice
        $scopeCalculations = go_calculate_v2($projectDataJSON,$scopeId);
        $scopeCalculationsPrice = $scopeCalculations->total;
        update_field( 'field_57407a995b430', $scopeCalculationsPrice, $scopeId );

        $message = "";
        $redirect = get_bloginfo('url') . '/?p=' . $projectId;
        echo json_encode( array("message" => $message, "redirect" => $redirect, "status" => 'success','log'=>$log) );
        die;

}
else {
        $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong! No project data!</div>";
        echo json_encode( array("message" => $message, "status" => 'fail') );
        die;
}
?>
