<?php
require_once( ABSPATH . 'wp-load.php');
// getting Current User ID
$current_user_id = current_user_id();
// get project infos
$quote_id = get_the_ID();
?>

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
                
                                <p class="text-center no-tasks">There is no tasks yet.</p>
                
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