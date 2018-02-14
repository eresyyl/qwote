<?php
$templateId = $_POST['templateId']; $templateId = intval($templateId);
$projectId = $_POST['projectId']; $projectId = intval($projectId);
$projectName = $_POST['projectName'];
$projectLevel = $_POST['projectLevel'];
$agentToken = $_POST['agentToken'];
?>


<div class="row text-center">

  <form id="projectDetailsForm" method="POST" action="<?php bloginfo('url'); ?>/add_quote/step3">
  <input type="hidden" name="templateId" value="<?php echo $templateId; ?>">
  <input type="hidden" name="projectId" value="<?php echo $projectId; ?>">
  <input type="hidden" name="agentToken" value="<?php echo $agentToken; ?>">

  <div style="visibility: none" class="row margin-bottom-40">
    <div class="col-md-6 col-md-offset-3">

        <?php if(is_headcontractor()) : ?>
            <div class="form-group">
              <h4>Margin</h4>
              <input class="form-control" type="number" name="scopeMargin" placeholder="Profit margin, %" data-min="-50" data-plugin='TouchSpin' data-max='100' data-step='1' data-decimals='0' data-boostat='5' data-maxboostedstep='10' data-postfix='%' value="0">
            </div>
        <?php else : ?>
            <input class="form-control" type="hidden" name="scopeMargin" value="0">
        <?php endif; ?>
        
           <div class="row margin-bottom-40">
                              <div class="col-md-6 col-md-offset-3">

                                  
                               <div class="form-group">
        <h4>Project/Room name</h4>
        <?php
        $templateName = get_the_title($templateId);
        if($projectName != '') {
          $projectName = $projectName;
        }
        else {
          $projectName = get_the_title($templateId);
        }
        ?>
        <input class="form-control" type="text" name="projectName" placeholder="<?php echo $templateName; ?> name..." value="<?php echo $projectName; ?> Quote">
      </div>

                              </div>
                            </div>


    </div>
  </div>

  <?php

  if( have_rows('quote_fields',$templateId) ) {

    while ( have_rows('quote_fields',$templateId) ) : the_row();

      // checking if this template has Width and Height rows
      if( get_row_layout() == 'width_and_length' ) {
        echo "<div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>" . get_sub_field('title') . "</h4><div class='text-center'>" . get_sub_field('description') . "</div>";
        echo "<div class='row'><div class='col-md-6 col-md-offset-3'><div class='row'>";
        echo "<div class='col-md-6 text-center'><div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>Width</h4><div class='text-center'>";
        echo "<input type='number' class='form-control input-lg' name='" . get_sub_field('slug') . "_width' data-plugin='TouchSpin' data-min='0' data-max='100' data-step='0.1' data-decimals='2' data-boostat='5' data-maxboostedstep='10' data-postfix='M' value='1'>";
        echo "</div></div>";
        echo "<div class='col-md-6 text-center'><div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>Length</h4><div class='text-center'>";
        echo "<input type='number' class='form-control input-lg' name='" . get_sub_field('slug') . "_length' data-plugin='TouchSpin' data-min='0' data-max='100' data-step='0.1' data-decimals='2' data-boostat='5' data-maxboostedstep='10' data-postfix='M' value='1'>";
        echo "</div></div>";
        echo "</div></div></div><br/>";
      }
    
      if( get_row_layout() == 'width_and_height' ) {
        echo "<div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>" . get_sub_field('title') . "</h4><div class='text-center'>" . get_sub_field('description') . "</div>";
        echo "<div class='row'><div class='col-md-6 col-md-offset-3'><div class='row'>";
        echo "<div class='col-md-6 text-center'><div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>Length</h4><div class='text-center'>";
        echo "<input type='number' class='form-control input-lg' name='" . get_sub_field('slug') . "_width' data-plugin='TouchSpin' data-min='0' data-max='100' data-step='0.1' data-decimals='2' data-boostat='5' data-maxboostedstep='10' data-postfix='M' value='1'>";
        echo "</div></div>";
        echo "<div class='col-md-6 text-center'><div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>Height</h4><div class='text-center'>";
        echo "<input type='number' class='form-control input-lg' name='" . get_sub_field('slug') . "_height' data-plugin='TouchSpin' data-min='0' data-max='100' data-step='0.1' data-decimals='2' data-boostat='5' data-maxboostedstep='10' data-postfix='M' value='2.4'>";
        echo "</div></div>";
        echo "</div></div></div><br/>";
      }

     if( get_row_layout() == 'price_and_area' ) {
        echo "<div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>" . get_sub_field('title') . "</h4><div class='text-center'>" . get_sub_field('description') . "</div>";
        echo "<div class='row'><div class='col-md-6 col-md-offset-3'><div class='row'>";
        echo "<div class='col-md-6 text-center'><div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>Price (per m2)</h4><div class='text-center'>";
        echo "<input type='number' class='form-control input-lg' name='" . get_sub_field('slug') . "_price' data-plugin='TouchSpin' data-min='0' data-step='0.1' data-decimals='2' data-boostat='5' data-maxboostedstep='10' data-postfix='$' value='30'>";
        echo "</div></div>";
        echo "<div class='col-md-6 text-center'><div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>Area (m2)</h4><div class='text-center'>";
        echo "<input type='number' class='form-control input-lg' name='" . get_sub_field('slug') . "_area' data-plugin='TouchSpin' data-min='0' data-step='0.1' data-decimals='2' data-boostat='5' data-maxboostedstep='10' data-postfix='M2' value='1'>";
        echo "</div></div>";
        echo "</div></div></div><br/>";
      }
    
      if( get_row_layout() == 'panel_title' ) {
        echo "<h3 class='text-center'>" . get_sub_field('title') . "</h3><div class='text-center'><p class='text-center'>" . get_sub_field('description') . "</p></div>";
      }

            // checking if this template has Width and Height rows
      if( get_row_layout() == 'length' ) {
        echo "<div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>" . get_sub_field('title') . "</h4><div class='text-center'>" . get_sub_field('description') . "</div>";
        echo "<div class='row'><div class='col-md-12'><div class='row'>";
        echo "<div class='col-md-6 col-md-offset-3 text-center'><div class='example-wrap margin-sm-0'></div><div class='form-group text-center'>";
        echo "<input type='number' class='form-control input-lg' name='" . get_sub_field('slug') . "' data-plugin='TouchSpin' data-min='0' data-max='100' data-step='0.1' data-decimals='2' data-boostat='5' data-maxboostedstep='10' data-postfix='M' value='2.4'>";
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
          echo "<span style='position:relative'><label class='styled_in_ajax' " . $tooltit_text . ">";
          echo "<input class='chr' type='" . $type . "' title name='" . $slug . $type_array . "' value=\"" . $value_string . "\">";
          echo "<img src=" . get_sub_field('image') . ">";
          echo "<span>" . get_sub_field('title') . "</span>";
          if($qnt == true) {
            //echo "<input type='text' class='qnt form-control input-xs' name='" . $value . "' id='" . $value . "' data-plugin='TouchSpin' data-min='1' data-max='100' data-step='1' data-decimals='2' data-boostat='5' data-maxboostedstep='10' data-postfix='' value='1'>";
            echo "<input class='qnt form-control' type='number' name='" . $value . "' id='" . $value . "' min='1' step='1' value='1'>";
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
          echo "<span style='position:relative'><label class='styled_in_ajax' " . $tooltit_text . ">";
          echo "<input class='chr' type='" . $type . "' title name='" . $slug . $type_array . "' value=\"" . $value_string . "\">";
          echo "<img src=" . get_sub_field('image') . ">";
          echo "<span>" . get_sub_field('title') . "</span>";
          if($qnt == true) {
            //echo "<input type='text' class='qnt form-control input-xs' name='" . $value . "' id='" . $value . "' data-plugin='TouchSpin' data-min='1' data-max='100' data-step='1' data-decimals='2' data-boostat='5' data-maxboostedstep='10' data-postfix='' value='1'>";
            echo "<input class='qnt' type='number' name='" . $value . "' id='" . $value . "' min='1' step='1' value='1'>";
            echo "<div style='position:absolute; right:10px; top:74px;' class='adding'><a onclick='event.preventDefault(); inputAdd(\"" . $value . "\");' class='btn btn-xs btn-round btn-success btn-icon addInput'><i class='icon wb-plus margin-horizontal-0'></i></a></div>";
            echo "<div style='position:absolute; right:35px; top:74px;' class='removing'><a onclick='event.preventDefault(); inputRemove(\"" . $value . "\");' class='btn btn-xs btn-round btn-danger btn-icon removeInput'><i class='icon wb-minus margin-horizontal-0'></i></a></div>";
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
  </form>

</div>

<div class="row margin-bottom-40">
  <div class="col-md-12">
    <a class='btn btn-default btn-sm margin-top-40 margin-horizontal-10' data-target="#resetProject" data-toggle="modal">back</a>
    <a class='btn btn-danger btn-lg margin-top-40 margin-horizontal-10 gotoStep3'>Next Step</a>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="resetProject" aria-hidden="true" aria-labelledby="resetProject"
role="dialog" tabindex="-1">
  <div class="modal-dialog modal-center">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title">Are you sure?</h4>
      </div>
      <div class="modal-body">
        <p class="text-center">All progress will be lost! Are you sure you want to restart?</p>
      </div>
      <div class="modal-footer text-center">
        <button type="button" data-project="<?php echo $projectId; ?>" class="btn btn-danger resetProject">Yes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>
<!-- End Modal -->
