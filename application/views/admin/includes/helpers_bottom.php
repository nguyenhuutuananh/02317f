   <?php include_once(APPPATH . 'views/admin/includes/modals/post_likes.php'); ?>
   <?php include_once(APPPATH . 'views/admin/includes/modals/post_comment_likes.php'); ?>

   <div id="newsfeed" class="animated fadeIn hide" <?php if($this->session->flashdata('newsfeed_auto')){echo 'data-newsfeed-auto';} ?>>
   </div>
   <!-- Task modal view START -->
   <div class="modal fade task-modal-single" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content data">

        </div>
    </div>
</div>
<!--Task modal view END-->
<!-- Lead Data Add/Edit  START-->
<div class="modal fade lead-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

        </div>
    </div>
</div>
<!--Lead Data Add/Edit END-->
<div class="modal fade timers-modal-logout" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h4 class="bold"><?php echo _l('timers_started_confirm_logout'); ?></h4>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="<?php echo site_url('authentication/logout'); ?>" class="btn btn-danger"><?php echo _l('confirm_logout'); ?></a>
            </div>
        </div>
    </div>
</div>
<!--Tracking stats chart for task END-->
<div id="tacking-stats"></div>
<!--Tracking stats chart for task END-->
<!--Add/edit task modal start-->
<div id="_task"></div>
<!--Add/edit task modal end-->
<!--Lead convert to customer modal start-->
<div id="lead_convert_to_customer"></div>
<!--Lead convert to customer modal end-->
<!--Lead convert to customer modal start-->
<div id="lead_reminder_modal"></div>
<!--Lead convert to customer modal end-->
