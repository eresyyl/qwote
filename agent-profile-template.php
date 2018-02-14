<?php
/*
Template Name: Agent Profile
*/

$agent_name = get_query_var('agent_name');
$agent = get_user_by('login', $agent_name);
$user_type = get_field('user_type', "user_$agent->ID");

if( $user_type != "Agent") { 
	get_template_part( 404 ); 
	exit();
}

$agent_data = go_userdata($agent->ID);
?>
<?php get_header(); ?>
<div class="page animsition">	
	<div class="container container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="section-title">Profile</h1>
			</div>
			<div class="row">
				<div class="col-md-3">
					<div class="widget text-center">
						<div class="widget-header">
							<div class="widget-header-content">
								<div class="avatar avatar-lg">
									<img src="<?php echo $agent_data->avatar; ?>">
								</div>
								<h4 class="profile-user"><?php echo $agent_data->first_name; ?> <?php echo $agent_data->last_name; ?></h4>
								<div class="profile-job">
									<p> <?php the_field('business_name','user_' . $agent->ID); ?> </p>
								</div>
								<div class="profile-job">
									<p><?php echo $agent_data->email; ?></p>
									<p><?php echo $agent_data->phone; ?></p>
								</div>
								<div class="profile-job margin-top-10">
									<p> <?php echo $agent_data->address; ?> </p>
								</div>
							</div>
						</div>
					</div>
				</div>						
				<div class="col-md-9">
					<div class="panel">
						<div class="panel-body">
							<h3 class="section-title"> Templates </h3>
							<div class="row feature-group">
								<div class="col-lg-12 wow fadeIn animated">
									<?php
										$by_project_args = array('post_type'=>'template', 'posts_per_page'=>-1, 'author'  =>  $agent->ID );
										$by_project_templates = get_posts($by_project_args);
									?>
									<?php foreach($by_project_templates as $template) : ?>
										<div class="col-md-3 col-xs-6">
											<figure class="quote_option text-center" >
												<img src="<?php the_field('template_image',$template->ID); ?>">
												<figcaption class="margin-top-10">
													<div class="font-size-20 margin-bottom-30 blue-grey-800"><?php echo $template->post_title; ?></div>
												</figcaption>
											</figure>
										</div>
									<?php endforeach; ?>
									<?php if( empty($by_project_templates) ): ?>
										<div>Sorry, there are no templates here yet.</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>    
</div>

 <?php get_footer(); ?>