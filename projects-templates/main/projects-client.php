<?php
$current_user_id = current_user_id();

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$default_args = array('posts_per_page'=>10,'post_type'=>'project','paged'=>$paged);

$client_args = array( array('key'=>'client_id','value'=>$current_user_id) );

// Creating WP_Query Arguments
if($_GET['status']) {
	$quote_status = $_GET['status'];
	$status_args = array('key'=>'status','value'=>$quote_status);
}
else {
        $status_args = array('key'=>'status','value'=>'cancelled','compare'=>'!=');
}
$status_args = array($status_args);

if($_GET['status']) {
        $meta_args = array( 'meta_query' => array('relation' => 'AND', array_merge($status_args,$client_args) ) );
}
else {
       $meta_args = array( 'meta_query' => array('relation' => 'AND', array_merge($status_args,$client_args) ) );
}

$args_all = array_merge($default_args,$meta_args);
$projects_statistic = go_projects_statistic($current_user_id);

$quote_amount = $projects_statistic->quote + $projects_statistic->pending;
$client_string = get_field('client','options');
$agent_string = get_field('agent','options');

?>
<?php get_header(); ?>

<div class="page animsition">

	<?php get_template_part('projects-templates/sidebars/sidebar','client'); ?>

	<div class="page-main">
		<div class="page-content">
			<div class="panel">
				<div class="panel-heading">
					<h3 class="panel-title">Your Quotes</h3>
					<ul class="panel-info">
						<li>
							<div class="num blue-grey-600"><?php echo $quote_amount; ?></div>
							<p>Quotes</p>
						</li>
						<li>
							<div class="num green-600"><?php echo $projects_statistic->live; ?></div>
							<p>Live Jobs</p>
						</li>
					</ul>
				</div>
				<div class="panel-body">
                                        <div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Status</th>
								<th>Date</th>
								<th class="text-center"><?php echo $client_string; ?></th>
								<th>Quote</th>
								<th>Price</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>

							<?php
							$new_query = new WP_Query($args_all);
							if ($new_query->have_posts()) : while ($new_query->have_posts()) : $new_query->the_post();
							$max_num_pages = $new_query->max_num_pages;
							$quote_id = get_the_ID();
							$client_id = get_field('client_id');
							$client = go_userdata($client_id["ID"]);
                                                        $agent_id = get_field('agent_id');
                                                                if($agent_id[0] == NULL) {
                                                                        $agent_id = $agent_id['ID'];
                                                                }
                                                                else {
                                                                        $agent_id = $agent_id[0];
                                                                }
                                                        $agent_info = go_userdata($agent_id);
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
									<div style="display:inline-block; position:relative;" data-toggle="tooltip" data-placement="left" data-trigger="hover" data-original-title="You: <?php echo $client->first_name; ?> <?php echo $client->last_name; ?>" title="">
										<img class="avatar small" src="<?php echo $client->avatar; ?>" \>
										<span class="addMember-remove"><i class="fa fa-user"></i></span>
									</div>
                                                                        <b style="display:block;">
                                                                                        <?php echo $client->first_name; ?> <?php echo $client->last_name; ?><br>
											<?php echo $client->phone; ?>
                                                                        </b>
								</td>
								<td class="subject" style="width:45%;">
									<div class="table-content">
										<p class="blue-grey-500">
                                                                            <a class="blue-grey-500" style="cursor:pointer;" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                                                </p>
									</div>
								</td>
								<td class="total" style="width:10%;">
                                                                        <?php $total = get_field('total'); if($total) { $total = number_format($total, 2, '.', ''); } else { $total = '0.00'; } ?>
									$<?php echo $total; ?>
								</td>

								<td class="actions" style="width:10%; text-align:center;">
                                                                        <div class="table-content">
                                                                                <?php
                                                                                if($status->status == 'quote') {
                                                                                        go_project_actions(array('permalink'),$quote_id);
                                                                                }
                                                                                elseif($status->status == 'active') {
                                                                                        go_project_actions(array('permalink'),$quote_id);
                                                                                }
                                                                                elseif($status->status == 'pending') {
                                                                                        go_project_actions(array('permalink'),$quote_id);
                                                                                }
                                                                                elseif($status->status == 'live') {
                                                                                        go_project_actions(array('permalink'),$quote_id);
                                                                                }
                                                                                elseif($status->status == 'completed') {
                                                                                        go_project_actions(array('permalink'),$quote_id);
                                                                                }
                                                                                elseif($status->status == 'cancelled') {
																					go_project_actions(array('permalink'),$quote_id);
                                                                                }
                                                                                ?>
                                                                        </div>
								</td>
							</tr>

							<?php endwhile; ?>
							<?php else : ?>
								<tr class="text-center">
									<td colspan="6">
										There are no projects yet.
									</td>
								</tr>
							<?php endif; ?>

						</tbody>
					</table>
                                        </div>
				</div>
				<div class="panel-footer">
					<?php if($max_num_pages > 1) : ?>
						<div class="panel-footer padding-none text-center">
							<nav><?php wp_pagenavi( array( 'query' => $new_query ) ); ?></nav>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>
