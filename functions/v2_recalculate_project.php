<?php
require_once(ABSPATH . "wp-load.php");

/*
  This function used to calculate Total Price of project based on
  Scope prices.
*/
function go_recalculate_project($projectId) {

  $projectScope = get_field('projectScopes',$projectId);
  // get total of project based on subtotals of scopes
  $projectTotal = 0;
  foreach($projectScope as $pS) {
      $scopePrice = 0;
      $scopeAdjustment = 0;
  	$scopePrice = get_field('scopePrice',$pS);
    $scopeAdjustment = get_field('totalAdjustment',$pS);
    $scopePriceTotal = $scopePrice + $scopeAdjustment;
  	$projectTotal = $projectTotal + $scopePriceTotal;
  }
  $projectTotal = number_format($projectTotal, 2, '.', '');

  // saving Price in project custom field
  $report = update_field('field_567ecca82747a',$projectTotal,$projectId);

  return $report;

}

?>
