<?php
global $need_starrating;

$need_starrating = array(
	'styles' => true,
	'scripts' => true
);
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

// set client approvement based on project status
if($projectStatus->status == 'live' || $projectStatus->status == 'completed') {
	$clientApprove = true;
}
else {
	$clientApprove = false;
}

// get total of project based on subtotals of scopes
$projectTotal = get_field('total',$projectId);

$client_string = get_field('client','options');
$contractor_string = get_field('contractor','options');
$agent_string = get_field('agent','options');
$head_string = get_field('head_contractor','options');

/*
$t = go_set_default_selections(2433);
var_dump($t);
die;
*/
?>
<?php get_header(); ?>

<div class="page container">

	<div class="page-main">
		<div class="page-content bg-white">
					<?php include('views_v2/projectReview.php'); ?>
			
					<?php /*
						*** NOT DONE!!! Need to make AJAX function
					*/ ?>
					<?php // Completed by Client (show only when projectStatus == live) ?>
					<?php if($projectStatus->status == 'live') : ?>
					<div class="row margin-bottom-40 text-center">
						<div class="col-md-12">
							<div class="margin-bottom-20 font-size-18" style="color:#37474f;">Mark Project as Completed?</div>
							<div id="projectCompletingResponse"></div>
							<a class="btn btn-lg btn-success margin-horizontal-5 projectComplete" data-project='<?php echo $projectId; ?>' data-user='<?php echo $currentUserId; ?>'>Complete</a>
						</div>
					</div>
					<?php endif; ?>
					<?php /*
						*** NOT DONE!!! Need to make AJAX function
					*/ ?>

				
			
                                <ul class="nav nav-tabs nav-tabs-line" data-plugin="nav-tabs" role="tablist">
              		<li class="active" style="width:50%; text-align:center" role="presentation"><a class="quote" data-toggle="tab" href="#quote" aria-controls="quote" role="tab">Quote</a></li>
              		<li style="width:50%; text-align:center" role="presentation"><a data-toggle="tab" class="activity" href="#activity" aria-controls="activity" role="tab">Activity</a></li>
                  <li class="hidden" style="width:25%; text-align:center" role="presentation"><a class="payments" data-toggle="tab" href="#payments" aria-controls="payments" role="tab">Payments</a></li>
              		<li class="hidden" style="width:25%; text-align:center" role="presentation"><a data-toggle="tab" class="schedule" href="#schedule" aria-controls="schedule" role="tab">Schedule</a></li>
                </ul>
										<div class="tab-content scrollable">
                		<div class="tab-pane active" id="quote" role="tabpanel">
         <div class="panel panel-bordered">
            <div class="padding-20 bg-grey-100">
					<div class="row">
					<div class="col-md-4">
						<div class="relative font-size-30 inline-block">
								<span class="label label-<?php echo $projectStatus->status_class; ?>"><?php echo $projectStatus->status_string; ?></span>
								</div>
						</div>	
				 <div class="pull-right">
					<?php // Approval by Cltient (show only when projectStatus == pending) ?>
					<?php if($clientApprove != true && $projectStatus->status == 'quote' || $projectStatus->status == 'pending') : ?>
					
							<div id="projectAcceptingResponse"></div>
							<a class="btn btn-lg inline-block btn-success margin-horizontal-5 projectAccept" data-toggle="tooltip" data-placement="left" data-trigger="hover" data-original-title="Happy with the instant quote? We'll send your project to a service provider partner" title="" data-project='<?php echo $projectId; ?>' data-user='<?php echo $currentUserId; ?>'>Proceed</a>
								<a href="<?php bloginfo('url'); ?>/add_quote?projectId=<?php echo $projectId; ?>" class="inline-block btn btn-lg btn-outline btn-primary" data-toggle="tooltip" data-placement="right" data-trigger="hover" data-original-title="Add another room or service to this project" title="">Add Scope</a>
					<?php endif; ?>

						</div>	
				</div>			
				</div>

							<div class="col-md-8">
								
							<div class="font-size-30 blue-grey-700 inline-block updateTitle"><?php the_title(); ?>
									</div><br/>
								<div class="font-size-20 inline-block blue-grey-500">
									<i class="icon wb-time"></i>&nbsp;&nbsp;<span class="updateTimeframe"><?php echo $projectTimeframe; ?></span>
								</div><br/>
								<br/>
						<div class="font-size-40 red-700">
							Grand Total: $<?php echo $projectTotal; ?>
							</h1>
							</div>
							<div class="row">
								 <?php include('views_v2/projectNotes.php'); ?>
							</div>
	            </div>
	
					<div class="col-md-4">
						
						<div class="row">
                        <div class="col-md-12">
                                <div class="widget widget-shadow">
                                        <div class="widget-header white bg-red-600 padding-30 clearfix">
                                                <a class="avatar avatar-100 pull-left img-bordered margin-right-20" href="javascript:void(0)">
                                                        <img src="<?php echo $clientData->avatar; ?>" alt="">
                                                </a>
                                                <div class="pull-left relative">
                                                        <div class="font-size-20 margin-bottom-15 newNames"><?php echo $clientData->first_name; ?>&nbsp;<?php echo $clientData->last_name; ?></div>
                                                        <p class="margin-bottom-5 text-nowrap"><i class="icon wb-envelope margin-right-10" aria-hidden="true"></i>
                                                                <span class="text-break"><?php echo $clientData->email; ?></span>
                                                        </p>
                                                        <p class="margin-bottom-5 text-nowrap"><i class="fa fa-phone margin-right-10" aria-hidden="true"></i>
                                                                <span class="text-break newPhone"><?php echo $clientData->phone; ?></span>
                                                        </p>
                                                        <p class="margin-bottom-5 text-nowrap"><i class="icon wb-map margin-right-10" aria-hidden="true"></i>
                                                                <span class="text-break newAddress"><?php echo $clientData->address; ?></span>
                                                        </p>
																	
																									                                                       

                                                </div>
                                        </div>
                                      
                                </div>

                        </div>
                </div>

          
							</div>
					 
					 	<div class="row padding-30">
														
	<?php $projectScope = get_field('projectScopes',$project_id);

$arrayNames = array();
foreach($projectScope as $pS) {

	$scopeId = $pS;

	$scopeData = get_field('scopeData',$scopeId);
	$scopeDataDecoded = base64_decode($scopeData);
	$scopeDataArray = json_decode($scopeDataDecoded,true);
	$scopeLevel = get_field('scopeLevel',$scopeId);
	$scopeLevel = get_term( $scopeLevel, 'selection_level' );
	$scopeLevel = $scopeLevel->name;
  $scopePriceTemp = get_field('scopePrice',$scopeId);
  $scopeAdjustment = get_field('totalAdjustment',$scopeId);
  $scopePrice = $scopePriceTemp + $scopeAdjustment;
	$scopeTemplateId = get_field('scopeTemplate',$scopeId);
	$scopeTemplateFields = get_field('quote_fields',$scopeTemplateId);

	$scopeDetails = go_scope_details_v2($scopeTemplateId,$scopeId);

	$message = '<div class="margin-top-20">';
	$message .= '<div class="font-size-20 blue-grey-700">' . $scopeDataArray["projectName"] . '</div>';
	$message .= '<div class="font-size-20 red-800">Sub Total: $' . $scopePrice . '</div></div>';
	foreach($scopeDetails as $sD) {

	$valueKeyFirst = $sD['section_title'];
	$valueKeyFirst = preg_replace("/[^a-zA-Z]/", "", $valueKeyFirst);
	$valueKeyFirst = strtolower($valueKeyFirst);

	  $message .= '<div>';
	  $message .= '<div class="font-size-20 margin-0 blue-grey-700"><b>' . $sD['section_title'] . '</b></div>';
	  foreach($sD['section_values'] as $value) {

		if($value == NULL) {
			$message .= 'N/A';
		}
		else {
		  $message .= '<p class="blue-grey-500">' . $value . '</p>';
		  $cleanValue = explode(' x', $value);
		  $cleanValue = $cleanValue[0];
		  $valueKeyLast = preg_replace("/[^a-zA-Z]/", "", $cleanValue);
	  	  $valueKeyLast = strtolower($valueKeyLast);
		  $valueKey = $valueKeyFirst . '_' . $valueKeyLast;
		  $arrayNames[$valueKey] = $sD['section_title'] . ': ' . $value;

		  // looking for description
		  $count = count($scopeTemplateFields);
		  $i=1;
		  while($i <= $count) {
				  if($scopeTemplateFields[$i]['title'] == $sD['section_title']) {
						  foreach($scopeTemplateFields[$i]['fields'] as $field) {
								  if($field['title'] == $cleanValue) {
										  if($field['description'] != '') {
											  	$desc = $field['description'];
													 $desc = strip_tags($desc);
												  $message .= "<p class='margin-0 blue-grey'>(" . $desc . ")</p><br /> ";
										  }
										  else {
												  $message .= "";
										  }

								  }
						  }
				  }
				  $i++;
		  }

		}
	  }
	  $message .= '</div>';
	}

	$editor .= $message;

} ; ?>
							<div class="col-md-12 text-left">
								<div class="font-size-30 margin-bottom-30 blue-grey-800">Quote Summary</div>
											<div class="row">
												<?php include('views_v2/scope.php'); ?>
												<div id="showScopeResponse"></div>							</div>
<div class="row">
					<?php echo $editor ;?>
					<div class="font-size-30 pull-right red-700">
							Grand Total: $<?php echo $projectTotal; ?>
							</h1>
							</div>
								</div>
							</div>
			
											</div>
		</div>
	
																		

			<?php // project Agreement ?>
			<div class="panel hidden is-collapse">
				<div class="panel-heading">
					<h2 class="panel-title font-size-18">TERMS & CONDITIONS</h2>
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
		 <div class="panel-heading bg-grey-100">
					<div class="row">
					<div class="col-md-4">
						<div class="relative font-size-30 inline-block">
								<span class="label label-<?php echo $projectStatus->status_class; ?>"><?php echo $projectStatus->status_string; ?></span>
								</div>
						</div>	
				 <div class="pull-right">
					<?php // Approval by Cltient (show only when projectStatus == pending) ?>
					<?php if($clientApprove != true && $projectStatus->status == 'quote' || $projectStatus->status == 'pending') : ?>
					
							<div id="projectAcceptingResponse"></div>
							<a class="btn btn-lg btn-success margin-horizontal-5 projectAccept" data-project='<?php echo $projectId; ?>' data-user='<?php echo $currentUserId; ?>'>Proceed</a>
							
					<?php endif; ?>	
           </div>	
				</div>			
				</div>
											
										
		</div>
					      	  <div class="tab-pane" id="activity" role="tabpanel">
		<div class="col-md-6">
				<div class="panel-heading">
				        <div class="font-size-20 blue-grey-700">PEOPLE</div>
              		<div class="panel-actions">
              		</div>
            	</div>
					<div class="row">

						<div class="padding-bottom-40">

										<?php // PL ?>
										<?php
										$projectAgentLead = get_field('plMain',$projectId);
										if($projectAgentLead['ID']) {
											$projectAgentLead = $projectAgentLead['ID'];
										}
										else {
											$projectAgentLead = $projectAgentLead[0];
										}
										foreach($agentsArray as $agentId) :
											$agentData = go_userdata($agentId);
											if($agentId == $projectAgentLead) {
												$agentLead = true;
											}
											else {
												$agentLead = false;
											}
										?>
<div class="row">
	
													<div class="col-md-12">
											                                         <div class="widget widget-shadow">
                                        <div class="widget-header white bg-blue-600 padding-30 clearfix">
																									<span class="label label-white">Manager</span>
                                                <a class="avatar avatar-100 pull-left img-bordered margin-right-20" href="javascript:void(0)">
                                                        <img src="<?php echo $agentData->avatar; ?>" alt="">
                                                </a>
                                                <div class="pull-left relative">
                                                      <div class="font-size-20 margin-bottom-15 newNames"><?php echo $agentData->first_name; ?>&nbsp;<?php echo $agentData->last_name; ?></div>
                                                  <p class="margin-bottom-5 text-nowrap"><i class="icon fa-bullhorn margin-right-10" aria-hidden="true"></i>
                                                                <span class="text-break"><?php the_field('business_name','user_' . $agentId); ?></span>
                                                        </p>      
																									<p class="margin-bottom-5 text-nowrap"><i class="icon wb-envelope margin-right-10" aria-hidden="true"></i>
                                                                <span class="text-break"><?php echo $agentData->email; ?></span>
                                                        </p>
                                                        <p class="margin-bottom-5 text-nowrap"><i class="fa fa-phone margin-right-10" aria-hidden="true"></i>
                                                                <span class="text-break newPhone"><?php echo $agentData->phone; ?></span>
                                                        </p>
                                                    
                                                </div>
                                        </div>
                                      
                                </div>

                       
                </div>

											          </div>

												<?php endforeach; ?>
										<?php // *** END PL ?>
										<?php // PM ?>

										<?php foreach($contractorsArray as $contractorId) :
											$contractorData = go_userdata($contractorId);
										?>
 <div class="row">
											
                          <div class="col-md-12">
                                <div class="widget widget-shadow">
                                        <div class="widget-header white bg-green-600 padding-30 clearfix">
																													<span class="label label-white">Tradesperson</span>
                                                <a class="avatar avatar-100 pull-left img-bordered margin-right-20" href="javascript:void(0)">
                                                        <img src="<?php echo $contractorData->avatar; ?>" alt="">
                                                </a>
                                                <div class="pull-left relative">
                                                      <div class="font-size-20 margin-bottom-15 newNames"><?php echo $contractorData->first_name; ?>&nbsp;<?php echo $contractorData->last_name; ?></div>
                                                        	<p class="margin-bottom-5 text-nowrap"><i class="icon fa-bullhorn margin-right-10" aria-hidden="true"></i>
                                                                <span class="text-break"><?php the_field('business_name','user_' . $contractorId); ?></span>
                                                        </p>  
																									<p class="margin-bottom-5 text-nowrap"><i class="icon fa-cogs margin-right-10" aria-hidden="true"></i>
                                                                <span class="text-break"><?php the_field('hi_pages','user_' . $contractorId); ?></span>
                                                        </p>
																									    <p class="margin-bottom-5 text-nowrap"><i class="icon wb-envelope margin-right-10" aria-hidden="true"></i>
                                                                <span class="text-break"><?php echo $contractorData->email; ?></span>
                                                        </p>
                                                        <p class="margin-bottom-5 text-nowrap"><i class="fa fa-phone margin-right-10" aria-hidden="true"></i>
                                                                <span class="text-break newPhone"><?php echo $contractorData->phone; ?></span>
                                                        </p>
                                                     
                                                </div>
                                        </div>
                                      
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





						<?php // *** END projectPL, projectPM ?>

					</div>
				</div>
			
     </div>

			<?php // project Messages ?>
			<div class="col-md-6" id="messages">
								<div class="panel-heading">

									<div class="font-size-20 blue-grey-700">MESSAGES</div></div>
						<?php include('views_v2/messages.php'); ?>
            	</div>
					<div class="row">	
						<div class="col-md-12">
				<div class="col-md-6">      
									<div class="panel-heading">
										<div class="font-size-20 blue-grey-700">UPLOADS</div></div>
							<?php include('views_v2/uploads.php'); ?>
								</div>
       <div class="col-md-6">
				 				<div class="panel-heading">
									<div class="font-size-20 blue-grey-700">NOTIFICATIONS</div></div>
                 	<?php include('views_v2/activity.php'); ?>
				</div>
										</div>	
										</div>
											<?php // project Participants: Client, PL, PM ?>
			<style>
				.makeLead {
					cursor:pointer;
				}
				.alreadyLead {
					cursor:default;
				}
			</style>
	

											</div>
										<div class="tab-pane" id="payments" role="tabpanel">
			
												<?php // project Payments and Variations ?>
			<div class="panel">
				<div class="panel-heading">
              		<h2 class="panel-title font-size-18">PAYMENTS</h2>
              		<div class="panel-actions">
                		<a class="panel-action icon wb-minus" data-toggle="panel-collapse" aria-hidden="true"></a>
              		</div>
            	</div>
				<ul class="nav nav-tabs nav-tabs-line" data-plugin="nav-tabs" role="tablist">
              		<li class="active" style="width:50%; text-align:center" role="presentation"><a class="paymentsTabClick" data-toggle="tab" href="#projectPayments" aria-controls="projectPayments" role="tab">Payments</a></li>
              		<li style="width:50%; text-align:center" role="presentation"><a data-toggle="tab" class="variationsTabClick" href="#projectVariations" aria-controls="projectVariations" role="tab">Variations</a></li>
                </ul>
				<div class="panel-body">
					<div class="tab-content">
                		<div class="tab-pane active" id="projectPayments" role="tabpanel">
		                	<?php include('views_v2/projectPayments.php'); ?>
		                </div>
						<div class="tab-pane" id="projectVariations" role="tabpanel">
                            <?php include('views_v2/projectVariations.php'); ?>
		                </div>
					</div>
				</div>
			</div>
												
		                </div>
					      	  <div class="tab-pane" id="schedule" role="tabpanel">
										
											
		<div class="panel" id="schedule">
			<div class="row">
				<div class="col-md-12">
					<?php // project Schedule ?>

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

		                </div>
                  	</div>
		
				


		</div>
	</div>
</div>
<?php include('manage_v2/managePopupsHead.php'); ?>
<?php get_footer(); ?>
