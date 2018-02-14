<?php
require_once("../../../../../../../../wp-load.php");
if($_POST && $_POST['projectId']) {

    $projectId = $_POST['projectId'];
    $projectSchedules = get_field('schedule',$projectId);

    function generateRandomString($length = 10) {
    $characters = 'abcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
        return $randomString;
    }

    $message = '';
    $message .= '<div class="row">
                    <div class="col-md-12">
                        <h3 class="panel-title font-size-18">Schedules Settings</h3>
                    </div>
                </div>';
    $message .= '<form id="manageSchedulesForm">';
    $message .= '<input type="hidden" name="projectId" value="' . $projectId . '">';
    if($projectSchedules) : $i=0; foreach($projectSchedules as $sch) : $i++;
        $title = $sch['title'];
        $description = $sch['description'];
        $tasks = $sch['tasks'];
        $dateFrom = $sch['date_from'];
        $dateTo = $sch['date_to'];
        $done = $sch['done'];
            if($done == true) { $done = 'true'; $marketDone = 'checked'; } else { $done = 'false'; $marketDone = ''; }
        $rand = rand(111,999);
        $randC = generateRandomString();

        $currentPhotosArray = $sch['photos'];
        $currentPhotos = '';
        if(is_array($currentPhotosArray)) {
                foreach($currentPhotosArray as $photoId) {
                    $photoIdUrl = wp_get_attachment_image_src($photoId,'thumbnail');
                    $currentPhotos .= '<div class="uploaded_image_section schedulePhotoUploaded">
                                            <input type="hidden" name="schedulePhoto_' . $randC . '[]" class="attachment" value="' . $photoId . '">
                                            <div style="margin:20px 0 10px 0; position:relative;">
                                                <img src="' . $photoIdUrl[0] . '" height="100px"><i style="cursor:pointer; position:absolute; top:-5px; right:-5px; color:red;" class="fa fa-times-circle" style="color:red;"></i>
                                            </div>
                                        </div>';
                }
        }

        // tasks show
        $t=$i-1;
        $tasksShow = '';
        if(is_array($tasks)) {
            foreach($tasks as $task) {
                if($task['done'] == true) {
                    $done = 'checked';
                    $val = 'on';
                }
                else {
                    $done = '';
                    $val = 'off';
                }
                $rand = rand(111111,999999);
                $tasksShow .= '<div class="row margin-bottom-20 tasksRow">
                                <div class="col-md-10"><input class="form-control input-sm tasksTitles" type="text" name="taskTitle_'.$t.'[]" value="' . $task['title'] . '"></div>
                                <div class="col-md-1 text-center">
                                    <div class="checkbox-custom checkbox-primary scheduleTask" style="margin-top: 5px;">
                                        <input class="hintDone" type="hidden" value="'.$val.'" name="taskDone_'.$t.'[]">
                                        <input class="hintDoneReal" id="' . $rand . '" type="checkbox" name="_taskDone_'.$t.'[]" ' . $done . '>
                                        <label for="' . $rand . '">
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-1 text-center padding-top-5">
                                    <a style="display: inline-block;" class="btn btn-xs btn-outline btn-round btn-danger btn-icon deleteteTask">
                                        <i class="icon wb-minus margin-horizontal-0"></i>
                                    </a>
                                </div>
                            </div>';
            }
        }
        else {
            $tasksShow .= '';
        }

        $message .= '<div class="panel bg-grey-100 margin-top-0 margin-bottom-10 schedulesManage" data-row="' . $row . '">';
        $message .= '<div class="panel-body">
                    <input type="hidden" value="'.$t.'" name="rowId[]">
                      <div class="row">
                              <div class="col-md-4 col-xs-12">
                                      <h5 class="grey-800">Title</h5>
                                      <div class="form-group">
                                              <input type="text" class="form-control input-sm titles" value="' . $title . '" name="title[]">
                                      </div>
                              </div>
                              <div class="col-md-4 col-xs-12">
                                      <h5 class="grey-800">Date From</h5>
                                      <div class="form-group">
                                              <input type="text" data-plugin="datepicker" class="form-control input-sm datepicker dates" value="' . $dateFrom . '" name="dateFrom[]">
                                      </div>
                              </div>
                              <div class="col-md-4 col-xs-12">
                                      <h5 class="grey-800">Due Date</h5>
                                      <div class="form-group">
                                              <input type="text" data-plugin="datepicker" class="form-control input-sm datepicker dates" value="' . $dateTo . '" name="dateTo[]">
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
                      <div class="row allTasksRow margin-bottom-40">
                              <div class="col-md-12 col-xs-12">
                                      <h5 class="grey-800">Tasks</h5>
                                      <div class="allScheduleTasks">
                                      ' . $tasksShow . '
                                      </div>
                                      <div class="text-right">
                                            <a class="btn btn-sm btn-outline btn-default addScheduleTask" data-id="'.$t.'">Add Task</a>
                                      </div>
                              </div>
                      </div>
                      <div class="row">
                          <div class="col-md-3 padding-vertical-10">
                            <div class="checkbox-custom checkbox-default">
                                <input type="checkbox" name="done[]" id="markedDone_' . $rand . '" ' . $marketDone . '/>
                                <label for="markedDone_' . $rand . '">Done</label>
                            </div>
                          </div>
                          <div class="col-md-6 padding-vertical-10">
                                <div class="scheduleAddPhotoButton">
                                  <a class="btn btn-sm btn-outline btn-default scheduleAddPhoto" data-rand="' . $rand . '"><i class="icon wb-upload" aria-hidden="true"></i> Add Photos</a>
                                  <input type="file" name="schedulePhoto[]" class="schedulePhotoInput" id="schedulePhotoInput_'.$rand.'" data-photocontainer="' . $randC . '" data-rand="' . $rand . '" accept="image/*" style="display:none;" />
                                </div>
                          </div>
                          <div class="col-md-3 text-right">
                                  <a class="btn btn-pure btn-danger icon wb-close removeScheduleManage"></a>
                          </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                            <div class="schedulePhotosResponse_' . $rand . '">
                                ' . $currentPhotos . '
                            </div>
                        </div>
                      </div>
                      <input type="hidden" name="photosContainer[]" value="' . $randC . '">
                </div>';
        $message .= '</div>';

    endforeach;
    else :
        $rand = rand(111,999);
        $randC = generateRandomString();
        $message .= '<div class="panel bg-grey-100 margin-top-0 margin-bottom-10 schedulesManage">';
        $message .= '<div class="panel-body">
                    <input type="hidden" value="0" name="rowId[]">
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
                                            <a class="btn btn-sm btn-outline btn-default addScheduleTask" data-id="0">Add Task</a>
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
                                  <input type="file" name="schedulePhoto[]" class="schedulePhotoInput" id="schedulePhotoInput_'.$rand.'" data-photocontainer="' . $randC . '" data-rand="' . $rand . '" accept="image/*" style="display:none;" />
                                </div>
                          </div>
                          <div class="col-md-3 text-right">
                                  <a class="btn btn-pure btn-danger icon wb-close removeScheduleManage"></a>
                          </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                            <div class="schedulePhotosResponse_' . $rand . '">

                            </div>
                        </div>
                      </div>
                      <input type="hidden" name="photosContainer[]" value="' . $randC . '">
                </div>';
        $message .= '</div>';
    endif;

    $message .= '<div id="newScheduleBlock"></div>';

    $message .= '</form>';

    $message .= '<div class="row margin-top-40">
                    <div class="col-md-12">
                        <div id="saveScheduleResponse"></div>
                    </div>
                </div>';

    // getting all payment Templates
    $templates = get_posts(array(
        'posts_per_page' => 9999,
        'post_type' => 'schedule_template'
    ));

    $message .= '<div class="row margin-top-40">
                    <div class="col-md-6">
                        <div class="form-group">
                            <select name="paymentsTemplate" class="form-control selectpicker" data-live-search="true">';
                                $message .= '<option value="0" selected disabled>Load Schedule from Template?</option>';
                            foreach($templates as $t) :
                                $message .= '<option value="' . $t->ID . '">' . $t->post_title . '</option>';
                            endforeach;
    $message .= '           </select>
                        </div>
                    </div>';

    $message .= '<div class="col-md-6 text-right">
                        <a class="panel-action margin-horizontal-10 btn btn-sm btn-outline btn-default" onclick="manageSchedulesAdd();">Add Schedule</a>
                        <a class="panel-action margin-horizontal-10 btn btn-sm btn-outline btn-success" onclick="manageSchedulesSave();">Save Changes</a>
                        <a class="panel-action margin-horizontal-10 btn btn-sm btn-outline btn-danger managePaymentsTab" onclick="manageSchedulesShow(' . $projectId . ');">Undo Changes</a>
                    </div>
                </div>';


        echo json_encode( array("message" => $message, "status" => 'success', "log" => $projectSchedules) );
        die;
}
else {
        $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>";
        echo json_encode( array("message" => $message, "status" => 'fail') );
        die;
}
?>
