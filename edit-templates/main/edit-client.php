<?php 
$quote_id = $_GET['quote_id'];
$quote_templates = get_field('templates',$quote_id);
$quote_data = get_field('quote_array',$quote_id);
$quote_data = json_decode($quote_data, true);
//var_dump($quote_data);
?>
<?php get_header(); ?>
  
  <div class="page animsition">
	  
	<?php get_template_part('projects-templates/sidebars/sidebar','client'); ?>  
	  
	<div class="page-main"> 
    <div class="page-content">
      
	  <?php 
		$city = get_field('quote_city',$quote_id);
		$templates_title = '';
		foreach($quote_templates as $t) {
			$templates_title = $templates_title . " " . get_the_title($t) . ". ";
		}
	  ?>
	  <div class="page-header text-center">
		  <h1 class="page-title">Scope: <?php echo $templates_title; ?> City: <?php echo $city; ?></h1>
		  <p class="page-description">
			  Sorry! This function is on Development stage!
		  </p>
	  </div>
	  
    </div>
	</div>
  </div>

<?php get_footer(); ?>