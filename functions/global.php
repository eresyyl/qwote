
<?php
require_once(ABSPATH . "wp-load.php");

// retrieving All user data
function go_userdata($id) {
	$object = new stdClass();
    $user_data = get_userdata($id);

	// getting basic user data: First name, Last name, Email, Phone, User Type
	if($user_data != false) {
		$object->id = $id;
		$object->login = $user_data->user_login;
		$object->first_name = $user_data->first_name;
		$object->last_name = $user_data->last_name;
		$object->email = $user_data->user_email;
		$object->phone = get_field('phone','user_' . $id);
                $object->address = get_field('address','user_' . $id);
		$object->type = get_field('user_type','user_' . $id);
                $object->location = get_field('location','user_' . $id);
	}
	else {
		$object = false;
	}

	// getting user Avatar link
	if(get_field('ava','user_' . $id)) {
		$user_avatar = get_field('ava','user_' . $id );
		$size = "ava";
		$ava = wp_get_attachment_image_src( $user_avatar, $size );
		$user_avatar = $ava[0];
	}
	else {
		$user_avatar = get_bloginfo('template_url') . '/assets/defaults/default-ava.png';
	}
	$object->avatar = $user_avatar;


	// getting user Admin or not
	if( current_user_can( 'manage_options' ) ) {
		$object->administrator = true;
	}
	else {
		$object->administrator = false;
	}

	return $object;
}

// retrieving Project statistic of user
function go_projects_statistic($id) {
	$object = new stdClass();
	$user_data = get_userdata($id);
	$quote_mode = 0;
	$active = 0;
	$pending = 0;
	$live = 0;
	$completed = 0;
	$cancelled = 0;
	$quote_mode_paid = 0;
	$active_paid = 0;
	$pending_paid = 0;
	$live_paid = 0;
	$completed_paid = 0;
	$cancelled_paid = 0;
	$quote_mode_topay = 0;
	$active_topay = 0;
	$pending_topay = 0;
	$live_topay = 0;
	$completed_topay = 0;
	$cancelled_topay = 0;

	$quote_mode_total = 0;
	$active_total = 0;
	$pending_total = 0;
	$live_total = 0;
	$completed_total = 0;

	if($user_data != false) {
		$user_type = get_field('user_type','user_' . $id);
		if($user_type == 'Client') {
            $args = array('posts_per_page'=>9999,'post_type'=>'project','meta_key'=>'client_id','meta_value'=>$id);
		}
		elseif($user_type == 'Contractor') {
			// let's go for all projects and get ID's of projects where current user id exist. stored in $contractorProjects array
			$allProjects = get_posts(array('posts_per_page' => 9999, 'post_type' => 'project', 'meta_key' => 'contractor_id'));
			$contractorProjects = array();
			foreach($allProjects as $p) {
				$contractors = get_field('contractor_id',$p->ID);
				$contractorsArray = array();
				foreach($contractors as $c) {
					$contractorsArray[] = $c["ID"];
				}
				if(in_array($id,$contractorsArray)) {
					$contractorProjects[] = $p->ID;
				}
			}
			if(!is_array($contractorProjects) || count($contractorProjects) == 0) {
				$contractorProjects = array(0);
			}
			$args = array('posts_per_page'=>9999,'post_type'=>'project','post__in'=>$contractorProjects);
		}
		elseif($user_type == 'Agent') {
			// let's go for all projects and get ID's of projects where current user id exist. stored in $agentProjects array
			$allProjects = get_posts(array('posts_per_page' => 9999, 'post_type' => 'project', 'meta_key' => 'agent_id'));
			$agentProjects = array();
			foreach($allProjects as $p) {
				$agents = get_field('agent_id',$p->ID);
				$agentsArray = array();
				foreach($agents as $a) {
					$agentsArray[] = $a["ID"];
				}
				if(in_array($id,$agentsArray)) {
					$agentProjects[] = $p->ID;
				}
			}
			if(!is_array($agentProjects) || count($agentProjects) == 0) {
				$agentProjects = array(0);
			}
            $args = array('posts_per_page'=>9999,'post_type'=>'project','post__in'=>$agentProjects);
		}
		else {
			$args = array('posts_per_page'=>9999,'post_type'=>'project');
		}

		$all_projects = get_posts($args);
		foreach($all_projects as $project) {
			$status = get_field('status',$project->ID);
			$total = get_field('total',$project->ID);
                        $paid = get_field('paid',$project->ID);
			$topay = get_field('topay',$project->ID);
			if($status == 'quote') {
				$quote_mode++;
                                $quote_mode_total = $quote_mode_total + $total;
				$quote_mode_paid = $quote_mode_paid + $paid;
				$quote_mode_topay = $quote_mode_topay + $topay;
			}
			elseif($status == 'active') {
				$active++;
                                $active_total = $active_total + $total;
				$active_paid = $active_paid + $paid;
				$active_topay = $active_topay + $topay;
			}
			elseif($status == 'pending') {
				$pending++;
                                $pending_total = $pending_total + $total;
				$pending_paid = $pending_paid + $paid;
				$pending_topay = $pending_topay + $topay;
			}
			elseif($status == 'completed') {
				$completed++;
                                $completed_total = $completed_total + $total;
				$completed_paid = $completed_paid + $paid;
				$completed_topay = $completed_topay + $topay;
			}
			elseif($status == 'live') {
				$live++;
                                $live_total = $live_total + $total;
				$live_paid = $live_paid + $paid;
				$live_topay = $live_topay + $topay;
			}
			elseif($status == 'cancelled') {
				$cancelled++;
				$cancelled_paid = $cancelled_paid + $paid;
				$cancelled_topay = $cancelled_topay + $topay;
			}
		}

		$object->quote = $quote_mode;
		$object->active = $active;
		$object->pending = $pending;
		$object->live = $live;
		$object->completed = $completed;
		$object->cancelled = $cancelled;

		$object->quote_total = $quote_mode_total;
		$object->active_total = $active_total;
		$object->pending_total = $pending_total;
		$object->live_total = $live_total;
		$object->completed_total = $completed_total;

		$object->quote_paid = $quote_mode_paid;
		$object->active_paid = $active_paid;
		$object->pending_paid = $pending_paid;
		$object->live_paid = $live_paid;
		$object->completed_paid = $completed_paid;
		$object->cancelled_paid = $cancelled_paid;

		$object->quote_topay = $quote_mode_topay;
		$object->active_topay = $active_topay;
		$object->pending_topay = $pending_topay;
		$object->live_topay = $live_topay;
		$object->completed_topay = $completed_topay;
		$object->cancelled_topay = $cancelled_topay;

	}
	else {
		$object = false;
	}

	return $object;
}

function go_project_status($id) {
	$object = new stdClass();
	$status = get_field('status',$id);
	if($status == 'quote') {
		$object->status = 'quote';
		$object->status_string = 'Quotation';
		$object->status_class = 'default';
	}
	elseif($status == 'active') {
		$object->status = 'active';
		$object->status_string = 'Active';
		$object->status_class = 'primary';
	}
	elseif($status == 'pending') {
		$object->status = 'pending';
		$object->status_string = 'Final Quote';
		$object->status_class = 'warning';
	}
	elseif($status == 'live') {
		$object->status = 'live';
		$object->status_string = 'Live Job';
		$object->status_class = 'info';
	}
	elseif($status == 'completed') {
		$object->status = 'completed';
		$object->status_string = 'Won';
		$object->status_class = 'success';
	}
	elseif($status == 'cancelled') {
		$object->status = 'cancelled';
		$object->status_string = 'Lost';
		$object->status_class = 'dark';
	}

	return $object;
}

function go_generate_title($id) {
        $templates = get_field('templates',$id);
	$templates_title = 'Scope:';
	foreach($templates as $t) {
		$templates_title = $templates_title . " " . get_the_title($t) . ". ";
	}
				  $client_id = get_field('client_id');
					$client = go_userdata($client_id);
	$templates_title = $templates_title . $client->address;
        $object = $templates_title;
        return $object;
}

function go_project_actions($actions,$id) {
        $action_code = '';
        foreach($actions as $act) {
                if($act == 'preview') {
                        $action_code = $action_code . "<a class='preview' data-toggle='tooltip' data-placement='left' data-trigger='hover' data-original-title='Preview' title=''><i class='icon wb-eye' data-url='" . get_bloginfo('url') . "/project_preview?quote_id=" . $id . "' data-toggle='slidePanel'></i></a>";
                }
                elseif($act == 'edit') {
                        $action_code = $action_code . "<a target='_blank' href='" . get_bloginfo('url') . "/edit?quote_id=" . $id . "' data-toggle='tooltip' data-placement='left' data-trigger='hover' data-original-title='Edit Scope' title=''><i class='icon wb-pencil'></i></a>";
                }
                elseif($act == 'permalink') {
                        $action_code = $action_code . "<a class='permalink' href='" . get_the_permalink($id) . "'><i class='icon wb-more-horizontal' data-toggle='tooltip' data-placement='left' data-trigger='hover' data-original-title='Goto Project' title=''></i></a>";
                }
                elseif($act == 'cancel') {
                        $action_code = $action_code . "<a data-toggle='tooltip' data-placement='left' data-trigger='hover' data-original-title='Cancel' title=''><i data-target='#cancel' data-toggle='modal' data-quote='" . $id . "' class='icon wb-close-mini red-600 cancel'></i></a>";
                        $action_code = $action_code . "<div class='modal fade' id='cancel' aria-hidden='true' aria-labelledby='cancel' role='dialog' tabindex='-1'>
                                	<div class='modal-dialog modal-center'>
                                		<div class='modal-content'>
                                			<div class='modal-header text-center'>
                                				<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                					<span aria-hidden='true'>×</span>
                                				</button>
                                				<h4 class='modal-title'>Are you sure you want to cancel?</h4>
                                			</div>
                                			<div class='modal-body text-center'>
                                				<div id='cancel_quote_respopnse'></div>
                                				<div class='cancel_quote_hidden' style='display:none;'></div>
                                				<a class='btn btn-danger cancel_quote' data-quote=''>Yes, please!</a>
                                				<a class='btn btn-default btn-sm cancel_quote_close' data-dismiss='modal' aria-label='Close'>No, i was wrong</a>
                                			</div>
                                		</div>
                                	</div>
                                </div>";
                }
                elseif($act == 'approve') {
                        $action_code = $action_code . "<a data-toggle='tooltip' data-placement='left' data-trigger='hover' data-original-title='Approve' title=''><i data-target='#approve' data-toggle='modal' data-quote='" . $id . "' class='icon wb-check green-600 approve'></i></a>";
                        $action_code = $action_code . "<div class='modal fade' id='approve' aria-hidden='true' aria-labelledby='approve' role='dialog' tabindex='-1'>
                                	<div class='modal-dialog modal-center'>
                                		<div class='modal-content'>
                                			<div class='modal-header text-center'>
                                				<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                					<span aria-hidden='true'>×</span>
                                				</button>
                                				<h4 class='modal-title'>Are you sure you want to approve?</h4>
                                			</div>
                                			<div class='modal-body text-center'>
                                				<div id='approve_quote_respopnse'></div>
                                				<a class='btn btn-success approve_quote' data-quote=''>Yes, please!</a>
                                				<a class='btn btn-default btn-sm approve_quote_close' data-dismiss='modal' aria-label='Close'>No, i was wrong</a>
                                			</div>
                                		</div>
                                	</div>
                                </div>";
                }
                elseif($act == 'add_details') {
                        if(is_singular('project')) {
                                $single = '&single=true';
                        }
                        else {
                                $single = '&single=false';
                        }
                        $action_code = $action_code . "<a class='add_details' data-toggle='tooltip' data-placement='left' data-trigger='hover' data-original-title='Manage Project Details' title=''><i class='icon wb-medium-point blue-800' data-url='" . get_bloginfo('url') . "/manage_details?quote_id=" . $id . $single . "' data-toggle='slidePanel'></i></a>";
                }
        }

        echo $action_code;
}

function go_payment_actions($actions,$id,$i) {
        $action_code = '';
        foreach($actions as $act) {
                if($act == 'done') {
                        $action_code = $action_code . "<i class='icon wb-check-circle green-600' style='cursor:default;' data-toggle='tooltip' data-placement='left' data-trigger='hover' data-original-title='Send Invoice' title=''></i>";
                }
                elseif($act == 'invoice') {
                        $payments = get_field('payments',$id);
                        $row = $i - 1;
                        $invoice_id = $payments[$row]['invoice_id'];
                        $action_code = $action_code . "<a data-toggle='tooltip' data-placement='left' data-trigger='hover' data-original-title='Payment Invoice' title='' href='" . get_bloginfo('url') . "/?p=" . $invoice_id . "'><i class='icon wb-file orange-600'></i></a>";
                }
                elseif($act == 'paid') {
                        $action_code = $action_code . "<i class='icon wb-order green-600 margin-right-20' style='cursor:default;' data-toggle='tooltip' data-placement='left' data-trigger='hover' data-original-title='Marked as Paid' title=''></i>";
                }
                elseif($act == 'waiting') {
                        $action_code = $action_code . "<i class='icon wb-time grey-400' style='cursor:default;' data-toggle='tooltip' data-placement='left' data-trigger='hover' data-original-title='Awaiting Payment' title=''></i>";
                }
                elseif($act == 'mark_done') {
                        $action_code = $action_code . "<a data-toggle='tooltip' data-placement='left' data-trigger='hover' data-original-title='Mark as Done' title=''><i data-target='#mark_done' data-toggle='modal' data-quote='" . $id . "' data-milestone='" . $i . "' class='icon wb-check green-600 mark_as_done'></i></a>";
                        $action_code = $action_code . "<div class='modal fade' id='mark_done' aria-hidden='true' aria-labelledby='mark_done' role='dialog' tabindex='-1'>
                                	<div class='modal-dialog modal-center'>
                                		<div class='modal-content'>
                                			<div class='modal-header text-center'>
                                				<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                					<span aria-hidden='true'>×</span>
                                				</button>
                                				<h4 class='modal-title'>Are you sure you want to send this?</h4>
                                			</div>
                                			<div class='modal-body text-center'>
                                				<div id='mark_as_done_respopnse'></div>
                                				<a class='btn btn-success mark_as_done_confirm' data-quote='' data-milestone=''>Yes, please!</a>
                                				<a class='btn btn-default btn-sm mark_as_done_close' data-dismiss='modal' aria-label='Close'>No, i was wrong</a>
                                			</div>
                                		</div>
                                	</div>
                                </div>";
                }
                elseif($act == 'mark_paid') {
                        $action_code = $action_code . "<a data-toggle='tooltip' data-placement='left' data-trigger='hover' data-original-title='Mark as Paid' title=''><i data-target='#mark_paid' data-toggle='modal' data-quote='" . $id . "' data-milestone='" . $i . "' class='icon wb-check green-600 mark_as_paid'></i></a>";
                        $action_code = $action_code . "<div class='modal fade' id='mark_paid' aria-hidden='true' aria-labelledby='mark_paid' role='dialog' tabindex='-1'>
                                	<div class='modal-dialog modal-center'>
                                		<div class='modal-content'>
                                			<div class='modal-header text-center'>
                                				<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                					<span aria-hidden='true'>×</span>
                                				</button>
                                				<h4 class='modal-title'>Are you sure you want to mark as Paid?</h4>
                                			</div>
                                			<div class='modal-body text-center'>
                                				<div id='mark_as_paid_respopnse'></div>
                                				<a class='btn btn-success mark_as_paid_confirm' data-quote='' data-milestone=''>Yes, please!</a>
                                				<a class='btn btn-default btn-sm mark_as_paid_close' data-dismiss='modal' aria-label='Close'>No, i was wrong</a>
                                			</div>
                                		</div>
                                	</div>
                                </div>";
                }
                elseif($act == 'adjust') {
                        $action_code = $action_code . "<a data-toggle='tooltip' data-placement='left' data-trigger='hover' data-original-title='Adjust Milestone' title='' class='adjust' data-quote='" . $id . "' data-milestone='" . $i . "'><i class='icon wb-settings grey-600'></i></a>";
                }
        }

        echo $action_code;
}

function go_variaton_actions($actions,$id,$i) {
        $action_code = '';
        foreach($actions as $act) {
                if($act == 'done') {
                        $action_code = $action_code . "<i class='icon wb-check-circle green-600' style='cursor:default;' data-toggle='tooltip' data-placement='left' data-trigger='hover' data-original-title='Marked as Done' title=''></i>";
                }
                elseif($act == 'invoice') {
                        $payments = get_field('add_payments',$id);
                        $row = $i - 1;
                        $invoice_id = $payments[$row]['invoice_id'];
                        $action_code = $action_code . "<a data-toggle='tooltip' data-placement='left' data-trigger='hover' data-original-title='Payment Variation Invoice' title='' href='" . get_bloginfo('url') . "/?p=" . $invoice_id . "'><i class='icon wb-file orange-600'></i></a>";
                }
                elseif($act == 'paid') {
                        $action_code = $action_code . "<i class='icon wb-order green-600 margin-right-20' style='cursor:default;' data-toggle='tooltip' data-placement='left' data-trigger='hover' data-original-title='Marked as Paid' title=''></i>";
                }
                elseif($act == 'waiting') {
                        $action_code = $action_code . "<i class='icon wb-time grey-400' style='cursor:default;' data-toggle='tooltip' data-placement='left' data-trigger='hover' data-original-title='In progress' title=''></i>";
                }
                elseif($act == 'mark_done') {
                        $action_code = $action_code . "<a data-toggle='tooltip' data-placement='left' data-trigger='hover' data-original-title='Mark as Done' title=''><i data-target='#mark_done_variation' data-toggle='modal' data-quote='" . $id . "' data-milestone='" . $i . "' class='icon wb-check green-600 mark_as_done_variation'></i></a>";
                        $action_code = $action_code . "<div class='modal fade' id='mark_done_variation' aria-hidden='true' aria-labelledby='mark_done_variation' role='dialog' tabindex='-1'>
                                	<div class='modal-dialog modal-center'>
                                		<div class='modal-content'>
                                			<div class='modal-header text-center'>
                                				<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                					<span aria-hidden='true'>×</span>
                                				</button>
                                				<h4 class='modal-title'>Are you sure you want to mark as Done?</h4>
                                			</div>
                                			<div class='modal-body text-center'>
                                				<div id='mark_as_done_variation_respopnse'></div>
                                				<a class='btn btn-success mark_as_done_variation_confirm' data-quote='' data-milestone=''>Yes, please!</a>
                                				<a class='btn btn-default btn-sm mark_as_done_variation_close' data-dismiss='modal' aria-label='Close'>No, i was wrong</a>
                                			</div>
                                		</div>
                                	</div>
                                </div>";
                }
                elseif($act == 'mark_paid') {
                        $action_code = $action_code . "<a data-toggle='tooltip' data-placement='left' data-trigger='hover' data-original-title='Mark as Paid' title=''><i data-target='#mark_paid_variation' data-toggle='modal' data-quote='" . $id . "' data-milestone='" . $i . "' class='icon wb-check green-600 mark_as_paid_variation'></i></a>";
                        $action_code = $action_code . "<div class='modal fade' id='mark_paid_variation' aria-hidden='true' aria-labelledby='mark_paid_variation' role='dialog' tabindex='-1'>
                                	<div class='modal-dialog modal-center'>
                                		<div class='modal-content'>
                                			<div class='modal-header text-center'>
                                				<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                					<span aria-hidden='true'>×</span>
                                				</button>
                                				<h4 class='modal-title'>Are you sure you want to mark as Paid?</h4>
                                			</div>
                                			<div class='modal-body text-center'>
                                				<div id='mark_as_paid_variation_respopnse'></div>
                                				<a class='btn btn-success mark_as_paid_variation_confirm' data-quote='' data-milestone=''>Yes, please!</a>
                                				<a class='btn btn-default btn-sm mark_as_paid_variation_close' data-dismiss='modal' aria-label='Close'>No, i was wrong</a>
                                			</div>
                                		</div>
                                	</div>
                                </div>";
                }
        }

        echo $action_code;
}

function go_activity($text,$type,$date,$user,$quote) {
       $activities = get_field('activities',$quote);
       $activities_temp = array();
       foreach($activities as $a) {
               $activities_temp[] = array('text' => $a['text'], 'type' => $a['type'], 'date' => $a['date'], 'user' => $a['user']);
       }
       $activities_temp[] = array('text' => $text, 'type' => $type, 'date' => $date, 'user' => $user);
       update_field('field_56953023c1cc1',$activities_temp,$quote);
}

function go_notification($text,$type,$date,$user,$quote) {
       $notifications = get_field('notifications','user_' . $user);
       $notifications_temp = array();
       foreach($notifications as $n) {
               $notifications_temp[] = array('text' => $n['text'], 'type' => $n['type'], 'date' => $n['date'], 'project_id' => $n['project_id']);
       }
       $notifications_temp[] = array('text' => $text, 'type' => $type, 'date' => $date, 'project_id' => $quote);
       update_field('field_5694e3c0045fc',$notifications_temp,'user_' . $user);
}

function go_clear_notifications($user,$quote) {
       $notifications = get_field('notifications','user_' . $user);
       $notifications_temp = array();
       foreach($notifications as $n) {
               if($quote != $n['project_id']) {
                      $notifications_temp[] = array('text' => $n['text'], 'type' => $n['type'], 'date' => $n['date'], 'project_id' => $n['project_id']);
               }
       }
       update_field('field_5694e3c0045fc',$notifications_temp,'user_' . $user);
}

function go_message($text,$date,$from,$user,$quote) {
       $messages = get_field('messages','user_' . $user);
       $messages_temp = array();
       foreach($messages as $m) {
               $messages_temp[] = array('text' => $m['text'], 'date' => $m['date'], 'user_id' => $m['user_id'], 'project_id' => $n['project_id']);
       }
       $messages_temp[] = array('text' => $text, 'date' => $date, 'user_id' => $from, 'project_id' => $quote);
       update_field('field_569f60bb57903',$messages_temp,'user_' . $user);
}

function go_clear_messages($user,$quote) {
       $messages = get_field('messages','user_' . $user);
       $messages_temp = array();
       foreach($messages as $m) {
               if($quote != $m['project_id']) {
                      $messages_temp[] = array('text' => $n['text'], 'date' => $n['date'], 'user_id' => $m['user_id'], 'project_id' => $n['project_id']);
               }
       }
       update_field('field_569f60bb57903',$messages_temp,'user_' . $user);
}

?>
