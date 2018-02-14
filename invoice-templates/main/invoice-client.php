<?php
// getting Current User ID
$current_user_id = current_user_id();
// get invoice infos
$invoice_id = get_the_ID();
// clear notification of current invoice
go_clear_notifications($current_user_id,$invoice_id);

get_header();

$client_id = get_field('client_id'); $client_data = go_userdata($client_id);
$total = get_field('milestone_price');
$tax_name = get_field('tax_name','options');
$tax_value = get_field('tax_value','options');

$quote_id = get_field('project_id');

// let's get Lead PL of a project
$agentLeadId = get_field('plMain',$quote_id);
if($agentLeadId['ID']) { $agentLeadId = $agentLeadId['ID']; }
elseif($agentLeadId[0]) { $agentLeadId = $agentLeadId[0]; }
else { $agentLeadId = false; }
if($agentLeadId != false) {
    // get all vars for invoice settings from LeadAgent profile
    $companyName = get_field('invCompany_name','user_' . $agentLeadId);
    $companyAddress = get_field('invAddress','user_' . $agentLeadId);
    $companyEmail = get_field('invEmail','user_' . $agentLeadId);
    $companyPhone = get_field('invPhone','user_' . $agentLeadId);
    $companyTaxName = get_field('invTax_name','user_' . $agentLeadId);
    $companyTaxValue = get_field('invTax_value','user_' . $agentLeadId);
    $companyInstructions = get_field('invIpi','user_' . $agentLeadId);
    $companyLogo = get_field('invLogo','user_' . $agentLeadId);
}
else {
    $companyName = get_field('company_name','options');
    $companyAddress = get_field('address','options');
    $companyEmail = get_field('email','options');
    $companyPhone = get_field('phone','options');
    $companyTaxName = get_field('tax_name','options');
    $companyTaxValue = get_field('tax_value','options');
    $companyInstructions = get_field('ipi','options');
    $companyLogo = get_field('logo','options');
}

$tax_name = $companyTaxName;
$tax_value = $companyTaxValue;

$milestone_id = get_field('milestone_id',$invoice_id) - 1;
$payments = get_field('payments',$quote_id);
$adjustments = $payments[$milestone_id]['adjustments'];

$adj_price = 0;
if(is_array($adjustments)) {
        foreach($adjustments as $adjz) {

                $adj_price = $adj_price + $adjz['price'];

        }
}

$taxless_price = ($total + $adj_price)/$tax_value; $tax_price = ($total + $adj_price) - $taxless_price;
$taxless_price = round($taxless_price,2); $taxless_price = number_format($taxless_price, 2, '.', '');
$tax_price = round($tax_price,2); $tax_price = number_format($tax_price, 2, '.', '');

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
<div class="page animsition">

        <?php get_template_part('invoice-templates/sidebars/sidebar','client'); ?>

        <div class="page-main">

        <div class="page-content">
                <!-- Panel -->
                <div class="panel">
                        <div class="panel-body container-fluid">
                                <div class="row">
                                        <div class="col-md-6">
                                                        <?php $logo = $companyLogo; $size = "medium"; $clogo = wp_get_attachment_image_src( $logo, $size ); ?>
                                                        <img class="margin-bottom-20 invoice_logo" src="<?php echo $clogo[0]; ?>" alt="<?php the_field('company_name','options'); ?>">
                                                        <address>
                                                            <p><?php echo $companyAddress; ?></p>
                                                            <p>E-mail:&nbsp;&nbsp;<?php echo $companyEmail; ?></p>
                                                            <p>Phone:&nbsp;&nbsp;<?php echo $companyPhone; ?></p>
                                                          <p>ABN: 69612882158</p>
                                                        </address>
                                                </div>
                                                <div class="col-md-6 text-right">
                                                        <h4>Invoice Info</h4>

                                                        <p>
                                                                <div class="font-size-20">#<?php the_field('number'); ?></div>
                                                                <br> To:
                                                                <br>
                                                                <span class="font-size-20"><?php echo $client_data->first_name; ?> <?php echo $client_data->last_name; ?></span>
                                                        </p>
                                                        <address>
                                                                <p><?php echo $client_data->address; ?></p>
                                                                <p>E-mail:&nbsp;&nbsp;<?php echo $client_data->email; ?></p>
                                                                <p>Phone:&nbsp;&nbsp;<?php echo $client_data->phone; ?></p>
                                                        </address>
                                                        <span>Invoice Date: <?php echo $invoice_date_temp; ?></span>
                                                        <br>
                                                        <span>Due Date: <?php echo $invoice_duedate; ?></span>
                                                </div>
                                        </div>
                                        <div class="page-invoice-table table-responsive">
                                                <table class="table text-right">
                                                        <thead>
                                                                <tr>
                                                                        <th class="text-center">#</th>
                                                                        <th>Description</th>
                                                                        <th class="text-right">Quantity</th>
                                                                        <th class="text-right">Unit Cost</th>
                                                                        <th class="text-right">Total</th>
                                                                </tr>
                                                        </thead>
                                                        <tbody>
                                                                <tr>
                                                                        <td class="text-center">
                                                                                1
                                                                        </td>
                                                                        <td class="text-left">
                                                                                <?php the_field('milestone_title'); ?> <span class='grey-500'>(%<?php the_field('milestone_percent'); ?> of total)</span>
                                                                        </td>
                                                                        <td>
                                                                                1
                                                                        </td>
                                                                        <td>
                                                                                $<?php echo $total; ?>
                                                                        </td>
                                                                        <td>
                                                                                $<?php echo $total; ?>
                                                                        </td>
                                                                </tr>
                                                                <?php $a=1; if(is_array($adjustments)) : foreach($adjustments as $adj) : $a++;?>
                                                                        <tr style="background: #F9F9F9;">
                                                                                <td class="text-center">
                                                                                        <?php echo $a; ?>
                                                                                </td>
                                                                                <td class="text-left">
                                                                                        <?php echo $adj['title']; ?>
                                                                                </td>
                                                                                <td>
                                                                                        1
                                                                                </td>
                                                                                <td>
                                                                                        $<?php echo number_format($adj['price'], 2, '.', ''); ?>
                                                                                </td>
                                                                                <td>
                                                                                        $<?php echo number_format($adj['price'], 2, '.', ''); ?>
                                                                                </td>
                                                                        </tr>
                                                                <?php endforeach; endif; ?>
                                                        </tbody>
                                                </table>
                                        </div>
                                        <div class="text-right clearfix">
                                                <div class="pull-right">

                                                        <p>Sub - Total amount:
                                                                <span>$<?php echo $taxless_price; ?></span>
                                                        </p>
                                                        <p><?php echo $tax_name; ?>:
                                                                <span>$<?php echo $tax_price?></span>
                                                        </p>
                                                        <p class="page-invoice-amount">Grand Total:
                                                                <span>$<?php echo $total + $adj_price; ?></span>
                                                        </p>
                                                </div>
                                        </div>
                                        <div class="text-left">
                                    <?php $stripay = ($total + $adj_price) * 100; ?>
                                               <h4>Payment Instructions</h4>
                                         <?php  echo do_shortcode( '[stripe name="Paynt" prefill_email="true" description="' .$payment['title']. '" amount="' .$stripay. '"]' ); ?>
                                               <?php echo $companyInstructions; ?>
                                        </div>
                                        <div class="text-right">
                                                        <a href="<?php bloginfo('url'); ?>/tcpdf/invoice/invoice.php?invoice_id=<?php echo $invoice_id; ?>" class="btn btn-primary">PDF</a>
                                        </div>
                                </div>

                        </div>
                        <!-- End Panel -->
                </div>
        </div>

</div>

<?php get_footer(); ?>
