<?php $rand = rand(111111,999999);
echo "<div class='panel bg-grey-100 margin-top-0 margin-bottom-10 selections'>
        
                                                        <div class='panel-body'>
                                                              <div class='row'>
                                                                      <div class='col-md-12 col-xs-12'>
                                                                              <h5 class='grey-800'>Title</h5>
                                                                              <div class='form-group'>
                                                                                      <input type='text' class='form-control input-sm' name='title[]'>
                                                                              </div>
                                                                      </div>
                                                              </div>
                                                              <div class='row'>
                                                                      <div class='col-md-12 col-xs-12'>
                                                                              <h5 class='grey-800'>Description</h5>
                                                                              <div class='form-group'>
                                                                                      <textarea name='description[]' class='form-control input-sm quote_textarea'></textarea>
                                                                              </div>
                                                                      </div>
                                                              </div>
                                                              <div class='row'>  
                                                                      <div class='col-md-4 col-xs-12'>
                                                                              <h5 class='grey-800'>Price, $</h5>
                                                                              <div class='form-group'>
                                                                                      <input type='text' class='form-control input-sm' name='price[]'>
                                                                              </div>
                                                                      </div> 
                                                                      <div class='col-md-4 col-xs-12'>
                                                                              <h5 class='grey-800'>PC Sum, $</h5>
                                                                              <div class='form-group'>
                                                                                      <input type='text' class='form-control input-sm' name='pc_sum[]'>
                                                                              </div>
                                                                      </div>
                                                                      <div class='col-md-4 col-xs-12'>
                                                                              <h5 class='grey-800'>Photo</h5>
                                                                              <div class='form-group'>
                                                                                      <input type='file' class='form-control input-sm file_upload' name='photo[]' id='photo_" . $rand . "'>
                                                                                      <div class='photo_" . $rand . "'><input type='hidden' name='photo[]' value=''></div>
                                                                                      <script>$('#photo_" . $rand . "').change(function(){ UploadSelection('photo_" . $rand . "'); });</script>
                                                                              </div>
                                                                      </div> 
                                                              </div>
                                                              <div class='row'>
                                                                  <div class='col-md-12 text-right'>
                                                                          <a class='btn btn-pure btn-danger icon wb-close remove_selection'></a>
                                                                  </div>    
                                                              </div>
                                                        </div>
                                                </div>
"; 
?>