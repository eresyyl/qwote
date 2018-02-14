<?php 
/*
This is AJAX function to load chat messages from project
*/
require_once("../../../../../wp-load.php");
$current_user_id = current_user_id();
if($_POST) {
        $quote_id = $_POST['quote_id'];
        $messages = get_field('messages',$quote_id);
        if(is_array($messages)) {
                foreach($messages as $m) :
                $from = $m['user_from'];
                $from_data = go_userdata($from);
                $date = $m['date'];
                $message = $m['message'];
                // to show old attachments (before multiupload) $m['attachment'] variable
                $attachment = $m['attachments'];
                if($attachment != '') {
                        $attachemnts_to_show = array();
                        foreach($attachment as $a) {
                		$size = "thumbnail";
                		$att_thumb = wp_get_attachment_image_src( $a, $size );
                                $att_link = wp_get_attachment_url($a);
                                if($att_thumb[0] != '') {
                                        $att_thumbnail = $att_thumb[0];
                                        $type = 'image';
                                }
                                else {
                                        $att_thumbnail = get_bloginfo('template_url') . '/assets/defaults/attachment.png';
                                        $type = 'file';
                                }
                                $attachemnts_to_show[] = array('link'=>$att_link,'thumb'=>$att_thumbnail,'type' => $type);
                        }
                        $att = "<div class='chat-body'>
                                <div class='chat-content text-left' style='padding:0;'>";
                        foreach($attachemnts_to_show as $attach) {
                                if($attach['type'] == 'image') {
                                        $att .= "<a class='attachment_popup' style='display:block; margin:10px;' data-plugin='magnificPopup' data-main-class='mfp-img-mobile' href='" . $attach['link'] . "' ><img src='" . $attach['thumb'] . "'></a>";
                                }
                                else {
                                        $att .= "<a style='display:block; margin:10px;' target='_blank' href='" . $attach['link'] . "' ><img src='" . $attach['thumb'] . "'></a>";
                                }
                                
                        }
                        $att .= "</div>
                        </div>";
                }
                else {
                        $att = null;
                }
                if($current_user_id == $from) {
                        $additional_class = '';
                }
                else {
                        $additional_class = 'chat-left';
                }
                if($from_data->type == 'Head' || $from_data->type == 'Agent') {
                        $head_class = 'chat-head';
                }
                else {
                        $head_class = '';
                }
                echo "<div class='chat " . $additional_class . " " . $head_class . "'>
                        <div class='chat-avatar'>
                                <a class='avatar'>
                                        <img src='" . $from_data->avatar . "'>
                                </a>
                        </div>
                        <div class='chat-body'>
                                <div class='chat-content text-left'>
                                        <div class='margin-bottom-5'><strong style='font-weight:normal;'>" . $from_data->first_name . " " . $from_data->last_name . "</strong>, <small>" . $date . "</small></div>
                                        " . $message . "
                                </div>
                        </div>
                        " . $att . "
                </div>";
                endforeach;
        }
        else {
                echo "<div class='text-center margin-bottom-20'>no messages yet</div>";
                die;
        }
        echo "<script>$(document).ready(function() { $('.attachment_popup').magnificPopup({type:'image'}); });</script>";
}
?>