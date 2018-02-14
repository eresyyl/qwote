
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
<script src="<?php bloginfo('template_url'); ?>/vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.js"></script>
<script src="<?php bloginfo('template_url'); ?>/vendor/slidepanel/jquery-slidePanel.js"></script>
<script src="<?php bloginfo('template_url'); ?>/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<!-- <script src="<?php bloginfo('template_url'); ?>/vendor/chartist-js/chartist.min.js"></script> -->
<!-- <script src="<?php bloginfo('template_url'); ?>/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.min.js"></script> -->
<script src="<?php bloginfo('template_url'); ?>/vendor/alertify-js/alertify.js"></script>

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
<script src="<?php bloginfo('template_url'); ?>/js/components/alertify-js.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/components/bootstrap-touchspin.js"></script>


<script src="<?php bloginfo('template_url'); ?>/js/plugins/responsive-tabs.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/plugins/closeable-tabs.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/components/tabs.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/components/bootstrap-datepicker.min.js"></script>

<script src="<?php bloginfo('template_url'); ?>/js/components/panel.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/quote-templates/js/quote_03.js"></script>

<?php if(is_page('edit')) : ?>
        <script src="<?php bloginfo('template_url'); ?>/quote-edit-templates/js/quote_edit.js"></script>
        <script src="<?php bloginfo('template_url'); ?>/quote-edit-templates/js/quote_edit_image.js"></script>
<?php endif; ?>


<?php // Quote list scripts?>
<script src="<?php bloginfo('template_url'); ?>/vendor/jquery-selective/jquery-selective.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/assets/js/app.js"></script>
<script src="<?php bloginfo('template_url'); ?>/assets/examples/js/apps/work.js"></script>

<?php if(is_page('new_quote')) : ?>
<?php $goto_template = $_GET['type']; if(!empty($goto_template) && $goto_template != '') : ?>
<script>
        $(document).ready(function() {
                $('#step1').hide();
                $('#<?php echo $goto_template; ?>').prop('checked', true);
                $('.goto_2_step').click();
        });
</script>
<?php endif; endif; ?>

<?php /*
<script>
        $('.selectpicker').selectpicker({
          size: 6
        });
    </script>
*/ ?>

<script src="<?php bloginfo('template_url'); ?>/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/vendor/datatables-fixedheader/dataTables.fixedHeader.js"></script>
<script src="<?php bloginfo('template_url'); ?>/vendor/datatables-bootstrap/dataTables.bootstrap.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/vendor/datatables-responsive/dataTables.responsive.js"></script>
<script src="<?php bloginfo('template_url'); ?>/vendor/datatables-tabletools/dataTables.tableTools.js"></script>
<script src="<?php bloginfo('template_url'); ?>/vendor/switchery/switchery.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/components/datatables.min.js"></script>

<script src="<?php bloginfo('template_url'); ?>/js/components/magnific-popup.min.js"></script>


<script src="<?php bloginfo('template_url'); ?>/assets/examples/js/tables/datatable.min.js"></script>

<?php if(is_page('account')) : ?>
       <script src="<?php bloginfo('template_url'); ?>/account-templates/js/clipboard.min.js"></script>
       <script src="<?php bloginfo('template_url'); ?>/account-templates/js/account.js"></script>
<?php endif; ?>

<?php if(is_singular('project')) : ?>
        <?php $quote_id = get_the_ID(); $current_user_id = current_user_id();?>
        <script src="<?php bloginfo('template_url'); ?>/project-templates/js/payments.js"></script>
        <script src="<?php bloginfo('template_url'); ?>/project-templates/js/scopes.js"></script>
        <script src="<?php bloginfo('template_url'); ?>/project-templates/js/chat_11.js"></script>
        <script src="<?php bloginfo('template_url'); ?>/project-templates/js/schedule.js"></script>
        <script src="<?php bloginfo('template_url'); ?>/project-templates/js/adjustm.js"></script>
        <script src="<?php bloginfo('template_url'); ?>/project-templates/js/save_note.js"></script>
        <script src="<?php bloginfo('template_url'); ?>/project-templates/js/save_tasks.js"></script>
        <script src="<?php bloginfo('template_url'); ?>/project-templates/js/save_proposal2.js"></script>
        <script src="<?php bloginfo('template_url'); ?>/project-templates/js/selection_select_13.js"></script>


        <script>
                LoadChat(<?php echo $quote_id; ?>);
        </script>

        <script src="<?php bloginfo('template_url'); ?>/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>


<?php endif; ?>

<?php if(is_page('all_projects') || is_page('manage_details') || is_page('project_preview')) : ?>
        <script src="<?php bloginfo('template_url'); ?>/projects-templates/js/projects.js"></script>
        <script src="<?php bloginfo('template_url'); ?>/project-templates/js/save_note.js"></script>
        <script src="<?php bloginfo('template_url'); ?>/project-templates/js/save_tasks.js"></script>
<?php endif; ?>

<?php if(is_page('payments')) : ?>
        <script src="<?php bloginfo('template_url'); ?>/invoice-templates/js/invoices.js"></script>
<?php endif; ?>

<?php if(is_page('all_contacts')) : ?>
        <script src="<?php bloginfo('template_url'); ?>/contacts-templates/js/contact15.js"></script>
<?php endif; ?>

<script src="<?php bloginfo('template_url'); ?>/vendor/bootstrap-table/bootstrap-table.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/vendor/bootstrap-table/extensions/mobile/bootstrap-table-mobile.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/assets/examples/js/tables/bootstrap.min.js"></script>

<script src="<?php bloginfo('template_url'); ?>/quote-templates-v2/js/quotev2.js"></script>
<script src="<?php bloginfo('template_url'); ?>/quote-templates-v2/js/jRedirect.js"></script>
<?php
if( $_GET['templateId'] != '' ) {
    if($_GET['templateId'] != '') { $templateId = $_GET['templateId']; }
    echo "<script>goto2step(" . $templateId . ");</script>";
}
?>

<?php if(is_page('step3') && is_user_logged_in() ) : ?>
    <?php $projectId = $_POST['projectId']; ?>
    <script>
        refreshStep3(<?php echo $projectId; ?>);
    </script>
<?php endif; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/vendor/multi-select/jquery.multi-select.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/components/bootstrap-select.min.js"></script>

<script src="<?php bloginfo('template_url'); ?>/vendor/switchery/switchery.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/components/switchery.min.js"></script>


<?php if(is_singular('project')) : ?>
    <script src="<?php bloginfo('template_url'); ?>/project-templates/main_v2/manage_v2/js/dropzone.js"></script>
    <script>
    Dropzone.options.myAwesomeDropzone = {

        acceptedFiles : "image/*,application/pdf",
        init: function () {
          this.on("addedfile", function (file) {
            $('.projectUploadsButton').hide();
          });
          this.on("complete", function (file) {
            if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
              $('.projectUploadsButton').show();
            }
            else {

            }
          });
        }
    };
    $('.projectUploadsCancel').click(function(){
        $('.projectUploadsButton').hide();
        Dropzone.forElement("#my-awesome-dropzone").removeAllFiles(true);
    });

    Dropzone.options.scheduleDropzone = {
        acceptedFiles : "image/*",
        thumbnailWidth : 100,
        thumbnailHeight : 100,
        init: function () {
          var thisClass = this.element.classList[0];
          this.on("addedfile", function (file) {
             $(thisClass + ' .scheduleUploadsButton').hide();
          });
          this.on("complete", function (file) {
            if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
              $('.' + thisClass).parent().find('.scheduleUploadsButton').show();
            }
            else {

            }
          });
        }
    };
    $('.projectUploadsCancel').click(function(){
        $('.projectUploadsButton').hide();
        Dropzone.forElement("#my-awesome-dropzone").removeAllFiles(true);
    });
    $('.scheduleUploadsCancel').click(function(){
        $(this).parent().find('.scheduleUploadsButton').hide();
        var row = $(this).attr('data-row');
        Dropzone.forElement(".scheduleDropzone_" + row).removeAllFiles(true);
    });

    </script>



    <script src="<?php bloginfo('template_url'); ?>/project-templates/main_v2/manage_v2/js/managev2.js"></script>
    <script>
        $('.selectpicker').selectpicker({
          size: 6
        });
    </script>

    <script src="<?php bloginfo('template_url'); ?>/vendor/owl-carousel/owl.carousel.min.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/vendor/slick-carousel/slick.min.js"></script>

<?php endif; ?>


<?php wp_footer(); ?>
</body>
</html>
