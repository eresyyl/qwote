<?php
/*
Template Name: quote-page
*/
?>
<!DOCTYPE html>
<html class="no-js before-run" lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="bootstrap Frontend template">
  <meta name="author" content="">

  <title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; <?php } ?> <?php wp_title(); ?></title>

  <link rel="apple-touch-icon" href="<?php bloginfo('template_url'); ?>/assets/front/images/apple-touch-icon.png">
  <link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/assets/images/favicon.ico">

  <!-- Stylesheets -->
  <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/front/css/site.css">
  <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/front/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/front/css/bootstrap-extend.min.css">
  <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/css/site.min.css">
  <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/skins/red.css">
  
  <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/front/vendor/asscrollable/asScrollable.min.css">
  <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/front/vendor/animate-css/animate.css">


  <!-- Fonts -->
  <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/fonts/web-icons/web-icons.min.css">
  <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/fonts/brand-icons/brand-icons.min.css">
  <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
  <!-- Inline -->
  <!--[if lt IE 9]>
    <script src="<?php bloginfo('template_url'); ?>/assets/vendor/html5shiv/html5shiv.min.js"></script>
    <![endif]-->

  <!--[if lt IE 10]>
    <script src="<?php bloginfo('template_url'); ?>/assets/vendor/media-match/media.match.min.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/assets/vendor/respond/respond.min.js"></script>
    <![endif]-->

  <!-- Scripts -->
  <script src="<?php bloginfo('template_url'); ?>/vendor/modernizr/modernizr.js"></script>
  <script src="<?php bloginfo('template_url'); ?>/vendor/breakpoints/breakpoints.js"></script>
  <script>
    Breakpoints();
  </script>
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
</head>
<body class="page-home-1">
  <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
<header class="other-bg">

 <!-- Navbar -->
  <nav class="navbar navbar-default bg-white navbar-fixed-top navbar-mega">
    <div class="container-fluid">
      <div class="navbar-header">
        <button class="navbar-toggle hamburger hamburger-close navbar-toggle-left hided"
        data-toggle="site-menubar" type="button">
          <span class="sr-only">Toggle navigation</span>
          <span class="hamburger-bar"></span>
        </button>
        <div class="navbar-brand navbar-brand-center">
          <a href="<?php bloginfo('url'); ?>"><img style="margin-top: -10px; height: 42px" class="navbar-brand-logo" src="<?php bloginfo('template_url'); ?>/assets/images/renoblack.png" title="<?php bloginfo('name'); ?>"></a>
        </div>
      </div>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false"><b>find out more</b></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="/about">About Us</a></li>
            <li><a href=/services>Services</a></li>
            <li><a href="/#">How It Works</a></li>
            <li><a href="/faq">FAQ</a></li>
          </ul>
        </li>
			  <li><a href="/#contact">Contact</a></li>
        <li><a href="tel:098873030">09 887 3030</a></li>
        <li>
            </li>
            <li class="dropdown">
                        <?php if(is_user_logged_in()) : $current_user_id = current_user_id(); ?>
                                <a class="navbar-avatar dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" data-animation="scale-up" role="button">
                                        <span class="avatar avatar-online">
                                                <?php if(get_field('ava','user_' . $current_user_id)) : ?>
                                                        <?php $ava_id = get_field('ava','user_' . $current_user_id ); $size = "ava"; $ava = wp_get_attachment_image_src( $ava_id, $size ); ?>
                                                        <img src="<?php echo $ava[0]; ?>" alt="...">
                                                        <i></i>
                                                <?php else : ?>
                                                        <img src="<?php bloginfo('template_url'); ?>/assets/defaults/default-ava.png" alt="...">
                                                        <i></i>
                                                <?php endif; ?>
                                        </span>
                                </a>
			
                                <ul class="dropdown-menu" role="menu">
                                        <li role="presentation">
                                                <a href="<?php bloginfo('url'); ?>/account" role="menuitem"><i class="icon wb-user" aria-hidden="true"></i> Account</a>
                                        </li>
                                        <li role="presentation">
                                                <a href="<?php bloginfo('url'); ?>/all_projects" role="menuitem"><i class="icon wb-briefcase" aria-hidden="true"></i> My Projects</a>
                                        </li>
                                        <li class="divider" role="presentation"></li>
                                        <li role="presentation">
                                                <a href="<?php echo wp_logout_url( home_url() ); ?>" role="menuitem"><i class="icon wb-power" aria-hidden="true"></i> Logout</a>
                                        </li>
                                </ul>
                                               

                </li>
				<?php else : ?>
				                 <a href="<?php bloginfo('url'); ?>/sign-in"><b>Sign in</b></a>

				<?php endif; ?>
      </ul>
    </div>
  </nav>
  <!-- End Navbar -->

  <!-- Menubar -->
  <div class="site-menubar">
    <ul class="site-menu">
      <li class="site-menu-item has-sub">
        <a href="javascript:void(0)" data-slug="">
          <span class="site-menu-title">Home</span>
        </a>
    
      </li>
      <li class="site-menu-item has-sub">
        <a href="javascript:void(0)" data-slug="">
          <span class="site-menu-title">Pages</span>
          <span class="site-menu-arrow"></span>
        </a>
        <ul class="site-menu-sub">
          <li class="site-menu-item">
            <a class="animsition-link" href="../pages/about-us.html" data-slug="about-us">
              <span class="site-menu-title">About Us</span>
            </a>
          </li>
          <li class="site-menu-item">
            <a class="animsition-link" href="../pages/company.html" data-slug="Company">
              <span class="site-menu-title">Company</span>
            </a>
          </li>
          <li class="site-menu-item">
            <a class="animsition-link" href="../pages/contact.html" data-slug="Contact">
              <span class="site-menu-title">Contact</span>
            </a>
          </li>
          <li class="site-menu-item">
            <a class="animsition-link" href="../pages/faq.html" data-slug="Faq">
              <span class="site-menu-title">Faq</span>
            </a>
          </li>
          <li class="site-menu-item">
            <a class="animsition-link" href="../pages/service.html" data-slug="Service">
              <span class="site-menu-title">Service</span>
            </a>
          </li>
          <li class="site-menu-item">
            <a class="animsition-link" href="../pages/pricing.html" data-slug="pages-pricing">
              <span class="site-menu-title">Pricing</span>
            </a>
          </li>
        </ul>
      </li>
      <li class="site-menu-item has-sub">
        <a href="javascript:void(0)" data-slug="">
          <span class="site-menu-title">Blog</span>
          <span class="site-menu-arrow"></span>
        </a>
        <ul class="site-menu-sub">
          <li class="site-menu-item">
            <a class="animsition-link" href="../blog/author-list.html" data-slug="blog-author-list">
              <span class="site-menu-title">Blog Author List</span>
            </a>
          </li>
          <li class="site-menu-item">
            <a class="animsition-link" href="../blog/list.html" data-slug="blog-list">
              <span class="site-menu-title">Blog List</span>
            </a>
          </li>
          <li class="site-menu-item">
            <a class="animsition-link" href="../blog/masonry.html" data-slug="blog-masonry">
              <span class="site-menu-title">Blog Masonry</span>
            </a>
          </li>
          <li class="site-menu-item">
            <a class="animsition-link" href="../blog/single.html" data-slug="blog-single">
              <span class="site-menu-title">Blog Single</span>
            </a>
          </li>
          <li class="site-menu-item">
            <a class="animsition-link" href="../blog/with-sidebar.html" data-slug="blog-with-sidebar">
              <span class="site-menu-title">Blog With Sidebar</span>
            </a>
          </li>
          <li class="site-menu-item">
            <a class="animsition-link" href="../blog/archive.html" data-slug="blog-archive">
              <span class="site-menu-title">Blog Archive</span>
            </a>
          </li>
        </ul>
      </li>
    </ul>
  </div>
  <!-- End Menubar -->
  <!-- Hero -->
  <section class="site-hero hero">
    <div class="container text-center">
      <div class="content">
        <h1 class="wow fadeInDown">Lets Renovate</h1>
        <p class="lead wow fadeInDown">Get a price for any home improvement project in just 60 seconds.</p>
        <p>
           <a class="btn btn-lg btn-round btn-primary margin-vertical-15 wow bounceInLeft"
          href="<?php bloginfo('url'); ?>/renovate" data-toggle="tooltip" data-placement="top" title="For: Bathroom, Toilets, Kitchen, Laundry, Decking and Extension Projects.">Select Full Projects</a> or
           <a class="btn btn-lg btn-round btn-info margin-vertical-15 wow bounceInLeft"
          href="<?php bloginfo('url'); ?>/trades" data-toggle="tooltip" data-placement="top" title="For: Painting, Flooring, Electrical, Plumbing and Carpentry Projects.">Select Trades</a>
        </p>
      </div>
    </div>
  </section>
  <!-- End Hero -->

</header>
  
 
 <div class="site-body">
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
		
 <div class="section" id="section1" data-anchor="feature-01">
	     
          <div class="container text-center">
            <div class="row">
							<h2>
								How Renovar Works
							</h2>
							<hr>
							<div class="pearls row"><div class="pearl current col-md-4 col-xs-4" aria-expanded="true"><div class="pearl-icon"><i class="con wb-user" aria-hidden="true"></i></div><span class="pearl-title"></span></div>
<div class="pearl current col-md-4 col-xs-4" aria-expanded="true"><div class="pearl-icon"><i class="icon wb-payment" aria-hidden="true"></i></div><span class="pearl-title"></span></div>
<div class="pearl current col-md-4 col-xs-4" aria-expanded="true"><div class="pearl-icon"><i class="icon wb-check" aria-hidden="true"></i></div><span class="pearl-title"></span></div></div>
              <div class="col-lg-4">
								<span class="number">1</span>
                <h3 class="title">Get an Instant Quote</h3>
                <p class="description">Using industry verified rates and simple questions we are able to offer you an instant quote. </p>
              </div>      
              <div class="col-lg-4">
							 <span class="number">2</span>
                <h3 class="title">Finalise the Details</h3>
                <p class="description">A Renovation consultant will be in touch to finalise the finer details and book in the project. </p>
              </div>                    
              <div class="col-lg-4">
								 <span class="number">3</span>
                <h3 class="title">Satisfaction Guarantee</h3>
                <p class="description">We guarantee that we wont leave until you're 100% satisfied with the finished product. </p>
              </div>
            </div>
          </div>    
      <hr>
	 
    <div class="container text-center">
        <div class="row">
          <div class="col-md-12">
            <div class="row margin-bottom-40">
              <div class="col-md-4">
               <?php $image = get_field('photo_1'); ?>
                <img class="margin-bottom-20 wow zoomIn" width="100%" src="<?php echo $image['url']; ?>"
                alt="">
              </div>
              <div class="col-md-4">
                <?php $image1 = get_field('photo_2'); ?>
                <img class="margin-bottom-20 wow zoomIn" width="100%" src="<?php echo $image1['url']; ?>"
                alt="">
              </div>
              <div class="col-md-4">
                 <?php $image2 = get_field('photo_3'); ?>
                <img class="margin-bottom-20 wow zoomIn" width="100%" src="<?php echo $image2['url']; ?>"
                alt="">
              </div>
            </div>
          </div>
          <div class="col-lg-12 col-md-12 padding-30">
          <?php the_field('content'); ?>
          </div><br/>
        </div>
   
         
      
             
			
          </div>
       </div>
    
    
     
     <div class="section section-dark" id="section1" data-anchor="feature-01">
          <div class="container">
            <div class="row">
              <div class="col-lg-12">
          <h1 class="section-title">Hassle-Free Home Renovations</h1>
                <p>From our state of the art platform for instant pricing and managing home projects to our relentless focus on customer service. You'll quickly realise that we do things differently.
									Well better put,we are the best at what we do and innovation plays a huge part in that, making your next home project with us the most streamlined and enjoyable ever.
 </p>
              </div>
            </div>
          </div>
       </div>
    
    
   
   
    
 
<section class="section section-feature text-center">
      <div class="container container-fluid">
        <h3 class="section-title text-uppercase wow fadeInDown animated" style="visibility: visible;">Putting power back in the hands of the Homeowner.</h3>
        <p class="section-desc wow fadeInDown animated" style="visibility: visible;">From our extremely rigorous recruitment process to every bit of development on our platform, our difference is our relentless focus on customer service. We've done this by building a platform that makes home improvement and renovation completely transparent and actually enjoyable. </p>
        <div class="row feature-group">
          <div class="col-sm-4 wow fadeIn animated" style="visibility: visible;">
            <img width="100%" src="<?php bloginfo('template_url'); ?>/assets/images/bathroom.jpg" alt="">
          </div>
          <div class="col-sm-4 wow fadeIn animated" data-wow-delay="100ms" style="visibility: visible; animation-delay: 100ms;">
            <img width="100%" src="<?php bloginfo('template_url'); ?>/assets/images/family.jpg" alt="">
          </div>
          <div class="col-sm-4 wow fadeIn animated" data-wow-delay="200ms" style="visibility: visible; animation-delay: 200ms;">
            <img width="100%" src="<?php bloginfo('template_url'); ?>/assets/images/house.jpg" alt="">
          </div>
        </div>
        <div class="row feature-group">
          <div class="col-sm-6 col-md-4 iconbox iconbox-left wow fadeInDown animated" data-wow-delay="200ms" style="visibility: visible; animation-delay: 200ms;">
            <i class="icon iconbox-icon wb-cloud" aria-hidden="true"></i>
            <div class="iconbox-content">
              <h3 class="iconbox-title">Online Quotes</h3>
                <p>Instantly recieve a comprehensive quote for almost every home project. With flat rate pricing, the right questions mixed with some amazing technology get your quote in just 60 seconds.</p>
            </div>
          </div>          
          <div class="col-sm-6 col-md-4 iconbox iconbox-left wow fadeInDown animated" data-wow-delay="200ms" style="visibility: visible; animation-delay: 200ms;">
            <i class="icon iconbox-icon wb-star-outline" aria-hidden="true"></i>
            <div class="iconbox-content">
              <h3 class="iconbox-title">Satisfaction Guarantee</h3>
                <p>Our customer focus doesnt stop at the front door, we are here to ensure you're 100% happy with the finished product and we wont leave until that happens.</p>
            </div>
          </div>
          <div class="col-sm-6 col-md-4 iconbox iconbox-left wow fadeInDown animated" data-wow-delay="300ms" style="visibility: visible; animation-delay: 300ms;">
            <i class="icon iconbox-icon wb-check" aria-hidden="true"></i>
            <div class="iconbox-content">
              <h3 class="iconbox-title">Project Management</h3>
                <p>Using the Renovar platform and our customer focused job managers we coordinate and manage your home renovation project from setup to cleanup.</p>
            </div>
          </div></div>
        
        <div class="row feature-group">
          <div class="col-sm-6 col-md-4 iconbox iconbox-left wow fadeInDown animated" data-wow-delay="100ms" style="visibility: visible; animation-delay: 100ms;">
            <i class="icon iconbox-icon wb-users" aria-hidden="true"></i>
            <div class="iconbox-content">
              <h3 class="iconbox-title">Verified Contractors</h3>
              <p>We put each of our contractors through an intense vetting process, we continue to monitor performance and cover all insurances. </p>
            </div>
          </div>
          <div class="col-sm-6 col-md-4 iconbox iconbox-left wow fadeInDown animated" data-wow-delay="300ms" style="visibility: visible; animation-delay: 300ms;">
            <i class="icon iconbox-icon wb-pencil" aria-hidden="true"></i>
            <div class="iconbox-content">
              <h3 class="iconbox-title">Project Tools</h3>
              <p>From quote to completion you will see your project unfold on our project panel, there are plenty of tools that make the process so much better.</p>
            </div>
          </div>
          <div class="col-sm-6 col-md-4 iconbox iconbox-left wow fadeInDown animated" data-wow-delay="300ms" style="visibility: visible; animation-delay: 300ms;">
            <i class="icon iconbox-icon wb-eye" aria-hidden="true"></i>
            <div class="iconbox-content">
              <h3 class="iconbox-title">Customer Service</h3>
              <p>We have a relentless focus on customer service, from setup to clean up we're here every step of the way. 24/7 support. </p>
            </div>
          </div>
        </div>
      </div>
    </section>
    
     <section class="section section-content-5 section-dark section-small text-center" id="contact" data-anchor="contact">
      <div class="container">
		<div class="row">
																											<?php echo do_shortcode('[contact-form-7 id="880" title="Contact form 1"]'); ?>

		</div>
	</div>
    </section>
  </div>


  <!-- Footer -->
  <footer class="footer">
    <div class="footer-detial">
     <div class="container">
                <div class="row padding-30">
                    <div class="col-md-4">
                        <strong class="stat-count">Interested in using Renovar to improve your business?</strong>
                        <a href="<?php bloginfo('url'); ?>/agents" class="btn btn-default btn-outline btn-block">For Agents</a>
                        <a href="<?php bloginfo('url'); ?>/partners" class="btn btn-default btn-info btn-block">For Contractors</a>
                    </div>
                    <div class="col-md-8">
                        <div class="col-sm-4 col-xs-6">
                          <ul class="nav social">
                           <li><a href="<?php bloginfo('url'); ?>/about">About Us</a></li> 
                           <li><a href="<?php bloginfo('url'); ?>/services">Services</a></li> 
                           <li><a href="<?php bloginfo('url'); ?>/#">How It Works</a></li> 
                           <li><a href="<?php bloginfo('url'); ?>/contact">Contact Us</a></li> 
                           <li><a href="<?php bloginfo('url'); ?>/faq">FAQ</a></li> 
                           
                          </ul>
                            
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <ul class="nav social">
                           <li><a href="<?php bloginfo('url'); ?>/services/bathroom">Bathroom</a></li> 
                           <li><a href="<?php bloginfo('url'); ?>/services/kitchen">Kitchen</a></li> 
                           <li><a href="<?php bloginfo('url'); ?>/services/laundry">Laundry</a></li> 
                           <li><a href="<?php bloginfo('url'); ?>/services/painting">Painting</a></li> 
                           <li><a href="<?php bloginfo('url'); ?>/services/electrical">Electrical</a></li> 
                           <li><a href="<?php bloginfo('url'); ?>/services/plumbing">Plumbing</a></li> <br/>
                           <li><a href="<?php bloginfo('url'); ?>/services"><b>All Services</b></a></li> 
                              
                           
                          </ul>                        </div>
                        <div class="col-sm-4 col-xs-12">
                          <div class="social">
              <a class="icon bd-facebook" href="javascript:void(0)"></a>
              <a class="icon bd-twitter" href="javascript:void(0)"></a>
            </div>
                          <br/>
                         <a href="<?php bloginfo('url'); ?>/sign-up" class="btn btn-default btn-info pull-left">Sign Up</a>
                        <a href="<?php bloginfo('url'); ?>/sign-in" class="btn btn-default margin-left-15 btn-primary">Login</a>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    
  
  </footer>
  <!-- End Footer -->
  <!-- JS and analytics only. -->
  <!-- Core  -->
  <script src="<?php bloginfo('template_url'); ?>/assets/front/vendor/jquery/jquery.js"></script>
  <script src="<?php bloginfo('template_url'); ?>/assets/front/vendor/bootstrap/bootstrap.js"></script>
  <script src="<?php bloginfo('template_url'); ?>/assets/front/vendor/asscroll/jquery-asScroll.js"></script>
  <script src="<?php bloginfo('template_url'); ?>/assets/front/vendor/asscrollable/jquery.asScrollable.all.js"></script>
  <script src="<?php bloginfo('template_url'); ?>/assets/front/vendor/wow/wow.js"></script>

  <!-- Plugins -->

  <!-- Scripts -->
  <script src="<?php bloginfo('template_url'); ?>/js/core.js"></script>
  <script src="<?php bloginfo('template_url'); ?>/assets/js/site.js"></script>

  <script src="<?php bloginfo('template_url'); ?>/js/configs/config-colors.js"></script>

  <script src="<?php bloginfo('template_url'); ?>/js/modules/navbar.js"></script>
  <script src="<?php bloginfo('template_url'); ?>/js/modules/aside.js"></script>
  <script src="<?php bloginfo('template_url'); ?>/js/modules/menubar.js"></script>
  <script src="<?php bloginfo('template_url'); ?>/js/modules/menu.js"></script>
  <script src="<?php bloginfo('template_url'); ?>/js/modules/footer.js"></script>

  <script src="<?php bloginfo('template_url'); ?>/assets/front/js/components/wow.js"></script>


  <!-- Scripts For This Page -->


  <script>
    (function(document, window, $) {
      'use strict';

      var Site = window.Site;
      $(document).ready(function() {
        Site.run();
      });
    })(document, window, jQuery);
  </script>

</body>

</html>