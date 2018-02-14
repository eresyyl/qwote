<?php 
require_once("../../../../../wp-load.php");
if($_POST && $_POST['quote_id']) {
        $quote_id = $_POST['quote_id'];
        $price = $_POST['total_price'];
        $paid = get_field('paid',$quote_id);
        $topay = $price - $paid;
        
        update_field('total',$price,$quote_id);
        update_field('topay',$topay,$quote_id);
        echo "<div class='text-center selection_add_success margin-vertical-20 green-600'>Total Price updated successfully!</div>";
        die;
}
else {
        echo "<div class='text-center margin-vertical-20 red-800'>Something goes wrong!</div>";
        die;
}
?>