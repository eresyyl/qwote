<?php
require('../../../../../wp-load.php');
?>
<?php $projectId = $_POST['projectId']; ?>
<?php if(!is_user_logged_in() ) : ?>

	<div class="row margin-top-40">
		<div class="col-md-6 col-md-offset-3">
			<?php // if user is not logged in let's show error ?>
		    <div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Sorry, but something went wrong. Please, try again!</div>
		</div>
	</div>
<?php else : ?>

	<?php
	// if user is client we don't need any additional data, let's show only quote selects
	if(is_client() && $projectId == '0') : $currentUserId = current_user_id(); ?>

			<div class="row margin-top-40">
				<div class="col-md-6 col-md-offset-3">

					<div class="row">
						<div class="col-md-12">
							<h4 class="example-title text-center">TIMEFRAME</h4>
							<p>
               Do you need it done, If so when?
							</p>
				            <div class="form-group text-center">
				            <?php $timeframes = get_field('timeframe',9065); ?>
				              	<select name="projectTimeframe" class="form-control">
	                                <?php foreach($timeframes as $timeframe) : ?>
			                        	<option><?php echo $timeframe['timeframe']; ?></option>
			                    	<?php endforeach; ?>
	                            </select>
				            </div>
						</div>
					</div>

				</div>
			</div>

			<div style="display:none;">
			<select  name="projectClient" class="form-control selectpicker" data-live-search="true">
				<option value="<?php echo $currentUserId; ?>" selected>default</option>>
			</select>
			</div>

	<?php elseif(is_agent() && $projectId == '0') : ?>

		<div class="row margin-top-40">
			<div class="col-md-6 col-md-offset-3">

				<div class="row">
					<div class="col-md-12">
						<h4 class="example-title text-center">City</h4>
							<p>
							What area is the project in?
							</p>
			            <div class="form-group text-center">
			            <?php $cities = get_field('cities',9065); ?>
			              	<select name="projectCity" class="form-control">
			              	<?php foreach($cities as $city) : ?>
		                        <option><?php echo $city['city']; ?></option>
		                    <?php endforeach; ?>
		                    </select>
			            </div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<h4 class="example-title text-center">STATUS</h4>
						<p>
								Do you need it done, if so when?
							</p>
			            <div class="form-group text-center">
			            <?php $timeframes = get_field('timeframe',9065); ?>
			              	<select name="projectTimeframe" class="form-control">
                                <?php foreach($timeframes as $timeframe) : ?>
		                        	<option><?php echo $timeframe['timeframe']; ?></option>
		                    	<?php endforeach; ?>
                            </select>
			            </div>
					</div>
				</div>

			</div>
		</div>

		<div class="row margin-vertical-20">
			<div class="col-md-6 col-md-offset-3">

				<div class="row">
					<div class="col-md-12">
						<h4 class="example-title text-center">Select Client</h4>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="showClients">
						<div class="form-group text-center">
						<?php
						$current_user_id = current_user_id();
				        $agents_clients = get_field('contacts','user_' . $current_user_id);
				        $agents_clients_only = array();
				        foreach($agents_clients as $contact) {
				                $user_type = get_field('user_type','user_' . $contact['ID']);
				                if($user_type == 'Client') {
				                        $agents_clients_only[] = $contact['ID'];
				                }
				        }
				        ?>

							<select name="projectClient" class="form-control selectpicker" data-live-search="true">
								<?php
								if(!empty($agents_clients_only) && is_array($agents_clients_only)) {
                                    echo "<option value='0'>Select your client</option>";
                                    foreach ($agents_clients_only as $client) {
                                        $client_data = get_userdata($client);
                                        $first_client_name = $client_data->first_name;
                                        $last_client_name = $client_data->last_name;
                                        echo "<option value='" . $client . "'>" . $first_client_name . " " . $last_client_name . "</option>";
                                    }
                                }
                                else {
                                    echo "<option value='0'>You have no client yet!</option>";
                                }
                                ?>
							</select>

							<script>
								$('.selectpicker').selectpicker({
								  size: 6
								});
							</script>

						</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12 text-center">
						<a class="btn btn-sm btn-default" data-target="#newClient" data-toggle="modal">Add New User</a>
					</div>
				</div>

				
			</div>
		</div>


		<!-- Modal -->
		<div class="modal fade" id="newClient" aria-hidden="true" aria-labelledby="newClient"
		role="dialog" tabindex="-1">
		  <div class="modal-dialog modal-center">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">×</span>
		        </button>
		        <h4 class="modal-title">Create new client</h4>
		      </div>
		      <div class="modal-body">
		        <p class="text-center">Client will recieve all neccessary data to its email!</p>

		        <form id="registerClient">

		        <div class="row margin-top-40">
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
		            <h4 class="example-title text-center">Full Address</h4>
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
									We'll use this number once the job is ready to go.  
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
		        </form>

		        <div class="row">
		          <div class="col-md-12">
		          	<div id="createClientResponse"></div>
		          </div>
		        </div>

		      </div>
		      <div class="modal-footer text-center">
		        <button type="button" class="btn btn-primary registerClientButton registerClient">Create</button>
		      </div>
		    </div>
		  </div>
		</div>
		<!-- End Modal -->

	<?php elseif(is_headcontractor() && $projectId == '0') : ?>

		<div class="row margin-top-40">
			<div class="col-md-6 col-md-offset-3">

				<div class="row">
					<div class="col-md-12">
						<h4 class="example-title text-center">TIMEFRAME</h4>
						<p>
								Do you need it done, if so when
							</p>
			            <div class="form-group text-center">
			            <?php $timeframes = get_field('timeframe',9065); ?>
			              	<select name="projectTimeframe" class="form-control">
                                <?php foreach($timeframes as $timeframe) : ?>
		                        	<option><?php echo $timeframe['timeframe']; ?></option>
		                    	<?php endforeach; ?>
                            </select>
			            </div>
					</div>
				</div>

			</div>
		</div>

		<div class="row margin-vertical-20">
			<div class="col-md-6 col-md-offset-3">

				<div class="row">
					<div class="col-md-12">
						<h4 class="example-title text-center">Select Client</h4>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="showClients">
						<div class="form-group text-center">
						<?php
						$current_user_id = current_user_id();
				        $head_clients = get_users( array( 'meta_key' => 'user_type', 'meta_value' => 'Client', 'number' => 9999 ) );
				        ?>

							<select name="projectClient" class="form-control selectpicker" data-live-search="true">
								<?php
								if(!empty($head_clients) && is_array($head_clients)) {
                                    echo "<option value='0'>Select your client</option>";
                                    foreach ($head_clients as $client) {
                                        $client_data = get_userdata($client->data->ID);
                                        $first_client_name = $client_data->first_name;
                                        $last_client_name = $client_data->last_name;
                                        echo "<option value='" . $client->data->ID . "'>" . $first_client_name . " " . $last_client_name . "</option>";
                                    }
                                }
                                else {
                                    echo "<option value='0'>You have no client yet!</option>";
                                }
                                ?>
							</select>

							<script>
								$('.selectpicker').selectpicker({
								  size: 6
								});
							</script>

						</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12 text-center">
						<a class="btn btn-round btn-sm btn-default" data-target="#newClient" data-toggle="modal">Add New User</a>
					</div>
				</div>

			</div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="newClient" aria-hidden="true" aria-labelledby="newClient"
		role="dialog" tabindex="-1">
		  <div class="modal-dialog modal-center">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">×</span>
		        </button>
		        <h4 class="modal-title">Create new user</h4>
		      </div>
		      <div class="modal-body">
		        <p class="text-center">User will recieve login details via email!</p>

		        <form id="registerClient">

		        <div class="row margin-top-40">
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
									We'l use this number once the job starts.  
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
		        </form>

		        <div class="row">
		          <div class="col-md-12">
		          	<div id="createClientResponse"></div>
		          </div>
		        </div>

		      </div>
		      <div class="modal-footer text-center">
		        <button type="button" class="btn btn-primary registerClientButton registerClient">Create</button>
		      </div>
		    </div>
		  </div>
		</div>
		<!-- End Modal -->

	<?php endif; ?>

	<div class="row">
	  <div class="col-md-6 col-md-offset-3">
	    <div id="finishProjectResponse"></div>
	  </div>
	</div>

	<?php if($projectId == '0') : ?>
	<div class="row margin-top-20">
	  <div class="col-md-12">
	    <a class='btn btn-primary btn-lg finishButton finishProject'>Get Your Price</a>
	  </div>
	</div>
	<?php endif; ?>

<?php endif; ?>
