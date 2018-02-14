<?php
require_once(ABSPATH . "wp-load.php");

/*
  This function used to set all default Selections to Scope
  Used in finishProject.php before calculating of Total Price
*/
function go_calculate_selection($selectionsData,$firstTitle,$secondTitle) {


  //update_field('field_57507cdc3ec4b',$firstTitle,'options');


  // FIND USERS SELECTION ID AND ADD ITS PRICE TO LABOURnMATERIAL
  $selectionPrice = 0;
  if(is_array($selectionsData)) {
    $radioFirstName = preg_replace("/[^a-zA-Z0-9]/", "", $firstTitle);
    $radioFirstName = strtolower($radioFirstName);
    $radioName = preg_replace("/[^a-zA-Z0-9]/", "", $secondTitle);
    $radioName = strtolower($radioName);
    $selectionOfType = $selectionsData[$radioFirstName . '_' . $radioName];

    if($selectionOfType != null && $selectionOfType != '' && is_array($selectionOfType) && count($selectionOfType) > 0) {
        $selectionPrice = 0;
        foreach($selectionOfType as $selectionOfTypeSingle) {
            // selection price
            $selectionLabourPrice = 0;
            $selectionLabour = get_field('labour',$selectionOfTypeSingle);
            foreach($selectionLabour as $sL) {
              $selectionLabourPrice = $selectionLabourPrice + $sL['price'];
            }
            $selectionLabourPrice = number_format($selectionLabourPrice, 2, '.', '');
            $selectionMaterialPrice = 0;
            $selectionMaterial = get_field('material',$selectionOfTypeSingle);
            foreach($selectionMaterial as $sM) {
              $selectionMaterialPrice = $selectionMaterialPrice + $sM['price'];
            }
            $selectionMaterialPrice = number_format($selectionMaterialPrice, 2, '.', '');
            $selectionPrice = $selectionPrice + $selectionLabourPrice + $selectionMaterialPrice;
        }
    }
    else {
      $selectionPrice = 0;
    }

  }

  return $selectionPrice;

}

?>
