<?php
require_once("../../../../../../../../wp-load.php");
if($_POST) {

    function generateRandomString($length = 10) {
    $characters = 'abcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
        return $randomString;
    }

    $randC = generateRandomString();

    $tasksShow = '';
    $rand = rand(111111,999999);
    $tasksShow .= '';

    $message = '';
    $rand = rand(111,999);
    $message .= '<div class="panel bg-grey-100 margin-top-0 margin-bottom-10 schedulesManage">';
    $message .= '<div class="panel-body">
                <input type="hidden" value="'.$rand.'" name="rowId[]">
                  <div class="row">
                          <div class="col-md-4 col-xs-12">
                                  <h5 class="grey-800">Title</h5>
                                  <div class="form-group">
                                          <input type="text" class="form-control input-sm titles" value="" name="title[]">
                                  </div>
                          </div>
                          <div class="col-md-4 col-xs-12">
                                  <h5 class="grey-800">Date From</h5>
                                  <div class="form-group">
                                          <input type="text" data-plugin="datepicker" class="form-control input-sm datepicker dates" value="" name="dateFrom[]">
                                  </div>
                          </div>
                          <div class="col-md-4 col-xs-12">
                                  <h5 class="grey-800">Due Date</h5>
                                  <div class="form-group">
                                          <input type="text" data-plugin="datepicker" class="form-control input-sm datepicker dates" value="" name="dateTo[]">
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
                  <div class="row allTasksRow margin-bottom-40">
                          <div class="col-md-12 col-xs-12">
                                  <h5 class="grey-800">Tasks</h5>
                                  <div class="allScheduleTasks">
                                  ' . $tasksShow . '
                                  </div>
                                  <div class="text-right">
                                        <a class="btn btn-sm btn-outline btn-default addScheduleTask" data-id="'.$rand.'">Add Task</a>
                                  </div>
                          </div>
                  </div>
                  <div class="row">
                      <div class="col-md-3 padding-vertical-10">
                          <div class="checkbox-custom checkbox-default">
                              <input type="checkbox" name="done[]" id="markedDone_' . $rand . '"/>
                              <label for="markedDone_' . $rand . '">Done</label>
                          </div>
                      </div>
                      <div class="col-md-6 padding-vertical-10">
                            <div class="scheduleAddPhotoButton">
                              <a class="btn btn-sm btn-outline btn-default scheduleAddPhoto" data-rand="' . $rand . '"><i class="icon wb-upload" aria-hidden="true"></i> Add Photos</a>
                              <input type="file" name="schedulePhoto[]" class="schedulePhotoInput" id="schedulePhotoInput_'.$rand.'" data-rand="' . $rand . '" data-photocontainer="' . $randC . '" accept="image/*" style="display:none;" />
                            </div>
                      </div>
                      <div class="col-md-3 text-right">
                              <a class="btn btn-pure btn-danger icon wb-close removeScheduleManage"></a>
                      </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                        <div class="schedulePhotosResponse_' . $rand . '"></div>
                    </div>
                  </div>
                  <input type="hidden" name="photosContainer[]" value="' . $randC . '">
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
