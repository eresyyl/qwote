<?php 
require_once("../../../../../wp-load.php");
if($_POST && $_POST['quote_id']) {
        $quote_id = $_POST['quote_id'];
        $title = $_POST['title'];
        
        $edit_title = array(
              'ID'  => $quote_id,
              'post_title'   => $title
        );
        wp_update_post( $edit_title );
        
        echo "<div class='text-center selection_add_success margin-vertical-20 green-600'>Title updated successfully!</div>";
        die;
}
else {
        echo "<div class='text-center margin-vertical-20 red-800'>Something goes wrong!</div>";
        die;
}
?>