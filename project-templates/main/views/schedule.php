<?php
require_once( ABSPATH . 'wp-load.php');
// getting Current User ID
$current_user_id = current_user_id();
// get project infos
$quote_id = get_the_ID();
?>

<?php $schedule = get_field('schedule');
if($schedule) : ?>
<!-- Timeline -->
<div id="schedule_response"></div>
<ul class="timeline timeline-simple">
        <?php $i=1; $j=0; foreach($schedule as $s) : $i++; $j++; ?>
                <li class="timeline-item schedule_<?php echo $j; ?> <?php if($i%2) { echo "timeline-reverse"; } ?>">
                        <div class="timeline-dot "><i class="icon iconchage wb-settings"></i>
                                <div class="schedule_buttons">
                                        <?php if($s['done'] != true) : ?>
                                                <button type="button" class="btn btn-icon btn-default btn-round sch_done" data-quote="<?php echo $quote_id; ?>" data-row="<?php echo $j; ?>" ><i class="icon wb-check s_done" aria-hidden="true"></i></button>
                                                                                                
                                                <button type="button" class="btn btn-icon btn-default btn-round sch_edit" data-row="<?php echo $j; ?>"><i class="icon wb-pencil s_done" aria-hidden="true"></i></button>
                                        <?php endif; ?>
                                        <button type="button" class="btn btn-icon btn-default btn-round sch_delete" data-quote="<?php echo $quote_id; ?>" data-row="<?php echo $j; ?>"><i class="icon wb-trash s_delete" aria-hidden="true"></i></button>
                                </div>
                        </div>
                        <div class="timeline-content">
                                <div class="widget widget-article widget-shadow <?php if($s['done'] != true) { echo 'bg-grey-100'; } else { echo 'bg-green-100'; } ?>">
                                        <div class="widget-body padding-vertical-20">
                                                <div class="sview">
                                                        <h4 class="widget-title" style="font-size:16px;"><?php if($s['done'] == true) { echo '<i class=\'icon wb-check-circle green-600\'></i>'; } ?> <?php echo $s['title']; ?></h4>
                                                        <p class="widget-metas">
                                                                <span class="widget-time"><?php echo $s['date_from']; ?> - <?php echo $s['date_to']; ?></span>
                                                        </p>
                                                        <div class="widget-description"><?php echo $s['description']; ?></div>
                                                </div>
                                                <div class="sedit">
                                                        <input type="text" class="schedule_title" value="<?php echo $s['title']; ?>" name="title">
                                                        <div class="row">
                                                                <div class="col-md-6">
                                                                        <input class="schedule_date from_date_<?php echo $j; ?>" name="date_from" value="<?php echo $s['date_from']; ?>">
                                                                </div>
                                                                <div class="col-md-6">
                                                                        <input class="schedule_date to_date_<?php echo $j; ?>" name="date_to" value="<?php echo $s['date_to']; ?>">
                                                                </div>
                                                        </div>
                                                        <textarea class="schedule_description" name="description"><?php echo $s['description']; ?></textarea>
                                                        <div class="schedule_actions text-center">
                                                                <button type="button" class="btn btn-icon btn-success btn-round save_schedule" data-row="<?php echo $j; ?>" data-quote="<?php echo $quote_id; ?>"><i class="icon wb-check" aria-hidden="true"></i></button>
                                                                <button type="button" class="btn btn-icon btn-danger btn-outline btn-round cancel_schedule" data-row="<?php echo $j; ?>"><i class="icon wb-close" aria-hidden="true"></i></button>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                        </div>
                </li>
        <?php endforeach; ?>
        <li class="timeline-item" style="position: absolute; bottom: 30px;">
                <div class="timeline-dot add_schedule"><i class="icon wb-plus"></i></div>
        </li>
</ul>
<form id="add_schedule_row">
        <input type="hidden" name="quote_id" value="<?php echo $quote_id; ?>">
        <div id="schedule_template"></div>
        <div id="schedule_new_response"></div>
</form>
                                                                
<?php else : ?>
        <p class="text-center margin-top-20">No schedule details yet.</p>
<?php endif; ?>