<?php 
/*
This is AJAX function to Add selections to project
*/
require_once("../../../../../wp-load.php");

if($_POST) {
        $selection = $_POST['selection'];
        $action = $_POST['action'];
        $quote_id = $_POST['quote_id'];
        $default_selections = get_field('default_selections',$quote_id);
        $default_selections_temp = array();
        if($action == 'add') {
               foreach($default_selections as $s){
                       if($s != $selection) {
                               $default_selections_temp[] = $s;
                       }
               }
               $default_selections_temp[] = $selection;
        }
        if($action == 'remove') {
               foreach($default_selections as $s){
                       if($s != $selection) {
                               $default_selections_temp[] = $s;
                       }
               }
        }
        
        $new_table = array('title' => 'test','price' => '100', 'budget' => 120);
        
        update_field('field_5702b0cd22350',$default_selections_temp,$quote_id);
        $status = true;
        echo json_encode( array("status" => $status, "selection" => $selection, 'table' => $new_table) );
}
else {
        $status = false;
        echo json_encode( array("status" => $status, "selection" => $selection, 'table' => $new_table) );
        die;
}

?>