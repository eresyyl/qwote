<?php
require_once( ABSPATH . 'wp-load.php');
// getting Current User ID
$current_user_id = current_user_id();
// get project infos
$quote_id = get_the_ID();
$template_id = get_field('templates');
?>


<style>
.scope_popups a:hover{
        text-decoration:none;
        border-bottom:0;
}
.scope_popups a:hover span{
        background:#E0E0E0;
        border:none;
        text-decoration:none;

}
</style>

<?php
/*
foreach($template_id as $t) {
        $quote_fields = get_field('quote_fields',$t);
        $scope_details = go_scope_details($t,$quote_id);

        echo "<h3 style='padding-bottom:20px;'>" . get_the_title($t) . "</h3>";

        $count = count($scope_details);
        foreach($scope_details as $s) {
                $room = $s['room'];
                $details = $s['details'];
                if($count > 1) {
                        echo "<div class='margin-bottom-20'><h4>" . $room . "</h4></div>";
                }

                foreach($details as $d) {
                        $section_title = $d['section_title'];
                        $section_details = $d['section_values'];
                        $section_type = $d['section_type'];

                        if($section_type == 'flds') {
                                echo "<div class='margin-bottom-20 scope_popups'>";
                                echo "<h5>" . $section_title . "</h5>";
                                if(is_array($section_details)) {
                                        $s_title = preg_replace("/[^a-zA-Z]/", "", $section_title);
        				                        $s_title = strtolower($s_title);
                                        foreach($section_details as $v) {
                                                $title_flat = strpos($v, " x") ? substr($v, 0, strpos($v, " x")) : $v;
                                                if($v != null) {
                                                        $v_link = preg_replace("/[^a-zA-Z]/", "", $title_flat);
                        				                        $v_link = strtolower($v_link);
                                                        echo "<p><a style='cursor:pointer' data-target='#" . $s_title . "_" . $v_link . "' data-toggle='modal'><span class='label label-default margin-right-5'>" . $v . "</span></a></p>";
                                                }
                                                else {
                                                        echo "<span class='label label-dark margin-right-5'>Not set</span>";
                                                }
                                        }
                                }
                                else {
                                        echo "<a style='cursor:pointer' data-target='#" . $s_title . "_" . $v_link . "' data-toggle='modal'><span class='label label-default margin-right-5'><span class='label label-default margin-right-5'>" . $section_details . "</span></a>";
                                }
                                echo "</div>";

                                foreach($quote_fields as $field) {
                                        if($field['title'] == $section_title) {

                                                $s_title = preg_replace("/[^a-zA-Z]/", "", $section_title);
                				 $s_title = strtolower($s_title);

                                                $labour_material = $field['type_of_price'];
                                                if($labour_material == 'labour') {
                                                        $labour_material = true;
                                                }
                                                else {
                                                       $labour_material = false;
                                                }
                                                foreach($field['fields'] as $f) {
                                                        $v_link = preg_replace("/[^a-zA-Z]/", "", $f['title']);
                        				                        $v_link = strtolower($v_link);
                                                        if($f['description'] != '') {
                                                                $dsc = $f['description'];
                                                        }
                                                        else {
                                                                $dsc = " ";
                                                        }
                                                        echo "<div class='modal fade' id='" . $s_title . "_" . $v_link . "' aria-hidden='true' aria-labelledby='" . $s_title . "_" . $v_link . "' role='dialog' tabindex='-1'>
                                                        <div class='modal-dialog modal-center'>
                                                                <div class='modal-content'>
                                                                        <div class='modal-header text-center'>
                                                                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                                                        <span aria-hidden='true'>×</span>
                                                                                </button>
                                                                                <h4 class='modal-title'>" . $section_title . ": " . $f['title'] . "</h4>
                                                                                <p>" . $dsc . "</p>";
                                                                if(is_headcontractor() && $labour_material == true) {
                                                                        echo "<h4 class='modal-title'>Labour and Material</h4>";
                                                                        $labour = $f['labour'];
                                                                        $material = $f['material'];

                                                                        if(is_array($labour) || is_array($material)) {
                                                                                echo "<div class='margin-top-10'><b>Labour</b></div>";
                                                                                foreach($labour as $l) {
                                                                                        echo "<div class='margin-vertical-5'>";
                                                                                        echo "<b>" . $l['title']  . ":</b> $" . $l['price'];
                                                                                        // if($l['description']) {
                                                                                        //        echo "<p>" . $l['description'] . "</p>";
                                                                                        // }
                                                                                        echo "</div>";
                                                                                }
                                                                                echo "<div class='margin-top-20'><b>Material</b></div>";
                                                                                foreach($material as $m) {
                                                                                        echo "<div class='margin-vertical-5'>";
                                                                                        echo "<b>" . $m['title']  . ":</b> $" . $m['price'];
                                                                                        // if($m['description']) {
                                                                                        //        echo "<p>" . $m['description'] . "</p>";
                                                                                        // }
                                                                                        echo "</div>";
                                                                                }
                                                                        }
                                                                        else {
                                                                                echo "<p>No Labour and material info.</p>";
                                                                        }
                                                                }
                                                        echo "</div>
                                                                </div>
                                                        </div>
                                                </div>";
                                                }
                                        }
                                }
                        }

                }

        }


}

?>
                <?php include('full_proposal_view.php'); ?>


<?php if(get_field('contract')) : ?>
        <?php the_field('contract'); ?>
<?php else : ?>

        <?php //the_field('proposal','options'); ?>
<?php endif; ?>
