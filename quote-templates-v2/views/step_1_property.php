<?php
if($_GET['projectId']) {
  $projectId = $_GET['projectId']; $projectId = intval($projectId);
}
elseif($_POST['projectId']) {
  $projectId = $_POST['projectId']; $projectId = intval($projectId);
}
else {
  $projectId = 0;
}
if($_GET['token']) {
  $agentToken = $_GET['token'];
}
?>
	                                <?php if(is_headcontractor() || is_agent()) : ?>

<div class="row">

  <div class="col-md-6 col-md-offset-3">
							<h4 class="example-title text-center">Choose your city?</h4>
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
 <?php endif ;?>
<div class="row text-center">
						
  
  				 							<div class="font-size-20 margin-20 white text-center">Choose your service?</div>

  
                      <?php
    $by_project_cnt = 0;
    $by_project_args = array('post_type'=>'template', 'posts_per_page'=>-1, 'meta_key'=>'by_type','meta_value'=>'main');
    $by_project_templates = get_posts($by_project_args);
    foreach($by_project_templates as $template) :
    ?>


       <div class="col-md-3 col-xs-6">

       <?php /* <figure class="quote_option overlay text-center" data-name="<?php echo $template->post_title; ?>" data-project="<?php echo $projectId; ?>" data-template="<?php echo $template->ID; ?>" data-target="#startProject" data-toggle="modal"> */ ?>
       <figure
            class="quote_option text-center startProject"
            data-name="<?php echo $template->post_title; ?>"
            data-project="<?php echo $projectId; ?>"
            data-template="<?php echo $template->ID; ?>"
            <?php if($agentToken) : ?>data-token="<?php echo $agentToken; ?>"<?php else : ?>data-token="0"<?php endif; ?>>
                    <img src="<?php the_field('template_image',$template->ID); ?>">
                    <figcaption class="margin-top-10">
                      <div class="font-size-20 margin-bottom-30 white"><?php echo $template->post_title; ?></div>
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
                    
                                

    <!-- Modal -->
    <div class="modal fade" id="startProject" aria-hidden="true" aria-labelledby="startProject"
    role="dialog" tabindex="-1">
      <div class="modal-dialog modal-center">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">Instant Quote</h4>
          </div>
          <div class="modal-body">
          <div class="modal-footer text-center">
            <button type="button" class="btn btn-success btn-lg btn-block startProject" <?php if($agentToken) : ?>data-token="<?php echo $agentToken; ?>"<?php else : ?>data-token="0"<?php endif; ?>>Start Project</button>
          </div>
        </div>
      </div>
    </div>
    <!-- End Modal -->

</div>
			
</div>