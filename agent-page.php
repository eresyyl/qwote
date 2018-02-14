<?php
/*
Template Name: business
*/
?>

<?php get_template_part('header2'); ?>

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

<div class="animsition" style="animation-duration: 800ms; opacity: 1;">
    <section class="section bg-cyan-600">
        <div class="container">
				
					                    <div class="row margin-bottom-100">
<div class="text-center white margin-top-100 margin-xs-0">
        <div class="font-size-50 margin-bottom-30">Become a Qwoter</div>
        <p class="lead wow fadeInDown">Offer our realtime quoting to your customers and streamline your sales</p>
      
					<div class="col-md-6 col-md-offset-3">
     <div class="padding-50">
<a class="inline btn btn-raised btn-primary bg-cyan-500 font-size-30" href="#get_started">GET STARTED</a>
			
						</div>       </div>
	
                </div>
					
      </div>
    </div>
    
  </section>

	
<div class="padding-50">

				 <div class="row">
					 <div class="col-md-12 blue-grey-800">
						 <div class="font-size-30 text-center">
							 Why Qwote?
						 </div>
						 <div class="col-md-4">
							 <div class="padding-35 text-center">
                  <i class="icon ti-pencil-alt" aria-hidden="true" style="font-size: 64px;"></i>
								 <div class="font-size-30">
                      Instant Quotes
                    </div>
								 <div class="font-size-20">
									  Accurate, true price quotes in just 2 minutes
								 </div>
                  </div>
						 </div>
						  <div class="col-md-4">
							 <div class="padding-35 text-center">
                  <i class="icon ti-medall" aria-hidden="true" style="font-size: 64px;"></i>
								 <div class="font-size-30">
                      20+ Trades
                    </div>
								  <div class="font-size-20">
										Choose from 20+ different trade quotes
         								 </div>
                  </div>
						 </div>
						  <div class="col-md-4">
							 <div class="padding-35 text-center">
                  <i class="icon ti-user" aria-hidden="true" style="font-size: 64px;"></i>
								 <div class="font-size-30">
                      Industry Verified
                    </div>
								  <div class="font-size-20">
                     True pricing based on industry hourly and area rates
								 </div>
                  </div>
						 </div>
					 </div>
				 </div>
</div>

			<section class="bg-white">
			<div class="text-center margin-20 font-size-30 blue-grey-700">
					Features
				</div>
				<div class="row no-space">
				<div class="col-md-6">
									  <div class="text-center bg-cyan-600 white padding-30 height-400">
                 	<div class="font-size-30 white">
								Instant Quoting
									<ul class="font-size-20 text-left">
									<li>Real industry quote data</li>
									<li>Transperant Pricing & Rates</li>
									<li>2min quote generator</li>
									<li>Profit Margin control</li>
									<li>Fine grained options</li>
									<li>100s of quote variatents</li>
									<li>Instant email and live quote</li>
									<li>Automatice PDF quote</li>
									<li>Track quote progress</li>
									<li>Assign quote to team members</li>
								</ul>
						  	</div> 
								
								   
                  </div>
				</div>
	
						<div class="col-md-6">
							<div class="vertical-align">
								 	<div class="carousel slide" id="exampleCarouselCaptions" data-ride="carousel">
                    <ol class="carousel-indicators carousel-indicators-fillin">
                      <li class="" data-slide-to="0" data-target="#exampleCarouselCaptions"></li>
                      <li class="" data-slide-to="1" data-target="#exampleCarouselCaptions"></li>
                      <li class="active" data-slide-to="2" data-target="#exampleCarouselCaptions"></li>
                    </ol>
                    <div class="carousel-inner" style="max-height: 400px" role="listbox">
                      <div class="item">
                        <img class="width-full" src="<?php bloginfo('template_url'); ?>/assets/images/slide1.png" alt="...">
                      </div>
                      <div class="item active left">
                        <img class="width-full" src="<?php bloginfo('template_url'); ?>/assets/images/slide2.png" alt="...">
                      </div>
                      <div class="item next left">
                        <img class="width-full" src="<?php bloginfo('template_url'); ?>/assets/images/slide4.png" alt="...">
                      </div>
                    </div>
                    <a class="left carousel-control" href="#exampleCarouselCaptions" role="button" data-slide="prev">
                      <span class="icon wb-chevron-left" aria-hidden="true"></span>
                      <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#exampleCarouselCaptions" role="button" data-slide="next">
                      <span class="icon wb-chevron-right" aria-hidden="true"></span>
                      <span class="sr-only">Next</span>
                    </a>
                  </div>
		
							
							</div>
							
							
							</div>
							</div>
					<div class="row no-space">
							<div class="col-md-6">
							<div class="vertical-align">
								 	<div class="carousel slide" id="exampleCarouselCaptions2" data-ride="carousel">
                    <ol class="carousel-indicators carousel-indicators-fillin">
                      <li class="" data-slide-to="0" data-target="#exampleCarouselCaptions2"></li>
                      <li class="" data-slide-to="1" data-target="#exampleCarouselCaptions2"></li>
                      <li class="active" data-slide-to="2" data-target="#exampleCarouselCaptions2"></li>
                    </ol>
                    <div class="carousel-inner" style="max-height: 400px" role="listbox">
                      <div class="item">
                        <img class="width-full" src="<?php bloginfo('template_url'); ?>/assets/images/slide5.png" alt="...">
                      </div>
                      <div class="item active left">
                        <img class="width-full" src="<?php bloginfo('template_url'); ?>/assets/images/slide6.png" alt="...">
                      </div>
                      <div class="item next left">
                        <img class="width-full" src="<?php bloginfo('template_url'); ?>/assets/images/slide7.png" alt="...">
                      </div>
                    </div>
                    <a class="left carousel-control" href="#exampleCarouselCaptions2" role="button" data-slide="prev">
                      <span class="icon wb-chevron-left" aria-hidden="true"></span>
                      <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#exampleCarouselCaptions2" role="button" data-slide="next">
                      <span class="icon wb-chevron-right" aria-hidden="true"></span>
                      <span class="sr-only">Next</span>
                    </a>
                  </div>
		
							
							</div>
							
							
							</div>
				<div class="col-md-6">
									  <div class="text-center bg-cyan-600 white padding-30 height-400">
                 	<div class="font-size-30 white">
								Powerful Dashboard
									<ul class="font-size-20 text-left">
									<li>Live data on all quotes</li>
									<li>Add notes to clients and projects</li>
									<li>Full contact manager</li>
									<li>CRM</li>
									<li>Manage rates</li>
									<li>Track success rates</li>
								</ul>
						  	</div> 
								
								   
                  </div>
				</div>
	
					
							</div>
					<div class="row no-space">
				<div class="col-md-6">
									  <div class="text-center bg-cyan-600 white padding-30 height-400">
                 	<div class="font-size-30 white">
								Project Tools
									<ul class="font-size-20 text-left">
									<li>Instant Messaging</li>
									<li>Combine Quotes</li>
									<li>Notifications</li>
									<li>Refine Quote once live</li>
									<li>Track progress</li>
									<li>Add Scope</li>
								</ul>
						  	</div> 
								
								   
                  </div>
				</div>
	
						<div class="col-md-6">
							<div class="vertical-align">
								 	<div class="carousel slide" id="exampleCarouselCaptions3" data-ride="carousel">
                    <ol class="carousel-indicators carousel-indicators-fillin">
                      <li class="" data-slide-to="0" data-target="#exampleCarouselCaptions3"></li>
                      <li class="" data-slide-to="1" data-target="#exampleCarouselCaptions3"></li>
                      <li class="active" data-slide-to="2" data-target="#exampleCarouselCaptions"></li>
                    </ol>
                    <div class="carousel-inner" style="max-height: 400px" role="listbox">
                      <div class="item">
                        <img class="width-full" src="<?php bloginfo('template_url'); ?>/assets/images/slide8.png" alt="...">
                      </div>
                      <div class="item active left">
                        <img class="width-full" src="<?php bloginfo('template_url'); ?>/assets/images/slide9.png" alt="...">
                      </div>
                      <div class="item next left">
                        <img class="width-full" src="<?php bloginfo('template_url'); ?>/assets/images/slide10.png" alt="...">
                      </div>
                    </div>
                    <a class="left carousel-control" href="#exampleCarouselCaptions3" role="button" data-slide="prev">
                      <span class="icon wb-chevron-left" aria-hidden="true"></span>
                      <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#exampleCarouselCaptions3" role="button" data-slide="next">
                      <span class="icon wb-chevron-right" aria-hidden="true"></span>
                      <span class="sr-only">Next</span>
                    </a>
                  </div>
		
							
							</div>
							
							
							</div>
							</div>
				
			
	    </section>
	
	<section>
			<div id="get_started" class="text-center margin-20 font-size-30 blue-grey-700">
					Pricing
				</div>
		<div class="container">
	<div class="pricing-table">
                <div class="pricing-column-two">
                  <div class="pricing-header">
                    <div class="pricing-price">
                      <span class="pricing-currency">$</span>
                      <span class="pricing-amount"><small>from</small>299.00</span>
                      <span class="pricing-period">/ mo</span>
                      <span class="pricing-period">SETUP - POA</span>
                    </div>
                    <div class="pricing-title">Qwoter Premium</div>
                  </div>
                  <ul class="pricing-features">
                    <li>
                      <strong>Unlimited</strong> quotes</li>
                    <li>
                      <strong>Full</strong>setup of quote generators</li>
                    <li>
                      <strong>Full featured</strong> CRM</li>
                    <li>
                      <strong>Instant</strong> Messaging</li>
                    <li>
                      <strong>Unlimited</strong> Items and descriptions</li>
										  <li>
                      <strong>Ongoing</strong> support</li>
                  </ul>
                  <div class="pricing-footer">
                    <a class="btn btn-primary btn-outline" href="/buy" role="button"><i class="icon wb-arrow-right font-size-16 margin-right-15" aria-hidden="true"></i>Buy</a>
                  </div>
                </div>
              </div>
				
		</div>
	</section>  
	
		
	
		<section class="section section-feature text-center" id="services" data-anchor="services">
			<div class="container">
				        <div class="row feature-group">
      
											<div class="font-size-50 margin-bottom-30 blue-grey-800">
Available Quotes 
									</div>
						        <p class="lead wow fadeInDown">We've taken the hassle out of finding out how much you should pay for that next home project.
  </p>
									
						
									
									
                <div class="container">

									
						                     <?php include('quote-templates-v2/views/step_1_property1.php'); ?>

									
					 
</div>
									
		
									
									<div class="vertical-align text-center blue-grey-700 padding-30"> 
									<div class="font-size-40">
										And plenty more to come......
									</div>
																		<div class="vertical-align-middle text-center font-size-20">
We're always updating our pricing and adding new options and forms, if its not there feel free to let us know what you'd like to see here next.
										</div>
									</div>
				</section>
   
			<div class="row no-space">
																		
											 <div class="col-md-6">
                  <div class="vertical-align text-center bg-cyan-600 white padding-30 height-400">
                    <div class="vertical-align-middle font-size-60">
                       <i class="icon pe-gleam" aria-hidden="true" style="font-size: 120px;"></i><br/>
                    </div>
                  </div>
                </div>
											
                <div class="col-md-6">
                <div class="vertical-align text-center bg-grey-200 blue-grey-700 padding-30"> 
									<div class="font-size-40">
										BECOME A QUOTER
									</div>
									<div class="vertical-align-middle font-size-20">
                      Get a company membership to take advantage of all our features. 
										<ul class="text-left">
											<div class="font-size-20 blue-grey-700">
												We work with:
											</div>
											<li>Painters & Decorators</li>
											<li>Renovators & Builders</li>
											<li>Tilers and Floorers</li>
											<li>Finance companies</li>
											<li>Property Managers</li>
										</ul>
				</div>
																					<a class="btn btn-lg btn-raised btn-primary" href="/setup">GET STARTED</a>

									</div>
												</div>
								
								
												
										
				

              
              </div>
															
			
	
  <!-- Footer -->
  <div id="contact" class="footer bg-blue-grey-800">
    <div class="footer-detail">
     <div class="container">
                <div class="row white padding-30">
                    <div class="col-md-6">
											<div class="col-md-6">
											<div class="font-size-20 font-weight-200 margin-bottom-30 white">HELP</div>
                     <ul class="nav">
                           <li><a href="/terms" class="white">Terms & Conditions</a></li> 
                           <li><a href="#contact" class="white">Contact</a></li> 
											     <li><a href="/partners" class="white">Become a Qwoter</a></li> 
											     <li><a href="/finance" class="white">Qwote for financial insitutions</a></li> 
											     <li><a href="/partners" class="white">Qwote for your business</a></li> 

                           </ul>      
											</div>
											<div class="col-md-6">
											<div class="font-size-20 font-weight-200 margin-bottom-30 white">ABOUT</div>
                            <ul class="nav">
                           <li><a href="#services" class="white">Why we did it?</a></li> 
                           <li><a href="#how-it-works" class="white">How it Works</a></li> 
                           <li><a href="#services" class="white">Quotes</a></li> 
													  <li><a href="/sign-in" class="white">Sign up</a></li> 
                           <li><a href="/sign-in" class="white">Login</a></li> 
                           </ul>      
                    </div>
									</div>
									
                    <div class="col-md-6 white">
											        <div class="font-size-30 margin-bottom-30 white">QUESTIONS</div>

												<?php echo do_shortcode('[contact-form-7 id="10041" title="Front-contact"]'); ?>
                            
											</div>
                </div>
			 <hr/>
			 <div class="row">
				 <div class="col-md-6">
					   <a href="<?php bloginfo('url'); ?>">
            <img class="navbar-brand-logo" src="<?php bloginfo('template_url'); ?>/assets/images/qwote.png" title="Paynt">
          </a>
				 </div>
				  <div class="col-md-6">
					 <div class="font-size-30 white">
						ABOUT US
						</div>
						<small class="white">
				      Qwote is the easiest way to get a quote for any type of home project, we use real industry data and offer a fully transperant quote in just 2 minutes. All quotes use verified hourly and area based rates and if you like the price we will put you in contact with a service provider partner. 
						</p>
				 </div>
			 </div>
            </div>
    </div>
    
  
  </div>
<footer class="footer bg-blue-grey-800">
    <div class="container white padding-10">
     <div class="inline">
			 <p class="text-left">Copyright © 2017. All Rights Reserved.</p> 
			</div> 
    </div>
  </footer>
  <!-- Footer -->
<?php get_footer(); ?>