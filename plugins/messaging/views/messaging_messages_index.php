<?php init_head(); ?>
<?php $CI = get_instance(); if($cid):$conversation = $CI->Messaging_model->getConversationDetail(array(), $cid)?>
    <div id="open-message" data-title="<?php echo $conversation['title']?>" data-cid="<?php echo $cid?>"
         data-is-contact="<?php echo(!$conversation['is_contact'])? 'staff' : 'contact'?>"
         data-type="<?php echo $conversation['type']?>"></div>
<?php endif?>
<div id="wrapper" style="background: #ffffff">
    <div  style="" id="main-messages">
        <div class="row">
            <div class="col-md-3" id="main-messages-left">
                <div class="messages-title">
                    <i class="fa fa-commenting-o"></i>
                    <span><?php _lm('messaging_messages')?></span>
                    <a href="" data-toggle="modal" data-target="#messaging-send-modal" class="pull-right btn btn-primary"><i class="fa  fa-pencil-square-o"></i> <?php _lm('messaging_new')?></a>
                </div>

                <div class="messages-conversations-lists">
                    <a data-toggle="modal" data-target="#messaging-send-modal" style="margin-bottom: 20px" href="" class="btn btn-default btn-block"><?php _lm('messaging_start_new_conversation')?></a>
                    <?php foreach($this->Messaging_model->getConversationLists(100) as $conversation):?>
                        <a
                            onclick="return MessagingChat.openMessage('<?php echo $conversation['title']?>',
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
                </div>
            </div>
            <div class="col-md-9" id="main-messages-right">
                    <span class="messages-no-conversation-selected">
                        <i class="fa fa-commenting-o" style="font-size: 55px;display: block;margin-bottom: 15px"></i>
                        <?php _lm('messaging_select_conversation')?>
                    </span>
            </div>
        </div>
    </div>
</div>
<div id="new_version"></div>
<?php init_tail(); ?>


</body>
</html>
