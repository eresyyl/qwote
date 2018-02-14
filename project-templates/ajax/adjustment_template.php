<?php 
/*
This is AJAX function to show Adjustment fields
*/
$quote_id = $_POST['quote_id'];
$milestone = $_POST['row'];
echo "<div class='row'>
        <form id='adjustment'>
        <input type='hidden' name='quote_id' value='" . $quote_id . "'>
        <input type='hidden' name='milestone_id' value='" . $milestone . "'>
        <div class='col-md-12'><h3 class='panel-title' style='font-size:18px; padding: 10px 0 20px 0;'>Adjust milestone #" . $milestone . "</h3></div>
        <div class='col-md-12'><p>You can use positive value (e.g. 10) to add price to milestone or negative value (e.g. -10) to decrease milestone price.</p></div>
        <div class='col-md-8'>
                <h5 class='grey-800'>Title</h5>
                <div class='form-group'>
                        <input type='text' class='form-control input-sm titles' name='title'>
                </div>
        </div>
        <div class='col-md-4'>
                <h5 class='grey-800'>Price, $</h5>
                <div class='form-group'>
                        <input type='number' class='form-control input-sm titles' name='price'>
                </div>
        </div>
        <div class='col-md-12'>
                <h5 class='grey-800'>Description</h5>
                <div class='form-group'>
                        <textarea type='text' class='form-control input-sm quote_textarea' name='description'></textarea>
                </div>
        </div>
        <div class='col-md-8'>
                <div id='adjustment_save_response'></div>
        </div>
        <div class='col-md-4 text-right'>
                <button type='button' class='btn btn-icon btn-success btn-round save_adjustment'><i class='icon wb-check' aria-hidden='true'></i></button>
                <button type='button' class='btn btn-icon btn-danger btn-outline btn-round cancel_adjustment'><i class='icon wb-close' aria-hidden='true'></i></button>
        </div>
        </form>
</div>";
die;
?>