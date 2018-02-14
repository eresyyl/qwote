<?php
require_once("../../../../../../../../wp-load.php");
if($_POST) {

    $message = '';

    $message .= '<div class="panel bg-grey-100 margin-top-0 margin-bottom-10 payments">';
    $message .= '<input type="hidden" name="done[]" value="false">
                <input type="hidden" name="paid[]" value="false">
                <input type="hidden" name="status[]" value="active">
                <input type="hidden" name="invoice_id[]" value="">';
    $message .= '<div class="panel-body">
                  <div class="row">
                          <div class="col-md-4 col-xs-12">
                                  <h5 class="grey-800">Title</h5>
                                  <div class="form-group">
                                          <input type="text" class="form-control input-sm titles" value="" name="title[]">
                                  </div>
                          </div>
                          <div class="col-md-4 col-xs-12">
                                  <h5 class="grey-800">Price, $</h5>
                                  <div class="form-group">
                                          <input type="number" min="1" max="100" step="1" class="form-control input-sm percents" value="" name="percent[]">
                                  </div>
                          </div>
                          <div class="col-md-4 col-xs-12">
                                  <h5 class="grey-800">Due Date</h5>
                                  <div class="form-group">
                                          <input type="text" data-plugin="datepicker" class="form-control input-sm datepicker dates" value="" name="date[]">
                                  </div>
                          </div>
                  </div>
                  <div class="row">
                          <div class="col-md-12 col-xs-12">
                                  <h5 class="grey-800">Description</h5>
                                  <div class="form-group">
                                          <textarea type="text" class="form-control input-sm quote_textarea" name="description[]"></textarea>
                                  </div>
                          </div>
                  </div>
                  <div class="row">
                      <div class="col-md-3 padding-vertical-10">
                              Status: active
                      </div>
                      <div class="col-md-3 padding-vertical-10">
                      </div>
                      <div class="col-md-3 padding-vertical-10">
                      </div>
                      <div class="col-md-3 text-right">
                              <a class="btn btn-pure btn-danger icon wb-close removePayment"></a>
                      </div>
                  </div>
            </div>';
    $message .= '</div>';

        echo json_encode( array("message" => $message, "status" => 'success') );
        die;
}
else {
        $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>";
        echo json_encode( array("message" => $message, "status" => 'fail') );
        die;
}
?>
