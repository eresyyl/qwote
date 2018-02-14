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
                                        <h5 class="page-aside-title">All Invoices</h5>
                                        <div class="list-group">
                                                <a class="list-group-item <?php if($quote_status == 'all') { echo 'active'; } ?>" href="<?php bloginfo('url'); ?>/all_invoices"><i class="icon wb-more-horizontal" aria-hidden="true"></i>All</a>
                                                <a class="list-group-item <?php if($quote_status == 'Pending') { echo 'active'; } ?>" href="<?php bloginfo('url'); ?>/all_invoices?status=Pending"><i class="icon wb-time" aria-hidden="true"></i>Pending</a>
                                                <a class="list-group-item <?php if($quote_status == 'Paid') { echo 'active'; } ?>" href="<?php bloginfo('url'); ?>/all_invoices?status=Paid"><i class="icon wb-order" aria-hidden="true"></i>Paid</a>
                                        </div>
                                </section>
                                <section class="page-aside-section">
                                        <h5 class="page-aside-title">Actions</h5>
                                        <div class="list-group">
                                                <a class="list-group-item" href="<?php bloginfo('url'); ?>/new_quote"><i class="icon wb-plus-circle" aria-hidden="true"></i>New Quote</a>
                                        </div>
                                </section>
                        </div>
                </div>
        </div>
</div>