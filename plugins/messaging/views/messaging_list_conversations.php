<?php foreach($conversations as $conversation):?>
    <a
        onclick="return MessagingChat.open('<?php echo $conversation['title']?>',
         '<?php echo $conversation['id']?>', '', '<?php echo $conversation['type']?>',
         '<?php echo (!$conversation['is_contact'])? 'staff' : 'contact'?>')" class="media chat-user">
        <div class="media-left">

            <img class="media-object" src="<?php echo $conversation['avatar']?>" >

        </div>
        <div class="media-body">
            <h6 class="media-heading clearfix">
                <span class="pull-left"><?php echo $conversation['title']?></span>
               </h6>
            <span class="info">
                <?php if($conversation['message']['message']):?>
                    <?php echo messaging_format_message($conversation['message']['message'])?>
                <?php else:?>
                    <?php _lm('messaging_attachment')?>
                <?php endif?>
            </span>
        </div>
    </a>
<?php endforeach?>