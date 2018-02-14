<?php
require_once( ABSPATH . 'wp-load.php');
// getting Current User ID
$current_user_id = current_user_id();
// get project infos
$quote_id = get_the_ID();
$template_id = get_field('templates');
?>

<div class="full_proposal_view">

         <div class="page-invoice-table table-responsive">
                                                <table class="table text-right">
                                                        
                                                        <tbody>



        <?php if(get_field('full_proposal',$quote_id)) : ?>
                <?php $editor = get_field('full_proposal',$quote_id); ?>
        <?php else : ?>
        <?php
        $scope_details = go_scope_details($t,$quote_id);
        $template_id = get_field('templates');
        $editor = "";

        foreach($template_id as $t) {

                $editor .= "<tr><td><h4>" . get_the_title($t) . "</h4></td></tr>";

                $quote_fields = get_field('quote_fields',$t);
                //print_r($quote_fields);

                $count = count($scope_details);
                foreach($scope_details as $s) {
                        $room = $s['room'];
                        $details = $s['details'];
                        if($count > 1) {
                                $editor .= "<tr><td><h4>" . $room . "</h4></td></tr>";
                        }

                        foreach($details as $d) {
                                $section_title = $d['section_title'];
                                $section_details = $d['section_values'];
                                $section_type = $d['section_type'];

                                if($section_type == 'flds') {
                                        $editor .= "<tr class='active'><td class='text-center'><h5>" . $section_title . "</h5></td></tr>";
                                        if(is_array($section_details)) {
                                                $s_title = preg_replace("/[^a-zA-Z]/", "", $section_title);
                                                $s_title = strtolower($s_title);
                                                foreach($section_details as $v) {
                                                        $title_flat = strpos($v, " x") ? substr($v, 0, strpos($v, " x")) : $v;
                                                        if($v != null) {
                                                                $v_link = preg_replace("/[^a-zA-Z]/", "", $title_flat);
                                                                $v_link = strtolower($v_link);
                                                                $editor .= "<tr><td class='text-center'><strong>" . $v . "</strong></td>";

                                                                // looking for description
                                                                $count = count($quote_fields);
                                                                $i=1;
                                                                while($i <= $count) {
                                                                        if($quote_fields[$i]['title'] == $section_title) {
                                                                                foreach($quote_fields[$i]['fields'] as $field) {
                                                                                        if($field['title'] == $title_flat) {
                                                                                                if($field['description'] != '') {
                                                                                                        $editor .= "<td class='text-left'><em>" . $field['description'] . "</em></td>";
                                                                                                }
                                                                                                else {
                                                                                                        $editor .= "<td class='text-left'><em>N/A</em></td></tr>";
                                                                                                }

                                                                                        }
                                                                                }
                                                                        }
                                                                        $i++;
                                                                }

                                                        }
                                                        else {
                                                                $editor .= " ";
                                                        }

                                                }
                                        }
                                        else {
                                                $editor .= "<tr class='active'><td class='text-center'><strong>" . $section_details . "</strong></td>";
                                                // looking for description
                                                $count = count($quote_fields);
                                                $i=1;
                                                while($i <= $count) {
                                                        if($quote_fields[$i]['title'] == $section_title) {

                                                                foreach($quote_fields[$i]['fields'] as $field) {
                                                                        if($field['title'] == $section_details) {
                                                                                if($field['description'] != '') {
                                                                                        $editor .= "<td><em>" . $field['description'] . "</em><td>";
                                                                                }
                                                                                else {
                                                                                        $editor .= "<td><em>N/A</em></td></tr>";
                                                                                }
                                                                        }
                                                                }
                                                        }
                                                        $i++;
                                                }
                                        }

                                }

                        }

                }

        }

        ?>
        <?php endif; ?>


        <?php echo $editor; ?>

                     </tbody>
                                                </table>
                                        </div>


</div>
