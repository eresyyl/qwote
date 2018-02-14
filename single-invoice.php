<?php
go_check_registered();
$invoice_id = get_the_ID();
$current_user_id = current_user_id();
$client_id = get_field('client_id',$invoice_id);
if(is_client()) {
        if($current_user_id != $client_id) {
                wp_redirect(home_url() . "/all_invoices");
                die;  
        }
	get_template_part('invoice-templates/main/invoice','client');
	die;
}
if(is_headcontractor() || is_agent()) {
	get_template_part('invoice-templates/main/invoice','head');
	die;
}
else {
        wp_redirect(home_url() . "/all_projects");
        die;
}
?>