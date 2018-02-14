<?php 
require_once("../../../../../wp-load.php");
if($_POST && $_POST['quote_id']) {
        $quote_id = $_POST['quote_id'];
        $due = $_POST['due_date'];
        
        update_field('due',$due,$quote_id);
        echo "<div class='text-center selection_add_success margin-vertical-20 green-600'>Due Date updated successfully!</div>";
        die;
}
else {
        echo "<div class='text-center margin-vertical-20 red-800'>Something goes wrong!</div>";
        die;
}
?>