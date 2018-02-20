<?php
require_once(ABSPATH . "wp-load.php");

/*
  This function used to set all default Selections to Scope
  Used in finishProject.php before calculating of Total Price
*/
function go_set_default_selections($scopeId) {

  $scopeSelectionsArray = array();

  $scopeData = get_field('scopeData',$scopeId);
  $scopeDataDecoded = base64_decode($scopeData);
  $scopeDataArray = json_decode($scopeDataDecoded,true);
  $scopeLevel = get_field('scopeLevel',$scopeId);
  $scopeLevelId = $scopeLevel;
  $scopeLevel = get_term( $scopeLevel, 'selection_level' );
  $scopeLevel = $scopeLevel->name;
  $scopeTemplateId = get_field('scopeTemplate',$scopeId);
  $templateData = get_field('quote_fields',$scopeTemplateId);

  $scopeDetails = go_scope_details_v2($scopeTemplateId,$scopeId);

  $scopeSelectionsArray = go_get_default_selections($scopeDetails);

  $selectionsArray = json_encode($scopeSelectionsArray);
  $selectionsArrayEncoded = base64_encode($selectionsArray);

  $report = update_field('field_574ffd4ff8125',$selectionsArrayEncoded,$scopeId);

  return $report;

}

function go_get_default_selections($scopeDetails){
  $selectionsExist = false;
  foreach($scopeDetails as $sD) {
	if(array_key_exists('section_type',$sD) && $sD['section_type'] == 'flds') {
	  $scopeSectionTitle = $sD['section_title'];
	  $radioFirstName = preg_replace("/[^a-zA-Z0-9]/", "", $scopeSectionTitle);
	  $radioFirstName = strtolower($radioFirstName);

	  foreach($sD['section_values'] as $value) {

		// let's go by Quote Template array and find current Title options
		foreach($templateData as $tD) {
		  if($tD['title'] == $scopeSectionTitle) {
			foreach($tD['fields'] as $field) {
			  $cleanValue = explode(' x', $value);
			  $cleanValue = $cleanValue[0];
			  if($field['title'] == $cleanValue && $field['selections_category'] != null) {
				  $selectionsExist = true;
				  $radioName = preg_replace("/[^a-zA-Z0-9]/", "", $field['title']);
				  $radioName = strtolower($radioName);
				  // let's get a Selections for category: $field['selections_category'] AND level: $scopeLevelId
				  $selections = get_posts(
					array(
					  'posts_per_page'=>9999,
					  'post_type'=>'select',
					  'tax_query' => array(
						array(
							'taxonomy' => 'selection_cat',
							'field' => 'term_id',
							'terms' => array($field['selections_category'])
						),
						array(
							'taxonomy' => 'selection_level',
							'field' => 'term_id',
							'terms' => array($scopeLevelId)
						)
					  )
					)
				  );
				  // in $defaultId variable we will store array of default selections
				  $defaultId = array();
				  foreach($selections as $selection) {

					$selectionByDefault = get_field('default',$selection->ID);
					if($selectionByDefault == true) {
					  $defaultId[] = $selection->ID;
					}
					else {

					}

				  }

				  // adding default selection into array
				  $scopeSelectionsArray[$radioFirstName .'_' . $radioName] = $defaultId;
				  $defaultId = null;
			  }
			}
		  }
		}

	  }
	}
  }
  
  return $scopeSelectionsArray;
}

?>
