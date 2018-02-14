<?php
$current_user_id = current_user_id();
$projects_statistic = go_projects_statistic($current_user_id);

$quote_total = $projects_statistic->quote_total; $quote_total = number_format($quote_total, 2, '.', '');
$active_total = $projects_statistic->active_total; $active_total = number_format($active_total, 2, '.', '');
$pending_total = $projects_statistic->pending_total; $pending_total = number_format($pending_total, 2, '.', '');
$live_total = $projects_statistic->live_total; $live_total = number_format($live_total, 2, '.', '');
$completed_total = $projects_statistic->completed_total; $completed_total = number_format($completed_total, 2, '.', '');
?>
<?php get_header(); ?>
 <?php if(!is_contractor()) : ?>
<div class="row">
<!-- First Row -->
    <div class="col-lg-6 col-sm-6 col-xs-12 info-panel">
            <div class="widget widget-shadow">
                    <div class="widget-content bg-white padding-20">
                            <button type="button" class="btn btn-floating btn-sm btn-default">
                                    <i class="icon wb-attach-file"></i>
                            </button>
                            <span class="margin-left-15 font-weight-400">Quote Mode</span>
                            <div class="content-text text-center margin-bottom-0">
                                    <span class="font-size-30 font-weight-100">$ <?php echo $quote_total; ?></span>
                            </div>
                    </div>
            </div>
    </div>
    <div class="col-lg-6 col-sm-6 col-xs-12 info-panel">
            <div class="widget widget-shadow">
                    <div class="widget-content bg-white padding-20">
                            <button type="button" class="btn btn-floating btn-sm btn-primary">
                                    <i class="icon wb-medium-point"></i>
                            </button>
                            <span class="margin-left-15 font-weight-400">Active</span>
                            <div class="content-text text-center margin-bottom-0">
                                    <span class="font-size-30 font-weight-100">$ <?php echo $active_total; ?></span>
                            </div>
                    </div>
            </div>
    </div>
</div>
<?php endif; ?>
<div class="row">

   <div class="col-lg-4 col-sm-4 col-xs-12 info-panel">
            <div class="widget widget-shadow">
                    <div class="widget-content bg-white padding-20">
                            <button type="button" class="btn btn-floating btn-sm btn-warning">
                                    <i class="icon wb-pause"></i>
                            </button>
                            <span class="margin-left-15 font-weight-400">Pending</span>
                            <div class="content-text text-center margin-bottom-0">
                                    <span class="font-size-30 font-weight-100">$ <?php echo $pending_total; ?></span>
                            </div>
                    </div>
            </div>
    </div>
  
    <div class="col-lg-4 col-sm-6 col-xs-12 info-panel">
            <div class="widget widget-shadow">
                    <div class="widget-content bg-white padding-20">
                            <button type="button" class="btn btn-floating btn-sm btn-info">
                                    <i class="icon wb-play"></i>
                            </button>
                            <span class="margin-left-15 font-weight-400">Live</span>
                            <div class="content-text text-center margin-bottom-0">
                                    <span class="font-size-30 font-weight-100">$ <?php echo $live_total; ?></span>
                            </div>
                    </div>
            </div>
    </div>
    <div class="col-lg-4 col-sm-6 col-xs-12 info-panel">

                           <div class="widget widget-shadow">
                    <div class="widget-content bg-white padding-20">
                            <button type="button" class="btn btn-floating btn-sm btn-success">
                                    <i class="icon wb-check"></i>
                            </button>
                            <span class="margin-left-15 font-weight-400">Completed</span>
                            <div class="content-text text-center margin-bottom-0">
                                    <span class="font-size-30 font-weight-100">$ <?php echo $completed_total; ?></span>
                            </div>
                    </div>
            </div>
    </div>

</div>
<!-- End First Row -->
