<?php
/*
Template Name: Homepage
*/
?>
<?php 
if(is_contractor() ) {
    wp_redirect(home_url() . "/dash");
    die;
}
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

 <section class="site-hero hero">
    <div class="container text-center">
      <div class="content">
        <h1 class="wow fadeInDown">Get an Instant Price and Connect with our exclusive Contrators and Suppliers.</h1>
        <p class="lead wow fadeInDown">Your quotation is just a few clicks away</p>
        <p>
          <a class="btn btn-lg btn-round btn-primary margin-vertical-15 wow bounceInLeft"
          href="#add_quote">Get Your Price</a>

        </p>
      </div>
    </div>
  </section>

<div class="page">
    <div class="page-content padding-30 container-fluid">

        <div class="panel" id="step1">
            <div class="panel-body">


                <div class="pearls row">
                    <div class="pearl col-xs-3 current" aria-expanded="true">
                      <div class="pearl-icon"><i class="icon wb-user" aria-hidden="true"></i></div>
                      <span class="pearl-title">Choose Project</span>
                  </div>
                  <div class="pearl col-xs-3 " aria-expanded="true">
                      <div class="pearl-icon"><i class="icon wb-payment" aria-hidden="true"></i></div>
                      <span class="pearl-title">Fill in Details</span>
                  </div>
                  <div class="pearl col-xs-3" aria-expanded="true">
                      <div class="pearl-icon"><i class="icon wb-user" aria-hidden="true"></i></div>
                      <span class="pearl-title">Contact Details</span>
                  </div>
                  <div class="pearl col-xs-3" aria-expanded="true">
                      <div class="pearl-icon"><i class="icon wb-check" aria-hidden="true"></i></div>
                      <span class="pearl-title">Get Your Price</span>
                  </div>
              </div>


                <div class="col-md-10 col-md-offset-1">

                    <div class="row">

                        <div class="col-md-12">

                            <div class="example-wrap margin-vertical-20 text-center ">

                              <?php include('views/step_1.php'); ?>
                                
                            </div>

                        </div>
            
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>