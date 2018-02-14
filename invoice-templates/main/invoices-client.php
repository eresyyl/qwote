<?php
// getting Current User ID
$current_user_id = current_user_id();
// Creating WP_Query Arguments
if($_GET) {
	$invoice_status = $_GET['status'];
	$status_args = array('key'=>'status','value'=>$invoice_status,'compare'=>'LIKE');
}
else {
	$quote_status = 'all';
	$status_args = array();
}

$client_args = array('key'=>'client_id','value'=>$current_user_id);
$meta_args = array('meta_query'=>array($status_args,$client_args));
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;	
$args = array('posts_per_page'=>10,'post_type'=>'invoice','paged'=>$paged);
$args_all = array_merge($args,$meta_args);
$invoice_statistic = go_invoice_statistic($current_user_id);
?>
<?php get_header(); ?>
  
<div class="page animsition">
	  
	<?php get_template_part('invoice-templates/sidebars/sidebar','client'); ?>  
	  
	<div class="page-main"> 
		<div class="page-content">
			<div class="panel">
				<div class="panel-heading">
					<h3 class="panel-title">INVOICES</h3>
          
					<ul class="panel-info">
						<li>
							<div class="num blue-grey-600"><?php echo $invoice_statistic->pending; ?></div>
							<p>Pending</p>
						</li>
						<li>
							<div class="num green-600"><?php echo $invoice_statistic->paid; ?></div>
							<p>Paid</p>
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
                                                                <th>Due Date</th>
								<th>Subject</th>
								<th>Total</th>
								<th class="text-center">Actions</th>
							</tr>
						</thead>
						<tbody>
				
							<?php 
							$new_query = new WP_Query($args_all); 
							if ($new_query->have_posts()) : while ($new_query->have_posts()) : $new_query->the_post();
							$max_num_pages = $new_query->max_num_pages;
							$invoice_id = get_the_ID();
							$client_id = get_field('client_id');
							$client = go_userdata($client_id);
                                                        $status = get_field('status');
                                                        if($status == 'Pending') {
                                                                $status_class = "label-default";
                                                        }
                                                        elseif($status == 'Paid') {
                                                               $status_class = "label-success"; 
                                                        }
                                                        $quote_id = get_field('project_id');
                                                        $due = get_field('due',$quote_id);
                                                        $invoice_date_temp = get_the_time('d-m-Y');
                                                        if($due != '0') {
                                                                $due = intval($due);
                                                                $invoice_duedate = date('d-m-Y', strtotime($invoice_date_temp. ' + ' . $due . ' days'));
                                                        }
                                                        else {
                                                                $invoice_duedate = 'Due on receipt';
                                                        }
							?>
				
							<tr id="invoice_<?php echo $quote_id; ?>">
								<td class="work-status" style="width:10%;">
									<span class="label <?php echo $status_class; ?>"><?php echo $status; ?></span>
								</td>
								<td class="date">
									<span class="blue-grey-400"><?php the_time('d-m-Y'); ?></span>
								</td>
								<td class="date">
									<span class="blue-grey-400"><?php echo $invoice_duedate; ?></span>
								</td>
								<td class="subject">
									<div class="table-content">
                                                                               <?php the_title(); ?><br />
                                                                               <span class="grey-400"><?php the_field('milestone_title'); ?></span>
									</div>
								</td>
								<td class="total" style="width:10%;">
									$<?php the_field('milestone_price'); ?>
								</td>
								
								<td class="actions text-center">
                                                                        <div class="table-content">
                                                                                <?php 
                                                                                if($status == 'Pending') {
                                                                                        go_invoice_actions(array('preview'),$invoice_id);
                                                                                }
                                                                                elseif($status == 'Paid') {
                                                                                        go_invoice_actions(array('paid','preview'),$invoice_id);
                                                                                }
                                                                                ?>
                                                                        </div>
								</td>
							</tr>
			  
							<?php endwhile; ?>
							<?php else : ?>
								<tr class="text-center">
									<td colspan="6">
										There is no invoices yet.
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