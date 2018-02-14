<?php $current_user_id = current_user_id(); ?>
<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	      <meta name="description" content="Give an instant for anything">
        <meta name="google-site-verification" content="3RSNQA-Pihx0maVBQqly2xjb1jzOJAuH2T8-fH33C-E" />

        <title><?php bloginfo('name'); ?> - <?php bloginfo('description'); ?> <?php if ( is_single() ) { ?> &raquo; <?php } ?> <?php wp_title(); ?></title>
        <link rel="apple-touch-icon" href="<?php bloginfo('template_url'); ?>/assets/images/apple-touch-icon.png">
        <link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/assets/images/favicon.ico">
        <!-- Stylesheets -->
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/animate.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/bootstrap-extend.min.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/css/site.min.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/skins/cyan.css">

        <!-- Plugins -->
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/animsition/animsition.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/owl-carousel/owl.carousel.min.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/asscrollable/asScrollable.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/switchery/switchery.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/intro-js/introjs.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/slidepanel/slidePanel.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/flag-icon-css/flag-icon.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/alertify-js/alertify.min.css?v2.1.0">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/bootstrap-datepicker/bootstrap-datepicker.min.css">
	      <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/bootstrap-touchspin/bootstrap-touchspin.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/multi-select/multi-select.min.css?v2.2.0">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/examples/css/dashboard/ecommerce.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/aspieprogress/asPieProgress.css">


        <!-- Fonts -->
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/fonts/web-icons/web-icons.min.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/fonts/7-stroke/7-stroke.min.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/fonts/themify/themify.min.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/fonts/font-awesome/font-awesome.min.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/fonts/brand-icons/brand-icons.min.css">
        <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

        <?php // Dashboard styles ?>
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/examples/css/dashboard/ecommerce.css">

        <?php // Quotes list styles ?>
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/slidepanel/slidePanel.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/jquery-selective/jquery-selective.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/examples/css/apps/work.css">

        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/bootstrap-select/bootstrap-select.min.css?v2.2.0">

        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/switchery/switchery.min.css?v2.2.0">


        <?php // add Invoice styles
        if(is_singular('invoice')) : ?>
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/examples/css/pages/invoice.css">
<?php endif; ?>

<?php // add Account styles if we are on Account page
if(is_page('account')) : ?>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/examples/css/pages/profile.css">
<?php endif; ?>

<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/examples/css/apps/message.min.css?v2.1.0">


<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/bootstrap-table/bootstrap-table.min.css?v2.1.0">


<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/project-templates/main_v2/manage_v2/js/dropzone.css">
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style.css">

<!--[if lt IE 9]>
<script src="<?php bloginfo('template_url'); ?>/vendor/html5shiv/html5shiv.min.js"></script>
<![endif]-->
<!--[if lt IE 10]>
        <script src="<?php bloginfo('template_url'); ?>/vendor/media-match/media.match.min.js"></script>
        <script src="<?php bloginfo('template_url'); ?>/vendor/respond/respond.min.js"></script>
        <![endif]-->
        <!-- Scripts -->
        <script src="<?php bloginfo('template_url'); ?>/vendor/modernizr/modernizr.js"></script>
        <script src="<?php bloginfo('template_url'); ?>/vendor/breakpoints/breakpoints.js"></script>
        <script>
        Breakpoints();
        </script>

        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/magnific-popup/magnific-popup.min.css?v2.1.0">


        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/stylev2.css">


        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/project-templates/project.css">

        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/owl-carousel/owl.carousel.min.css?v2.2.0">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/slick-carousel/slick.min.css?v2.2.0">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/examples/css/uikit/carousel.min.css?v2.2.0">

        <?php wp_head(); ?>
</head>
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-90952463-1', 'auto');
  ga('send', 'pageview');

</script>
	
	<!--Start of Zendesk Chat Script-->
<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
$.src="https://v2.zopim.com/?4eGOP6hJ9a5vg32VU2pkoGld116iSarT";z.t=+new Date;$.
type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
</script>
<!--End of Zendesk Chat Script-->
	
<body class="<?php echo $body_class; ?>">
        <!--[if lt IE 8]>
                <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
                <![endif]-->
                <nav class="navbar bg-red-700 navbar-fixed-top" role="navigation">
         
									
<div class="navbar-container container-fluid">
		
        <!-- Navbar Collapse -->
           
					<div class="navbar-brand">
          <a href="http://www.paynt.com.au/property-login">
            <img class="navbar-brand-logo" src="<?php bloginfo('template_url'); ?>/assets/images/payntwt.png" title="Paynt">
            </a>
        </div>
                <!-- Navbar Toolbar Right -->
                <ul class="nav navbar-toolbar navbar-right margin-right-0 navbar-toolbar-right">
       
		  <?php if(!is_user_logged_in()) : ?> 
		 <form action="<?php bloginfo('url'); ?>/sign-in">
		<button class="btn btn-default navbar-btn btn-sm" href="">LOGIN</button>
	</form>
</li>
        <?php endif ; ?>		
</li>
        </ul>
					
					  
        <!-- Navbar Toolbar Right -->
                <ul class="nav navbar-toolbar navbar-right margin-right-0 navbar-toolbar-right">
                  
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
																	   <?php if(is_headcontractor() || is_agent()) : ?><li role="presentation">
																									<a href="<?php bloginfo('url'); ?>/dash" role="menuitem"><i class="icon wb-briefcase" aria-hidden="true"></i> Dashboard</a>
                                        </li><?php endif ;?>
                                        <li role="presentation">
                                                <a href="<?php bloginfo('url'); ?>/all_projects" role="menuitem"><i class="icon wb-align-justify" aria-hidden="true"></i> My Jobs</a>
                                        </li>
																	   <?php if(is_headcontractor() || is_agent()) : ?><li role="presentation">
                                                <a href="<?php bloginfo('url'); ?>/all_contacts" role="menuitem"><i class="icon wb-users" aria-hidden="true"></i> Contacts</a>
                                        </li><?php endif ;?>
																	<li role="presentation">
                                                <a href="<?php bloginfo('url'); ?>/payments" role="menuitem"><i class="icon wb-user" aria-hidden="true"></i> Payments</a>
                                        </li>
                                        <li class="divider" role="presentation"></li>
                                        <li role="presentation">
                                                <a href="<?php echo wp_logout_url( home_url() ); ?>" role="menuitem"><i class="icon wb-power" aria-hidden="true"></i> Logout</a>
                                        </li>
                                </ul>
                       
                </li>
   <?php endif; ?>   
        </ul>
					
	
<!-- End Navbar Collapse -->
	
</div>
</nav>
