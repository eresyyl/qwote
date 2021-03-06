<?php
/*
Template Name: Sign Up
*/
?>
<?php
if(is_user_logged_in()) {
        wp_redirect( home_url() . "/account" ); die;
}
?>
<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

        <title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; <?php } ?> <?php wp_title(); ?></title>
        <link rel="apple-touch-icon" href="<?php bloginfo('template_url'); ?>/assets/images/apple-touch-icon.png">
        <link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/assets/images/favicon.ico">
        <!-- Stylesheets -->
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/bootstrap-extend.min.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/css/site.min.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/skins/cyan.css">
  
        <!-- Plugins -->
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/animsition/animsition.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/asscrollable/asScrollable.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/switchery/switchery.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/intro-js/introjs.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/slidepanel/slidePanel.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/flag-icon-css/flag-icon.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/examples/css/pages/login-v3.css">
        <!-- Fonts -->
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/fonts/web-icons/web-icons.min.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/fonts/brand-icons/brand-icons.min.css">
        <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
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
                        <?php wp_head(); ?>
                </head>
  <style>
    .page-login-v3 {
      background: #57c7d4;
    }
  </style>
                <body class="page-login-v3 bg-cyan-600 layout-full">
                        <!--[if lt IE 8]>
                                <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
                                <![endif]-->
                                <!-- Page -->
                                <div class="animsition vertical-align text-center" data-animsition-in="fade-in" data-animsition-out="fade-out" style="margin:0 auto!important;">
                                <div class="page-content vertical-align-middle">
                                        <div class="panel">
                                                <div class="panel-body">
                                                  <div class="brand">
                                                                <a href="<?php bloginfo('url'); ?>"><img class="brand-img" src="<?php bloginfo('template_url'); ?>/assets/images/qwotebk.png" alt="..." style="width:50%;"></a>
                                                        </div>
                                                        <form id="sign-up">
                                                                <div class="radio-custom radio-danger row" style="text-align:left">
                                                                        <div class="col-md-6">
                                                                                <input type="radio" id="inputRadiosChecked1" value="Agent" name="user_type" checked="true">
                                                                                <label for="inputRadiosChecked1">Quoter</label>
                                                                        </div>
                                                                   <div class="col-md-6">
                                                                                <input type="radio" id="inputRadiosChecke2" value="Client" name="user_type" checked="">
                                                                                <label for="inputRadiosChecked2">Client</label>
                                                                        </div>
                                                                </div>
                                                                <div class="row">
                                                                        <div class="col-md-6">
                                                                                <div class="form-group form-material floating">
                                                                                        <input type="text" class="form-control" name="user_firstname" />
                                                                                        <label class="floating-label">First Name</label>
                                                                                </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                                <div class="form-group form-material floating">
                                                                                        <input type="text" class="form-control" name="user_lastname" />
                                                                                        <label class="floating-label">Last Name</label>
                                                                                </div>
                                                                        </div>
                                                                </div>
                                                                <div class="form-group form-material floating">
                                                                        <input type="email" class="form-control" name="user_email" />
                                                                        <label class="floating-label">E-mail</label>
                                                                </div>
                                                                <div class="row">
                                                                        <div class="col-md-6">
                                                                                <div class="form-group form-material floating">
                                                                                        <input type="password" class="form-control" name="user_password" />
                                                                                        <label class="floating-label">Password</label>
                                                                                </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                                <div class="form-group form-material floating">
                                                                                        <input type="password" class="form-control" name="user_passwordc" />
                                                                                        <label class="floating-label">Password Confirm</label>
                                                                                </div>
                                                                        </div>
                                                                </div>
                                                                <div id="sign-up-response"></div>
                                                                <a id="go-sign-up" class="btn btn-primary btn-block btn-lg margin-top-20 margin-left-0">Sign Up</a>
                                                        </form>
                                                        <p>Have an account already? Please go to <a href="<?php bloginfo('url'); ?>/sign-in">Sign In</a></p>
                                                </div>
                                        </div>
                                        <footer class="page-copyright page-copyright-inverse">
                                                <p>© <?php echo date('Y'); ?> <?php bloginfo('name'); ?></p>
                                                <?php /*
                                                <div class="social">
                                                <a class="btn btn-icon btn-pure" href="javascript:void(0)">
                                                <i class="icon bd-twitter" aria-hidden="true"></i>
                                                </a>
                                                <a class="btn btn-icon btn-pure" href="javascript:void(0)">
                                                <i class="icon bd-facebook" aria-hidden="true"></i>
                                                </a>
                                                <a class="btn btn-icon btn-pure" href="javascript:void(0)">
                                                <i class="icon bd-google-plus" aria-hidden="true"></i>
                                                </a>
                                                </div>
                                                <?php */ ?>
                                        </footer>
                                </div>
                        </div>
                        <!-- End Page -->
                        <!-- Core  -->
                        <script src="<?php bloginfo('template_url'); ?>/vendor/jquery/jquery.js"></script>
                        <script src="<?php bloginfo('template_url'); ?>/vendor/bootstrap/bootstrap.js"></script>
                        <script src="<?php bloginfo('template_url'); ?>/vendor/animsition/animsition.js"></script>
                        <script src="<?php bloginfo('template_url'); ?>/vendor/asscroll/jquery-asScroll.js"></script>
                        <script src="<?php bloginfo('template_url'); ?>/vendor/mousewheel/jquery.mousewheel.js"></script>
                        <script src="<?php bloginfo('template_url'); ?>/vendor/asscrollable/jquery.asScrollable.all.js"></script>
                        <script src="<?php bloginfo('template_url'); ?>/vendor/ashoverscroll/jquery-asHoverScroll.js"></script>
                        <!-- Plugins -->
                        <script src="<?php bloginfo('template_url'); ?>/vendor/switchery/switchery.min.js"></script>
                        <script src="<?php bloginfo('template_url'); ?>/vendor/intro-js/intro.js"></script>
                        <script src="<?php bloginfo('template_url'); ?>/vendor/screenfull/screenfull.js"></script>
                        <script src="<?php bloginfo('template_url'); ?>/vendor/slidepanel/jquery-slidePanel.js"></script>
                        <script src="<?php bloginfo('template_url'); ?>/vendor/jquery-placeholder/jquery.placeholder.js"></script>
                        <!-- Scripts -->
                        <script src="<?php bloginfo('template_url'); ?>/js/core.js"></script>
                        <script src="<?php bloginfo('template_url'); ?>/assets/js/site.js"></script>
                        <script src="<?php bloginfo('template_url'); ?>/assets/js/sections/menu.js"></script>
                        <script src="<?php bloginfo('template_url'); ?>/assets/js/sections/menubar.js"></script>
                        <script src="<?php bloginfo('template_url'); ?>/assets/js/sections/sidebar.js"></script>
                        <script src="<?php bloginfo('template_url'); ?>/js/configs/config-colors.js"></script>
                        <script src="<?php bloginfo('template_url'); ?>/assets/js/configs/config-tour.js"></script>
                        <script src="<?php bloginfo('template_url'); ?>/js/components/asscrollable.js"></script>
                        <script src="<?php bloginfo('template_url'); ?>/js/components/animsition.js"></script>
                        <script src="<?php bloginfo('template_url'); ?>/js/components/slidepanel.js"></script>
                        <script src="<?php bloginfo('template_url'); ?>/js/components/switchery.js"></script>
                        <script src="<?php bloginfo('template_url'); ?>/js/components/jquery-placeholder.js"></script>
                        <script src="<?php bloginfo('template_url'); ?>/js/components/material.js"></script>
                        
                        <script src="<?php bloginfo('template_url'); ?>/auth-templates/js/sign-up.js"></script>
                        <script>
                        (function(document, window, $) {
                                'use strict';
                                var Site = window.Site;
                                $(document).ready(function() {
                                        Site.run();
                                });
                        })(document, window, jQuery);
                        </script>
                        <?php wp_footer(); ?>
                </body>
                </html>