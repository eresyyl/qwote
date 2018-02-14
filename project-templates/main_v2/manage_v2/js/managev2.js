$(document).ready(function() {

	$('.schedulePaymentCheckbox').change(function(){
		var projectId = $(this).attr('data-quote'),
			taskRow = $(this).attr('data-row'),
			schedulerow = $(this).attr('data-schedulerow');
		scheduleTask(projectId,schedulerow,taskRow);
	});

	$('.changeTitle').click(function(){
		var projectId = $(this).attr('data-project'),
			projectTitle = $('input[name=projectTitle]').val();
		changeTitle(projectId,projectTitle);
	});

	$('.changeStatus').click(function(){
		var projectId = $(this).attr('data-project'),
			projectStatus = $('select[name=projectStatus]').val(),
			projectStatusBefore = $(this).attr('data-status');
		changeStatus(projectId,projectStatus,projectStatusBefore);
	});

	$('.changeCity').click(function(){
		var projectId = $(this).attr('data-project'),
			projectCity = $('select[name=projectCity]').val(),
			projectCityBefore = $(this).attr('data-city');
		changeCity(projectId,projectCity,projectCityBefore);
	});

	$('.changeTimeframe').click(function(){
		var projectId = $(this).attr('data-project'),
			projectTimeframe = $('select[name=projectTimeframe]').val(),
			projectTimeframeBefore = $(this).attr('data-timeframe');
		changeTimeframe(projectId,projectTimeframe,projectTimeframeBefore);
	});

	$('.changeClient').click(function(){
		var projectId = $(this).attr('data-project'),
			clientId = $('select[name=projectClient]').val();
			changeClient(projectId,clientId);
	});

	$('.projectAccept').click(function(){
		var projectId = $(this).attr('data-project'),
			userId = $(this).attr('data-user');
			projectAccept(projectId,userId);
	});
	$('.projectCancel').click(function(){
		var projectId = $(this).attr('data-project'),
			userId = $(this).attr('data-user');
			projectCancel(projectId,userId);
	});

	$('.projectComplete').click(function(){
		var projectId = $(this).attr('data-project'),
			userId = $(this).attr('data-user');
			projectComplete(projectId,userId);
	});

	$('.removeContractorMiddleware').click(function(){
		var contractorId = $(this).attr('data-contractor'),
			contractorName = $(this).attr('data-names');
			$('.contractorToRemove').html(contractorName);
			$('.removeContractor').attr('data-contractor',contractorId);
	});
	$('.removeContractor').click(function(){
		var projectId = $(this).attr('data-project'),
			contractorId = $(this).attr('data-contractor');
			removeContractor(projectId,contractorId);
	});

	$('.removeAgentMiddleware').click(function(){
		var agentId = $(this).attr('data-agent'),
			agentName = $(this).attr('data-names');
			$('.agentToRemove').html(agentName);
			$('.removeAgent').attr('data-agent',agentId);
	});
	$('.removeAgent').click(function(){
		var projectId = $(this).attr('data-project'),
			agentId = $(this).attr('data-agent');
			removeAgent(projectId,agentId);
	});

	$('.addAgent').click(function(){
		var projectId = $(this).attr('data-project'),
			agentId = $('select[name=projectAgent]').val();
			addAgent(projectId,agentId);
	});

	$('.addContractor').click(function(){
		var projectId = $(this).attr('data-project'),
			contractorId = $('select[name=projectContractor]').val();
			addContractor(projectId,contractorId);
	});

	$('.removeScopeMiddleware').click(function(){
		var scopeId = $(this).attr('data-scope'),
			scopeName = $(this).attr('data-names');
			$('#removeScopeResponse').html('');
			$('.scopeToRemove').html(scopeName);
			$('.removeScope').attr('data-scope',scopeId);
	});
	$('.removeScope').click(function(){
		var projectId = $(this).attr('data-project'),
			scopeId = $(this).attr('data-scope');
			removeScope(projectId,scopeId);
	});

	$('.showScope').click(function(){
		var projectId = $(this).attr('data-project'),
			scopeId = $(this).attr('data-scope');
			showScope(projectId,scopeId);
	});

	$('.manageSelections').click(function(){
		var projectId = $(this).attr('data-project'),
			scopeId = $(this).attr('data-scope');
			manageSelections(projectId,scopeId);
	});

	/*
	$('#showScopeResponse').on('click','.selectionSelect',function(){
		var selectionId = $(this).attr('data-id'),
				rowName = $(this).attr('data-name'),
				inputname = $(this).attr('data-inputname');

		console.log(rowName);
		console.log(inputname);

		if($(this).hasClass('btn-outline')) {
				$(this).removeClass('btn-outline');
				var newInput = ' <input type="hidden" class="' + selectionId + '" name="' + inputname + '[]" value="' + selectionId + '"> ';
				console.log(newInput);
				$('#' + rowName).append(newInput);
		}
		else {
			$(this).addClass('btn-outline');
			$('input.' + selectionId).remove();
			//alert('old selection');
		}

	});
	*/
	$('#showScopeResponse').on('change','.selectionSelect',function(){
		var selectionId = $(this).attr('data-id'),
				rowName = $(this).attr('data-name'),
				inputname = $(this).attr('data-inputname');

		//console.log(rowName);
		//console.log(inputname);

		if($(this).is(":checked")) {
				var newInput = ' <input type="hidden" class="' + selectionId + '" name="' + inputname + '[]" value="' + selectionId + '"> ';
				//console.log(newInput);
				$('#' + rowName).append(newInput);
		}
		else {
			$('input.' + selectionId).remove();
			//alert('old selection');
		}

	});

	// all scripts to manage payments
	$('.managePaymentsTab').click(function(){
		$('.managePaymentsTabClick').click();
	});
	$('.backToPayments').click(function(){
		$('.paymentsTabClick').click();
	});
	$('#projectPaymentsManageResponse').on('click', '.removePayment', function() {
	        $(this).closest('.payments').remove();
	});

	// load payment template on select change
	$('#projectPaymentsManageResponse').on('change', 'select[name=paymentsTemplate]', function() {
		var templateId = $(this).val(),
			projectId = $('input[name=projectId]').val();
		if (confirm('All current payments settings will be lost! Are you sure you want to load template?')) {
			managePaymentsShowTemplate(projectId,templateId);
		} else {
			return false;
		}
	});

	// all scripts to manage variations
	$('.manageVariationsTab').click(function(){
		$('.manageVariationsTabClick').click();
	});
	$('.backToVariations').click(function(){
		$('.variationsTabClick').click();
	});
	$('#projectVariationsManageResponse').on('click', '.removePayment', function() {
	        $(this).closest('.payments').remove();
	});

	// notes
	$('.addNote').click(function(){
		$('.notesForm').fadeIn();
		$(this).hide();
	});
	$('.cancelNote').click(function(){
		$('.notesForm').hide();
		$('.addNote').fadeIn();
	});
	$('.saveNote').click(function(){
		var projectId = $(this).attr('data-project');
			manageNotes(projectId);
	});

	// tasks
	$('.addTask').click(function(){
		$('.tasksForm').fadeIn();
		$(this).hide();
	});
	$('.cancelTask').click(function(){
		$('.tasksForm').hide();
		$('.addTask').fadeIn();
	});
	$('.saveTask').click(function(){
		var projectId = $(this).attr('data-project');
			manageTasks(projectId);
	});

	// schedules
	$('#manageSchedulesResponse').on('click', '.removeScheduleManage', function() {
	        $(this).closest('.schedulesManage').remove();
	});

	// load payment template on select change
	$('#manageSchedulesResponse').on('change', 'select[name=paymentsTemplate]', function() {
		var templateId = $(this).val(),
			projectId = $('input[name=projectId]').val();
		if (confirm('All current schedules settings will be lost! Are you sure you want to load template?')) {
			manageSchedulesShowTemplate(projectId,templateId);
		} else {
			return false;
		}
	});

	// photos for schedules
	$('#manageSchedulesResponse').on('click', '.scheduleAddPhoto', function() {
			var rand = $(this).attr('data-rand');
	        $('#schedulePhotoInput_' + rand).click();
	});
	$('#manageSchedulesResponse').on('change', '.schedulePhotoInput', function() {
			var $input = $(this),
				rand = $(this).attr('data-rand'),
				photoContainer = $(this).attr('data-photocontainer');
			uploadSchedulephoto($input,rand,photoContainer);
	});
	$('#manageSchedulesResponse').on('click', '.schedulePhotoUploaded i', function() {
			$(this).closest('.schedulePhotoUploaded').remove();
	});

    $('.projectReviewSave').click(function(){
		var projectId = $(this).attr('data-project')
            review = $('textarea[name=projectReview]').val();
			saveReview(projectId,review);
	});

	$('.uploadFile').click(function(){
		$('.uploads').click();
		//$('.dropzone').click();
	});

	$('.projectUploadsSave').click(function(){
		var projectId = $(this).attr('data-project');
			saveUploads(projectId);
	});

    $('.scheduleUploadsSave').click(function(){
		var projectId = $(this).attr('data-project'),
            row = $(this).attr('data-row');
			saveScheduleUploads(projectId,row);
	});

	$('.addContact').click(function(){
		var userId = $(this).attr('data-user');
			addContact(userId);
	});


	// schedule tasks
	$('#manageSchedulesResponse').on('click','.deleteteTask',function(){
        $(this).closest('.row').remove();
    });

	$('#manageSchedulesResponse').on('change','.hintDoneReal',function(){
		if ( $( this ).is( ":checked" ) ) {
			val = 'on';
		}
		else {
			val = 'off';
		}

		$(this).closest('.scheduleTask').find('.hintDone').val(val);
	});

	$('#manageSchedulesResponse').on('click','.addScheduleTask',function(){
		var id = $(this).attr('data-id'),
		newTask = '<div class="row margin-bottom-20 tasksRow"><div class="col-md-10"><input class="form-control input-sm tasksTitles" type="text" name="taskTitle_' + id + '[]" value=""></div><div class="col-md-1 text-center"><div class="checkbox-custom checkbox-primary scheduleTask" style="margin-top: 5px;"><input class="hintDone" type="hidden" value="off" name="taskDone_' + id + '[]"><input class="hintDoneReal" id="0" type="checkbox" name="_taskDone_' + id + '[]"><label for="0"><span></span></label></div></div><div class="col-md-1 text-center padding-top-5"><a style="display: inline-block;" class="btn btn-xs btn-outline btn-round btn-danger btn-icon deleteteTask"><i class="icon wb-minus margin-horizontal-0"></i></a></div></div>';
		$(this).closest('.allTasksRow').find('.allScheduleTasks').append(newTask);
    });

	$('.panel').on('click','.makeLead',function(){
		var agentId = $(this).attr('data-agent'),
			projectId = $(this).attr('data-project');
			makeLead(projectId,agentId);
	});


});

function showLoader() {
	$('.quoteOverlay').fadeIn();
}
function removeLoader() {
	$('.quoteOverlay').fadeOut();
}

function changeTitle(projectId,projectTitle) {
	$('#changeTitleResponse').html('');
	var url = "/wp-content/themes/go/project-templates/main_v2/manage_v2/ajax/changeTitle.php",
		projectId = projectId,
		projectTitle = projectTitle;

		if(projectTitle.length<1) {
            $('#changeTitleResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Project title can't be blank!</div>");
            return false;
        }

        showLoader();
	 	jQuery.ajax({
  	  	url: url,
   	 	type: "POST",
		dataType: 'json',
		cache: false,
		data: {
			'projectId' : projectId,
			'projectTitle' : projectTitle
		},
   	 	success: function(response) {
		        if(response.status == 'fail') {
		        	$('#changeTitleResponse').html(response.message);
		        }
		        else if(response.status == 'success') {
		        	$('.updateTitle').html(response.newTitle);
		        	$('.close').click();
		        }
		        removeLoader();
		 	},
		error: function(response) {
		        $('#changeTitleResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>");
		        removeLoader();
	  		}
	  	});
}

function changeStatus(projectId,projectStatus,projectStatusBefore) {
	$('#changeStatusResponse').html('');
	var url = "/wp-content/themes/go/project-templates/main_v2/manage_v2/ajax/changeStatus.php",
		projectId = projectId,
		projectStatus = projectStatus,
		projectStatusBefore = projectStatusBefore;

		if(projectStatusBefore == projectStatus) {
			$('#changeStatusResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>You need to change status!</div>");
            return false;
		}
		if(projectStatus.length<1) {
            $('#changeStatusResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something wrong with new status!</div>");
            return false;
        }

        showLoader();
	 	jQuery.ajax({
  	  	url: url,
   	 	type: "POST",
		dataType: 'json',
		cache: false,
		data: {
			'projectId' : projectId,
			'projectStatus' : projectStatus,
			'projectStatusBefore' : projectStatusBefore
		},
   	 	success: function(response) {
		        if(response.status == 'fail') {
		        	$('#changeStatusResponse').html(response.message);
		        	removeLoader();
		        }
		        else if(response.status == 'success') {
		        	location.reload();
		        }

		 	},
		error: function(response) {
		        $('#changeStatusResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>");
		        removeLoader();
	  		}
	  	});
}

function changeCity(projectId,projectCity,projectCityBefore) {
	$('#changeCityResponse').html('');
	var url = "/wp-content/themes/go/project-templates/main_v2/manage_v2/ajax/changeCity.php",
		projectId = projectId,
		projectCity = projectCity,
		projectCityBefore = projectCityBefore;

		if(projectCity == projectCityBefore) {
			$('#changeCityResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>You need to change city!</div>");
            return false;
		}
		if(projectCity.length<1) {
            $('#changeCityResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something wrong with new city!</div>");
            return false;
        }

        showLoader();
	 	jQuery.ajax({
  	  	url: url,
   	 	type: "POST",
		dataType: 'json',
		cache: false,
		data: {
			'projectId' : projectId,
			'projectCity' : projectCity,
			'projectCityBefore' : projectCityBefore
		},
   	 	success: function(response) {
		        if(response.status == 'fail') {
		        	$('#changeCityResponse').html(response.message);
		        }
		        else if(response.status == 'success') {
		        	$('.updateCity').html(response.newCity);
		        	$('.changeCity').attr('data-city',response.newCity);
		        	$('.close').click();
		        }
		        removeLoader();

		 	},
		error: function(response) {
		        $('#changeCityResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>");
		        removeLoader();
	  		}
	  	});
}

function changeTimeframe(projectId,projectTimeframe,projectTimeframeBefore) {
	$('#changeTimeframeResponse').html('');
	var url = "/wp-content/themes/go/project-templates/main_v2/manage_v2/ajax/changeTimeframe.php",
		projectId = projectId,
		projectTimeframe = projectTimeframe,
		projectTimeframeBefore = projectTimeframeBefore;

		if(projectTimeframe == projectTimeframeBefore) {
			$('#changeTimeframeResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>You need to change timeframe!</div>");
            return false;
		}
		if(projectTimeframe.length<1) {
            $('#changeTimeframeResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something wrong with new timeframe!</div>");
            return false;
        }

        showLoader();
	 	jQuery.ajax({
  	  	url: url,
   	 	type: "POST",
		dataType: 'json',
		cache: false,
		data: {
			'projectId' : projectId,
			'projectTimeframe' : projectTimeframe,
			'projectTimeframeBefore' : projectTimeframeBefore
		},
   	 	success: function(response) {
		        if(response.status == 'fail') {
		        	$('#changeTimeframeResponse').html(response.message);
		        }
		        else if(response.status == 'success') {
		        	$('.updateTimeframe').html(response.newTimeframe);
		        	$('.changeTimeframe').attr('data-timeframe',response.newTimeframe);
		        	$('.close').click();
		        }
		        removeLoader();

		 	},
		error: function(response) {
		        $('#changeTimeframeResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>");
		        removeLoader();
	  		}
	  	});
}

function changeClient(projectId,clientId) {
	$('#changeClientResponse').html('');
	var url = "/wp-content/themes/go/project-templates/main_v2/manage_v2/ajax/changeClient.php",
		projectId = projectId,
		clientId = clientId;

		if( clientId == '0' || clientId == NaN || clientId == undefined || clientId == null ) {
            $('#changeClientResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>You need to select client!</div>");
            return false;
    }

    showLoader();
	 	jQuery.ajax({
			url: url,
			type: "POST",
			dataType: 'json',
			cache: false,
			data: {
				'projectId' : projectId,
				'clientId' : clientId
			},
   	 	success: function(response) {
		        if(response.status == 'fail') {
		        	$('#changeClientResponse').html(response.message);
							removeLoader();
		        }
		        else if(response.status == 'success') {
		        	location.reload();
		        }
			},
			error: function(response) {
		        $('#changeClientResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>");
		        removeLoader();
			}
		});
}

function projectAccept(projectId,userId) {
	$('#projectAcceptingResponse').html('');
	var url = "/wp-content/themes/go/project-templates/main_v2/manage_v2/ajax/projectAccept.php",
		projectId = projectId,
		userId = userId;

    showLoader();
	 	jQuery.ajax({
			url: url,
			type: "POST",
			dataType: 'json',
			cache: false,
			data: {
				'projectId' : projectId,
				'userId' : userId
			},
   	 	success: function(response) {
		        if(response.status == 'fail') {
		        	$('#projectAcceptingResponse').html(response.message);
							removeLoader();
		        }
		        else if(response.status == 'success') {
							location.reload();
		        }
			},
			error: function(response) {
		        $('#projectAcceptingResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>");
		        removeLoader();
			}
		});
}

function projectCancel(projectId,userId) {
	$('#projectAcceptingResponse').html('');
	var url = "/wp-content/themes/go/project-templates/main_v2/manage_v2/ajax/projectCancel.php",
		projectId = projectId,
		userId = userId;

    showLoader();
	 	jQuery.ajax({
			url: url,
			type: "POST",
			dataType: 'json',
			cache: false,
			data: {
				'projectId' : projectId,
				'userId' : userId
			},
   	 	success: function(response) {
		        if(response.status == 'fail') {
		        	$('#projectAcceptingResponse').html(response.message);
							removeLoader();
		        }
		        else if(response.status == 'success') {
							location.reload();
		        }
			},
			error: function(response) {
		        $('#projectAcceptingResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>");
		        removeLoader();
			}
		});
}

function projectComplete(projectId,userId) {
	$('#projectCompletingResponse').html('');
	var url = "/wp-content/themes/go/project-templates/main_v2/manage_v2/ajax/projectComplete.php",
		projectId = projectId,
		userId = userId;

    showLoader();
	 	jQuery.ajax({
			url: url,
			type: "POST",
			dataType: 'json',
			cache: false,
			data: {
				'projectId' : projectId,
				'userId' : userId
			},
   	 	success: function(response) {
		        if(response.status == 'fail') {
		        	$('#projectCompletingResponse').html(response.message);
							removeLoader();
		        }
		        else if(response.status == 'success') {
							location.reload();
		        }
			},
			error: function(response) {
		        $('#projectCompletingResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>");
		        removeLoader();
			}
		});
}

function removeContractor(projectId,contractorId) {
	$('#removeContractorResponse').html('');
	var url = "/wp-content/themes/go/project-templates/main_v2/manage_v2/ajax/removeContractor.php",
		projectId = projectId,
		contractorId = contractorId;

    showLoader();
	 	jQuery.ajax({
			url: url,
			type: "POST",
			dataType: 'json',
			cache: false,
			data: {
				'projectId' : projectId,
				'contractorId' : contractorId
			},
   	 	success: function(response) {
		        if(response.status == 'fail') {
		        	$('#removeContractorResponse').html(response.message);
							removeLoader();
		        }
		        else if(response.status == 'success') {
							$('.close').click();
							$('#contractor-' + contractorId).remove();
							if ( $('.projectParticipants li').length < 1 ) {
								$('.noParticipants').show();
							}
							removeLoader();
		        }
			},
			error: function(response) {
		        $('#removeContractorResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>");
		        removeLoader();
			}
		});
}

function removeAgent(projectId,agentId) {
	$('#removeAgentResponse').html('');
	var url = "/wp-content/themes/go/project-templates/main_v2/manage_v2/ajax/removeAgent.php",
		projectId = projectId,
		agentId = agentId;

    showLoader();
	 	jQuery.ajax({
			url: url,
			type: "POST",
			dataType: 'json',
			cache: false,
			data: {
				'projectId' : projectId,
				'agentId' : agentId
			},
   	 	success: function(response) {
		        if(response.status == 'fail') {
		        	$('#removeAgentResponse').html(response.message);
							removeLoader();
		        }
		        else if(response.status == 'success') {
							$('.close').click();
							$('#agent-' + agentId).remove();
							if ( $('.projectParticipants li').length < 1 ) {
								$('.noParticipants').show();
							}
							removeLoader();
		        }
			},
			error: function(response) {
		        $('#removeAgentResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>");
		        removeLoader();
			}
		});
}

function addAgent(projectId,agentId) {
	$('#addAgentResponse').html('');
	var url = "/wp-content/themes/go/project-templates/main_v2/manage_v2/ajax/addAgent.php",
		projectId = projectId,
		agentId = agentId;

		if( agentId == '0' || agentId == NaN || agentId == undefined || agentId == null ) {
            $('#changeClientResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>You need to select Project Leader!</div>");
            return false;
    }

    showLoader();
	 	jQuery.ajax({
			url: url,
			type: "POST",
			dataType: 'json',
			cache: false,
			data: {
				'projectId' : projectId,
				'agentId' : agentId
			},
   	 	success: function(response) {
		        if(response.status == 'fail') {
		        	$('#addAgentResponse').html(response.message);
							removeLoader();
		        }
		        else if(response.status == 'success') {
		        	location.reload();
		        }
			},
			error: function(response) {
		        $('#addAgentResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>");
		        removeLoader();
			}
		});
}

function addContractor(projectId,contractorId) {
	$('#addContractorResponse').html('');
	var url = "/wp-content/themes/go/project-templates/main_v2/manage_v2/ajax/addContractor.php",
		projectId = projectId,
		contractorId = contractorId;

		if( contractorId == '0' || contractorId == NaN || contractorId == undefined || contractorId == null ) {
            $('#changeClientResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>You need to select Project Manager!</div>");
            return false;
    }

    showLoader();
	 	jQuery.ajax({
			url: url,
			type: "POST",
			dataType: 'json',
			cache: false,
			data: {
				'projectId' : projectId,
				'contractorId' : contractorId
			},
   	 	success: function(response) {
		        if(response.status == 'fail') {
		        	$('#addContractorResponse').html(response.message);
					console.log(response.log);
							removeLoader();
		        }
		        else if(response.status == 'success') {
		        	location.reload();
		        }
			},
			error: function(response) {
		        $('#addContractorResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>");
		        removeLoader();
			}
		});
}

function removeScope(projectId,scopeId) {
	$('#removeScopeResponse').html('');
	var url = "/wp-content/themes/go/project-templates/main_v2/manage_v2/ajax/removeScope.php",
		projectId = projectId,
		scopeId = scopeId;

    showLoader();
	 	jQuery.ajax({
			url: url,
			type: "POST",
			dataType: 'json',
			cache: false,
			data: {
				'projectId' : projectId,
				'scopeId' : scopeId
			},
   	 	success: function(response) {
		        if(response.status == 'fail') {
		        	$('#removeScopeResponse').html(response.message);
							removeLoader();
		        }
		        else if(response.status == 'success') {
		        	location.reload();
		        }
			},
			error: function(response) {
		        $('#removeScopeResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>");
		        removeLoader();
			}
		});
}

function showScope(projectId,scopeId) {
	$('#showScopeResponse').html('');
	var url = "/wp-content/themes/go/project-templates/main_v2/manage_v2/ajax/showScope.php",
		projectId = projectId,
		scopeId = scopeId;

    showLoader();
	 	jQuery.ajax({
			url: url,
			type: "POST",
			dataType: 'json',
			cache: false,
			data: {
				'projectId' : projectId,
				'scopeId' : scopeId
			},
   	 	success: function(response) {
		        if(response.status == 'fail') {
		        	$('#showScopeResponse').html(response.message);
							removeLoader();
		        }
		        else if(response.status == 'success') {
							$('#showScopeResponse').html(response.message);
							$('.scopeDefaultMessage').hide();
							removeLoader();
		        }
			},
			error: function(response) {
		        $('#showScopeResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>");
		        removeLoader();
			}
		});
}

function closeScope() {
	$('#showScopeResponse').html('');
	$('.scopeDefaultMessage').show();
}

function manageSelections(projectId,scopeId) {
	$('#showScopeResponse').html('');
	var url = "/wp-content/themes/go/project-templates/main_v2/manage_v2/ajax/manageSelections.php",
		projectId = projectId,
		scopeId = scopeId;

    showLoader();
	 	jQuery.ajax({
			url: url,
			type: "POST",
			dataType: 'json',
			cache: false,
			data: {
				'projectId' : projectId,
				'scopeId' : scopeId
			},
   	 	success: function(response) {
		        if(response.status == 'fail') {
		        	$('#showScopeResponse').html(response.message);
							removeLoader();
		        }
		        else if(response.status == 'success') {
						$('.scopeDefaultMessage').hide();
							$('#showScopeResponse').html(response.message);

							var elems = Array.prototype.slice.call(document.querySelectorAll('.switchy'));
							elems.forEach(function(html) {
							  var switchery = new Switchery(html);
							});
							removeLoader();
		        }
			},
			error: function(response) {
		        $('#showScopeResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>");
		        removeLoader();
			}
		});
}

function saveSelections() {
	$('#saveSelectionsResponse').html('');
	var url = "/wp-content/themes/go/project-templates/main_v2/manage_v2/ajax/saveSelections.php",
		projectId = projectId,
		scopeId = scopeId;

    showLoader();
	 	jQuery.ajax({
			url: url,
			type: "POST",
			dataType: 'json',
			cache: false,
			data: $('#scopeSelections').serialize(),
   	 	success: function(response) {
		        if(response.status == 'fail') {
		        	$('#saveSelectionsResponse').html(response.message);
					removeLoader();
		        }
		        else if(response.status == 'success') {
					//removeLoader();
					//console.log(response.log);
					location.reload();
		        }
			},
			error: function(response) {
		        $('#saveSelectionsResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>");
		        removeLoader();
			}
		});
}

function managePaymentsShow(projectId) {
	$('#projectPaymentsManageResponse').html('');
	var url = "/wp-content/themes/go/project-templates/main_v2/manage_v2/ajax/managePayments/projectPaymentsShow.php",
		projectId = projectId;
    	showLoader();
	 	jQuery.ajax({
			url: url,
			type: "POST",
			dataType: 'json',
			cache: false,
			data: {
				'projectId' : projectId,
			},
   	 	success: function(response) {
		        if(response.status == 'fail') {
		        	$('#projectPaymentsManageResponse').html(response.message);
					removeLoader();
		        }
		        else if(response.status == 'success') {
					$('#projectPaymentsManageResponse').html(response.message);
					console.log(response.log);
					removeLoader();
					$('.datepicker').datepicker({
					        format: 'dd/mm/yyyy',
					        startDate: '-0d',
					        autoclose: true
					});
					$('.selectpicker').selectpicker({
			          size: 6
			        });
		        }
			},
			error: function(response) {
		        $('#projectPaymentsManageResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>");
		        removeLoader();
			}
		});
}

function managePaymentsShowTemplate(projectId,templateId) {
	$('#projectPaymentsManageResponse').html('');
	var url = "/wp-content/themes/go/project-templates/main_v2/manage_v2/ajax/managePayments/projectPaymentsShowTemplate.php",
		projectId = projectId,
		templateId = templateId;
    	showLoader();
	 	jQuery.ajax({
			url: url,
			type: "POST",
			dataType: 'json',
			cache: false,
			data: {
				'projectId' : projectId,
				'templateId' : templateId,
			},
   	 	success: function(response) {
		        if(response.status == 'fail') {
		        	$('#projectPaymentsManageResponse').html(response.message);
					removeLoader();
		        }
		        else if(response.status == 'success') {
					$('#projectPaymentsManageResponse').html(response.message);
					console.log(response.log);
					removeLoader();
					$('.datepicker').datepicker({
					        format: 'dd/mm/yyyy',
					        startDate: '-0d',
					        autoclose: true
					});
					$('.selectpicker').selectpicker({
			          size: 6
			        });
		        }
			},
			error: function(response) {
		        $('#projectPaymentsManageResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>");
		        removeLoader();
			}
		});
}

function managePaymentsSave() {
	$('#savePaymentsResponse').html('');
	var url = "/wp-content/themes/go/project-templates/main_v2/manage_v2/ajax/managePayments/projectPaymentsSave.php";
    	showLoader();

		var titles_valid = true;
        $('.titles').each(function() {
                if(!$(this).val()){
					$('#savePaymentsResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>All payments titles should be filled!</div>");
    		        removeLoader();
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
					$('#savePaymentsResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>All payments percents should be filled!</div>");
					removeLoader();
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
					$('#savePaymentsResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>All payments dates should be filled!</div>");
					removeLoader();
					dates_valid = false;
					return false;
                }
        });
        if(dates_valid == false) {
                return false;
        }

	 	jQuery.ajax({
			url: url,
			type: "POST",
			dataType: 'json',
			cache: false,
			data: $('#managePaymentsForm').serialize(),
   	 	success: function(response) {
		        if(response.status == 'fail') {
		        	$('#savePaymentsResponse').html(response.message);
					removeLoader();
		        }
		        else if(response.status == 'success') {
					location.reload();
		        }
			},
			error: function(response) {
		        $('#savePaymentsResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>");
		        removeLoader();
			}
		});
}

function managePaymentsAdd() {
	$('#savePaymentsResponse').html('');
	var url = "/wp-content/themes/go/project-templates/main_v2/manage_v2/ajax/managePayments/projectPaymentsAdd.php";
    	showLoader();
	 	jQuery.ajax({
			url: url,
			type: "POST",
			dataType: 'json',
			cache: false,
			data: {
				'smth' : true,
			},
   	 	success: function(response) {
		        if(response.status == 'success') {
					$('#newPaymentBlock').append(response.message);
					removeLoader();
					$('.datepicker').datepicker({
					        format: 'dd/mm/yyyy',
					        startDate: '-0d',
					        autoclose: true
					});
		        }
				else {
					$('#savePaymentsResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>");
			        removeLoader();
				}
			},
			error: function(response) {
		        $('#savePaymentsResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>");
		        removeLoader();
			}
		});
}

function manageVariationsShow(projectId) {
	$('#projectVariationsManageResponse').html('');
	var url = "/wp-content/themes/go/project-templates/main_v2/manage_v2/ajax/manageVariations/projectVariationsShow.php",
		projectId = projectId;
    	showLoader();
	 	jQuery.ajax({
			url: url,
			type: "POST",
			dataType: 'json',
			cache: false,
			data: {
				'projectId' : projectId,
			},
   	 	success: function(response) {
		        if(response.status == 'fail') {
		        	$('#projectVariationsManageResponse').html(response.message);
					removeLoader();
		        }
		        else if(response.status == 'success') {
					$('#projectVariationsManageResponse').html(response.message);
					console.log(response.log);
					removeLoader();
					$('.datepicker').datepicker({
					        format: 'dd/mm/yyyy',
					        startDate: '-0d',
					        autoclose: true
					});
					$('.selectpicker').selectpicker({
			          size: 6
			        });
		        }
			},
			error: function(response) {
		        $('#projectVariationsManageResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>");
		        removeLoader();
			}
		});
}

function manageVariationsAdd() {
	$('#saveVariationsResponse').html('');
	var url = "/wp-content/themes/go/project-templates/main_v2/manage_v2/ajax/manageVariations/projectVariationsAdd.php";
    	showLoader();
	 	jQuery.ajax({
			url: url,
			type: "POST",
			dataType: 'json',
			cache: false,
			data: {
				'smth' : true,
			},
   	 	success: function(response) {
		        if(response.status == 'success') {
					$('#newPaymentBlockV').append(response.message);
					removeLoader();
					$('.datepicker').datepicker({
					        format: 'dd/mm/yyyy',
					        startDate: '-0d',
					        autoclose: true
					});
		        }
				else {
					$('#saveVariationsResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>");
			        removeLoader();
				}
			},
			error: function(response) {
		        $('#saveVariationsResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>");
		        removeLoader();
			}
		});
}

function manageVariationsSave() {
	$('#saveVariationsResponse').html('');
	var url = "/wp-content/themes/go/project-templates/main_v2/manage_v2/ajax/manageVariations/projectVariationsSave.php";
    	showLoader();

		var titles_valid = true;
        $('.titles').each(function() {
                if(!$(this).val()){
					$('#saveVariationsResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>All variations titles should be filled!</div>");
    		        removeLoader();
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
					$('#saveVariationsResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>All variations percents should be filled!</div>");
					removeLoader();
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
					$('#saveVariationsResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>All variations dates should be filled!</div>");
					removeLoader();
					dates_valid = false;
					return false;
                }
        });
        if(dates_valid == false) {
                return false;
        }

	 	jQuery.ajax({
			url: url,
			type: "POST",
			dataType: 'json',
			cache: false,
			data: $('#manageVariationsForm').serialize(),
   	 	success: function(response) {
		        if(response.status == 'fail') {
		        	$('#saveVariationsResponse').html(response.message);
					removeLoader();
		        }
		        else if(response.status == 'success') {
					location.reload();
		        }
			},
			error: function(response) {
		        $('#saveVariationsResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>");
		        removeLoader();
			}
		});
}

function manageNotes(projectId) {
	$('#notesResponse').html('');
	var url = "/wp-content/themes/go/project-templates/main_v2/manage_v2/ajax/noteAdd.php",
		projectId = projectId,
		noteText = $('textarea[name=noteText]').val(),
		noteRole = $('select[name=noteRole]').val();

		if (typeof projectId === 'undefined' || projectId === null) {
			$('#notesResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong! Project ID is wrong!</div>");
			console.log('Invalid ProjectId: ' + projectId);
			return false;
		}
		if (typeof noteText === 'undefined' || noteText === null || noteText === '') {
			$('#notesResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Note can't be empty!</div>");
			console.log('Invalid Note text: ' + noteText);
			return false;
		}
		if (typeof noteRole === 'undefined' || noteRole === null || noteRole === '0') {
			$('#notesResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Select user role!</div>");
			console.log('Invalid Note role: ' + noteRole);
			return false;
		}

		showLoader();
	 	jQuery.ajax({
			url: url,
			type: "POST",
			dataType: 'json',
			cache: false,
			data: {
				'projectId' : projectId,
				'noteText' : noteText,
				'noteRole' : noteRole
			},
   	 	success: function(response) {
		        if(response.status == 'fail') {
		        	$('#notesResponse').html(response.message);
					removeLoader();
		        }
		        else if(response.status == 'success') {
					$('#notesResponse').html('');
					$('.noNotes').hide();
					$('.notesForm').hide();
					$('.addNote').fadeIn();
					$('.project_notes').append(response.message);
					removeLoader();
		        }
			},
			error: function(response) {
		        $('#notesResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>");
		        removeLoader();
			}
		});
}

function manageTasks(projectId) {
	$('#tasksResponse').html('');
	var url = "/wp-content/themes/go/project-templates/main_v2/manage_v2/ajax/taskAdd.php",
		projectId = projectId,
		taskText = $('input[name=task]').val();

		if (typeof projectId === 'undefined' || projectId === null) {
			$('#notesResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong! Project ID is wrong!</div>");
			console.log('Invalid ProjectId: ' + projectId);
			return false;
		}
		if (typeof taskText === 'undefined' || taskText === null || taskText === '') {
			$('#notesResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Task can't be empty!</div>");
			console.log('Invalid Task text: ' + taskText);
			return false;
		}

		showLoader();
	 	jQuery.ajax({
			url: url,
			type: "POST",
			dataType: 'json',
			cache: false,
			data: {
				'projectId' : projectId,
				'taskText' : taskText
			},
   	 	success: function(response) {
		        if(response.status == 'fail') {
		        	$('#tasksResponse').html(response.message);
					removeLoader();
		        }
		        else if(response.status == 'success') {
					$('#tasksResponse').html('');
					$('.noTasks').hide();
					$('.tasksForm').hide();
					$('.addTask').fadeIn();
					$('.list-task').append(response.message);
					removeLoader();
		        }
			},
			error: function(response) {
		        $('#tasksResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>");
		        removeLoader();
			}
		});
}

function manageSchedulesShow(projectId) {
	$('#manageSchedulesResponse').html('');
	var url = "/wp-content/themes/go/project-templates/main_v2/manage_v2/ajax/manageSchedules/projectSchedulesShow.php",
		projectId = projectId;
    	showLoader();
	 	jQuery.ajax({
			url: url,
			type: "POST",
			dataType: 'json',
			cache: false,
			data: {
				'projectId' : projectId,
			},
   	 	success: function(response) {
		        if(response.status == 'fail') {
		        	$('#manageSchedulesResponse').html(response.message);
					removeLoader();
		        }
		        else if(response.status == 'success') {
					$('#manageSchedulesResponse').html(response.message);
					console.log(response.log);
					removeLoader();
					$('.datepicker').datepicker({
					        format: 'dd/mm/yyyy',
					        startDate: '-0d',
					        autoclose: true
					});
		        }
			},
			error: function(response) {
		        $('#manageSchedulesResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>");
		        removeLoader();
			}
		});
}

function manageSchedulesAdd() {
	$('#saveScheduleResponse').html('');
	var url = "/wp-content/themes/go/project-templates/main_v2/manage_v2/ajax/manageSchedules/projectSchedulesAdd.php",
		rows =  $('.schedulesManage').length;
		rows = rows+1;
		console.log(rows);
    	showLoader();
	 	jQuery.ajax({
			url: url,
			type: "POST",
			dataType: 'json',
			cache: false,
			data: {
				'smth' : true,
			},
   	 	success: function(response) {
		        if(response.status == 'success') {
					$('#newScheduleBlock').append(response.message);
					removeLoader();
					$('.datepicker').datepicker({
					        format: 'dd/mm/yyyy',
					        startDate: '-0d',
					        autoclose: true
					});
		        }
				else {
					$('#saveScheduleResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>");
			        removeLoader();
				}
			},
			error: function(response) {
		        $('#saveScheduleResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>");
		        removeLoader();
			}
		});
}

function manageSchedulesSave() {
	$('#savePaymentsResponse').html('');
	var url = "/wp-content/themes/go/project-templates/main_v2/manage_v2/ajax/manageSchedules/projectSchedulesSave.php";
    	showLoader();

		var titles_valid = true;
        $('.titles').each(function() {
                if(!$(this).val()){
					$('#saveScheduleResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>All schedules titles should be filled!</div>");
    		        removeLoader();
					titles_valid = false;
					return false;
                }
        });
        if(titles_valid == false) {
                return false;
        }

		var dates_valid = true;
        $('.dates').each(function() {
                if(!$(this).val()){
					$('#saveScheduleResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>All schedules dates should be filled!</div>");
					removeLoader();
					dates_valid = false;
					return false;
                }
        });
        if(dates_valid == false) {
                return false;
        }

		var taskTitles_valid = true;
        $('.tasksTitles').each(function() {
                if(!$(this).val()){
					$('#saveScheduleResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>All task titles should be filled!</div>");
    		        removeLoader();
					taskTitles_valid = false;
					return false;
                }
        });
        if(taskTitles_valid == false) {
                return false;
        }

	 	jQuery.ajax({
			url: url,
			type: "POST",
			dataType: 'json',
			cache: false,
			data: $('#manageSchedulesForm').serialize(),
   	 	success: function(response) {
		        if(response.status == 'fail') {
		        	$('#saveScheduleResponse').html(response.message);
					removeLoader();
		        }
		        else if(response.status == 'success') {
					location.reload();
					//console.log(response.log);
		        }
			},
			error: function(response) {
		        $('#saveScheduleResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>");
		        removeLoader();
			}
		});
}

function manageSchedulesShowTemplate(projectId,templateId) {
	$('#manageSchedulesResponse').html('');
	var url = "/wp-content/themes/go/project-templates/main_v2/manage_v2/ajax/manageSchedules/projectSchedulesShowTemplate.php",
		projectId = projectId,
		templateId = templateId;
    	showLoader();
	 	jQuery.ajax({
			url: url,
			type: "POST",
			dataType: 'json',
			cache: false,
			data: {
				'projectId' : projectId,
				'templateId' : templateId,
			},
   	 	success: function(response) {
		        if(response.status == 'fail') {
		        	$('#manageSchedulesResponse').html(response.message);
					removeLoader();
		        }
		        else if(response.status == 'success') {
					$('#manageSchedulesResponse').html(response.message);
					console.log(response.log);
					removeLoader();
					$('.datepicker').datepicker({
					        format: 'dd/mm/yyyy',
					        startDate: '-0d',
					        autoclose: true
					});
		        }
			},
			error: function(response) {
		        $('#manageSchedulesResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>");
		        removeLoader();
			}
		});
}

function uploadSchedulephoto(file,rand,photoContainer) {
	var file = file,
		photoContainer = photoContainer,
		fd = new FormData;
	fd.append('img', file.prop('files')[0]);
	fd.append('photoContainer', photoContainer);

	$.ajax({
		url: '/wp-content/themes/go/project-templates/main_v2/manage_v2/ajax/manageSchedules/projectSchedulesUploadPhoto.php',
		data: fd,
		processData: false,
		contentType: false,
		type: 'POST',
		success: function (data) {
			$('#schedulePhotoInput_' + rand).val('');
			$('.schedulePhotosResponse_' + rand).append(data);
		}
	});

}

function saveReview(projectId,review) {
	$('#projectReviewResponse').html('');
	var url = "/wp-content/themes/go/project-templates/main_v2/manage_v2/ajax/reviewSave.php";

        if(review.length < 1) {
            $('#projectReviewResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>You need to enter Review!</div>");
            return false;
        }

        showLoader();

	 	jQuery.ajax({
			url: url,
			type: "POST",
			dataType: 'json',
			cache: false,
			data: {
                'projectId' : projectId,
                'review' : review
            },
   	 	success: function(response) {
		        if(response.status == 'fail') {
		        	$('#projectReviewResponse').html(response.message);
					removeLoader();
		        }
		        else if(response.status == 'success') {
                    $('#projectReviewResponse').html('');
                    $('.reviewBlock').html(response.message);
					removeLoader();
		        }
			},
			error: function(response) {
		        $('#projectReviewResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>");
		        removeLoader();
			}
		});
}

function addContact(userId) {
	$('.user_' + userId).html('<i class="fa fa-spin fa-refresh margin-horizontal-0"></i>');
	var url = "/wp-content/themes/go/project-templates/main_v2/manage_v2/ajax/addContact.php";

	 	jQuery.ajax({
			url: url,
			type: "POST",
			dataType: 'json',
			cache: false,
			data: {
                'userId' : userId
            },
   	 	success: function(response) {
		        if(response.status == 'fail') {
		        	$('.user_' + response.userId).html('<i class="icon wb-user-add margin-horizontal-0"></i>');
		        }
		        else if(response.status == 'success') {
                    $('.user_' + response.userId).html('<i class="icon wb-check-mini green-800 margin-horizontal-0"></i>');
		        }
			},
			error: function(response) {
		        $('.addContact').html('<i class="icon wb-user-add margin-horizontal-0"></i>');
			}
		});
}

function scheduleTask(projectId, schedulerow, taskRow) {
	var url = "/wp-content/themes/go/project-templates/main_v2/manage_v2/ajax/scheduleTask.php";
console.log('Schedue row: ' + schedulerow);
console.log('Task row: ' + taskRow);
	 	jQuery.ajax({
			url: url,
			type: "POST",
			dataType: 'json',
			cache: false,
			data: {
                'projectId' : projectId,
				'scheduleRow' : schedulerow,
				'taskRow' : taskRow
            },
   	 	success: function(response) {
		        if(response.status == 'fail') {
					$('#scheduleTask_' + schedulerow + '_' + taskRow).attr('checked',false);
			        alert('Something went wrong!');
		        }
		        else if(response.status == 'success') {
					$('#scheduleTask_' + schedulerow + '_' + taskRow).attr('disabled',true);
					$('label[for=scheduleTask_' + schedulerow + '_' + taskRow + ']').css('text-decoration','line-through');
		        }
			},
			error: function(response) {
				$('#scheduleTask_' + schedulerow + '_' + taskRow).attr('checked',false);
		        alert('Something went wrong!');
			}
		});
}


function makeLead(projectId,agentId) {
	$('.agent_' + agentId).html('<i class="fa fa-spin fa-refresh margin-horizontal-0"></i>');
	var url = "/wp-content/themes/go/project-templates/main_v2/manage_v2/ajax/makeLead.php";

	 	jQuery.ajax({
			url: url,
			type: "POST",
			dataType: 'json',
			cache: false,
			data: {
				'projectId' : projectId,
                'agentId' : agentId
            },
   	 	success: function(response) {
		        if(response.status == 'fail') {
		        	$('.agent_' + response.agentId).html('<i class="icon wb-star-outline margin-horizontal-0"></i>');
		        }
		        else if(response.status == 'success') {
					$('a.alreadyLead i').removeClass('yellow-600').removeClass('wb-star').addClass('wb-star-outline');
					$('a.alreadyLead').removeClass('alreadyLead').addClass('makeLead').css('cursor','pointer');
					$('a.agent_' + response.agentId).addClass('alreadyLead').removeClass('makeLead').css('cursor','default');
                    $('.agent_' + response.agentId).html('<i class="icon wb-star yellow-600 margin-horizontal-0"></i>');
		        }
			},
			error: function(response) {
		        $('.agent_' + agentId).html('<i class="icon wb-star-outline margin-horizontal-0"></i>');
			}
		});
}

function saveUploads(projectId) {
	showLoader();
	$('.saveUploadsResponse').html('');
	var url = "/wp-content/themes/go/project-templates/main_v2/manage_v2/ajax/saveUploads.php";

	 	jQuery.ajax({
			url: url,
			type: "POST",
			dataType: 'json',
			cache: false,
			data: {
				'projectId' : projectId
            },
   	 	success: function(response) {
		        if(response.status == 'fail') {
		        	$('.saveUploadsResponse').html(response.message);
					removeLoader();
		        }
		        else if(response.status == 'success') {
					location.reload();
		        }
			},
			error: function(response) {
				$('.saveUploadsResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>");
				removeLoader();
			}
		});
}
function saveScheduleUploads(projectId,row) {
	showLoader();
	$('.scheduleDropzoneResponse_' + row).html('');
	var url = "/wp-content/themes/go/project-templates/main_v2/manage_v2/ajax/saveScheduleUploads.php";

	 	jQuery.ajax({
			url: url,
			type: "POST",
			dataType: 'json',
			cache: false,
			data: {
				'projectId' : projectId,
                'row' : row
            },
   	 	success: function(response) {
		        if(response.status == 'fail') {
		        	$('.scheduleDropzoneResponse_' + row).html(response.message);
					removeLoader();
		        }
		        else if(response.status == 'success') {
					location.reload();
		        }
			},
			error: function(response) {
				$('.scheduleDropzoneResponse_' + row).html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>");
				removeLoader();
			}
		});
}
