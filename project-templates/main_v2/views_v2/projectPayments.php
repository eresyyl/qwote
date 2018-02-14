<?php
require_once( ABSPATH . 'wp-load.php');
// getting defaults
$currentUserId = current_user_id();
$projectId = get_the_ID();

$projectPayments = get_field('payments',$projectId);
$projectTotal = get_field('total',$projectId);


$projectPaid = get_field('paid',$projectId);
if(!$projectPaid) { $projectPaid = 0; }
$projectPaid = number_format($projectPaid, 2, '.', '');
$projectToPay = get_field('topay',$projectId);
if(!$projectToPay) { $projectToPay = 0; }
$projectToPay = number_format($projectToPay, 2, '.', '');
?>

<?php // Project milestones ?>
<div class="panel">
    <div class="panel-heading">
       <?php if(!is_contractor()) : ?> <ul class="panel-info">
            <li>
                <div class="num blue-600">$
                    <?php echo $projectTotal; ?>
                </div>
                <p>Total</p>
            </li>
        </ul><?php endif; ?>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Description</th>
                        <?php if(!is_contractor()) : ?> <th>Total</th>
                        <th class="text-center">Actions</th><?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if($projectPayments) : $i=0;
                    foreach($projectPayments as $payment) : $i++; ?>
                        <?php // get payment (milestone data)
                        $percent = $payment['percent'];
                        $price = ($percent * $projectTotal) / 100;
                        $price = number_format($price, 2, '.', '');
                        $stripay = $price * 100;
                        if($payment['status'] == 'pending') {
                            $status_class = "default";
                        }
                        elseif($payment['status'] == 'active') {
                            $status_class = "info";
                        }
                        elseif($payment['status'] == 'done') {
                            $status_class = "primary";
                        }
                        elseif($payment['status'] == 'paid') {
                            $status_class = "success";
                        }
                        ?>
                        <tr id="payment_<?php echo $i; ?>">
                            <td class="work-status" style="width:10%;">
                                <span class="label label-<?php echo $status_class; ?>" style="text-transform: capitalize;"><?php echo $payment['status']; ?>
                            </span>
                          </td>
                            <td class="date" style="width:15%;">
                                <span class="blue-grey-400"><?php echo $payment['due_date']; ?>
                            </td>
                            <td class="subject">
                                <div class="table-content">
                                    <p class="blue-grey-500">
                                        <?php echo $payment['title']; ?>
                                    </p>
                                    <p class="blue-grey-400">
                                        <?php echo $payment['description']; ?>
                                    </p>
                                </div>
                            </td>
                            <?php if(!is_contractor()) : ?>
                            <td class="total">
                                <span class="blue-grey-800">$<?php echo $price; ?></span>
                                <p class="blue-grey-400">
                                    (% <?php echo $percent; ?> of total)
                                </p>
                                
                              <?php if($payment['status'] == 'done'): ?><?php  echo do_shortcode( '[stripe name="Paynt" prefill_email="true" description="' .$payment['title']. '" amount="' .$stripay. '"]' ); ?><?php endif; ?>
                            </td>
                            <td class="actions text-center">
                                <div class="table-content">
                                    <?php
                                    if($payment['status'] == 'pending') {
                                        go_payment_actions(array('adjust'),$quote_id,$i);
                                    }
                                    elseif($payment['status'] == 'active') {
                                        go_payment_actions(array('mark_done','adjust'),$quote_id,$i);
                                    }
                                    elseif($payment['status'] == 'done') {
                                        go_payment_actions(array('done','invoice','mark_paid'),$quote_id,$i);
                                    }
                                    elseif($payment['status'] == 'paid') {
                                        go_payment_actions(array('done','invoice','paid'),$quote_id,$i);
                                    }
                                    ?>
                                </div>

                            </td>
                        </tr>
                        <?php endif; ?>
                        <?php if(is_array($payment['adjustments'])) : $j=0;
                        foreach($payment['adjustments'] as $adj) : $j++; ?>
                            <tr style="background: #F9F9F9;">
                                <td style="padding: 10px 8px;"></td>
                                <td style="padding: 10px 8px;" class="text-center">
                                    <i data-toggle='tooltip' data-placement='top' data-trigger='hover' data-original-title='Milestone adjustment' title='' class="icon wb-help-circle grey-400"></i>
                                </td>
                                <td style="padding: 10px 8px;">
                                    <p class="blue-grey-500">
                                        <?php echo $adj['title']; ?>
                                    </p>
                                    <p class="blue-grey-400">
                                        <?php echo $adj['description']; ?>
                                    </p>
                                </td>
                                <td style="padding: 10px 8px;">
                                    $
                                    <?php echo $adj['price']; ?>
                                </td>
                                <td style="padding: 10px 8px;" class="text-center">
                                    <?php if($payment['status'] == 'pending' || $payment['status'] == 'active') : ?>
                                        <a style="cursor:pointer;" class="delete_adjustment" data-quote='<?php echo $quote_id; ?>' data-milestone='<?php echo $i; ?>' data-adj='<?php echo $j; ?>' data-toggle='tooltip' data-placement='left' data-trigger='hover' data-original-title='Remove adjustment'
                                            title=''><i class="icon wb-close-mini red-600"></i></a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; endif; ?>
                    <?php endforeach; else : ?>
                        <tr class="text-center">
                            <td colspan="5">
                                There are no payments yet.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div id="adjust_response"></div>
    </div>
</div>
