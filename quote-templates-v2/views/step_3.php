<?php
$projectData = json_encode($_POST);
//$projectData = $_POST;
$projectId = $_POST['projectId'];
?>
<div style="position:relative;">

<h4 class="example-title text-center">See your Price</h4>
<div class="row text-center">

  <?php if(!is_user_logged_in() ) : ?>

    <div class="row margin-vertical-20 authTabs">
      <div class="col-md-6 col-md-offset-3">
        <div class="form-group">

            <input type="hidden" value="<?php echo $projectId; ?>" name="projectId">

            <div style='display:inline-block;' class='margin-horizontal-10 text-center radio-custom radio-danger'><input type='radio' value='tryLogin' id='sign_in' class='quote_guest' name='quote_guest'><label for='sign_in'>Sign In</label></div>
            <div style='display:inline-block;' class='margin-horizontal-10 text-center radio-custom radio-success'><input type='radio' value='tryRegister' id='register' class='quote_guest' name='quote_guest' checked><label for='register'>Create New</label></div>

        </div>
      </div>
    </div>

    <div class="row tryLogin" style="display:none;">
      <div class="col-md-6 col-md-offset-3">

        <div class="row">
          <div class="col-md-12">
            <h4 class="example-title text-center">E-mail</h4>
            <div class="form-group text-center">
              <input type="email" class="form-control" name="loginEmail">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <h4 class="example-title text-center">Password</h4>
            <div class="form-group text-center">
              <input type="password" class="form-control" name="loginPassword">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div id="loginFail"></div>
          </div>
        </div>

        <div class="row margin-top-20">
          <div class="col-md-12 text-center">
            <a class="btn btn-danger btn-lg loginButton doLogin">Sign In</a>
          </div>
        </div>

      </div>
    </div>

    <div class="row tryRegister">
      <div class="col-md-6 col-md-offset-3">

        <div class="row">
          <div class="col-md-6">
            <h4 class="example-title text-center">First Name</h4>
            <div class="form-group text-center">
              <input type="text" class="form-control" name="registerFirstName">
            </div>
          </div>
          <div class="col-md-6">
            <h4 class="example-title text-center">Last Name</h4>
            <div class="form-group text-center">
              <input type="text" class="form-control" name="registerLastName">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <h4 class="example-title text-center">Address</h4>
							 <small>
									Used to look up the house online for the final quote. 
								</small>
            <div class="form-group text-center">
              <input type="text" class="form-control" name="registerAddress">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <h4 class="example-title text-center">Phone</h4>
							 <small>
									We'll call you once the job is ready to go. 
								</small>
            <div class="form-group text-center">
							<input type="tel" class="form-control" id="inputPhone" name="registerPhone" data-plugin="formatter" data-pattern="([[999999999]]">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <h4 class="example-title text-center">E-mail</h4>
            <div class="form-group text-center">
              <input type="email" class="form-control" name="registerEmail">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <h4 class="example-title text-center">Password</h4>
            <div class="form-group text-center">
              <input type="password" class="form-control" name="registerPassword">
            </div>
          </div>
          <div class="col-md-6">
            <h4 class="example-title text-center">Re-type Password</h4>
            <div class="form-group text-center">
              <input type="password" class="form-control" name="registerPasswordCheck">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div id="registerFail"></div>
          </div>
        </div>

        <div class="row margin-top-20">
          <div class="col-md-12 text-center">
            <a class="btn btn-danger btn-lg registerButton doRegister">Get your Price</a>
          </div>
        </div>

      </div>
    </div>

  <?php endif; ?>

  <form id="personalDetailsForm" method="POST" action="<?php bloginfo('url'); ?>/add_quote/step4">
  <?php if($projectId != '0') : ?>
      <input type="hidden" name="clientId" value="<?php echo get_field('client_id',$projectId); ?>">
  <?php endif; ?>
  <input type="hidden" name="projectData" value="<?php echo base64_encode($projectData); ?>">
  <div id="responseSuccess"></div>
  </form>

</div>

<div class="row margin-bottom-40">
  <div class="col-md-12">
    <a class='btn btn-default btn-sm margin-top-40 margin-horizontal-10 backStep2'>back</a>
  </div>
</div>

</div>

<!-- Modal -->
<div class="modal fade" id="resetProject" aria-hidden="true" aria-labelledby="resetProject"
role="dialog" tabindex="-1">
  <div class="modal-dialog modal-center">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title">Are you sure?</h4>
      </div>
      <div class="modal-body">
        <p class="text-center">All progress will be lost! Are you sure you want to restart?</p>
      </div>
      <div class="modal-footer text-center">
        <button type="button" data-project="<?php echo $projectId; ?>" class="btn btn-danger resetProject">Yes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>
<!-- End Modal -->
