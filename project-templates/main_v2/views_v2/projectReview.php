<?php
// getting review information
$reviewData = array(
	'rating' => get_field('projectRating',$projectId),
	'review' => get_field('projectReview',$projectId)	
);
?>

<?php // Review (show only when projectStatus == completed) ?>
<?php if($projectStatus->status == 'completed') : ?>
	<div class="row margin-bottom-40 text-center">
		<div class="col-md-12">
			<?php if(get_field('projectReview',$projectId)) : ?>
				<?php include('projectReviewMessage.php'); ?>
			<?php else : ?>
				<div class="reviewBlock">
					<div class="margin-bottom-20 font-size-18" style="color:#37474f;">Please leave a review:</div>
					<div id="projectReviewResponse"></div>
					<div class="margin-bottom-20">
						<select name="projectRating" id="projectRating">
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5" selected>5</option>
						</select>
					</div>
					<div class="margin-bottom-20">
						<textarea name="projectReview" class="form-control input-sm quote_textarea"></textarea>
					</div>
					<a class="btn btn-lg btn-success margin-horizontal-5 projectReviewSave" data-project='<?php echo $projectId; ?>'>Save</a>
				</div>
		<?php endif; ?>
		</div>
	</div>
<?php endif; ?>