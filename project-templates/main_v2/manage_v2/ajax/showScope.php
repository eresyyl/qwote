<?php
require_once("../../../../../../../wp-load.php");
if($_POST && $_POST['projectId']) {

        $projectId = $_POST['projectId'];
        $scopeId = $_POST['scopeId'];

        $scopeSelections = get_field('scopeSelections',$scopeId);
        $scopeSelections = base64_decode($scopeSelections);
        $scopeSelections = json_decode($scopeSelections,true);

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

        $scopeDetails = go_scope_details_v2($scopeTemplateId,$scopeId);

        $message = '<div class="margin-top-20">';
        $message .= '<h3 class="text-center">' . $scopeDataArray["projectName"] . '</h3><br/>';
        $message .= '<dl class="dl-horizontal scope_detailes_list margin-top-40 font-size-16">';
        foreach($scopeDetails as $sD) {
          // this if-else for hiding empty ositions of quote. Before this if-else it was showing Undefinite string
          if(count($sD['section_values']) == 1 && $sD['section_values'][0] == NULL) {
          }
          else {
            $message .= '<dt class="text-left" style="padding:5px 0;">';
            $message .= $sD['section_title'];
            $message .= '</dt>';
            $message .= '<dd style="padding:5px 0;">';
            foreach($sD['section_values'] as $value) {
              if($value == NULL) {
                  $message .= '<span class="label label-default bg-grey-100 margin-right-10 margin-bottom-10">Undefined</span>';
              }
              else {
                // making var for selections search
                $radioFirstName = preg_replace("/[^a-zA-Z0-9]/", "", $sD['section_title']);
                $radioFirstName = strtolower($radioFirstName);
                $cleanValue = explode(' x', $value);
                $cleanValue = $cleanValue[0];
                $radioName = preg_replace("/[^a-zA-Z0-9]/", "", $cleanValue);
                $radioName = strtolower($radioName);
                $selectionValue = $radioFirstName . "_" . $radioName;
                $selectionsCurrent = '';
                if(array_key_exists($selectionValue,$scopeSelections) && count($scopeSelections[$selectionValue]) > 0) {
                    $selections = $scopeSelections[$selectionValue];
                    $selectionsCurrent .= '(';
                    $lastElement = end($selections);
                    foreach($selections as $selection) {
                        if($selection != $lastElement) {
                            $selectionsCurrent .= get_the_title($selection) . ', ';
                        }
                        else {
                            $selectionsCurrent .= get_the_title($selection) . '';
                        }
                    }
                    $selectionsCurrent .= ')';
                }
                else {
                    $selections = null;;
                }

                $message .= '<span class="label label-default margin-right-10 margin-bottom-10">' . $value . ' ' . $selectionsCurrent . '</span>';
              }
            }
            $message .= '</dd>';
          }
          // *** end
        }
        $message .= '</dl>';
        $message .= '</div>';
        $message .= '<div class="text-center"><a style="cursor:pointer;" class="btn btn-sm btn-outline btn-default" onclick="closeScope();">Close</a></div>';
        echo json_encode( array("message" => $message, "status" => 'success') );
        die;
}
else {
        $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong! No POST data!</div>";
        echo json_encode( array("message" => $message, "status" => 'fail') );
        die;
}
?>
