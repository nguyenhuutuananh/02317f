<div class="message-pane-title">
    <?php echo $title?>
</div>
<div class="single-message-box" id="single-message-box" data-cid="<?php echo $cid?>">
    <a class='chat-load-more' id="chat-load-more" href='' style='display:block;padding:2px;text-align:center;font-size:15px;color:#BABABA;'><i class='fa fa-ellipsis-h'></i></a>
    <div class="messages-container">
        <?php foreach($this->Messaging_model->getMessages($cid) as $message) {
    echo $this->load->view("messaging_each_chat", array('message' => $message), true);
}?>
    </div>
    <form id="main-message-form" enctype='multipart/form-data' data-id='<?php echo $cid?>' action='' method='post'>
        <input type='hidden' name='uid' value='"+uid+"'/>
        <input type='hidden' name='cid' value='<?php echo $cid?>'/>
        <input type='hidden' name='user_type' value='<?php echo $userType?>'/>
        <textarea  placeholder='Type a message' name='message'></textarea>

        <input  id='main-message-file-file' style='position:fixed;top:-1000;visibility:hidden' type='file' name='file'/>
        <input  style='visibility:hidden;position:fixed;top:-1000' id='main-message-photo-file' type='file' name='photo'/>
        <div class='chat-form-icons'>
            <a class='message-open-file' data-ref='main-message-photo-file' href=''><i class='fa fa-picture-o'></i></a>
            <a href='' class='message-open-file' data-ref='main-message-file-file'><i class='fa fa-file-o'></i></a>
            <a class='emoticon' href=''><i class='fa fa-smile-o'></i></a>
            <a  class='like pull-right' href=''><i class='fa fa-thumbs-up'></i></a>
        </div>
    </form>
    <div class='messaging-emoticons' data-target='single-message-box'></div>
</div>