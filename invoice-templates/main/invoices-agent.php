<?php
// getting Current User ID
$current_user_id = current_user_id();

// let's go for all projects and get ID's of projects where current user id exist. stored in $agentProjects array
$allProjects = get_posts(array('posts_per_page' => 9999, 'post_type' => 'project', 'meta_key' => 'agent_id'));
$agentProjects = array();
foreach($allProjects as $p) {
	$agents = get_field('agent_id',$p->ID);
	$agentsArray = array();
	foreach($agents as $a) {
		$agentsArray[] = $a["ID"];
	}
	if(in_array($current_user_id,$agentsArray)) {
		$agentProjects[] = $p->ID;
	}
}
if(!is_array($agentProjects) || count($agentProjects) == 0) {
	$agentProjects = array();
    $agentProjects[] = 0;
}
$allInvoices = get_posts(array(
    'posts_per_page'=> 9999,
    'post_type' => 'invoice',
));
foreach($allInvoices as $invoice) {
    $projectId = get_field('project_id',$invoice->ID);
    if(in_array($projectId,$agentProjects)) {
        $allAgentInvoices[] = $invoice->ID;
    }
}
if(count($allAgentInvoices) < 1) {
    $allAgentInvoices = array(0);
}
// so now all agent's Invoices stored in array $allAgentInvoices

// Creating WP_Query Arguments
if($_GET) {
	$invoice_status = $_GET['status'];
	$status_args = array('key'=>'status','value'=>$invoice_status);
}
else {
	$quote_status = 'all';
	$status_args = array();
}

$meta_args = array('meta_query'=>$status_args);
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$new_args = array('post_type' => 'invoice', 'post__in' => $allAgentInvoices, 'posts_per_page'=>10, 'paged'=>$paged, 'meta_query' => $meta_args );
$all_args = array('post_type' => 'invoice', 'post__in' => $allAgentInvoices, 'posts_per_page'=>9999);
$allInvoicesStats = get_posts($all_args);
$paid = 0; $pending = 0;
foreach($allInvoicesStats as $invoiceStats) {
    $status = get_field('status',$invoiceStats->ID);
    if($status == 'Pending') {
        $pending = $pending + 1;
    }
    elseif($status == 'Paid') {
        $paid = $paid + 1;
    }
}

//$invoice_statistic = go_invoice_statistic($current_user_id);
?>
<?php get_header(); ?>

<div class="page animsition">

	<?php get_template_part('invoice-templates/sidebars/sidebar','head'); ?>

	<div class="page-main">
		<div class="page-content">
			<div class="panel">
				<div class="panel-heading">
					<h3 class="panel-title">INVOICES</h3>

					<ul class="panel-info">
						<li>
							<div class="num blue-grey-600"><?php echo $pending; ?></div>
							<p>Pending</p>
						</li>
						<li>
							<div class="num green-600"><?php echo $paid; ?></div>
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
							$new_query = new WP_Query($new_args);
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
                                                                                        go_invoice_actions(array('mark_paid','remind','preview'),$invoice_id);
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
										There are no invoices yet.
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
