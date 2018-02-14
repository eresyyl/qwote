<?php
require_once( ABSPATH . 'wp-load.php');
// getting Current User ID
$current_user_id = current_user_id();
// get project infos
$quote_id = get_the_ID();

$selected_selections_prices = get_field('selected_selections');
$selected_price = 0;
$selected_summ = 0; 
foreach($selected_selections_prices as $s) {
        $selection_price = get_field('selection_price',$s);
        $selected_price = $selected_price + $selection_price;
        $selection_summ = get_field('selection_budget',$s);
        $selected_summ = $selected_summ + $selection_summ;
}
$s=null;
$difference = $selected_price - $selected_summ;
?>
<style>
.overlay {
        position:absolute;
        top:0;
        left:0;
        width:100%;
        height:100%;
        background: rgba(255,255,255,0.8);
        display:none;
        z-index:600;
}
.selection_section_title {
        font-size: 18px;
        font-weight: 100;
        padding: 10px 0;
        text-shadow: none;
}
</style>
<?php if(get_field('default_selections')) : ?>
        <div class="row default_selections">
                <div class="col-md-12">
                        <div class="selection_section_title">Available Selections</div>
                </div>
                <?php 
                $selected_selections = get_field('selected_selections');
                $selections = get_field('default_selections'); $s=0; foreach($selections as $selection) : $s++;
                        $title = get_field('selection_name',$selection);
                        $price = get_field('selection_price',$selection);
                        $pc_sum = get_field('selection_budget',$selection);
                        $selection_photo_id = get_field('selection_photo',$selection);
                        $size = "selection";
                        $photo = wp_get_attachment_image_src( $selection_photo_id, $size );
                        $photo_url = $photo[0];
                        ?>
                        <div class="col-md-4 col-xs-6 margin-bottom-20 margin-horizontal-15 selection_<?php echo $selection; ?>">
                                <div class="overlay" <?php if(in_array($selection,$selected_selections)) { echo "style='display:block'"; } ?>></div>
                                <?php if($photo) : ?>
                                        <img width="100%" src="<?php echo $photo_url; ?>">
                                <?php else : ?>
                                        <img width="100%" src="<?php bloginfo('template_url'); ?>/assets/defaults/no_selection.png">
                                <?php endif; ?>
                                <div class="text-center"><strong><?php echo $title; ?></strong></div>
                                <div class="text-center">Actual Price: $<?php echo $price; ?> Budgeted Price: $<?php echo $pc_sum; ?> </div>
                                <div class="text-center margin-top-10"><a data-target='#selection_<?php echo $selection; ?>' data-toggle='modal' class="btn btn-xs btn-default">Details</a></div>
                                <div class="text-center margin-top-10"><a data-selection="<?php echo $selection; ?>" data-quote="<?php echo $quote_id; ?>" class="btn btn-xs btn-success select_selection">Add</a></div>
                        </div>
                <?php endforeach; ?>
        </div>
        
        <div class="row">
                <div class="col-md-12">
                        <div class="selection_section_title padding-bottom-0">Selected Options</div>
                        <div class="selection_section_title padding-top-0"><strong>Actual Cost:</strong> $<span class="total"><?php echo $selected_price; ?></span><strong class="padding-left-10">Budget Cost:</strong> $<span class="summ"><?php echo $selected_summ; ?></span><strong class="padding-left-10">Difference:</strong> $<span class="summ"><?php echo $difference; ?></span></div>
                </div>
                </div>
                <div class="selected_selections">
                <?php $selections = get_field('selected_selections'); $s=0; foreach($selections as $selection) : $s++;
                        $title = get_field('selection_name',$selection);
                        $price = get_field('selection_price',$selection);
                        $pc_sum = get_field('selection_budget',$selection);
                        $selection_photo_id = get_field('selection_photo',$selection);
                        $size = "selection";
                        $photo = wp_get_attachment_image_src( $selection_photo_id, $size );
                        $photo_url = $photo[0];
                        ?>
                        <div class="col-md-4 col-xs-6 margin-bottom-20 margin-horizontal-15 selection_<?php echo $selection; ?>">
                                <?php if($photo) : ?>
                                        <img width="100%" src="<?php echo $photo_url; ?>">
                                <?php else : ?>
                                        <img width="100%" src="<?php bloginfo('template_url'); ?>/assets/defaults/no_selection.png">
                                <?php endif; ?>
                                <div class="text-center"><strong><?php echo $title; ?></strong></div>
                                <div class="text-center">Actual Price: $<?php echo $price; ?> Budgeted Price: $<?php echo $pc_sum; ?> </div>
                                <div class="text-center margin-top-10"><a data-target='#selection_<?php echo $selection; ?>' data-toggle='modal' class="btn btn-xs btn-default">Details</a></div>
                                <div class="text-center margin-top-10"><a data-selection="<?php echo $selection; ?>" data-quote="<?php echo $quote_id; ?>" class="btn btn-xs btn-danger select_selection">Remove</a></div>
                        </div>
                <?php endforeach; ?>
                </div>
        
        <?php $s=0; 
        $selections = get_field('default_selections');
        foreach($selections as $selection) : $s++;
                $title = get_field('selection_name',$selection);
                $description = get_field('selection_description',$selection);
                $brands = wp_get_post_terms($selection,'brand',array('fields'=>'all'));
                $price = get_field('selection_price',$selection);
                $pc_sum = get_field('selection_budget',$selection);
                $selection_photo_id = get_field('selection_photo',$selection);
                $size = "full";
                $photo = wp_get_attachment_image_src( $selection_photo_id, $size );
                $photo_url = $photo[0];
                ?>
                <div class='modal fade' id='selection_<?php echo $selection; ?>' aria-hidden='true' aria-labelledby='selection_<?php echo $selection; ?>' role='dialog' tabindex='-1'>
                        <div class='modal-dialog modal-center'>
                                <div class='modal-content'>
                                        <div class='modal-header text-center'>
                                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                        <span aria-hidden='true'>×</span>
                                                </button>
                                                <h4 class='modal-title'><?php echo $title; ?></h4>
                                        </div>
                                        <div class='modal-body selection_popup'>
                                                <?php if($photo) : ?>
                                                        <div class="text-center"><img src="<?php echo $photo_url; ?>" alt=""></div>
                                                <?php endif; ?>
                                                <div class="text-center"><span class="label label-lg label-info">Price: $<?php echo $price; ?></span> <span class="label label-lg label-danger">PC Sum: $<?php echo $pc_sum; ?></span> </div>
                                                <div>Brand: <?php foreach($brands as $brand) { echo $brand->name . " "; } ?></div>
                                                <div><?php echo $description; ?></div>
                                        </div>
                                </div>
                        </div>
                </div>
        <?php endforeach; ?>
        
<?php else : ?>
        <p class="text-center margin-top-20">No options yet.</p>
<?php endif; ?>