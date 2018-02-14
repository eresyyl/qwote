<?php
/*
Template Name: trades
*/
?>
<?php 
if(is_contractor() ) {
        wp_redirect(home_url() . "/dash");
        die;
}
?>
<?php get_header(); 
$goto_template = $_GET['type']; if(!empty($goto_template) && $goto_template != '')  {
        echo "<style>#step1{display:none;}</style>";
}
?>
<style>
.front-bg {
  background:url(assets/images/stairs.jpg) no-repeat center;
  background-size: cover;
}
</style>
	<style>
	
	/*-------------------------------*/
/*      Code snippet by          */
/*      @maridlcrmn              */
/*-------------------------------*/


section {
    padding-top: 100px;
    padding-bottom: 100px;
}

.quote {
    color: rgba(0,0,0,.1);
    text-align: center;
    margin-bottom: 30px;
}

/*-------------------------------*/
/*    Carousel Fade Transition   */
/*-------------------------------*/

#fade-quote-carousel.carousel {
  padding-bottom: 60px;
}
#fade-quote-carousel.carousel .carousel-inner .item {
  opacity: 0;
  -webkit-transition-property: opacity;
      -ms-transition-property: opacity;
          transition-property: opacity;
}
#fade-quote-carousel.carousel .carousel-inner .active {
  opacity: 1;
  -webkit-transition-property: opacity;
      -ms-transition-property: opacity;
          transition-property: opacity;
}
#fade-quote-carousel.carousel .carousel-indicators {
  bottom: 10px;
}
#fade-quote-carousel.carousel .carousel-indicators > li {
  background-color: #e84a64;
  border: none;
}
#fade-quote-carousel blockquote {
    text-align: center;
    border: none;
}
#fade-quote-carousel .profile-circle {
    width: 100px;
    height: 100px;
    margin: 0 auto;
    border-radius: 100px;
}
</style>
<!-- Page -->
		

<div class="page">
        <div class="page-content padding-30 container-fluid">
 
                <div class="panel" id="step1">
                        <div class="panel-body">
                                
                                
                                
			  
								<div class="pearls row">
                <div class="pearl current col-xs-4" aria-expanded="true">
                  <div class="pearl-icon"><i class="icon wb-user" aria-hidden="true"></i></div>
                  <span class="pearl-title">Choose Project(s)</span>
                </div>
                <div class="pearl col-xs-4 current" aria-expanded="true">
                  <div class="pearl-icon"><i class="icon wb-payment" aria-hidden="true"></i></div>
                  <span class="pearl-title">Fill Out Details</span>
                </div>
                <div class="pearl col-xs-4 current" aria-expanded="true">
                  <div class="pearl-icon"><i class="icon wb-check" aria-hidden="true"></i></div>
                  <span class="pearl-title">Get Your Price</span>
                </div>
              </div>
                                <form id="quote_form_1">
		  	
                                        <div class="col-md-10 col-md-offset-1">
			
                                                <div class="col-md-6 example-wrap margin-sm-0">
                                                        <h4 class="example-title text-center">City</h4>
                                                        <div class="form-group">
                                                                <select name="city" class="form-control bg-blue-300">
                                                                        <?php while(has_sub_field('cities')) : ?>
                                                                                <option><?php the_sub_field('city'); ?></option>
                                                                        <?php endwhile; ?>
                                                                </select>
                                                        </div>
                                                </div>
                                            <div class="col-md-6 example-wrap margin-sm-0">
                                                        <h4 class="example-title text-center">Timeframe</h4>
                                                        <div class="form-group">
                                                                <select name="timeframe" class="form-control bg-blue-300">
                                                                        <?php while(has_sub_field('timeframe')) : ?>
                                                                                <option><?php the_sub_field('timeframe'); ?></option>
                                                                        <?php endwhile; ?>
                                                                </select>
                                                        </div>
                                                </div>                                                
                                              
			  
                                                <div class="row">
				  
                                                       
				
                                                        <div class="col-md-12">
			  		
                                                                <div class="example-wrap margin-vertical-20 text-center ">
                                                                        <h4 class="example-title text-center">Select Individual Trades</h4>
																																	<p>
																																		An Individual trade quotation will include everything associated with the trade. 
																																		If you select painting it will quote the paint supply to the cleanup. 
																																	</p>
                                                                        <div class="row text-center">
                                                                                <?php 
                                                                                $by_service_cnt = 0;
                                                                                $by_service_args = array('post_type'=>'template', 'posts_per_page'=>-1, 'meta_key'=>'by_type','meta_value'=>'by_service');
                                                                                $by_service_templates = get_posts($by_service_args);
                                                                                foreach($by_service_templates as $template) :
                                                                                        ?>
					  
                                                                                        <label class="styled ">
                                                                                                <input class='chr' type="checkbox" name="quote_template[]" value="<?php echo $template->ID; ?>" id="<?php echo $template->ID; ?>">
                                                                                                <img src="<?php the_field('template_image',$template->ID); ?>">
                                                                                                <span><?php echo $template->post_title; ?></span>
                                                                                                <?php $label = get_field('name_of_duplicate',$template->ID); $qnt = get_field('quantity',$template->ID); if($qnt == true) {
                                                                                                        echo "<input class='qnt' type='number' name='" . $template->ID . "' id='" . $template->ID . "' min='1' step='1' value='1'>";
                                                                                                        echo "<span class='qnt_title label label-default'>" . $label . ":</span>";
                                                                                                } ?>
                                                                                        </label>
						  
                                                                                        <?php 
                                                                                        $by_service_cnt++;
                                                                                endforeach;
                                                                                if($by_service_cnt == 0) {
                                                                                        echo "<p>Sorry, there are no templates here yet.</p>";
                                                                                }
                                                                                ?>
                                                                        </div>
                                                                </div>
				  
                                                        </div>
			
                                                </div>
			  
                                                <div class="example-wrap margin-sm-0 text-center">
                                                        <a class="btn btn-info btn-round btn-lg margin-top-40 goto_2_step">Next Step</a>
                                                </div>
			<h3 class="text-center">
		OR
	</h3>
                                        </div>
			
                                </form>
			
                        </div>
                </div>
	  
                <div id="step1_response"></div>
	  
        </div>
</div>
<!-- End Page-->

<div class="container">
		<div class="row">
																											<?php echo do_shortcode('[contact-form-7 id="880" title="Contact form 1"]'); ?>

		</div>
	</div>

<section id="carousel" class="bg-white">    				
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
                <div class="quote"><i class="fa fa-quote-left fa-4x"></i></div>
				<div class="carousel slide" id="fade-quote-carousel" data-ride="carousel" data-interval="3000">
				  <!-- Carousel indicators -->
                  <ol class="carousel-indicators">
				    <li data-target="#fade-quote-carousel" data-slide-to="0" class="active"></li>
				    <li data-target="#fade-quote-carousel" data-slide-to="1"></li>
				    <li data-target="#fade-quote-carousel" data-slide-to="2"></li>
                    <li data-target="#fade-quote-carousel" data-slide-to="3"></li>
				  </ol>
				  <!-- Carousel items -->
				  <div class="carousel-inner">
				    <div class="item">
				    	<blockquote>
                <p>
	               We've renovated before and never had an experience like Renovar offers, from the instant quote to the their helpful project Leaders I had my bathroom done earlier than expected. Will definitely recommend.
								</p>			
							<p>
								<b>Steven Cooke</b> - Northcote
								</p>
							</blockquote>	
				    </div>
				    <div class="item">
				    	<blockquote>
                <p>
	               I found the whole process to be so simple, there wasnt any mucking around with various painting quotes I recieved my price and they started 2 days later. They even helped with moving furniture.
								</p>				  
							<p>
								<b>Sally Mckenzie</b> - Pakuranga
								</p>
							</blockquote>
				    </div>
				    <div class="active item">
				    	<blockquote>
                 <p>
	                I was just looking for a quote for my kitchen, I waited and waited (as most of us do) I tried the Renovar platform. I must admit I was sceptical at first but their pricing was on the money. Job done well without a hitch. Very happy.
								</p>				    	
							<p>
								<b>Peter Gibbs</b> - Orakei
								</p>
							</blockquote>
				    </div>
                    <div class="item">
    			    	<blockquote>
                  <p>
                I was so stressed when our laundry flooded, working full time meant I had to come home to meet tradesmen. Luckily Renovar managed the whole process over the phone. Laundry looks great. 
									</p>				    	
							<p>
								<b>Lucy McNaught</b> - Belmont
								</p>				    	</blockquote>
				    </div>
        
				  </div>
				</div>
			</div>							
		</div>
	</div>
</section>

<?php get_footer(); ?>