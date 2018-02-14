<?php 
require_once("../../../../../wp-load.php");
//var_dump($_POST);
$quote_id = $_POST['quote_id'];
update_post_meta($quote_id, 'quote_array', $_POST);

$total = go_calculate($_POST); 
//update prices
update_post_meta($quote_id, 'total', $total->total);

echo "<div class='text-center green-600'>Scope updated successfully!<br />New Total is: $" . $total->total . "</div>";
echo "<script>$('#goto_update_scope').html('Update Scope');</script>";
die;

?>