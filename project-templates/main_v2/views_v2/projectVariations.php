<?php
require_once( ABSPATH . 'wp-load.php');
// getting defaults
$currentUserId = current_user_id();
$projectId = get_the_ID();

$projectPayments = get_field('add_payments',$projectId);
?>

<?php // Project milestones ?>
<div class="panel">
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Description</th>
                        <?php if(!is_contractor()) : ?> <th>Total</th><?php endif; ?>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($projectPayments) : $i=0;
                    foreach($projectPayments as $payment) : $i++; ?>
                        <?php // get payment (milestone data)
                        $percent = $payment['percent'];
                        $price = number_format($percent, 2, '.', '');
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
                                <span class="label label-<?php echo $status_class; ?>" style="text-transform: capitalize;"><?php echo $payment['status']; ?></span>
                            </td>
                            <td class="date" style="width:15%;">
                                <span class="blue-grey-400"><?php echo $payment['due_date']; ?></span>
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
                              <?php if($payment['status'] == 'done'): ?><?php  echo do_shortcode( '[stripe name="Paynt" prefill_email="true" description="' .$payment['title']. '" amount="' .$stripay. '"]' ); ?><?php endif; ?>
                          </td>
                          
                          <?php endif; ?>
                           <?php if(!is_contractor()) : ?> <td class="actions text-center">
                                <div class="table-content">
                                    <?php
                                    if($payment['status'] == 'pending') {
                                        go_variaton_actions(array(),$quote_id,$i);
                                    }
                                    elseif($payment['status'] == 'active') {
                                        go_variaton_actions(array('mark_done'),$quote_id,$i);
                                    }
                                    elseif($payment['status'] == 'done') {
                                        go_variaton_actions(array('done','invoice','mark_paid'),$quote_id,$i);
                                    }
                                    elseif($payment['status'] == 'paid') {
                                        go_variaton_actions(array('done','invoice','paid'),$quote_id,$i);
                                    }
                                    ?>
                                </div>
                            </td><?php endif; ?>
                        </tr>
                    <?php endforeach; else : ?>
                        <tr class="text-center">
                            <td colspan="5">
                                There are no variations yet.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
