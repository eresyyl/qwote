<?php
$quote_id = $_GET['quote_id'];
$templates = get_field('templates',$quote_id);
$status = go_project_status($quote_id);
$total = get_field('total',$quote_id); $total = number_format($total, 2, '.', '');
$paid = get_field('paid',$quote_id); $paid = number_format($paid, 2, '.', '');
$topay = get_field('topay',$quote_id); $topay = number_format($topay, 2, '.', '');
$selections = get_field('selections',$quote_id);
$payments = get_field('payments',$quote_id);
$add_payments = get_field('add_payments',$quote_id);
$scope_array = get_field('quote_array',$quote_id);
if(!is_array($scope_array)) {
        $scope_array = json_decode($scope_array,true);
}
$client_id = get_field('client_id',$quote_id);
if($client_id[0] == NULL) {
        $client_id = $client_id['ID'];
}
else {
        $client_id = $client_id[0];
}
$client = go_userdata($client_id);
$agent_id = get_field('agent_id',$quote_id);
if($agent_id){
        if($agent_id[0] == NULL) {
                $agent_id = $agent_id['ID'];
        }
        else {
                $agent_id = $agent_id[0];
        } 
        $agent_info = go_userdata($agent_id);
}        

$client_approved = get_field('client_approve',$quote_id);
$agent_approved = get_field('agent_approve',$quote_id);

$client_string = get_field('client','options');
$agent_string = get_field('agent','options');

?>
<header class="slidePanel-header bg-blue-600">
        <div class="slidePanel-actions" aria-label="actions" role="group">
                <button type="button" class="btn btn-pure btn-inverse slidePanel-close actions-top icon wb-close"
                aria-hidden="true"></button>
        </div>
        <span class="label label-<?php echo $status->status_class; ?>"><?php echo $status->status_string; ?></span>
        <h1><?php echo go_generate_title($quote_id); ?></h1>
</header>
<div class="slidePanel-inner">
  
        <section class="slidePanel-inner-section">
    
                <div class="step-info">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="step">
                                        <span class="step-numbers blue-600">$<?php echo $total; ?></span>
                                        <div class="step-desc">
                                                <span class="step-title">Total</span>
                                                <p>amount</p>
                                        </div>
                                </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="step">
                                        <span class="step-numbers green-600">$<?php echo $paid; ?></span>
                                        <div class="step-desc">
                                                <span class="step-title">Paid</span>
                                                <p>amount</p>
                                        </div>
                                </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="step">
                                        <span class="step-numbers red-600">$<?php echo $topay; ?></span>
                                        <div class="step-desc">
                                                <span class="step-title">To</span>
                                                <p>amount</p>
                                        </div>
                                </div>
                        </div>
                </div>
                
                <div class="padding-horizontal-15">
                        
                <div class="row">
                     <div class="col-md-6">
                             <div class="widget widget-shadow">
                                     <div class="widget-header padding-10 bg-grey-100">
                                             <a class="avatar avatar-lg pull-left margin-right-20" href="javascript:void(0)">
                                                     <img src="<?php echo $client->avatar; ?>" alt="">
                                             </a>
                                             <div class="vertical-align text-right height-80 text-truncate">
                                                     <div class="vertical-align-middle">
                                                             <div class="font-size-16 margin-bottom-5 blue-600 text-truncate"><?php echo $client->first_name; ?> <?php echo $client->last_name; ?><br/><?php echo $client->phone; ?><br/><?php echo $client->email; ?></div>
                                                             <div class="font-size-12 text-truncate"><?php echo $client_string; ?> <?php if($client_approved == true) { echo "<span class='green-600'>(approved)</span>"; } else { echo "<span class='grey-400'>(not approved yet)</span>"; } ?></div>
                                                     </div>
                                             </div>
                                     </div>
                             </div>
                     </div>
                     <div class="col-md-6">
                             <div class="widget widget-shadow">
                                    <div class="widget-header padding-10 bg-blue-100">
                                             <?php if($agent_id) : ?>
                                             <a class="avatar avatar-lg pull-right margin-left-20" href="javascript:void(0)">
                                                     <img src="<?php echo $agent_info->avatar; ?>" alt="">
                                             </a>
                                             <?php endif; ?>
                                             <div class="vertical-align text-left height-60 text-truncate">
                                                     <div class="vertical-align-middle">
                                                             <?php if($agent_id) : ?>
                                                                     <div class="font-size-16 margin-bottom-5 blue-600 text-truncate"><?php echo $agent_info->first_name; ?> <?php echo $agent_info->last_name; ?><br/><?php echo $agent_info->phone; ?><br/><?php echo $agent_info->email; ?></div>
                                                                     <div class="font-size-12 text-truncate"><?php echo $agent_string; ?></div>
                                                             <?php else : ?>
                                                                     <div class="font-size-14 margin-bottom-5 blue-600 text-truncate">No <?php echo $agent_string; ?> selected</div>
                                                             <?php endif; ?>
                                                             
                                                     </div>
                                             </div>
                                     </div>
                             </div>
                     </div>   
                </div>
                
                <?php // show Quote Templates ?>
                
                <div class="row">
                        <div class="col-md-12">
                                <h4 color="blue-grey-800">Notes</h4>
                        </div>   
                </div>
                <div class="row">
                        <div class="col-md-12">
                           

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
                        </div>   
                </div>
									
							  <div class="row">
                        <div class="col-md-12">
                                <h4 color="blue-grey-800">Tasks</h4>
                        </div>   
                </div>
                <div class="row">
                        <div class="col-md-12">
                            <div class="tasks">

        <ul class="list-task list-group sortable " data-role="tasklist" data-plugin="sortable" data-sortable-id="2" aria-dropeffect="move">
                
                <?php $tasks = get_field('tasks',$quote_id); ?>
        
                <?php if(is_array($tasks)) : $i=0; foreach($tasks as $task) : $i++; ?>
                
                        <?php 
                        $task_title = $task['task_title'];
                        $task_date = $task['task_date'];
                        $task_done = $task['task_done'];
                        ?>
                        
                        <li class="list-group-item margin-vertical-0 padding-vertical-0">
                                <div class="checkbox-custom checkbox-primary task_item_<?php echo $i; ?> <?php if($task_done == true) { echo "task_done"; } ?>">
                                        <input class="<?php if($task_done != true && !is_client()) { echo "task_done_action"; } ?> task_row_<?php echo $i; ?>" data-row="<?php echo $i; ?>" data-quote="<?php echo $quote_id; ?>" type="checkbox" id="task_check_<?php echo $i; ?>" name="task_<?php echo $i; ?>" <?php if($task_done == true) { echo "checked='' disabled=''"; } if(is_client()) { echo "disabled=''"; } ?>>
                                        <label for="task_check_<?php echo $i; ?>">
                                                <span><small><?php echo $task_date; ?></small> <?php echo $task_title; ?></span>
                                        </label>
                                </div>
                        </li>
                        
                        <?php endforeach; else : ?>
                
                                <p class="text-center no-tasks">There are no tasks yet.</p>
                
                        <?php endif; ?>
                        
        </ul>

</div>

<?php if(!is_client()) : ?>
<a class="btn btn-block btn-success add_task">Add Task</a>

<div class="tasks_form margin-top-20" style="display:none;">
        <form id="add_task">
                <input type="hidden" name="quote_id" value="<?php echo $quote_id; ?>">
                <div class="row">
                        <div class="col-md-12 col-xs-12">
                                <h5 class="grey-800 ">Task</h5>
                                <div class="form-group">
                                        <input type="text" class="form-control input-sm" name="task" />
                                </div>
                        </div>
                </div>
                <div class="row">
                        <div class="col-md-6 col-xs-12">
                                <div class="tasks_response"></div>
                        </div>
                        <div class="col-md-6 col-xs-12 text-right">
                                <a class="btn btn-primary save_task">Add</a>
                        </div>
                </div>
        </form>
</div>
<?php endif; ?>   
                        </div>   
                </div>
                
                <?php // show Selections 
                if($status->status == 'active' || $status->status == 'pending' || $status->status == 'live' || $status->status == 'completed') :?>
                <div class="row margin-top-20">
                        <div class="col-md-12">
                                <h4 color="blue-grey-800">Selections</h4>
                        </div>   
                </div>
                <div class="row">
                        <div class="col-md-12">
                                <?php if($selections) : ?>
                                <?php $s=0; foreach($selections as $selection) : $s++;
                                        $title = $selection['title'];
                                        $price = $selection['price'];
                                        $photo = $selection['photo'];
                        		$size = "selection";
                        		$photo = wp_get_attachment_image_src( $photo, $size );
                        		$photo_url = $photo[0];
                                ?>
                                        <div class="template_show">
                                                <a class="popup_details hidden-xs hidden-sm" data-target='#selection_<?php echo $s; ?>' data-toggle='modal'><i class="icon wb-info-circle"></i></a>
                                                <?php if($photo) : ?>
                                                        <img src="<?php echo $photo_url; ?>">
                                                <?php else : ?>
                                                        <img src="<?php bloginfo('template_url'); ?>/assets/defaults/no_selection.png">
                                                <?php endif; ?>
                                                <div class="text-center"><strong><?php echo $title; ?></strong></div>
                                                <div class="text-center">$<?php echo $price; ?></div>
                                        </div>
                                <?php endforeach; ?>
                                <?php else : ?>
                                        <p class="margin-top-20">No selection details yet.</p>
                                <?php endif; ?>
                        </div>   
                </div>
                
              
                <?php endif; ?>
                
                
                
                </div>
                
	
        </section>
        <div class="slidePanel-footer text-center margin-bottom-0">
                <a class="btn btn-primary" href="<?php echo get_the_permalink($quote_id); ?>"><i class="icon wb-more-horizontal"></i> Goto Project</a>
        </div>
</div>

<?php $s=0; foreach($selections as $selection) : $s++;
        $title = $selection['title'];
        $price = $selection['price'];
        $description = $selection['description'];
        $photo = $selection['photo'];
        $size = "full";
        $photo = wp_get_attachment_image_src( $photo, $size );
        $photo_url = $photo[0];
?>
<div class='modal fade' id='selection_<?php echo $s; ?>' aria-hidden='true' aria-labelledby='selection_<?php echo $s; ?>' role='dialog' tabindex='-1'>
        <div class='modal-dialog modal-center'>
                <div class='modal-content'>
                        <div class='modal-header text-center'>
                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                        <span aria-hidden='true'>×</span>
                                </button>
                                <h4 class='modal-title'><?php echo $title; ?></h4>
                        </div>
                        <div class='modal-body selection_popup'>
                                <?php if($photo) : ?>
                                        <div class="text-center"><img src="<?php echo $photo_url; ?>" alt=""></div>
                                <?php endif; ?>
                                <div class="text-center"><span class="label label-lg label-info">$<?php echo $price; ?></span></div>
                                <div><?php echo $description; ?></div>
                        </div>
                </div>
        </div>
</div>
<?php endforeach; ?>