<?php foreach($contacts as $contact):?>
    <a onclick="return MessagingChat.open('<?php echo $contact['firstname'].' '.$contact['lastname']?>', '', '<?php echo $contact['id']?>', 'single','contact')" class="media chat-user">
        <div class="media-left">

            <img class="media-object" src="<?php echo messaging_get_contact_avatar($contact)?>" >

        </div>
        <div class="media-body">
            <h6 class="media-heading clearfix">
                <span class="pull-left"><?php echo $contact['firstname'].' '.$contact['lastname']?></span>
                <span class="pull-right">
                    <span class="online-icon <?php echo (messaging_user_is_online($contact)) ? 'online-icon-active' : null?>"></span>
                </span></h6>
            <span class="info"><?php echo $contact['company']?></span>
        </div>
    </a>
<?php endforeach?>