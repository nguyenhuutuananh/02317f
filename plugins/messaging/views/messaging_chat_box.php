<?php $CI = &get_instance()?>
<div class="chat-list-opener">
    <a id="chat-list-opener-btn" style="background: <?php echo get_option('messaging_chat_opener_color')?>" href="" onclick="return messaging_show_chat_list(this)"><i class="fa fa-comments"></i></a>
    <span class="count chat-online-count" >0</span>
</div>

<div id="chat-list-container" class="animated slideInRight">
    <div class="chat-list-head" style="<?php echo (is_client_logged_in())? 'height:91px' : ''?> ">
        <h3> <?php _lm('messaging_chat')?> <span class="chat-online-count label label-success" style="position: relative;border: solid 1px green;color:green;font-weight:bold;background:none;top:0px;margin-left:10px">0</span></h3>
        <a href="" onclick="return close_messaging_chat_list()"><i class="fa fa-times"></i></a>
    </div>
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#chat-list-staff" aria-controls="general" role="tab" data-toggle="tab"><?php $CI = &get_instance(); echo $CI->lang->line("messaging_staffs")?></a>
        </li>
       <?php if(is_staff_logged_in()):?>
           <li role="presentation">
               <a href="#chat-list-contacts" aria-controls="invoice" role="tab" data-toggle="tab"><?php echo $CI->lang->line("messaging_contacts")?></a>
           </li>
           <li role="presentation">
               <a href="#chat-list-groups" aria-controls="invoice" role="tab" data-toggle="tab"><?php echo $CI->lang->line("messaging_groups")?></a>
           </li>
        <?php endif?>
    </ul>

    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active chat-list-pane" id="chat-list-staff">
            <span class="chat-no-list">No staffs found</span>
        </div>
        <div role="tabpanel" class="tab-pane  chat-list-pane" id="chat-list-contacts">
            <span class="chat-no-list">No contacts found</span>
        </div>
        <div role="tabpanel" class="tab-pane  " id="chat-list-groups">
            <div class="chat-list-pane">
                <?php if (messaging_can_create_group()):?>
                    <a href="" class="btn btn-sm btn-block btn-secondary" onclick="return messaging_toggle('#new-chat-group-form')"><?php echo $CI->lang->line("messaging_add_new_group")?></a>
                    <form action="" method="post" style="padding: 10px;display:none" id="new-chat-group-form">
                        <label class="control-label"><?php _lm("messaging_group_title")?></label>
                        <input type="text" name="title" class="form-control"/>
                        <?php echo render_select('staffs[]',$CI->staff_model->get('', 1),array('staffid',array('firstname','lastname')),$CI->lang->line("messaging_staffs"),array(),array('multiple'=>true));?>

                        <button class="btn btn-primary btn-sm"><?php _lm("messaging_add")?></button>
                    </form>
                <?php endif?>
                <div id="group-chat-list">
                    <span class="chat-no-list">No groups found</span>
                </div>
            </div>

        </div>
    </div>
</div>



<div id="messaging-group-addstaff-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php _lm('messaging_add_staff')?></h4>
            </div>
            <form id="messaging-add-staff-form" action="" method="post">
                <input type="hidden" value="" class='cid' name="cid"/>
                <div class="modal-body">
                    <?php echo render_select('staffs[]',$CI->staff_model->get('', 1),array('staffid',array('firstname','lastname')),$CI->lang->line("messaging_staffs"),array(),array('multiple'=>true));?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php _lm('messaging_close')?></button>
                    <button type="submit" class="btn btn-primary"><?php _lm('messaging_save')?></button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php if(!is_client_logged_in() and is_staff_logged_in()):?>
<div id="messaging-send-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog " >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php _lm('messaging_new_message')?></h4>
            </div>
            <form id="new-message-form" action="" method="post">

                <div class="modal-body">
                    <div class="form-group">
                        <label><?php _lm('messaging_to')?></label>
                        <select name="to" class="form-control">
                            <optgroup label="<?php _lm('messaging_staff')?>">
                                <?php foreach($CI->Messaging_model->getStaffs() as $staff):?>
                                    <option value="staff_<?php echo $staff['staffid']?>"><?php echo $staff['firstname'].' '.$staff['lastname']?></option>
                                <?php endforeach?>
                            </optgroup>
                            <optgroup label="<?php _lm('messaging_contact')?>">
                                <?php foreach($CI->Messaging_model->getContacts() as $staff):?>
                                    <option value="contact_<?php echo $staff['id']?>"><?php echo $staff['firstname'].' '.$staff['lastname']?></option>
                                <?php endforeach?>
                            </optgroup>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><?php _lm('messaging_message_content')?></label>
                        <textarea class="form-control" style="height:200px" name="message"></textarea>
                    </div>

                    <div class="form-group">
                        <label><?php _lm('messaging_attach_photo')?></label>
                        <input type="file" name="photo"/>
                    </div>

                    <div class="form-group">
                        <label><?php _lm('messaging_attach_file')?></label>
                        <input type="file" name="photo"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php _lm('messaging_close')?></button>
                    <button type="submit" class="btn btn-primary"><?php _lm('messaging_send')?></button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php endif?>

<div id="messaging-photo-viewer">
    <a href="" onclick="return messaging_close_photo_viewer()" class="close-btn"><i class="fa fa-times"></i></a>
    <div class="photo-viewer-content">
        <img src=""/>
    </div>
</div>

<audio id="messaging-sound" preload="auto">
    <source src="<?php echo base_url('plugins/messaging/sounds/notification.ogg')?>" type="audio/ogg">
    <source src="<?php echo base_url('plugins/messaging/sounds/notification.mp3')?>" type="audio/mpeg">
    <source src="<?php echo base_url('plugins/messaging/sounds/notification.wav')?>" type="audio/wav">
</audio>
<script>
    var chatHeadColor = '<?php echo get_option('messaging_chat_head_color')?>';
    var chatOwnColor = '';
    var chatOwnFontColor = '';
    var chatFromColor= '<?php echo get_option('messaging_chat_message_from_color')?>';
    var chatFromFontColor= '<?php echo get_option('messaging_chat_message_from_font_color')?>';
    var messagesStr = '<?php _lm('messaging_messages')?>';
    var message_settings_str = '<?php _lm('messaging_message_settings')?>';
    var type_a_message_str = '<?php _lm('messaging_type_message')?>';

</script>