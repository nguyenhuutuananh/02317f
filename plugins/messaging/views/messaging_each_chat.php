<div class="each-chat-message clearfix">
    <?php  messaging_mark_message_read($message['id'])?>
    <?php if(is_chat_message_owner($message)):?>
        <div class="chat-right">
            <?php if($message['message']):?>
                <span class="message" style="background: <?php echo get_option('messaging_chat_message_own_color')?> !important;color:<?php echo get_option('messaging_chat_message_own_font_color')?> !important"><?php echo messaging_format_message($message['message'])?></span>
            <?php endif?>
            <?php if ($message['image_path']):?>
                <a  href="" onclick="return messaging_open_photo_viewer('<?php echo base_url($message['image_path'])?>')"><img class="image" src="<?php echo base_url($message['image_path'])?>"/></a>
            <?php endif?>
            <?php if($message['file_path']):?>

                <a class="file" href="<?php echo base_url($message['file_path'])?>"><?php
                    $explode = explode('/', $message['file_path']);
                    $fileName = $explode[count($explode)-1];
                    echo $fileName;
                    ?></a>
            <?php endif?>
            <?php if($message['send_like']):?>
                <i class="fa fa-thumbs-up" style="font-size: 40px;color:lightblue"></i>
            <?php endif?>
            <div class="time">
                <?php echo messaging_format_time($message['time_created'])?>
            </div>
        </div>
    <?php else:?>
        <div class="chat-left ">

            <div class="clearfix">
                <img src="<?php echo messaging_get_chat_avatar($message)?>" style="display:inline-block;margin-right: 5px;width:25px;height:25px;border-radius:3px;float:left"/>
                <div>
                    <?php if($message['message']):?>
                        <span class="message" style="background: <?php echo get_option('messaging_chat_message_from_color')?> !important;color:<?php echo get_option('messaging_chat_message_from_font_color')?> !important;max-width:80%"><?php echo messaging_format_message($message['message'])?></span>
                    <?php endif?>
                    <?php if ($message['image_path']):?>
                        <a  href="" onclick="return messaging_open_photo_viewer('<?php echo base_url($message['image_path'])?>')"><img class="image" src="<?php echo base_url($message['image_path'])?>"/></a>
                    <?php endif?>
                    <?php if($message['file_path']):?>

                        <a class="file" href="<?php echo base_url($message['file_path'])?>"><?php
                            $explode = explode('/', $message['file_path']);
                            $fileName = $explode[count($explode)-1];
                            echo $fileName;
                            ?></a>
                    <?php endif?>
                    <?php if($message['send_like']):?>
                        <i class="fa fa-thumbs-up" style="font-size: 40px;color:lightblue"></i>
                    <?php endif?>
                </div>
            </div>
            <div class="time">
                <?php echo messaging_format_time($message['time_created'])?>
            </div>
        </div>
    <?php endif?>
</div>