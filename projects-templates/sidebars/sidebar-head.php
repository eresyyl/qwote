<?php if($_GET) {
        $quote_status = $_GET['status'];
}
else {
        $quote_status = 'all';
}
?>
<div class="page-aside">
        <div class="page-aside-switch">
                <i class="icon wb-chevron-left" aria-hidden="true"></i>
                <i class="icon wb-chevron-right" aria-hidden="true"></i>
        </div>
        <div class="page-aside-inner" data-plugin="pageAsideScroll">
                <div data-role="container">
                        <div data-role="content">
                                <section class="page-aside-section">
                                        <h5 class="page-aside-title">All Projects</h5>
                                        <div class="list-group">
                                                <a class="list-group-item <?php if($quote_status == 'all') { echo 'active';} ?>" href="<?php bloginfo('url'); ?>/all_projects"><i class="icon wb-more-horizontal" aria-hidden="true"></i>All</a>
                                                <a class="list-group-item <?php if($quote_status == 'quote') { echo 'active'; } ?>" href="<?php bloginfo('url'); ?>/all_projects?status=quote"><i class="icon wb-attach-file" aria-hidden="true"></i>Quotes</a>
                                                <a class="list-group-item <?php if($quote_status == 'live') { echo 'active'; } ?>" href="<?php bloginfo('url'); ?>/all_projects?status=live"><i class="icon wb-play" aria-hidden="true"></i>Live Jobs</a>
                                                <a class="list-group-item <?php if($quote_status == 'completed') { echo 'active'; } ?>" href="<?php bloginfo('url'); ?>/all_projects?status=completed"><i class="icon wb-check" aria-hidden="true"></i>Won</a>
                                                <a class="list-group-item <?php if($quote_status == 'completed') { echo 'active'; } ?>" href="<?php bloginfo('url'); ?>/all_projects?status=cancelled"><i class="icon wb-check" aria-hidden="true"></i>Lost</a>
                                        </div>
                                </section>
                                <?php if(!is_contractor()) : ?>
                                <section class="page-aside-section">
                                  <h5 class="page-aside-title">Actions</h5>
                                  <div class="list-group">
                    				<a class="list-group-item" href="<?php bloginfo('url'); ?>/add_quote"><i class="icon wb-plus-circle" aria-hidden="true"></i>New Job</a>
                                  </div>
                                </section>
                                <?php endif; ?>
                        </div>
                </div>
        </div>
</div>
