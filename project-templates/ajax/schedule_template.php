<?php $rand = rand(111111,999999); $rand1 = rand(111111,999999);
echo "<div class='panel bg-grey-100 margin-top-0 margin-bottom-10 schedules'>
        <input type='hidden' value='false' name='done[]'>
                                                                <div class='panel-body'>
                                                                      <div class='row'>
                                                                              <div class='col-md-12 col-xs-12'>
                                                                                      <h5 class='grey-800'>Title</h5>
                                                                                      <div class='form-group'>
                                                                                              <input type='text' class='form-control input-sm titles' name='title'>
                                                                                      </div>
                                                                              </div>
                                                                      </div>
                                                                      <div class='row'>
                                                                              <div class='col-md-12 col-xs-12'>
                                                                                      <h5 class='grey-800'>Description</h5>
                                                                                      <div class='form-group'>
                                                                                              <textarea type='text' class='form-control input-sm quote_textarea' name='description'></textarea>
                                                                                      </div>
                                                                              </div>
                                                                      </div>
                                                                      <div class='row'>  
                                                                              <div class='col-md-6 col-xs-12'>
                                                                                      <h5 class='grey-800'>Date From</h5>
                                                                                      <div class='form-group'>
                                                                                              <input type='text' data-plugin='datepicker' class='form-control input-sm dates datepicker_" . $rand1 . "' name='date_from'>
                                                                                      </div>
                                                                              </div>
                                                                              <div class='col-md-6 col-xs-12'>
                                                                                      <h5 class='grey-800'>Date To</h5>
                                                                                      <div class='form-group'>
                                                                                              <input type='text' data-plugin='datepicker' class='form-control input-sm dates datepicker_" . $rand . "' name='date_to'>
                                                                                      </div>
                                                                              </div> 
                                                                      </div>
                                                                      <div class='row'>
                                                                          <div class='col-md-12 text-right'>
                                                                                  <button type='button' class='btn btn-icon btn-success btn-round save_schedule_add'><i class='icon wb-check' aria-hidden='true'></i></button>
                                                                                  <button type='button' class='btn btn-icon btn-danger btn-outline btn-round cancel_schedule_add'><i class='icon wb-close' aria-hidden='true'></i></button>  
                                                                          </div>    
                                                                      </div>
                                                                </div>
                                                        </div>
                                                        <script>$('.datepicker_" . $rand1 . "').datepicker({format: 'dd/mm/yyyy', startDate: '-0d', autoclose: true}); $('.datepicker_" . $rand . "').datepicker({format: 'dd/mm/yyyy', startDate: '-0d', autoclose: true});</script>"; 
?>