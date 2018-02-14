<?php
global $is_single_template;
$is_single_template = true;

$agentId = get_post_field( 'post_author' );
session_start();
session_unset();
get_header(); 
?>

<?php if( current_user_can('administrator') || $agentId == get_current_user_id() ):?>
	<?php acf_form_head(); ?>

	<div class="page animsition">
        <div class="page-content container-fluid">
			<div class="row">
				<div class="col-sm-12">
					
						<h1><?php the_title(); ?></h1>
						<?php acf_form(array(
							'field_groups' => array(2984)
						)); ?>
				</div><!-- .col-sm-12 -->
			</div><!-- .row -->
		</div><!-- .page-content.container-fluid -->
	</div><!-- .page.animsition -->


<?php endif; ?>
<?php get_footer(); ?>