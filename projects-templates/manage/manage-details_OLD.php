<?php
$quote_id = $_GET['quote_id'];
$single = $_GET['single'];
$status = go_project_status($quote_id);
$status_add_contractor = go_project_status($quote_id);
$total = get_field('total',$quote_id); $total = round($total,2); $total = number_format($total, 2, '.', '');
$paid = get_field('paid',$quote_id); $paid = round($paid,2); $paid = number_format($paid, 2, '.', '');
$topay = get_field('topay',$quote_id); $topay = round($topay,2); $topay = number_format($topay, 2, '.', '');
$selections = get_field('selections',$quote_id);
$payments = get_field('payments',$quote_id);
$add_payments = get_field('add_payments',$quote_id);
$schedule = get_field('schedule',$quote_id);

$client_id = get_field('client_id',$quote_id);
if($client_id[0] == NULL) {
        $client_id = $client_id['ID'];
}
else {
        $client_id = $client_id[0];
}
$client = go_userdata($client_id);
$agent_id = get_field('agent_id',$quote_id);
if($agent_id){
        if($agent_id[0] == NULL) {
                $agent_id = $agent_id['ID'];
        }
        else {
                $agent_id = $agent_id[0];
        } 
        $agent_info = go_userdata($agent_id);
}        

$client_approved = get_field('client_approve',$quote_id);
$agent_approved = get_field('agent_approve',$quote_id);

$client_string = get_field('client','options');
$contractor_string = get_field('contractor','options');

?>
<header class="slidePanel-header bg-blue-600">
        <div class="slidePanel-actions" aria-label="actions" role="group">
                <button type="button" class="btn btn-pure btn-inverse slidePanel-close actions-top icon wb-close"
                aria-hidden="true"></button>
        </div>
        <span class="label label-<?php echo $status->status_class; ?>"><?php echo $status->status_string; ?></span>
        <h1><?php echo go_generate_title($quote_id); ?></h1>
</header>
<div class="slidePanel-inner">
  
        <section class="slidePanel-inner-section">
    
                <div class="step-info">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="step">
                                        <span class="step-numbers blue-600">$<?php echo $total; ?></span>
                                        <div class="step-desc">
                                                <span class="step-title">Total</span>
                                                <p>Amount</p>
                                        </div>
                                </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="step">
                                        <span class="step-numbers green-600">$<?php echo $paid; ?></span>
                                        <div class="step-desc">
                                                <span class="step-title">Paid</span>
                                                <p>Amount</p>
                                        </div>
                                </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="step">
                                        <span class="step-numbers red-600">$<?php echo $topay; ?></span>
                                        <div class="step-desc">
                                                <span class="step-title">To</span>
                                                <p>Pay</p>
                                        </div>
                                </div>
                        </div>
                </div>
                
                <div class="row">
                     <div class="col-md-6">
                             <div class="widget widget-shadow">
                                     <div class="widget-header padding-10 bg-grey-100">
                                             <a class="avatar avatar-lg pull-left margin-right-20" href="javascript:void(0)">
                                                     <img src="<?php echo $client->avatar; ?>" alt="">
                                             </a>
                                             <div class="vertical-align text-right height-80 text-truncate">
                                                     <div class="vertical-align-middle">
                                                             <div class="font-size-16 margin-bottom-5 blue-600 text-truncate"><?php echo $client->first_name; ?> <?php echo $client->last_name; ?><br/><?php echo $client->phone; ?><br/><?php echo $client->email; ?></div>
                                                             <div class="font-size-12 text-truncate"><?php echo $client_string; ?> <?php if($client_approved == true) { echo "<span class='green-600'>(approved)</span>"; } else { echo "<span class='grey-400'>(not approved yet)</span>"; } ?></div>
                                                     </div>
                                             </div>
                                     </div>
                             </div>
                     </div>
                     <div class="col-md-6">
                             <div class="widget widget-shadow">
                                     <div class="widget-header padding-10 bg-blue-100">
                                             <?php if($agent_id) : ?>
                                             <a class="avatar avatar-lg pull-right margin-left-20" href="javascript:void(0)">
                                                     <img src="<?php echo $agent_info->avatar; ?>" alt="">
                                             </a>
                                             <?php endif; ?>
                                             <div class="vertical-align text-left height-60 text-truncate">
                                                     <div class="vertical-align-middle">
                                                             <?php if($agent_id) : ?>
                                                                     <div class="font-size-16 margin-bottom-5 blue-600 text-truncate"><?php echo $agent_info->first_name; ?> <?php echo $agent_info->last_name; ?><br/><?php echo $agent_info->phone; ?><br/><?php echo $agent_info->email; ?></div>
                                                                     <div class="font-size-12 text-truncate"><?php echo $contractor_string; ?></div>
                                                             <?php else : ?>
                                                                     <div class="font-size-14 margin-bottom-5 blue-600 text-truncate">No <?php echo $contractor_string; ?> selected</div>
                                                             <?php endif; ?>
                                                             
                                                     </div>
                                             </div>
                                     </div>
                             </div>
                     </div>   
                </div>
                
                <div class="row">
                        <div class="col-md-12">
                                
                                <div style='cursor:pointer; position:relative;' class="padding-vertical-10" data-toggle="collapse" href="#manage_title" aria-expanded="false" aria-controls="manage_title"><h4 color='blue-grey-800'><i class="icon wb-plus"></i> Manage Title</h4></div>
                                
                                <div class="collapse" id="manage_title">
                                        <form id="title">
                                        <input type="hidden" name="quote_id" value="<?php echo $quote_id; ?>">
                                        <?php $title = get_the_title($quote_id); ?>
                                                <div class="row">
                                                        <div class="col-md-12 col-xs-12">
                                                                <h5 class='grey-800'>Custom Title</h5>
                                                                <div class="form-group">
                                                                        <input type="text" class="form-control input-sm" value="<?php echo $title; ?>" name="title">
                                                                </div>
                                                        </div>
                                                </div>
                                        </form>
                                        <div id="title_response">
                                                <?php // AJAX response after price save will be loaded here ?>
                                        </div>
                                        
                                        <div class="row">
                                             <div class="col-md-12 col-xs-12 text-center"><a class="btn btn-primary save_title">Save Title</a></div>   
                                        </div>
                                        
                                </div>
                                
                                
                                <div style='cursor:pointer; position:relative;' class="padding-vertical-10" data-toggle="collapse" href="#manage_price" aria-expanded="false" aria-controls="manage_price"><h4 color='blue-grey-800'><i class="icon wb-plus"></i> Manage Price</h4></div>
                                
                                <div class="collapse" id="manage_price">
                                        <form id="price">
                                        <input type="hidden" name="quote_id" value="<?php echo $quote_id; ?>">
                                                <div class="row">
                                                        <div class="col-md-12 col-xs-12">
                                                                <h5 class='grey-800'>Total Price, $</h5>
                                                                <div class="form-group">
                                                                        <input type="number" min="1" class="form-control input-sm" value="<?php echo $total; ?>" name="total_price">
                                                                </div>
                                                        </div>
                                                </div>
                                        </form>
                                        <div id="price_response">
                                                <?php // AJAX response after price save will be loaded here ?>
                                        </div>
                                        
                                        <div class="row">
                                             <div class="col-md-12 col-xs-12 text-center"><a class="btn btn-primary save_price">Save Price</a></div>   
                                        </div>
                                        
                                </div>
                                
                                
                                <div style='cursor:pointer; position:relative;' class="padding-vertical-10" data-toggle="collapse" href="#manage_due" aria-expanded="false" aria-controls="manage_due"><h4 color='blue-grey-800'><i class="icon wb-plus"></i> Manage Invoice Due Date</h4></div>
                                
                                <div class="collapse" id="manage_due">
                                        <form id="due">
                                        <input type="hidden" name="quote_id" value="<?php echo $quote_id; ?>">
                                                <div class="row">
                                                        <div class="col-md-12 col-xs-12">
                                                                <h5 class='grey-800'>Invoice Due Date</h5>
                                                                <div class="form-group">
                                                                        <?php $due = get_field('due',$quote_id); ?>
                                                                        <select name="due_date" class="form-control">
                                                                                <option value="0" <?php if($due == '0') { echo "selected"; } ?>>Due on receipt</option>
                                                                                <option value="3" <?php if($due == '3') { echo "selected"; } ?>>3 days</option>
                                                                                <option value="7" <?php if($due == '7') { echo "selected"; } ?>>7 days</option>
                                                                                <option value="15" <?php if($due == '15') { echo "selected"; } ?>>15 days</option>
                                                                                <option value="30" <?php if($due == '30') { echo "selected"; } ?>>30 days</option>
                                                                        </select>
                                                                </div>
                                                        </div>
                                                </div>
                                        </form>
                                        <div id="due_response">
                                                <?php // AJAX response after price save will be loaded here ?>
                                        </div>
                                        
                                        <div class="row">
                                             <div class="col-md-12 col-xs-12 text-center"><a class="btn btn-primary save_due">Save Due Date</a></div>   
                                        </div>
                                        
                                </div>
                                
                                <div style='cursor:pointer; position:relative;' class="padding-vertical-10" data-toggle="collapse" href="#select_selections" aria-expanded="false" aria-controls="select_selections"><h4 color='blue-grey-800'><i class="icon wb-plus"></i> Select Selections</h4></div>
                                
                                <div class="collapse selections_block" id="select_selections">
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
                                        
                                        <style>
                                        .select_selection_remove {
                                                cursor:pointer;
                                                color:#f96868;
                                        }
                                        .select_selection_add {
                                                cursor:pointer;
                                                color:#46be8a;
                                        }
                                        .dataTables_filter, .dataTables_paginate {
                                                text-align:right;
                                        }
                                        .dataTables_filter input {
                                                margin-left:10px;
                                        }
                                        </style>
                                        
                                        <div class="table-responsive">
					<table class="table contacts_table" id="default_selections" >
						<thead class="don_not_show">
							<tr>
                                                                <th style="width:10%"></th>
								<th >Title</th>
								<th >Price</th>
								<th >Budget</th>
							</tr>
						</thead>
						<tbody>
                                                        
                                                        <?php 
                                                        $default_selections = get_field('default_selections',$quote_id);
                                                        if(!$default_selections) { $default_selections = array(); }
                                                        $quote_templates = get_field('templates',$quote_id);
                                                        $selections_args = array(
                                                               'post_per_page' => 9999,
                                                               'post_type' => 'selection',
                                                        );
                                                        $select_selections = get_posts($selections_args); 
                                                        foreach($select_selections as $selection) : 
                                                        if(!is_array($quote_templates)) {
                                                                $quote_templates = array(intval($quote_templates));
                                                        }
                                                        $selection_templates = get_field('assigned_template',$selection->ID);
                                                        $result = array_intersect($selection_templates, $quote_templates);
                                                        $result_count = count($result);
                                                        if($result_count > 0) :
                                                        ?>
                                                        <tr>
                                                                <td class="text-center" style="width:10%" id="selection_<?php echo $selection->ID; ?>">
                                                                        <?php if(in_array($selection->ID,$default_selections)) { $selected = true; } else { $selected = false; } ?>
                                                                        <?php if($selected == true) : ?>
                                                                                <a data-selection="<?php echo $selection->ID; ?>" class="select_selection_remove"><i class="fa fa-minus"></i></a>
                                                                        <?php else : ?>
                                                                                <a data-selection="<?php echo $selection->ID; ?>" class="select_selection_add"><i class="fa fa-plus"></i></a>
                                                                        <?php endif; ?>
                                                                </td>
                                                                <td>
                                                                        <?php echo get_field('selection_name',$selection->ID);?>
                                                                </td>
                                                                <td>
                                                                        $<?php echo get_field('selection_price',$selection->ID);?>
                                                                </td>
                                                                <td>
                                                                        $<?php echo get_field('selection_budget',$selection->ID);?>
                                                                </td>
                                                        </tr>
                                                <?php endif; endforeach; ?>
                                                </tbody>
                                        </table>
                                        </div>
                                </div>
                                
                                
                                <div style='cursor:pointer; position:relative;' class="padding-vertical-10" data-toggle="collapse" href="#manage_selections" aria-expanded="false" aria-controls="manage_selections"><h4 color='blue-grey-800'><i class="icon wb-plus"></i> Manage Selections</h4></div>
                                
                                <div class="collapse selections_block" id="manage_selections">
                                                
                                        <form id="slide_selections">
                                        <input type="hidden" name="quote_id" value="<?php echo $quote_id; ?>">
                                                
                                        <?php if($selections) : $i=0; foreach($selections as $s) : $i++; 
                                                $title = $s['title'];
                                                $price = $s['price'];
                                                $pc_sum = $s['pc_sum'];
                                                $description = $s['description'];
                                                $photo = $s['photo'];
                                                if($photo) {
                                        		$size = "full";
                                        		$photo_proceed = wp_get_attachment_image_src( $photo, $size );
                                        		$photo_url = $photo_proceed[0];   
                                                        $photo_title = get_the_title($photo);
                                                }
                                        ?>
                                                <div class="panel bg-grey-100 margin-top-0 margin-bottom-10 selections">
                                                        <div class="panel-body">
                                                              <div class="row">
                                                                      <div class="col-md-12 col-xs-12">
                                                                              <h5 class='grey-800'>Title</h5>
                                                                              <div class="form-group">
                                                                                      <input type="text" class="form-control input-sm" value="<?php echo $title; ?>" name="title[]" data-fv-notempty="true" data-fv-notempty-message="This is required" data-fv-field="title">
                                                                              </div>
                                                                      </div>
                                                              </div>
                                                              <div class="row">
                                                                      <div class="col-md-12 col-xs-12">
                                                                              <h5 class='grey-800'>Description</h5>
                                                                              <div class="form-group">
                                                                                      <textarea name="description[]" class="form-control input-sm quote_textarea"><?php echo $description; ?></textarea>
                                                                              </div>
                                                                      </div>
                                                              </div>
                                                              <div class="row">  
                                                                      <div class="col-md-4 col-xs-12">
                                                                              <h5 class='grey-800'>Price, $</h5>
                                                                              <div class="form-group">
                                                                                      <input type="text" class="form-control input-sm" value="<?php echo $price; ?>" name="price[]">
                                                                              </div>
                                                                      </div>
																																      <div class="col-md-4 col-xs-12">
                                                                              <h5 class='grey-800'>PC Sum, $</h5>
                                                                              <div class="form-group">
                                                                                      <input type="text" class="form-control input-sm" value="<?php echo $pc_sum; ?>" name="pc_sum[]">
                                                                              </div>
                                                                      </div>
                                                                      <div class="col-md-4 col-xs-12">
                                                                              <h5 class='grey-800'>Photo</h5>
                                                                              <div class="form-group">
                                                                                      <?php if($photo) : ?>
                                                                                              <input type='hidden' name='photo[]' value='<?php echo $photo; ?>'>
                                                                                              <i class='fa fa-check-circle light-green-800'></i> <?php echo $photo_title; ?>
                                                                                      <?php else : ?>
                                                                                              <input type="file" class="form-control input-sm file_upload" name="photo[]" id="photo_<?php echo $i; ?>">
                                                                                              <div class='photo_<?php echo $i; ?>'><input type='hidden' name='photo[]' value=''></div>
                                                                                              <script>$('#photo_<?php echo $i; ?>').change(function(){ UploadSelection('photo_<?php echo $i; ?>'); });</script>
                                                                                      <?php endif; ?>
                                                                              </div>
                                                                      </div> 
                                                              </div>
                                                              <div class="row">
                                                                  <div class="col-md-12 text-right">
                                                                          <a class="btn btn-pure btn-danger icon wb-close remove_selection"></a>
                                                                  </div>    
                                                              </div>
                                                        </div>
                                                </div>
                                                
                                        <?php endforeach; 
                                        else : ?>
                                                
                                                <div class="panel bg-grey-100 margin-top-0 margin-bottom-10 selections">
                                                        <div class="panel-body">
                                                              <div class="row">
                                                                      <div class="col-md-12 col-xs-12">
                                                                              <h5 class='grey-800'>Title</h5>
                                                                              <div class="form-group">
                                                                                      <input type="text" class="form-control input-sm" value="" name="title[]" data-fv-notempty="true" data-fv-notempty-message="This is required" data-fv-field="title">
                                                                              </div>
                                                                      </div>
                                                              </div>
                                                              <div class="row">
                                                                      <div class="col-md-12 col-xs-12">
                                                                              <h5 class='grey-800'>Description</h5>
                                                                              <div class="form-group">
                                                                                      <textarea name="description[]" class="form-control input-sm quote_textarea"></textarea>
                                                                              </div>
                                                                      </div>
                                                              </div>
                                                              <div class="row">  
                                                                      <div class="col-md-4 col-xs-12">
                                                                              <h5 class='grey-800'>Price, $</h5>
                                                                              <div class="form-group">
                                                                                      <input type="text" class="form-control input-sm" value="" name="price[]">
                                                                              </div>
                                                                      </div> 
																																     <div class="col-md-4 col-xs-12">
                                                                              <h5 class='grey-800'>PC Sum, $</h5>
                                                                              <div class="form-group">
                                                                                      <input type="text" class="form-control input-sm" value="" name="pc_sum[]">
                                                                              </div>
                                                                      </div>
                                                                      <div class="col-md-4 col-xs-12">
                                                                              <h5 class='grey-800'>Photo</h5>
                                                                              <div class="form-group">
                                                                                              <input type="file" class="form-control input-sm file_upload" name="photo[]" id="photo_0">
                                                                                              <div class='photo_0'><input type='hidden' name='photo[]' value=''></div>
                                                                                              <script>$('#photo_0').change(function(){ UploadSelection('photo_0'); });</script>
                                                                              </div>
                                                                      </div> 
                                                              </div>
                                                              <div class="row">
                                                                  <div class="col-md-12 text-right">
                                                                          <a class="btn btn-pure btn-danger icon wb-close remove_selection"></a>
                                                                  </div>    
                                                              </div>
                                                        </div>
                                                </div>
                                                
                                        <?php endif; ?>
                                        
                                        <div class="selections_section">
                                                <?php // new selections forms will be loaded here ?>
                                        </div>
                                        
                                        </form>
                                        
                                        <div id="manage_response">
                                                <?php // AJAX response after selections save will be loaded here ?>
                                        </div>
                                        
                                        <div class="row">
                                             <div class="col-md-6 col-xs-6 text-center"><a class="btn btn-primary slide_save_selections">Save Selections</a></div>
                                             <div class="col-md-6 col-xs-6 text-center"><a class="btn btn-default add_selection">Add New</a></div>   
                                        </div>
                                                
                                        
                                </div>
                                
                                <div style='cursor:pointer;' class="padding-vertical-10" data-toggle="collapse" href="#manage_contract" aria-expanded="false" aria-controls="manage_contract"><h4 color='blue-grey-800'><i class="icon wb-plus"></i> Manage Contract</h4></div>
                                
                                <div class="collapse" id="manage_contract">
																	
                                        <form id="contract">
                                                <input type="hidden" name="quote_id" value="<?php echo $quote_id; ?>">
																					
                                                <textarea name="contract" class="quote_textarea contract_area"><?php echo get_field('contract',$quote_id);?></textarea>
                                        </form>
                                        <div id="contract_response">
                                                <?php // AJAX response after contract save will be loaded here ?>
                                        </div>
                                        
                                        <div class="row">
                                             <div class="col-md-12 col-xs-12 text-center"><a class="btn btn-primary save_contract">Save Contract</a></div>   
                                        </div>
                                </div>
                                
                                <div style='cursor:pointer;' class="padding-vertical-10" data-toggle="collapse" href="#manage_payments" aria-expanded="false" aria-controls="manage_payments"><h4 color='blue-grey-800'><i class="icon wb-plus"></i> Manage Payments</h4></div>
                                
                                <div class="collapse payments_block" id="manage_payments">
                                        
                                        <form id="payments_manage">
                                        <input type="hidden" name="quote_id" value="<?php echo $quote_id; ?>">
                                        
                                        <div class="payments_fields">
                                        
                                                <?php if($payments) : $i=0; foreach($payments as $pay) : $i++; 
                                                        $title = $pay['title'];
                                                        $description = $pay['description'];
                                                        $percent = $pay['percent'];
                                                        $due_date = $pay['due_date'];
                                                        $done = $pay['done'];
                                                        $paid = $pay['paid'];
                                                        $status_p = $pay['status'];
                                                        $invoice = $pay['invoice_id'];
                                                ?>
                                                        <div class="panel bg-grey-100 margin-top-0 margin-bottom-10 payments">
                                                                <input type="hidden" name="done[]" value="<?php if($done == true) { echo "true"; } else { echo "false"; } ?>">
                                                                <input type="hidden" name="paid[]" value="<?php if($paid == true) { echo "true"; } else { echo "false"; } ?>">
                                                                <input type="hidden" name="status[]" value="<?php echo $status_p; ?>">
                                                                <input type="hidden" name="invoice_id[]" value="<?php echo $invoice; ?>">
                                                                <div class="panel-body">
                                                                      <div class="row">
                                                                              <div class="col-md-12 col-xs-12">
                                                                                      <h5 class='grey-800'>Title</h5>
                                                                                      <div class="form-group">
                                                                                              <input type="text" class="form-control input-sm titles" value="<?php echo $title; ?>" name="title[]">
                                                                                      </div>
                                                                              </div>
                                                                      </div>
                                                                      <div class="row">
                                                                              <div class="col-md-12 col-xs-12">
                                                                                      <h5 class='grey-800'>Description</h5>
                                                                                      <div class="form-group">
                                                                                              <textarea type="text" class="form-control input-sm quote_textarea" name="description[]"><?php echo $description; ?></textarea>
                                                                                      </div>
                                                                              </div>
                                                                      </div>
                                                                      <div class="row">  
                                                                              <div class="col-md-6 col-xs-12">
                                                                                      <h5 class='grey-800'>Percent, %</h5>
                                                                                      <div class="form-group">
                                                                                              <input type="number" min="1" max="100" step="1" class="form-control input-sm percents" value="<?php echo $percent; ?>" name="percent[]">
                                                                                      </div>
                                                                              </div>
                                                                              <div class="col-md-6 col-xs-12">
                                                                                      <h5 class='grey-800'>Due Date</h5>
                                                                                      <div class="form-group">
                                                                                              <input type="text" data-plugin="datepicker" class="form-control input-sm datepicker dates" value="<?php echo $due_date; ?>" name="date[]">
                                                                                      </div>
                                                                              </div> 
                                                                      </div>
                                                                      <div class="row">
                                                                          <div class="col-md-3 padding-vertical-10">
                                                                                  Status: <?php echo $status_p; ?>
                                                                          </div>
                                                                          <div class="col-md-3 padding-vertical-10">
                                                                                  <?php if($done == true) : ?>
                                                                                                  <div><i class="fa fa-check-circle light-green-800"></i> Market as Done</div>
                                                                                  <?php endif; ?>
                                                                          </div>
                                                                          <div class="col-md-3 padding-vertical-10">
                                                                                  <?php if($paid == true) : ?>
                                                                                                  <div><i class="icon wb-order light-green-800"></i> Market as Paid</div>
                                                                                  <?php endif; ?>
                                                                          </div>
                                                                          <div class="col-md-3 text-right">
                                                                                  <a class="btn btn-pure btn-danger icon wb-close remove_payment"></a>
                                                                          </div>    
                                                                      </div>
                                                                </div>
                                                        </div>
                                                
                                                <?php endforeach; 
                                                else : ?>
                                                
                                                        <div class="panel bg-grey-100 margin-top-0 margin-bottom-10 payments">
                                                                <input type="hidden" name="done[]" value="false">
                                                                <input type="hidden" name="paid[]" value="false">
                                                                <input type="hidden" name="status[]" value="pending">
                                                                <input type="hidden" name="invoice_id[]" value="">
                                                                <div class="panel-body">
                                                                      <div class="row">
                                                                              <div class="col-md-12 col-xs-12">
                                                                                      <h5 class='grey-800'>Title</h5>
                                                                                      <div class="form-group">
                                                                                              <input type="text" class="form-control input-sm titles" name="title[]">
                                                                                      </div>
                                                                              </div>
                                                                      </div>
                                                                      <div class="row">
                                                                              <div class="col-md-12 col-xs-12">
                                                                                      <h5 class='grey-800'>Description</h5>
                                                                                      <div class="form-group">
                                                                                              <textarea type="text" class="form-control input-sm quote_textarea" name="description[]"></textarea>
                                                                                      </div>
                                                                              </div>
                                                                      </div>
                                                                      <div class="row">  
                                                                              <div class="col-md-6 col-xs-12">
                                                                                      <h5 class='grey-800'>Percent, %</h5>
                                                                                      <div class="form-group">
                                                                                              <input type="number" min="1" max="100" step="1" class="form-control input-sm percents" name="percent[]">
                                                                                      </div>
                                                                              </div>
                                                                              <div class="col-md-6 col-xs-12">
                                                                                      <h5 class='grey-800'>Due Date</h5>
                                                                                      <div class="form-group">
                                                                                              <input type="text" data-plugin="datepicker" class="form-control input-sm datepicker dates" name="date[]">
                                                                                      </div>
                                                                              </div> 
                                                                      </div>
                                                                      <div class="row">
                                                                          <div class="col-md-12 text-right">
                                                                                  <a class="btn btn-pure btn-danger icon wb-close remove_payment"></a>
                                                                          </div>    
                                                                      </div>
                                                                </div>
                                                        </div>
                                                
                                                <?php endif; ?>
                                               
                                               <div class="payments_section">
                                                       <?php // new payment forms will be loaded here ?>
                                               </div>
                                               
                                               </div>
                                               
                                               <?php $payment_templates = get_posts('posts_per_page=9999&post_type=payment_template'); ?>
                                               <div class="row margin-vertical-20">
                                                       <div class="col-md-12 text-center">
                                                               <p>Loading template will override all payment milestones above!</p>
                                                               
                                                               <div class="row">
                                                                       <div class="col-xs-8">
                                                                               <div class="form-group">
                                                                                       <select name="payment_template" class="form-control payment_template">
                                                                                               <option value="0">Select Payment template</option>
                                                                                               <?php foreach($payment_templates as $template) : ?>
                                                                                                       <option value="<?php echo $template->ID; ?>"><?php echo $template->post_title; ?></option>
                                                                                               <?php endforeach; ?>
                                                                                       </select>
                                                                               </div>
                                                                       </div>
                                                                       <div class="col-xs-4">
                                                                               <a class="btn btn-default load_from_template">Load from template</a>  
                                                                       </div>
                                                               </div>
                                                       </div>
                                               </div>
                                                
                                        </form>
                                        
                                        <div id="payments_response">
                                                <?php // AJAX response after payments save will be loaded here ?>
                                        </div>
                                        
                                        <div class="row">
                                             <div class="col-md-6 col-xs-6 text-center"><a class="btn btn-primary save_payments">Save Payments</a></div>
                                             <div class="col-md-6 col-xs-6 text-center"><a class="btn btn-default add_payment">Add New</a></div>   
                                        </div>
                                        
                                </div>
                                
                                <div style='cursor:pointer;' class="padding-vertical-10" data-toggle="collapse" href="#manage_add_payments" aria-expanded="false" aria-controls="manage_add_payments"><h4 color='blue-grey-800'><i class="icon wb-plus"></i> Manage Variations</h4></div>
                                
                                <div class="collapse add_payments_block" id="manage_add_payments">
                                        
                                        <form id="add_payments">
                                        <input type="hidden" name="quote_id" value="<?php echo $quote_id; ?>">
                                        
                                                <?php if($add_payments) : $i=0; foreach($add_payments as $add_pay) : $i++; 
                                                        $title = $add_pay['title'];
                                                        $description = $add_pay['description'];
                                                        $percent = $add_pay['percent'];
                                                        $due_date = $add_pay['due_date'];
                                                        $done = $add_pay['done'];
                                                        $paid = $add_pay['paid'];
                                                        $status_p = $add_pay['status'];
                                                        $invoice = $add_pay['invoice_id'];
                                                ?>
                                                        <div class="panel bg-grey-100 margin-top-0 margin-bottom-10 add_payments">
                                                                <input type="hidden" name="done[]" value="<?php if($done == true) { echo "true"; } else { echo "false"; } ?>">
                                                                <input type="hidden" name="paid[]" value="<?php if($paid == true) { echo "true"; } else { echo "false"; } ?>">
                                                                <input type="hidden" name="status[]" value="<?php echo $status_p; ?>">
                                                                <input type="hidden" name="invoice_id[]" value="<?php echo $invoice; ?>">
                                                                <div class="panel-body">
                                                                      <div class="row">
                                                                              <div class="col-md-12 col-xs-12">
                                                                                      <h5 class='grey-800'>Title</h5>
                                                                                      <div class="form-group">
                                                                                              <input type="text" class="form-control input-sm add_titles" value="<?php echo $title; ?>" name="title[]">
                                                                                      </div>
                                                                              </div>
                                                                      </div>
                                                                      <div class="row">
                                                                              <div class="col-md-12 col-xs-12">
                                                                                      <h5 class='grey-800'>Description</h5>
                                                                                      <div class="form-group">
                                                                                              <textarea type="text" class="form-control input-sm quote_textarea" name="description[]"><?php echo $description; ?></textarea>
                                                                                      </div>
                                                                              </div>
                                                                      </div>
                                                                      <div class="row">  
                                                                              <div class="col-md-6 col-xs-12">
                                                                                      <h5 class='grey-800'>Price, $</h5>
                                                                                      <div class="form-group">
                                                                                              <input type="number" class="form-control input-sm add_percents" value="<?php echo $percent; ?>" name="percent[]">
                                                                                      </div>
                                                                              </div>
                                                                              <div class="col-md-6 col-xs-12">
                                                                                      <h5 class='grey-800'>Due Date</h5>
                                                                                      <div class="form-group">
                                                                                              <input type="text" data-plugin="datepicker" class="form-control input-sm datepicker add_dates" value="<?php echo $due_date; ?>" name="date[]">
                                                                                      </div>
                                                                              </div> 
                                                                      </div>
                                                                      <div class="row">
                                                                              <div class="col-md-3 padding-vertical-10">
                                                                                      Status: <?php echo $status_p; ?>
                                                                              </div>
                                                                              <div class="col-md-3 padding-vertical-10">
                                                                                      <?php if($done == true) : ?>
                                                                                                      <div><i class="fa fa-check-circle light-green-800"></i> Market as Done</div>
                                                                                      <?php endif; ?>
                                                                              </div>
                                                                              <div class="col-md-3 padding-vertical-10">
                                                                                      <?php if($paid == true) : ?>
                                                                                                      <div><i class="icon wb-order light-green-800"></i> Market as Paid</div>
                                                                                      <?php endif; ?>
                                                                              </div>
                                                                          <div class="col-md-3 text-right">
                                                                                  <a class="btn btn-pure btn-danger icon wb-close remove_add_payment"></a>
                                                                          </div>    
                                                                      </div>
                                                                </div>
                                                        </div>
                                                
                                                <?php endforeach; 
                                                else : ?>
                                                
                                                        <div class="panel bg-grey-100 margin-top-0 margin-bottom-10 add_payments">
                                                                <input type="hidden" name="done[]" value="false">
                                                                <input type="hidden" name="paid[]" value="false">
                                                                <input type="hidden" name="status[]" value="active">
                                                                <input type="hidden" name="invoice_id[]" value="">
                                                                <div class="panel-body">
                                                                      <div class="row">
                                                                              <div class="col-md-12 col-xs-12">
                                                                                      <h5 class='grey-800'>Title</h5>
                                                                                      <div class="form-group">
                                                                                              <input type="text" class="form-control input-sm add_titles" name="title[]">
                                                                                      </div>
                                                                              </div>
                                                                      </div>
                                                                      <div class="row">
                                                                              <div class="col-md-12 col-xs-12">
                                                                                      <h5 class='grey-800'>Description</h5>
                                                                                      <div class="form-group">
                                                                                              <textarea type="text" class="form-control input-sm quote_textarea" name="description[]"></textarea>
                                                                                      </div>
                                                                              </div>
                                                                      </div>
                                                                      <div class="row">  
                                                                              <div class="col-md-6 col-xs-12">
                                                                                      <h5 class='grey-800'>Price, $</h5>
                                                                                      <div class="form-group">
                                                                                              <input type="number" class="form-control input-sm add_percents" name="percent[]">
                                                                                      </div>
                                                                              </div>
                                                                              <div class="col-md-6 col-xs-12">
                                                                                      <h5 class='grey-800'>Due Date</h5>
                                                                                      <div class="form-group">
                                                                                              <input type="text" data-plugin="datepicker" class="form-control input-sm datepicker add_dates" name="date[]">
                                                                                      </div>
                                                                              </div> 
                                                                      </div>
                                                                      <div class="row">
                                                                          <div class="col-md-12 text-right">
                                                                                  <a class="btn btn-pure btn-danger icon wb-close remove_add_payment"></a>
                                                                          </div>    
                                                                      </div>
                                                                </div>
                                                        </div>
                                                
                                                <?php endif; ?>
                                               
                                               <div class="add_payments_section">
                                                       <?php // new payment forms will be loaded here ?>
                                               </div>
                                                
                                        </form>
                                        
                                        <div id="add_payments_response">
                                                <?php // AJAX response after payments save will be loaded here ?>
                                        </div>
                                        
                                        <div class="row">
                                             <div class="col-md-6 col-xs-6 text-center"><a class="btn btn-primary save_add_payments">Save Variations</a></div>
                                             <div class="col-md-6 col-xs-6 text-center"><a class="btn btn-default add_add_payment">Add New</a></div>   
                                        </div>
                                        
                                </div>
                                
                                <div style='cursor:pointer;' class="padding-vertical-10" data-toggle="collapse" href="#manage_schedule" aria-expanded="false" aria-controls="manage_schedule"><h4 color='blue-grey-800'><i class="icon wb-plus"></i> Manage Schedule</h4></div>
                                
                                <div class="collapse schedules_block" id="manage_schedule">
                                        
                                        <form id="schedule_manage">
                                        <input type="hidden" name="quote_id" value="<?php echo $quote_id; ?>">
                                        
                                                <?php if($schedule) : $i=0; foreach($schedule as $s) : $i++; 
                                                        $title = $s['title'];
                                                        $description = $s['description'];
                                                        $date_from = $s['date_from'];
                                                        $date_to = $s['date_to'];
                                                        $done = $s['done'];
                                                        if($done == true) { $done_value = 'true'; } else { $done_value = 'false'; }
                                                ?>
                                                        <input type="hidden" value="<?php echo $done_value; ?>" name="done[]">
                                                        <div class="panel bg-grey-100 margin-top-0 margin-bottom-10 schedules">
                                                                <div class="panel-body">
                                                                      <div class="row">
                                                                              <div class="col-md-12 col-xs-12">
                                                                                      <h5 class='grey-800'>Title</h5>
                                                                                      <div class="form-group">
                                                                                              <input type="text" class="form-control input-sm stitles" value="<?php echo $title; ?>" name="title[]">
                                                                                      </div>
                                                                              </div>
                                                                      </div>
                                                                      <div class="row">
                                                                              <div class="col-md-12 col-xs-12">
                                                                                      <h5 class='grey-800'>Description</h5>
                                                                                      <div class="form-group">
                                                                                              <textarea type="text" class="form-control input-sm quote_textarea" name="description[]"><?php echo $description; ?></textarea>
                                                                                      </div>
                                                                              </div>
                                                                      </div>
                                                                      <div class="row">  
                                                                              <div class="col-md-6 col-xs-12">
                                                                                      <h5 class='grey-800'>Date From</h5>
                                                                                      <div class="form-group">
                                                                                              <input type="text" data-plugin="datepicker" class="form-control input-sm datepicker sdates" value="<?php echo $date_from; ?>" name="date_from[]">
                                                                                      </div>
                                                                              </div>
                                                                              <div class="col-md-6 col-xs-12">
                                                                                      <h5 class='grey-800'>Due Date</h5>
                                                                                      <div class="form-group">
                                                                                              <input type="text" data-plugin="datepicker" class="form-control input-sm datepicker sdates" value="<?php echo $date_to; ?>" name="date_to[]">
                                                                                      </div>
                                                                              </div> 
                                                                      </div>
                                                                      <div class="row">
                                                                              <div class="col-md-6">
                                                                                          <?php if($done == true) : ?>
                                                                                                          <div><i class="fa fa-check-circle light-green-800"></i> Market as Done</div>
                                                                                    <?php endif; ?>
                                                                              </div>
                                                                          <div class="col-md-6 text-right">
                                                                                  <a class="btn btn-pure btn-danger icon wb-close remove_schedule"></a>
                                                                          </div>    
                                                                      </div>
                                                                </div>
                                                        </div>
                                                
                                                <?php endforeach; 
                                                else : ?>
                                                
                                                        <div class="panel bg-grey-100 margin-top-0 margin-bottom-10 schedules">
                                                                <input type="hidden" value="false" name="done[]">
                                                                <div class="panel-body">
                                                                      <div class="row">
                                                                              <div class="col-md-12 col-xs-12">
                                                                                      <h5 class='grey-800'>Title</h5>
                                                                                      <div class="form-group">
                                                                                              <input type="text" class="form-control input-sm stitles" name="title[]">
                                                                                      </div>
                                                                              </div>
                                                                      </div>
                                                                      <div class="row">
                                                                              <div class="col-md-12 col-xs-12">
                                                                                      <h5 class='grey-800'>Description</h5>
                                                                                      <div class="form-group">
                                                                                              <textarea type="text" class="form-control input-sm quote_textarea" name="description[]"></textarea>
                                                                                      </div>
                                                                              </div>
                                                                      </div>
                                                                      <div class="row">  
                                                                              <div class="col-md-6 col-xs-12">
                                                                                      <h5 class='grey-800'>Date From</h5>
                                                                                      <div class="form-group">
                                                                                              <input type="text" data-plugin="datepicker" class="form-control input-sm datepicker sdates" value="" name="date_from[]">
                                                                                      </div>
                                                                              </div>
                                                                              <div class="col-md-6 col-xs-12">
                                                                                      <h5 class='grey-800'>Date To</h5>
                                                                                      <div class="form-group">
                                                                                              <input type="text" data-plugin="datepicker" class="form-control input-sm datepicker sdates" value="" name="date_to[]">
                                                                                      </div>
                                                                              </div> 
                                                                      </div>
                                                                      <div class="row">
                                                                          
                                                                          <div class="col-md-12 text-right">
                                                                                  <a class="btn btn-pure btn-danger icon wb-close remove_schedule"></a>
                                                                          </div>    
                                                                      </div>
                                                                </div>
                                                        </div>
                                                
                                                <?php endif; ?>
                                               
                                               <div class="schedules_section">
                                                       <?php // new schedule forms will be loaded here ?>
                                               </div>
                                                
                                        </form>
                                        
                                        <div id="schedules_response">
                                                <?php // AJAX response after schedules save will be loaded here ?>
                                        </div>
                                        
                                        <div class="row">
                                             <div class="col-md-6 col-xs-6 text-center"><a class="btn btn-primary save_schedules">Save Schedule</a></div>
                                             <div class="col-md-6 col-xs-6 text-center"><a class="btn btn-default add_schedule">Add New</a></div>   
                                        </div>
                                        
                                </div>
                                
                                <?php if($status->status == 'quote') : ?>
                                <div style='cursor:pointer;' class="padding-vertical-10" data-toggle="collapse" href="#manage_active" aria-expanded="false" aria-controls="manage_active"><h4 color='blue-grey-800'><i class="icon wb-plus"></i> Make Active</h4></div>
                                
                                <div class="collapse payments_block" id="manage_active">
                                        <form id="make_active">
                                                <input type="hidden" name="quote_id" value="<?php echo $quote_id; ?>">
                                                <input type="hidden" name="single" value="<?php echo $single; ?>">
                                                
                                                <p>Do you want to mark project as Active?</p>   
                                        </form>
                                        <div id="make_active_response"></div>
                                        <div class="row">
                                             <div class="col-md-12 col-xs-12 text-center"><a class="btn btn-primary make_active">Mark Active!</a></div>  
                                        </div>
                                </div>
                                <?php endif; ?>
                                
                                <?php if($status->status == 'active') : ?>
                                <div style='cursor:pointer;' class="padding-vertical-10" data-toggle="collapse" href="#manage_pending" aria-expanded="false" aria-controls="manage_active"><h4 color='blue-grey-800'><i class="icon wb-plus"></i> Send Proposal (In Proposal status)</h4></div>
                                
                                <div class="collapse payments_block" id="manage_pending">
                                        <form id="make_pending">
                                                <input type="hidden" name="quote_id" value="<?php echo $quote_id; ?>">
                                                <input type="hidden" name="single" value="<?php echo $single; ?>">
                                                
                                                <p>Do you want to mark project as In Proposal?</p>   
                                        </form>
                                        <div id="make_pending_response"></div>
                                        <div class="row">
                                             <div class="col-md-12 col-xs-12 text-center"><a class="btn btn-primary make_pending">Send proposal</a></div>  
                                        </div>
                                </div>
                                <?php endif; ?>
                                
                                <div style='cursor:pointer; position:relative;' class="padding-vertical-10" data-toggle="collapse" href="#manage_agent" aria-expanded="false" aria-controls="manage_agent"><h4 color='blue-grey-800'><i class="icon wb-plus"></i> Assign Project Leader</h4></div>
                                
                                <div class="collapse" id="manage_agent">
                                        
                                        <?php $agent = get_field('agent_id',$quote_id); ?>
                                        <div class="row">
                                                <div class="col-md-12 col-xs-12">
                                                        <h5 class='grey-800'>Current Agent is:</h5>
                                                        <div class="form-group form-group widget widget-body bg-blue-grey-100 padding-10">
                                                                <?php if($agent) : ?>
                                                                      <?php $agent_info = go_userdata($agent['ID']); ?>
                                                                      <p>First name: <?php echo $agent_info->first_name; ?></p>
                                                                      <p>Last name: <?php echo $agent_info->last_name; ?></p>
                                                                      <p>Email: <?php echo $agent_info->email; ?></p>
                                                                      <p>Phone: <?php echo $agent_info->phone; ?></p>
                                                                <?php else : ?>
                                                                      <p>Project Leader is unset.</p>  
                                                                <?php endif; ?>
                                                        </div>
                                                </div>
                                        </div>
                                        
                                        <div id="agent_response">
                                                <?php // AJAX response after agent search will be loaded here ?>
                                        </div>
                                        
                                        <?php $all_agents = get_users( array( 'meta_key' => 'user_type', 'meta_value' => 'Agent', 'number' => 9999 ) ); ?>
                                                <div class="row">
                                                        <div class="col-md-12 col-xs-12">
                                                                <div class="table-responsive">
                                                                <table class="table">
                                                                        <?php foreach($all_agents as $c) : $agent_id = $c->ID; $agent_data = go_userdata($agent_id); ?>
                                                                        <tr>
                                                                                <td><?php echo $agent_data->first_name; ?> <?php echo $agent_data->last_name; ?></td>
                                                                                <td><?php echo $agent_data->email; ?></td>
                                                                                <td><?php echo $agent_data->phone; ?></td>
                                                                                <td><a class="set_agent agent_<?php echo $agent_id; ?>" data-id="<?php echo $agent_id; ?>" data-quote="<?php echo $quote_id; ?>" style="cursor:pointer;"><i class="icon wb-user-add green-600"></i></a></td>
                                                                        </tr>
                                                                        <?php endforeach; ?>
                                                                </table>
                                                                </div>
                                                        </div>
                                                </div>
                                        
                                </div>
                                
                                
                                <div style='cursor:pointer; position:relative;' class="padding-vertical-10" data-toggle="collapse" href="#manage_contractor" aria-expanded="false" aria-controls="manage_contractor"><h4 color='blue-grey-800'><i class="icon wb-plus"></i> Assign Project Manager</h4></div>
                                
                                <div class="collapse" id="manage_contractor">
                                        
                                        <?php $contractor = get_field('contractor_id',$quote_id); ?>
                                        <div class="row">
                                                <div class="col-md-12 col-xs-12">
                                                        <h5 class='grey-800'>Current Contractor is:</h5>
                                                        <div class="form-group form-group widget widget-body bg-blue-grey-100 padding-10">
                                                                <?php if($contractor) : ?>
                                                                      <?php $contractor_info = go_userdata($contractor['ID']); ?>
                                                                      <p>First name: <?php echo $contractor_info->first_name; ?></p>
                                                                      <p>Last name: <?php echo $contractor_info->last_name; ?></p>
                                                                      <p>Email: <?php echo $contractor_info->email; ?></p>
                                                                      <p>Phone: <?php echo $contractor_info->phone; ?></p>
                                                                <?php else : ?>
                                                                      <p>Project Manager is unset.</p>  
                                                                <?php endif; ?>
                                                        </div>
                                                </div>
                                        </div>
                                        
                                        <div id="contractor_response">
                                                <?php // AJAX response after contractor search will be loaded here ?>
                                        </div>
                                        
                                        <?php $all_contractors = get_users( array( 'meta_key' => 'user_type', 'meta_value' => 'Contractor', 'number' => 9999 ) ); ?>
                                                <div class="row">
                                                        <div class="col-md-12 col-xs-12">
                                                                <div class="table-responsive">
                                                                <table class="table">
                                                                        <?php foreach($all_contractors as $c) : $contractor_id = $c->ID; $contractor_data = go_userdata($contractor_id); ?>
                                                                        <tr>
                                                                                <td><?php echo $contractor_data->first_name; ?> <?php echo $contractor_data->last_name; ?></td>
                                                                                <td><?php echo $contractor_data->email; ?></td>
                                                                                <td><?php echo $contractor_data->phone; ?></td>
                                                                                <td><?php echo $contractor_data->location; ?></td>
                                                                                <td><a class="set_contractor contractor_<?php echo $contractor_id; ?>" data-id="<?php echo $contractor_id; ?>" data-quote="<?php echo $quote_id; ?>" style="cursor:pointer;"><i class="icon wb-user-add green-600"></i></a></td>
                                                                        </tr>
                                                                        <?php endforeach; ?>
                                                                </table>
                                                                </div>
                                                        </div>
                                                </div>
                                        
                                </div>
                                
                                
                                <?php if($status->status == 'live') : ?>
                                <div style='cursor:pointer;' class="padding-vertical-10" data-toggle="collapse" href="#manage_completed" aria-expanded="false" aria-controls="manage_completed"><h4 color='blue-grey-800'><i class="icon wb-plus"></i> Mark as Completed</h4></div>
                                
                                <div class="collapse payments_block" id="manage_completed">
                                        <form id="make_completed">
                                                <input type="hidden" name="quote_id" value="<?php echo $quote_id; ?>">
                                                <input type="hidden" name="single" value="<?php echo $single; ?>">
                                                
                                                <p>Do you want to mark project as Completed?</p>   
                                        </form>
                                        <div id="make_completed_response"></div>
                                        <div class="row">
                                             <div class="col-md-12 col-xs-12 text-center"><a class="btn btn-primary make_completed">Mark as Completed!</a></div>  
                                        </div>
                                </div>
                                <?php endif; ?>
                                
                                
                        </div>
                </div>
                
                
	
        </section>
        <div class="slidePanel-footer text-center margin-bottom-0">
                <a class="btn btn-primary" href="<?php echo get_the_permalink($quote_id); ?>"><i class="icon wb-more-horizontal"></i> Goto Project</a>
        </div>
</div>
<script>

$('.selections_block').on('click','.select_selection_remove', function(){
        var selection = $(this).data('selection');
	var assign_selection_to_project = '/wp-content/themes/go/projects-templates/ajax/assign_selection_to_project.php';
 	jQuery.ajax({
  	url: assign_selection_to_project,
 	type: 'POST',
        dataType: "json",
        cache: false,
	data: { 
		'action' : 'remove',
                'selection' : selection,
                'quote_id' : <?php echo $quote_id; ?>
	},
 	success: function(response) {
                if(response.status == true) {
                        $('#selection_' + response.selection + ' a').removeClass('select_selection_remove').addClass('select_selection_add').html('<i class="fa fa-plus"></i>');
                }
	},
	error: function(response) {
	}
  	});  
});
$('.selections_block').on('click','.select_selection_add', function(){
        var selection = $(this).data('selection');
	var assign_selection_to_project = '/wp-content/themes/go/projects-templates/ajax/assign_selection_to_project.php';
 	jQuery.ajax({
  	url: assign_selection_to_project,
 	type: 'POST',
        dataType: "json",
        cache: false,
	data: { 
		'action' : 'add',
                'selection' : selection,
                'quote_id' : <?php echo $quote_id; ?>
	},
 	success: function(response) {
                if(response.status == true) {
                        $('#selection_' + response.selection + ' a').removeClass('select_selection_add').addClass('select_selection_remove').html('<i class="fa fa-minus"></i>');
                }
	},
	error: function(response) {
	}
  	});  
});

$('.selections_block').on('click', '.add_selection', function() {
	var selection_add = '/wp-content/themes/go/projects-templates/ajax/selection_template.php';
 	jQuery.ajax({
  	url: selection_add,
 	type: 'POST',
  	dataType: 'html',
	data: { 
		'load_selection' : true
	},
 	success: function(response) {
                $('.selection_add_error').remove();
                $('.selections_section').append(response);
	 	},
	error: function(response) {
                $('.selection_add_error').remove();
		$('.selections_section').append('<div class=\'text-center selection_add_error margin-vertical-20 red-800\'>Something went wrong! Try agan later.</div>');
	}
  	});
});

$('.selections_block').on('click', '.remove_selection', function() {
        $(this).closest('.selections').remove();
});

$('.slide_save_selections').click(function() {
        var valid = true;
        $('.selections_block input[type=text]').each(function() {
                if(!$(this).val()){
                   alert('Some fields are empty');
                   valid = false;
                   return false;
                }
        });
        
        if(valid != false) {
                $('#manage_response').html('<div class=\'text-center margin-vertical-20\'><i class=\'fa fa-refresh fa-spin\'></i></div>');
        	var manage = '/wp-content/themes/go/projects-templates/ajax/save_selections.php';
         	jQuery.ajax({
          	url: manage,
         	type: 'POST',
          	dataType: 'html',
        	data: jQuery('#slide_selections').serialize(),
         	success: function(response) {
        	 	        $('#manage_response').html(response);
        	 	},
        	error: function(response) {
        		        $('#manage_response').html('<div class=\'text-center margin-vertical-20 red-800\'>Something went wrong!</div>');
        	}
          	});
        } 
             
});

$('.save_contract').click(function() {
        var valid = true;
        $('.contract_area').each(function() {
                if(!$(this).val()){
                   alert('Contract field can\'t be empty');
                   valid = false;
                   return false;
                }
        });
        
        if(valid != false) {
                $('#contract_response').html('<div class=\'text-center margin-vertical-20\'><i class=\'fa fa-refresh fa-spin\'></i></div>');
        	var contract = '/wp-content/themes/go/projects-templates/ajax/save_contract.php';
         	jQuery.ajax({
          	url: contract,
         	type: 'POST',
          	dataType: 'html',
        	data: jQuery('#contract').serialize(),
         	success: function(response) {
        	 	        $('#contract_response').html(response);
        	 	},
        	error: function(response) {
        		        $('#contract_response').html('<div class=\'text-center margin-vertical-20 red-800\'>Something went wrong!</div>');
        	}
          	});
        } 
             
});

$('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        startDate: '-0d',
        autoclose: true
});

$('.payments_block').on('click', '.add_payment', function() {
	var payment_add = '/wp-content/themes/go/projects-templates/ajax/payment_template.php';
 	jQuery.ajax({
  	url: payment_add,
 	type: 'POST',
  	dataType: 'html',
	data: { 
		'load_payment' : true
	},
 	success: function(response) {
                $('.payment_add_error').remove();
                $('.payments_section').append(response);
	 	},
	error: function(response) {
                $('.payment_add_error').remove();
		$('.payments_section').append('<div class=\'text-center payment_add_error margin-vertical-20 red-800\'>Something went wrong! Try agan later.</div>');
	}
  	});
});

$('.payments_block').on('click', '.remove_payment', function() {
        $(this).closest('.payments').remove();
});

// loading payment template from Payment Templates
$('.payments_block').on('click', '.load_from_template', function() {
        var load_template_id = $('.payment_template').val();
        if(load_template_id == '0') {
                alert('You need to select Payment Template to load!');
                return false;
        }
        $('div').siblings('.payments').remove();
        $('.payments_section').html('');
	var payment_load_template = '/wp-content/themes/go/projects-templates/ajax/payment_template_load.php';
 	jQuery.ajax({
  	url: payment_load_template,
 	type: 'POST',
  	dataType: 'html',
	data: { 
		'load_payment' : true,
                'load_template_id' : load_template_id
	},
 	success: function(response) {
                $('.payment_add_error').remove();
                $('.payments_section').append(response);
	 	},
	error: function(response) {
                $('.payment_add_error').remove();
		$('.payments_section').append('<div class=\'text-center payment_add_error margin-vertical-20 red-800\'>Something went wrong! Try agan later.</div>');
	}
  	});
});

$('.save_payments').click(function() {
        var titles_valid = true;
        $('.titles').each(function() {
                if(!$(this).val()){
                   alert('Payments Title field can\'t be empty!');
                   titles_valid = false;
                   return false;
                }
        });
        if(titles_valid == false) {
                return false;
        }
        var percents_valid = true;
        $('.percents').each(function() {
                if(!$(this).val()){
                   alert('Payments Percent field can\'t be empty!');
                   percents_valid = false;
                   return false;
                }
        });
        if(percents_valid == false) {
                return false;
        }
        var dates_valid = true;
        $('.dates').each(function() {
                if(!$(this).val()){
                   alert('Payments Date field can\'t be empty!');
                   dates_valid = false;
                   return false;
                }
        });
        if(dates_valid == false) {
                return false;
        }
        
        if(titles_valid != false && percents_valid != false && dates_valid != false) {
                $('#payments_response').html('<div class=\'text-center margin-vertical-20\'><i class=\'fa fa-refresh fa-spin\'></i></div>');
        	var payments = '/wp-content/themes/go/projects-templates/ajax/save_payments.php';
         	jQuery.ajax({
          	url: payments,
         	type: 'POST',
          	dataType: 'html',
        	data: jQuery('#payments_manage').serialize(),
         	success: function(response) {
        	 	        $('#payments_response').html(response);
        	 	},
        	error: function(response) {
        		        $('#payments_response').html('<div class=\'text-center margin-vertical-20 red-800\'>Something went wrong!</div>');
        	}
          	});
        } 
             
});

// additional payments
$('.add_payments_block').on('click', '.add_add_payment', function() {
	var add_payment_add = '/wp-content/themes/go/projects-templates/ajax/add_payment_template.php';
 	jQuery.ajax({
  	url: add_payment_add,
 	type: 'POST',
  	dataType: 'html',
	data: { 
		'load_payment' : true
	},
 	success: function(response) {
                $('.add_payment_add_error').remove();
                $('.add_payments_section').append(response);
	 	},
	error: function(response) {
                $('.add_payment_add_error').remove();
		$('.add_payments_section').append('<div class=\'text-center add_payment_add_error margin-vertical-20 red-800\'>Something went wrong! Try agan later.</div>');
	}
  	});
});

$('.add_payments_block').on('click', '.remove_add_payment', function() {
        $(this).closest('.add_payments').remove();
});


$('.save_add_payments').click(function() {
        var titles_valid = true;
        $('.add_titles').each(function() {
                if(!$(this).val()){
                   alert('Payments Title field can\'t be empty!');
                   titles_valid = false;
                   return false;
                }
        });
        if(titles_valid == false) {
                return false;
        }
        var percents_valid = true;
        $('.add_percents').each(function() {
                if(!$(this).val()){
                   alert('Payments Price field can\'t be empty!');
                   percents_valid = false;
                   return false;
                }
        });
        if(percents_valid == false) {
                return false;
        }
        var dates_valid = true;
        $('.add_dates').each(function() {
                if(!$(this).val()){
                   alert('Payments Date field can\'t be empty!');
                   dates_valid = false;
                   return false;
                }
        });
        if(dates_valid == false) {
                return false;
        }
        
        if(titles_valid != false && percents_valid != false && dates_valid != false) {
                $('#add_payments_response').html('<div class=\'text-center margin-vertical-20\'><i class=\'fa fa-refresh fa-spin\'></i></div>');
        	var add_payments = '/wp-content/themes/go/projects-templates/ajax/save_add_payments.php';
         	jQuery.ajax({
          	url: add_payments,
         	type: 'POST',
          	dataType: 'html',
        	data: jQuery('#add_payments').serialize(),
         	success: function(response) {
        	 	        $('#add_payments_response').html(response);
        	 	},
        	error: function(response) {
        		        $('#add_payments_response').html('<div class=\'text-center margin-vertical-20 red-800\'>Something went wrong!</div>');
        	}
          	});
        } 
             
});

$('.make_active').click(function() {
        $('#make_active_response').html('<div class=\'text-center margin-vertical-20\'><i class=\'fa fa-refresh fa-spin\'></i></div>');
        var ma = '/wp-content/themes/go/projects-templates/ajax/make_active.php';
        jQuery.ajax({
        url: ma,
        type: 'POST',
        dataType: 'html',
        data: jQuery('#make_active').serialize(),
        success: function(response) {
                $('#make_active_response').html(response);
        },
        error: function(response) {
                $('#make_active_response').html('<div class=\'text-center margin-vertical-20 red-800\'>Something went wrong!</div>');
        }
        });   
});

$('.make_pending').click(function() {
        $('#make_pending_response').html('<div class=\'text-center margin-vertical-20\'><i class=\'fa fa-refresh fa-spin\'></i></div>');
        var ma = '/wp-content/themes/go/projects-templates/ajax/make_pending.php';
        jQuery.ajax({
        url: ma,
        type: 'POST',
        dataType: 'html',
        data: jQuery('#make_pending').serialize(),
        success: function(response) {
                $('#make_pending_response').html(response);
        },
        error: function(response) {
                $('#make_pending_response').html('<div class=\'text-center margin-vertical-20 red-800\'>Something went wrong!</div>');
        }
        });   
});

$('.make_completed').click(function() {
        $('#make_completed_response').html('<div class=\'text-center margin-vertical-20\'><i class=\'fa fa-refresh fa-spin\'></i></div>');
        var mc = '/wp-content/themes/go/projects-templates/ajax/make_completed.php';
        jQuery.ajax({
        url: mc,
        type: 'POST',
        dataType: 'html',
        data: jQuery('#make_completed').serialize(),
        success: function(response) {
                $('#make_completed_response').html(response);
        },
        error: function(response) {
                $('#make_completed_response').html('<div class=\'text-center margin-vertical-20 red-800\'>Something went wrong!</div>');
        }
        });   
});

$('.save_price').click(function() {
        $('#price_response').html('<div class=\'text-center margin-vertical-20\'><i class=\'fa fa-refresh fa-spin\'></i></div>');
        var price = '/wp-content/themes/go/projects-templates/ajax/manage_price.php';
        jQuery.ajax({
        url: price,
        type: 'POST',
        dataType: 'html',
        data: jQuery('#price').serialize(),
        success: function(response) {
                $('#price_response').html(response);
        },
        error: function(response) {
                $('#price_response').html('<div class=\'text-center margin-vertical-20 red-800\'>Something went wrong!</div>');
        }
        });   
});

$('.save_title').click(function() {
        $('#title_response').html('<div class=\'text-center margin-vertical-20\'><i class=\'fa fa-refresh fa-spin\'></i></div>');
        var title = '/wp-content/themes/go/projects-templates/ajax/manage_title.php';
        jQuery.ajax({
        url: title,
        type: 'POST',
        dataType: 'html',
        data: jQuery('#title').serialize(),
        success: function(response) {
                $('#title_response').html(response);
        },
        error: function(response) {
                $('#title_response').html('<div class=\'text-center margin-vertical-20 red-800\'>Something went wrong!</div>');
        }
        });   
});

$('.save_due').click(function() {
        $('#due_response').html('<div class=\'text-center margin-vertical-20\'><i class=\'fa fa-refresh fa-spin\'></i></div>');
        var due = '/wp-content/themes/go/projects-templates/ajax/manage_due_date.php';
        jQuery.ajax({
        url: due,
        type: 'POST',
        dataType: 'html',
        data: jQuery('#due').serialize(),
        success: function(response) {
                $('#due_response').html(response);
        },
        error: function(response) {
                $('#due_response').html('<div class=\'text-center margin-vertical-20 red-800\'>Something went wrong!</div>');
        }
        });   
});


// Schedules
$('.schedules_block').on('click', '.add_schedule', function() {
	var schedule_add = '/wp-content/themes/go/projects-templates/ajax/schedule_template.php';
 	jQuery.ajax({
  	url: schedule_add,
 	type: 'POST',
  	dataType: 'html',
	data: { 
		'load_schedule' : true
	},
 	success: function(response) {
                $('.schedule_add_error').remove();
                $('.schedules_section').append(response);
	 	},
	error: function(response) {
                $('.schedule_add_error').remove();
		$('.schedules_section').append('<div class=\'text-center schedule_add_error margin-vertical-20 red-800\'>Something went wrong! Try agan later.</div>');
	}
  	});
});

$('.schedules_block').on('click', '.remove_schedule', function() {
        $(this).closest('.schedules').remove();
});

$('.save_schedules').click(function() {
        var titles_valid = true;
        $('.stitles').each(function() {
                if(!$(this).val()){
                   alert('Schedule Title fields can\'t be empty!');
                   titles_valid = false;
                   return false;
                }
        });
        if(titles_valid == false) {
                return false;
        }
        var dates_valid = true;
        $('.sdates').each(function() {
                if(!$(this).val()){
                   alert('Schedule Date fields can\'t be empty!');
                   dates_valid = false;
                   return false;
                }
        });
        if(dates_valid == false) {
                return false;
        }
        
        if(titles_valid != false && dates_valid != false) {
                $('#schedules_response').html('<div class=\'text-center margin-vertical-20\'><i class=\'fa fa-refresh fa-spin\'></i></div>');
        	var schedules = '/wp-content/themes/go/projects-templates/ajax/save_schedules.php';
         	jQuery.ajax({
          	url: schedules,
         	type: 'POST',
          	dataType: 'html',
        	data: jQuery('#schedule_manage').serialize(),
         	success: function(response) {
        	 	        $('#schedules_response').html(response);
        	 	},
        	error: function(response) {
        		        $('#schedules_response').html('<div class=\'text-center margin-vertical-20 red-800\'>Something went wrong!</div>');
        	}
          	});
        } 
             
});

$('.set_contractor').click(function() {
        $(this).html('<i class=\'fa fa-refresh fa-spin\'></i>');
	var add_contractor = '/wp-content/themes/go/projects-templates/ajax/add_contractor.php';
        var contractor_id = $(this).attr('data-id');
        var quote_id = $(this).attr('data-quote');
 	jQuery.ajax({
  	url: add_contractor,
 	type: 'POST',
  	dataType: 'html',
                data: {
                        'contractor_id' : contractor_id,
                        'quote_id' : quote_id
                },
 	success: function(response) {
	 	        $('#contractor_response').html(response);
	 	},
	error: function(response) {
                        $('.set_contractor').html('<i class=\'icon wb-user-add green-600\'></i>');
		        $('#contractor_response').html('<div class=\'text-center margin-vertical-20 red-800\'>Something went wrong!</div>');
	}
  	});
});

$('.set_agent').click(function() {
        $(this).html('<i class=\'fa fa-refresh fa-spin\'></i>');
	var add_agent = '/wp-content/themes/go/projects-templates/ajax/add_agent.php';
        var agent_id = $(this).attr('data-id');
        var quote_id = $(this).attr('data-quote');
 	jQuery.ajax({
  	url: add_agent,
 	type: 'POST',
  	dataType: 'html',
                data: {
                        'agent_id' : agent_id,
                        'quote_id' : quote_id
                },
 	success: function(response) {
	 	        $('#agent_response').html(response);
	 	},
	error: function(response) {
                        $('.set_agent').html('<i class=\'icon wb-user-add green-600\'></i>');
		        $('#agent_response').html('<div class=\'text-center margin-vertical-20 red-800\'>Something went wrong!</div>');
	}
  	});
});

</script>
<script src="<?php bloginfo('template_url'); ?>/vendor/bootstrap-table/bootstrap-table.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/vendor/bootstrap-table/extensions/mobile/bootstrap-table-mobile.min.js"></script>
<script>
$(document).ready(function() {
    $('#default_selections').DataTable( {
            "paging": true,
            "searching": true,
            "info": false,
            "lengthChange": false,
            
    } );
} );
</script>
<!-- <script src="<?php bloginfo('template_url'); ?>/assets/examples/js/tables/bootstrap.min.js"></script> -->