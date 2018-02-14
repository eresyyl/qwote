<?php
// getting Current User ID
$current_user_id = current_user_id();

// get project infos
$quote_id = get_the_ID();

// clear notification of current quote
go_clear_notifications($current_user_id,$quote_id);
go_clear_messages($current_user_id,$quote_id);

$status = go_project_status($quote_id);
$payments = get_field('payments');
$total = get_field('total'); $total = round($total,2); $total = number_format($total, 2, '.', '');
$paid = get_field('paid'); $paid = round($paid,2); $paid = number_format($paid, 2, '.', '');
$topay = get_field('topay'); $topay = round($topay,2); $topay = number_format($topay, 2, '.', '');

$variations = get_field('add_payments');

// get Client info
$client_id = get_field('client_id',$quote_id);
if($client_id[0] == NULL) {
        $client_id = $client_id['ID'];
}
else {
        $client_id = $client_id[0];
}
$client = go_userdata($client_id);
$client_approved = get_field('client_approve');
// get Contractor info
$agent_id = get_field('agent_id',$quote_id);
if($agent_id){
        if($agent_id[0] == NULL) {
                $agent_id = $agent_id['ID'];
        }
        else {
                $agent_id = $agent_id[0];
        } 
        $agent_info = go_userdata($agent_id);
        $agent_approved = get_field('agent_approve');
}

$client_string = get_field('client','options');
$contractor_string = get_field('contractor','options');
$agent_string = get_field('agent','options');
$head_string = get_field('head_contractor','options');

?>
<?php get_header(); ?>
  
<div class="page animsition">
	  
        <?php get_template_part('project-templates/sidebars/sidebar','client'); ?>  
	  
        <div class="page-main"> 
                <div class="page-content">
									<div class="panel">
                               
                                <div class="panel-body">
                        <div class="row">
												
                                <div class="col-md-12 text-center">
                                        <h3><?php echo go_generate_title($quote_id); ?> -  <span class="label label-<?php echo $status->status_class; ?>"><?php echo $status->status_string; ?></span>
</h3>
                                        	<p>
								<i class="icon wb-map"></i> <?php echo $client->address; ?>
							</p>
                                </div>
                                
                        </div>
                        
                        <?php // Project Participants ?>
                        
                                        
                                        <div class="row">
                                                <div class="col-md-6">
                                                        <div class="widget widget-shadow margin-bottom-10">
                                                                <div class="widget-header padding-10 bg-grey-100">
                                                                        <a class="avatar avatar-lg pull-left margin-right-20" href="javascript:void(0)">
                                                                                <img src="<?php echo $client->avatar; ?>" alt="">
                                                                        </a>
                                                                        <div class="vertical-align text-right height-80 text-truncate">
                                                                                <div class="vertical-align-middle">
                                                                                        <div class="font-size-16 margin-bottom-5 blue-600 text-truncate"><?php echo $client->first_name; ?> <?php echo $client->last_name; ?></div>
                                                                                        <div class="font-size-12 text-truncate"><?php echo $client_string; ?> <?php if($client_approved == true) { echo "<span class='green-600'>(approved)</span>"; } else { echo "<span class='grey-400'>(not approved yet)</span>"; } ?></div>
                                                                                </div>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                        <?php // confirmation from client
                                                        if($client_approved != true && $status->status == 'active') :
                                                                ?>
                                                                <p class="margin-top-20 project_actions">
                                                                       Would you like to Accept the Quote?
						                                                   <a class="btn btn-success btn-lg margin-horizontal-10" data-target='#approve' data-toggle='modal' data-quote='<?php echo $quote_id; ?>' class='icon wb-check green-600 approve'>Accept</a>
																																					
																																				<i data-target='#approve' data-toggle='modal' data-quote='<?php echo $quote_id; ?>' class='icon wb-check green-600 approve'></i></a>
                                                                </p>
                                                             
                                                                <div class='modal fade' id='approve' aria-hidden='true' aria-labelledby='approve' role='dialog' tabindex='-1'>
                                                                        <div class='modal-dialog modal-center'>
                                                                                <div class='modal-content'>
                                                                                        <div class='modal-header text-center'>
                                                                                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                                                                        <span aria-hidden='true'>×</span>
                                                                                                </button>
                                                                                                <h4 class='modal-title'>Are you sure you want to accept?</h4>
                                                                                        </div>
                                                                                        <div class='modal-body text-center'>
                                                                                                <div id='approve_respopnse'></div>
                                                                                                <a class='btn btn-success approve_confirm' data-quote=''>Yes, please!</a>
                                                                                                <a class='btn btn-default btn-sm approve_cancel' data-dismiss='modal' aria-label='Close'>No, i was wrong</a>
                                                                                        </div>
                                                                                </div>
                                                                        </div>
                                                                </div>
                                                             
                                                             
                                                        <?php endif; ?>
                                                </div>
                                                <div class="col-md-6">
                                                        <div class="widget widget-shadow margin-bottom-10">
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
                                                                                                <div class="font-size-14 margin-bottom-5 blue-600 text-truncate">No <?php echo $agent_string; ?>  selected</div>
                                                                                                <div class="font-size-12 text-truncate">A <?php echo $agent_string; ?> will be selected when the project is Active</div>
                                                                                        <?php endif; ?>
                                                             
                                                                                </div>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                </div>   
                                        </div>
                                        
                                </div>
				
                        </div>
                        		
                         
                        <div class="row">
                                <div class="col-md-6 col-xs-12">
                                        <div class="panel">
                                                <div class="panel-heading">
                                                        <ul class="panel-actions">
                                                                <li><a target="_blank" href="<?php bloginfo('url'); ?>/tcpdf/scope/scope.php?project_id=<?php echo get_the_ID(); ?>">Download PDF</a></li>
                                                        </ul>
                                                        <h3 class="panel-title" style="font-size:18px; padding: 0px 10px;">Project Scope</h3>
                                                </div>
                                                <div class="panel-body">

                                                        <?php include('views/scope.php'); ?>

                                                </div>
                                        </div>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                        <div class="panel">
                                                <div class="nav-tabs-horizontal">
                                                        <ul class="nav nav-tabs nav-tabs-line" data-plugin="nav-tabs" role="tablist">
                                                                <li class="active" role="presentation"><a data-toggle="tab" href="#mes" aria-controls="mes" role="tab" aria-expanded="true">Messages</a></li>
                                                                <li role="presentation"><a data-toggle="tab" href="#activity" aria-controls="activity" role="tab" aria-expanded="true">Notifications</a></li>
                                                                <li role="presentation"><a data-toggle="tab" href="#tasks" aria-controls="tasks" role="tab" aria-expanded="true">Tasks</a></li>
                                                        </ul>
                                                </div>

                                                <div class="panel-body padding-0">
                                                        <div class="tab-content">
                                                                <div class="tab-pane active" id="mes" role="tabpanel">

                                                                        <?php include('views/messages.php'); ?>
                                                                </div>
                                                                
                                                                <div class="tab-pane padding-30" id="activity" role="tabpanel">

                                                                        <?php include('views/activity.php'); ?>

                                                                </div>
								
                                                                <div class="tab-pane padding-30" id="tasks" role="tabpanel">
                                                                        
                                                                        <?php include('views/project_tasks.php'); ?>

                                                                </div>
                                                                
                                                        </div>

                                                </div>
                                        </div>
                                </div>
                        </div>
		 
			     
                        <?php // Project details ?>
                        <div class="panel">

                                        <div class="nav-tabs-horizontal">
                                                <ul class="nav nav-tabs nav-tabs-line" data-plugin="nav-tabs" role="tablist">
                                                        <li class="active" role="presentation"><a data-toggle="tab" href="#payments" aria-controls="Payments" role="tab" aria-expanded="true">Payments</a></li>
                                                        <li role="presentation" class=""><a data-toggle="tab" href="#contract" aria-controls="contract" role="tab" aria-expanded="false">Proposal</a></li>
                                                        <li role="presentation" class=""><a data-toggle="tab" href="#selections" aria-controls="selections" role="tab" aria-expanded="false">Selections</a></li>
                                                        <li role="presentation" class=""><a data-toggle="tab" href="#schedule" aria-controls="schedule" role="tab" aria-expanded="false">Schedule</a></li>
                                                        <li class="dropdown" role="presentation" style="display: none;">
                                                                <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                                                        <span class="caret"></span>More
                                                                </a>
                                                                <ul class="dropdown-menu" role="menu">
                                                                        <li class="" role="presentation"><a data-toggle="tab" href="#payments" aria-controls="payments" role="tab">Payments</a></li>
                                                                        <li role="presentation"><a data-toggle="tab" href="#contract" aria-controls="contract" role="tab">Proposal</a></li>
                                                                        <li role="presentation"><a data-toggle="tab" href="#selections" aria-controls="selections" role="tab">Selections</a></li>
                                                                        <li role="presentation"><a data-toggle="tab" href="#schedule" aria-controls="schedule" role="tab">Schedule</a></li>
                                                                </ul>
                                                        </li>
                                                </ul>
                                                
                                                <div class="tab-content padding-20">
                                                        <div class="tab-pane active" id="payments" role="tabpanel">
                                                                
                                                                                                               
                                                                <?php // Project milestones ?>
                                                                <div class="panel">
                                                                        <div class="panel-heading">
                                                                                <h3 class="panel-title" style="font-size:18px; padding: 0px 10px;">Payments</h3>
                                                                                <ul class="panel-info">
                                                                                        <li>
                                                                                                <div class="num blue-600">$<?php echo $total; ?></div>
                                                                                                <p>Total</p>
                                                                                        </li>
                                                                                        <li>
                                                                                                <div class="num green-600">$<?php echo $paid; ?></div>
                                                                                                <p>Paid</p>
                                                                                        </li>
                                                                                        <li>
                                                                                                <div class="num orange-600">$<?php echo $topay; ?></div>
                                                                                                <p>To Pay</p>
                                                                                        </li>
                                                                                </ul>
                                                                        </div>
                                                                        <div class="panel-body">
                                                                                <div class="table-responsive">
                                                                                        <table class="table">
                                                                                                <thead>
                                                                                                        <tr>
                                                                                                                <th>Status</th>
                                                                                                                <th>Date</th>
                                                                                                                <th>Description</th>
                                                                                                                <th>Total</th>
                                                                                                                <th class="text-center">Actions</th>
                                                                                                        </tr>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                        <?php if($payments) : $i=0; foreach($payments as $payment) : $i++; ?>
                                                                                                                <?php // get payment (milestone data)
                                                                                                                $percent = $payment['percent'];
                                                                                                                $price = ($percent * $total) / 100;
                                                                                                                $price = number_format($price, 2, '.', '');
                                                                                                                if($payment['status'] == 'pending') {
                                                                                                                        $status_class = "default";
                                                                                                                }
                                                                                                                elseif($payment['status'] == 'active') {
                                                                                                                        $status_class = "info";
                                                                                                                }
                                                                                                                elseif($payment['status'] == 'done') {
                                                                                                                        $status_class = "primary";
                                                                                                                }
                                                                                                                elseif($payment['status'] == 'paid') {
                                                                                                                        $status_class = "success";
                                                                                                                }
                                                                                                                ?>
                                                                                                                <tr id="payment_<?php echo $i; ?>">
                                                                                                                        <td class="work-status" style="width:10%;">
                                                                                                                                <span class="label label-<?php echo $status_class; ?>" style="text-transform: capitalize;"><?php echo $payment['status']; ?></span>
                                                                                                                        </td>
                                                                                                                        <td class="date" style="width:15%;">
                                                                                                                                <span class="blue-grey-400"><?php echo $payment['due_date']; ?></span>
                                                                                                                        </td>
                                                                                                                        <td class="subject">
                                                                                                                                <div class="table-content">
                                                                                                                                        <p class="blue-grey-500"><?php echo $payment['title']; ?></p>
                                                                                                                                        <p class="blue-grey-400"><?php echo $payment['description']; ?></p>
                                                                                                                                </div>
                                                                                                                        </td>
                                                                                                                        <td class="total">
                                                                                                                                <span class="blue-grey-800">$<?php echo $price; ?></span>
                                                                                                                                <p class="blue-grey-400">(%<?php echo $percent; ?> of total)</p>
                                                                                                                        </td>
                                                                                                                        <td class="actions text-center">
                                                                                                                                <div class="table-content">
                                                                                                                                        <?php 
                                                                                                                                        if($payment['status'] == 'active') {
                                                                                                                                                go_payment_actions(array('waiting'),$quote_id,$i);
                                                                                                                                        }
                                                                                                                                        elseif($payment['status'] == 'done') {
                                                                                                                                                go_payment_actions(array('done','invoice'),$quote_id,$i);
                                                                                                                                        }
                                                                                                                                        elseif($payment['status'] == 'paid') {
                                                                                                                                                go_payment_actions(array('done','invoice','paid'),$quote_id,$i);
                                                                                                                                        }
                                                                                                                                        ?>
                                                                                                                                </div>
                                                                                                                        </td>    
                                                                                                                </tr>
                                                                                                                
                                                                                                                <?php if(is_array($payment['adjustments'])) : $j=0; foreach($payment['adjustments'] as $adj) : $j++; ?>
                                                                                                                        <tr style="background: #F9F9F9;">
                                                                                                                                <td style="padding: 10px 8px;"></td>
                                                                                                                                <td style="padding: 10px 8px;" class="text-center">
                                                                                                                                        <i data-toggle='tooltip' data-placement='top' data-trigger='hover' data-original-title='Milestone adjustment' title='' class="icon wb-help-circle grey-400"></i>
                                                                                                                                </td>
                                                                                                                                <td style="padding: 10px 8px;">
                                                                                                                                        <p class="blue-grey-500"><?php echo $adj['title']; ?></p>
                                                                                                                                        <p class="blue-grey-400"><?php echo $adj['description']; ?></p>
                                                                                                                                </td>
                                                                                                                                <td style="padding: 10px 8px;">
                                                                                                                                        $<?php echo $adj['price']; ?>
                                                                                                                                </td> 
                                                                                                                                <td style="padding: 10px 8px;" class="text-center">
                                                                                       
                                                                                                                                </td>
                                                                                                                        </tr>
                                                                                                                <?php endforeach; endif; ?>
                                                                                                                
                                                                                                        <?php endforeach; else : ?>
                                                                                                                <tr class="text-center">
                                                                                                                        <td colspan="5">
                                                                                                                                There are no payments yet.
                                                                                                                        </td>
                                                                                                                </tr>
                                                                                                        <?php endif; ?>
                                                                                                </tbody>
                                                                                        </table>
                                                                                </div>
                                                                        </div>
				
                                                                </div>
                        
                        
                                                                <?php // Project Additional milestones 
                                                                if($variations) :
                                                                        ?>
                                                                        <div class="panel">
                                                                                <div class="panel-heading">
                                                                                        <h3 class="panel-title" style="font-size:18px; padding: 0px 10px;">Variations</h3>
                                                                                </div>
                                                                                <div class="panel-body">
                                                                                        <div class="table-responsive">
                                                                                                <table class="table">
                                                                                                        <thead>
                                                                                                                <tr>
                                                                                                                        <th>Status</th>
                                                                                                                        <th>Date</th>
                                                                                                                        <th>Description</th>
                                                                                                                        <th>Total</th>
                                                                                                                        <th class="text-center">Actions</th>
                                                                                                                </tr>
                                                                                                        </thead>
                                                                                                        <tbody>
                                                                                                                <?php if($variations) : $i=0; foreach($variations as $variation) : $i++; ?>
                                                                                                                        <?php // get payment (milestone data)
                                                                                                                        $price = $variation['percent'];
                                                                                                                        $price = number_format($price, 2, '.', '');
                                                                
                                                                                                                        if($variation['status'] == 'pending') {
                                                                                                                                $status_class = "default";
                                                                                                                        }
                                                                                                                        elseif($variation['status'] == 'active') {
                                                                                                                                $status_class = "info";
                                                                                                                        }
                                                                                                                        elseif($variation['status'] == 'done') {
                                                                                                                                $status_class = "primary";
                                                                                                                        }
                                                                                                                        elseif($variation['status'] == 'paid') {
                                                                                                                                $status_class = "success";
                                                                                                                        }
                                                                                                                        ?>
                                                                                                                        <tr id="var_<?php echo $i; ?>">
                                                                                                                                <td class="work-status" style="width:10%;">
                                                                                                                                        <span class="label label-<?php echo $status_class; ?>" style="text-transform: capitalize;"><?php echo $variation['status']; ?></span>
                                                                                                                                </td>
                                                                                                                                <td class="date" style="width:15%;">
                                                                                                                                        <span class="blue-grey-400"><?php echo $variation['due_date']; ?></span>
                                                                                                                                </td>
                                                                                                                                <td class="subject">
                                                                                                                                        <div class="table-content">
                                                                                                                                                <p class="blue-grey-500"><?php echo $variation['title']; ?></p>
                                                                                                                                                <p class="blue-grey-400"><?php echo $variation['description']; ?></p>
                                                                                                                                        </div>
                                                                                                                                </td>
                                                                                                                                <td class="total">
                                                                                                                                        <span class="blue-grey-800">$<?php echo $price; ?></span>
                                                                                                                                </td>
                                                                                                                                <td class="actions text-center">
                                                                                                                                        <div class="table-content">
                                                                                                                                                <?php 
                                                                                                                                                if($variation['status'] == 'active') {
                                                                                                                                                        go_variaton_actions(array('waiting'),$quote_id,$i);
                                                                                                                                                }
                                                                                                                                                elseif($variation['status'] == 'done') {
                                                                                                                                                        go_variaton_actions(array('done','invoice'),$quote_id,$i);
                                                                                                                                                }
                                                                                                                                                elseif($variation['status'] == 'paid') {
                                                                                                                                                        go_variaton_actions(array('done','invoice','paid'),$quote_id,$i);
                                                                                                                                                }
                                                                                                                                                ?>
                                                                                                                                        </div>
                                                                                                                                </td>    
                                                                                                                        </tr>
                                                                                                                <?php endforeach; else : ?>
                                                                                                                <?php endif; ?>
                                                                                                        </tbody>
                                                                                                </table>
                                                                                        </div>
                                                                                </div>
				
                                                                        </div>
                                                                <?php endif; ?>
                        
                                                                
                                                        </div>
                                                        
                                                        <div class="tab-pane" id="contract" role="tabpanel">
                                                                
                                                                <?php include('views/contract.php'); ?>
                                                                
                                                        </div>
                                                        <div class="tab-pane" id="selections" role="tabpanel">
                                                                
                                                                <?php include('views/selections.php'); ?>
                                                                
                                                        </div>
                                                        <div class="tab-pane" id="schedule" role="tabpanel">
                                                                
                                                                <?php include('views/schedule.php'); ?>
                                                                
                                                        </div>
                                                        							
                                                </div>
                                        </div>
                        </div>
                         
			
                  
                        
                </div>
        </div>
</div>

<?php get_footer(); ?>