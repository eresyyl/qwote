<?php // getting defaults
$projectId = get_the_ID();
$projectTitle = get_the_title($projectId);
$projectStatus = go_project_status($projectId);
$projectCity = get_field('projectCity',$projectId);
$allCities = get_field('cities',9065);
$projectTimeframe = get_field('projectTimeframe',$projectId);
$allTimeframes = get_field('timeframe',9065);

$clientId = get_field('client_id',$projectId); $clientId = $clientId['ID'];
$clientData = go_userdata($clientId);

$headClients = get_users( array( 'meta_key' => 'user_type', 'meta_value' => 'Client', 'number' => 9999 ) );

$headAgents = get_users( array( 'meta_key' => 'user_type', 'meta_value' => 'Agent', 'number' => 9999 ) );
$headContractors = get_users( array( 'meta_key' => 'user_type', 'meta_value' => 'Contractor', 'number' => 9999 ) );

$projectPayments = get_field('payments',$projectId);

?>

<div class='modal fade' id='manageTitle' aria-hidden='true' aria-labelledby='manageTitle' role='dialog' tabindex='-1'>
    <div class='modal-dialog modal-center'>
        <div class='modal-content'>
            <div class='modal-header text-center'>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                </button>
                <h4 class='modal-title'>Manage Title</h4>
            </div>
            <div class='modal-body text-center'>
                <div class="form-group">
                    <input class="form-control" type="text" name="projectTitle" value="<?php echo $projectTitle; ?>">
                </div>
                <div id="changeTitleResponse"></div>
            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-success changeTitle" data-project="<?php echo $projectId; ?>">Save</button>
            </div>
        </div>
    </div>
</div>

<div class='modal fade' id='manageStatus' aria-hidden='true' aria-labelledby='manageStatus' role='dialog' tabindex='-1'>
    <div class='modal-dialog modal-center'>
        <div class='modal-content'>
            <div class='modal-header text-center'>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                </button>
                <h4 class='modal-title'>Manage Status</h4>
            </div>
            <div class='modal-body text-center'>
                <div class="form-group">
                    <select class="form-control" name="projectStatus">
                        <option value="quote" <?php if($projectStatus->status == 'quote') { echo "selected"; } ?>>Quote</option>
                        <option value="pending" <?php if($projectStatus->status == 'pending') { echo "selected"; } ?>>Final Quote</option>
                        <option value="live" <?php if($projectStatus->status == 'live') { echo "selected"; } ?>>Live</option>
                        <option value="completed" <?php if($projectStatus->status == 'completed') { echo "selected"; } ?>>Completed</option>
                        <option value="cancelled" <?php if($projectStatus->status == 'cancelled') { echo "selected"; } ?>>Cancelled</option>
                    </select>
                </div>
                <div id="changeStatusResponse"></div>
            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-success changeStatus" data-project="<?php echo $projectId; ?>" data-status="<?php echo $projectStatus->status; ?>">Save</button>
            </div>
        </div>
    </div>
</div>

<div class='modal fade' id='manageCity' aria-hidden='true' aria-labelledby='manageCity' role='dialog' tabindex='-1'>
    <div class='modal-dialog modal-center'>
        <div class='modal-content'>
            <div class='modal-header text-center'>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                </button>
                <h4 class='modal-title'>Manage City</h4>
            </div>
            <div class='modal-body text-center'>
                <div class="form-group">
                    <select class="form-control" name="projectCity">
                    <?php foreach($allCities as $aC) : ?>
                        <option <?php if($aC['city'] == $projectCity) { echo "selected"; } ?>><?php echo $aC['city']; ?></option>
                    <?php endforeach; ?>
                    </select>
                </div>
                <div id="changeCityResponse"></div>
            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-success changeCity" data-project="<?php echo $projectId; ?>" data-city="<?php echo $projectCity; ?>">Save</button>
            </div>
        </div>
    </div>
</div>

<div class='modal fade' id='manageTimeframe' aria-hidden='true' aria-labelledby='manageTimeframe' role='dialog' tabindex='-1'>
    <div class='modal-dialog modal-center'>
        <div class='modal-content'>
            <div class='modal-header text-center'>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                </button>
                <h4 class='modal-title'>Manage Timeframe</h4>
            </div>
            <div class='modal-body text-center'>
                <div class="form-group">
                    <select class="form-control" name="projectTimeframe">
                    <?php foreach($allTimeframes as $aT) : ?>
                        <option <?php if($aT['timeframe'] == $projectTimeframe) { echo "selected"; } ?>><?php echo $aT['timeframe']; ?></option>
                    <?php endforeach; ?>
                    </select>
                </div>
                <div id="changeTimeframeResponse"></div>
            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-success changeTimeframe" data-project="<?php echo $projectId; ?>" data-timeframe="<?php echo $projectTimeframe; ?>">Save</button>
            </div>
        </div>
    </div>
</div>

<div class='modal fade' id='manageClient' aria-hidden='true' aria-labelledby='manageClient' role='dialog' tabindex='-1'>
    <div class='modal-dialog modal-center'>
        <div class='modal-content'>
            <div class='modal-header text-center'>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                </button>
                <h4 class='modal-title'>Manage Client</h4>
            </div>
            <div class='modal-body text-center'>
                <div class="form-group">
                    <h4 class="font-size-14">Current: <?php echo $clientData->first_name; ?> <?php echo $clientData->last_name; ?></h4>
                    <select name="projectClient" class="form-control selectpicker" data-live-search="true">
                        <?php
                        if(!empty($headClients) && is_array($headClients)) {
                            echo "<option value='0'>Select your client</option>";
                            foreach ($headClients as $client) {
                                $client_data = get_userdata($client->data->ID);
                                $first_client_name = $client_data->first_name;
                                $last_client_name = $client_data->last_name;
                                $client_email = $client_data->user_email;
                                if($clientId == $client->data->ID) { $selected = "selected"; } else { $selected = ''; }
                                echo "<option value='" . $client->data->ID . "' " . $selected . ">" . $first_client_name . " " . $last_client_name . " (" . $client_email . ")</option>";
                            }
                        }
                        else {
                            echo "<option value='0'>You have no client yet!</option>";
                        }
                        ?>
                    </select>
                </div>
                <div id="changeClientResponse"></div>
            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-success changeClient" data-project="<?php echo $projectId; ?>">Save</button>
            </div>
        </div>
    </div>
</div>

<div class='modal fade' id='removeContractor' aria-hidden='true' aria-labelledby='removeContractor' role='dialog' tabindex='-1'>
    <div class='modal-dialog modal-center'>
        <div class='modal-content'>
            <div class='modal-header text-center'>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                </button>
                <h4 class='modal-title'>Do you want to remove Contractor?</h4>
            </div>
            <div class='modal-body text-center'>
                <div class="form-group">
                    <h4 class="font-size-14 contractorToRemove"></h4>
                </div>
                <div id="removeContractorResponse"></div>
            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-danger removeContractor" data-project="<?php echo $projectId; ?>" data-contractor="">Remove</button>
            </div>
        </div>
    </div>
</div>

<div class='modal fade' id='removeAgent' aria-hidden='true' aria-labelledby='removeAgent' role='dialog' tabindex='-1'>
    <div class='modal-dialog modal-center'>
        <div class='modal-content'>
            <div class='modal-header text-center'>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                </button>
                <h4 class='modal-title'>Do you want to remove contractor?</h4>
            </div>
            <div class='modal-body text-center'>
                <div class="form-group">
                    <h4 class="font-size-14 agentToRemove"></h4>
                </div>
                <div id="removeAgentResponse"></div>
            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-danger removeAgent" data-project="<?php echo $projectId; ?>" data-agent="">Remove</button>
            </div>
        </div>
    </div>
</div>

<div class='modal fade' id='addAgent' aria-hidden='true' aria-labelledby='addAgent' role='dialog' tabindex='-1'>
    <div class='modal-dialog modal-center'>
        <div class='modal-content'>
            <div class='modal-header text-center'>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                </button>
                <h4 class='modal-title'>Add Project Manager</h4>
            </div>
            <div class='modal-body text-center'>
                <div class="form-group">
                    <select name="projectAgent" class="form-control selectpicker" data-live-search="true">
                        <?php
                        if(!empty($headClients) && is_array($headClients)) {
                            echo "<option value='0'>Select</option>";
                            foreach ($headAgents as $agent) {
                                $agent_data = get_userdata($agent->data->ID);
                                $first_agent_name = $agent_data->first_name;
                                $last_agent_name = $agent_data->last_name;
                                $agent_email = $agent_data->user_email;
                                $selected = '';
                                echo "<option value='" . $agent->data->ID . "' " . $selected . ">" . $first_agent_name . " " . $last_agent_name . " (" . $agent_email . ")</option>";
                            }
                        }
                        else {
                            echo "<option value='0'>There are no Job managers yet!</option>";
                        }
                        ?>
                    </select>
                </div>
                <div id="addAgentResponse"></div>
            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-success addAgent" data-project="<?php echo $projectId; ?>">Add</button>
            </div>
        </div>
    </div>
</div>

<div class='modal fade' id='addContractor' aria-hidden='true' aria-labelledby='addContractor' role='dialog' tabindex='-1'>
    <div class='modal-dialog modal-center'>
        <div class='modal-content'>
            <div class='modal-header text-center'>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                </button>
                <h4 class='modal-title'>Add contractor</h4>
            </div>
            <div class='modal-body text-center'>
                <div class="form-group">
                    <select name="projectContractor" class="form-control selectpicker" data-live-search="true">
                        <?php
                        if(!empty($headContractors) && is_array($headContractors)) {
                            echo "<option value='0'>Select Contractor</option>";
                            foreach ($headContractors as $contractor) {
                                $contractor_data = get_userdata($contractor->data->ID);
                                $first_contractor_name = $contractor_data->first_name;
                                $last_contractor_name = $contractor_data->last_name;
                                $contractor_email = $contractor_data->user_email;
                                $selected = '';
                                echo "<option value='" . $contractor->data->ID . "' " . $selected . ">" . $first_contractor_name . " " . $last_contractor_name . " (" . $contractor_email . ")</option>";
                            }
                        }
                        else {
                            echo "<option value='0'>There are no contractors yet!</option>";
                        }
                        ?>
                    </select>
                </div>
                <div id="addContractorResponse"></div>
            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-success addContractor" data-project="<?php echo $projectId; ?>">Add</button>
            </div>
        </div>
    </div>
</div>

<div class='modal fade' id='removeScope' aria-hidden='true' aria-labelledby='removeScope' role='dialog' tabindex='-1'>
    <div class='modal-dialog modal-center'>
        <div class='modal-content'>
            <div class='modal-header text-center'>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                </button>
                <h4 class='modal-title'>Do you really want to remove this scope?</h4>
            </div>
            <div class='modal-body text-center'>
                <div class="form-group">
                    <h4 class="font-size-14 scopeToRemove"></h4>
                </div>
                <div id="removeScopeResponse"></div>
            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-danger removeScope" data-project="<?php echo $projectId; ?>" data-scope="">Remove</button>
            </div>
        </div>
    </div>
</div>
