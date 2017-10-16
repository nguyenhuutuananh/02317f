<?php foreach($groups as $group):?>
    <?php $delete = ($group['user1'] == get_staff_user_id()) ? true : false;?>
    <a onclick="return MessagingChat.open('<?php echo $group['title']?>', '<?php echo $group['id']?>', '', 'group','staff', <?php echo $delete?>)" class="media chat-user">
        <div class="media-left">

            <img class="media-object" src="<?php echo base_url('plugins/messaging/group-icon.png')?>" >

        </div>
        <div class="media-body">
            <h6 class="media-heading clearfix">
                <span class="pull-left"><?php echo $group['title']?></span>
                <span class="pull-right">
                    <span class="online-icon"></span>
                </span></h6>
            <span class="info"><?php echo $group['members']?> <?php _lm('messaging_members')?></span>
        </div>
    </a>
<?php endforeach?>