<?php
/*
Template Name: services single
*/
?>
<?php get_header(); ?>
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

 <header class="front-bg">
  <section  class="site-hero bg-blue-600 hero">
    <div class="container verticle-align-middle text-center">
      <div class="content">
        <h1 class="wow white fadeInDown">Get a Free, no obligation instant estimate for your home project</h1>
        <p class="lead black wow fadeInDown">Estimo is the easiest way to improve your home</p>
        <p>
          <a class="btn btn-lg bg-blue-600 btn-default white margin-vertical-15 wow bounceInLeft"
          href="#add_quote">Get Your Price</a>

        </p>
      </div>
    </div>
  </section>
</header>
  <section id="add_quote" class="section bg-white section-feature section-small text-center">
        <div class="row feature-group">
        <div id="step1">
                
                <div class="col-md-10 col-md-offset-1">
<h2 class="black">
	Choose Your Project:
									</h2>
                    <div class="row">

                        <div class="col-md-12">

                            <div class="example-wrap margin-vertical-20 text-center ">

                              <?php include('quote-templates-v2/views/step_1.php'); ?>
                                
                            </div>

                        </div>
            
                    </div>

                </div>
				</div>
</div>
</section>
		
   
  <div class="site-body">
    
		 <div class="padding-top-50 padding-bottom-50" id="how-it-works" data-anchor="how-it-works">
          <div class="container text-center padding-30">
            <div class="row">
							<h2>
								How Does Estimo Work
							</h2><br/>
							<div class="col-lg-4">
								<i class="icon fa-calculator text-danger" aria-hidden="true" style="font-size: 42px;"></i>
								<h2>1</h2>
                <h3 class="title">Get an Instant Quote</h3>
                <p>Get a quote for your home projects in just 60 seconds, answer a few questions about your home and recieve a full quote. Our pricing is flat rate and industry verified.</p>
              </div>      
              <div class="col-lg-4 ">
							<i class="icon fa-rocket text-danger" aria-hidden="true" style="font-size: 42px;"></i>
							 <h2>2</h2>
                <h3 class="title">Get a Final Price</h3>
                <p>We'll contact you for more information, we'll ask for photos and measurements but if everything looks good we'll send you a proposal and you can accept online using our platform.</p>
              </div>                    
              <div class="col-lg-4">
								<i class="icon fa-smile-o text-danger" aria-hidden="true" style="font-size: 42px;"></i>								
								 <h2>3</h2>
                <h3 class="title">Get It Done</h3>
                <p>Once you're happy with the final price we'll assign the project to a partner in our network, we hand pick your contractor based on the project and the profile. </p>
              </div>
            </div>
          </div>
       </div>
		
		<section class="bg-white">
		<div class="container">
			<h1>
				About Estimo
			</h1>
			<p>
We understand how much of a challenge it is for people to navigate through the home improvement process. Whether it be finding out clearly and quickly how much you should spend right through to finding a good contractor to do the work, home improvement was stressful and extremely time consuming.
<br/>We saw an opportunity to alleviate the pain involved when improving your home and it all started with tackling the “how much will it cost” question. After 12 months of testing our pricing algorithms with real market data we launched the platform to the world and welcomed the first accurate instant quoting platform for home improvement projects.
</br/>Our aim is to simplify the home improvement process by providing homeowners with a one of a kind platform for pricing and managing projects along with matching them with a hand picked contractor to do the work.
We want change! We see the struggle homeowners go through and that was enough to find a better way. Estimo is the easiest way to improve your home!
						</p>
			</div>
		</section>
    <section class="bg-red-600 text-center">
<div class="container">
	<h1 class="white">
		100% Satisfaction Gaurantee
	</h1>
	<p class="white">
We take your safety and peace of mind seriously. That's why all of our tradespeople are background checked, licensed and insured. We also back all of our work with a 100% satisfaction guarantee, which means we're not done, until you're satisfied.
	</p>
			</div>
</section>
		<section id="carousel" class="bg-grey">    				
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
	               We've renovated before and never had an experience like Estimo offers, from the instant quote to the their helpful project Leaders I had my bathroom done earlier than expected. Will definitely recommend.
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
	                I was just looking for a quote for my kitchen, I waited and waited (as most of us do) I tried the Estimo platform. I must admit I was sceptical at first but their pricing was on the money. Job done well without a hitch. Very happy.
								</p>				    	
							<p>
								<b>Peter Gibbs</b>
								</p>
							</blockquote>
				    </div>
                    <div class="item">
    			    	<blockquote>
                  <p>
                I was so stressed when our laundry flooded, working full time meant I had to come home to meet tradesmen. Luckily Estimo managed the whole process over the phone. Laundry looks great. 
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
		
		
<section class="section section-feature bg-white text-center">
      <div class="container container-fluid">
        <h1 class="section-title text-uppercase wow fadeInDown animated padding-10" style="visibility: visible;">
				Why is Estimo is the way to go</h1>
        <div class="row padding-20 feature-group">
          <div class="col-xs-12 col-md-4 iconbox iconbox-left wow fadeInDown animated" data-wow-delay="200ms" style="visibility: visible; animation-delay: 200ms;">
            <i class="icon iconbox-icon text-danger wb-tag" style="font-size: 40px"  aria-hidden="true"></i>
            <div class="iconbox-content">
              <h3 class="iconbox-title">Instant Quotes</h3>
                <p>Instant online pricing, Guaranteed to be accurate. Transparent quotations and easy booking.</p>
            </div>
          </div>                  		
          <div class="col-xs-12 col-md-4 iconbox iconbox-left wow fadeInDown animated" data-wow-delay="100ms" style="visibility: visible; animation-delay: 100ms;">
            <i class="icon iconbox-icon text-danger wb-users" style="font-size: 40px" aria-hidden="true"></i>
            <div class="iconbox-content">
              <h3 class="iconbox-title">Expert Contractors</h3>
              <p>Licensed and insured contractors, certified for quality and professionalism. </p>
            </div>
          </div>
          <div class="col-xs-12 col-md-4 iconbox iconbox-left wow fadeInDown animated" data-wow-delay="300ms" style="visibility: visible; animation-delay: 300ms;">
            <i class="icon iconbox-icon text-danger wb-hammer" style="font-size: 40px"  aria-hidden="true"></i>
            <div class="iconbox-content">
              <h3 class="iconbox-title">Job Managers</h3>
              <p>Dedicated online job managers for a single point of contact and coordination. </p>
            </div>
          </div>
        </div>
				  <div class="row padding-20 feature-group">
          <div class="col-xs-12 col-md-4 iconbox iconbox-left wow fadeInDown animated" data-wow-delay="200ms" style="visibility: visible; animation-delay: 200ms;">
            <i class="icon iconbox-icon text-danger wb-help" style="font-size: 40px"  aria-hidden="true"></i>
            <div class="iconbox-content">
              <h3 class="iconbox-title">Customer Service</h3>	
                <p>Online customer service 24 hours a day, 7 days a week, we'll answer any questions you may have within hours.</p>
            </div>
          </div>                  
          <div class="col-xs-12 col-md-4 iconbox iconbox-left wow fadeInDown animated" data-wow-delay="100ms" style="visibility: visible; animation-delay: 100ms;">
            <i class="icon iconbox-icon text-danger wb-heart" style="font-size: 40px" aria-hidden="true"></i>
            <div class="iconbox-content">
              <h3 class="iconbox-title">Transparent Pricing</h3>
              <p>Flat rate, industry verified prices for all home projects. We use industry standard times for tasks then add an industry standard hourly rate.</p>
            </div>
          </div>
          <div class="col-xs-12 col-md-4 iconbox iconbox-left wow fadeInDown animated" data-wow-delay="300ms" style="visibility: visible; animation-delay: 300ms;">
            <i class="icon iconbox-icon text-danger wb-calendar" style="font-size: 40px"  aria-hidden="true"></i>
            <div class="iconbox-content">
              <h3 class="iconbox-title">Easy Booking</h3>
              <p>Book your project in with as little as 48 hours notice, We have crews that can start any day of the week. </p>
            </div>
          </div>
        </div>
      </div>
    </section>
    
  </div>
  <!-- Footer -->
<?php get_footer(); ?>