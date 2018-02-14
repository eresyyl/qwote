<?php
// getting defaults
$currentUserId = current_user_id();
$currentUserContacts = get_field('contacts','user_' . $currentUserId);
foreach($currentUserContacts as $contact) {
    $currentUserContactsArray[] = $contact['ID'];
}
$projectId = get_the_ID();

// get all Scope prices and store them in Project custom field
go_recalculate_project($projectId);

// getting project participants
$clientId = get_field('client_id',$projectId); $clientId = $clientId['ID'];
$clientData = go_userdata($clientId);

$agentsId = get_field('agent_id',$projectId);
$agentsArray = array();
foreach($agentsId as $a) {
	$agentsArray[] = $a['ID'];
}

$contractorsId = get_field('contractor_id',$projectId);
$contractorsArray = array();
foreach($contractorsId as $c) {
	$contractorsArray[] = $c['ID'];
}

// clear notification of current user
go_clear_notifications($currentUserId,$projectId);
go_clear_messages($currentUserId,$projectId);

// get project details
$projectStatus = go_project_status($projectId);
$projectCity = get_field('projectCity',$projectId);
$projectTimeframe = get_field('projectTimeframe',$projectId);
$projectPayments = get_field('payments',$projectId);
$projectVariations = get_field('add_payments',$projectId);

// get total of project based on subtotals of scopes
$projectTotal = get_field('total',$projectId);

$client_string = get_field('client','options');
$contractor_string = get_field('contractor','options');
$agent_string = get_field('agent','options');
$head_string = get_field('head_contractor','options');

$contractorAdjust = ( $projectTotal * 20 ) /100;
$contractorTotal = $projectTotal - $contractorAdjust;
$contractorTotal = round($contractorTotal,2); 
$ContractorTotal = number_format($contractorTotal, 2, '.', '');
/*
$t = go_set_default_selections(2433);
var_dump($t);
die;
*/
?>
<?php get_header(); ?>

<div class="page animsition">

	<div class="page-aside">
        <div class="page-aside-switch">
                <i class="icon wb-chevron-left" aria-hidden="true"></i>
                <i class="icon wb-chevron-right" aria-hidden="true"></i>
        </div>
        <div class="page-aside-inner">
                <div data-role="container">
                        <div data-role="content">
                                <section class="page-aside-section">
                 <ul class="nav nav-tabs nav-tabs-line" data-plugin="nav-tabs" role="tablist">
              		<li class="active" style="width:100%; text-align:center" role="presentation"><a data-toggle="tab" class="tasks" href="#tasks" aria-controls="tasks" role="tab">To-Do</a></li>
                </ul>
															<div class="tab-content scrollable margin-20">
					      	<div class="tab-pane" id="tasks" role="tabpanel">
									<?php include('views_v2/projectTasks.php'); ?>
		                </div>
																	</div>
                                </section>
                        </div>
                </div>
        </div>
</div>

	<div class="page-main">
		<div class="page-content">

			<div class="panel panel-bordered">
            <div class="panel-heading bg-dark">
							<div class="col-md-8">
								
							<h3 class="white updateTitle"><?php the_title(); ?></h3><br/>
							<div class="relative inline-block">
								<span class="label label-<?php echo $projectStatus->status_class; ?>"><?php echo $projectStatus->status_string; ?></span>
								</div>
								<div class="relative white inline-block margin-horizontal-30">
									<i class="icon wb-map"></i>&nbsp;&nbsp;<span class=""><?php echo $clientData->address; ?></span>
								</div>
								<div class="relative white inline-block margin-horizontal-30">
									<i class="icon wb-time"></i>&nbsp;&nbsp;<span class="updateTimeframe"><?php echo $projectTimeframe; ?></span>
									<div class="frontEndManage">
										<a class="btn btn-xs btn-outline btn-round btn-default btn-icon" data-toggle="modal" data-target="#manageTimeframe"><i class="icon white wb-pencil"></i></a>
									</div>
								</div>
							</div>
					<div class="pull-right">
            <div class="text-center">
              <a class="avatar avatar-50" href="javascript:void(0)">
                <img src="<?php echo $clientData->avatar; ?>" alt="">
              </a>
              <div class="text-center white">
                <div class="font-size-20"><?php echo $clientData->first_name; ?>&nbsp;<?php echo $clientData->last_name; ?></div>
								<span class="label label-danger"><?php echo $client_string; ?></span>
                <p class="margin-0 text-nowrap">
                  <span class="text-break"><?php echo $clientData->phone; ?></span>
                </p>
                <p class="margin-0 text-nowrap">
                  <span class="text-break"><?php echo $clientData->email; ?></span>
                </p>
                </p>
              </div>
          </div>
							</div>
			</div>

            <div class="panel-body">
				<div class="row">
											<?php include('views_v2/scope.php'); ?>
							</div>
				</div>
				<div class="panel-footer bg-grey-100">
					<div class="row">
									<div class="pull-right">
							 <a target="_blank" class="inline-block btn-danger btn btn-lg btn-outline" href="<?php bloginfo('url'); ?>/tcpdf/scope/work-order.php?project_id=<?php echo get_the_ID(); ?>" >View Work Order</a>
					</div>	
				</div>			
				</div>

          </div>
		
	
			<?php // project Scope Details ?>
			<div class="panel">
				<div class="panel-heading">
              		<h2 class="panel-title font-size-18">THE PROJECT</h2>
              		<div class="panel-actions">
                		<a class="panel-action icon wb-minus" data-toggle="panel-collapse" aria-hidden="true"></a>
              		</div>
            	</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">
																<h3>Project Notes</h3>
																<?php include('views_v2/projectNotes.php'); ?>
							<div class="margin-20">
							</div>
						<div class="col-md-12 bg-grey-100">
							<div class="padding-vertical-30">
								<div class="scopeDefaultMessage text-center">
									<h3>Scope details</h3>
									<p>Nothing to show. Select any scope from above to see it's details or to manage Options.</p>
								</div>
								<div id="showScopeResponse"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>	
				<?php // project Participants: Client, PL, PM ?>
			<div class="panel">
				<div class="panel-heading">
              		<h2 class="panel-title font-size-18">Crew</h2>
              		<div class="panel-actions">
                		<a class="panel-action icon wb-minus" data-toggle="panel-collapse" aria-hidden="true"></a>
              		</div>
            	</div>
				<div class="panel-body">
					<div class="row">

						<div class="col-md-12 padding-bottom-40">
							
										<?php // PL ?>
										<?php foreach($agentsArray as $agentId) :
											$agentData = go_userdata($agentId);
										?>
													<div class="col-md-4">
            <div class="widget-header text-center">
              <a class="avatar avatar-100" href="javascript:void(0)">
                <img src="<?php echo $agentData->avatar; ?>" alt="">
              </a>
              <div class="text-center">
                <div class="font-size-20 margin-bottom-15"><?php echo $agentData->first_name; ?>&nbsp;<?php echo $agentData->last_name; ?></div>
											<div class="frontEndManage" style="top:15px; right:10px;">
                                                <?php if(in_array($agentData->id,$currentUserContactsArray)) : ?>
                                                    <a style="cursor:default;" class="btn btn-xs btn-outline btn-round btn-default btn-icon margin-top-5 "><i class="icon wb-check-mini green-800 margin-horizontal-0"></i></a>
                                                <?php else : ?>
                                                    <a class="btn btn-xs btn-outline btn-round btn-default btn-icon margin-top-5 user_<?php echo $agentData->id; ?> addContact" data-user="<?php echo $agentData->id; ?>"><i class="icon wb-user-add margin-horizontal-0"></i></a>
                                                <?php endif; ?>
                                            </div>
								<span class="label label-success"><?php echo $agent_string; ?></span>
                <p class="margin-bottom-5 text-nowrap">
                <span class="text-break"><?php echo $agentData->phone; ?></span>
                </p>
                <p class="margin-bottom-5 text-nowrap">
                <span class="text-break"><?php echo $agentData->email; ?></span>
                </p>
                </p>
              </div>
            </div>
       
						</div>
												<?php endforeach; ?>
										<?php // *** END PL ?>
										<?php // PM ?>

										<?php foreach($contractorsArray as $contractorId) :
											$contractorData = go_userdata($contractorId);
										?>
						 <div class="col-md-4">
            <div class="widget-header text-center">
              <a class="avatar avatar-100" href="javascript:void(0)">
                <img src="<?php echo $contractorData->avatar; ?>" alt="">
              </a>
              <div class="text-center">
                <div class="font-size-20 margin-bottom-15"><?php echo $contractorData->first_name; ?>&nbsp;<?php echo $contractorData->last_name; ?></div>
								<div class="frontEndManage" style="top:15px; right:10px;">
                                    <?php if(in_array($contractorData->id,$currentUserContactsArray) || $contractorData->id == $currentUserId) : ?>
                                        <a style="cursor:default;" class="btn btn-xs btn-outline btn-round btn-default btn-icon margin-top-5 "><i class="icon wb-check-mini green-800 margin-horizontal-0"></i></a>
                                    <?php else : ?>
                                        <a class="btn btn-xs btn-outline btn-round btn-default btn-icon margin-top-5 user_<?php echo $contractorData->id; ?> addContact" data-user="<?php echo $contractorData->id; ?>"><i class="icon wb-user-add margin-horizontal-0"></i></a>
                                    <?php endif; ?>
                 </div>
								 <span class="label label-info"><?php echo $contractor_string; ?></span>
                <p class="margin-bottom-5 text-nowrap">
                  <span class="text-break"><?php echo $contractorData->phone; ?></span>
                </p>
                <p class="margin-bottom-5 text-nowrap">
                  <span class="text-break"><?php echo $contractorData->email; ?></span>
                </p>
                </p>
              </div>
            </div>

						</div>

										<?php endforeach; ?>
										<?php // *** END PM ?>

										<?php // show message if there are no PL or PM ?>
										<?php if( (count($contractorsArray) == 0) && (count($agentsArray) == 0) ) : ?>
											<?php $visible = 'display:block'; ?>
										<?php else : ?>
											<?php $visible = 'display:none'; ?>
										<?php endif; ?>
                                        <?php /*
										<p class="text-center noParticipants" style="<?php echo $visible; ?>">There is no Project Leaders or Contractors set yet.</p>
                                        */ ?>
										<?php // *** END show message if there are no PL or PM ?>



								</div>

						<?php // *** END projectPL, projectPM ?>

					</div>
				</div>
			</div>
		
			<div class="row">
				<div class="col-md-12">
					<?php // project Schedule ?>
					<div class="panel" id="schedule">
						<div class="panel-heading">
		              		<h2 class="panel-title font-size-18">SCHEDULE</h2>
		              		<div class="panel-actions">
		                		<a class="panel-action icon wb-minus" data-toggle="panel-collapse" aria-hidden="true"></a>
		              		</div>
		            	</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12">
									<?php include('views_v2/projectSchedule.php'); ?>
									<div id="manageSchedulesResponse"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<?php // project Agreement ?>
			<div class="panel is-collapse">
				<div class="panel-heading">
					<h2 class="panel-title font-size-18">TERMS</h2>
					<div class="panel-actions">
						<a class="panel-action icon wb-plus" data-toggle="panel-collapse" aria-hidden="true"></a>
					</div>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">
							<?php the_field('proposal','options'); ?>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
<?php //include('manage_v2/managePopupsHead.php'); ?>
<?php get_footer(); ?>

