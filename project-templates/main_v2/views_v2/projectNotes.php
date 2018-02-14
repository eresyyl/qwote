<?php
require_once( ABSPATH . 'wp-load.php');
// getting Current User ID
$current_user_id = current_user_id();
// get project infos
$quote_id = get_the_ID();
?>

<div class="project_notes">

        <?php $notes = get_field('notes',$quote_id); ?>

        <?php $notesPresent = false; if(is_array($notes)) : foreach($notes as $note) : ?>

                <?php
                $note_user = $note['note_user'];
                $note_user_info = go_userdata($note_user);
                $note_date = $note['note_date'];
                $note_text = $note['note_text'];
                $noreRole = $note['noteRole'];
                ?>

                <?php
                $showNote = false;
                if($noreRole == 'all') {
                    $showNote = true;
                    $notesPresent = true;
                }
                elseif($noreRole == 'Head') {
                    if(is_headcontractor()) {
                        $showNote = true;
                        $notesPresent = true;
                    }
                }
                elseif($noreRole == 'Agent') {
                    if(is_agent() || is_headcontractor()) {
                        $showNote = true;
                        $notesPresent = true;
                    }
                }
                elseif($noreRole == 'Contractor') {
                    if(!is_client()) {
                        $showNote = true;
                        $notesPresent = true;
                    }
                }
                elseif($noreRole == 'Client') {
                    if(!is_contractor()) {
                        $showNote = true;
                        $notesPresent = true;
                    }
                }
                ?>

                <?php if($showNote == true) : ?>

                <div class="chat">
                        <div class="chat-avatar">
                                <a class="avatar">
                                        <img src="<?php echo $note_user_info->avatar; ?>">
                                </a>
                        </div>
                        <div class="chat-body">
                                <div class="chat-content text-left">
                                        <?php if(is_headcontractor()) : ?>
                                            <div class="margin-bottom-5"><small>Visibility: <?php echo $noreRole; ?></small></div>
                                        <?php endif; ?>
                                        <div class="margin-bottom-5"><strong style="font-weight:normal;"><?php echo $note_user_info->first_name . " " . $note_user_info->last_name; ?></strong>, <small><?php echo $note_date; ?></small></div>
                                        <p><?php echo $note_text; ?></p>

                                </div>
                        </div>
                </div>

            <?php else : ?>
            <?php endif; ?>
         
        <?php endforeach; else : ?>
            <?php $notesPresent = false; ?>
        <?php endif; ?>

      

</div>

<?php if(!is_client()) : ?>
<div class="text-center margin-top-20">
    <a class="btn btn-sm btn-outline btn-default addNote">Add Note</a>
</div>

<div class="notesForm margin-top-20" style="display:none;">
        <div class="row">
                <div class="col-md-12 col-xs-12">
                        <h5 class="grey-800">Note</h5>
                        <div class="form-group">
                                <textarea class="form-control input-sm quote_textarea" name="noteText"></textarea>
                        </div>
                        <h5 class="grey-800">Who will see note?</h5>
                        <div class="form-group">
                                <select class="form-control" name="noteRole">
                                    <?php if(!is_contractor()) : ?><option value="all">Everyone</option><?php endif; ?>
                                    <option value="Agent">Paynt Staff</option>
                                     <?php if(!is_contractor()) : ?><option value="Contractor">Tradesperson</option><?php endif; ?>
                                </select>
                        </div>
                </div>
        </div>
        <div class="row">
                <div class="col-md-12 col-xs-12">
                        <div id="notesResponse"></div>
                </div>
                <div class="col-md-12 col-xs-12 text-right">
                        <a class="btn btn-sm btn-outline btn-success saveNote" data-project="<?php echo $quote_id; ?>">Save Note</a>
                        <a class="btn btn-sm btn-outline btn-default cancelNote">Cancel</a>
                </div>
        </div>
</div>
<?php endif; ?>
