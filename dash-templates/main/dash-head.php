<?php
$current_user_id = current_user_id();

$args = array('posts_per_page'=>5,'post_type'=>'project');
$projects_statistic = go_projects_statistic($current_user_id);

$quote_total = $projects_statistic->quote_total; $quote_total = number_format($quote_total, 2, '.', '');
$active_total = $projects_statistic->active_total; $active_total = number_format($active_total, 2, '.', '');
$pending_total = $projects_statistic->pending_total; $pending_total = number_format($pending_total, 2, '.', '');
$live_total = $projects_statistic->live_total; $live_total = number_format($live_total, 2, '.', '');
$completed_total = $projects_statistic->completed_total; $completed_total = number_format($completed_total, 2, '.', '');

$client_string = get_field('client','options');
$contractor_string = get_field('contractor','options');

?>
<?php get_header(); ?>

<div class="page animsition">

        <div class="page-content container-fluid">
                <div class="page-header">
                        <h1 class="page-title font-size-18 font-weight-100 text-center">Projects Statistics</h1>
                </div>

                <?php include('views/statistics.php'); ?>


                <div class="page-header text-center">
                        <h1 class="page-title font-size-18 font-weight-100 text-center margin-bottom-20">Recent Projects</h1>
                        <a href="<?php bloginfo('url'); ?>/all_projects" class="btn btn-primary">Manage All Projects</a>
                </div>

                <div class="panel">
		<div class="panel-body">
                        <div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th>Status</th>
						<th>Date</th>
                        <th class="text-center"><?php echo $client_string; ?></th>
						<th>Subject</th>
						<th>Total</th>
						<th class="text-center">Actions</th>
					</tr>
				</thead>
				<tbody>

					<?php
					$new_query = new WP_Query($args);
					if ($new_query->have_posts()) : while ($new_query->have_posts()) : $new_query->the_post();
					$max_num_pages = $new_query->max_num_pages;
					$quote_id = get_the_ID();
					$client_id = get_field('client_id');
					        if($client_id[0] == NULL) {
					                $client_id = $client_id['ID'];
					        }
					        else {
					                $client_id = $client_id[0];
					        }
					$client = go_userdata($client_id);
					$status = go_project_status($quote_id);
					?>

					<tr id="project_<?php echo $quote_id; ?>">
						<td class="work-status" style="width:10%;">
							<span class="label label-<?php echo $status->status_class; ?>"><?php echo $status->status_string; ?></span>
						</td>
						<td class="date" style="width:10%;">
							<span class="blue-grey-400"><?php the_time('d/m/Y'); ?></span>
						</td>
                        <td style="width:15%;" class="text-center">
							<div style="display:inline-block; position:relative;" data-toggle="tooltip" data-placement="left" data-trigger="hover" data-original-title="<?php echo $client_string; ?>: <?php echo $client->first_name; ?> <?php echo $client->last_name; ?>" title="">
								<img class="avatar small" src="<?php echo $client->avatar; ?>" \>
                                <b style="display:block;">
    								<?php echo $client->first_name; ?> <?php echo $client->last_name; ?><br>
									<?php echo $client->phone; ?>
                                </b>
							</div>
						</td>
						<td class="subject" style="width:45%;">
							<div class="table-content">
                                <a class="blue-grey-500" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</div>
						</td>
						<td class="total" style="width:10%;">
                            <?php $total = get_field('total'); if($total) { $total = number_format($total, 2, '.', ''); } else { $total = '0.00'; } ?>
							$<?php echo $total; ?>
						</td>
						<td class="actions" style="width:10%;">
                            <div class="table-content text-center">
                                    <?php
                                    go_project_actions(array('permalink'),$quote_id);
                                    ?>
                            </div>
						</td>
					</tr>

					<?php endwhile; ?>
					<?php else : ?>
						<tr class="text-center">
							<td colspan="6">
								There is no projects yet.
							</td>
						</tr>
					<?php endif; ?>

				</tbody>
			</table>
                        </div>
		</div>
                </div>

        </div>

</div>

<?php get_footer(); ?>
