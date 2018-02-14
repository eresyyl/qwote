<?php
// getting Current User ID
$current_user_id = current_user_id();
$current_user_id = intval($current_user_id);
//var_dump(get_field('client_id',1648));
$c = get_userdata($current_user_id);
// Creating WP_Query Arguments
if($_GET) {
	$quote_status = $_GET['status'];
	$status_args = array('key'=>'status','value'=>$quote_status);
}
else {
	$quote_status = 'all';
	$status_args = array();
}

$agent_args = array('key'=>'client_id','value'=>$current_user_id,'compare' => '=');
$meta_args = array('meta_query'=>array($status_args,$agent_args), 'relation' => 'AND');
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;	
$args = array('posts_per_page'=>10,'post_type'=>'project','paged'=>$paged);
$args_all = array_merge($args,$meta_args);

$projects_statistic = go_projects_statistic($current_user_id);

$client_string = get_field('client','options');
$agent_string = get_field('agent','options');

//update_post_meta(1653, 'client_id', 76);
//update_field('field_567eb805b96b3',3,1653);
$custom_fields = get_post_meta(1656,'client_id',true);
print_r($custom_fields);


?>
<?php get_header(); ?>
  
<div class="page animsition">
	  
	<?php get_template_part('projects-templates/sidebars/sidebar','client'); ?>  
	  
	<div class="page-main"> 
		<div class="page-content">
			<div class="panel">
				<div class="panel-heading">
					<h3 class="panel-title">PROJECTS LIST</h3>
          
					<ul class="panel-info">
						<li>
							<div class="num blue-grey-600"><?php echo $projects_statistic->quote; ?></div>
							<p>Quote Mode</p>
						</li>
						<li>
							<div class="num yellow-600"><?php echo $projects_statistic->active; ?></div>
							<p>Active</p>
						</li>
						<li>
							<div class="num orange-600"><?php echo $projects_statistic->pending; ?></div>
							<p>Pending</p>
						</li>
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
								<th><?php echo $client_string; ?></th>								
								<th>Project</th>
								<th>Price</th>
								<th><?php echo $agent_string; ?></th>
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
								<td class="date">
									<span class="blue-grey-400"><?php the_time('d/m/Y'); ?></span>
								</td>
	              <td style="width:15%;">
									<div style="display:inline-block; position:relative;" data-toggle="tooltip" data-placement="left" data-trigger="hover" data-original-title="You: <?php echo $client->first_name; ?> <?php echo $client->last_name; ?>" title="">
										<img class="avatar small" src="<?php echo $client->avatar; ?>" \>
										<span class="addMember-remove"><i class="fa fa-user"></i></span>
									</div>
								   <b>
										<?php echo $client->first_name; ?> <?php echo $client->last_name; ?><br>
											<?php echo $client->phone; ?>
									</b>
								</td>								
								<td class="subject">
									<div class="table-content">
										<p class="blue-grey-500">
                                                                                        <?php if($status->status != 'cancelled') : ?>
                                                                                                <a class="blue-grey-500" style="cursor:pointer;" href="<?php echo get_the_permalink($quote_id); ?>"><?php echo go_generate_title($quote_id); ?></a>
                                                                                        <?php else : ?>
                                                                                                <?php echo go_generate_title($quote_id); ?>
                                                                                        <?php endif; ?>
                                                                                </p>
									</div>
								</td>
								<td class="total" style="width:10%;">
                                                                        <?php $total = get_field('total'); if($total) { $total = number_format($total, 2, '.', ''); } else { $total = '0.00'; } ?>
									$<?php echo $total; ?>
								</td>
								<td style="width:15%;">
									<?php if(get_field('agent_id')) : ?>
										<div style="display:inline-block; position:relative;"  data-toggle="tooltip" data-placement="left" data-trigger="hover" data-original-title="<?php echo $agent_string; ?>: <?php echo $agent_info->first_name; ?> <?php echo $agent_info->last_name; ?>" title="">
											<img class="avatar small" src="<?php echo $agent_info->avatar; ?>" \>
											<span class="addMember-remove"><i class="fa fa-group"></i></span>
										</div>
									  <b>
										<?php echo $agent_info->first_name; ?> <?php echo $agent_info->last_name; ?><br>
											<?php echo $agent_info->phone; ?>
									</b>
									<?php endif; ?>
								</td>
				
								<td class="actions">
                                                                        <div class="table-content">
                                                                                <?php 
                                                                                if($status->status == 'quote') {
                                                                                        go_project_actions(array('preview','edit','cancel','permalink'),$quote_id);
                                                                                }
                                                                                elseif($status->status == 'active') {
                                                                                        go_project_actions(array('preview','approve','cancel','permalink'),$quote_id);
                                                                                }
                                                                                elseif($status->status == 'pending') {
                                                                                        go_project_actions(array('preview','permalink'),$quote_id);
                                                                                }
                                                                                elseif($status->status == 'live') {
                                                                                        go_project_actions(array('preview','permalink'),$quote_id);
                                                                                }
                                                                                elseif($status->status == 'completed') {
                                                                                        go_project_actions(array('preview','permalink'),$quote_id);
                                                                                }
                                                                                elseif($status->status == 'cancelled') {
                                                                                        
                                                                                }
                                                                                ?>
                                                                        </div>
								</td>
							</tr>
			  
							<?php endwhile; ?>
							<?php else : ?>
								<tr class="text-center">
									<td colspan="7">
										There is no projects yet.
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