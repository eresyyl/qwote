<?php
/*
Template Name: Quote Edit
*/
?>
<?php 
$quote_id = $_GET['quote_id'];
if(is_contractor()) {
        wp_redirect(home_url() . "/dash");
        die;
}
if($quote_id == '') {
        wp_redirect(home_url() . "/dash");
        die;
}

$client_id = get_field('client_id',$quote_id);
if($client_id[0] == NULL) {
        $client_id = $client_id['ID'];
}
else {
        $client_id = $client_id[0];
}
$client = go_userdata($client_id);
$templates = get_field('templates',$quote_id);
$scope_array = get_field('quote_array',$quote_id);
if(!is_array($scope_array)) {
        $scope_array = json_decode($scope_array,true);
}

$client_string = get_field('client','options');

?>
<?php get_header(); ?>

<!-- Page -->
<div class="page">
        <div class="page-content padding-30 container-fluid">
              
					
                <div class="page-header text-center">
                        <h1 class="page-title"><?php the_title(); ?></h1>
                        <p class="page-description">
                                <?php the_field('sub_title'); ?>
                        </p>
									<div class="row">
                     <div class="col-md-6 col-xs-12 col-md-offset-3">
                             <div class="widget widget-shadow">
                                     <div class="widget-header padding-10 bg-grey-100">
                                             <a class="avatar avatar-lg pull-left margin-right-20" href="javascript:void(0)">
                                                     <img src="<?php echo $client->avatar; ?>" alt="">
                                             </a>
                                             <div class="vertical-align text-right height-80 text-truncate">
                                                     <div class="vertical-align-middle">
                                                             <div class="font-size-16 margin-bottom-5 blue-600 text-truncate"><?php echo $client->first_name; ?> <?php echo $client->last_name; ?><br/><?php echo $client->phone; ?><br/><?php echo $client->email; ?></div>
                                                             <div class="font-size-12 text-truncate"><?php echo $client_string; ?> <?php if($client_approved == true) { echo "<span class='green-600'>(approved)</span>"; } else { echo "<span class='grey-400'>(not approved yet)</span>"; } ?></div>
                                                     </div>
                                             </div>
                                     </div>
                             </div>
                     </div>
                </div>
	  
                <form id="edit_quote">
                <input type="hidden" name="quote_id" value="<?php echo $quote_id; ?>">
                <?php foreach( $templates as $t ) { echo "<input type='hidden' name='templates[]' value='" . $t . "'>"; } ?>
                <div class="panel">
                        <div class="panel-body">
			  
                                <div class="row text-center">
                                        <?php foreach($templates as $t) : 
                                                $total_slug = get_field('total_slug',$t);
                                                $rooms_count = $scope_array[$total_slug . '_rooms'];
                                                ?>
                                                <div class="template_show margin-bottom-20 margin-horizontal-15" data-template="<?php echo $t; ?>" data-quote="<?php echo $quote_id; ?>">
                                                        <img src="<?php the_field('template_image',$t); ?>">
                                                        <div class="text-center"><strong><?php echo get_the_title($t); ?></strong> <span class="label label-default">x<?php echo $rooms_count; ?></span></div>
                                                </div>
                                        <?php endforeach; ?>
                                </div>
			
                        </div>
                </div>
                
                <form id="scope_edit">
                
                <?php foreach( $templates as $t ) : 
                        $total_slug = get_field('total_slug',$t);
                        $rooms_qnt = $scope_array[$total_slug . '_rooms'];
                ?>
                
                <div class="panel">
                        <div class="panel-body">
                                
                                <div><h1 class="text-center margin-bottom-40"><?php echo get_the_title($t); ?></h1></div>
                                
                                <input type='hidden' name='<?php echo $total_slug; ?>_rooms' value='<?php echo $rooms_qnt; ?>'>
                                
                                <?php
                        	$rooms = 1;
                        	while($rooms <= $rooms_qnt) :
                        	$label = get_field('name_single',$t);
                        	if($rooms_qnt > 1) { echo "<h3 class='text-center margin-bottom-40'>". $label . " : " . $rooms . "</h3>"; }
	
                        	if( have_rows('quote_fields',$t) ) {
		
                        		while ( have_rows('quote_fields',$t) ) : the_row();
			
			
                        			// checking if this template has Width and Height rows
                        			if( get_row_layout() == 'width_and_height' ) {
                        				echo "<div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>" . get_sub_field('title') . "</h4><div class='text-center'>" . get_sub_field('description') . "</div>";
                        				echo "<div class='row'><div class='col-md-6 col-md-offset-3'><div class='row'>";
                        				echo "<div class='col-md-6 text-center'><div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>Width (approx.), m.</h4><div class='form-group text-center'>";
                                                        $temp = null;
                                                        $temp = $scope_array[$total_slug . '_' . get_sub_field('slug') . '_width_' . $rooms];
                        				echo "<input type='number' class='form-control' name='" . $total_slug . "_" . get_sub_field('slug') . "_width_" . $rooms . "' min='1' value='" . $temp . "'>";
                        				echo "</div></div>";
                        				echo "<div class='col-md-6 text-center'><div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>Length (approx.), m.</h4><div class='form-group text-center'>";
                                                        $temp = null;
                                                        $temp = $scope_array[$total_slug . '_' . get_sub_field('slug') . '_length_' . $rooms];
                        				echo "<input type='number' class='form-control' name='" . $total_slug . "_" . get_sub_field('slug') . "_length_" . $rooms . "' min='1' value='" . $temp . "'>";
                        				echo "</div></div>";
                        				echo "</div></div></div>";
                        			}
			
                        		        // checking if this template has Width and Height rows
                        			if( get_row_layout() == 'length' ) {
                        				echo "<div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>" . get_sub_field('title') . "</h4><div class='text-center'>" . get_sub_field('description') . "</div>";
                        				echo "<div class='row'><div class='col-md-12'><div class='row'>";
                        				echo "<div class='col-md-6 col-offset-3 text-center'><div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>Length (approx.), m.</h4><div class='form-group text-center'>";
                                                        $temp = null;
                                                        $temp = $scope_array[$total_slug . '_' . get_sub_field('slug') . '_width_' . $rooms];
                        				echo "<input type='number' class='form-control' name='" . $total_slug . "_" . get_sub_field('slug') . "_width_" . $rooms . "' min='1' value='" . $temp . "'>";
                        				echo "</div></div>";
                        				echo "</div></div></div>";
                        			}
		
                        			// checking if this template has Image radio or checkbox rows
                        			if( get_row_layout() == 'fields' ) {
                        				$slug = get_sub_field('slug');
                        				$type = get_sub_field('type_of_fields');
                                                        
                        				if($type == "Checkbox") { $type = 'checkbox'; $type_array = '[]'; }
                        				elseif($type == "Radio") { $type = 'radio'; $type_array = ''; }
                        				echo "<div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>" . get_sub_field('title') . "</h4><div class='text-center'>" . get_sub_field('description') . "</div><div class='form-group text-center'>";
                                                        
                                                        $temp = null;
                                                        $temp = $scope_array[$total_slug . "_" . $slug . "_" . $rooms];
                                
                        				$i=0;	
                        				while(has_sub_field('fields')) :
                        					$qnt = get_sub_field('quantity');
                        					$value = get_sub_field('title');
                                                                $value_string = get_sub_field('title');
                        					$value = preg_replace("/[^a-zA-Z]/", "", $value);
                        				        $tooltip = get_sub_field('tooltip');
                        					$value = strtolower($value);
                                                                
                                                                if(is_array($temp) && in_array($value_string,$temp)) {
                                                                        $temp_selected = 'checked';
                                                                }
                                                                elseif($value_string == $temp) {
                                                                        $temp_selected = 'checked';
                                                                }
                                                                else {
                                                                       $temp_selected = ''; 
                                                                }
                                                                
                        					echo "<label class='styled_in_ajax'>";
                                                                echo "<input class='chr' type='" . $type . "' data-toggle='tooltip' data-placement='top' data-original-title='" . $tooltip . "' title name='" . $total_slug . "_" . $slug . "_" . $rooms . $type_array . "' value=\"" . $value_string . "\" " . $temp_selected . ">";
                        					echo "<img src=" . get_sub_field('image') . ">";
                        					echo "<span>" . get_sub_field('title') . "</span>";
                        					if($qnt == true) {
                                                                        $qnt_of_field = 0; $qnt_of_field = $scope_array[$total_slug . "_" . $value . "_" . $rooms];
                        						echo "<input class='qnt' type='number' name='" . $total_slug . "_" . $value . "_" . $rooms . "' id='" . $total_slug . "_" . $value . "_" . $rooms . "' min='1' step='1' value='" . $qnt_of_field . "'>";
                        					}
                        					echo "</label>";
                        				$i++;	
                        				endwhile;
				
                        				echo "</div>";
                        			}
			
			
                        			// checking if this template has Note
                        			if( get_row_layout() == 'additional_notes' ) {
                        				echo "<div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>" . get_sub_field('title') . "</h4><div class='text-center'>" . get_sub_field('description') . "</div>";
                        				echo "<div class='row'><div class='col-md-6 col-md-offset-3'><div class='row'>";
                        				echo "<div class='form-group text-center margin-top-10'>";
                                                        $temp = null;
                                                        $temp = $scope_array[$total_slug . '_' . get_sub_field('slug') . '_' . $rooms];
                        				echo "<textarea class='quote_textarea' name='" . $total_slug . "_" . get_sub_field('slug') . "_" . $rooms . "'>" . $temp . "</textarea>";
                        				echo "</div>";
                        				echo "</div></div></div>";
                        			}
			
                        
                                                
                        				// checking if this template has Note
			if( get_row_layout() == 'additional_photos' ) {
				echo "<div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>" . get_sub_field('title') . "</h4><div class='text-center'>" . get_sub_field('description') . "</div>";
				echo "<div class='row'><div class='col-md-10 col-md-offset-1 margin-top-20'><div class='row'>";
				echo "<div class='col-md-4'>";
				echo "<div class='form-group text-center'><input type='file' name='" . $total_slug . "_" . get_sub_field('slug') . "_" . $rooms . "_1' id='" . $total_slug . "_" . get_sub_field('slug') . "_" . $rooms . "_1' class='file_upload'><div class='" . $total_slug . "_" . get_sub_field('slug') . "_" . $rooms . "_1'></div></div>";
				echo "<script>$('#" . $total_slug . "_" . get_sub_field('slug') . "_" . $rooms . "_1').change(function(){ UploadImage('" . $total_slug . "_" . get_sub_field('slug') . "_" . $rooms . "_1'); });</script>";
				echo "</div>";
				echo "<div class='col-md-4'>";
				echo "<div class='form-group text-center'><input type='file' name='" . $total_slug . "_" . get_sub_field('slug') . "_" . $rooms . "_2' id='" . $total_slug . "_" . get_sub_field('slug') . "_" . $rooms . "_2' class='file_upload'><div class='" . $total_slug . "_" . get_sub_field('slug') . "_" . $rooms . "_2'></div></div>";
				echo "<script>$('#" . $total_slug . "_" . get_sub_field('slug') . "_" . $rooms . "_2').change(function(){ UploadImage('" . $total_slug . "_" . get_sub_field('slug') . "_" . $rooms . "_2'); });</script>";
				echo "</div>";
				echo "<div class='col-md-4'>";
				echo "<div class='form-group text-center'><input type='file' name='" . $total_slug . "_" . get_sub_field('slug') . "_" . $rooms . "_3' id='" . $total_slug . "_" . get_sub_field('slug') . "_" . $rooms . "_3' class='file_upload'><div class='" . $total_slug . "_" . get_sub_field('slug') . "_" . $rooms . "_3'></div></div>";
				echo "<script>$('#" . $total_slug . "_" . get_sub_field('slug') . "_" . $rooms . "_3').change(function(){ UploadImage('" . $total_slug . "_" . get_sub_field('slug') . "_" . $rooms . "_3'); });</script>";
				echo "</div>";
				echo "</div></div></div>";
			}
			
		
                        		endwhile;
		
                        	}
	
                        	echo "<hr />";
	
                        	$rooms++;
                        	endwhile;     
                                        
                                ?>
                                
                        </div>
                </div>
                
                <?php endforeach ;?>
                
                <div id="scope_edit_response"></div>
                
                <?php
                echo "<div class='row text-center'>";
                echo "<a class='btn btn-info btn-round btn-lg margin-top-40 margin-horizontal-10' id='goto_update_scope'>Update Scope</a>";
                echo "</div>";
                ?>
                
                </form>
	  
                
	  
        </div>
</div>
<!-- End Page -->


<?php get_footer(); ?>