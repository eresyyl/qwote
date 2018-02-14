<?php if($_GET) {
        $contact_type = $_GET['type'];
}
else {
        $contact_type = 'all';
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
                                        <h5 class="page-aside-title">All Contacts</h5>
                                        <div class="list-group">
                                                <a class="list-group-item <?php if($contact_type == 'all') { echo 'active';} ?>" href="<?php bloginfo('url'); ?>/all_contacts"><i style="padding-right: 10px;" class="fa fa-users" aria-hidden="true"></i>All</a>
                                        </div>
                                </section>
                                <section class="page-aside-section">
                                  <h5 class="page-aside-title">Actions</h5>
                                  <div class="list-group">
                    				<a class="list-group-item" data-target='#add_contact' style="cursor:pointer;" data-toggle='modal'><i class="icon wb-user-add" aria-hidden="true"></i>New Contact</a>
                                  </div>
                                </section>
                        </div>
                </div>
        </div>
</div>
