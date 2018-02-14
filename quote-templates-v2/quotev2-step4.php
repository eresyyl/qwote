<?php
/*
Template Name: Quote v2. Step 4. Final.
*/
?>
<?php 
if(is_contractor() ) {
    wp_redirect(home_url() . "/dash");
    die;
}
if(!$_POST) {
  wp_redirect( home_url() . "/add_quote" );
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



        <div class="bg-white" id="step1">
            <div class="panel-body">

						
	 </div>
                <div class="col-md-10 col-md-offset-1">

                    <div class="row">

                        <div class="col-md-12">

                            <div class="example-wrap margin-vertical-20 text-center ">
															
                              <?php include('views/step_4.php'); ?>
                                
                            </div>

                        </div>
            
                    </div>

                </div>
			
		    
    </div>
</div>

<?php get_footer(); ?>