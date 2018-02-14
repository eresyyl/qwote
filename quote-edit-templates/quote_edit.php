<?php
/*
Template Name: Scope Edit
*/
?>
<?php
$currentUserId = current_user_id();
$projectId = $_GET['projectId'];
$scopeId = $_GET['scopeId'];

// redirect to DASH if current user is contractor
if(is_contractor()) {
    wp_redirect(home_url() . "/dash");
    die;
}
// redirect to DASH if projectId or scopeId unset
if($projectId == '' || $scopeId == '') {
    wp_redirect(home_url() . "/dash");
    die;
}
// redirect to DASH if current user is client but he is not a client of project
$clientId = get_field('client_id',$projectId);
if($clientId[0] == NULL) {
        $clientId = $clientId['ID'];
}
else {
        $clientId = $clientId[0];
}
$clientData = go_userdata($clientId);
if(is_client()) {
    if($currentUserId != $clientId) {
        wp_redirect(home_url() . "/dash");
        die;
    }
}
// redirect to DASH if scopeID is invalid
$projectScopes = get_field('projectScopes',$projectId);
if(!in_array($scopeId,$projectScopes)) {
    wp_redirect(home_url() . "/dash");
    die;
}

// *** END OF checking
$client = go_userdata($client_id);
$scopeTemplate = get_field('scopeTemplate',$scopeId);
$scopeData = get_field('scopeData',$scopeId);
$scopeLevel = get_field('scopeLevel',$scopeId);
$scopeDataDecoded = base64_decode($scopeData);
$scopeDataArray = json_decode($scopeDataDecoded,true);
$scopeMargin = get_field('scopeMargin',$scopeId);

$scopeTitle = get_the_title($scopeId);
?>
<?php get_header(); ?>
<style>
label{
    display: inline-block;
}
label img{
    pointer-events: none;
}
</style>
<script src="<?php bloginfo('template_url'); ?>/vendor/jquery/jquery.js"></script>
<script src="<?php bloginfo('template_url'); ?>/quote-edit-templates/js/quote_edit.js"></script>
<!-- Page -->
<div class="page">
        <div class="page-content padding-30 container-fluid">


                <div class="page-header text-center">
                        <h1 class="page-title"><?php the_title(); ?></h1>
                        <p class="page-description">
                                <?php the_field('sub_title'); ?>
               
            
                <form id="editedScope">
                <input type="hidden" name="projectId" value="<?php echo $projectId; ?>">
                <input type="hidden" name="scopeId" value="<?php echo $scopeId; ?>">
                <input type="hidden" name="templateId" value="<?php echo $scopeTemplate; ?>">

                <div class="panel">
                        <div class="panel-body">

                          
                            <div class="row margin-bottom-40">
                                       </p>
                              <div class="col-md-6 col-md-offset-3">
                     <div class="widget widget-shadow">
            <div class="widget-header padding-30 bg-white">
              <a class="avatar avatar-100 img-bordered bg-white" href="javascript:void(0)">
							 <img src="<?php echo $clientData->avatar; ?>" alt="">
              </a>
              <div class="vertical-align text-truncate">
                <div class="vertical-align-middle">
											                <div class="font-size-20 margin-bottom-15"><?php echo $clientData->first_name; ?>&nbsp;<?php echo $clientData->last_name; ?></div>
																			<span class="label label-danger"><?php echo $client_string; ?></span>
																			<p class="margin-0 text-nowrap">
																				<span class="text-break"><?php echo $clientData->phone; ?></span>
																			</p>
																			<a class="preview btn btn-sm btn-default bg-blue-600 white" data-url="<?php bloginfo('url'); ?>/contact_preview?contact_id=<?php echo $clientId; ?>" data-toggle="slidePanel" data-original-title="See Profile" title="">View Profile</a>
                </div>
              </div>
            </div>
														
											        	</div>

                  </div>
                          
                              <div class="col-md-6 col-md-offset-3">
                                <?php if(is_headcontractor() || is_agent()) : ?>
            <div class="form-group">
              <h4>Margin</h4>
              <input class="form-control" type="number" name="scopeMargin" placeholder="Profit margin, %" data-min="-50" data-plugin='TouchSpin' data-step='1' data-decimals='0' data-boostat='5' data-maxboostedstep='10' data-postfix='%' value="<?php echo $scopeMargin; ?>">
            </div>
        <?php else : ?>
            <input class="form-control" type="hidden" name="scopeMargin" value="<?php echo $scopeMargin; ?>">
        <?php endif; ?>
                                
                              </div>
                            </div>

                             <div class="form-group">
                                    <h4>Project/Room Name</h4>
                                    <input class="form-control" type="text" name="projectName" placeholder="Scope Name" value="<?php echo $scopeDataArray['projectName']; ?>">
                                  </div>
                            <?php

                            if( have_rows('quote_fields',$scopeTemplate) ) {

                              while ( have_rows('quote_fields',$scopeTemplate) ) : the_row();

                                // checking if this template has Width and Height rows
                                if( get_row_layout() == 'width_and_length' ) {
                                  $thisValueWidth = null;
                                  $thisValueLength = null;
                                  $slug = null;
                                  $slug = get_sub_field('slug');
                                  echo "<div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>" . get_sub_field('title') . "</h4><div class='text-center'>" . get_sub_field('description') . "</div>";
                                  echo "<div class='row'><div class='col-md-6 col-md-offset-3'><div class='row'>";
                                  echo "<div class='col-md-6 text-center'><div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>Width</h4><div class='text-center'>";
                                  if(array_key_exists($slug . '_width',$scopeDataArray)) {
                                      $thisValueWidth = $scopeDataArray[$slug . '_width'];
                                  }
                                  if(array_key_exists($slug . '_length',$scopeDataArray)) {
                                      $thisValueLength = $scopeDataArray[$slug . '_length'];
                                  }
                                  echo "<input type='text' class='form-control input-lg' name='" . get_sub_field('slug') . "_width' data-plugin='TouchSpin' data-min='0' data-max='100' data-step='0.1' data-decimals='2' data-boostat='5' data-maxboostedstep='10' data-postfix='M' value='" . $thisValueWidth . "'>";
                                  echo "</div></div>";
                                  echo "<div class='col-md-6 text-center'><div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>Length</h4><div class='text-center'>";
                                  echo "<input type='text' class='form-control input-lg' name='" . get_sub_field('slug') . "_length' data-plugin='TouchSpin' data-min='0' data-max='100' data-step='0.1' data-decimals='2' data-boostat='5' data-maxboostedstep='10' data-postfix='M' value='" . $thisValueLength . "'>";
                                  echo "</div></div>";
                                  echo "</div></div></div><br/>";
                                }
															
															    if( get_row_layout() == 'price_and_area' ) {
                                  $thisValuePrice = null;
                                  $thisValueArea = null;
                                  $slug = null;
                                  $slug = get_sub_field('slug');
                                  echo "<div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>" . get_sub_field('title') . "</h4><div class='text-center'>" . get_sub_field('description') . "</div>";
                                  echo "<div class='row'><div class='col-md-6 col-md-offset-3'><div class='row'>";
                                  echo "<div class='col-md-6 text-center'><div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>Width</h4><div class='text-center'>";
                                  if(array_key_exists($slug . '_price',$scopeDataArray)) {
                                      $thisValuePrice = $scopeDataArray[$slug . '_price'];
                                  }
                                  if(array_key_exists($slug . '_area',$scopeDataArray)) {
                                      $thisValueArea = $scopeDataArray[$slug . '_area'];
                                  }
                                  echo "<input type='text' class='form-control input-lg' name='" . get_sub_field('slug') . "_price' data-plugin='TouchSpin' data-min='0' data-max='100' data-step='0.1' data-decimals='2' data-boostat='5' data-maxboostedstep='10' data-postfix='$' value='" . $thisValuePrice . "'>";
                                  echo "</div></div>";
                                  echo "<div class='col-md-6 text-center'><div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>Area</h4><div class='text-center'>";
                                  echo "<input type='text' class='form-control input-lg' name='" . get_sub_field('slug') . "_area' data-plugin='TouchSpin' data-min='0' data-max='100' data-step='0.1' data-decimals='2' data-boostat='5' data-maxboostedstep='10' data-postfix='M2' value='" . $thisValueArea . "'>";
                                  echo "</div></div>";
                                  echo "</div></div></div><br/>";
                                }
															
                              
                                // checking if this template has Width and height rows
                                if( get_row_layout() == 'width_and_height' ) {
                                  $thisValueWidth = null;
                                  $thisValueHeight = null;
                                  $slug = null;
                                  $slug = get_sub_field('slug');
                                  echo "<div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>" . get_sub_field('title') . "</h4><div class='text-center'>" . get_sub_field('description') . "</div>";
                                  echo "<div class='row'><div class='col-md-6 col-md-offset-3'><div class='row'>";
                                  echo "<div class='col-md-6 text-center'><div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>Length</h4><div class='text-center'>";
                                  if(array_key_exists($slug . '_width',$scopeDataArray)) {
                                      $thisValueWidth = $scopeDataArray[$slug . '_width'];
                                  }
                                  if(array_key_exists($slug . '_height',$scopeDataArray)) {
                                      $thisValueHeight = $scopeDataArray[$slug . '_height'];
                                  }
                                  echo "<input type='text' class='form-control input-lg' name='" . get_sub_field('slug') . "_width' data-plugin='TouchSpin' data-min='0' data-max='100' data-step='0.1' data-decimals='2' data-boostat='5' data-maxboostedstep='10' data-postfix='M' value='" . $thisValueWidth . "'>";
                                  echo "</div></div>";
                                  echo "<div class='col-md-6 text-center'><div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>Height</h4><div class='text-center'>";
                                  echo "<input type='text' class='form-control input-lg' name='" . get_sub_field('slug') . "_height' data-plugin='TouchSpin' data-min='0' data-max='100' data-step='0.1' data-decimals='2' data-boostat='5' data-maxboostedstep='10' data-postfix='M' value='" . $thisValueHeight . "'>";
                                  echo "</div></div>";
                                  echo "</div></div></div><br/>";
                                }

                                if( get_row_layout() == 'panel_title' ) {
                                  echo "<h3 class='text-center'>" . get_sub_field('title') . "</h3><div class='text-center'><p class='text-center'>" . get_sub_field('description') . "</p></div>";
                                }

                                      // checking if this template has Width and Height rows
                                if( get_row_layout() == 'length' ) {

                                    $thisValue = null;
                                    $slug = null;
                                    $slug = get_sub_field('slug');
                                    if(array_key_exists($slug ,$scopeDataArray)) {
                                        $thisValue = $scopeDataArray[$slug];
                                    }

                                  echo "<div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>" . get_sub_field('title') . "</h4><div class='text-center'>" . get_sub_field('description') . "</div>";
                                  echo "<div class='row'><div class='col-md-12'><div class='row'>";
                                  echo "<div class='col-md-6 col-md-offset-3 text-center'><div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>Height</h4><div class='form-group text-center'>";
                                  echo "<input type='text' class='form-control input-lg' name='" . get_sub_field('slug') . "' data-plugin='TouchSpin' data-min='0' data-max='100' data-step='0.1' data-decimals='2' data-boostat='5' data-maxboostedstep='10' data-postfix='M' value='" . $thisValue . "'>";
                                  echo "</div></div>";
                                  echo "</div></div></div>";
                                }

                                // checking if this template has Image radio or checkbox rows
                                if( get_row_layout() == 'fields' ) {
                                  echo "<style>input[type=number]::-webkit-inner-spin-button, input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0;  }</style>";
                                  $slug = get_sub_field('slug');
                                  $type = get_sub_field('type_of_fields');
                                  if($type == "Checkbox") { $type = 'checkbox'; $type_array = '[]'; }
                                  elseif($type == "Radio") { $type = 'radio'; $type_array = ''; }
                                  echo "<div id=". $slug . " class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>" . get_sub_field('title') . "</h4><div class='text-center'>" . get_sub_field('description') . "</div><div class='text-center'>";

                                  $temp = null;
                                  $temp = $scopeDataArray[$slug];

                                  $i=0;
                                  while(has_sub_field('fields')) :
                                    $qnt = get_sub_field('quantity');
                                    $value = get_sub_field('title');
                                    $value_string = get_sub_field('title');
                                    $value = preg_replace("/[^a-zA-Z0-9]/", "", $value);
                                                                  $tooltip = get_sub_field('tooltip');
                                                                  if($tooltip != '') {
                                                                          $tooltit_text = 'data-toggle="tooltip" data-placement="top" data-trigger="hover" data-original-title="' . $tooltip . '" title=""';
                                                                  }
                                                                  else {
                                                                       $tooltit_text = '';
                                                                  }

                                    $value = strtolower($value);


                                    // check if options selected
                                    $value_string_m = addslashes($value_string);
                                    if(is_array($temp) && in_array($value_string_m,$temp)) {
                                            $temp_selected = 'checked';
                                    }
                                    elseif($value_string_m == $temp) {
                                            $temp_selected = 'checked';
                                    }
                                    else {
                                           $temp_selected = '';
                                    }


                                    echo "<span style='position:relative'><label class='styled_in_ajax' " . $tooltit_text . ">";
                                    echo "<input class='chr' type='" . $type . "' title name='" . $slug . $type_array . "' value=\"" . $value_string . "\" " . $temp_selected . ">";
                                    echo "<img src=" . get_sub_field('image') . ">";
                                    echo "<span>" . get_sub_field('title') . "</span>";
                                    if($qnt == true) {
                                      $qnt_of_field = 0; $qnt_of_field = $scopeDataArray[$value];
                                      //echo "<input type='text' class='qnt form-control input-xs' name='" . $value . "' id='" . $value . "' data-plugin='TouchSpin' data-min='1' data-max='100' data-step='1' data-decimals='2' data-boostat='5' data-maxboostedstep='10' data-postfix='' value='1'>";
                                    echo "<input class='qnt form-control' type='number' name='" . $value . "' id='" . $value . "' min='1' step='1' value='". $qnt_of_field ."'>";
                                    echo "<div style='position: absolute; right: 4px; top: 126px;' class='adding'><a onclick='event.preventDefault(); inputAdd(\"" . $value . "\");' class='btn btn-xs btn-default btn-icon addInput'><i class='icon wb-plus margin-horizontal-0'></i></a></div>";
                                    echo "<div style='position: absolute; left: 4px; top: 126px;' class='removing'><a onclick='event.preventDefault(); inputRemove(\"" . $value . "\");' class='btn btn-xs btn-default btn-icon removeInput'><i class='icon wb-minus margin-horizontal-0'></i></a></div>";
                                  }
                                      echo "</label>";
                                    echo "</span>";
                                  $i++;
                                  endwhile;

                                  echo "</div>";
                                }
                              
    if(is_headcontractor() || is_agent()) {
     if( get_row_layout() == 'exclusions' ) {
                                  echo "<style>input[type=number]::-webkit-inner-spin-button, input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0;  }</style>";
                                  $slug = get_sub_field('slug');
                                  $type = get_sub_field('type_of_fields');
                                  if($type == "Checkbox") { $type = 'checkbox'; $type_array = '[]'; }
                                  elseif($type == "Radio") { $type = 'radio'; $type_array = ''; }
                                  echo "<div id=". $slug . " class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>" . get_sub_field('title') . "</h4><div class='text-center'>" . get_sub_field('description') . "</div><div class='text-center'>";

                                  $temp = null;
                                  $temp = $scopeDataArray[$slug];

                                  $i=0;
                                  while(has_sub_field('fields')) :
                                    $qnt = get_sub_field('quantity');
                                    $value = get_sub_field('title');
                                    $value_string = get_sub_field('title');
                                    $value = preg_replace("/[^a-zA-Z0-9]/", "", $value);
                                                                  $tooltip = get_sub_field('tooltip');
                                                                  if($tooltip != '') {
                                                                          $tooltit_text = 'data-toggle="tooltip" data-placement="top" data-trigger="hover" data-original-title="' . $tooltip . '" title=""';
                                                                  }
                                                                  else {
                                                                       $tooltit_text = '';
                                                                  }

                                    $value = strtolower($value);


                                    // check if options selected
                                    $value_string_m = addslashes($value_string);
                                    if(is_array($temp) && in_array($value_string_m,$temp)) {
                                            $temp_selected = 'checked';
                                    }
                                    elseif($value_string_m == $temp) {
                                            $temp_selected = 'checked';
                                    }
                                    else {
                                           $temp_selected = '';
                                    }


                                    echo "<span style='position:relative'><label class='styled_in_ajax' " . $tooltit_text . ">";
                                    echo "<input class='chr' type='" . $type . "' title name='" . $slug . $type_array . "' value=\"" . $value_string . "\" " . $temp_selected . ">";
                                    echo "<img src=" . get_sub_field('image') . ">";
                                    echo "<span>" . get_sub_field('title') . "</span>";
                                    if($qnt == true) {
                                      $qnt_of_field = 0; $qnt_of_field = $scopeDataArray[$value];
                                      //echo "<input type='text' class='qnt form-control input-xs' name='" . $value . "' id='" . $value . "' data-plugin='TouchSpin' data-min='1' data-max='100' data-step='1' data-decimals='2' data-boostat='5' data-maxboostedstep='10' data-postfix='' value='1'>";
                                    echo "<input class='qnt form-control' type='number' name='" . $value . "' id='" . $value . "' min='1' step='1' value='". $qnt_of_field ."'>";
                                    echo "<div style='position: absolute; right: 4px; top: 126px;' class='adding'><a onclick='event.preventDefault(); inputAdd(\"" . $value . "\");' class='btn btn-xs btn-default btn-icon addInput'><i class='icon wb-plus margin-horizontal-0'></i></a></div>";
                                    echo "<div style='position: absolute; left: 4px; top: 126px;' class='removing'><a onclick='event.preventDefault(); inputRemove(\"" . $value . "\");' class='btn btn-xs btn-default btn-icon removeInput'><i class='icon wb-minus margin-horizontal-0'></i></a></div>";
                                  }
                                      echo "</label>";
                                    echo "</span>";
                                  $i++;
                                  endwhile;

                                  echo "</div>";
                                }
                              
    }

                              endwhile;

                            }

                            ?>

                            <div id="saveScopeResponse" class="margin-top-40"></div>

                            <div class="row margin-bottom-40">
                              <div class="col-md-12">
                                <a class="btn btn-danger btn-lg margin-top-40 margin-horizontal-10 saveScope">Update Quote</a>
                              </div>
                            </div>

                        </div>
                </div>

                </form>



        </div>
</div>
<!-- End Page -->

<?php get_footer(); ?>
