<?php
require_once(ABSPATH . "wp-load.php");

// redirecting if User is not registered
function go_scope_details($template_id,$quote_id) {

	$total_slug = get_field('total_slug',$template_id);
        $scope_array = get_field('quote_array',$quote_id);
        if(!is_array($scope_array)) {
                $scope_array = json_decode($scope_array,true);
        }
        $rooms = $scope_array[$total_slug . "_rooms"];
        $result = array();
        $i=1;
        while($i <= $rooms) :
        $room = 'Room ' .  $i;
        $section_details = array();
                while ( have_rows('quote_fields',$template_id) ) : the_row();

                        if( get_row_layout() == 'width_and_height' ) {
                                $slug = get_sub_field('slug');
                                $title = get_sub_field('title');
                                $width = $scope_array[$total_slug . "_" . $slug . "_width_" . $i];
                                $lenght = $scope_array[$total_slug . "_" . $slug . "_length_" . $i];
                                $value =  $width . "x" . $lenght;
                                $section_details[] = array('section_title' => $title, 'section_values' => array($value));
                        }

                        if( get_row_layout() == 'length' ) {
                                $slug = get_sub_field('slug');
                                $title = get_sub_field('title');
                                $width = $scope_array[$total_slug . "_" . $slug . "_width_" . $i];
                                $value =  $width;
                                $section_details[] = array('section_title' => $title, 'section_values' => array($value));
                        }

                        if( get_row_layout() == 'fields' ) {
                                $slug = get_sub_field('slug');
                                $data = $scope_array[$total_slug . "_" . $slug . "_" . $i];
                                $title = get_sub_field('title');
                                $new_value = array();
                                if(is_array($data)) {
                                        foreach($data as $d) {
                                                $cnt_field_name = preg_replace("/[^a-zA-Z]/", "", $d);
        					$cnt_field_name = strtolower($cnt_field_name);
                                                $cnt_field_name = $total_slug . "_" . $cnt_field_name . "_" . $i;
                                                if (array_key_exists($cnt_field_name, $scope_array)) {
                                                        $value_cnt = $scope_array[$cnt_field_name];
                                                        $new_value[] = $d . " x" . $value_cnt;
                                                }
                                                else {
                                                        $new_value[] = $d;
                                                }
                                        }
                                        $value = $new_value;
                                }
                                else {
                                        $cnt_field_name = preg_replace("/[^a-zA-Z]/", "", $data);
					$cnt_field_name = strtolower($cnt_field_name);
                                        $cnt_field_name = $total_slug . "_" . $cnt_field_name . "_" . $i;
                                        if (array_key_exists($cnt_field_name, $scope_array)) {
                                                $value_cnt = $scope_array[$cnt_field_name];
                                                $new_value[] = $data . " x" . $value_cnt;
                                        }
                                        else {
                                                $new_value[] = $data;
                                        }
                                        $value = $new_value;
                                }
                                $section_details[] = array('section_title' => $title, 'section_type' => 'flds', 'section_values' => $value);
                        }

                        if( get_row_layout() == 'additional_notes' ) {
                                $slug = get_sub_field('slug');
                                $title = get_sub_field('title');
                                $notes = $scope_array[$total_slug . "_" . $slug . "_" . $i];
                                $value =  $notes;
                                $section_details[] = array('section_title' => $title, 'section_type' => 'notes', 'section_values' => array($value));
                        }

                        if( get_row_layout() == 'additional_photos' ) {
                                $slug = get_sub_field('slug');
                                $title = get_sub_field('title');
                                $photo = $scope_array[$total_slug . "_" . $slug . "_" . $i];

                                $section_details[] = array('section_title' => $title, 'section_type' => 'photos', 'section_values' => $photo);
                        }

                endwhile;
                $result[] = array('room'=>$room,'details'=>$section_details);
                $i++; $j++;
        endwhile;

	return $result;
}

function go_scope_details_v2($template_id,$scopeId) {

	$scopeData = get_field('scopeData',$scopeId);
	$scopeDataDecoded = base64_decode($scopeData);
	$scopeDataArray = json_decode($scopeDataDecoded,true);

    return go_scope_details_by_scope_data($template_id, $scopeDataArray);    
}

function go_scope_details_by_scope_data($template_id, $scopeDataArray){
	$result = array();
	$section_details = array();
	while ( have_rows('quote_fields',$template_id) ) : the_row();

			if( get_row_layout() == 'width_and_height' ) {
					$slug = get_sub_field('slug');
					$title = get_sub_field('title');
					$width = $scopeDataArray[$slug . "_width"];
					$lenght = $scopeDataArray[$slug . "_height"];
					$wallarea = $width * $lenght;
					$value =  $width . "x" . $lenght . " - Area " . $wallarea . " m2" ;
					$section_details[] = array('section_title' => $title, 'section_values' => array($value));
			}
		 
			  if( get_row_layout() == 'width_and_length' ) {
					$slug = get_sub_field('slug');
					$title = get_sub_field('title');
					$width = $scopeDataArray[$slug . "_width"];
					$lenght = $scopeDataArray[$slug . "_length"];
					$floorarea = $width * $lenght;
					$value =  $width . " x " . $lenght . " - Area - " . $floorarea . "m2";
					$section_details[] = array('section_title' => $title, 'section_values' => array($value));
			}

			  if( get_row_layout() == 'price_and_area' ) {
					$slug = get_sub_field('slug');
					$title = get_sub_field('title');
					$supply_price = $scopeDataArray[$slug . "_price"];
					$supply_area = $scopeDataArray[$slug . "_area"];
					$supply_total = $supply_price * $supply_area;
											  
					$value =  "$" . $supply_price . " x " . $supply_area ."m2 - Supply Cost: $" . $supply_total . "inc gst";
					$section_details[] = array('section_title' => $title, 'section_values' => array($value));
			}


			if( get_row_layout() == 'length' ) {
					$slug = get_sub_field('slug');
					$title = get_sub_field('title');
					$width = $scopeDataArray[$slug];
					$value =  $width . "m";
					$section_details[] = array('section_title' => $title, 'section_values' => array($value));
			}

			if( get_row_layout() == 'fields' ) {
					$slug = get_sub_field('slug');
					$data = $scopeDataArray[$slug . ""];
					$title = get_sub_field('title');
					$new_value = array();
					if(is_array($data)) {
							foreach($data as $d) {
									$cnt_field_name = preg_replace("/[^a-zA-Z0-9]/", "", $d);
											  $cnt_field_name = strtolower($cnt_field_name);
									$cnt_field_name = $cnt_field_name . "";
									if (array_key_exists($cnt_field_name, $scopeDataArray)) {
											$value_cnt = $scopeDataArray[$cnt_field_name];
											$new_value[] = $d . " x " . $value_cnt;
									}
									else {
											$new_value[] = $d;
									}
							}
							$value = $new_value;
					}
					else {
							$cnt_field_name = preg_replace("/[^a-zA-Z0-9]/", "", $data);
							$cnt_field_name = strtolower($cnt_field_name);
							$cnt_field_name = $cnt_field_name . "";
							if (array_key_exists($cnt_field_name, $scopeDataArray)) {
									$value_cnt = $scopeDataArray[$cnt_field_name];
									$new_value[] = $data . " x " . $value_cnt;
							}
							else {
									$new_value[] = $data;
							}
							$value = $new_value;
					}
					$section_details[] = array('section_title' => $title, 'section_type' => 'flds', 'section_values' => $value);
			}

			 if( get_row_layout() == 'exclusions' ) {
					$slug = get_sub_field('slug');
					$data = $scopeDataArray[$slug . ""];
					$title = get_sub_field('title');
					$new_value = array();
					if(is_array($data)) {
							foreach($data as $d) {
									$cnt_field_name = preg_replace("/[^a-zA-Z0-9]/", "", $d);
									$cnt_field_name = strtolower($cnt_field_name);
									$cnt_field_name = $cnt_field_name . "";
									if (array_key_exists($cnt_field_name, $scopeDataArray)) {
											$value_cnt = $scopeDataArray[$cnt_field_name];
											$new_value[] = $d . " x " . $value_cnt;
									}
									else {
											$new_value[] = $d;
									}
							}
							$value = $new_value;
					}
					else {
							$cnt_field_name = preg_replace("/[^a-zA-Z0-9]/", "", $data);
							$cnt_field_name = strtolower($cnt_field_name);
							$cnt_field_name = $cnt_field_name . "";
							if (array_key_exists($cnt_field_name, $scopeDataArray)) {
									$value_cnt = $scopeDataArray[$cnt_field_name];
									$new_value[] = $data . " x " . $value_cnt;
							}
							else {
									$new_value[] = $data;
							}
							$value = $new_value;
					}
					$section_details[] = array('section_title' => $title, 'section_type' => 'flds', 'section_values' => $value);
			}

	endwhile;
	$result = $section_details;
	$i++; $j++;


	return $result;
}

?>
