<?php
require_once( ABSPATH . 'wp-load.php');
// getting Current User ID
$current_user_id = current_user_id();
// get project infos
$quote_id = get_the_ID();
?>
<style>
.uploaded_image_section {
        display:inline-block;
        margin-right: 5px;
}
</style>

<!-- Message Input-->
<form class="app-message-input">
        <div class="message-input">
                <textarea class="form-control message_text" name="message"></textarea>
                <div class="message-input-actions btn-group">
                </div>
        </div>
          <button class="btn btn-pure btn-icon btn-default add_attachment" type="button">
                                <i class="icon wb-attach-file" aria-hidden="true"></i>
                        </button>
      <button style="top:31px; bottom:auto;" class="message-input-btn btn btn-primary message_sent" data-project="<?php echo $quote_id; ?>" type="button">SEND</button>       
        <input type='file' name='attach' id='attach' accept="application/pdf,image/*,application/msword" style="display:none;">
        <div class="attach" style="position:relative; left:auto; top:auto; bottom:auto; right:auto;"></div>
</form>
<!-- End Message Input-->

<!-- Chat Box -->
<div class="app-message-chats">
        <div class="chats">
                <div id="chat_messages"></div>
        </div>

</div>
<!-- End Chat Box -->

