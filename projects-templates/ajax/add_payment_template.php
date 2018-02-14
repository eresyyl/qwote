<?php $rand = rand(111111,999999);
echo "<div class='panel bg-grey-100 margin-top-0 margin-bottom-10 add_payments'>
        <input type='hidden' name='done[]' value='false'>
        <input type='hidden' name='paid[]' value='false'>
        <input type='hidden' name='status[]' value='active'>
        <input type='hidden' name='invoice_id[]' value=''>
                                                                <div class='panel-body'>
                                                                      <div class='row'>
                                                                              <div class='col-md-12 col-xs-12'>
                                                                                      <h5 class='grey-800'>Title</h5>
                                                                                      <div class='form-group'>
                                                                                              <input type='text' class='form-control input-sm add_titles' name='title[]'>
                                                                                      </div>
                                                                              </div>
                                                                      </div>
                                                                      <div class='row'>
                                                                              <div class='col-md-12 col-xs-12'>
                                                                                      <h5 class='grey-800'>Description</h5>
                                                                                      <div class='form-group'>
                                                                                              <textarea type='text' class='form-control input-sm quote_textarea' name='description[]'></textarea>
                                                                                      </div>
                                                                              </div>
                                                                      </div>
                                                                      <div class='row'>  
                                                                              <div class='col-md-6 col-xs-12'>
                                                                                      <h5 class='grey-800'>Price, $</h5>
                                                                                      <div class='form-group'>
                                                                                              <input type='number' class='form-control input-sm add_percents' name='percent[]'>
                                                                                      </div>
                                                                              </div>
                                                                              <div class='col-md-6 col-xs-12'>
                                                                                      <h5 class='grey-800'>Due Date</h5>
                                                                                      <div class='form-group'>
                                                                                              <input type='text' data-plugin='datepicker' class='form-control input-sm add_dates datepicker_" . $rand . "' name='date[]'>
                                                                                      </div>
                                                                              </div> 
                                                                      </div>
                                                                      <div class='row'>
                                                                          <div class='col-md-12 text-right'>
                                                                                  <a class='btn btn-pure btn-danger icon wb-close remove_add_payment'></a>
                                                                          </div>    
                                                                      </div>
                                                                </div>
                                                        </div>
                                                        <script>$('.datepicker_" . $rand . "').datepicker({format: 'dd/mm/yyyy', startDate: '-0d', autoclose: true});</script>"; 
?>