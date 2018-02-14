<?php
/*
Template Name: about
*/
?>
<!DOCTYPE html>
<?php get_header(); ?>
  
  
 
 <div class="site-body">
   
	 <!-- Hero -->
  <section class="site-hero bg-blue-500 hero padding-50">
    <div class="container text-center">
      <div class="content">
        <h1 class="white">Time for improved home improvement</h1>
        <p class="lead white">Get your Price in just a Few Clicks.</p>
      </div>
    </div>
  </section>
  <!-- End Hero -->
 
      <!-- Content-6 -->
    <section class="section bg-white padding-50">
      <div class="container">
        <div class="row">
          <div class="col-md-8 col-md-offset-2 col-small-12">
          <?php the_field('content'); ?>
          </div>
        </div>
      </div>
    </section>
    <!-- End Content-6 -->
   
  

  </div>

 <!-- Footer -->
 <?php get_footer(); ?>