<?php
/*
Template Name: landing office
*/
?>

<?php get_template_part('header2'); ?>
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

<div class="animsition" style="animation-duration: 800ms; opacity: 1;">
    <div class="page-header margin-bottom-30">
      <div class="text-center blue-grey-800 margin-top-50 margin-xs-0">
        <div class="font-size-50 margin-bottom-30 blue-grey-800">Office & Strata Painting, The Easy Way!</div>
        <p class="lead wow fadeInDown">Paynt takes the pain out of painting with instant quotes, hand picked expert painters and our <b>100% SATISFACTION GUARANTEE</b>  </p>
        <div class="container">
				
					<div class="col-md-8 col-md-offset-2 col-xs-12">

                    <div class="row">

                            <div class="margin-20 text-center">
                              <?php include('quote-templates-v2/views/step_1_office.php'); ?>
                            </div>

            
                    </div>

                </div>
      </div>
    </div>
    
  </div>

  		 <div class="bg-red-700 padding-50">

				 <div class="row">
					 <div class="col-md-12">
						 <div class="col-md-4">
							 <div class="padding-35 text-center white">
                  <i class="icon ti-pencil-alt" aria-hidden="true" style="font-size: 64px;"></i>
								 <div class="font-size-30 white">
                      Instant Quotes
                    </div>
								 <div class="font-size-20 white">
									  Accurate, fixed price quotes in just 2 minutes
								 </div>
                  </div>
						 </div>
						  <div class="col-md-4">
							 <div class="padding-35 text-center white">
                  <i class="icon ti-medall" aria-hidden="true" style="font-size: 64px;"></i>
								 <div class="font-size-30 white">
                      Expert Painters
                    </div>
								  <div class="font-size-20 white">
										Handpicked, Licensed and Registered Painters
         								 </div>
                  </div>
						 </div>
						  <div class="col-md-4">
							 <div class="padding-35 text-center white">
                  <i class="icon ti-user" aria-hidden="true" style="font-size: 64px;"></i>
								 <div class="font-size-30 white">
                      Dedicated Job Managers
                    </div>
								  <div class="font-size-20 white">
                     One point of contact from setup to cleanup
								 </div>
                  </div>
						 </div>
					 </div>
				 </div>
</div>
 
    
		 <div class="bg-white padding-top-50 padding-bottom-50" id="how-it-works" data-anchor="how-it-works">
			 
			 
          <div class="container text-center">
            <div class="row">
							<div class="font-size-50 blue-grey-800 margin-bottom-30">
								Fresh walls in 3 easy steps
							</div>
						
							 <div class="col-md-6">
								 
							</div>   
						<div class="col-md-8 col-md-offset-2 col-xs-12">
              <div class="widget widget-shadow widget-completed-options">
                <div class="widget-content height-300 padding-30">
                  <div class="row">
											<i class="icon fa-calculator text-danger" aria-hidden="true" style="font-size: 42px;"></i>
                      <div class="counter blue-grey-700">
                        <div class="counter-number font-size-40 margin-top-10">
                          1
                        </div>
												<div class="counter-label font-size-30 margin-top-10">See Your Price.</div>
												<p class="description">Fill out the quote generator and get a price in 60 seconds, We'll then call you to confirm any details. Our pricing is flat rate and extremely accurate.</p>
                      </div>
                  </div>
                </div>
              </div>
																									<i class="icon fa-arrow-down black" aria-hidden="true" style="font-size: 22px;"></i>


            </div>

						<div class="col-md-8 col-md-offset-2 col-xs-12">
              <div class="widget widget-shadow widget-completed-options">
                <div class="widget-content height-300 padding-30">
                  <div class="row">
											<i class="icon fa-rocket text-danger" aria-hidden="true" style="font-size: 42px;"></i>
                      <div class="counter blue-grey-700">
                        <div class="counter-number font-size-40 margin-top-10">
                          2
                        </div>
												<div class="counter-label font-size-30 margin-top-10">Get Started.</div>
												<p class="description">We assign the project to a local acreditted painting contractor, with the help of our job managers, they'll look after you from quote to completion. </p>
                      </div>
                  </div>
                </div>
              </div>
																		<i class="icon fa-arrow-down black" aria-hidden="true" style="font-size: 22px;"></i>


            </div>
							
						<div class="col-md-8 col-md-offset-2 col-xs-12">
              <div class="widget widget-shadow widget-completed-options">
                <div class="widget-content height-300 padding-30">
                  <div class="row">
											<i class="icon fa-smile-o text-danger" aria-hidden="true" style="font-size: 42px;"></i>
                      <div class="counter blue-grey-700">
                        <div class="counter-number font-size-40 margin-top-10">
                          3
                        </div>
												<div class="counter-label font-size-30 margin-top-10">Enjoy</div>
												<p class="description">Enjoy a truely hassle free painting experience. Step into your newly painted office with our 100% satisfaction guarantee.</p>
                      </div>
                  </div>
                </div>
              </div>
            </div>
           
						</div>
						
            </div>
          </div>
       </div>
		
	<section class="bg-white" id="about" data-anchor="about">
		<div class="container">
			
			<div class="panel">
			<div class="panel-body">
				<div class="panel-heading">
					<div class="font-size-50 margin-bottom-30 blue-grey-800">
          The easiest path to fresh walls
					</div>
				</div>
				<b>	We solved a glaring problem most people know too well: completing a home or office painting project can be a painful and confusing process.
				</b><br/>
								<p>Paynt is the easiest way to get your home or office painted. Just answer our simple questions, and in under 2 minutes, you’ll have an accurate quote. If you like the price our paint crews can start with just 24 hours notice. We assign you a dedicated job manager to help you work through all of the details. Painting your home or office has never been this fun. 
			</p>
				</div>
		
						</div>

			</div>
		</section>
    
	<div class="bg-red-700 padding-top-50 padding-bottom-50" id="why" data-anchor="why">
			 
			 
          <div class="container white">
            <div class="row">
							<div class="col-md-6">
								<div class="font-size-50 margin-bottom-30">
							 Why use Paynt?
							</div>
								
									<div class="margin-20 font-size-20">
								<i class="icon fa-calculator" aria-hidden="true"></i>
										 Fast, data-driven, transparent online quoting and secure booking
								</div>
									<div class="margin-20 font-size-20">
								<i class="icon fa-group"  aria-hidden="true"></i>
                     Licensed and insured painting crews, certified for quality and professionalism									
								</div>
									<div class="margin-20 font-size-20">
								<i class="icon fa-heart-o"  aria-hidden="true"></i>
										High quality Dulux paints in over 3,000 colors
								</div>
									<div class="margin-20 font-size-20">
								<i class="icon fa-paint-brush"  aria-hidden="true"></i>
										Complete setup, prep, and clean up
										
								</div>
									<div class="margin-20 font-size-20">
								<i class="icon fa-street-view"  aria-hidden="true"></i>
										Dedicated project managers for a single point of contact and coordination
								</div>
									<div class="margin-20 font-size-20">
								<i class="icon fa-calendar" aria-hidden="true"></i>
										Flexible start dates and fast turn around times for your convenience
								</div>
							</div>
						
								<div class="col-md-6 text-center">
								<div class="white">
								<i class="icon ti-paint-roller margin-top-20" style="font-size: 150px"  aria-hidden="true"></i>
										<div class="panel margin-top-50">
			<div class="panel-body">
				<div class="panel-heading">
					<div class="font-size-20 margin-bottom-30 blue-grey-800">
				100% Satisfaction Guaranteed
					</div>
				</div>
				<p class="black">
We take your safety and peace of mind seriously. That's why all of our painters are background checked, licensed and insured. We also back all of our work with a 100% satisfaction guarantee, which means we're not done, until you're satisfied.	</p>
				</div>
		
						</div>

							</div>	
							</div>
            </div>
          </div>
       </div>

 <section class="section bg-grey-100 section-feature section-small">
	<div class="container">
		<div class="col-md-8">
			<div class="font-size-50 margin-bottom-30 blue-grey-800">
								5 Year Painter's Workmanship Warranty
							</div>
						 <p class="lead wow text-left fadeInDown">Our Expert Painters can provide your project with their own professional 5 year warranty.</p>
		</div>
		<div class="col-md-4">
			<div class="widget">
            <div class="widget-content padding-30 bg-red-700">
              <div class="widget-watermark darker font-size-50 margin-15"><i class="icon fa-thumbs-o-up"  aria-hidden="true"></i></div>
              <div class="counter counter-md counter-inverse text-left">
                <div class="counter-number-group">
                  <span class="font-size-50 counter-number">5</span>
                </div>
                <div class="counter-label text-capitalize">year warranty</div>
              </div>
            </div>
          </div>
		</div>
		
	 </div>
	

</section>

		
		<section class="section section-feature text-center" id="services" data-anchor="services">
			<div class="container">
				        <div class="row feature-group">
      
											<div class="font-size-50 margin-bottom-30 blue-grey-800">
								Our Services
							</div>
						 <p class="lead wow fadeInDown">We cover all residential/commercial painting services</p>
									
						<div class="row">
							<div class="col-md-3">
							<i class="icon ti-ruler text-danger" style="font-size: 50px"  aria-hidden="true"></i>
              <h4>
								Full Repaints
								</h4>
							</div>		
							<div class="col-md-3">
							<i class="ti-layout text-danger" style="font-size: 50px"  aria-hidden="true"></i>
              <h4>
								Office Painting
								</h4>
							</div>		
							<div class="col-md-3">
							<i class="icon ti-home text-danger" style="font-size: 50px"  aria-hidden="true"></i>
              <h4>
								Apartment Painting
								</h4>
							</div>
							<div class="col-md-3">
							<i class="icon ti-map text-danger" style="font-size: 50px"  aria-hidden="true"></i>
              <h4>
               Specialised Finishes
								</h4>
							</div>
									</div>
													<div class="row margin-top-30">

							<div class="col-md-3">
							<i class="icon ti-layout-placeholder text-danger" style="font-size: 50px"  aria-hidden="true"></i>
              <h4>
								Roof Painting
								</h4>
							</div>
							<div class="col-md-3">
							<i class="icon ti-cut text-danger" style="font-size: 50px"  aria-hidden="true"></i>
              <h4>
								Wallpaper Installation & Removal
								</h4>
							</div>
							<div class="col-md-3">
							<i class="icon ti-package text-danger" style="font-size: 50px"  aria-hidden="true"></i>
              <h4>
								Cabinetry
								</h4>
							</div>
							<div class="col-md-3">
							<i class="icon ti-palette text-danger" style="font-size: 50px"  aria-hidden="true"></i>
              <h4>
								Colour consultations
								</h4>
							</div>
									</div>			

								
						
</div>
					</div>
				</section>
			

<!-- End Hero -->
 <section id="add_quote" class="section bg-grey-100 section-feature section-small text-center">
	 <div class="font-size-50 margin-bottom-30 blue-grey-800">
								Get a Price
							</div>
						 <p class="lead wow fadeInDown">In just 60s you'll know what you'll pay and when we can start</p>
	 <div class="container">
		 	<div class="widget widget-shadow padding-30">
							<div class="pearls row">
                    <div class="pearl col-xs-3 current" aria-expanded="true">
                      <div class="pearl-icon"><i class="icon wb-user" aria-hidden="true"></i></div>
                      <span class="pearl-title">Choose Quote</span>
                  </div>
                  <div class="pearl col-xs-3" aria-expanded="true">
                      <div class="pearl-icon"><i class="icon wb-payment" aria-hidden="true"></i></div>
                      <span class="pearl-title">Describe Space</span>
                  </div>
                  <div class="pearl col-xs-3" aria-expanded="true">
                      <div class="pearl-icon"><i class="icon wb-user" aria-hidden="true"></i></div>
                      <span class="pearl-title">Final Details</span>
                  </div>
                  <div class="pearl col-xs-3" aria-expanded="true">
                      <div class="pearl-icon"><i class="icon wb-check" aria-hidden="true"></i></div>
                      <span class="pearl-title">Instant Quote</span>
                  </div>
              </div>

					
					</div>
				
	 </div>
        <div class="row feature-group">
				
        <div id="step1">
					
					<div class="text-center col-md-6 col-md-offset-3 col-xs-12">

                    <div class="row">


                            <div class="margin-20 text-center ">
                              <?php include('quote-templates-v2/views/step_1_office.php'); ?>
                            </div>
<div class="font-size-20 margin-bottom-30 blue-grey-700">
	OR</div>
	<div class="font-size-20 margin-bottom-30 blue-grey-700">Call us and we'll do it over the phone</div>
											
<a href="tel: +61284171038" class="btn btn-primary btn-lg">02 8417 1038</a>
                    </div>

                </div>
				</div>
</div>
				</section>

<!-- Question -->
    <section id="faq" class="section section-question bg-white">
      <div class="container">
        <!-- FAQ 1 -->
				<div class="font-size-50 margin-bottom-30 blue-grey-800">
								F.A.Q
							</div>
        <div class="question-group" id="faq1">
          <h3>Popular Questions</h3>
          <div role="tablist" aria-multiselectable="true" id="accordion2" class="panel-group panel-group-simple panel-group-continuous">

            <!-- Question 1 -->
            <div class="panel">
              <div role="tab" id="question-1" class="panel-heading">
                <a data-parent="#accordion2" href="#answer-1" data-toggle="collapse" aria-expanded="false" aria-controls="answer-1" class="panel-title">
                What’s included in every job?
              </a>
              </div>
              <div role="tabpanel" aria-labelledby="question-1" id="answer-1" class="panel-collapse collapse">
                <div class="panel-body">
                Your final price includes the cost for labor, tax where applicable, management and the materials (if we are supplying it).                </div>
              </div>
            </div>

            <!-- End Question 1 -->

            <!-- Question 2 -->
            <div class="panel">
              <div role="tab" id="question-2" class="panel-heading">
                <a data-parent="#accordion2" href="#answer-2" data-toggle="collapse" aria-expanded="false" aria-controls="answer-2" class="panel-title">
              Do I need to get materials or any supplies?
              </a>
              </div>
              <div role="tabpanel" aria-labelledby="question-2" id="answer-2" class="panel-collapse collapse">
                <div class="panel-body">
              Nope! We will come with all necessary supplies, including ladders. If you purchase material through us, we’ll bring that with us, too.
								</div>
              </div>
            </div>

            <!-- End Question 2 -->

            <!-- Question 3 -->
            <div class="panel">
              <div role="tab" id="question-3" class="panel-heading">
                <a data-parent="#accordion2" href="#answer-3" data-toggle="collapse" aria-expanded="false" aria-controls="answer-3" class="panel-title">
               How do I choose my colours?
              </a>
              </div>
              <div role="tabpanel" aria-labelledby="question-3" id="answer-3" class="panel-collapse collapse">
                <div class="panel-body">
Our contractors will help you choose on the day or you can visit a Dulux paint shop before we start.            </div>
              </div>
            </div>

      
            <!-- End Question 4 -->
          </div>
        </div>
        <!-- End FAQ 1 -->

        <!-- FAQ 2 -->
        <div class="question-group" id="faq2">
          <h3>Trust & Safety</h3>
          <div role="tablist" aria-multiselectable="true" id="accordion" class="panel-group panel-group-simple panel-group-continuous">

            <!-- Question 5 -->
            <div class="panel">
              <div role="tab" id="question-5" class="panel-heading">
                <a data-parent="#accordion" href="#answer-5" data-toggle="collapse" aria-expanded="false" aria-controls="answer-5" class="panel-title">
                Are Paynt's contractors insured?              </a>
              </div>
              <div role="tabpanel" aria-labelledby="question-5" id="answer-5" class="panel-collapse collapse">
                <div class="panel-body">
               Yes, all painting crews have general liability insurance.</div>
              </div>
            </div>

            <!-- End Question 5 -->

            <!-- Question 6 -->
            <div class="panel">
              <div role="tab" id="question-6" class="panel-heading">
                <a data-parent="#accordion" href="#answer-6" data-toggle="collapse" aria-expanded="false" aria-controls="answer-6" class="panel-title">
                Where do you find your tradespeople?								</a>
              </div>
              <div role="tabpanel" aria-labelledby="question-6" id="answer-6" class="panel-collapse collapse">
                <div class="panel-body">
              Each city’s general manager is responsible for adding new painting crews to our platform. Each crew is subcontracted and undergoes a full background check before being onboarded.                </div>
              </div>
            </div>

            <!-- End Question 6 -->

            <!-- Question 7 -->
            <div class="panel">
              <div role="tab" id="question-7" class="panel-heading">
                <a data-parent="#accordion" href="#answer-7" data-toggle="collapse" aria-expanded="false" aria-controls="answer-7" class="panel-title">
               How are crews assigned to jobs?
              </a>
              </div>
              <div role="tabpanel" aria-labelledby="question-7" id="answer-7" class="panel-collapse collapse">
                <div class="panel-body">
              Each city’s general manager assigns crews to jobs based on their availability and area of expertise.                </div>
              </div>
            </div>

						
						<div class="panel">
              <div role="tab" id="question-8" class="panel-heading">
                <a data-parent="#accordion1" href="#answer-8" data-toggle="collapse" aria-expanded="false" aria-controls="answer-8" class="panel-title">
                 What if I’m not totally happy with my paint job?
              </a>
              </div>
              <div role="tabpanel" aria-labelledby="question-8" id="answer-8" class="panel-collapse collapse" style="">
                <div class="panel-body">
             We have a 100% Satisfaction Guarantee. If for any reason you don’t love your project, we will come back and fix it for you free of charge until you are happy. </div>
              </div>
            </div>
            <!-- End Question 7 -->
          </div>
        </div>
        <!-- End FAQ 2 -->

        <!-- FAQ 3 -->
        <div class="question-group" id="faq3">
          <h3>Before we Start</h3>
          <div role="tablist" aria-multiselectable="true" id="accordion1" class="panel-group panel-group-simple panel-group-continuous">

      
            <!-- Question 9 -->
            <div class="panel">
              <div role="tab" id="question-9" class="panel-heading">
                <a data-parent="#accordion1" href="#answer-9" data-toggle="collapse" aria-expanded="false" aria-controls="answer-9" class="panel-title collapsed">
    How does pricing work?
              </a>
              </div>
              <div role="tabpanel" aria-labelledby="question-9" id="answer-9" class="panel-collapse collapse" aria-expanded="false">
                <div class="panel-body">
We’ve used industry standards to determine how long it takes to for each project, and applied a dollar amount per hour. You will no longer need to worry about getting overcharged or scammed - pay for exactly what you are having done.                </div>
              </div>
            </div>

            <!-- End Question 9 -->

            <!-- Question 10 -->
            <div class="panel">
              <div role="tab" id="question-10" class="panel-heading">
                <a data-parent="#accordion1" href="#answer-10" data-toggle="collapse" aria-expanded="false" aria-controls="answer-10" class="panel-title collapsed">
             When can I book my paint job?              </a>
              </div>
              <div role="tabpanel" aria-labelledby="question-10" id="answer-10" class="panel-collapse collapse" aria-expanded="false">
                <div class="panel-body">
               Seven days a week. We have crews available every day, so book according to your schedule.                </div>
              </div>
            </div>

            <!-- End Question 10 -->
						 <!-- Question 10 -->
            <div class="panel">
              <div role="tab" id="question-10" class="panel-heading">
                <a data-parent="#accordion1" href="#answer-11" data-toggle="collapse" aria-expanded="false" aria-controls="answer-11" class="panel-title collapsed">
             Do I need to be home for my paynt job?
            </a>
              </div>
              <div role="tabpanel" aria-labelledby="question-11" id="answer-11" class="panel-collapse collapse" aria-expanded="false">
                <div class="panel-body">
              Nope. Feel free to go about your day, if you please. We are happy for you to leave a key.  </div>
              </div>
            </div>

            <!-- End Question 10 -->
						 <!-- Question 10 -->
            <div class="panel">
              <div role="tab" id="question-10" class="panel-heading">
                <a data-parent="#accordion1" href="#answer-12" data-toggle="collapse" aria-expanded="false" aria-controls="answer-12" class="panel-title collapsed">
             What happens if I need to cancel my job?
    </a>
              </div>
              <div role="tabpanel" aria-labelledby="question-12" id="answer-12" class="panel-collapse collapse" aria-expanded="false">
                <div class="panel-body">
               You can cancel your job anytime up to 5 PM the day prior to your scheduled job with zero fees. If there is a last-minute cancellation on the morning of your scheduled job, you will lose 10% of your deposit. </div>
              </div>
            </div>

            <!-- End Question 10 -->
						 <!-- Question 10 -->
            <div class="panel">
              <div role="tab" id="question-13" class="panel-heading">
                <a data-parent="#accordion1" href="#answer-13" data-toggle="collapse" aria-expanded="false" aria-controls="answer-10" class="panel-title collapsed">
             How far in advance do I need to book?
  </a>
              </div>
              <div role="tabpanel" aria-labelledby="question-13" id="answer-13" class="panel-collapse collapse" aria-expanded="false">
                <div class="panel-body">
               We recommend booking 48 hours in advance to ensure material can be ordered and any insurance documents can be coordinated.           </div>
              </div>
            </div>

            <!-- End Question 10 -->
          </div>
        </div>
        <!-- End FAQ 3 -->
				
				<!-- FAQ 3 -->
        <div class="question-group" id="faq4">
          <h3>Payment</h3>
          <div role="tablist" aria-multiselectable="true" id="accordion1" class="panel-group panel-group-simple panel-group-continuous">

      
            <!-- Question 9 -->
            <div class="panel">
              <div role="tab" id="question-14" class="panel-heading">
                <a data-parent="#accordion1" href="#answer-14" data-toggle="collapse" aria-expanded="false" aria-controls="answer-14" class="panel-title collapsed">
                How do I pay for my project?              </a>
              </div>
              <div role="tabpanel" aria-labelledby="question-14" id="answer-14" class="panel-collapse collapse" aria-expanded="false">
                <div class="panel-body">
              Before you start we will invoice a deposit to secure your start date and allow the contractors to buy material, Then the rest on the day of the job. We hold the funds until you're satisfied and then pay our contractors.             </div>
            </div>

            <!-- End Question 9 -->

           
          </div>
        </div>
        <!-- End FAQ 3 -->
      </div>
    </section>
    <!-- End Question -->

				<section id="carousel" class="bg-grey-200">    				
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
	               We've painted before and never had an experience like Paynt offers, from the instant quote to the their helpful job managers I had my house done earlier than expected. Will definitely recommend.
								</p>			
							<p>
								<b>Steven Cooke</b>
								</p>
							</blockquote>	
				    </div>
				    <div class="item">
				    	<blockquote>
                <p>
	               I found the whole process to be so simple, there wasnt any mucking around with various painting quotes I recieved my price and they started 2 days later. They even helped with moving furniture.
								</p>				  
							<p>
								<b>Sally Mckenzie</b> 
								</p>
							</blockquote>
				    </div>
				    <div class="active item">
				    	<blockquote>
                 <p>
	                I was just looking for a quote for my kitchen, I waited and waited (as most of us do) I tried the Paynt platform. I must admit I was sceptical at first but their pricing was on the money. Job done well without a hitch. Very happy.
								</p>				    	
							<p>
								<b>Peter Gibbs</b>
								</p>
							</blockquote>
				    </div>
                    <div class="item">
    			    	<blockquote>
                  <p>
                I was so stressed when our tenants left our rental house in a mess, working full time meant I had to come home to meet tradesmen. Luckily Paynt managed the whole process over the phone. New Tenats love it. 
									</p>				    	
							<p>
								<b>Lucy McNaught</b>
								</p>				    	</blockquote>
				    </div>
        
				  </div>
				</div>
			</div>							
		</div>
	</div>
</section>
	
			
  <!-- Footer -->
  <div id="contact" class="footer bg-blue-grey-600">
    <div class="footer-detail">
     <div class="container">
                <div class="row white padding-30">
                    <div class="col-md-6">
											<div class="col-md-6">
											<div class="font-size-20 margin-bottom-30 white">HELP</div>
                     <ul class="nav">
                           <li><a href="#faq" class="white">FAQ</a></li> 
                           <li><a href="/terms" class="white">Terms & Conditions</a></li> 
                           <li><a href="/privacy" class="white">Privacy</a></li> 
                           <li><a href="#contact" class="white">Contact</a></li> 
                          
                           </ul>      
											</div>
											<div class="col-md-6">
											<div class="font-size-20 margin-bottom-30 white">ABOUT</div>
                            <ul class="nav">
                           <li><a href="#why" class="white">About</a></li> 
                           <li><a href="#services" class="white">Services</a></li> 
                           <li><a href="/sign-in" class="white">Login</a></li> 
                           <li><a href="/sign-up" class="white">Contractor Signup</a></li> 
                           </ul>      
                    </div>
									</div>
                    <div class="col-md-6 white">
											        <div class="font-size-20 margin-bottom-30 white">CONTACT - 02 8417 1038</div>

												<?php echo do_shortcode('[contact-form-7 id="880" title="Contact form 1"]'); ?>
                            
											</div>
                </div>
            </div>
    </div>
    
  
  </div>
			
<footer class="footer bg-blue-grey-700">
    <div class="container white padding-10">
     <div class="inline">
			 <p class="text-left">Copyright © 2017 Paynt. All Rights Reserved.</p> 
			</div> 
    </div>
  </footer>
  <!-- Footer -->
<?php get_footer(); ?>