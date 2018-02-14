<?php
require_once(ABSPATH . "wp-load.php");

// retrieving Invoice statistic of user
function go_calculate($data) {
        $object = new stdClass();
        $total = 0;
        
        $temlates = $data['templates'];
        
        
        foreach($temlates as $t) {
                        
                // formulas for Bathroom template
                if(get_the_title($t) == 'Bathroom') {
                                
                                
                        $all_scope_data = get_field('quote_fields',$t);
                        $total_slug = get_field('total_slug',$t);
                        $rooms_qnt = $data[$total_slug . '_rooms'];
                        if(empty($rooms_qnt) || $rooms_qnt == NULL || $rooms_qnt == '') {
                                $rooms_qnt = 1;
                        }
                
                        $rooms = 1;
                        while($rooms <= $rooms_qnt) :
                                        
                                
                                $width = $data[$total_slug . '_square_width_' . $rooms];
                                $length = $data[$total_slug . '_square_length_' . $rooms];
                                
                                $floor_area = $width * $length;
                                
                                
                                foreach($all_scope_data as $d) {
                                        if($d['slug'] == 'ceiling_height') {
                                                $height_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'current_fixtures') {
                                                $current_fixtures_prices = $d['type_of_price'];
                                                $current_fixtures_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'proposed_fixtures') {
                                                $proposed_fixtures_prices = $d['type_of_price'];
                                                $proposed_fixtures_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'paint_ceilings') {
                                                $paint_ceilings_prices = $d['type_of_price'];
                                                $paint_ceilings_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'flooring') {
                                                $flooring_prices = $d['type_of_price'];
                                                $flooring_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'flooring') {
                                                $flooring_prices = $d['type_of_price'];
                                                $flooring_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'walls') {
                                                $walls_prices = $d['type_of_price'];
                                                $walls_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'extra') {
                                                $extra_prices = $d['type_of_price'];
                                                $extra_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'level') {
                                                $extra_prices = $d['type_of_price'];
                                                $extra_data = $d['fields'];
                                        }
                                }
                                
                                $height = $data[$total_slug . '_ceiling_height_' . $rooms];
                                $height_total = 0;
                                foreach($height_data as $temp) {
                                        if( $temp['title'] == $height ) {
                                        
                                                $range_price_total = $temp['range_price'];
                                                $height_total = $range_price_total;
                                        
                                        }
                                }
                                
                                $wall_area = ( $width + $width + $length + $length ) * $height_total;
                                
                                $demolition = $data[$total_slug . '_demolition_' . $rooms];
                                $current_fixtures = $data[$total_slug . '_current_fixtures_' . $rooms];
                                $current_fixtures_total = 0;
                                if($demolition == 'Yes') {
                                        foreach($current_fixtures_data as $fixture) {
                                                if( in_array($fixture['title'],$current_fixtures) && $fixture['title'] != 'Tiled Wall' && $fixture['title'] != 'Tiled Floor' && $fixture['title'] != 'Vinyl Floor') {
                                                
                                                        // let's count QNT of each extra field
                                                        $field_title = $fixture['title'];
                                                        $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                        $count_field_title = strtolower($count_field_title);
                                                        $extra_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
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
                                                        
                                                                $current_fixtures_total = $current_fixtures_total + ($material_price_total_value + $labour_price_total_value * $extra_count);
                                                        }
                                                        elseif($current_fixtures_prices == 'range') {
                                                                $range_price_total = $fixture['range_price'];
                                                                $current_fixtures_total = $current_fixtures_total + ($range_price_total * $extra_count);
                                                        }
                                                        
                                                }
                                                elseif( in_array($fixture['title'],$current_fixtures) && $fixture['title'] == 'Tiled Wall') {
                                                        
                                                        // let's count QNT of each extra field
                                                        $field_title = $fixture['title'];
                                                        $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                        $count_field_title = strtolower($count_field_title);
                                                        $extra_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
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
                                                        
                                                                $labour_material_price_total = $material_price_total_value + $labour_price_total_value;
                                                                $current_fixtures_total = $current_fixtures_total + ( $labour_material_price_total * $wall_area * $extra_count);
                                                        }
                                                        elseif($current_fixtures_prices == 'range') {
                                                                $range_price_total = $fixture['range_price'];
                                                                $current_fixtures_total = $current_fixtures_total + ( $range_price_total * $wall_area * $extra_count); 
                                                        }
                                                        
                                                }
                                                elseif( in_array($fixture['title'],$current_fixtures) && ( $fixture['title'] == 'Tiled Floor' || $fixture['title'] == 'Vinyl Floor' )) {
                                                        
                                                        // let's count QNT of each extra field
                                                        $field_title = $fixture['title'];
                                                        $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                        $count_field_title = strtolower($count_field_title);
                                                        $extra_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
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
                                                        
                                                                $labour_material_price_total = $material_price_total_value + $labour_price_total_value;
                                                                $current_fixtures_total = $current_fixtures_total + ( $labour_material_price_total * $floor_area * $extra_count);
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
                                
                                $paint_ceilings = $data[$total_slug . '_paint_ceilings_' . $rooms];
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
                                                        
                                                                $labour_material_price_total = $material_price_total_value + $labour_price_total_value;
                                                                $paint_ceilings_total = $paint_ceilings_total + ( $labour_material_price_total * $floor_area );
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
                                
                                $proposed_fixtures = $data[$total_slug . '_proposed_fixtures_' . $rooms];
                                $proposed_fixtures_total = 0;
                                foreach($proposed_fixtures_data as $fixture) {
                                        if( in_array($fixture['title'],$proposed_fixtures) ) {
                                                
                                                // let's count QNT of each extra field
                                                $field_title = $fixture['title'];
                                                $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                $count_field_title = strtolower($count_field_title);
                                                $extra_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
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
                                                
                                                        $proposed_fixtures_total = $proposed_fixtures_total + ($material_price_total_value + $labour_price_total_value * $extra_count);
                                                }
                                                elseif($proposed_fixtures_prices == 'range') {
                                                        $range_price_total = $fixture['range_price'];
                                                        $proposed_fixtures_total = $proposed_fixtures_total + ( $range_price_total * $extra_count );
                                                }
                                                
                                        }
                                }
                                
                                $flooring = $data[$total_slug . '_flooring_' . $rooms];
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
                                                
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $flooring_total = $labour_and_material_total * $floor_area;
                                                }
                                                elseif($flooring_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $flooring_total = $range_price_total * $floor_area;
                                                }
                                                
                                        }
                                }
                                
                                $walls = $data[$total_slug . '_walls_' . $rooms];
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
                                                
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $walls_total = $labour_and_material_total * $wall_area;
                                                }
                                                elseif($walls_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $walls_total = $range_price_total * $wall_area;
                                                }
                                                
                                        }
                                }
                                
                                $extra = $data[$total_slug . '_extra_' . $rooms];
                                $extra_total = 0;
                                foreach($extra_data as $temp) {
                                        if( in_array($temp['title'],$extra) ) {
                                                
                                                // let's count QNT of each extra field
                                                $field_title = $temp['title'];
                                                $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                $count_field_title = strtolower($count_field_title);
                                                $extra_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
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
                                                
                                                        $material_and_labour_total = $material_price_total_value + $labour_price_total_value;
                                                        $extra_total = $extra_total +  ( $material_and_labour_total * $extra_count);
                                                }
                                                elseif($extra_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $extra_total = $extra_total + ( $range_price_total * $extra_count);
                                                }
                                                
                                        }
                                        
                                }    
                                
                                $bathroom_total = $current_fixtures_total + $proposed_fixtures_total + $paint_ceilings_total + $flooring_total + $walls_total + $extra_total;
                               
                                $level = $data[$total_slug . '_level_' . $rooms];
                                $level_total = 0;
                                foreach($level_data as $temp) {
                                        if( in_array($temp['title'],$level) ) {
                                                
                                                // let's count QNT of each extra field
                                                $field_title = $temp['title'];
                                                $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                $count_field_title = strtolower($count_field_title);
                                                $level_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
                                                if($level_count == NULL || $level_count == '' || empty($level_count)) {
                                                       $level_count = 1; 
                                                }
                                                
                                                if($level_prices == 'labour') {
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
                                                
                                                        $material_and_labour_total = $material_price_total_value + $labour_price_total_value;
                                                        $level_total = $level_total +  ( $material_and_labour_total * $level_count);
                                                }
                                                elseif($level_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $level_total = $level_total + ( $range_price_total * $bathroom_total);
                                                }
                                                
                                        }
                                        
                                }
                  
                                $bathroom_total = $bathroom_total + $level_total;
                                $total = $total + $bathroom_total;
                                $full_total = $bathroom_total;
                                $rooms++;        
                        endwhile; 
                        
                }
                
                // formulas for Toilet template
                if(get_the_title($t) == 'Toilet') {
                                
                                
                        $all_scope_data = get_field('quote_fields',$t);
                        $total_slug = get_field('total_slug',$t);
                        $rooms_qnt = $data[$total_slug . '_rooms'];
                        if(empty($rooms_qnt) || $rooms_qnt == NULL || $rooms_qnt == '') {
                                $rooms_qnt = 1;
                        }
                
                        $rooms = 1;
                        while($rooms <= $rooms_qnt) :
                                        
                                
                                $width = $data[$total_slug . '_area_width_' . $rooms];
                                $length = $data[$total_slug . '_area_length_' . $rooms];
                                
                                $floor_area = $width * $length;
                                
                                foreach($all_scope_data as $d) {
                                        if($d['slug'] == 'ceiling_height') {
                                                $height_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'current') {
                                                $current_fixtures_prices = $d['type_of_price'];
                                                $current_fixtures_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'fixtures') {
                                                $proposed_fixtures_prices = $d['type_of_price'];
                                                $proposed_fixtures_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'ceiling') {
                                                $paint_ceilings_prices = $d['type_of_price'];
                                                $paint_ceilings_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'floor') {
                                                $flooring_prices = $d['type_of_price'];
                                                $flooring_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'wall') {
                                                $walls_prices = $d['type_of_price'];
                                                $walls_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'extras') {
                                                $extra_prices = $d['type_of_price'];
                                                $extra_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'level') {
                                                $level_prices = $d['type_of_price'];
                                                $level_data = $d['fields'];
                                        }
                                }
                                
                                $height = $data[$total_slug . '_ceiling_height_' . $rooms];
                                $height_total = 0;
                                foreach($height_data as $temp) {
                                        if( $temp['title'] == $height ) {
                                        
                                                $range_price_total = $temp['range_price'];
                                                $height_total = $range_price_total;
                                        
                                        }
                                }
                                
                                $wall_area = ( $width + $width + $length + $length ) * $height_total;
                                
                                $demolition = $data[$total_slug . '_demolition_' . $rooms];
                                $current_fixtures = $data[$total_slug . '_current_' . $rooms];
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
                                                        
                                                                $current_fixtures_total = $current_fixtures_total + $material_price_total_value + $labour_price_total_value;
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
                                                        
                                                                $labour_material_price_total = $material_price_total_value + $labour_price_total_value;
                                                                $current_fixtures_total = $current_fixtures_total + ( $labour_material_price_total * $wall_area );
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
                                                        
                                                                $labour_material_price_total = $material_price_total_value + $labour_price_total_value;
                                                                $current_fixtures_total = $current_fixtures_total + ( $labour_material_price_total * $floor_area );
                                                        }
                                                        elseif($current_fixtures_prices == 'range') {
                                                                $range_price_total = $fixture['range_price'];
                                                                $current_fixtures_total = $current_fixtures_total + ( $range_price_total * $floor_area); 
                                                        }
                                                        
                                                }
                                        }
                                        
                                }
                                
                                $paint_ceilings = $data[$total_slug . '_ceiling_' . $rooms];
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
                                                        
                                                                $labour_material_price_total = $material_price_total_value + $labour_price_total_value;
                                                                $paint_ceilings_total = $paint_ceilings_total + ( $labour_material_price_total * $floor_area );
                                                        }
                                                        elseif($paint_ceilings_prices == 'range') {
                                                                $range_price_total = $temp['range_price'];
                                                                $paint_ceilings_total = $paint_ceilings_total + ( $range_price_total * $floor_area );
                                                        }
                                                        
                                                }
                                        }
                                        
                                }
                                
                                $proposed_fixtures = $data[$total_slug . '_fixtures_' . $rooms];
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
                                                
                                                        $proposed_fixtures_total = $proposed_fixtures_total + $material_price_total_value + $labour_price_total_value;
                                                }
                                                elseif($proposed_fixtures_prices == 'range') {
                                                        $range_price_total = $fixture['range_price'];
                                                        $proposed_fixtures_total = $proposed_fixtures_total + $range_price_total;
                                                }
                                                
                                        }
                                }
                                
                                $flooring = $data[$total_slug . '_floor_' . $rooms];
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
                                                
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $flooring_total = $labour_and_material_total * $floor_area;
                                                }
                                                elseif($flooring_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $flooring_total = $range_price_total * $floor_area;
                                                }
                                                
                                        }
                                }
                                
                                $walls = $data[$total_slug . '_wall_' . $rooms];
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
                                                
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $walls_total = $labour_and_material_total * $wall_area;
                                                }
                                                elseif($walls_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $walls_total = $range_price_total * $wall_area;
                                                }
                                                
                                        }
                                }
                                
                                $extra = $data[$total_slug . '_extras_' . $rooms];
                                $extra_total = 0;
                                foreach($extra_data as $temp) {
                                        if( in_array($temp['title'],$extra) ) {
                                                
                                                // let's count QNT of each extra field
                                                $field_title = $temp['title'];
                                                $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                $count_field_title = strtolower($count_field_title);
                                                $extra_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
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
                                                
                                                        $material_and_labour_total = $material_price_total_value + $labour_price_total_value;
                                                        $extra_total = $extra_total +  ( $material_and_labour_total * $extra_count);
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
                                $rooms++;        
                        endwhile; 
                        
                }
                
                // formulas for Laundry template
                if(get_the_title($t) == 'Laundry') {
                                
                                
                        $all_scope_data = get_field('quote_fields',$t);
                        $total_slug = get_field('total_slug',$t);
                        $rooms_qnt = $data[$total_slug . '_rooms'];
                        if(empty($rooms_qnt) || $rooms_qnt == NULL || $rooms_qnt == '') {
                                $rooms_qnt = 1;
                        }
                
                        $rooms = 1;
                        while($rooms <= $rooms_qnt) :
                                        
                                
                                $width = $data[$total_slug . '_area_width_' . $rooms];
                                $length = $data[$total_slug . '_area_length_' . $rooms];
                                
                                $floor_area = $width * $length;
                                
                                
                                foreach($all_scope_data as $d) {
                                        if($d['slug'] == 'ceiling') {
                                                $height_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'current') {
                                                $current_fixtures_prices = $d['type_of_price'];
                                                $current_fixtures_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'fixutres') {
                                                $proposed_fixtures_prices = $d['type_of_price'];
                                                $proposed_fixtures_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'ceilings') {
                                                $paint_ceilings_prices = $d['type_of_price'];
                                                $paint_ceilings_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'floor') {
                                                $flooring_prices = $d['type_of_price'];
                                                $flooring_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'walls') {
                                                $walls_prices = $d['type_of_price'];
                                                $walls_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'extras') {
                                                $extra_prices = $d['type_of_price'];
                                                $extra_data = $d['fields'];
                                        }
                                }
                                
                                $height = $data[$total_slug . '_ceiling_' . $rooms];
                                $height_total = 0;
                                foreach($height_data as $temp) {
                                        if( $temp['title'] == $height ) {
                                        
                                                $range_price_total = $temp['range_price'];
                                                $height_total = $range_price_total;
                                        
                                        }
                                }
                                
                                $wall_area = ( $width + $width + $length + $length ) * $height_total;
                                
                                $demolition = $data[$total_slug . '_demolition_' . $rooms];
                                $current_fixtures = $data[$total_slug . '_current_' . $rooms];
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
                                                        
                                                                $current_fixtures_total = $current_fixtures_total + $material_price_total_value + $labour_price_total_value;
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
                                                        
                                                                $labour_material_price_total = $material_price_total_value + $labour_price_total_value;
                                                                $current_fixtures_total = $current_fixtures_total + ( $labour_material_price_total * $wall_area );
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
                                                        
                                                                $labour_material_price_total = $material_price_total_value + $labour_price_total_value;
                                                                $current_fixtures_total = $current_fixtures_total + ( $labour_material_price_total * $floor_area );
                                                        }
                                                        elseif($current_fixtures_prices == 'range') {
                                                                $range_price_total = $fixture['range_price'];
                                                                $current_fixtures_total = $current_fixtures_total + ( $range_price_total * $floor_area); 
                                                        }
                                                        
                                                }
                                        }
                                        
                                }
                                
                                $paint_ceilings = $data[$total_slug . '_ceilings_' . $rooms];
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
                                                        
                                                                $labour_material_price_total = $material_price_total_value + $labour_price_total_value;
                                                                $paint_ceilings_total = $paint_ceilings_total + ( $labour_material_price_total * $floor_area );
                                                        }
                                                        elseif($paint_ceilings_prices == 'range') {
                                                                $range_price_total = $temp['range_price'];
                                                                $paint_ceilings_total = $paint_ceilings_total + ( $range_price_total * $floor_area );
                                                        }
                                                        
                                                }
                                        }
                                        
                                }
                                
                                $proposed_fixtures = $data[$total_slug . '_fixtures_' . $rooms];
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
                                                
                                                        $proposed_fixtures_total = $proposed_fixtures_total + $material_price_total_value + $labour_price_total_value;
                                                }
                                                elseif($proposed_fixtures_prices == 'range') {
                                                        $range_price_total = $fixture['range_price'];
                                                        $proposed_fixtures_total = $proposed_fixtures_total + $range_price_total;
                                                }
                                                
                                        }
                                }
                                
                                $flooring = $data[$total_slug . '_floor_' . $rooms];
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
                                                
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $flooring_total = $labour_and_material_total * $floor_area;
                                                }
                                                elseif($flooring_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $flooring_total = $range_price_total * $floor_area;
                                                }
                                                
                                        }
                                }
                                
                                $walls = $data[$total_slug . '_walls_' . $rooms];
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
                                                
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $walls_total = $labour_and_material_total * $wall_area;
                                                }
                                                elseif($walls_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $walls_total = $range_price_total * $wall_area;
                                                }
                                                
                                        }
                                }
                                
                                $extra = $data[$total_slug . '_extras_' . $rooms];
                                $extra_total = 0;
                                foreach($extra_data as $temp) {
                                        if( in_array($temp['title'],$extra) ) {
                                                
                                                // let's count QNT of each extra field
                                                $field_title = $temp['title'];
                                                $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                $count_field_title = strtolower($count_field_title);
                                                $extra_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
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
                                                
                                                        $material_and_labour_total = $material_price_total_value + $labour_price_total_value;
                                                        $extra_total = $extra_total +  ( $material_and_labour_total * $extra_count);
                                                }
                                                elseif($extra_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $extra_total = $extra_total + ( $range_price_total * $extra_count);
                                                }
                                                
                                        }
                                        
                                }    
                                
                                $laundry_total = $current_fixtures_total + $paint_ceilings_total + $proposed_fixtures_total + $flooring_total + $walls_total + $extra_total;
                                $total = $total + $laundry_total;
                        
                                $rooms++;        
                        endwhile; 
                        
                }
                
                // formulas for House Extension template
                if(get_the_title($t) == 'House Extension') {
                                
                                
                        $all_scope_data = get_field('quote_fields',$t);
                        $total_slug = get_field('total_slug',$t);
                        $rooms_qnt = $data[$total_slug . '_rooms'];
                        $house_extension_total = 0;
                
                        $rooms = 1;
                        while($rooms <= $rooms_qnt) :
                                        
                                
                                $width = $data[$total_slug . '_area_width_' . $rooms];
                                $length = $data[$total_slug . '_area_length_' . $rooms];
                                
                                $floor_area = $width * $length;
                                
                                foreach($all_scope_data as $d) {
                                        if($d['slug'] == 'rooms') {
                                                $pick_rooms_prices = $d['type_of_price'];
                                                $pick_rooms_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'foundation') {
                                                $foundation_prices = $d['type_of_price'];
                                                $foundation_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'cladding') {
                                                $cladding_prices = $d['type_of_price'];
                                                $cladding_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'roof') {
                                                $roof_prices = $d['type_of_price'];
                                                $roof_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'site') {
                                                $site_prices = $d['type_of_price'];
                                                $site_data = $d['fields'];
                                        }
                                }
                                
                                $pick_rooms = $data[$total_slug . '_rooms_' . $rooms];
                                $pick_rooms_total = 0;
                                foreach($pick_rooms_data as $temp) {
                                        if( in_array($temp['title'],$pick_rooms) ) {
                                                
                                                // let's count QNT of each extra field
                                                $field_title = $temp['title'];
                                                $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                $count_field_title = strtolower($count_field_title);
                                                $extra_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
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
                                                
                                                        $pick_rooms_total = $pick_rooms_total + ( $material_price_total_value + $labour_price_total_value * $extra_count );
                                                }
                                                elseif($pick_rooms_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $pick_rooms_total = $pick_rooms_total + ( $range_price_total * $extra_count );
                                                }
                                                
                                        }
                                }
                                
                                $foundation = $data[$total_slug . '_foundation_' . $rooms];
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
                                                
                                                        $foundation_total = $material_price_total_value + $labour_price_total_value;
                                                }
                                                elseif($foundation_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $foundation_total = $range_price_total;
                                                }
                                                
                                        }
                                }
                                
                                $wall_cladding = $data[$total_slug . '_cladding_' . $rooms];
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
                                                
                                                        $wall_cladding_total = $material_price_total_value + $labour_price_total_value;
                                                }
                                                elseif($cladding_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $wall_cladding_total = $range_price_total;
                                                }
                                                
                                        }
                                }
                                
                                $roof_cladding = $data[$total_slug . '_roof_' . $rooms];
                                $roof_cladding_total = 0;
                                foreach($roof_data as $temp) {
                                        if( $temp['title'] == $roof_cladding ) {
                                                
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
                                                
                                                        $roof_cladding_total = $material_price_total_value + $labour_price_total_value;
                                                }
                                                elseif($roof_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $roof_cladding_total = $range_price_total;
                                                }
                                                
                                        }
                                }
                                
                                $site = $data[$total_slug . '_site_' . $rooms];
                                $site_total_1 = 0;
                                $site_total_2 = 0;
                                foreach($site_data as $temp) {
                                        if( in_array($temp['title'],$site) && ( $temp['title'] == 'Easy Access' || $temp['title'] == 'Flat land' || $temp['title'] == 'Difficult Access' || $temp['title'] == 'Sloping Site' || $temp['title'] == 'Minor Demolition' || $temp['title'] == 'Major Demolition' || $temp['title'] == 'Contigency Sum' ) ) {
                                                
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
                        
                                $rooms++;        
                        endwhile; 
                        
                }
                
                // formulas for Kitchen template
                if(get_the_title($t) == 'Kitchen') {
                                
                                
                        $all_scope_data = get_field('quote_fields',$t);
                        $total_slug = get_field('total_slug',$t);
                        $rooms_qnt = $data[$total_slug . '_rooms'];
                        if(empty($rooms_qnt) || $rooms_qnt == NULL || $rooms_qnt == '') {
                                $rooms_qnt = 1;
                        }
                
                        $rooms = 1;
                        while($rooms <= $rooms_qnt) :
                                        
                                $kitchen_total_price = 0;
                                $width = $data[$total_slug . '_square_width_' . $rooms];
                                $length = $data[$total_slug . '_square_length_' . $rooms];
                                
                                $floor_area = $width * $length;
                                
                                
                                foreach($all_scope_data as $d) {
                                        if($d['slug'] == 'ceiling_height') {
                                                $height_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'current') {
                                                $current_fixtures_prices = $d['type_of_price'];
                                                $current_fixtures_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'appliances') {
                                                $proposed_fixtures_prices = $d['type_of_price'];
                                                $proposed_fixtures_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'ceiling') {
                                                $paint_ceilings_prices = $d['type_of_price'];
                                                $paint_ceilings_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'floor') {
                                                $flooring_prices = $d['type_of_price'];
                                                $flooring_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'walls') {
                                                $walls_prices = $d['type_of_price'];
                                                $walls_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'extras') {
                                                $extra_prices = $d['type_of_price'];
                                                $extra_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'cabinetry') {
                                                $layout_prices = $d['type_of_price'];
                                                $layout_data = $d['fields'];
                                        } 
                                        if($d['slug'] == 'cabinets') {
                                                $cabinets_prices = $d['type_of_price'];
                                                $cabinets_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'island') {
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
                                                $kitchen_size_prices = $d['type_of_price'];
                                                $kitchen_size_data = $d['fields'];
                                        }
                                        
                                }
                                
                                $height = $data[$total_slug . '_ceiling_height_' . $rooms];
                                $height_total = 0;
                                foreach($height_data as $temp) {
                                        if( $temp['title'] == $height ) {
                                        
                                                $range_price_total = $temp['range_price'];
                                                $height_total = $range_price_total;
                                        
                                        }
                                }
                                
                                $wall_area = ( $width + $width + $length + $length ) * $height_total;
                                
                                $demolition = $data[$total_slug . '_demolition_' . $rooms];
                                $current_fixtures = $data[$total_slug . '_current_' . $rooms];
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
                                                        
                                                                $current_fixtures_total = $current_fixtures_total + $material_price_total_value + $labour_price_total_value;
                                                        }
                                                        elseif($current_fixtures_prices == 'range') {
                                                                $range_price_total = $fixture['range_price'];
                                                                $current_fixtures_total = $current_fixtures_total + $range_price_total;
                                                        }
                                                        
                                                }
                                                
                                        }
                                        
                                }
                                
                                $paint_ceilings = $data[$total_slug . '_ceiling_' . $rooms];
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
                                                        
                                                                $labour_material_price_total = $material_price_total_value + $labour_price_total_value;
                                                                $paint_ceilings_total = $paint_ceilings_total + ( $labour_material_price_total * $floor_area );
                                                        }
                                                        elseif($paint_ceilings_prices == 'range') {
                                                                $range_price_total = $temp['range_price'];
                                                                $paint_ceilings_total = $paint_ceilings_total + ( $range_price_total * $floor_area );
                                                        }
                                                        
                                                }
                                        }
                                        
                                }
                                
                                $layout = $data[$total_slug . '_cabinetry_' . $rooms];
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
                                                
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $layout_total = $labour_and_material_total;
                                                }
                                                elseif($layout_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $layout_total = $range_price_total;
                                                }
                                                
                                        }
                                }
                  
                        $cabinets = $data[$total_slug . '_cabinets_' . $rooms];
                                $cabinets_total = 0;
                                foreach($cabinets_data as $temp) {
                                        if( in_array($temp['title'],$cabinets) ) {
                                                
                                                // let's count QNT of each extra field
                                                $field_title = $temp['title'];
                                                $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                $count_field_title = strtolower($count_field_title);
                                                $cabinets_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
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
                                                
                                                        $material_and_labour_total = $material_price_total_value + $labour_price_total_value;
                                                        $cabinets_total = $cabinets_total +  ( $material_and_labour_total * $cabinets_count);
                                                }
                                                elseif($cabinets_prices == 'range') 
                                                        $range_price_total = $temp['range_price'];
                                                        $cabinets_total = $cabinets_total + ( $range_price_total * $cabinets_count);
                                                }
                                                
                                        }
                                        
                                
                                
                                $island = $data[$total_slug . '_island_' . $rooms];
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
                                                        
                                                                $labour_material_price_total = $material_price_total_value + $labour_price_total_value;
                                                                $island_total = $labour_material_price_total;
                                                        }
                                                        elseif($island_prices == 'range') {
                                                                $range_price_total = $temp['range_price'];
                                                                $island_total = $range_price_total;
                                                        }
                                                        
                                                }
                                        }
                                        
                                }
                                
                                $benchtop = $data[$total_slug . '_benchtop_' . $rooms];
                                $benchtop_total = 0;
                                foreach($benchtop_data as $temp) {
                                        if( $temp['title'] == $benchtop ) {
                                                
                                                $range_price_total = $temp['range_price'];
                                                $benchtop_total = $range_price_total;
                                                
                                        }
                                }
                                
                                $cabinetry_finish = $data[$total_slug . '_finish_' . $rooms];
                                $cabinetry_finish_total = 0;
                                foreach($cabinetry_finish_data as $temp) {
                                        if( $temp['title'] == $cabinetry_finish ) {
                                                
                                                $range_price_total = $temp['range_price'];
                                                $cabinetry_finish_total = $range_price_total;
                                                
                                        }
                                }
                                
                                $kitchen_size = $data[$total_slug . '_size_' . $rooms];
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
                                                
                                                        $labour_material_price_total = $material_price_total_value + $labour_price_total_value;
                                                        $kitchen_size_total = $labour_material_price_total;
                                                }
                                                elseif($kitchen_size_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $kitchen_size_total = $range_price_total;
                                                }
                                                
                                        }
                                }
                                
                                $flooring = $data[$total_slug . '_floor_' . $rooms];
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
                                                
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $flooring_total = $labour_and_material_total * $floor_area;
                                                }
                                                elseif($flooring_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $flooring_total = $range_price_total * $floor_area;
                                                }
                                                
                                        }
                                }
                               
                                $walls = $data[$total_slug . '_walls_' . $rooms];
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
                                                
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $walls_total = $labour_and_material_total * $wall_area;
                                                }
                                                elseif($walls_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $walls_total = $range_price_total * $wall_area;
                                                }
                                                
                                        }
                                }
                               
                                $proposed_fixtures = $data[$total_slug . '_appliances_' . $rooms];
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
                                                
                                                        $proposed_fixtures_total = $proposed_fixtures_total + $material_price_total_value + $labour_price_total_value;
                                                }
                                                elseif($proposed_fixtures_prices == 'range') {
                                                        $range_price_total = $fixture['range_price'];
                                                        $proposed_fixtures_total = $proposed_fixtures_total + $range_price_total;
                                                }
                                                
                                        }
                                }
                                
                                $extra = $data[$total_slug . '_extras_' . $rooms];
                                $extra_total = 0;
                                foreach($extra_data as $temp) {
                                        if( in_array($temp['title'],$extra) ) {
                                                
                                                // let's count QNT of each extra field
                                                $field_title = $temp['title'];
                                                $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                $count_field_title = strtolower($count_field_title);
                                                $extra_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
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
                                                
                                                        $material_and_labour_total = $material_price_total_value + $labour_price_total_value;
                                                        $extra_total = $extra_total +  ( $material_and_labour_total * $extra_count);
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
                        
                                $rooms++;        
                        endwhile; 
                        
                }
        
                
                // formulas for Recladding template
                if(get_the_title($t) == 'Re-Cladding') {
                                
                                
                        $all_scope_data = get_field('quote_fields',$t);
                        $total_slug = get_field('total_slug',$t);
                        $rooms_qnt = $data[$total_slug . '_rooms'];
                
                        $rooms = 1;
                        while($rooms <= $rooms_qnt) :
                                        
                                
                                $width = $data[$total_slug . '_area_width_' . $rooms];
                                $length = $data[$total_slug . '_area_length_' . $rooms];
                                
                                foreach($all_scope_data as $d) {
                                        if($d['slug'] == 'ceiling') {
                                                $height_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'current') {
                                                $current_cladding_prices = $d['type_of_price'];
                                                $current_cladding_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'joinery') {
                                                $windows_and_doors_prices = $d['type_of_price'];
                                                $windows_and_doors_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'proposed') {
                                                $proposed_prices = $d['type_of_price'];
                                                $proposed_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'paint') {
                                                $painted_prices = $d['type_of_price'];
                                                $painted_data = $d['fields'];
                                        }
                                }
                                
                                $height = $data[$total_slug . '_ceiling_' . $rooms];
                                $height_total = 0;
                                foreach($height_data as $temp) {
                                        if( $temp['title'] == $height ) {
                                        
                                                $range_price_total = $temp['range_price'];
                                                $height_total = $range_price_total;
                                        
                                        }
                                }
                                
                                $wall_area = ( $width + $width + $length + $length ) * $height_total;
                                
                                $current_cladding = $data[$total_slug . '_current_' . $rooms];
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
                                                
                                                        $current_cladding_total = ( $material_price_total_value + $labour_price_total_value ) * $wall_area;
                                                }
                                                elseif($current_cladding_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $current_cladding_total = $range_price_total * $wall_area;
                                                }
                                                
                                        }
                                }
                                // ADD CURRENT CLADDING TOTAL TO $TOTAL
                                $total = $total + $current_cladding_total;
                                
                                $proposed_cladding = $data[$total_slug . '_proposed_' . $rooms];
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
                                                
                                                        $proposed_cladding_total = ( $material_price_total_value + $labour_price_total_value ) * $wall_area;
                                                }
                                                elseif($proposed_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $proposed_cladding_total = $range_price_total * $wall_area;
                                                }
                                                
                                        }
                                }
                                // ADD PROPOSED CLADDING TOTAL TO $TOTAL
                                $total = $total + $proposed_cladding_total;
                                
                                $paint_ceilings = $data[$total_slug . '_paint_' . $rooms];
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
                                                        
                                                                $labour_material_price_total = $material_price_total_value + $labour_price_total_value;
                                                                $paint_ceilings_total = $labour_material_price_total * $wall_area;
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
                                
                                $extra = $data[$total_slug . '_joinery_' . $rooms];
                                $extra_total = 0;
                                foreach($windows_and_doors_data as $temp) {
                                        if( in_array($temp['title'],$extra) ) {
                                                
                                                // let's count QNT of each extra field
                                                $field_title = $temp['title'];
                                                $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                $count_field_title = strtolower($count_field_title);
                                                $extra_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
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
                                                
                                                        $material_and_labour_total = $material_price_total_value + $labour_price_total_value;
                                                        $extra_total = $extra_total +  ( $material_and_labour_total * $extra_count);
                                                }
                                                elseif($windows_and_doors_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $extra_total = $extra_total + ( $range_price_total * $extra_count);
                                                }
                                                
                                        }
                                        
                                }    
                                // ADD windows and doors TOTAL TO $TOTAL
                                $total = $total + $extra_total;
                        
                                $rooms++;        
                        endwhile; 
                        
                }
                 
                // formulas for Decking template
                if(get_the_title($t) == 'Decking') {
                                
                                
                        $all_scope_data = get_field('quote_fields',$t);
                        $total_slug = get_field('total_slug',$t);
                        $rooms_qnt = $data[$total_slug . '_rooms'];
                        if(empty($rooms_qnt) || $rooms_qnt == NULL || $rooms_qnt == '') {
                                $rooms_qnt = 1;
                        }
                
                        $rooms = 1;
                        while($rooms <= $rooms_qnt) :
                                        
                                
                                $width = $data[$total_slug . '_area_width_' . $rooms];
                                $length = $data[$total_slug . '_area_length_' . $rooms];
                                
                                $p_width = $data[$total_slug . '_pergola_area_width_' . $rooms];
                                $p_length = $data[$total_slug . '_pergola_area_length_' . $rooms];
                                
                                $floor_area = $width * $length;
                                $outer_length = $width + $width + $length + $length;
                                $pergola_area = $p_width * $p_length;
                                
                                foreach($all_scope_data as $d) {
                                        if($d['slug'] == 'height') {
                                                $height_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'foundation') {
                                                $foundation_prices = $d['type_of_price'];
                                                $foundation_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'deck') {
                                                $decking_prices = $d['type_of_price'];
                                                $decking_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'finish') {
                                                $finish_prices = $d['type_of_price'];
                                                $finish_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'ballustrade') {
                                                $ballustrade_prices = $d['type_of_price'];
                                                $ballustrade_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'extras') {
                                                $extra_prices = $d['type_of_price'];
                                                $extra_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'style') {
                                                $style_prices = $d['type_of_price'];
                                                $style_data = $d['fields'];
                                        }
                                }
                                
                                $height = $data[$total_slug . '_height_' . $rooms];
                                $height_total = 0;
                                foreach($height_data as $temp) {
                                        if( $temp['title'] == $height ) {
                                                
                                                $range_price_total = $temp['range_price'];
                                                $height_total = $range_price_total;
                                                
                                        }
                                }
                                
                                $foundation = $data[$total_slug . '_foundation_' . $rooms];
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
                                                        $foundation_total = $labour_and_material_total;
                                                }
                                                elseif($foundation_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $foundation_total = $range_price_total;
                                                }
                                                
                                        }
                                }
                                
                                $decking = $data[$total_slug . '_deck_' . $rooms];
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
                                                        $decking_total = $labour_and_material_total;
                                                }
                                                elseif($decking_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $decking_total = $range_price_total;
                                                }
                                                
                                        }
                                }
                  
                                $finish = $data[$total_slug . '_finish_' . $rooms];
                                $finish_total = 0;
                                foreach($finish_data as $temp) {
                                        if( $temp['title'] == $finish ) {
                                                
                                                $range_price_total = $temp['range_price'];
                                                $finsih_total = $range_price_total;
                                                
                                        }
                                }
                                
                                $ballustrade = $data[$total_slug . '_ballustrade_' . $rooms];
                                $ballustrade_total = 0;
                                foreach($ballustrade_data as $temp) {
                                        if( $temp['title'] == $ballustrade ) {
                                                
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
                                                
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $ballustrade_total = $labour_and_material_total * $outer_length;
                                                }
                                                elseif($ballustrade_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $ballustrade_total = $range_price_total * $outer_length;
                                                }
                                                
                                        }
                                }
                                
                                $extra = $data[$total_slug . '_extras_' . $rooms];
                                $extra_total = 0;
                                foreach($extra_data as $temp) {
                                        if( in_array($temp['title'],$extra) ) {
                                                
                                                // let's count QNT of each extra field
                                                $field_title = $temp['title'];
                                                $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                $count_field_title = strtolower($count_field_title);
                                                $extra_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
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
                                                
                                                        $material_and_labour_total = $material_price_total_value + $labour_price_total_value;
                                                        $extra_total = $extra_total +  ( $material_and_labour_total * $extra_count);
                                                }
                                                elseif($extra_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $extra_total = $extra_total + ( $range_price_total * $extra_count);
                                                }
                                                
                                        }
                                        
                                }
                                
                                $style = $data[$total_slug . '_style_' . $rooms];
                                $style_total = 0;
                                foreach($style_data as $temp) {
                                        if( $temp['title'] == $style ) {
                                                
                                                if($style_prices == 'labour') {
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
                                                        $style_total = $labour_and_material_total;
                                                }
                                                elseif($style_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $style_total = $range_price_total;
                                                }
                                                
                                        }
                                }
                                
                                $deck_price_sub = $floor_area * ($foundation_total + $decking_total);
                                $deck_price_sub_percent = $height_total * $deck_price_sub / 100;
                                $deck_finish_price = $deck_price_sub * $finish_total / 100;
                                $deck_pergola_sub = $pergola_area * $style_total;
                                $decking_total_summ = $deck_price_sub + $deck_price_sub_percent + $deck_finish_price + $deck_pergola_sub + $ballustrade_total + $extra_total;
                                $total = $total + $decking_total_summ;
                        
                                $rooms++;        
                        endwhile; 
                        
                }
                
                // formulas for Fencing template
                if(get_the_title($t) == 'Fencing') {
                                
                                
                        $all_scope_data = get_field('quote_fields',$t);
                        $total_slug = get_field('total_slug',$t);
                        $rooms_qnt = $data[$total_slug . '_rooms'];
                        if(empty($rooms_qnt) || $rooms_qnt == NULL || $rooms_qnt == '') {
                                $rooms_qnt = 1;
                        }
                
                        $rooms = 1;
                        while($rooms <= $rooms_qnt) :
                                        
                                
                                $length = $data[$total_slug . '_length_width_' . $rooms];
                                
                                foreach($all_scope_data as $d) {
                                        if($d['slug'] == 'height') {
                                                $height_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'type') {
                                                $fence_type_prices = $d['type_of_price'];
                                                $fence_type_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'painted') {
                                                $painted_prices = $d['type_of_price'];
                                                $painted_data = $d['fields'];
                                        }
                                }
                                
                                $height = $data[$total_slug . '_height_' . $rooms];
                                $height_total = 0;
                                foreach($height_data as $temp) {
                                        if( $temp['title'] == $height ) {
                                                
                                                $range_price_total = $temp['range_price'];
                                                $height_total = $range_price_total;
                                                
                                        }
                                }
                                
                                $area = $length * $height_total;
                                
                                $fence_type = $data[$total_slug . '_type_' . $rooms];
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
                                                        $fence_type_total = $fence_type_total + ($labour_and_material_total * $length);
                                                }
                                                elseif($fence_type_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $fence_type_total = $fence_type_total + ($range_price_total * $length);
                                                }
                                                
                                        }
                                }
                                
                                $fence_type_total = $fence_type_total + ($fence_type_total * $height_total / 100);
                                
                                $painted = $data[$total_slug . '_painted_' . $rooms];
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
                                                        $painted_total = $labour_and_material_total * $length;
                                                }
                                                elseif($painted_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $painted_total = $range_price_total * $length;
                                                }
                                                
                                        }
                                }
                                
                                $fencing_total = $fence_type_total + $painted_total;
                                $total = $total + $fencing_total;
                        
                                $rooms++;        
                        endwhile; 
                        
                }
                
                // formulas for Painting Exterior template
                if(get_the_title($t) == 'Painting Exterior') {
                                
                                
                        $all_scope_data = get_field('quote_fields',$t);
                        $total_slug = get_field('total_slug',$t);
                        $rooms_qnt = $data[$total_slug . '_rooms'];
                        if(empty($rooms_qnt) || $rooms_qnt == NULL || $rooms_qnt == '') {
                                $rooms_qnt = 1;
                        }
                
                        $rooms = 1;
                        while($rooms <= $rooms_qnt) :
                                        
                                
                                $width = $data[$total_slug . '_area_width_' . $rooms];
                                $length = $data[$total_slug . '_area_length_' . $rooms];
                                
                                foreach($all_scope_data as $d) {
                                        if($d['slug'] == 'ceiling') {
                                                $height_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'current') {
                                                $current_prices = $d['type_of_price'];
                                                $current_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'joinerys') {
                                                $windows_and_doors_prices = $d['type_of_price'];
                                                $windows_and_doors_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'trim') {
                                                $trim_prices = $d['type_of_price'];
                                                $trim_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'roof') {
                                                $roof_prices = $d['type_of_price'];
                                                $roof_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'extras') {
                                                $extras_prices = $d['type_of_price'];
                                                $extras_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'paint') {
                                                $paint_prices = $d['type_of_price'];
                                                $paint_data = $d['fields'];
                                        }
                                        
                                }
                                
                                $height = $data[$total_slug . '_ceiling_' . $rooms];
                                $height_total = 0;
                                foreach($height_data as $temp) {
                                        if( $temp['title'] == $height ) {
                                                
                                                $range_price_total = $temp['range_price'];
                                                $height_total = $range_price_total;
                                                
                                        }
                                }
                                
                                $wall_area = ($width + $width + $length + $length) * $height_total;
                                $outer_length = $width + $width + $length + $length;
                                
                                $current = $data[$total_slug . '_current_' . $rooms];
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
                                                
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $current_total = $current_total + ($labour_and_material_total * $wall_area);
                                                }
                                                elseif($current_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $current_total = $current_total + ($range_price_total * $wall_area);
                                                }
                                                
                                        }
                                }
                                
                                $windows_and_doors = $data[$total_slug . '_joinerys_' . $rooms];
                                $windows_and_doors_total = 0;
                                foreach($windows_and_doors_data as $temp) {
                                        if( in_array($temp['title'],$windows_and_doors) ) {
                                                
                                                // let's count QNT of each extra field
                                                $field_title = $temp['title'];
                                                $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                $count_field_title = strtolower($count_field_title);
                                                $extra_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
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
                                                
                                                        $material_and_labour_total = $material_price_total_value + $labour_price_total_value;
                                                        $windows_and_doors_total = $windows_and_doors_total + ( $material_and_labour_total * $extra_count);
                                                }
                                                elseif($windows_and_doors_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $windows_and_doors_total = $windows_and_doors_total + ( $range_price_total * $extra_count);
                                                }
                                                
                                        }
                                        
                                }
                                
                                $trim = $data[$total_slug . '_trim_' . $rooms];
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
                                                
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $trim_total = $trim_total + ($labour_and_material_total * $outer_length);
                                                }
                                                elseif($trim_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $trim_total = $trim_total + ($range_price_total * $outer_length);
                                                }
                                                
                                        }
                                }
                                
                                $roof = $data[$total_slug . '_paint_' . $rooms];
                                $roof_total = 0;
                                foreach($roof_data as $temp) {
                                        if( $temp['title'] == $roof ) {
                                                
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
                                                
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $roof_total = $labour_and_material_total * ($width * $length);
                                                }
                                                elseif($roof_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $roof_total = $range_price_total * ($width * $length);
                                                }
                                                
                                        }
                                }
                                
                                $extras = $data[$total_slug . '_extras_' . $rooms];
                                $extras_total = 0;
                                foreach($extras_data as $temp) {
                                        if( in_array($temp['title'],$extras) ) {
                                                
                                                // let's count QNT of each extra field
                                                $field_title = $temp['title'];
                                                $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                $count_field_title = strtolower($count_field_title);
                                                $extra_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
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
                                                
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $extras_total = $extras_total + ( $labour_and_material_total * $extra_count );
                                                }
                                                elseif($extras_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $extras_total = $extras_total + ( $range_price_total * $extra_count );
                                                }
                                                
                                        }
                                }
                                
                                $paint = $data[$total_slug . '_paint_' . $rooms];
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
                                                
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $paint_details_total = $labour_and_material_total;
                                                }
                                                elseif($paint_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $paint_details_total = $range_price_total;
                                                }
                                                
                                        }
                                }
                                
                                $exterior_total = $current_total + $windows_and_doors_total + $trim_total + $roof_total;
                                $bring_paint = $exterior_total * $paint_details_total / 100;
                                $painting_exterior_total = $exterior_total + $bring_paint + $extras_total;
                                
                                $total = $total + $painting_exterior_total;
                        
                                $rooms++;        
                        endwhile; 
                        
                }
        
                if(get_the_title($t) == 'Price a whole house') {
                                
                                
                        $all_scope_data = get_field('quote_fields',$t);
                        $total_slug = get_field('total_slug',$t);
                        $rooms_qnt = $data[$total_slug . '_rooms'];
                        if(empty($rooms_qnt) || $rooms_qnt == NULL || $rooms_qnt == '') {
                                $rooms_qnt = 1;
                        }
                
                        $rooms = 1;
                        while($rooms <= $rooms_qnt) :
                                        
                                
                                $width = $data[$total_slug . '_area_width_' . $rooms];
                                $length = $data[$total_slug . '_area_length_' . $rooms];
                                
                                foreach($all_scope_data as $d) {
                                        if($d['slug'] == 'ceiling_height') {
                                                $height_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'rooms') {
                                                $p_rooms_prices = $d['type_of_price'];
                                                $p_rooms_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'paint_ceilings') {
                                                $paint_ceilings_prices = $d['type_of_price'];
                                                $paint_ceilings_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'paint') {
                                                $paint_supply_prices = $d['type_of_price'];
                                                $paint_supply_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'doors') {
                                                $extras_prices = $d['type_of_price'];
                                                $extras_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'extras') {
                                                $trim_prices = $d['type_of_price'];
                                                $trim_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'other') {
                                                $other_prices = $d['type_of_price'];
                                                $other_data = $d['fields'];
                                        }
                                        
                                }
                                
                                $height = $data[$total_slug . '_ceiling_height_' . $rooms];
                                $height_total = 0;
                                foreach($height_data as $temp) {
                                        if( $temp['title'] == $height ) {
                                                
                                                $range_price_total = $temp['range_price'];
                                                $height_total = $range_price_total;
                                                
                                        }
                                }
                                
                                $p_rooms = $data[$total_slug . '_rooms_' . $rooms];
                                $p_rooms_total = 0;
                                foreach($p_rooms_data as $temp) {
                                        if( in_array($temp['title'],$p_rooms) ) {
                                                
                                                // let's count QNT of each extra field
                                                $field_title = $temp['title'];
                                                $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                $count_field_title = strtolower($count_field_title);
                                                $extra_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
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
                                                
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $p_rooms_total = $p_rooms_total + ($labour_and_material_total * $extra_count);
                                                }
                                                elseif($p_rooms_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $p_rooms_total = $p_rooms_total + ($range_price_total * $extra_count);
                                                }
                                                
                                        }
                                }
                                
                                $paint_ceilings = $data[$total_slug . '_paint_ceilings_' . $rooms];
                                $paint_ceilings_total = 0;
                                foreach($paint_ceilings_data as $temp) {
                                        if( $temp['title'] == $paint_ceilings ) {
                                                
                                                $range_price_total = $temp['range_price'];
                                                $paint_ceilings_total = $range_price_total;
                                                
                                        }
                                        
                                }
                                
                                $paint_supply = $data[$total_slug . '_paint_' . $rooms];
                                $paint_supply_total = 0;
                                foreach($paint_supply_data as $temp) {
                                        if( $temp['title'] == $paint_supply ) {
                                                
                                                $range_price_total = $temp['range_price'];
                                                $paint_supply_total = $range_price_total;
                                                
                                        }
                                }
                                
                                $extras = $data[$total_slug . '_doors_' . $rooms];
                                $extras_total = 0;
                                foreach($extras_data as $temp) {
                                        if( in_array($temp['title'],$extras) ) {
                                                
                                                // let's count QNT of each extra field
                                                $field_title = $temp['title'];
                                                $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                $count_field_title = strtolower($count_field_title);
                                                $extra_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
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
                                                
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $extras_total = $extras_total + ($labour_and_material_total * $extra_count);
                                                }
                                                elseif($extras_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $extras_total = $extras_total + ($range_price_total * $extra_count);
                                                }
                                                
                                        }
                                }
                                
                                $other = $data[$total_slug . '_other_' . $rooms];
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
                                                
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $other_total = $other_total + $labour_and_material_total;
                                                }
                                                elseif($other_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $other_total = $other_total + $range_price_total;
                                                }
                                                
                                        }
                                }
                                
                                $trim = $data[$total_slug . '_extras_' . $rooms];
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
                                                
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $trim_total = $trim_total + $labour_and_material_total;
                                                }
                                                elseif($trim_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $trim_total = $trim_total + $range_price_total;
                                                }
                                                
                                        }
                                }
                                
                                
                                $percent_total = $height_total + $paint_ceilings_total + $trim_total;
                                $rooms_price_total = $p_rooms_total + ($p_rooms_total * $percent_total / 100) + $other_total + $extras_total;
                                $paint_interior_total = $rooms_price_total + ($rooms_price_total * $paint_supply_total / 100);


                                $total = $total + $paint_interior_total;
                        
                                $rooms++;        
                        endwhile; 
                        
                }
                 
                 
              
                if(get_the_title($t) == 'Price a Room') {
                                
                                
                        $all_scope_data = get_field('quote_fields',$t);
                        $total_slug = get_field('total_slug',$t);
                        $rooms_qnt = $data[$total_slug . '_rooms'];
                        if(empty($rooms_qnt) || $rooms_qnt == NULL || $rooms_qnt == '') {
                                $rooms_qnt = 1;
                        }
                
                        $rooms = 1;
                        while($rooms <= $rooms_qnt) :
                                        
                                
                                $width = $data[$total_slug . '_area_width_' . $rooms];
                                $length = $data[$total_slug . '_area_length_' . $rooms];
                                
                                foreach($all_scope_data as $d) {
                                        if($d['slug'] == 'ceiling_height') {
                                                $height_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'current_walls') {
                                                $current_walls_prices = $d['type_of_price'];
                                                $current_walls_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'wall_prep') {
                                                $wall_prep_prices = $d['type_of_price'];
                                                $wall_prep_data = $d['fields'];
                                        }            
                                        if($d['slug'] == 'new_walls') {
                                                $new_walls_prices = $d['type_of_price'];
                                                $new_walls_data = $d['fields'];
                                        }            
                                        if($d['slug'] == 'current_ceiling') {
                                                $current_ceiling_prices = $d['type_of_price'];
                                                $current_ceiling_data = $d['fields'];
                                        }            
                                        if($d['slug'] == 'ceiling_prep') {
                                                $ceiling_prep_prices = $d['type_of_price'];
                                                $ceiling_prep_data = $d['fields'];
                                        }            
                                        if($d['slug'] == 'new_ceiling') {
                                                $new_ceiling_prices = $d['type_of_price'];
                                                $new_ceiling_data = $d['fields'];
                                        }            
                                        if($d['slug'] == 'doors') {
                                                $doors_prices = $d['type_of_price'];
                                                $doors_data = $d['fields'];
                                        }            
                                        if($d['slug'] == 'trim') {
                                                $trim_prices = $d['type_of_price'];
                                                $trim_data = $d['fields'];
                                        }            
																}
                                
                                $height = $data[$total_slug . '_ceiling_height_' . $rooms];
                                $height_total = 0;
                                foreach($height_data as $temp) {
                                        if( $temp['title'] == $height ) {
                                                
                                                $range_price_total = $temp['range_price'];
                                                $height_total = $range_price_total;
                                                
                                        }
                                }
                                
	                              $wall_area = ( $width + $width + $length + $length ) * $height_total;
                                $ceiling_area = $width * $length;
                                $length = $width + $width + $length + $length;
                    
                                $current_walls = $data[$total_slug . '_current_walls_' . $rooms];
                                $current_walls_total = 0;
                                foreach($current_walls_data as $temp) {
                                        if( in_array($temp['title'],$current_walls) ) {
                                                
                                                // let's count QNT of each extra field
                                                $field_title = $temp['title'];
                                                $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                $count_field_title = strtolower($count_field_title);
                                                $extra_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
                                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                                       $extra_count = 1; 
                                                }
                                                
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
                                                
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $current_walls_total = $current_walls_total + ($labour_and_material_total * $extra_count);
                                                }
                                                elseif($current_walls_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $current_walls_total = $current_walls_total + ($range_price_total * $extra_count);
                                                }
                                                
                                        }
                                }
                               
	                              $wall_prep = $data[$total_slug . '_wall_prep_' . $rooms];
                                $wall_prep_total = 0;
                                foreach($wall_prep_data as $temp) {
                                        if( in_array($temp['title'],$wall_prep) ) {
                                                
                                                // let's count QNT of each extra field
                                                $field_title = $temp['title'];
                                                $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                $count_field_title = strtolower($count_field_title);
                                                $extra_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
                                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                                       $extra_count = 1; 
                                                }
                                                
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
                                                
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $wall_prep_total = $wall_prep_total + ($labour_and_material_total * $extra_count);
                                                }
                                                elseif($wall_prep_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $wall_prep_total = $wall_prep_total + ($range_price_total * $extra_count);
                                                }
                                                
                                        }
                                }
                               
	                              $new_walls = $data[$total_slug . '_new_walls_' . $rooms];
                                $new_walls_total = 0;
                                foreach($new_walls_data as $temp) {
                                        if( in_array($temp['title'],$new_walls) ) {
                                                
                                                // let's count QNT of each extra field
                                                $field_title = $temp['title'];
                                                $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                $count_field_title = strtolower($count_field_title);
                                                $extra_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
                                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                                       $extra_count = 1; 
                                                }
                                                
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
                                                
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $new_walls_total = $new_walls_total + ($labour_and_material_total * $extra_count);
                                                }
                                                elseif($new_walls_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $new_walls_total = $new_walls_total + ($range_price_total * $extra_count);
                                                }
                                                
                                        }
                                }
                               
	                              $current_ceiling = $data[$total_slug . '_current_ceiling_' . $rooms];
                                $current_ceiling_total = 0;
                                foreach($current_ceiling_data as $temp) {
                                        if( in_array($temp['title'],$current_ceiling) ) {
                                                
                                                // let's count QNT of each extra field
                                                $field_title = $temp['title'];
                                                $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                $count_field_title = strtolower($count_field_title);
                                                $extra_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
                                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                                       $extra_count = 1; 
                                                }
                                                
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
                                                
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $current_ceiling_total = $current_ceiling_total + ($labour_and_material_total * $extra_count);
                                                }
                                                elseif($current_ceiling_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $current_ceiling_total = $current_ceiling_total + ($range_price_total * $extra_count);
                                                }
                                                
                                        }
                                }
                               
                                $ceiling_prep = $data[$total_slug . '_ceiling_prep_' . $rooms];
                                $ceiling_prep_total = 0;
                                foreach($ceiling_prep_data as $temp) {
                                        if( in_array($temp['title'],$ceiling_prep) ) {
                                                
                                                // let's count QNT of each extra field
                                                $field_title = $temp['title'];
                                                $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                $count_field_title = strtolower($count_field_title);
                                                $extra_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
                                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                                       $extra_count = 1; 
                                                }
                                                
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
                                                
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $ceiling_prep_total = $ceiling_prep_total + ($labour_and_material_total * $extra_count);
                                                }
                                                elseif($ceiling_prep_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $ceiling_prep_total = $ceiling_prep_total + ($range_price_total * $extra_count);
                                                }
                                                
                                        }
                                }
                               
                                $new_ceiling = $data[$total_slug . '_new_ceiling_' . $rooms];
                                $new_ceiling_total = 0;
                                foreach($new_ceiling_data as $temp) {
                                        if( in_array($temp['title'],$new_ceiling) ) {
                                                
                                                // let's count QNT of each extra field
                                                $field_title = $temp['title'];
                                                $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                $count_field_title = strtolower($count_field_title);
                                                $extra_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
                                                if($extra_count == NULL || $extra_count == '' || empty($extra_count)) {
                                                       $extra_count = 1; 
                                                }
                                                
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
                                                
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $new_ceiling_total = $new_ceiling_total + ($labour_and_material_total * $extra_count);
                                                }
                                                elseif($new_ceiling_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $new_ceiling_total = $new_ceiling_total + ($range_price_total * $extra_count);
                                                }
                                                
                                        }
                                }
                               
	                              $doors = $data[$total_slug . '_doors_' . $rooms];
                                $doors_total = 0;
                                foreach($doors_data as $temp) {
                                        if( in_array($temp['title'],$doors) ) {
                                                
                                                // let's count QNT of each extra field
                                                $field_title = $temp['title'];
                                                $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                $count_field_title = strtolower($count_field_title);
                                                $extra_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
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
                                                
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $doors_total = $doors_total + ($labour_and_material_total * $extra_count);
                                                }
                                                elseif($doors_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $doors_total = $doors_total + ($range_price_total * $extra_count);
                                                }
                                                
                                        }
                                }
                               
                                $trim = $data[$total_slug . '_trim_' . $rooms];
                                $trim_total = 0;
                                foreach($trim_data as $temp) {
                                        if( in_array($temp['title'],$trim) ) {
                                                
                                                // let's count QNT of each extra field
                                                $field_title = $temp['title'];
                                                $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                $count_field_title = strtolower($count_field_title);
                                                $extra_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
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
                                                
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $trim_total = $trim_total + ($labour_and_material_total * $extra_count);
                                                }
                                                elseif($trim_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $trim_total = $trim_total + ($range_price_total * $extra_count);
                                                }
                                                
                                        }
                                }
                               	
	                              $walls_total = ( $current_walls_total + $wall_prep_total + $new_walls_total ) * $wall_area;
                                $ceiling_total = ( $current_ceiling_total + $ceiling_prep_total + $new_ceiling_total ) * $ceiling_area;
                                $trim_total_full =  $trim_total * $length;           
                                $paint_room_total = $walls_total + $ceiling_total + $trim_total_full + $doors_total;


                                $total = $total + $paint_room_total;
                        
                                $rooms++;        
                        endwhile; 
                        
                }
                           
                // formulas for Consultants template
                if(get_the_title($t) == 'Consultants') {
                                
                                
                        $all_scope_data = get_field('quote_fields',$t);
                        $total_slug = get_field('total_slug',$t);
                        $rooms_qnt = $data[$total_slug . '_rooms'];
                        if(empty($rooms_qnt) || $rooms_qnt == NULL || $rooms_qnt == '') {
                                $rooms_qnt = 1;
                        }
                
                        $rooms = 1;
                        while($rooms <= $rooms_qnt) :
                                        
                                foreach($all_scope_data as $d) {
                                        if($d['slug'] == 'consent') {
                                                $consent_prices = $d['type_of_price'];
                                                $consent_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'drafting') {
                                                $drafting_prices = $d['type_of_price'];
                                                $drafting_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'other') {
                                                $other_prices = $d['type_of_price'];
                                                $other_data = $d['fields'];
                                        }
                                }
                                
                                $consent = $data[$total_slug . '_consent_' . $rooms];
                                $consent_total = 0;
                                foreach($consent_data as $temp) {
                                        if( in_array($temp['title'],$consent)  || $temp['title'] == $consent ) {
                                                
                                                // let's count QNT of each extra field
                                                $field_title = $temp['title'];
                                                $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                $count_field_title = strtolower($count_field_title);
                                                $extra_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
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
                                                
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $consent_total = $consent_total + ( $labour_and_material_total * $extra_count );
                                                }
                                                elseif($consent_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $consent_total = $consent_total + ( $range_price_total * $extra_count );
                                                }
                                                
                                        }
                                }
                                
                                $drafting = $data[$total_slug . '_drafting_' . $rooms];
                                $drafting_total = 0;
                                foreach($drafting_data as $temp) {
                                        if( in_array($temp['title'],$drafting) || $temp['title'] == $drafting ) {
                                                
                                                // let's count QNT of each extra field
                                                $field_title = $temp['title'];
                                                $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                $count_field_title = strtolower($count_field_title);
                                                $extra_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
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
                                                
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $drafting_total = $drafting_total + ( $labour_and_material_total * $extra_count );
                                                }
                                                elseif($drafting_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $drafting_total = $drafting_total + ( $range_price_total * $extra_count );
                                                }
                                                
                                        }
                                }
                                
                                $other = $data[$total_slug . '_other_' . $rooms];
                                $other_total = 0;
                                foreach($other_data as $temp) {
                                        if( in_array($temp['title'],$other) || $temp['title'] == $other ) {
                                                
                                                // let's count QNT of each extra field
                                                $field_title = $temp['title'];
                                                $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                $count_field_title = strtolower($count_field_title);
                                                $extra_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
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
                                                
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
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
                        
                                $rooms++;        
                        endwhile; 
                        
                }
                
                // formulas for Flooring template
                if(get_the_title($t) == 'Flooring') {
                                
                                
                        $all_scope_data = get_field('quote_fields',$t);
                        $total_slug = get_field('total_slug',$t);
                        $rooms_qnt = $data[$total_slug . '_rooms'];
                        if(empty($rooms_qnt) || $rooms_qnt == NULL || $rooms_qnt == '') {
                                $rooms_qnt = 1;
                        }
                
                        $rooms = 1;
                        while($rooms <= $rooms_qnt) :
                                
                                $width = $data[$total_slug . '_square_width_' . $rooms];
                                $length = $data[$total_slug . '_square_length_' . $rooms];
                                
                                $area = $width * $length;
                                        
                                foreach($all_scope_data as $d) {
                                        if($d['slug'] == 'current') {
                                                $current_prices = $d['type_of_price'];
                                                $current_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'proposed') {
                                                $proposed_prices = $d['type_of_price'];
                                                $proposed_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'remove') {
                                                $remove_prices = $d['type_of_price'];
                                                $remove_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'extra') {
                                                $extra_prices = $d['type_of_price'];
                                                $extra_data = $d['fields'];
                                        }
                                }
                                
                                $current = $data[$total_slug . '_current_' . $rooms];
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
                                                
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $current_total = $current_total +  ( $labour_and_material_total * $area );
                                                }
                                                elseif($current_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $current_total = $current_total + ( $range_price_total * $area );
                                                }
                                                
                                        }
                                }
                                
                                $proposed = $data[$total_slug . '_proposed_' . $rooms];
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
                                                
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $proposed_total = $proposed_total + ( $labour_and_material_total * $area );
                                                }
                                                elseif($proposed_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $proposed_total = $proposed_total + ( $range_price_total * $area );
                                                }
                                                
                                        }
                                }
                                
                                $remove = $data[$total_slug . '_remove_' . $rooms];
                                
                                $extra = $data[$total_slug . '_extra_' . $rooms];
                                $extra_total = 0;
                                foreach($extra_data as $temp) {
                                        if( in_array($temp['title'],$extra) || $temp['title'] == $extra ) {
                                                
                                                // let's count QNT of each extra field
                                                $field_title = $temp['title'];
                                                $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                $count_field_title = strtolower($count_field_title);
                                                $extra_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
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
                        
                                $rooms++;        
                        endwhile; 
                        
                }
                
                // formulas for Roofing template
                if(get_the_title($t) == 'Roofing') {
                                
                                
                        $all_scope_data = get_field('quote_fields',$t);
                        $total_slug = get_field('total_slug',$t);
                        $rooms_qnt = $data[$total_slug . '_rooms'];
                        if(empty($rooms_qnt) || $rooms_qnt == NULL || $rooms_qnt == '') {
                                $rooms_qnt = 1;
                        }
                
                        $rooms = 1;
                        while($rooms <= $rooms_qnt) :
                                
                                $width = $data[$total_slug . '_area_width_' . $rooms];
                                $length = $data[$total_slug . '_area_length_' . $rooms];
                                
                                $area = $width * $length;
                                $outer_length = $width + $width + $length + $length;
                                $demolition = $data[$total_slug . '_demolition_' . $rooms];
                                        
                                foreach($all_scope_data as $d) {
                                        if($d['slug'] == 'slope') {
                                                $roof_pitch_prices = $d['type_of_price'];
                                                $roof_pitch_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'current') {
                                                $current_prices = $d['type_of_price'];
                                                $current_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'complex') {
                                                $complex_prices = $d['type_of_price'];
                                                $complex_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'material') {
                                                $material_prices = $d['type_of_price'];
                                                $material_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'gutter') {
                                                $gutter_prices = $d['type_of_price'];
                                                $gutter_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'misc') {
                                                $misc_prices = $d['type_of_price'];
                                                $misc_data = $d['fields'];
                                        }
                                }
                                
                                $current = $data[$total_slug . '_current_' . $rooms];
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
                                                
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $current_total = $current_total +  ( $labour_and_material_total * $area );
                                                }
                                                elseif($current_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $current_total = $current_total + ( $range_price_total * $area );
                                                }
                                                
                                        }
                                }
                                
                                $roof_pitch = $data[$total_slug . '_slope_' . $rooms];
                                $roof_pitch_total = 0;
                                foreach($roof_pitch_data as $temp) {
                                        if( in_array($temp['title'],$roof_pitch)  || $temp['title'] == $roof_pitch ) {
                                                
                                                $range_price_total = $temp['range_price'];
                                                $roof_pitch_total = $range_price_total;
                                                
                                        }
                                }
                                
                                $complex = $data[$total_slug . '_complex_' . $rooms];
                                $complex_total = 0;
                                foreach($complex_data as $temp) {
                                        if( in_array($temp['title'],$complex)  || $temp['title'] == $complex ) {
                                                
                                                $range_price_total = $temp['range_price'];
                                                $complex_total = $range_price_total;
                                                
                                        }
                                }
                               
                                $material = $data[$total_slug . '_material_' . $rooms];
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
                                                
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $material_total = $material_total +  ( $labour_and_material_total * $area );
                                                }
                                                elseif($material_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $material_total = $material_total + ( $range_price_total * $area );
                                                }
                                                
                                        }
                                }
                                
                                $gutter = $data[$total_slug . '_gutter_' . $rooms];
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
                                                
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $gutter_total = $gutter_total +  ( $labour_and_material_total * $outer_length );
                                                }
                                                elseif($gutter_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $gutter_total = $gutter_total + ( $range_price_total * $outer_length );
                                                }
                                                
                                        }
                                }
                                
                                $misc = $data[$total_slug . '_misc_' . $rooms];
                                $misc_total = 0;
                                foreach($misc_data as $temp) {
                                        if( in_array($temp['title'],$misc) || $temp['title'] == $misc ) {
                                                
                                                // let's count QNT of each extra field
                                                $field_title = $temp['title'];
                                                $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                $count_field_title = strtolower($count_field_title);
                                                $extra_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
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
                                        
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
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
                        
                                $rooms++;        
                        endwhile; 
                        
                }
                
                // formulas for General Building template
                if(get_the_title($t) == 'General Building') {
                                  
                        $all_scope_data = get_field('quote_fields',$t);
                        $total_slug = get_field('total_slug',$t);
                        $rooms_qnt = $data[$total_slug . '_rooms'];
                        if(empty($rooms_qnt) || $rooms_qnt == NULL || $rooms_qnt == '') {
                                $rooms_qnt = 1;
                        }
                
                        $rooms = 1;
                        while($rooms <= $rooms_qnt) :
                                
                                foreach($all_scope_data as $d) {
                                        if($d['slug'] == 'general') {
                                                $general_prices = $d['type_of_price'];
                                                $general_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'demo') {
                                                $demo_prices = $d['type_of_price'];
                                                $demo_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'doors') {
                                                $doors_prices = $d['type_of_price'];
                                                $doors_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'windows') {
                                                $windows_prices = $d['type_of_price'];
                                                $windows_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'trim') {
                                                $trim_prices = $d['type_of_price'];
                                                $trim_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'misc') {
                                                $misc_prices = $d['type_of_price'];
                                                $misc_data = $d['fields'];
                                        }
                                }
                                
                                $general = $data[$total_slug . '_general_' . $rooms];
                                $general_total = 0;
                                foreach($general_data as $temp) {
                                        if( in_array($temp['title'],$general) || $temp['title'] == $general ) {
                                                
                                                // let's count QNT of each extra field
                                                $field_title = $temp['title'];
                                                $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                $count_field_title = strtolower($count_field_title);
                                                $extra_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
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
                                        
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $general_total = $general_total + ( $labour_and_material_total * $extra_count );
                                                }
                                                elseif($general_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $general_total = $general_total + ( $range_price_total * $extra_count );
                                                }
                                        
                                        }
                                }
                                
                                $demo = $data[$total_slug . '_demo_' . $rooms];
                                $demo_total = 0;
                                foreach($demo_data as $temp) {
                                        if( in_array($temp['title'],$demo) || $temp['title'] == $demo ) {
                                                
                                                // let's count QNT of each extra field
                                                $field_title = $temp['title'];
                                                $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                $count_field_title = strtolower($count_field_title);
                                                $extra_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
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
                                        
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $demo_total = $demo_total + ( $labour_and_material_total * $extra_count );
                                                }
                                                elseif($demo_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $demo_total = $demo_total + ( $range_price_total * $extra_count );
                                                }
                                        
                                        }
                                }
                                
                                $doors = $data[$total_slug . '_doors_' . $rooms];
                                $doors_total = 0;
                                foreach($doors_data as $temp) {
                                        if( in_array($temp['title'],$doors) || $temp['title'] == $doors ) {
                                                
                                                // let's count QNT of each extra field
                                                $field_title = $temp['title'];
                                                $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                $count_field_title = strtolower($count_field_title);
                                                $extra_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
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
                                        
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $doors_total = $doors_total + ( $labour_and_material_total * $extra_count );
                                                }
                                                elseif($doors_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $doors_total = $doors_total + ( $range_price_total * $extra_count );
                                                }
                                        
                                        }
                                }
                                
                                $windows = $data[$total_slug . '_windows_' . $rooms];
                                $windows_total = 0;
                                foreach($windows_data as $temp) {
                                        if( in_array($temp['title'],$windows) || $temp['title'] == $windows ) {
                                                
                                                // let's count QNT of each extra field
                                                $field_title = $temp['title'];
                                                $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                $count_field_title = strtolower($count_field_title);
                                                $extra_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
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
                                        
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $windows_total = $windows_total + ( $labour_and_material_total * $extra_count );
                                                }
                                                elseif($windows_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $windows_total = $windows_total + ( $range_price_total * $extra_count );
                                                }
                                        
                                        }
                                }
                                
                                $trim = $data[$total_slug . '_trim_' . $rooms];
                                $trim_total = 0;
                                foreach($trim_data as $temp) {
                                        if( in_array($temp['title'],$trim) || $temp['title'] == $trim ) {
                                                
                                                // let's count QNT of each extra field
                                                $field_title = $temp['title'];
                                                $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                $count_field_title = strtolower($count_field_title);
                                                $extra_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
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
                                        
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $trim_total = $trim_total + ( $labour_and_material_total * $extra_count );
                                                }
                                                elseif($trim_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $trim_total = $trim_total + ( $range_price_total * $extra_count );
                                                }
                                        
                                        }
                                }
                                
                                $misc = $data[$total_slug . '_misc_' . $rooms];
                                $misc_total = 0;
                                foreach($misc_data as $temp) {
                                        if( in_array($temp['title'],$misc) || $temp['title'] == $misc ) {
                                                
                                                // let's count QNT of each extra field
                                                $field_title = $temp['title'];
                                                $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                $count_field_title = strtolower($count_field_title);
                                                $extra_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
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
                                        
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
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
                        
                                $rooms++;        
                        endwhile; 
                        
                }
                
                // formulas for Plumbing & Gasfitting template
                if(get_the_title($t) == 'Plumbing and Gasfitting') {       
                                  
                        $all_scope_data = get_field('quote_fields',$t);
                        $total_slug = get_field('total_slug',$t);
                        $rooms_qnt = $data[$total_slug . '_rooms'];
                        if(empty($rooms_qnt) || $rooms_qnt == NULL || $rooms_qnt == '') {
                                $rooms_qnt = 1;
                        }
                
                        $rooms = 1;
                        while($rooms <= $rooms_qnt) :
                                
                                foreach($all_scope_data as $d) {
                                        if($d['slug'] == 'type') {
                                                $type_prices = $d['type_of_price'];
                                                $type_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'fixtures') {
                                                $fixtures_prices = $d['type_of_price'];
                                                $fixtures_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'gas') {
                                                $gas_prices = $d['type_of_price'];
                                                $gas_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'maintain') {
                                                $maintain_prices = $d['type_of_price'];
                                                $maintain_data = $d['fields'];
                                        }
                                }
                                
                                $type = $data[$total_slug . '_type_' . $rooms];
                                $type_total = 100;
                                foreach($type_data as $temp) {
                                        if( in_array($temp['title'],$type) || $temp['title'] == $type ) {
                                                
                                                // let's count QNT of each extra field
                                                $field_title = $temp['title'];
                                                $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                $count_field_title = strtolower($count_field_title);
                                                $extra_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
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
                                        
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $type_total = $type_total + ( $labour_and_material_total * $extra_count );
                                                }
                                                elseif($type_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $type_total = $type_total + ( $range_price_total * $extra_count );
                                                }
                                        
                                        }
                                }
                                
                                $fixtures = $data[$total_slug . '_fixtures_' . $rooms];
                                $fixtures_total = 0;
                                foreach($fixtures_data as $temp) {
                                        if( in_array($temp['title'],$fixtures) || $temp['title'] == $fixtures ) {
                                                
                                                // let's count QNT of each extra field
                                                $field_title = $temp['title'];
                                                $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                $count_field_title = strtolower($count_field_title);
                                                $extra_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
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
                                        
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $fixtures_total = $fixtures_total + ( $labour_and_material_total * $extra_count );
                                                }
                                                elseif($fixtures_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $fixtures_total = $fixtures_total + ( $range_price_total * $extra_count );
                                                }
                                        
                                        }
                                }
                                
                                $gas = $data[$total_slug . '_gas_' . $rooms];
                                $gas_total = 0;
                                foreach($gas_data as $temp) {
                                        if( in_array($temp['title'],$gas) || $temp['title'] == $gas ) {
                                                
                                                // let's count QNT of each extra field
                                                $field_title = $temp['title'];
                                                $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                $count_field_title = strtolower($count_field_title);
                                                $extra_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
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
                                        
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $gas_total = $gas_total + ( $labour_and_material_total * $extra_count );
                                                }
                                                elseif($gas_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $gas_total = $gas_total + ( $range_price_total * $extra_count );
                                                }
                                        
                                        }
                                }
                                
                                $maintain = $data[$total_slug . '_maintain_' . $rooms];
                                $maintain_total = 0;
                                foreach($maintain_data as $temp) {
                                        if( in_array($temp['title'],$maintain) || $temp['title'] == $maintain ) {
                                                
                                                // let's count QNT of each extra field
                                                $field_title = $temp['title'];
                                                $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                $count_field_title = strtolower($count_field_title);
                                                $extra_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
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
                                        
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
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
                        
                                $rooms++;        
                        endwhile; 
                        
                }
                
                // formulas for Electrical template
                if(get_the_title($t) == 'Electrical') {
                                  
                        $all_scope_data = get_field('quote_fields',$t);
                        $total_slug = get_field('total_slug',$t);
                        $rooms_qnt = $data[$total_slug . '_rooms'];
                        if(empty($rooms_qnt) || $rooms_qnt == NULL || $rooms_qnt == '') {
                                $rooms_qnt = 1;
                        }
                
                        $rooms = 1;
                        while($rooms <= $rooms_qnt) :
                                
                                foreach($all_scope_data as $d) {
                                        if($d['slug'] == 'type_install') {
                                                $type_install_prices = $d['type_of_price'];
                                                $type_install_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'power') {
                                                $power_prices = $d['type_of_price'];
                                                $power_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'light') {
                                                $light_prices = $d['type_of_price'];
                                                $light_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'advanced') {
                                                $advanced_prices = $d['type_of_price'];
                                                $advanced_data = $d['fields'];
                                        }
                                        if($d['slug'] == 'heat') {
                                                $heat_prices = $d['type_of_price'];
                                                $heat_data = $d['fields'];
                                        }
                                }
                                
                                $type_install = $data[$total_slug . '_type_install_' . $rooms];
                                $type_install_total = 0;
                                foreach($type_install_data as $temp) {
                                        if( in_array($temp['title'],$type_install) || $temp['title'] == $type_install ) {
                                                
                                                // let's count QNT of each extra field
                                                $field_title = $temp['title'];
                                                $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                $count_field_title = strtolower($count_field_title);
                                                $extra_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
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
                                        
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $type_install_total = $type_install_total + ( $labour_and_material_total * $extra_count );
                                                }
                                                elseif($type_install_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $type_install_total = $type_install_total + ( $range_price_total * $extra_count );
                                                }
                                        
                                        }
                                }
                                
                                $power = $data[$total_slug . '_power_' . $rooms];
                                $power_total = 0;
                                foreach($power_data as $temp) {
                                        if( in_array($temp['title'],$power) || $temp['title'] == $power ) {
                                                
                                                // let's count QNT of each extra field
                                                $field_title = $temp['title'];
                                                $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                $count_field_title = strtolower($count_field_title);
                                                $extra_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
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
                                        
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $power_total = $power_total + ( $labour_and_material_total * $extra_count );
                                                }
                                                elseif($power_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $power_total = $power_total + ( $range_price_total * $extra_count );
                                                }
                                        
                                        }
                                }
                                
                                $light = $data[$total_slug . '_light_' . $rooms];
                                $light_total = 0;
                                foreach($light_data as $temp) {
                                        if( in_array($temp['title'],$light) || $temp['title'] == $light ) {
                                                
                                                // let's count QNT of each extra field
                                                $field_title = $temp['title'];
                                                $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                $count_field_title = strtolower($count_field_title);
                                                $extra_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
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
                                        
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $light_total = $light_total + ( $labour_and_material_total * $extra_count );
                                                }
                                                elseif($light_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $light_total = $light_total + ( $range_price_total * $extra_count );
                                                }
                                        
                                        }
                                }
                                
                                $advanced = $data[$total_slug . '_advanced_' . $rooms];
                                $advanced_total = 0;
                                foreach($advanced_data as $temp) {
                                        if( in_array($temp['title'],$advanced) || $temp['title'] == $advanced ) {
                                                
                                                // let's count QNT of each extra field
                                                $field_title = $temp['title'];
                                                $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                $count_field_title = strtolower($count_field_title);
                                                $extra_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
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
                                        
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
                                                        $advanced_total = $advanced_total + ( $labour_and_material_total * $extra_count );
                                                }
                                                elseif($advanced_prices == 'range') {
                                                        $range_price_total = $temp['range_price'];
                                                        $advanced_total = $advanced_total + ( $range_price_total * $extra_count );
                                                }
                                        
                                        }
                                }
                                
                                $heat = $data[$total_slug . '_heat_' . $rooms];
                                $heat_total = 0;
                                foreach($heat_data as $temp) {
                                        if( in_array($temp['title'],$heat) || $temp['title'] == $heat ) {
                                                
                                                // let's count QNT of each extra field
                                                $field_title = $temp['title'];
                                                $count_field_title = preg_replace("/[^a-zA-Z]/", "", $field_title);
                                                $count_field_title = strtolower($count_field_title);
                                                $extra_count = $data[$total_slug . '_' . $count_field_title . '_' . $rooms];
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
                                        
                                                        $labour_and_material_total = $material_price_total_value + $labour_price_total_value;
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
                        
                                $rooms++;        
                        endwhile; 
                        
                }
                
                
                
                
        }
  
  
        
        $object->height = $height_total;
        $object->fence = $fence_type_total;
        $object->painted = $painted_total;
        $object->area = $area;

        $object->total = $total;
        
        return $object;
}
        
?>