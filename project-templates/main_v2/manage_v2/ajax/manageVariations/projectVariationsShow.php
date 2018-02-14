<?php
require_once("../../../../../../../../wp-load.php");
if($_POST && $_POST['projectId']) {

    $projectId = $_POST['projectId'];
    $projectPayments = get_field('add_payments',$projectId);

    $message = '';
    $message .= '<form id="manageVariationsForm">';
    $message .= '<input type="hidden" name="projectId" value="' . $projectId . '">';
    if($projectPayments) : $i=0; foreach($projectPayments as $pay) : $i++;
        $title = $pay['title'];
        $description = $pay['description'];
        $percent = $pay['percent'];
        $due_date = $pay['due_date'];
        $done = $pay['done'];
            if($done == true) { $done = 'true'; $marketDone = '<div><i class="fa fa-check-circle light-green-800"></i> Market as Done</div>'; } else { $done = 'false'; }
        $paid = $pay['paid']; if($paid == true) { $paid = 'true'; $markedPaid = '<div><i class="icon wb-order light-green-800"></i> Market as Paid</div>'; } else { $paid = 'false'; }
        $status_p = $pay['status'];
        $invoice = $pay['invoice_id'];

        $message .= '<div class="panel bg-grey-100 margin-top-0 margin-bottom-10 payments">';
        $message .= '<input type="hidden" name="done[]" value="' . $done . '">
                    <input type="hidden" name="paid[]" value="' . $paid . '">
                    <input type="hidden" name="status[]" value="' . $status_p . '">
                    <input type="hidden" name="invoice_id[]" value="' . $invoice . '">';
        $message .= '<div class="panel-body">
                      <div class="row">
                              <div class="col-md-4 col-xs-12">
                                      <h5 class="grey-800">Title</h5>
                                      <div class="form-group">
                                              <input type="text" class="form-control input-sm titles" value="' . $title . '" name="title[]">
                                      </div>
                              </div>
                              <div class="col-md-4 col-xs-12">
                                      <h5 class="grey-800">Price, $</h5>
                                      <div class="form-group">
                                              <input type="number" min="1" max="100" step="1" class="form-control input-sm percents" value="' . $percent . '" name="percent[]">
                                      </div>
                              </div>
                              <div class="col-md-4 col-xs-12">
                                      <h5 class="grey-800">Due Date</h5>
                                      <div class="form-group">
                                              <input type="text" data-plugin="datepicker" class="form-control input-sm datepicker dates" value="' . $due_date . '" name="date[]">
                                      </div>
                              </div>
                      </div>
                      <div class="row">
                              <div class="col-md-12 col-xs-12">
                                      <h5 class="grey-800">Description</h5>
                                      <div class="form-group">
                                              <textarea type="text" class="form-control input-sm quote_textarea" name="description[]">' . $description . '</textarea>
                                      </div>
                              </div>
                      </div>
                      <div class="row">
                          <div class="col-md-3 padding-vertical-10">
                                  Status: ' . $status_p . '
                          </div>
                          <div class="col-md-3 padding-vertical-10">
                                  ' . $marketDone . '
                          </div>
                          <div class="col-md-3 padding-vertical-10">
                                  ' . $markedPaid . '
                          </div>
                          <div class="col-md-3 text-right">
                                  <a class="btn btn-pure btn-danger icon wb-close removePayment"></a>
                          </div>
                      </div>
                </div>';
        $message .= '</div>';

    endforeach;
    else :
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
    endif;

    $message .= '<div id="newPaymentBlockV"></div>';

    $message .= '</form>';

    $message .= '<div class="row margin-top-40">
                    <div class="col-md-12">
                        <div id="saveVariationsResponse"></div>
                    </div>
                </div>';


    $message .= '<div class="row margin-top-40">
                    <div class="col-md-6">
                    </div>';

    $message .= '<div class="col-md-6 text-right">
                        <a class="panel-action margin-horizontal-10 btn btn-sm btn-outline btn-default" onclick="manageVariationsAdd();">Add Payment</a>
                        <a class="panel-action margin-horizontal-10 btn btn-sm btn-outline btn-success" onclick="manageVariationsSave();">Save Changes</a>
                        <a class="panel-action margin-horizontal-10 btn btn-sm btn-outline btn-danger manageVariationsTab" onclick="manageVariationsShow(' . $projectId . ');">Undo Changes</a>
                    </div>
                </div>';


        echo json_encode( array("message" => $message, "status" => 'success', "log" => $projectPayments) );
        die;
}
else {
        $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>";
        echo json_encode( array("message" => $message, "status" => 'fail') );
        die;
}
?>
