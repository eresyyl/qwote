<div class="site-menubar">
	
        <?php if(is_user_logged_in()) : $current_user_id = current_user_id(); $current_user_data = get_userdata($current_user_id); ?>  
	  
                <div class="site-menubar-header">
                        <div class="cover overlay">
                                <img class="cover-image" src="<?php bloginfo('template_url'); ?>/assets//examples/images/dashboard-header.jpg" alt="...">
                                <div class="overlay-panel vertical-align overlay-background">
                                        <div class="vertical-align-middle">
			  
                                                <?php if(get_field('ava','user_' . $current_user_id)) : ?>
                                                        <?php $ava_id = get_field('ava','user_' . $current_user_id ); $size = "ava"; $ava = wp_get_attachment_image_src( $ava_id, $size ); ?>
                                                        <a class="avatar avatar-lg" href="<?php bloginfo('url'); ?>/account">
                                                                <img src="<?php echo $ava[0]; ?>" alt="">
                                                        </a>
                                                <?php else : ?>
                                                        <a class="avatar avatar-lg" href="<?php bloginfo('url'); ?>/account">
                                                                <img src="<?php bloginfo('template_url'); ?>/assets/defaults/default-ava.png" alt="">
                                                        </a>
                                                <?php endif; ?>
			
                                                <div class="site-menubar-info">
                                                        <h5 class="site-menubar-user"><?php echo $current_user_data->first_name; ?> <?php echo $current_user_data->last_name; ?></h5>
                                                        <p class="site-menubar-email"><?php echo $current_user_data->user_email; ?></p>
                                                </div>
                                        </div>
                                </div>
                        </div>
                </div>
	
        <?php else : ?>
		
                <div class="site-menubar-header">
                        <div class="cover overlay text-center">
                                <img class="cover-image" src="<?php bloginfo('template_url'); ?>/assets//examples/images/dashboard-header.jpg"
                                alt="...">
                                <div class="overlay-panel vertical-align overlay-background">
                                        <div class="vertical-align-middle text-center">
			
                                                <a href="<?php bloginfo('url'); ?>/sign-in" class="btn btn-primary btn-sm">Sign In</a>  
                                                <a href="<?php bloginfo('url'); ?>/sign-up" class="btn btn-primary btn-sm">Sign Up</a>  
			
                                        </div>
                                </div>
                        </div>
                </div>
	
        <?php endif; ?>
	
        <?php if(is_user_logged_in()) : ?>
        <div class="site-menubar-body">
                <div>
                        <div>
                                <ul class="site-menu">
                                        <li class="site-menu-item">
                                                <a href="<?php bloginfo('url'); ?>/dash">
                                                        <i class="site-menu-icon wb-dashboard" aria-hidden="true"></i>
                                                        <span class="site-menu-title">Dashboard</span>
                                                </a>
                                        </li>
                                        <li class="site-menu-item has-sub">
                                                <a href="javascript:void(0)">
                                                        <i class="site-menu-icon wb-briefcase" aria-hidden="true"></i>
                                                        <span class="site-menu-title">Projects</span>
                                                        <span class="site-menu-arrow"></span>
                                                </a>
                                                <ul class="site-menu-sub">
                                                        <li class="site-menu-item">
                                                                <a class="animsition-link" href="<?php bloginfo('url'); ?>/all_projects">
                                                                        <span class="site-menu-title">All</span>
                                                                </a>
                                                        </li>
                                                        <?php if(!is_contractor()) : ?>
                                                        <li class="site-menu-item">
                                                                <a class="animsition-link" href="<?php bloginfo('url'); ?>/all_projects?status=quote">
                                                                        <span class="site-menu-title">Quote Mode</span>
                                                                </a>
                                                        </li>
                                                        <li class="site-menu-item">
                                                                <a class="animsition-link" href="<?php bloginfo('url'); ?>/all_projects?status=active">
                                                                        <span class="site-menu-title">Active</span>
                                                                </a>
                                                        </li>
                                                        <?php endif; ?>
                                                        <li class="site-menu-item">
                                                                <a class="animsition-link" href="<?php bloginfo('url'); ?>/all_projects?status=pending">
                                                                        <span class="site-menu-title">Pending</span>
                                                                </a>
                                                        </li>
                                                        <li class="site-menu-item">
                                                                <a class="animsition-link" href="<?php bloginfo('url'); ?>/all_projects?status=live">
                                                                        <span class="site-menu-title">Live</span>
                                                                </a>
                                                        </li>
                                                        <li class="site-menu-item">
                                                                <a class="animsition-link" href="<?php bloginfo('url'); ?>/all_projects?status=completed">
                                                                        <span class="site-menu-title">Completed</span>
                                                                </a>
                                                        </li>
                                                        <?php if(!is_contractor()) : ?>
                                                        <li class="site-menu-item">
                                                                <a class="animsition-link" href="<?php bloginfo('url'); ?>/all_projects?status=cancelled">
                                                                        <span class="site-menu-title">Cancelled</span>
                                                                </a>
                                                        </li>
                                                        <?php endif; ?>
                                                </ul>
                                        </li>
                                        <?php if(!is_contractor()) : ?>
                                        <li class="site-menu-item has-sub">
                                                <a href="javascript:void(0)">
                                                        <i class="site-menu-icon wb-order" aria-hidden="true"></i>
                                                        <span class="site-menu-title">Invoices</span>
                                                        <span class="site-menu-arrow"></span>
                                                </a>
                                                <ul class="site-menu-sub">
                                                        <li class="site-menu-item">
                                                                <a class="animsition-link" href="<?php bloginfo('url'); ?>/all_invoices">
                                                                        <span class="site-menu-title">All</span>
                                                                </a>
                                                        </li>
                                                        <li class="site-menu-item">
                                                                <a class="animsition-link" href="<?php bloginfo('url'); ?>/all_invoices?status=Pending">
                                                                        <span class="site-menu-title">Pending</span>
                                                                </a>
                                                        </li>
                                                        <li class="site-menu-item">
                                                                <a class="animsition-link" href="<?php bloginfo('url'); ?>/all_invoices?status=Paid">
                                                                        <span class="site-menu-title">Paid</span>
                                                                </a>
                                                        </li>
                                                </ul>
                                        </li>
                                        <?php endif; ?>
                                        <li class="site-menu-item">
                                                <a href="<?php bloginfo('url'); ?>/account">
                                                        <i class="site-menu-icon wb-user" aria-hidden="true"></i>
                                                        <span class="site-menu-title">Account</span>
                                                </a>
                                        </li>
                                </ul>
                        </div>
                </div>
        </div>
        <?php endif; ?>
</div>