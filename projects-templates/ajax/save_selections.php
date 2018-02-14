<?php 
require_once("../../../../../wp-load.php");
//var_dump($_POST);
if($_POST && $_POST['quote_id']) {
        $selections_count = count($_POST['title']); $selections_count = $selections_count - 1;
        $quote_id = $_POST['quote_id'];
        $selections_repeater = array();
        $i=0;
        while($i <= $selections_count) {
                $title = $_POST['title'][$i];
                $price = $_POST['price'][$i];
                $pc_sum = $_POST['pc_sum'][$i];
                $description = $_POST['description'][$i];
                $photo = $_POST['photo'][$i];
                $selections_repeater[] = array('title' => $title, 'price' => $price, 'pc_sum' => $pc_sum, 'description' => $description, 'photo' => $photo);
                $i++;
        }
        // var_dump($selections_repeater);
        update_field('field_567eec5e2ee27',$selections_repeater,$quote_id);
        echo "<div class='text-center selection_add_success margin-vertical-20 green-600'>Selections updated successfully!</div>";
        die;
}
else {
        echo "<div class='text-center margin-vertical-20 red-800'>Something went wrong! Try Again</div>";
        die;
}
?>