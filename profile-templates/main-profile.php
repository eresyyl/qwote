<?php 
$current_user_id = current_user_id();
$current_user_data = go_userdata($current_user_id);
$current_user_stats = go_projects_statistic($current_user_id);
$client_string = get_field('client','options');
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
                                                        <div class="margin-bottom-10"><span class="label label-lg label-info"><?php echo $client_string; ?></span></div>
                                                        <div class="profile-job">
                                                                <p><?php echo $current_user_data->email; ?></p>
                                                                <p><?php echo $current_user_data->phone; ?></p>
                                                        </div>
                                                        <a href="<?php bloginfo('url'); ?>/new_quote" class="btn btn-primary">New Quote</a>
                                                        <a href="<?php bloginfo('url'); ?>/all_projects" class="btn btn-info">Manage Projects</a>
                                                </div>
                                        </div>
                                        <div class="widget-footer">
                                                <div class="row no-space">
                                                        <div class="col-xs-4">
                                                                <strong class="profile-stat-count"><?php echo $current_user_stats->quote; ?></strong>
                                                                <span>Quotes</span>
                                                        </div>
                                                        <div class="col-xs-4">
                                                                <strong class="profile-stat-count"><?php echo $stat = $current_user_stats->active +  $current_user_stats->pending + $current_user_stats->live; ?></strong>
                                                                <span>Going Projects</span>
                                                        </div>
                                                        <div class="col-xs-4">
                                                                <strong class="profile-stat-count"><?php echo $current_user_stats->completed; ?></strong>
                                                                <span>Completed</span>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                                <!-- End Page Widget -->
                        </div>
                        <div class="col-md-9">
                          <div role="alert" class="alert alert-success alert-dismissible">
                  <button aria-label="Close" data-dismiss="alert" class="close" type="button">
                    <span aria-hidden="true">×</span>
                  </button>
                  <h4>Welcome</h4>
                  <p>
                    Please make sure your profile is filled out correctly, we will contact you on the details we have on file. Renover is a platform that connect homeowners with contractors, we donnot undertake the work directly. </p>
                </div>
                                <!-- Panel -->
                                <div class="panel">
                                        <div class="panel-body nav-tabs-animate">
                                                <ul class="nav nav-tabs nav-tabs-line" data-plugin="nav-tabs" role="tablist">
                                                        <li class="active" role="presentation"><a data-toggle="tab" href="#personal" aria-controls="personal" role="tab">Personal</a></li>
                                                        <li role="presentation"><a data-toggle="tab" href="#security" aria-controls="security" role="tab">Security</a></li>
                                                </ul>
                                                <div class="tab-content">
                                                        <div class="tab-pane active animation-slide-left" id="personal" role="tabpanel">
                                                                <form id="account">
                                                                <input type="hidden" name="user_type" value="Client">
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
                                                                <input type="hidden" name="user_type" value="Client">
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