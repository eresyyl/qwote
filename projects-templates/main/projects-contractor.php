<?php
$current_user_id = current_user_id();

// let's go for all projects and get ID's of projects where current user id exist. stored in $contractorProjects array
$allProjects = get_posts(array('posts_per_page' => 9999, 'post_type' => 'project', 'meta_key' => 'contractor_id'));
$contractorProjects = array();
foreach($allProjects as $p) {
	$contractors = get_field('contractor_id',$p->ID);
	$contractorsArray = array();
	foreach($contractors as $c) {
		$contractorsArray[] = $c["ID"];
	}
	if(in_array($current_user_id,$contractorsArray)) {
		$contractorProjects[] = $p->ID;
	}
}
if(!is_array($contractorProjects) || count($contractorProjects) == 0) {
	$contractorProjects = array(0);
}


$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$default_args = array('posts_per_page'=>10,'post_type'=>'project','post__in'=>$contractorProjects,'paged'=>$paged);

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
        $meta_args = array( 'meta_query' => array('relation' => 'AND', $status_args ) );
}
else {
       $meta_args = array( 'meta_query' => array('relation' => 'AND', $status_args ) );
}

$args_all = array_merge($default_args,$meta_args);
$projects_statistic = go_projects_statistic($current_user_id);

$client_string = get_field('client','options');
$agent_string = get_field('agent','options');

?>
<?php get_header(); ?>

<div class="page animsition">
	
	<div class="page-main">
		<div class="page-content">
			<div class="panel">
				<div class="panel-heading">
					<h3 class="panel-title">PROJECT LIST</h3>
					<ul class="panel-info">
						<li>
							<div class="num green-600"><?php echo $projects_statistic->live; ?></div>
							<p>Live</p>
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
								<th>Project</th>
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
							        if($client_id[0] == NULL) {
							                $client_id = $client_id['ID'];
							        }
							        else {
							                $client_id = $client_id[0];
							        }
							$client = go_userdata($client_id);
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
									<div style="display:inline-block; position:relative;" data-toggle="tooltip" data-placement="left" data-trigger="hover" data-original-title="<?php echo $client_string; ?>: <?php echo $client->first_name; ?> <?php echo $client->last_name; ?>" title="">
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
										<a class="blue-grey-500" style="cursor:pointer;" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</div>
								</td>
								<td class="actions text-center" style="width:10%;">
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
