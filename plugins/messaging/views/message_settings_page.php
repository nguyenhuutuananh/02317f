<div class="row">
    <div class="col-md-6">


        <hr />

        <div class="form-group">
            <label for="default_task_priority" class="control-label"><?php _lm('messaging_who_create_group');?></label>
            <select name="settings[messaging_can_create_group]" class="selectpicker" id="" data-width="100%" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                <option value="1" <?php if(get_option('messaging_can_create_group') == 1){echo 'selected';} ?>><?php _lm('messaging_all_staff');?></option>
                <option value="2" <?php if(get_option('messaging_can_create_group') == 2){echo 'selected';} ?>><?php _lm('messaging_only_admin');?></option>
            </select>
        </div>

        <hr />
        <div class="form-group">
            <label  class="control-label">Chat Opener color</label>
            <div class="input-group mbot15 colorpicker-input colorpicker-element">
                <input type="text"  class="form-control" name="settings[messaging_chat_opener_color]" value="<?php echo get_option('messaging_chat_opener_color')?>"/>
                <span class="input-group-addon"><i></i></span>
            </div>
        </div>
        <hr />
        <div class="form-group"><label  class="control-label"><?php _lm('messaging_chat_head_color');?></label><div class="input-group mbot15 colorpicker-input colorpicker-element">
                <input type="text" value="<?php echo get_option('messaging_chat_head_color')?>" name="settings[messaging_chat_head_color]"  class="form-control">
                <span class="input-group-addon"><i></i></span>
            </div></div>
        <hr />
        <div class="form-group">
            <label  class="control-label"><?php _lm('messaging_message_own_bg_color')?></label>
            <div class="input-group mbot15 colorpicker-input colorpicker-element">
                <input type="text"  class="form-control" name="settings[messaging_chat_message_own_color]" value="<?php echo get_option('messaging_chat_message_own_color')?>"/>
                <span class="input-group-addon"><i></i></span>
            </div>
        </div>
        <div class="form-group">
            <label  class="control-label"><?php _lm('messaging_message_own_color')?></label>
            <div class="input-group mbot15 colorpicker-input colorpicker-element">
                <input type="text"  class="form-control" name="settings[messaging_chat_message_own_font_color]" value="<?php echo get_option('messaging_chat_message_own_font_color')?>"/>
                <span class="input-group-addon"><i></i></span>
            </div>
        </div>
        <hr />
        <div class="form-group">
            <label for="default_task_priority" class="control-label"><?php _lm('messaging_message_from_bg_color')?></label>
            <div class="input-group mbot15 colorpicker-input">
                <input type="text"  class="form-control" name="settings[messaging_chat_message_from_color]" value="<?php echo get_option('messaging_chat_message_from_color')?>"/>
                <span class="input-group-addon"><i></i></span>
            </div>
        </div>

        <div class="form-group">
            <label for="default_task_priority" class="control-label"><?php _lm('messaging__message_from_color')?></label>
            <div class="input-group mbot15 colorpicker-input">
                <input type="text"  class="form-control" name="settings[messaging_chat_message_from_font_color]" value="<?php echo get_option('messaging_chat_message_from_font_color')?>"/>
                <span class="input-group-addon"><i></i></span>
            </div>
        </div>
        <hr />
    </div>
</div>
