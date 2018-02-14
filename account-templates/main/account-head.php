<?php
$current_user_id = current_user_id();
$current_user_data = go_userdata($current_user_id);
$current_user_stats = go_projects_statistic($current_user_id);
$head_string = get_field('head_contractor','options');
$agent_string = get_field('agent','options');
if(is_agent()) {
    $agentToken = $current_user_id;
    $agentToken = base64_encode($agentToken);
    $agentTokenLink = get_bloginfo('url') . '/add_quote?token=' . $agentToken;
}
get_header(); ?>
<!-- Page -->
<div class="page animsition">
        <div class="page-content container-fluid">
                <div class="row">
                        <div class="col-md-3">
                                <!-- Page Widget -->
                                <div class="widget widget-shadow text-center">
                                        <div class="widget-header">
                                                <div class="widget-header-content">
                                                        <a class="avatar avatar-lg" href="javascript:void(0)">
                                                                <img src="<?php echo $current_user_data->avatar; ?>" alt="...">
                                                        </a>

                                                        <h4 class="profile-user"><?php echo $current_user_data->first_name; ?> <?php echo $current_user_data->last_name; ?></h4>
                                                        <div class="margin-bottom-10"><span class="label label-lg label-info"><?php if($current_user_data->type == 'Head') { echo $head_string; } elseif($current_user_data->type == 'Agent') { echo $agent_string; } ?></span></div>
                                                        <div class="profile-job">
                                                                <p><?php echo $current_user_data->email; ?></p>
                                                                <p><?php echo $current_user_data->phone; ?></p>
                                                        </div>
                                                        <?php if(is_agent()) : ?>
                                                        <style type="text/css">
                                                        input[name=agentToken] {
                                                          pointer-events:none;
                                                        }
                                                        </style>
                                                          <div class="form-group margin-horizontal-20">
                                                            <label for="agentToken">Your Direct Quote link</label>
                                                            <div class="input-group input-group-icon">
                                                              <input id="token" name="agentToken" type="text" class="form-control" id="agentToken" placeholder="Not generated" value="<?php echo $agentTokenLink; ?>" >
                                                              <span class="input-group-addon copyTokenLink" data-toggle="tooltip" data-placement="top" data-trigger="hover" data-original-title="Copy link to clipboard" title="" style="cursor:pointer;" data-clipboard-target="#token">
                                                                <span class="icon wb-copy" aria-hidden="true"></span>
                                                              </span>
                                                            </div>
                                                          </div>

                                                        <?php endif; ?>
                                                        <a href="<?php bloginfo('url'); ?>/all_projects" class="btn btn-primary">Manage Quotes</a>
                                                </div>
                                        </div>
                                        <div class="widget-footer">
                                                <div class="row no-space">
                                                        <div class="col-xs-4">
                                                                <strong class="profile-stat-count"><?php echo $current_user_stats->quote; ?></strong>
                                                                <span>Quotes</span>
                                                        </div>
                                                        <div class="col-xs-4">
                                                                <strong class="profile-stat-count"><?php echo $current_user_stats->completed; ?></strong>
                                                                <span>Won</span>
                                                        </div>
                                                   <div class="col-xs-4">
                                                                <strong class="profile-stat-count"><?php echo $current_user_stats->cancelled; ?></strong>
                                                                <span>Lost</span>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                                <!-- End Page Widget -->
                        </div>
                        <div class="col-md-9">
                                <!-- Panel -->
                                <div class="panel">
                                        <div class="panel-body nav-tabs-animate">
                                                <ul class="nav nav-tabs nav-tabs-line" data-plugin="nav-tabs" role="tablist">
                                                        <li class="active" role="presentation"><a data-toggle="tab" href="#personal" aria-controls="personal" role="tab">Personal</a></li>
                                                        <li role="presentation"><a data-toggle="tab" href="#security" aria-controls="security" role="tab">Security</a></li>
                                                        <li role="presentation"><a data-toggle="tab" href="#sub" aria-controls="sub" role="tab">Subscription</a></li>
                                                        <li role="presentation"><a data-toggle="tab" href="#embed" aria-controls="embed" role="tab">Embed</a></li>
                                                        <li role="presentation"><a data-toggle="tab" href="#edit" aria-controls="edit" role="tab">Edit Templates</a></li>

                                                </ul>
                                                <div class="tab-content">
                                                        <div class="tab-pane active animation-slide-left" id="personal" role="tabpanel">
                                                                <form id="account">
                                                                <input type="hidden" name="user_type" value="Head">
                                                                <div class="row margin-top-40">
                                                                        <div class="col-md-6">
                                                                                <div class="form-group form-control-default required">
                                                                                        <label for="exampleInputFirstName">First name</label>
                                                                                        <input name="first_name" type="text" class="form-control" id="exampleInputFirstName" placeholder="Your first name" value="<?php echo $current_user_data->first_name; ?>" required>
                                                                                </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                                <div class="form-group form-control-default required">
                                                                                        <label for="exampleInputLastName">Last name</label>
                                                                                        <input name="last_name" type="text" class="form-control" id="exampleInputLastName" placeholder="Your last name" value="<?php echo $current_user_data->last_name; ?>" required>
                                                                                </div>
                                                                        </div>
                                                                </div>
                                                                  <div class="form-group form-control-default">
                                                                                        <label for="businessName">Business Name</label>
                                                                                        <input name="business_name" type="text" class="form-control" id="businessName" placeholder="Business Name" value="<?php the_field('business_name','user_' . $current_user_id); ?>">
                                                                 </div>   
                                                                <div class="row">
                                                                        <div class="col-md-6">
                                                                                <div class="form-group form-control-default required">
                                                                                        <label for="exampleInputEmail">Email address</label>
                                                                                        <input name="email" type="email" class="form-control" id="exampleInputEmail" placeholder="Your E-mail" value="<?php echo $current_user_data->email; ?>">
                                                                                </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                                <div class="form-group form-control-default required">
                                                                                        <label for="exampleInputPhone">Phone</label>
                                                                                        <input name="phone" type="text" class="form-control" id="exampleInputPhone" placeholder="Your phone" value="<?php echo $current_user_data->phone; ?>" required>
                                                                                </div>
                                                                        </div>
                                                                </div>
                                                                <div class="form-group form-control-default required">
                                                                        <label for="exampleInputAddress">Address</label>
                                                                        <textarea name="address" class="form-control" id="exampleInputAddress" placeholder="Enter address" required><?php echo $current_user_data->address; ?></textarea>
                                                                </div>
                                                                <div class="form-group form-control-default">
                                                                        <label for="exampleInputAva">Change Photo</label>
                                                                        <input type="file" class="form-control input-sm file_upload" name="photo" id="photo">
                                                                        <div class='photo'><input type='hidden' name='photo' value=''></div>
                                                                </div>
                                                                <div id="account_response"></div>
                                                                <div class="text-center"><a id="save_account" class="btn btn-primary">Save</a></div>
                                                                </form>
                                                        </div>
                                                        <div class="tab-pane animation-slide-left" id="security" role="tabpanel">
                                                                <form id="security_form">
                                                                <input type="hidden" name="user_type" value="Head">
                                                                <div class="row margin-top-40">
                                                                        <div class="col-md-6">
                                                                                <div class="form-group form-control-default required">
                                                                                        <label for="exampleInputFirstName">Password</label>
                                                                                        <input name="password" type="password" class="form-control" id="exampleInputFirstName" placeholder="New password" value="" required>
                                                                                </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                                <div class="form-group form-control-default required">
                                                                                        <label for="exampleInputLastName">Password Confirm</label>
                                                                                        <input name="passwordc" type="password" class="form-control" id="exampleInputLastName" placeholder="Password Confirm" value="" required>
                                                                                </div>
                                                                        </div>
                                                                </div>

                                                                <div id="security_response"></div>
                                                                <div class="text-center"><a id="save_security" class="btn btn-primary">Save</a></div>
                                                                </form>
                                                        </div>
                                                   <div class="tab-pane animation-slide-left" id="sub" role="tabpanel">
                                                                
                                                        </div>
                                                     <div class="tab-pane animation-slide-left" id="embed" role="tabpanel">
                                                         <div class="row padding-20 text-center">
	


 
  
                      <?php
    $by_project_cnt = 0;
    $by_project_args = array('post_type'=>'template', 'posts_per_page'=>-1, 'author'  =>  $current_user_id );
    $by_project_templates = get_posts($by_project_args);
    foreach($by_project_templates as $template) :
    ?>


       <div class="col-md-3 col-xs-6">

       <figure class="quote_option text-center" >
         <img src="<?php the_field('template_image',$template->ID); ?>">
                    <figcaption class="margin-top-10">
                      <div class="font-size-20 margin-bottom-30 blue-grey-800"><?php echo $template->post_title; ?></div>
                    </figcaption>
                  </figure>

       </div>
                                                                  
    <?php
    $by_project_cnt++;
    endforeach;
    if($by_project_cnt == 0) {
        echo "<p>Sorry, there are no templates here yet.</p>";
    }
    ?>
	
	
	
                    </div>
 
                                                        </div>
                                                  <div class="tab-pane animation-slide-left" id="edit" role="tabpanel">
                                                                <div class="row padding-20 text-center">
	


 
  
                      <?php
    $by_project_cnt = 0;
    $by_project_args = array('post_type'=>'template', 'posts_per_page'=>-1, 'author'  =>  $current_user_id );
    $by_project_templates = get_posts($by_project_args);
    foreach($by_project_templates as $template) :
    ?>


       <div class="col-md-3 col-xs-6">

       <figure class="quote_option text-center" >
         <a href="<?php bloginfo('url'); ?>/template/<?php echo $template->post_name; ?>" title="Edit Quote template"><img src="<?php the_field('template_image',$template->ID); ?>">
                    <figcaption class="margin-top-10">
                      <div class="font-size-20 margin-bottom-30 blue-grey-800"><?php echo $template->post_title; ?></div>
                    </figcaption></a>
                  </figure>

       </div>
                                                                  
    <?php
    $by_project_cnt++;
    endforeach;
    if($by_project_cnt == 0) {
        echo "<p>Sorry, there are no templates here yet.</p>";
    }
    ?>
	
	
	
                    </div>
 
                                                        </div>
                                                        <?php if(is_headcontractor()) : ?>
                                                                <div class="tab-pane animation-slide-left" id="invoice" role="tabpanel">
                                                                        <form id="invoice_form">
                                                                            <div class="row">
                                                                        <div class="col-md-6">
                                                                                        <div class="form-group form-control-default required">
                                                                                                <label for="cname">Company Name</label>
                                                                                                <input name="company_name" type="text" class="form-control" id="cname" placeholder="Company Name" value="<?php the_field('company_name','options'); ?>" required>
                                                                                        </div>
                                                                        </div>
                                                                        </div>
                                                                        <div class="row">
                                                                                <div class="col-md-6">
                                                                                        <div class="form-group form-control-default required">
                                                                                                <label for="cemail">Accounts Email</label>
                                                                                                <input name="company_email" type="email" class="form-control" id="cemail" placeholder="Company E-mail" value="<?php the_field('email','options'); ?>">
                                                                                        </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                        <div class="form-group form-control-default required">
                                                                                                <label for="cphone">Accounts Phone</label>
                                                                                                <input name="company_phone" type="text" class="form-control" id="cphone" placeholder="Company Phone" value="<?php the_field('phone','options'); ?>" required>
                                                                                        </div>
                                                                                </div>
                                                                        </div>
                                                                        <div class="form-group form-control-default required">
                                                                                <label for="caddress">Company Address</label>
                                                                                <textarea name="address" class="form-control" id="caddress" placeholder="Enter Company address" required><?php the_field('address','options'); ?></textarea>
                                                                        </div>
                                                                        <div class="row hidden">
                                                                                <div class="col-md-6">
                                                                                        <div class="form-group form-control-default required">
                                                                                                <label for="taxname">Tax Name</label>
                                                                                                <input name="tax_name" type="text" class="form-control" id="taxname" placeholder="Tax Name" value="GST">
                                                                                        </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                        <div class="form-group form-control-default required">
                                                                                                <label for="tax_value">Tax Value</label>
                                                                                                <input name="tax_value" type="text" class="form-control" id="tax_value" placeholder="Tax Value" value="1.15" required>
                                                                                        </div>
                                                                                </div>
                                                                        </div>
                                                                        <div class="form-group form-control-default required">
                                                                                <label for="ipi">Invoice Payment Instructions</label>
                                                                                <textarea name="ipi" class="form-control" id="ipi" placeholder="Payment Instructions" required><?php the_field('ipi','options'); ?></textarea>
                                                                        </div>
                                                                        <div class="row">
                                                                                <div class="col-md-6">
                                                                                        <div class="form-group form-control-default">
                                                                                                <label for="exampleInputAva">Company Logo</label>
                                                                                                <input type="file" class="form-control input-sm file_upload" name="photo" id="logo">
                                                                                                <div class='logo'><input type='hidden' name='photo' value=''></div>
                                                                                        </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                       <div class="form-group form-control-default required">
                                                                                               <label for="tax_value">Current Company Logo</label>
                                                                                               <?php $logo = get_field('logo','options'); $size = "medium"; $clogo = wp_get_attachment_image_src( $logo, $size ); ?>
                                                                                               <?php if($logo) : ?>
                                                                                                       <div><img src="<?php echo $clogo[0]; ?>" alt=""></div>
                                                                                               <?php else : ?>
                                                                                                       <p>No logo yet.</p>
                                                                                               <?php endif; ?>
                                                                                       </div>
                                                                                </div>
                                                                        </div>
                                                                        <div id="invoice_response"></div>
                                                                        <div class="text-center"><a id="save_invoice" class="btn btn-primary">Save</a></div>
                                                                        </form>
                                                                </div>
                                                            <?php elseif(is_agent()) : ?>
                                                                <div class="tab-pane animation-slide-left" id="invoice" role="tabpanel">
                                                                         <form id="invoice_form">
                                                                            <div class="row">
                                                                        <div class="col-md-6">
                                                                                        <div class="form-group form-control-default required">
                                                                                                <label for="cname">Company Name</label>
                                                                                                <input name="company_name" type="text" class="form-control" id="cname" placeholder="Company Name" value="<?php the_field('company_name','options'); ?>" required>
                                                                                        </div>
                                                                        </div>
                                                                        </div>
                                                                        <div class="row">
                                                                                <div class="col-md-6">
                                                                                        <div class="form-group form-control-default required">
                                                                                                <label for="cemail">Accounts Email</label>
                                                                                                <input name="company_email" type="email" class="form-control" id="cemail" placeholder="Company E-mail" value="<?php the_field('email','options'); ?>">
                                                                                        </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                        <div class="form-group form-control-default required">
                                                                                                <label for="cphone">Accounts Phone</label>
                                                                                                <input name="company_phone" type="text" class="form-control" id="cphone" placeholder="Company Phone" value="<?php the_field('phone','options'); ?>" required>
                                                                                        </div>
                                                                                </div>
                                                                        </div>
                                                                        <div class="form-group form-control-default required">
                                                                                <label for="caddress">Company Address</label>
                                                                                <textarea name="address" class="form-control" id="caddress" placeholder="Enter Company address" required><?php the_field('address','options'); ?></textarea>
                                                                        </div>
                                                                        <div class="row hidden">
                                                                                <div class="col-md-6">
                                                                                        <div class="form-group form-control-default required">
                                                                                                <label for="taxname">Tax Name</label>
                                                                                                <input name="tax_name" type="text" class="form-control" id="taxname" placeholder="Tax Name" value="GST">
                                                                                        </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                        <div class="form-group form-control-default required">
                                                                                                <label for="tax_value">Tax Value</label>
                                                                                                <input name="tax_value" type="text" class="form-control" id="tax_value" placeholder="Tax Value" value="1.15" required>
                                                                                        </div>
                                                                                </div>
                                                                        </div>
                                                                        <div class="form-group form-control-default required">
                                                                                <label for="ipi">Invoice Payment Instructions</label>
                                                                                <textarea name="ipi" class="form-control" id="ipi" placeholder="Payment Instructions" required><?php the_field('ipi','options'); ?></textarea>
                                                                        </div>
                                                                        <div class="row">
                                                                                <div class="col-md-6">
                                                                                        <div class="form-group form-control-default">
                                                                                                <label for="exampleInputAva">Company Logo</label>
                                                                                                <input type="file" class="form-control input-sm file_upload" name="photo" id="logo">
                                                                                                <div class='logo'><input type='hidden' name='photo' value=''></div>
                                                                                        </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                       <div class="form-group form-control-default required">
                                                                                               <label for="tax_value">Current Company Logo</label>
                                                                                               <?php $logo = get_field('logo','options'); $size = "medium"; $clogo = wp_get_attachment_image_src( $logo, $size ); ?>
                                                                                               <?php if($logo) : ?>
                                                                                                       <div><img src="<?php echo $clogo[0]; ?>" alt=""></div>
                                                                                               <?php else : ?>
                                                                                                       <p>No logo yet.</p>
                                                                                               <?php endif; ?>
                                                                                       </div>
                                                                                </div>
                                                                        </div>
                                                                        <div id="invoice_response"></div>
                                                                        <div class="text-center"><a id="save_invoice" class="btn btn-primary">Save</a></div>
                                                                        </form>
                                                                </div>
                                                            <?php endif; ?>


                                                        <?php // ADD SELECTION TAB ?>
                                                        <div class="tab-pane animation-slide-left" id="selection" role="tabpanel">
                                                                <form id="addSelections">

                                                                <div class="row margin-top-40">
                                                                        <div class="col-md-6">
                                                                                <div class="form-group form-control-default required">
                                                                                        <label for="selectionTitle">Title</label>
                                                                                        <input name="selectionTitle" type="text" class="form-control" id="selectionTitle" placeholder="Title" value="" required>
                                                                                </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                                <div class="form-group form-control-default required">
                                                                                    <label for="selectionPrice">Retail Price, $</label>
                                                                                    <input name="selectionPrice" type="number" min="0" class="form-control" id="selectionPrice" placeholder="" value="0.00" required>
                                                                                </div>
                                                                        </div>
                                                                </div>
                                                                <div class="row ">
                                                                        <div class="col-md-3">
                                                                                <div class="form-group form-control-default required">
                                                                                        <label for="selectionSupplier">Supplier</label>
                                                                                        <?php $cats = get_terms( array(
                                                                                            'taxonomy' => 'selection_supplier',
                                                                                            'hide_empty' => false,
                                                                                            'fields' => 'all'
                                                                                        ) ); ?>
                                                                                        <select data-plugin="selectpicker" data-live-search="true" class="form-control" title="Select Supplier" id="selectionSupplier" name="selectionSupplier">
                                                                                            <?php foreach($cats as $cat) : ?>
                                                                                                <option value="<?php echo $cat->term_id; ?>"><?php echo $cat->name; ?></option>
                                                                                            <?php endforeach; ?>
                                                                                        </select>
                                                                                </div>
                                                                        </div>
                                                                       <div class="col-md-3">
                                                                                <div class="form-group form-control-default required">
                                                                                        <label for="selectionCategory">Category</label>
                                                                                        <?php $cats = get_terms( array(
                                                                                            'taxonomy' => 'selection_cat',
                                                                                            'hide_empty' => false,
                                                                                            'fields' => 'all'
                                                                                        ) ); ?>
                                                                                        <select multiple data-plugin="selectpicker" data-live-search="true" class="form-control" id="selectionCat" title="Select Categories" name="selectionCategory[]">
                                                                                            <?php foreach($cats as $cat) : ?>
                                                                                                <option value="<?php echo $cat->term_id; ?>"><?php echo $cat->name; ?></option>
                                                                                            <?php endforeach; ?>
                                                                                        </select>
                                                                                </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                                <div class="form-group form-control-default required">
                                                                                        <label for="selectionLevel">Level of Finish</label>
                                                                                        <?php $levels = get_terms( array(
                                                                                            'taxonomy' => 'selection_level',
                                                                                            'hide_empty' => false,
                                                                                            'fields' => 'all'
                                                                                        ) ); ?>
                                                                                        <select multiple data-plugin="selectpicker" data-live-search="true" id="selectionLevel" class="form-control" title="Select Level" name="selectionLevel[]">
                                                                                            <?php foreach($levels as $level) : ?>
                                                                                                <option value="<?php echo $level->term_id; ?>"><?php echo $level->name; ?></option>
                                                                                            <?php endforeach; ?>
                                                                                        </select>
                                                                                </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                                <div class="form-group form-control-default required">
                                                                                        <label for="selectionBrand">Brand</label>
                                                                                        <?php $brands = get_terms( array(
                                                                                            'taxonomy' => 'selection_brand',
                                                                                            'hide_empty' => false,
                                                                                            'fields' => 'all'
                                                                                        ) ); ?>
                                                                                        <select data-plugin="selectpicker" data-live-search="true" class="form-control" title="Select Brand" id="selectionBrand" name="selectionBrand">
                                                                                            <?php foreach($brands as $brand) : ?>
                                                                                                <option value="<?php echo $brand->term_id; ?>"><?php echo $brand->name; ?></option>
                                                                                            <?php endforeach; ?>
                                                                                        </select>
                                                                                </div>
                                                                        </div>
                                                                </div>

                                                                <div class="row ">
                                                                        <div class="col-md-12">
                                                                                <div class="form-group form-control-default required">
                                                                                        <label for="selectionDescription">Description</label>
                                                                                        <textarea name="selectionDescription" class="form-control" id="selectionDescription" placeholder="Description" required=""></textarea>
                                                                                </div>
                                                                        </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        Labour Price
                                                                    </div>
                                                                </div>
                                                                <div class="selectionLabourContainer" data-rows="1">
                                                                <div class="row selectionLabourRow">
                                                                        <div class="col-md-4">
                                                                                <div class="form-group form-control-default required">
                                                                                        <label for="selectionLabourTitle">Title</label>
                                                                                        <input name="selectionLabourTitle[]" type="text" class="form-control margin-bottom-10 selectionLabourTitle" placeholder="Title" required>
                                                                                </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                                <div class="form-group form-control-default required">
                                                                                        <label for="selectionLabourPrice">Price, $</label>
                                                                                        <input name="selectionLabourPrice[]" type="number" min="0" class="form-control margin-bottom-10 selectionLabourPrice" placeholder="" value="0.00" required>
                                                                                </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                                <div class="form-group form-control-default required">
                                                                                        <label for="selectionLabourDescription">Description</label>
                                                                                        <input name="selectionLabourDescription[]" type="text" class="form-control margin-bottom-10 selectionLabourDescription" placeholder="Description" required>
                                                                                </div>
                                                                        </div>
                                                                        <div class="col-md-1 padding-top-35">
                                                                            <a style="display:none;" class="btn btn-xs btn-outline btn-round btn-danger btn-icon deleteteLabour">
                                                                                <i class="icon wb-minus margin-horizontal-0"></i>
                                                                            </a>
                                                                        </div>
                                                                </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="text-center">
                                                                            <a class="btn btn-xs btn-outline btn-round btn-default btn-icon populateLabour">
                                                                                <i class="icon wb-plus margin-horizontal-0"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        Material Price
                                                                    </div>
                                                                </div>
                                                                <div class="selectionMaterialContainer" data-rows="1">
                                                                <div class="row selectionMaterialRow">
                                                                        <div class="col-md-4">
                                                                                <div class="form-group form-control-default required">
                                                                                        <label for="selectionMaterialTitle">Title</label>
                                                                                        <input name="selectionMaterialTitle[]" type="text" class="form-control margin-bottom-10 selectionMaterialTitle" placeholder="Title" required>
                                                                                </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                                <div class="form-group form-control-default required">
                                                                                        <label for="selectionMaterialPrice">Price, $</label>
                                                                                        <input name="selectionMaterialPrice[]" type="number" min="0" class="form-control margin-bottom-10 selectionMaterialPrice" placeholder="" value="0.00" required>
                                                                                </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                                <div class="form-group form-control-default required">
                                                                                        <label for="selectionMaterialDescription">Description</label>
                                                                                        <input name="selectionMaterialDescription[]" type="text" class="form-control margin-bottom-10 selectionMaterialDescription" placeholder="Description" required>
                                                                                </div>
                                                                        </div>
                                                                        <div class="col-md-1 padding-top-35">
                                                                            <a style="display:none;" class="btn btn-xs btn-outline btn-round btn-danger btn-icon deleteteMaterial">
                                                                                <i class="icon wb-minus margin-horizontal-0"></i>
                                                                            </a>
                                                                        </div>
                                                                </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="text-center">
                                                                            <a class="btn btn-xs btn-outline btn-round btn-default btn-icon populateMaterial">
                                                                                <i class="icon wb-plus margin-horizontal-0"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row margin-top-10">
                                                                    <div class="col-md-12">
                                                                        Photos
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="selectionPhotos">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row margin-vertical-20">
                                                                    <div class="col-md-12">
                                                                        <div class="text-center">
                                                                            <a class="btn btn-sm btn-outline btn-default btn-icon addSelectionPhotos">
                                                                                <i class="icon wb-upload margin-horizontal-0"></i> Upload Photo
                                                                            </a>
                                                                            <input type='file' name='attach' id='attach' accept="image/*" style="display:none;">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div id="addSelectionResponse">
                                                                </div>
                                                                <div class="text-center"><a class="btn btn-primary addSelection">Save Selection</a></div>
                                                                </form>
                                                        </div>

                                                </div>
                                        </div>
                                </div>
                                <!-- End Panel -->
                                                  </div>
                </div>
        </div>
</div>
<!-- End Page -->
<?php get_footer(); ?>
