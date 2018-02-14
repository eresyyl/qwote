<?php
require_once( ABSPATH . 'wp-load.php');
// getting Current User ID
$current_user_id = current_user_id();
// get project infos
$quote_id = get_the_ID();
?>

<div class="project_notes">
        
        <?php $notes = get_field('notes',$quote_id); ?>
        
        <?php if(is_array($notes)) : foreach($notes as $note) : ?>
                
                <?php 
                $note_user = $note['note_user'];
                $note_user_info = go_userdata($note_user);
                $note_date = $note['note_date'];
                $note_text = $note['note_text'];
                ?>
                
                <div class="chat">
                        <div class="chat-avatar">
                                <a class="avatar">
                                        <img src="<?php echo $note_user_info->avatar; ?>">
                                </a>
                        </div>
                        <div class="chat-body">
                                <div class="chat-content text-left">
                                        <div class="margin-bottom-5"><strong style="font-weight:normal;"><?php echo $note_user_info->first_name . " " . $note_user_info->last_name; ?></strong>, <small><?php echo $note_date; ?></small></div>
                                        <p><?php echo $note_text; ?></p>

                                </div>
                        </div>
                </div>
                
        <?php endforeach; else : ?>
                
                <p class="text-center">There are no notes yet.</p>
                
        <?php endif; ?>

</div>
										
<button type="button" class="site-action-toggle btn-raised btn btn-success btn-floating add_note">
        <i class="front-icon wb-plus animation-scale-up" aria-hidden="true"></i>
</button>

<div class="notes_form" style="display:none;">
        <form id="add_note">
                <input type="hidden" name="quote_id" value="<?php echo $quote_id; ?>">
                <div class="row">
                        <div class="col-md-12 col-xs-12">
                                <h5 class="grey-800 text-right">Note</h5>
                                <div class="form-group">
                                        <textarea class="form-control input-sm quote_textarea" name="note"></textarea>
                                </div>
                        </div>
                </div>
                <div class="row">
                        <div class="col-md-6 col-xs-12">
                                <div class="notes_response"></div>
                        </div>
                        <div class="col-md-6 col-xs-12 text-right">
                                <a class="btn btn-primary save_note">Save</a>
                        </div>
                </div>
        </form>
</div>