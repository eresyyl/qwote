<?php
session_start();
require_once( ABSPATH . 'wp-load.php');
// getting Current User ID
$current_user_id = current_user_id();
// get project infos
$quote_id = get_the_ID();
$projectMessages = get_field('messages',$quote_id);
?>

<div class="row" style="min-height: 350px">
    <?php foreach($projectMessages as $message) : ?>
        <?php if(is_array($message['attachments']) && count($message['attachments']) > 0 ) : ?>
            <?php foreach($message['attachments'] as $attachment) :
                $size = "thumbnail";
                $att_thumb = wp_get_attachment_image_src( $attachment, $size );
                        $att_link = wp_get_attachment_url($attachment);
                        if($att_thumb[0] != '') {
                                $att_thumbnail = $att_thumb[0];
                                $type = 'image';
                        }
                        else {
                                $att_thumbnail = get_bloginfo('template_url') . '/assets/defaults/attachment.png';
                                $type = 'file';
                        }
                 ?>
                <div class="col-sm-4">
                    <div class="example">
                        <?php if($type == 'image') : ?>
                            <a class='attachment_popup' href="<?php echo $att_link; ?>">
                                <img class="img-rounded" style="max-width:100%" src="<?php echo $att_thumbnail; ?>" alt="...">
                            </a>
                        <?php else : ?>
                            <a target="_blank" href="<?php echo $att_link; ?>">
                                <img class="img-rounded" style="max-width:100%" src="<?php echo $att_thumbnail; ?>" alt="...">
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endforeach; ?>

    <div class="uploadPreviews dropzone-previews"></div>

    <div class="projectUploadsDropzone">
    <form action="<?php bloginfo('template_url'); ?>/project-templates/main_v2/manage_v2/ajax/uploadsDropzone.php" class="dropzone" id="my-awesome-dropzone">
        <input type="file" name="file" style="display:none;"/>
        <div class="dz-message needsclick dz-clickable">
            You can upload photos, floor plans or files to help us understand your job more.<br>
        </div>
    </form>
    </div>

    <div class="text-center saveUploadsResponse"></div>
    <div class="text-center padding-10">
        <a class="btn btn-default projectUploadsButton projectUploadsCancel" style="display:none;">Cancel</a>
        <a class="btn btn-primary projectUploadsButton projectUploadsSave" data-project="<?php echo $quote_id; ?>" style="display:none;">Save</a>
    </div>

</div>
