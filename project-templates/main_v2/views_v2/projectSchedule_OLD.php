<?php
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
        <?php $i=1; $j=0; foreach($schedule as $s) : $i++; $j++; ?>
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
                                                            <?php echo $s['description']; ?>
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
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                        </div>
                </li>
        <?php endforeach; ?>
    </ul>
<?php else : ?>
        <p class="text-center noSchedules margin-top-20">No schedule details yet.</p>
<?php endif; ?>
