<?php 
/*
This is AJAX function to save_note
*/
require_once("../../../../../wp-load.php");
if($_POST) {
        $quote_id = $_POST['quote_id'];
        $selection_id = $_POST['selection_id'];
        $action = $_POST['action'];
        if($action == 'add') {
                $price = 0;
                $summ = 0;
                $selected_selections = get_field('selected_selections',$quote_id);
                $selected_selections_temp = array();
                if(is_array($selected_selections) && count($selected_selections) > 0) {
                        foreach($selected_selections as $s) {
                                if($s != $selection_id) {
                                        $selected_selections_temp[] = $s;
                                }
                                else {
                                        $selected_selections_temp[] = $s;
                                        $action = 'none';
                                        $status = false;
                                }
                                $selection_price = get_field('selection_price',$s);
                                $price = $price + $selection_price;
                                $selection_summ = get_field('selection_budget',$s);
                                $summ = $summ + $selection_summ;
                        }
                }
                if($action != 'none') {
                        $selected_selections_temp[] = $selection_id;
                        $selection_price = get_field('selection_price',$selection_id);
                        $price = $price + $selection_price;
                        $selection_summ = get_field('selection_budget',$selection_id);
                        $summ = $summ + $selection_summ;
                        
                        update_field('field_571887f172ccd',$selected_selections_temp,$quote_id);
                        $status = true; 
                        $action = 'add';
                }
                
                $price = number_format($price, 2, '.', '');
                $summ = number_format($summ, 2, '.', '');
                echo json_encode( array("status" => $status, "action" => $action, "selection" => $selection_id, "selection_price" => $price, "selection_summ" => $summ) );
                die;
        }
        if($action == 'remove') {
                $selected_selections = get_field('selected_selections',$quote_id);
                $selected_selections_temp = array();
                $price = 0;
                $summ = 0;
                if(is_array($selected_selections) && count($selected_selections) > 0) {
                        foreach($selected_selections as $s) {
                                if($s != $selection_id) {
                                        $selected_selections_temp[] = $s;
                                        $selection_price = get_field('selection_price',$s);
                                        $price = $price + $selection_price;
                                        $selection_summ = get_field('selection_budget',$s);
                                        $summ = $summ + $selection_summ;
                                        
                                }
                        }
                }
                update_field('field_571887f172ccd',$selected_selections_temp,$quote_id);
                $status = true;
                $price = number_format($price, 2, '.', '');
                $summ = number_format($summ, 2, '.', '');
                echo json_encode( array("status" => $status, "action" => "remove", "selection" => $selection_id, "selection_price" => $price, "selection_summ" => $summ) );
                die;
        }
}
else {
        $status = false;
        $selection_id = 0;
        echo json_encode( array("status" => $status, "action" => "none", "selection" => $selection_id) );
        die;
}
die;
?>