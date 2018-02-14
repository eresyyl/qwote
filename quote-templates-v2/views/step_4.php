<?php
$projectId = $_POST['projectId'];
$projectPrice = $_POST['projectPrice'];
$time = $projectPrice / 850;
$time = number_format($time, 1, '.', '');
?>


<div style="position:relative;">
	  
	           <div class="row font-size-30 blue-grey-800">
							 Your Price is <div class="inline red-800">$<?php echo $projectPrice; ?></div> 
						 </div>
							<div class="container padding-30">
    							<div class="panel panel-bordered">
           <div class="panel-footer bg-grey-100">
						 <div class="row">
							 <div class="btn-group btn-group-lg btn-group-justified">
									  	<a href="<?php bloginfo('url'); ?>/?p=<?php echo $projectId; ?>" class="btn btn-primary">View Project</a>
											<a href="<?php bloginfo('url'); ?>/add_quote?projectId=<?php echo $projectId; ?>" class="btn btn-primary btn-raised">Add Scope</a>
									</div>
						 </div>
				</div>

            <div class="panel-body">
				<div class="row">
								<div class="font-size-20 text-left margin-bottom-30 blue-grey-800"><strong>Remember to check your junk, we've sent you login details to manage the job.</strong> We'll be in touch to confirm the details and book in a start date. In the meantime you can click the "View Project" button above to chat with your project manager.</div>
				</div>
							
	<?php $projectScope = get_field('projectScopes',$projectId);

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

	$message .= '</div>';
	$editor .= $message;

} ; ?>
							<div class="text-left">
								<div class="font-size-20 margin-bottom-30 blue-grey-800">Quote Summary</div>
					<?php echo $editor ;?>
							</div>
							
				</div>
				
								<div class="panel-footer bg-grey-100">
													<div class="row">
									  	 <div class="btn-group btn-group-lg btn-group-justified">
									  		<a href="<?php bloginfo('url'); ?>/?p=<?php echo $projectId; ?>" class="btn btn-primary">View Project</a>
											<a href="<?php bloginfo('url'); ?>/add_quote?projectId=<?php echo $projectId; ?>" class="btn btn-primary btn-raised">Add Scope</a>
							</div>		</div>
		</div>

								</div>
