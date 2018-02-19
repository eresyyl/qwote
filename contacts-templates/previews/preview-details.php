<?php
require_once( ABSPATH . 'wp-load.php');

$contact_id = $_GET['contact_id'];
$contact_info = go_userdata($contact_id);
$contact_type = get_field('user_type','user_' . $contact_id);
$contact_stats = go_projects_statistic($contact_id);



if($contact_type == 'Client') {
        $quotes = $contact_stats->quote;
        $going = $contact_stats->active + $contact_stats->pending + $contact_stats->live;
        $completed = $contact_stats->completed;
        $recent_project_args = array('posts_per_page'=>10,'post_type'=>'project','meta_key' => 'client_id','meta_value' => $contact_id);
        //$recent_project_args = array('posts_per_page'=>10,'post_type'=>'project','meta_query'=>array(array('key'=>'client_id','value'=>$contact_id,'compare'=>'=')));
}
elseif($contact_type == 'Contractor') {
        $quotes = $contact_stats->quote;
        $going = $contact_stats->active + $contact_stats->pending + $contact_stats->live;
        $completed = $contact_stats->completed;

        // let's go for all projects and get ID's of projects where current user id exist. stored in $contractorProjects array
        $allProjects = get_posts(array('posts_per_page' => 9999, 'post_type' => 'project', 'meta_key' => 'contractor_id'));
        $contractorProjects = array();
        foreach($allProjects as $p) {
        	$contractors = get_field('contractor_id',$p->ID);
        	$contractorsArray = array();
        	foreach($contractors as $c) {
        		$contractorsArray[] = $c["ID"];
        	}
        	if(in_array($contact_id,$contractorsArray)) {
        		$contractorProjects[] = $p->ID;
        	}
        }
        if(!is_array($contractorProjects) || count($contractorProjects) == 0) {
        	$contractorProjects = array(0);
        }
        $recent_project_args = array('posts_per_page'=>10,'post_type'=>'project','post__in'=>$contractorProjects);
        //$recent_project_args = array('posts_per_page'=>10,'post_type'=>'project','meta_query'=>array(array('key'=>'contractor_id','value'=>$contact_id,'compare'=>'=')));
}
elseif($contact_type == 'Agent') {
        $quotes = $contact_stats->quote;
        $going = $contact_stats->active + $contact_stats->pending + $contact_stats->live;
        $completed = $contact_stats->completed;

        // let's go for all projects and get ID's of projects where current user id exist. stored in $agentProjects array
        $allProjects = get_posts(array('posts_per_page' => 9999, 'post_type' => 'project', 'meta_key' => 'agent_id'));
        $agentProjects = array();
        foreach($allProjects as $p) {
        	$agents = get_field('agent_id',$p->ID);
        	$agentsArray = array();
        	foreach($agents as $a) {
        		$agentsArray[] = $a["ID"];
        	}
        	if(in_array($contact_id,$agentsArray)) {
        		$agentProjects[] = $p->ID;
        	}
        }
        if(!is_array($agentProjects) || count($agentProjects) == 0) {
        	$agentProjects = array(0);
        }
        $recent_project_args = array('posts_per_page'=>10,'post_type'=>'project','post__in'=>$agentProjects);
        //$recent_project_args = array('posts_per_page'=>10,'post_type'=>'project','meta_query'=>array(array('key'=>'agent_id','value'=>$contact_id,'compare'=>'=')));
}
?>
<header class="slidePanel-header bg-blue-600">
        <div class="slidePanel-actions" aria-label="actions" role="group">
                <button type="button" class="btn btn-pure btn-inverse slidePanel-close actions-top icon wb-close"
                aria-hidden="true"></button>
        </div>
        <h1>User details</h1>
</header>
<div class="slidePanel-inner">

        <section class="slidePanel-inner-section">

                <div class="padding-horizontal-15">

                <div class="row">
                        <div class="col-md-12">
                                <div class="widget widget-shadow">
                                        <div class="widget-header white bg-red-600 padding-30 clearfix">
                                                <a class="avatar avatar-100 pull-left margin-right-20" href="javascript:void(0)">
                                                        <img src="<?php echo $contact_info->avatar; ?>" alt="">
                                                </a>
                                                <div class="pull-left relative">
                                                        <div class="font-size-20 margin-bottom-15 newNames"><?php echo $contact_info->first_name . " " . $contact_info->last_name; ?></div>
                                                        <p class="margin-bottom-5 text-nowrap"><i class="icon wb-envelope margin-right-10" aria-hidden="true"></i>
                                                                <span class="text-break"><?php echo $contact_info->email; ?></span>
                                                        </p>
                                                        <p class="margin-bottom-5 text-nowrap"><i class="fa fa-phone margin-right-10" aria-hidden="true"></i>
                                                                <span class="text-break newPhone"><?php echo $contact_info->phone; ?></span>
                                                        </p>
                                                        <p class="margin-bottom-5 text-nowrap"><i class="icon wb-map margin-right-10" aria-hidden="true"></i>
                                                                <span class="text-break newAddress"><?php echo $contact_info->address; ?></span>
                                                        </p>
										 <?php if($contact_type == 'Contractor') : ?>
												 <p class="margin-bottom-5 text-nowrap">
												  Business:<span class="text-break"> <?php the_field('business_name','user_' . $contact_id); ?> 
													 </span><br/>
													 ABN #:
                         <span class="text-break"> <?php the_field('trade','user_' . $contact_id); ?> </span> <br/>
													 
                         Areas serviced:<span class="text-break"> <?php the_field('areas_serviced','user_' . $contact_id); ?> </span><br/>
                         </p>													
																									
                 <?php endif; ?>
                                                        <?php if ( (is_agent() || is_headcontractor() ) && ( $contact_type == 'Client' || $contact_type == 'Contractor' ) ) : ?>
                                                        <div class="frontEndManage">
                    										<a class="btn btn-xs btn-outline btn-round btn-default btn-icon" data-toggle="modal" data-target="#manageContact"><i class="icon white wb-pencil"></i></a>
                    									</div>
                                                        <div class='modal fade' id='manageContact' aria-hidden='true' aria-labelledby='manageContact' role='dialog' tabindex='-1'>
                                                            <div class='modal-dialog modal-center'>
                                                                <div class='modal-content'>
                                                                    <div class='modal-header text-center'>
                                                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                                            <span aria-hidden='true'>×</span>
                                                                        </button>
                                                                        <h4 class='modal-title'>Manage User Details</h4>
                                                                    </div>
                                                                    <div class='modal-body text-center'>
                                                                        <div class="form-group">
                                                                            <input class="form-control" type="text" placeholder="First Name" name="userFirstName" value="<?php echo $contact_info->first_name; ?>">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <input class="form-control" type="text" placeholder="Last Name" name="userLastName" value="<?php echo $contact_info->last_name; ?>">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <input class="form-control" type="text" placeholder="Phone" name="userPhone" value="<?php echo $contact_info->phone; ?>">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <input class="form-control" type="text" placeholder="Address" name="userAddress" value="<?php echo $contact_info->address; ?>">
                                                                        </div>
                                                                        <div id="changeUserResponse"></div>
                                                                    </div>
                                                                    <div class="modal-footer text-center">
                                                                        <button type="button" class="btn btn-success changeUser" data-user="<?php echo $contact_id; ?>">Save</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php endif; ?>

                                                </div>
                                        </div>
                                        <div class="widget-content bg-blue-grey-100">
                                                <div class="row no-space padding-vertical-20 padding-horizontal-30 text-center">
                                                        <?php if($contact_type == 'Client' || $contact_type == 'Contractor' || $contact_type == 'Agent') : ?>
                                                                <div class="col-xs-4">
                                                                        <div class="counter">
                                                                                <span class="counter-number red-600"><?php echo $quotes; ?></span>
                                                                                <div class="counter-label">Quotes</div>
                                                                        </div>
                                                                </div>
                                                                <div class="col-xs-4">
                                                                        <div class="counter">
                                                                                <span class="counter-number red-600"><?php echo $going; ?></span>
                                                                                <div class="counter-label">Going Projects</div>
                                                                        </div>
                                                                </div>
                                                                <div class="col-xs-4">
                                                                        <div class="counter">
                                                                                <span class="counter-number red-600"><?php echo $completed; ?></span>
                                                                                <div class="counter-label">Completed</div>
                                                                        </div>
                                                                </div>
                                                        <?php elseif($contact_type == 'Head') : ?>
                                                                <div class="col-xs-12 text-center">
                                                                        <p>User is Head Contractor.</p>
                                                                </div>
                                                        <?php endif; ?>
                                                </div>
                                        </div>
                                </div>

                        </div>
                </div>

                <?php if($contact_type != 'Head') : ?>
                <div class="row">
                        <div class="col-md-12">
                                <div class="table-responsive">
                                        <table class="table">
                                                <thead>
                                                        <tr>
                                                	        <th>Status</th>
                                                		<th>Date</th>
                                                		<th>Project</th>
                                                		<th>Price</th>
                                                	</tr>
                                                </thead>
                                                <tbody>
							<?php
							// $recent_projects = get_posts($recent_project_args);
							$new_query = new WP_Query($recent_project_args);
							if ($new_query->have_posts()) : while ($new_query->have_posts()) : $new_query->the_post();
                                                        $quote_id = get_the_ID();
							$client_id = get_field('client_id',$quote_id);
							$client = go_userdata($client_id['ID']);
                                                        $agent_id = get_field('agent_id',$quote_id);
                                                        $agent_id = $agent_id['ID'];
                                                        $agent_info = go_userdata($agent_id);
							$status = go_project_status($quote_id);
							?>
                                                        <tr>
								<td class="work-status">
									<span class="label label-<?php echo $status->status_class; ?>"><?php echo $status->status_string; ?></span>
								</td>
								<td class="date">
									<span class="blue-grey-400"><?php echo get_the_time('d/m/Y',$quote_id); ?></span>
								</td>
								<td class="subject">
									<div class="table-content">
                                    <p class="blue-grey-500">
                                    <?php if(is_agent() || is_headcontractor()) : ?>
                                        <a class="blue-grey-500" href="<?php echo get_the_permalink($quote_id); ?>"><?php echo get_the_title($quote_id); ?></a>
                                    <?php else : ?>
                                        <?php echo get_the_title($quote_id); ?>
                                    <?php endif; ?>
                                    </p>
									</div>
								</td>
								<td class="total">
                                                                        <?php $total = get_field('total',$quote_id); if($total) { $total = number_format($total, 2, '.', ''); } else { $total = '0.00'; } ?>
									$<?php echo $total; ?>
								</td>
                                                        </tr>
							<?php endwhile; ?>
							<?php else : ?>
								<tr class="text-center">
									<td colspan="5">
										There is no projects yet.
									</td>
								</tr>
							<?php endif; ?>
                                                </tbody>
                                        </table>
                                </div>
                        </div>
                </div>
                <?php endif; ?>

                <?php if($contact_type == 'Agent' || $contact_type == 'Contractor' ) : ?>
					<div class="row">
						<div class="col-md-12">
							<h4 color="blue-grey-800">Reviews</h4>
							<?php 
								$agent_id = $contact_id; 
								include('page-parts/project-reviews.php'); 
							?>							
						</div>
					</div>
                <?php endif; ?>

                <?php if( (is_agent() || is_headcontractor()) && $contact_type != 'Head') : ?>
                <div class="row">
                     <div class="col-md-12">
                             <h4 color="blue-grey-800">Notes</h4>
                             <div class="all_contact_notes">
                             <?php if(get_field('notes','user_' . $contact_id)) : $notes = get_field('notes','user_' . $contact_id); ?>
                                     <?php foreach($notes as $n) : $note_author = $n['author_id']; $note_author = go_userdata($note_author['ID']); ?>
                                             <div class="widget widget-shadow margin-bottom-20">
                                                     <div class="widget-content padding-20 bg-blue-grey-100 height-full">
                                                             <a class="avatar pull-left margin-right-20" href="javascript:void(0)">
                                                                     <img src="<?php echo $note_author->avatar; ?>" alt="">
                                                             </a>
                                                             <div style="overflow:hidden;">
                                                                     <div class="font-size-18"><?php echo $note_author->first_name; ?> <?php echo $note_author->last_name; ?></div>
                                                                     <div class="font-size-14 margin-bottom-10"><?php echo $note_author->type; ?></div>
                                                                     <div>
                                                                             <?php echo $n['note']; ?>
                                                                     </div>
                                                             </div>
                                                     </div>
                                             </div>
                                     <?php endforeach; ?>
                             <?php endif; ?>
                             </div>

                             <form id="contact_notes">
                                     <input type="hidden" class="contact_id" value="<?php echo $contact_id; ?>">
                                     <div class="form-group form-control-default required">
                                             <textarea style="height:175px;" name="contact_notes" class="form-control" id="exampleInputAddress" placeholder="Enter your notes" required=""></textarea>
                                     </div>
                             </form>
                             <div class="contact_notes_response margin-vertical-20"></div>
                             <a class="btn btn-block btn-success save_contact_notes">Save Notes</a>

                     </div>
                </div>
                <?php endif; ?>

                </div>


        </section>

</div>

<script>
$(document).ready(function() {

    $('.changeUser').click(function(){
		var userId = $(this).attr('data-user'),
			firstName = $('input[name=userFirstName]').val(),
			lastName = $('input[name=userLastName]').val(),
            phone = $('input[name=userPhone]').val(),
            address = $('input[name=userAddress]').val();
		changeUser(userId,firstName,lastName,phone,address);
	});
    function changeUser(userId,firstName,lastName,phone,address) {
    	$('#changeUserResponse').html('');
    	var url = "/wp-content/themes/go/contacts-templates/ajax/changeUser.php";

    		if(firstName.length<1) {
                $('#changeUserResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>First name can't be blank!</div>");
                return false;
            }
            if(lastName.length<1) {
                $('#changeUserResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Last name can't be blank!</div>");
                return false;
            }
            if(phone.length<1) {
                $('#changeUserResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Phone can't be blank!</div>");
                return false;
            }
            if(address.length<1) {
                $('#changeUserResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Address can't be blank!</div>");
                return false;
            }

            showLoader();
    	 	jQuery.ajax({
      	  	url: url,
       	 	type: "POST",
    		dataType: 'json',
    		cache: false,
    		data: {
    			'userId' : userId,
    			'firstName' : firstName,
                'lastName' : lastName,
                'phone' : phone,
                'address' : address
    		},
       	 	success: function(response) {
    		        if(response.status == 'fail') {
    		        	$('#changeUserResponse').html(response.message);
    		        }
    		        else if(response.status == 'success') {
                        $('#changeUserResponse').html('');
                        $('.newNames').html(response.newFirstName + ' ' + response.newLastName);
                        $('.newPhone').html(response.newPhone);
                        $('.newAddress').html(response.newAddress);
    		        	$('.close').click();
    		        }
    		        removeLoader();
    		 	},
    		error: function(response) {
    		        $('#changeUserResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>");
    		        removeLoader();
    	  		}
    	  	});
    }

	$(".save_contact_notes").click(function(){
                var notes = $('textarea[name=contact_notes]').val();
                var contact_id = $('.contact_id').val();
                $(".contact_notes_response").html('<div class="text-center"><i class="fa fa-refresh fa-spin"</i></div>');

                if(notes.length<1) {
                        $(".contact_notes_response").html("<div class='red-800'>You need to enter Notes!</div>");
                        return false;
                }

		var newNotes = '<?php bloginfo("template_url"); ?>/contacts-templates/ajax/save_notes.php';
   	 	jQuery.ajax({
      	  	url: newNotes,
       	 	type: "POST",
                        //dataType: "html",
			dataType: "json",
                        cache: false,
			data: {
			        'notes' : notes,
                                'contact_id' : contact_id
			},
       	 	success: function(response) {
                                $(".contact_notes_response").html(response.message);
                                var newNote = '<div class="widget widget-shadow margin-bottom-20"><div class="widget-content padding-20 bg-blue-grey-100 height-full"><a class="avatar pull-left margin-right-20" href="javascript:void(0)"><img src="' + response.ava + '" alt=""></a><div style="overflow:hidden;"><div class="font-size-18">' + response.username + '</div><div class="font-size-14 margin-bottom-10">' + response.usertype + '</div><div>' + response.note + '</div></div></div></div>';
                                $(".all_contact_notes").append(newNote);
                                $('textarea[name=contact_notes]').val('');
   		 	},
    		error: function(response) {
	 	                $(".contact_notes_response").html("<div class='red-800'>Something went wrong! Try again later.</div>");
    		        }
  	  	});
	});
});
</script>
