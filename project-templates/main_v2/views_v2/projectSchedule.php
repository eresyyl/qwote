<?php
session_start();
require_once( ABSPATH . 'wp-load.php');
// getting Current User ID
$current_user_id = current_user_id();
// get project infos
$quote_id = get_the_ID();
?>

<!-- Timeline -->
<div id="schedule_response"></div>
<?php $schedule = get_field('schedule',$quote_id);
if($schedule) : ?>
    <ul class="timeline timeline-simple">
        <?php $i=1; $j=0; $row = 0; foreach($schedule as $s) : $i++; $j++; ?>
                <li class="timeline-item schedule_<?php echo $j; ?> <?php if($i%2) { echo "timeline-reverse"; } ?>">
                        <div class="timeline-dot ">
                        </div>
                        <div class="timeline-content">
                                <div class="widget widget-article widget-shadow <?php if($s['done'] != true) { echo 'bg-grey-100'; } else { echo 'bg-green-100'; } ?>">
                                        <div class="widget-body padding-vertical-20">
                                                <div class="sview">
                                                        <h4 class="widget-title" style="font-size:16px;"><?php if($s['done'] == true) { echo '<i class=\'icon wb-check-circle green-600\'></i>'; } ?> <?php echo $s['title']; ?></h4>
                                                        <p class="widget-metas">
                                                                <span class="widget-time"><?php echo $s['date_from']; ?> - <?php echo $s['date_to']; ?></span>
                                                        </p>
                                                        <div class="widget-description">
                                                            <?php
                                                            $desc = apply_filters('the_content', $s['description']);
                                                            echo do_shortcode($desc); ?>

                                                            <?php if(is_array($s['tasks'])) : ?>
                                                            <ul class="list-task list-group sortable " style="white-space: normal" data-role="tasklist" data-plugin="sortable" data-sortable-id="2" aria-dropeffect="move">

                                                                <?php $t=0; foreach($s['tasks'] as $task) : ?>
                                                                <?php
                                                                if(is_client()) {
                                                                    if($task['done'] == true) {
                                                                        $done = 'checked disabled';
                                                                        $doneStyle = 'style="text-decoration:line-through;"';
                                                                    }
                                                                    else {
                                                                        $done = 'disabled';
                                                                        $doneStyle = '';
                                                                    }
                                                                }
                                                                else {
                                                                    if($task['done'] == true) {
                                                                        $done = 'checked disabled';
                                                                        $doneStyle = 'style="text-decoration:line-through;"';
                                                                    }
                                                                    else {
                                                                        $done = '';
                                                                        $doneStyle = '';
                                                                    }
                                                                }
                                                                ?>
                                                                <?php
                                                                ?>
                                                                <li class="list-group-item margin-vertical-0 padding-vertical-0">
                                                                    <div class="checkbox-custom checkbox-primary scheduleTask">
                                                                        <input class="schedulePaymentCheckbox" data-schedulerow="<?php echo $row; ?>" data-row="<?php echo $t; ?>" data-quote="<?php echo $quote_id; ?>" type="checkbox" id="scheduleTask_<?php echo $row; ?>_<?php echo $t; ?>" name="task_<?php echo $row; ?>_<?php echo $t; ?>" <?php echo $done; ?>>
                                                                        <label for="scheduleTask_<?php echo $row; ?>_<?php echo $t; ?>" <?php echo $doneStyle; ?>>
                                                                            <span><?php echo $task['title']; ?></span>
                                                                        </label>
                                                                    </div>
                                                                </li>
                                                                <?php $t++; endforeach; ?>

                                                            </ul>
                                                            <?php endif; ?>


                                                            <?php if(is_array($s['photos'])) : ?>
                                                                <?php foreach($s['photos'] as $photoId) : ?>
                                                                    <?php
                                                                    $photoIdUrl = wp_get_attachment_image_src($photoId,'thumbnail');
                                                                    $photoIdUrlBig = wp_get_attachment_image_src($photoId,'large');
                                                                    ?>
                                                                    <div class="margin-vertical-20 text-center">
                                                                        <a class="attachment_popup" data-plugin="magnificPopup" data-main-class="mfp-img-mobile" href="<?php echo $photoIdUrlBig[0]; ?>">
                                                                            <img src="<?php echo $photoIdUrl[0]; ?>" alt="" />
                                                                        </a>
                                                                    </div>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>


                                                            <?php // front-end photos for schedule row ?>
                                                            <div class="margin-top-20">
                                                                <form action="<?php bloginfo('template_url'); ?>/project-templates/main_v2/manage_v2/ajax/uploadsScheduleDropzone.php?row=<?php echo $j; ?>" class="scheduleDropzone_<?php echo $j; ?> dropzone scheduleDropzone" id="schedule-dropzone">
                                                                    <input type="file" name="file" style="display:none;"/>
                                                                    <div class="dz-message needsclick dz-clickable">
                                                                        Drop files here or click to upload.<br>
                                                                    </div>
                                                                </form>
                                                                <div class="scheduleDropzoneResponse_<?php echo $j; ?>"></div>
                                                                <div class="text-center">
                                                                    <a class="btn btn-default scheduleUploadsButton scheduleUploadsCancel" data-row="<?php echo $j; ?>" style="display:none;">Cancel</a>
                                                                    <a class="btn btn-primary scheduleUploadsButton scheduleUploadsSave" data-row="<?php echo $j; ?>" data-project="<?php echo $quote_id; ?>" style="display:none;">Save</a>
                                                                </div>

                                                            </div>

                                                        </div>
                                                </div>
                                        </div>
                                </div>
                        </div>
                </li>
        <?php $row++;  endforeach; ?>
    </ul>
<?php else : ?>
        <p class="text-center noSchedules margin-top-20">No schedule details yet.</p>
<?php endif; ?>
