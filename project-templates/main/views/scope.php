<?php
require_once( ABSPATH . 'wp-load.php');
// getting Current User ID
$current_user_id = current_user_id();
// get project infos
$quote_id = get_the_ID();

$templates = get_field('templates');
$scope_array = get_field('quote_array');
if(!is_array($scope_array)) {
        $scope_array = json_decode($scope_array,true);
}

?>

<div id="scopes" aria-multiselectable="true" role="tablist">

 
        
        <div class="row">
                <?php foreach($templates as $t) : 
                        $total_slug = get_field('total_slug',$t);
                        $rooms_count = $scope_array[$total_slug . '_rooms'];
                        ?>
                        <div class="template_show margin-bottom-20 margin-horizontal-15 scope_load_details" data-template="<?php echo $t; ?>" data-quote="<?php echo $quote_id; ?>">
                                <img src="<?php the_field('template_image',$t); ?>">
                                <div class="text-center"><strong><?php echo get_the_title($t); ?></strong> <span class="label label-default">x<?php echo $rooms_count; ?></span><br/><?php echo $full_total; ?></div>
                        </div>
                <?php endforeach; ?>
        </div>
        <div class="row">
                <div class="col-md-12 margin-horizontal-5">
                        <div id="scope_details"></div>
                </div>
        </div>
</div>