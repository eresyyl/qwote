<?php 
require_once("../../../../../wp-load.php");
if($_POST && $_POST['quote_id']) {
        $quote_id = $_POST['quote_id'];
        $contract = $_POST['contract'];
        
        update_field('field_567eecbc4c98a',$contract,$quote_id);
        echo "<div class='text-center selection_add_success margin-vertical-20 green-600'>Contract updated successfully!</div>";
        die;
}
else {
        echo "<div class='text-center margin-vertical-20 red-800'>Something went wrong!</div>";
        die;
}
?>