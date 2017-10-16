<?php foreach($staffs as $staff):?>
    <a onclick="return MessagingChat.open('<?php echo $staff['firstname'].' '.$staff['lastname']?>', '', '<?php echo $staff['staffid']?>', 'single','<?php echo (is_staff_logged_in()) ? 'staff' : 'contact'?>')" class="media chat-user">
        <div class="media-left">

                <img class="media-object" src="<?php echo messaging_get_staff_avatar($staff)?>" >

        </div>
        <div class="media-body">
            <h6 class="media-heading clearfix">
                <span class="pull-left"><?php echo $staff['firstname'].' '.$staff['lastname']?></span>
                <span class="pull-right">
                    <span class="online-icon <?php echo (messaging_user_is_online($staff)) ? 'online-icon-active' : null?>"></span>
                </span></h6>
            <span class="info"><?php _lm('messaging_close')?></span>
        </div>
    </a>
<?php endforeach?>
