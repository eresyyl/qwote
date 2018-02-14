<?php
require_once(ABSPATH . "wp-load.php");

// retrieving Invoice statistic of user
function go_invoice_statistic($id) {
	$object = new stdClass();
	$user_data = get_userdata($id);
	$pending = 0;
	$paid = 0;
	if($user_data != false) {
		$user_type = get_field('user_type','user_' . $id);
		if($user_type == 'Client') {
			$args = array('posts_per_page'=>-1,'post_type'=>'invoice','meta_key'=>'client_id','meta_value'=>$id);
		}
		elseif($user_type == 'Agent') {
                        $agent_cleints = get_field('clients','user_' . $id);
                        $agent_cleints_to_show = array();
                        $agent_cleints_to_show[] = 0;
                        foreach($agent_cleints as $ac) {
                              $agent_cleints_to_show[] = array('key'=>'client_id','value'=>$ac['ID']);
                        }
			$args = array('posts_per_page'=>-1,'post_type'=>'invoice','meta_query'=>array('relation' => 'OR',$agent_cleints_to_show));
		}
		else {
			$args = array('posts_per_page'=>-1,'post_type'=>'invoice');
		}
		
		$all_invoices = get_posts($args);
		foreach($all_invoices as $invoice) {
			$status = get_field('status',$invoice->ID);
			if($status == 'Pending') {
				$pending++;
			}
			elseif($status == 'Paid') {
				$paid++;
			}			
		}
		
		$object->pending = $pending;
		$object->paid = $paid;
	}
	else {
		$object = false;
	}
	
	return $object;
}

function go_invoice_actions($actions,$id) {
        $action_code = '';
        foreach($actions as $act) {
                if($act == 'paid') {
                        $action_code = $action_code . "<i class='icon wb-order green-600 margin-right-20' style='cursor:default;' data-toggle='tooltip' data-placement='left' data-trigger='hover' data-original-title='Marked as Paid' title=''></i>";
                }
                elseif($act == 'mark_paid') {
                        $action_code = $action_code . "<a data-toggle='tooltip' data-placement='left' data-trigger='hover' data-original-title='Approve' title=''><i data-target='#paid' data-toggle='modal' data-invoice='" . $id . "' class='icon wb-check green-600 paid'></i></a>";
                        $action_code = $action_code . "<div class='modal fade' id='paid' aria-hidden='true' aria-labelledby='paid' role='dialog' tabindex='-1'>
                                	<div class='modal-dialog modal-center'>
                                		<div class='modal-content'>
                                			<div class='modal-header text-center'>
                                				<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                					<span aria-hidden='true'>×</span>
                                				</button>
                                				<h4 class='modal-title'>Are you sure you want to mark invoice as Paid?</h4>
                                			</div>
                                			<div class='modal-body text-center'>
                                				<div id='paid_invoice_respopnse'></div>
                                				<div class='paid_invoice_hidden' style='display:none;'></div>
                                				<a class='btn btn-success paid_invoice' data-invoice=''>Yes, please!</a>
                                				<a class='btn btn-default btn-sm cancel_invoice' data-dismiss='modal' aria-label='Close'>No, i was wrong</a>
                                			</div>
                                		</div>
                                	</div>
                                </div>";
                }
                elseif($act == 'remind') {
                        $action_code = $action_code . "<a data-toggle='tooltip' data-placement='left' data-trigger='hover' data-original-title='Remind' title=''><i data-target='#remind' data-toggle='modal' data-invoice='" . $id . "' class='icon wb-bell blue-600 remind'></i></a>";
                        $action_code = $action_code . "<div class='modal fade' id='remind' aria-hidden='true' aria-labelledby='remind' role='dialog' tabindex='-1'>
                                	<div class='modal-dialog modal-center'>
                                		<div class='modal-content'>
                                			<div class='modal-header text-center'>
                                				<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                					<span aria-hidden='true'>×</span>
                                				</button>
                                				<h4 class='modal-title'>Are you sure you want to remind client about invoice?</h4>
                                			</div>
                                			<div class='modal-body text-center'>
                                				<div id='remind_invoice_respopnse'></div>
                                				<div class='remind_invoice_hidden' style='display:none;'></div>
                                				<a class='btn btn-success remind_invoice' data-invoice=''>Yes, please!</a>
                                				<a class='btn btn-default btn-sm cancel_remind_invoice' data-dismiss='modal' aria-label='Close'>No, i was wrong</a>
                                			</div>
                                		</div>
                                	</div>
                                </div>";
                }
                elseif($act == 'preview') {
                        $action_code = $action_code . "<a class='preview' href='" . get_bloginfo('url') . "/?p=" . $id . "' data-toggle='tooltip' data-placement='left' data-trigger='hover' data-original-title='Details' title=''><i class='icon wb-more-horizontal'></i></a>";
                }
        }
        
        echo $action_code;
} 
        
?>