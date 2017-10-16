<li class='icon'>
    <a href=''  id="messaging-icon-trigger" class="dropdown-toggle notifications-icon" data-toggle="dropdown" aria-expanded="false">
        <i class='fa fa-comments'></i>
        <span id="chat-notification-count" class="label label-warning icon-total-indicator icon-notifications" style="display:none">2</span>
    </a>
    <div class="dropdown-menu notifications animated fadeIn width300" style="width: 300px">
        <div class="message-dropdown-title clearfix">
            <div class="pull-left">
                <?php _lm("messaging_recent_conversations")?>
            </div>
            <div class="pull-right">
                <?php if(!is_client_logged_in() and is_staff_logged_in()):?>
                    <a href="" data-toggle="modal" data-target="#messaging-send-modal"><?php _lm('messaging_new_message')?></a>
                <?php endif?>
            </div>
        </div>
        <div class="messaging-dropdown-list">

        </div>
    </div>
</li>